#!/bin/bash

set -Eeuo pipefail

/healthcheck-mysql.sh

# Composer
composer install --no-interaction
composer clear-cache

# Cache
bin/console cache:clear
bin/console cache:warmup

# DB
bin/console doctrine:schema:update --force

exec php-fpm -F
