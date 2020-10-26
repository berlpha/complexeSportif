release: php bin/console cache:clear && php bin/console cache:warmup
'web: heroku-php-apache2 public/'
web: vendor/bin/heroku-php-nginx -C heroku/nginx.conf public/
