<?php
// src/public/index.php
// Configuracion de cookies
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_strict_mode', 1);

session_start();
// Regenerar sesion
if (!isset($_SESSION['ultimo_regenerado'])) {
    $_SESSION['ultimo_regenerado'] = time();
} else if (time() - $_SESSION['ultimo_regenerado'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['ultimo_regenerado'] = time();
}

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/MapController.php';
require_once __DIR__ . '/../controllers/ApiController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/FavoritosController.php';
require_once __DIR__ . '/../controllers/HorariosController.php';
require_once __DIR__ . '/../controllers/ReportesController.php';

// Cabeceras de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
// Enrutador
if ($uri === '/' || $uri === '/home') {
    (new HomeController())->index();
} elseif ($uri === '/map') {
    (new MapController())->index();
} elseif ($uri === '/login') {
    if ($method === 'POST') {
        (new AuthController())->doLogin();
    } else {
        (new AuthController())->showLogin();
    }
} elseif ($uri === '/google-login' && $method === 'POST') {
    (new AuthController())->doGoogleLogin();
} elseif ($uri === '/register') {
    if ($method === 'POST') {
        (new AuthController())->doRegister();
    } else {
        (new AuthController())->showRegister();
    }
} elseif ($uri === '/logout') {
    (new AuthController())->logout();
} elseif ($uri === '/admin') {
    (new AdminController())->index();
} elseif ($uri === '/admin/bus/add') {
    (new AdminController())->addBus();
} elseif ($uri === '/admin/bus/store') {
    (new AdminController())->storeBus();
} elseif ($uri === '/admin/avisos') {
    (new AdminController())->avisos();
} elseif ($uri === '/api/buses') {
    (new ApiController())->getBuses();
} elseif ($uri === '/mis-rutas') {
    (new FavoritosController())->index();
} elseif ($uri === '/horarios') {
    (new HorariosController())->index();
} elseif ($uri === '/reportes') {
    (new ReportesController())->index();
} elseif ($uri === '/admin/horarios') {
    (new AdminController())->horarios();
} elseif ($uri === '/admin/reportes') {
    (new AdminController())->reportes();
} else {
    http_response_code(404);
    echo "404 - Pagina no encontrada";
}