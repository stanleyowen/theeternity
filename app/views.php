<?php
declare(strict_types=1);

/**
 * Shared layout partials. The markup below is the 2020 markup, moved into one
 * place (it used to be copy-pasted into ~50 files) with every dynamic value
 * escaped and every inline script removed (so a strict CSP can be enforced).
 */

const ASSET_VERSION = '2026.11';

/* ---- URLs ---------------------------------------------------------------- */

/** Web path of the application root (supports deployment in a sub-directory). */
function base_path(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }
    $doc  = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? '')) ?: '';
    $root = realpath(APP_ROOT) ?: APP_ROOT;
    $base = ($doc !== '' && str_starts_with($root, $doc))
        ? rtrim(str_replace(DIRECTORY_SEPARATOR, '/', substr($root, strlen($doc))), '/')
        : '';
    return $base;
}

function url(string $path = ''): string
{
    return base_path() . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/')) . '?v=' . ASSET_VERSION;
}

function lang_url(string $page, ?string $lang = null): string
{
    return url(lang_dir($lang ?? current_lang()) . '/' . ltrim($page, '/'));
}

function logout_url(): string
{
    if (Config::staticExport()) {
        return lang_url('index.php'); // a static site has no session to end
    }
    return url('global-validation/logout.php') . '?_csrf=' . rawurlencode(csrf_token());
}

/**
 * Attributes for <body>: pending flash messages (app.js shows them with alert(),
 * like the original) and, in a static export, the message shown when a form is submitted.
 */
function body_attrs(): string
{
    $attrs = '';
    if (Config::staticExport()) {
        $attrs .= ' data-static-archive="' . e(t('archive_write')) . '"';
    }
    $messages = take_flash();
    if ($messages !== []) {
        $attrs .= ' data-flash="' . e(json_encode(array_values($messages), JSON_UNESCAPED_UNICODE)) . '"';
    }
    return $attrs;
}

/* ---- Small components ---------------------------------------------------- */

/**
 * A state-changing button rendered as a tiny POST form (deletes used to be
 * GET links, which any page on the internet could trigger via <img src>).
 */
function action_button(string $action, array $fields, string $label, ?string $confirm = null): string
{
    $html = '<form class="inline-form" method="post" action="' . e(url('function/' . $action)) . '"'
        . ($confirm !== null ? ' data-confirm="' . e($confirm) . '"' : '') . '>' . csrf_field();
    foreach ($fields as $name => $value) {
        $html .= '<input type="hidden" name="' . e($name) . '" value="' . e($value) . '">';
    }
    return $html . '<button class="btn first" type="submit">' . e($label) . '</button></form>';
}

function external_link(?string $href, ?string $text = null): string
{
    $safe = safe_url($href);
    return '<a href="' . e($safe) . '" target="_blank" rel="noopener noreferrer">' . e($text ?? $href) . '</a>';
}

/* ---- Public site (Bootstrap 4 theme) ------------------------------------- */

/**
 * @param array{description?:string, meta_title?:string, css?:string[], topbar?:bool, lang_links?:array{en:string,id:string}} $opts
 */
function public_header(string $title, array $opts = []): void
{
    $lang = current_lang();
    $css  = $opts['css'] ?? [];
    ?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Eternity Esports | <?= e($title) ?></title>
<?php if (!empty($opts['meta_title'])): ?>
  <meta name="title" content="<?= e($opts['meta_title']) ?>">
<?php endif; ?>
<?php if (!empty($opts['description'])): ?>
  <meta name="description" content="<?= e($opts['description']) ?>">
<?php endif; ?>
  <link rel="icon" href="<?= e(asset('img/etr-img-1.jpeg')) ?>">
<?php if (in_array('dashboard-style.css', $css, true)): ?>
  <link rel="stylesheet" href="<?= e(asset('css/dashboard-style.css')) ?>">
<?php endif; ?>
  <link rel="stylesheet" href="<?= e(asset('vendor/font-awesome/css/font-awesome.min.css')) ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
  <link rel="stylesheet" href="<?= e(asset('vendor/bootstrap/css/bootstrap.min.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('css/button.css')) ?>">
<?php if (in_array('style-login.css', $css, true)): ?>
  <link rel="stylesheet" href="<?= e(asset('css/style-login.css')) ?>">
<?php endif; ?>
</head>

<body<?= body_attrs() ?>>
<?php if (($opts['topbar'] ?? true) === true):
        $links = $opts['lang_links'] ?? ['en' => 'index.php', 'id' => 'index.php']; ?>
  <footer class="footer text-faded text-center py-3 fixed-top">
    <div class="container">
      <p class="m-0 large" align="left">Eternity Esports<?php if (Config::archiveMode()): ?> <span class="archive-tag"><?= e(t('archive_label')) ?></span><?php endif; ?></p>
      <p class="m-0 large" align="right"><?= e(t('languages')) ?> <i class="fa fa-globe" aria-hidden="true"></i> : <a href="<?= e(lang_url($links['en'], 'en')) ?>">EN</a> | <a href="<?= e(lang_url($links['id'], 'id')) ?>">ID</a></p>
    </div>
  </footer>
  <br><br><br><br>
<?php endif;
    public_alerts();
}

/** Site-wide alert bars managed by admins, plus the permanent archive notice. */
function public_alerts(): void
{
    if (Config::archiveMode()): ?>
  <div class="alert alert-warning archive-alert" role="status">
    <i class="fa fa-archive" aria-hidden="true"></i> <?= e(t('archive_alert')) ?>
    <a href="<?= e(lang_url('event/release-notes.php')) ?>#archive-edition"><?= e(t('archive_link')) ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
  </div>
<?php endif;
    foreach (db_all('SELECT description, link, type FROM alerts_info ORDER BY id') as $row):
        $type = in_array($row['type'], ['success', 'warning', 'danger'], true) ? $row['type'] : 'warning'; ?>
  <div class="alert alert-<?= e($type) ?>">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?= e($row['description']) ?>
    <a href="<?= e(safe_url($row['link'])) ?>" rel="noopener noreferrer"><?= e(t('click_here')) ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
  </div>
<?php endforeach;
}

/**
 * Main navigation. $active is one of: home, event, gallery, contact, login, register.
 * $authMenu=false reproduces the login/register pages, which always showed Login/Register.
 */
function public_nav(string $active, bool $authMenu = true): void
{
    $items = [
        'home'    => ['index.php', t('home')],
        'event'   => ['event.php', t('event')],
        'gallery' => ['gallery.php', t('gallery')],
        'contact' => ['contact-us.php', t('contact')],
    ];
    $user = $authMenu ? current_user() : null;
    $tail = [];
    if ($user !== null) {
        $tail[] = [url(dashboard_path($user, current_lang())), t('dashboard'), false];
        $tail[] = [logout_url(), t('logout'), false];
    } else {
        $tail[] = [lang_url('login/index.php'), t('login'), $active === 'login'];
        $tail[] = [lang_url('login/register.php'), t('register'), $active === 'register'];
    }
    ?>
  <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
      <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#"><?= e(t('menus')) ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mx-auto">
<?php foreach ($items as $key => [$page, $label]): ?>
          <li class="nav-item<?= $key === $active ? ' active' : '' ?> px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="<?= e(lang_url($page)) ?>"><?= e($label) ?><?php if ($key === $active): ?> <span class="sr-only">(current)</span><?php endif; ?></a>
          </li>
<?php endforeach; ?>
<?php foreach ($tail as [$href, $label, $isActive]): ?>
          <li class="nav-item<?= $isActive ? ' active' : '' ?> px-lg-4"><a class="nav-link text-uppercase text-expanded" href="<?= e($href) ?>"><?= e($label) ?><?php if ($isActive): ?> <span class="sr-only">(current)</span><?php endif; ?></a></li>
<?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
<?php
}

/** Copyright bar, floating contact buttons and scripts. $variant 'login' reproduces the slimmer login footer. */
function public_footer(string $variant = 'default'): void
{
    $copyright = e(t('copyright')) . ' &copy; 2020 Eternity Esports | ' . e(t('designed_by'))
        . ' <a href="https://github.com/stanleyowen" target="_blank" rel="noopener noreferrer">Stanley Owen</a>';
    if ($variant === 'login'): ?>
  <footer class="footer text-faded text-center py-0 fixed-bottom">
    <div class="container-footer">
      <p class="m-0 small"><?= $copyright ?></p>
    </div>
  </footer>
<?php else: ?>
  <footer class="footer text-faded text-center py-3 fixed-bottom">
    <div class="container">
      <p class="m-0 small"><?= $copyright ?></p>
    </div>
  </footer>
<?php endif; ?>

  <div class="button" title="<?= e(t('contact_title')) ?>">
    <a href="https://wa.me/message/SGOS5RUB46CUA1" class="hvr-float-shadow" target="_blank" rel="noopener noreferrer">
      <img src="<?= e(asset('img/whatsapp-logo.png')) ?>" width="60" alt="WhatsApp">
    </a>
  </div>
  <div class="button1" title="<?= e(t('follow_title')) ?>">
    <a href="https://instagram.com/eternity_esports.id" class="hvr-float-shadow1" target="_blank" rel="noopener noreferrer">
      <img src="<?= e(asset('img/instagram-logo.webp')) ?>" width="60" alt="Instagram">
    </a>
  </div>
  <div class="button2" title="<?= e(t('mail_title')) ?>">
    <a href="mailto:theeternity.esports.id@gmail.com" class="hvr-float-shadow2">
      <img src="<?= e(asset('img/gmail-logo.png')) ?>" width="60" alt="Email">
    </a>
  </div>

  <script src="<?= e(asset('vendor/jquery/jquery.min.js')) ?>"></script>
  <script src="<?= e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
  <script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
<?php
}

/** Inline form error list (replaces global-validation/errors.php). */
function form_errors(array $errors): void
{
    if ($errors === []) {
        return;
    } ?>
	<div class="error">
<?php foreach ($errors as $error): ?>
		<p><?= e($error) ?></p>
<?php endforeach; ?>
	</div>
<?php
}

/** Demo sign-in buttons shown on the login page while the site is archived. */
function demo_access_panel(): void
{
    if (!Config::archiveMode()) {
        return;
    } ?>
			  <div class="demo-panel">
				<p><b><?= e(t('demo_title')) ?></b><br><?= e(t('demo_intro')) ?></p>
<?php if (Config::staticExport()): /* static site: link straight to the pre-rendered demo dashboards */ ?>
				<a class="submit demo-link" href="<?= e(lang_url('dashboard/index.php')) ?>"><i class="fa fa-gamepad" aria-hidden="true"></i> <?= e(t('demo_player')) ?></a>
				<a class="submit demo-link" href="<?= e(url('en-us/dashboard/admin/dashboard-admin.php')) ?>"><i class="fa fa-shield" aria-hidden="true"></i> <?= e(t('demo_admin')) ?></a>
<?php else: ?>
				<form method="post" action="<?= e(url('global-validation/demo-login.php')) ?>">
				  <?= csrf_field() ?>
				  <input type="hidden" name="lang" value="<?= e(current_lang()) ?>">
				  <button type="submit" class="submit" name="as" value="user"><i class="fa fa-gamepad" aria-hidden="true"></i> <?= e(t('demo_player')) ?></button>
				  <button type="submit" class="submit" name="as" value="admin"><i class="fa fa-shield" aria-hidden="true"></i> <?= e(t('demo_admin')) ?></button>
				</form>
<?php endif; ?>
			  </div>
<?php
}

/* ---- Dashboards (Bootstrap 3 theme) -------------------------------------- */

/**
 * Opens a dashboard page and renders the sidebar.
 * @param 'player'|'admin' $kind
 * @param string $active key of the active sidebar item
 */
function dashboard_header(string $title, string $kind, string $active, array $user): void
{
    $lang = current_lang();
    $isAdminHome = $kind === 'admin' && $active === 'dashboard';
    ?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
  <title>Eternity Esports | <?= e($title) ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!$isAdminHome): ?>
  <link rel="stylesheet" href="<?= e(asset('css/dashboard-style.css')) ?>">
<?php endif; ?>
  <link rel="stylesheet" href="<?= e(asset('vendor/bootstrap3/css/bootstrap.min.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('css/dashboard-extra.css')) ?>">
  <link rel="icon" href="<?= e(asset('img/etr-img-1.jpeg')) ?>">
<?php if ($isAdminHome): ?>
  <link rel="stylesheet" href="<?= e(asset('css/dashboard-admin-home.css')) ?>">
<?php endif; ?>
</head>

<body<?= body_attrs() ?>>
	<div class="container-fluid">
	  <div class="row content">
		<div class="col-sm-3 sidenav">
		  <h4><?= e(t('welcome_back')) ?> : <?= e($user['username']) ?></h4>
		  <h4><font color="green"><?= e(t('online')) ?></font></h4>
<?php if (Config::archiveMode()): ?>
		  <div class="alert alert-warning archive-note"><span class="label label-danger"><?= e(t('archive_label')) ?></span> <?= e(t('archive_dash')) ?></div>
<?php endif; ?>
		  <br>
<?php
    if ($kind === 'admin') {
        admin_sidebar($active);
    } else {
        player_sidebar($active);
    } ?>
		</div>

<?php
}

function sidebar_items(array $items, string $active): void
{
    foreach ($items as $key => [$href, $label]) {
        echo "\t\t\t<li" . ($key === $active ? ' class="active"' : '') . '><a href="' . e($href) . '">' . e($label) . "</a></li>\n";
    }
}

function player_sidebar(string $active): void
{
    $id = current_lang() === 'id';
    $d  = static fn (string $p): string => lang_url('dashboard/' . $p);
    $items = [
        'home'        => [lang_url('index.php'), 'Home'],
        'dashboard'   => [$d('index.php'), 'DashBoard'],
        'participate' => [$d('participate-scrim.php'), $id ? '1. Berpartisipasi Dalam Scrim' : '1. Participate in a Scrim'],
        'join-group'  => [$d('join-group.php'), $id ? '2. Bergabung Di Grup WA' : '2. Join WhatsApp Group'],
        'upload'      => [$d('upload-center.php'), $id ? '3. Pusat Pengunggahan' : '3. Upload Center'],
        'attendance'  => [$d('attendance.php'), $id ? '4. Absensi' : '4. Attendance'],
        'result'      => [$d('submit-result.php'), $id ? '5. Mengirim Hasil Akhir' : '5. Submit Result'],
        'certificate' => [$d('certificate.php'), $id ? '6. Unduh E-Sertifikat' : '6. Download Certificates'],
        'support'     => [$d('support.php'), 'Customer Service'],
        'logout'      => [logout_url(), t('logout')],
    ];
    echo "\t\t  <h4>Menus :</h4>\n\t\t  <ul class=\"nav nav-pills nav-stacked\">\n";
    sidebar_items($items, $active);
    echo "\t\t  </ul>\n";
}

function admin_sidebar(string $active): void
{
    $a = static fn (string $p): string => url('en-us/dashboard/admin/' . $p);
    echo "\t\t  <h4>Web Configuration :</h4>\n\t\t  <ul class=\"nav nav-pills nav-stacked\">\n";
    sidebar_items([
        'home'      => [url('en-us/index.php'), 'Home'],
        'dashboard' => [$a('dashboard-admin.php'), 'DashBoard'],
        'post'      => [$a('scrim-info.php'), 'Create Post'],
        'alert'     => [$a('edit-alert.php'), 'Edit Alert'],
        'gallery'   => [$a('edit-gallery.php'), 'Edit Gallery'],
        'message'   => [$a('message.php'), 'Message'],
        'user'      => [$a('edit-user.php'), 'User Account'],
    ], $active);
    echo "\t\t  </ul>\n\t\t  <h4>Scrim Settings :</h4>\n\t\t  <ul class=\"nav nav-pills nav-stacked\">\n";
    sidebar_items([
        'scrim'       => [$a('edit-event.php'), 'Create Scrim'],
        'participant' => [$a('user-upload.php'), 'Participant'],
        'present'     => [$a('present-participant.php'), 'Present Participant'],
        'result'      => [$a('scrim-result.php'), 'Scrim Result'],
        'certificate' => [$a('create-certificate-list.php'), 'Link Certificate'],
        'logout'      => [logout_url(), 'Logout'],
    ], $active);
    echo "\t\t  </ul>\n";
}

/** The "RECENT POSTS / Welcome to Eternity Gaming Club" block repeated on every admin page. */
function admin_intro(): void
{ ?>
		  <h4><small>RECENT POSTS</small></h4>
		  <hr>
		  <h2>Welcome to Eternity Gaming Club</h2>
		  <h5><span class="glyphicon glyphicon-time"></span> Posted by Admin.</h5>
		  <h5><span class="label label-danger">Welcome</span></h5><br>
		  <p>Welcome to Eternity Esports Official Website. We're dedicated to give you the best scrim experience, with a focus on scrim event and developing skill. Founded in 2019 by Owen Tristan, Eternity Esports has come a long way from its beginnings in Medan, Indonesia. When Eternity Esports first started out, our passion for developing drove us to create an online website with advanced security, so that we can offer you a fair and competitive scrim. We are ready to serve customers all over the world, and are thrilled that we're able to turn our passion into our own website. We hope you enjoy our services we provide. If you have any questions or comments, please don't hesitate to contact us/leave us a message.</p>
<?php
}

function dashboard_footer(): void
{ ?>
	  </div>
	</div>

	<footer class="footer text-faded text-center py-0">
    <div class="container">
      <p class="m-0 small"><?= e(t('copyright')) ?> &copy; 2020 Eternity Esports | <?= e(t('designed_by')) ?> <a href="https://github.com/stanleyowen" target="_blank" rel="noopener noreferrer">Stanley Owen</a></p>
    </div>
  </footer>

  <script src="<?= e(asset('vendor/jquery/jquery.min.js')) ?>"></script>
  <script src="<?= e(asset('vendor/bootstrap3/js/bootstrap.min.js')) ?>"></script>
  <script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
<?php
}

/* ---- Error pages --------------------------------------------------------- */

function render_error_page(int $code, string $title, string $heading, string $messageHtml): void
{
    if (!headers_sent()) {
        http_response_code($code);
    } ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= e($title) ?> | Eternity Esports</title>
	<link rel="icon" href="<?= e(asset('img/etr-img-1.jpeg')) ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900&amp;display=swap">
	<link rel="stylesheet" href="<?= e(asset('css/style-error.css')) ?>">
</head>

<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2><?= e($heading) ?></h2>
			<p><?= $messageHtml ?></p>
			<a href="<?= e(url('index.php')) ?>" data-back>Back</a>
		</div>
	</div>
	<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>

</html>
<?php
}
