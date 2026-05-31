<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
    
        $host = getenv('DATABASE_HOST') ?: 'localhost';
        $db   = getenv('DATABASE_NAME') ?: 'gpsdb';
        $user = getenv('DATABASE_USER') ?: 'postgres';
        $pass = getenv('DATABASE_PASSWORD') ?: '';

        $dsn = "pgsql:host=$host;port=5432;dbname=$db;";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}