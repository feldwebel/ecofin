<?php

declare(strict_types=1);

namespace App;

use PDO;

class DB {

    private static $instance;

    private PDO $link;

    private static array $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public static function me(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->link = new PDO(
            getenv('DSN'),
            getenv('DB_USER'),
            getenv('DB_PASS'),
            self::$opt);
    }

    public function getLink(): PDO
    {
        return $this->link;
    }
}
