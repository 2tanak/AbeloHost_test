<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * Самописный мини-парсер .env файлов
     */
    private static function loadEnv(): void
    {
        $envPath = __DIR__ . '/../../.env'; // Путь до корня проекта, где лежит .env
        
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // Игнорируем комментарии
                if (str_starts_with(trim($line), '#')) {
                    continue;
                }
                
                // Разбиваем строку на КЛЮЧ=ЗНАЧЕНИЕ
                if (str_contains($line, '=')) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value);
                    
                    // Убираем возможные кавычки вокруг значения
                    $value = trim($value, '"\'');
                    
                    // Записываем в переменные окружения PHP
                    putenv("{$name}={$value}");
                }
            }
        }
    }

    /**
     * Точка доступа к синглтону подключения
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // 1. Сначала загружаем данные из .env файла в память
            self::loadEnv();

            // 2. Теперь спокойно вытаскиваем их через getenv()
            $host    = getenv('DB_HOST') ?: 'mysql';
            $db      = getenv('DB_DATABASE') ?: 'abelo_blog';
            $user    = getenv('DB_USERNAME') ?: 'root';
            $pass    = getenv('DB_PASSWORD') ?: 'root_pass';
            $port    = getenv('DB_PORT') ?: '3306';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                header("HTTP/1.0 500 Internal Server Error");
                die("Ошибка Singleton подключения к MySQL через .env: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
