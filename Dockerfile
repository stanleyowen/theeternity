# Eternity Esports — archive edition
FROM php:8.5-apache

# GD (image re-encoding for uploads) and pdo_mysql (optional MySQL backend).
RUN apt-get update \
 && apt-get install -y --no-install-recommends libpng-dev libjpeg62-turbo-dev \
 && docker-php-ext-configure gd --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" gd pdo_mysql \
 && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && a2enmod headers \
 && a2disconf other-vhosts-access-log

COPY docker/php.ini /usr/local/etc/php/conf.d/zz-eternity.ini
COPY docker/apache.conf /etc/apache2/conf-available/zz-eternity.conf
COPY docker/entrypoint.sh /usr/local/bin/eternity-entrypoint
RUN a2enconf zz-eternity && chmod +x /usr/local/bin/eternity-entrypoint

WORKDIR /var/www/html
COPY . .

# Bake the read-only archive database into the image.
RUN php bin/init-db.php --fresh --seed \
 && chown -R root:www-data /var/www/html \
 && find /var/www/html -type d -exec chmod 755 {} + \
 && find /var/www/html -type f -exec chmod 644 {} + \
 && chown -R www-data:www-data storage \
 && chmod -R u+rwX,g+rX,o-rwx storage

ENV APP_ENV=production \
    ARCHIVE_MODE=true

EXPOSE 80
ENTRYPOINT ["eternity-entrypoint"]
CMD ["apache2-foreground"]
