#!/bin/bash

set -Eeuo pipefail

/healthcheck-mysql.sh

exec php-fpm -F
