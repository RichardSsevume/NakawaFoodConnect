#!/usr/bin/env bash
# Nakawa Food Connect - one command setup (Linux / macOS).
# Needs PHP >= 8.2 with pdo_mysql, and a running MySQL/MariaDB server.
set -e
cd "$(dirname "$0")"

command -v php >/dev/null || { echo "PHP not found. Install PHP 8.2+ first."; exit 1; }

if [ ! -f vendor/autoload.php ]; then
  command -v composer >/dev/null || { echo "vendor/ missing and Composer not installed."; exit 1; }
  composer install
fi

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate --force
fi

chmod -R ug+rwX storage bootstrap/cache public/uploads 2>/dev/null || true

php artisan config:clear
php artisan nfc:install --force

echo
echo "Starting the site at http://127.0.0.1:8000  (Ctrl+C to stop)"
php artisan serve
