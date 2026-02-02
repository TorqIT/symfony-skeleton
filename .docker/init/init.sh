#!/usr/bin/env bash

set -e

if [ -n "$(find migrations -name '*.php' -type f 2>/dev/null)" ]; then
    echo "Running migrations..."
    bin/console doctrine:migrations:migrate -n
else
    echo "No migration files found, so skipping migrations"
fi

echo "Init complete!"
