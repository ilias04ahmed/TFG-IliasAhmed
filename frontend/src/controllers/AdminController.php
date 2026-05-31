<?php

class AdminController
{
    private function requireAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder';
            header('Location: /login');
            exit;
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Acceso denegado. No tienes permisos de administrador.';
            header('Location: /');
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();

        $title = "Panel de Administración - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/admin/dashboard.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function addBus()
    {
        $this->requireAdmin();

        $title = "Añadir Autobús - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/admin/add_bus.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function storeBus()
    {
        $this->requireAdmin();

        header('Location: /admin');
        exit;
    }

    public function avisos()
    {
        $this->requireAdmin();

        $title = "Tablón de Avisos - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/admin/avisos.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function horarios()
    {
        $this->requireAdmin();

        $title = "Gestionar Horarios - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/admin/horarios.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function reportes()
    {
        $this->requireAdmin();

        $title = "Gestionar Reportes - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/admin/reportes.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
