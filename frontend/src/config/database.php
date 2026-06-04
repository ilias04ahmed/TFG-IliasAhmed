<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        
        // Colocamos tus datos de Render como valores por defecto si getenv() falla
        $host = getenv('DATABASE_HOST') ?: 'dpg-d8g6td3tqb8s73cl38l0-a.frankfurt-postgres.render.com';
        $db   = getenv('DATABASE_NAME') ?: 'tfg_bus_db';
        $user = getenv('DATABASE_USER') ?: 'admin_tfg';
        $pass = getenv('DATABASE_PASSWORD') ?: 'u7MQ82LTEUHhMh0h5wO02ucJkVHf5JAk';

        // ¡MUY IMPORTANTE!: Añadimos "sslmode=require" porque Render no permite conexiones externas sin SSL
        $dsn = "pgsql:host=$host;port=5432;dbname=$db;sslmode=require;";

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