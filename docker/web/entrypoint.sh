#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

cd /var/www/symfony && APP_ENV=dev composer install
cd /var/www/symfony && bin/console doctrine:database:create -n || true
cd /var/www/symfony && bin/console doctrine:schema:update --force -n
cd /var/www/symfony && bin/console doctrine:fixtures:load -n
chmod 777 var -R

exec "$@"