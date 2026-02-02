#!/usr/bin/env bash

set -e

if [ -n "$(find /var/www/html/migrations -name '*.php' -type f 2>/dev/null)" ]; then
    echo "Running migrations..."
    runuser -u www-data -- /var/www/html/bin/console doctrine:migrations:migrate -n
else
    echo "No migration files found, so skipping migrations"
fi

echo "Init complete!"
