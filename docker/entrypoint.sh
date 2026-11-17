#!/bin/sh
set -e

# Platforms such as Render / Railway / Fly inject $PORT.
if [ -n "$PORT" ] && [ "$PORT" != "80" ]; then
  sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

# Live mode with an external volume: make sure the schema exists.
if [ "${ARCHIVE_MODE:-true}" = "false" ]; then
  su -s /bin/sh www-data -c "php /var/www/html/bin/init-db.php" >/dev/null
fi

exec docker-php-entrypoint "$@"
