# Nakawa Food Connect (Laravel 12 + MySQL)

Food ordering for MUBS students in Nakawa: students, vendors and an administrator.

## Quick start (Windows / XAMPP)

1. Start **MySQL** in the XAMPP control panel (Apache is not needed).
2. Make sure PHP 8.2+ is in your PATH (XAMPP: `C:\xampp\php`) and `extension=pdo_mysql`
   is enabled in `php.ini` (it is by default in XAMPP).
3. Double-click **`setup.bat`** (or in a terminal inside this folder run the 3 commands below).

```
php artisan config:clear
php artisan nfc:install
php artisan serve
```

Open http://127.0.0.1:8000

`php artisan nfc:install` will: test the MySQL connection, **create the database
`nakawafoodconnect` if it does not exist**, build all tables and load demo data.
Running it again wipes the database and starts fresh.

## Logins (password for all: `password`)

| Role    | Email                                        |
|---------|----------------------------------------------|
| Admin   | admin@nakawafood.ug                          |
| Student | student@nakawafood.ug                        |
| Vendors | vendor1@nakawafood.ug ... vendor7@nakawafood.ug |

Admin panel: log in, then you are taken to `/admin`.

## MySQL settings

Edit `.env` (no spaces at the start of lines!):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nakawafoodconnect
DB_USERNAME=root
DB_PASSWORD=
```

After any `.env` change run `php artisan config:clear`.

## Troubleshooting

| Message | Fix |
|---------|-----|
| `SQLSTATE[HY000] [2002] No connection could be made` | MySQL is not running, or wrong `DB_PORT` (Laragon/MAMP may use 3307/8889). |
| `SQLSTATE[HY000] [1045] Access denied` | Wrong `DB_USERNAME` / `DB_PASSWORD`. |
| `could not find driver` | Enable `extension=pdo_mysql` in `php.ini`, restart terminal. |
| `Table ... doesn't exist` | Run `php artisan nfc:install`. |
| Old errors keep showing | `php artisan config:clear` and `php artisan view:clear`. |
| Server was already installed with an older broken database | `php artisan nfc:install` (it rebuilds everything). |

Password-reset emails are written to `storage/logs/laravel.log` until real SMTP is set in `.env`.
**Change all demo passwords and set `APP_DEBUG=false` before going live.**
