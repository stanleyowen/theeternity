#!/usr/bin/env python3
"""
End-to-end smoke tests for Eternity Esports (stdlib only).

    python3 tests/smoke_test.py archive http://localhost:8080
    python3 tests/smoke_test.py live    http://localhost:8081

archive: every page renders, demo sessions work, every write is refused.
live:    real register/login, scrim flow, uploads, admin CRUD, and attack
         payloads (XSS, SQLi, CSRF, javascript: links, forged roles, uploads).
The live suite expects an admin created with:  bin/create-admin.php "Smoke Admin"
using the password in SMOKE_ADMIN_PASSWORD (default below).
"""
import http.cookiejar
import io
import os
import re
import sys
import urllib.error
import urllib.parse
import urllib.request
import uuid

BASE = sys.argv[2].rstrip("/") if len(sys.argv) > 2 else "http://localhost:8080"
ADMIN_PASSWORD = os.environ.get("SMOKE_ADMIN_PASSWORD", "smoke-admin-password-123")
FAILURES = []
PASSES = 0

PUBLIC_PAGES = [
    "/", "/en-us/index.php", "/en-us/event.php", "/en-us/gallery.php", "/en-us/contact-us.php",
    "/en-us/login/index.php", "/en-us/login/register.php", "/en-us/event/release-notes.php",
    "/en-us/event/terms-and-conditions-scrim.php", "/en-us/event/event-view.php?encryption=20200915",
    "/id/index.php", "/id/event.php", "/id/gallery.php", "/id/contact-us.php", "/id/login/index.php",
    "/id/login/register.php", "/id/event/release-notes.php", "/id/event/terms-and-conditions-scrim.php",
    "/id/event/event-view.php?encryption=20200915",
]
PLAYER_PAGES = [f"/{lang}/dashboard/{p}" for lang in ("en-us", "id") for p in (
    "index.php", "participate-scrim.php", "join-group.php", "upload-center.php", "attendance.php",
    "submit-result.php", "certificate.php", "support.php")]
ADMIN_PAGES = [f"/en-us/dashboard/admin/{p}" for p in (
    "dashboard-admin.php", "scrim-info.php", "edit-scrim-info.php?id=1", "edit-alert.php", "edit-alert-id.php?id=1",
    "edit-gallery.php", "message.php", "edit-user.php", "edit-event.php", "edit-event-id.php?id=1",
    "user-upload.php", "view-upload.php?username=Demo+Squad", "present-participant.php", "scrim-result.php",
    "edit-player-result.php?username=Demo+Squad", "edit-player-result-2.php?username=Demo+Squad",
    "create-certificate-list.php", "edit-certificate-link.php?id=1")]
BLOCKED = ["/app/config.php", "/app/bootstrap.php", "/storage/database/eternity.sqlite", "/database/schema.sqlite.sql",
           "/database/seed.php", "/bin/init-db.php", "/.env", "/.git/config", "/docker/entrypoint.sh", "/storage/.app_key"]
PHP_NOISE = re.compile(r"(<b>)?(Warning|Notice|Deprecated|Fatal error|Parse error)(</b>)?:|Stack trace|Uncaught", re.I)

def make_png(width=8, height=8):
    """Build a valid RGB PNG in memory (zlib + CRC'd chunks)."""
    import struct, zlib
    def chunk(kind, data):
        return struct.pack(">I", len(data)) + kind + data + struct.pack(">I", zlib.crc32(kind + data) & 0xFFFFFFFF)
    raw = b"".join(b"\x00" + b"\xdc\x14\x3c" * width for _ in range(height))
    return (b"\x89PNG\r\n\x1a\n" + chunk(b"IHDR", struct.pack(">IIBBBBB", width, height, 8, 2, 0, 0, 0))
            + chunk(b"IDAT", zlib.compress(raw)) + chunk(b"IEND", b""))


PNG = make_png()


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *args, **kwargs):
        return None


class Client:
    def __init__(self):
        self.jar = http.cookiejar.CookieJar()
        self.follow = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(self.jar))
        self.nofollow = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(self.jar), NoRedirect)

    def request(self, path, data=None, headers=None, follow=True, files=None):
        url = path if path.startswith("http") else BASE + path
        headers = dict(headers or {})
        body = None
        if files:
            boundary = uuid.uuid4().hex
            buf = io.BytesIO()
            for k, v in (data or {}).items():
                buf.write(f'--{boundary}\r\nContent-Disposition: form-data; name="{k}"\r\n\r\n{v}\r\n'.encode())
            for k, (fname, content, ctype) in files.items():
                buf.write(f'--{boundary}\r\nContent-Disposition: form-data; name="{k}"; filename="{fname}"\r\n'
                          f'Content-Type: {ctype}\r\n\r\n'.encode() + content + b"\r\n")
            buf.write(f"--{boundary}--\r\n".encode())
            body = buf.getvalue()
            headers["Content-Type"] = f"multipart/form-data; boundary={boundary}"
        elif data is not None:
            body = urllib.parse.urlencode(data).encode()
        req = urllib.request.Request(url, data=body, headers=headers)
        opener = self.follow if follow else self.nofollow
        try:
            resp = opener.open(req, timeout=20)
            return resp.status, resp.read().decode("utf-8", "replace"), resp.headers, resp.geturl()
        except urllib.error.HTTPError as e:
            return e.code, e.read().decode("utf-8", "replace"), e.headers, url

    def get(self, path, **kw):
        return self.request(path, **kw)

    def csrf(self, path="/en-us/login/index.php"):
        _, html, _, _ = self.get(path)
        m = re.search(r'name="_csrf" value="([0-9a-f]{64})"', html)
        assert m, f"no CSRF token on {path}"
        return m.group(1)

    def post(self, path, data, referer=None, **kw):
        headers = {"Referer": BASE + referer} if referer else {}
        return self.request(path, data=data, headers=headers, **kw)


def check(name, cond, detail=""):
    global PASSES
    if cond:
        PASSES += 1
    else:
        FAILURES.append(f"{name} {detail}".strip())
        print(f"  FAIL {name} {detail}")


def flash_of(html):
    m = re.search(r'data-flash="([^"]*)"', html)
    return urllib.parse.unquote(m.group(1)).replace("&quot;", '"').replace("&#039;", "'") if m else ""


def page_ok(client, path, label):
    status, html, _, final = client.get(path)
    check(f"{label} {path} -> 200", status == 200, f"(got {status}, ended at {final})")
    noise = PHP_NOISE.search(html)
    check(f"{label} {path} has no PHP errors", noise is None, f"({noise.group(0) if noise else ''})")
    return html


def common_checks():
    print("* public pages, headers, blocked paths")
    anon = Client()
    for p in PUBLIC_PAGES:
        page_ok(anon, p, "public")
    status, _, headers, _ = anon.get("/en-us/index.php")
    csp = headers.get("Content-Security-Policy", "")
    check("CSP present", "script-src 'self'" in csp and "frame-ancestors 'none'" in csp, csp)
    check("nosniff", headers.get("X-Content-Type-Options") == "nosniff")
    check("no X-Powered-By", headers.get("X-Powered-By") is None)
    cookie = Client().get("/en-us/event.php")[2].get("Set-Cookie", "")
    check("session cookie HttpOnly+SameSite", "HttpOnly" in cookie and "SameSite=Lax" in cookie, cookie)
    for p in BLOCKED:
        status, _, _, _ = anon.get(p)
        check(f"blocked {p}", status in (403, 404), f"(got {status})")
    status, html, _, _ = anon.get("/does-not-exist")
    check("404 page", status == 404 and "Page not found" in html, f"(got {status})")
    for p in PLAYER_PAGES[:2] + ADMIN_PAGES[:2]:
        status, _, headers, _ = anon.get(p, follow=False)
        check(f"anonymous {p} redirects to login", status in (302, 303) and "login" in headers.get("Location", ""), f"({status})")
    status, _, _, _ = anon.get("/function/delete-user.php?id=1")
    check("GET on handler is 405", status == 405, f"(got {status})")
    status, _, _, _ = anon.get("/media.php?b=logo-squad&f=" + "a" * 32 + ".jpg")
    check("private media needs admin", status == 403, f"(got {status})")
    status, _, _, _ = anon.get("/media.php?b=gallery&f=../../app/config.php")
    check("media path traversal rejected", status == 404, f"(got {status})")


def archive_suite():
    common_checks()
    print("* archive: demo sessions + read-only")
    anon = Client()
    html = anon.get("/en-us/login/index.php")[1]
    check("demo panel on login", "View as Player" in html and "View as Administrator" in html)
    check("no role select on login", "validation_role" not in html)
    check("archive notice", "This website is archived" in html)

    player = Client()
    token = player.csrf()
    status, _, headers, _ = player.post("/global-validation/demo-login.php", {"_csrf": token, "as": "user", "lang": "en"}, follow=False)
    check("demo player login", status == 303 and "/en-us/dashboard/index.php" in headers.get("Location", ""), f"({status} {headers.get('Location')})")
    for p in PLAYER_PAGES:
        page_ok(player, p, "player")
    status, _, _, _ = player.get("/en-us/dashboard/admin/edit-user.php")
    check("player cannot open admin page", status == 403, f"(got {status})")

    admin = Client()
    token = admin.csrf()
    admin.post("/global-validation/demo-login.php", {"_csrf": token, "as": "admin", "lang": "en"})
    for p in ADMIN_PAGES:
        page_ok(admin, p, "admin")
    html = admin.get("/en-us/dashboard/admin/message.php")[1]
    check("messages decrypted for admin", "player@example.com" in html)
    html = admin.get("/en-us/dashboard/admin/edit-user.php")[1]
    check("no password hashes shown", "$2y$" not in html and "Password</th>" not in html)

    token = admin.csrf("/en-us/dashboard/admin/edit-alert.php")
    before = admin.get("/en-us/dashboard/admin/edit-user.php")[1].count("<tr>")
    for handler, data in [
        ("/function/delete-user.php", {"id": "2"}),
        ("/function/delete-scrim-participant-ALL.php", {"code": "CONFIRM"}),
        ("/function/delete-message-ALL.php", {"code": "CONFIRM"}),
        ("/function/add-alert-info.php", {"link": "https://example.com", "description": "x", "alert_type": "success"}),
        ("/global-validation/../function/add-user.php", {"username": "hacker", "password": "password123", "confirmpassword": "password123", "role": "admin"}),
    ]:
        status, html, _, _ = admin.post(handler, {"_csrf": token, **data}, referer="/en-us/dashboard/admin/edit-alert.php")
        check(f"archive refuses {handler}", "archived (read-only)" in flash_of(html), f"(status {status})")
    after = admin.get("/en-us/dashboard/admin/edit-user.php")[1].count("<tr>")
    check("users unchanged in archive", before == after, f"({before} -> {after})")
    status, html, _, _ = anon.post("/en-us/login/index.php", {"_csrf": anon.csrf(), "_username": "x", "_password": "y", "login_user": "1"})
    check("real login refused in archive", "archived" in flash_of(html))


def live_suite():
    common_checks()
    print("* live: registration, login, attacks")
    anon = Client()
    html = anon.get("/en-us/login/index.php")[1]
    check("no demo panel in live mode", "View as Player" not in html)

    # CSRF: missing token is rejected.
    status, html, _, _ = anon.post("/en-us/login/register.php", {"_username": "nocsrf", "_password": "password123", "_confirmpassword": "password123", "reg_user": "1"})
    check("register without CSRF refused", "expired" in flash_of(html) or "tampered" in flash_of(html), flash_of(html))

    squad = f"Squad {uuid.uuid4().hex[:6]}"
    player = Client()
    token = player.csrf("/en-us/login/register.php")
    status, html, _, url = player.post("/en-us/login/register.php", {"_csrf": token, "_username": squad, "_password": "correct horse battery", "_confirmpassword": "correct horse battery", "reg_user": "1", "honeypot": ""})
    check("register -> dashboard", "/en-us/dashboard/index.php" in url and squad in html, f"({url})")
    check("no credential cookies", not any(c.name.startswith("sessionid") for c in player.jar))

    # Forged role: the old login accepted validation_role=admin.
    attacker = Client()
    token = attacker.csrf()
    _, html, _, url = attacker.post("/en-us/login/index.php", {"_csrf": token, "_username": squad, "_password": "correct horse battery", "validation_role": "admin", "login_user": "1"})
    check("forged role ignored", "/en-us/dashboard/index.php" in url and "admin" not in url, url)
    check("player blocked from admin page", attacker.get("/en-us/dashboard/admin/edit-user.php")[0] == 403)

    # SQL injection attempt on login.
    sqli = Client()
    token = sqli.csrf()
    _, html, _, url = sqli.post("/en-us/login/index.php", {"_csrf": token, "_username": "' OR '1'='1' -- ", "_password": "' OR '1'='1", "login_user": "1"})
    check("SQLi login fails", "/login/" in url and "match our credentials" in html, url)

    # Brute force throttling.
    bf = Client()
    for _ in range(6):
        token = bf.csrf()
        _, html, _, _ = bf.post("/en-us/login/index.php", {"_csrf": token, "_username": squad, "_password": "wrong", "login_user": "1"})
    check("login throttled", "Too many failed login attempts" in html)

    print("* live: scrim flow")
    token = player.csrf("/en-us/dashboard/participate-scrim.php")
    _, html, _, url = player.post("/function/participate-in-scrim.php", {"_csrf": token, "event_id": "1", "term1": "1", "term2": "1"}, referer="/en-us/dashboard/participate-scrim.php")
    check("participate", "Successfully Participated" in flash_of(html), flash_of(html))
    for p in PLAYER_PAGES[:8]:
        page_ok(player, p, "player")

    token = player.csrf("/en-us/dashboard/attendance.php")
    _, html, _, _ = player.post("/function/attendance-user.php", {"_csrf": token, "id": "1", "token": "wrong"}, referer="/en-us/dashboard/attendance.php")
    check("attendance wrong token", "Mismatch" in flash_of(html) or "mismatch" in flash_of(html), flash_of(html))
    _, html, _, _ = player.post("/function/attendance-user.php", {"_csrf": token, "id": "1", "token": "ETR2020"}, referer="/en-us/dashboard/attendance.php")
    check("attendance ok", "successfully" in flash_of(html), flash_of(html))
    _, html, _, _ = player.post("/function/attendance-user.php", {"_csrf": token, "id": "1", "token": "ETR2020"}, referer="/en-us/dashboard/attendance.php")
    check("attendance once", "2 times" in flash_of(html), flash_of(html))

    token = player.csrf("/en-us/dashboard/submit-result.php")
    _, html, _, _ = player.post("/function/submit-result.php", {"_csrf": token, "id": "1", "rank": "3", "kill": "9", "honeypot": ""}, referer="/en-us/dashboard/submit-result.php")
    check("result submitted", "Result Submitted" in flash_of(html), flash_of(html))
    _, html, _, _ = player.post("/function/submit-result.php", {"_csrf": token, "id": "1", "rank": "1", "kill": "99", "honeypot": ""}, referer="/en-us/dashboard/submit-result.php")
    check("result only once", "ONCE" in flash_of(html), flash_of(html))
    _, html, _, _ = player.post("/function/submit-result-2.php", {"_csrf": token, "id": "1", "rank": "1; DROP TABLE users", "kill": "5", "honeypot": ""}, referer="/en-us/dashboard/submit-result.php")
    check("non-numeric result rejected", "Result Submitted" not in flash_of(html), flash_of(html))

    print("* live: uploads")
    token = player.csrf("/en-us/dashboard/upload-center.php")
    ref = "/en-us/dashboard/upload-center.php"
    _, html, _, _ = player.request("/function/upload-squad-picture.php", data={"_csrf": token, "submit": "1"},
                                   files={"file": ("shell.php.png", b"<?php system($_GET['c']); ?>", "image/png")}, headers={"Referer": BASE + ref})
    check("php disguised as png rejected", "Only photo" in flash_of(html) or "could not be read" in flash_of(html), flash_of(html))
    _, html, _, _ = player.request("/function/upload-squad-picture.php", data={"_csrf": token, "submit": "1"},
                                   files={"file": ("../../evil.png", PNG, "image/png")}, headers={"Referer": BASE + ref})
    check("valid png accepted", "Uploaded Successfully" in flash_of(html), flash_of(html))
    _, html, _, _ = player.request("/function/upload-squad-picture.php", data={"_csrf": token, "submit": "1"},
                                   files={"file": ("again.png", PNG, "image/png")}, headers={"Referer": BASE + ref})
    check("upload only once", "ONCE" in flash_of(html), flash_of(html))
    html = player.get(ref)[1]
    check("stored name is random", re.search(r"[0-9a-f]{32}\.png", html) is not None and "evil" not in html)

    print("* live: admin console")
    admin = Client()
    token = admin.csrf()
    _, html, _, url = admin.post("/en-us/login/index.php", {"_csrf": token, "_username": "Smoke Admin", "_password": ADMIN_PASSWORD, "login_user": "1"})
    check("admin login", "dashboard-admin.php" in url, url)
    for p in ADMIN_PAGES:
        page_ok(admin, p, "admin")

    ref = "/en-us/dashboard/admin/edit-alert.php"
    token = admin.csrf(ref)
    xss = '<script>alert(1)</script><img src=x onerror=alert(2)>'
    _, html, _, _ = admin.post("/function/add-alert-info.php", {"_csrf": token, "link": "javascript:alert(1)", "description": "bad", "alert_type": "success"}, referer=ref)
    check("javascript: link rejected", "Successfully" not in flash_of(html), flash_of(html))
    _, html, _, _ = admin.post("/function/add-alert-info.php", {"_csrf": token, "link": "https://example.com/x", "description": xss, "alert_type": 'success" onmouseover="x'}, referer=ref)
    check("bad alert type rejected", "Successfully" not in flash_of(html), flash_of(html))
    _, html, _, _ = admin.post("/function/add-alert-info.php", {"_csrf": token, "link": "https://example.com/x", "description": xss, "alert_type": "danger"}, referer=ref)
    check("alert added", "Successfully" in flash_of(html), flash_of(html))
    home = anon.get("/en-us/index.php")[1]
    check("stored XSS escaped on public page", "<script>alert(1)</script>" not in home and "&lt;script&gt;alert(1)&lt;/script&gt;" in home)

    ref = "/en-us/dashboard/admin/scrim-info.php"
    token = admin.csrf(ref)
    _, html, _, _ = admin.post("/function/add-scrim-info.php", {"_csrf": token, "header": "Live <b>test</b>", "code": "", "description": "line1\nline2 <script>x</script>"}, referer=ref)
    check("post added", "Successfully" in flash_of(html), flash_of(html))
    events = anon.get("/en-us/event.php")[1]
    check("post escaped + line breaks", "Live &lt;b&gt;test&lt;/b&gt;" in events and "line1<br>" in events and "<script>x</script>" not in events)

    ref = "/en-us/dashboard/admin/edit-user.php"
    token = admin.csrf(ref)
    _, html, _, _ = admin.post("/function/add-user.php", {"_csrf": token, "username": "Created By Admin", "role": "user", "password": "password-123", "confirmpassword": "password-123"}, referer=ref)
    check("admin adds user", "Successfully" in flash_of(html), flash_of(html))

    ref = "/en-us/dashboard/admin/user-upload.php"
    html = admin.get(ref)[1]
    check("participant listed", squad in html)
    view = admin.get("/en-us/dashboard/admin/view-upload.php?" + urllib.parse.urlencode({"username": squad}))[1]
    m = re.search(r'src="(/media\.php\?b=logo-squad&amp;f=[0-9a-f]{32}\.png)"', view)
    check("admin sees upload via media.php", m is not None)
    if m:
        status, _, headers, _ = admin.get(m.group(1).replace("&amp;", "&"))
        check("admin media 200 image/png", status == 200 and headers.get("Content-Type") == "image/png", f"({status} {headers.get('Content-Type')})")
        check("player cannot fetch private media", player.get(m.group(1).replace("&amp;", "&"))[0] == 403)

    ref = "/en-us/dashboard/admin/scrim-result.php"
    token = admin.csrf(ref)
    _, html, _, _ = admin.post("/function/delete-result.php", {"_csrf": token, "username": squad, "match": "1"}, referer=ref)
    check("delete-result clears match 1", "Deleted" in flash_of(html) or "Success" in flash_of(html), flash_of(html))
    html = admin.get("/en-us/dashboard/admin/user-upload.php")[1]
    check("participant kept after result delete", squad in html)

    _, html, _, _ = admin.post("/function/delete-scrim-participant-ALL.php", {"_csrf": token, "code": "nope"}, referer=ref)
    check("delete-all needs CONFIRM", "Mismatch" in flash_of(html), flash_of(html))

    # Cross-site request: valid session but no token.
    status, html, _, _ = admin.post("/function/delete-alert-id.php", {"id": "1"}, referer=ref)
    check("CSRF blocks admin delete", "expired" in flash_of(html) or "tampered" in flash_of(html), flash_of(html))

    # Logout requires the token too.
    admin.get("/global-validation/logout.php")
    check("logout without token keeps session", admin.get("/en-us/dashboard/admin/edit-user.php")[0] == 200)


if __name__ == "__main__":
    mode = sys.argv[1] if len(sys.argv) > 1 else "archive"
    (archive_suite if mode == "archive" else live_suite)()
    print(f"\n{PASSES} passed, {len(FAILURES)} failed")
    sys.exit(1 if FAILURES else 0)
