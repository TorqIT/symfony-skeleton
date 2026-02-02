#!/usr/bin/env bash

set -e

/composer-install-dependencies.sh

runuser -u www-data -- bin/console cache:clear

/init.sh
