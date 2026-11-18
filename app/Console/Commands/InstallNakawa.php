<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class InstallNakawa extends Command
{
    protected $signature = 'nfc:install {--force : Do not ask for confirmation}';

    protected $description = 'Create the MySQL database (if missing), then run migrations and seed demo data';

    public function handle(): int
    {
        $name = config('database.default');
        $cfg = config("database.connections.$name");

        if (in_array($name, ['mysql', 'mariadb'], true)) {
            $db = (string) ($cfg['database'] ?? '');

            if (!preg_match('/^[A-Za-z0-9_]+$/', $db)) {
                $this->error("DB_DATABASE '$db' is not valid. Use only letters, numbers and underscores in .env");
                return self::FAILURE;
            }

            if (!extension_loaded('pdo_mysql')) {
                $this->error('The PHP extension pdo_mysql is not enabled.');
                $this->line('Open php.ini, remove the ";" before  extension=pdo_mysql  , save, then run this command again.');
                return self::FAILURE;
            }

            $this->info("Connecting to MySQL at {$cfg['host']}:{$cfg['port']} as '{$cfg['username']}' ...");

            try {
                $dsn = !empty($cfg['unix_socket'])
                    ? "mysql:unix_socket={$cfg['unix_socket']}"
                    : "mysql:host={$cfg['host']};port={$cfg['port']}";

                $pdo = new PDO($dsn, (string) $cfg['username'], (string) ($cfg['password'] ?? ''), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);

                $charset = preg_match('/^\w+$/', (string) $cfg['charset']) ? $cfg['charset'] : 'utf8mb4';
                $collation = preg_match('/^\w+$/', (string) $cfg['collation']) ? $cfg['collation'] : 'utf8mb4_unicode_ci';
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE $collation");
            } catch (PDOException $e) {
                $this->error('Could not connect to MySQL: ' . $e->getMessage());
                $this->line('Please check:');
                $this->line('  1. MySQL is running (start "MySQL" in the XAMPP / Laragon / WAMP control panel).');
                $this->line('  2. DB_HOST, DB_PORT, DB_USERNAME and DB_PASSWORD in the .env file are correct');
                $this->line('     (XAMPP default: user root, empty password, port 3306).');
                $this->line('  3. After editing .env run:  php artisan config:clear');
                return self::FAILURE;
            }

            $this->info("Database '$db' is ready.");
        }

        if (!$this->option('force')
            && !$this->confirm('This ERASES all tables in this database and installs fresh demo data. Continue?', true)) {
            $this->line('Cancelled.');
            return self::SUCCESS;
        }

        DB::purge();

        $code = $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        if ($code !== 0) {
            $this->error('Migration failed. Read the message above.');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Nakawa Food Connect is installed.');
        $this->line('Start the site with:  php artisan serve   then open http://127.0.0.1:8000');
        $this->newLine();
        $this->table(['Role', 'Email', 'Password'], [
            ['Admin', 'admin@nakawafood.ug', 'password'],
            ['Student', 'student@nakawafood.ug', 'password'],
            ['Vendor', 'vendor1@nakawafood.ug ... vendor7@nakawafood.ug', 'password'],
        ]);

        return self::SUCCESS;
    }
}
