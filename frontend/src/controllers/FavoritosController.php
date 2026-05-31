<?php

class FavoritosController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $title = "Mis Rutas - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/favoritos.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
