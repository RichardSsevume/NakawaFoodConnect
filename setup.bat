@echo off
cd /d "%~dp0"
echo ==========================================
echo   Nakawa Food Connect - one click setup
echo ==========================================

where php >nul 2>nul
if errorlevel 1 goto nophp

if exist vendor\autoload.php goto havevendor
where composer >nul 2>nul
if errorlevel 1 goto nocomposer
call composer install
:havevendor

if exist .env goto haveenv
copy .env.example .env >nul
php artisan key:generate --force
:haveenv

php artisan config:clear
php artisan nfc:install --force
if errorlevel 1 goto fail

echo.
echo Starting the website at http://127.0.0.1:8000  (press Ctrl+C to stop)
php artisan serve
goto end

:nophp
echo PHP was not found. Install XAMPP or Laragon and add the PHP folder to your PATH.
echo XAMPP example: C:\xampp\php
goto fail

:nocomposer
echo The vendor folder is missing and Composer is not installed. Install Composer from getcomposer.org
goto fail

:fail
echo.
echo Setup stopped. Read the message above.
pause
exit /b 1

:end
