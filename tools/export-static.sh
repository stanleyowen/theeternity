#!/bin/sh
# Build the archive image, render every page into dist/, and stop the container.
# The result is a plain static site: publish dist/ on Netlify or Cloudflare Pages.
set -eu
cd "$(dirname "$0")/.."

PORT="${PORT:-8095}"
NAME=eternity-export

docker build -q -t eternity:export . >/dev/null
docker rm -f "$NAME" >/dev/null 2>&1 || true
docker run -d --name "$NAME" -p "127.0.0.1:${PORT}:80" -e STATIC_EXPORT=true eternity:export >/dev/null
trap 'docker rm -f "$NAME" >/dev/null 2>&1 || true' EXIT

i=0
until curl -sf -o /dev/null "http://127.0.0.1:${PORT}/en-us/index.php"; do
  i=$((i + 1)); [ "$i" -ge 30 ] && { echo "Server did not start" >&2; exit 1; }
  sleep 1
done

python3 tools/export_static.py "http://127.0.0.1:${PORT}" dist
