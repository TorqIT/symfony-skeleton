#!/usr/bin/env bash

set -e

/composer-install-dependencies.sh

bin/console cache:clear

/init.sh
