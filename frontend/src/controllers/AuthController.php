<?php

class AuthController
{
    private $db;
    private $googleClientId = '24521774555-sc0hs50gkip90pud8p8j1jooir6rc2pe.apps.googleusercontent.com';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    private function generarTokenCSRF()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    private function verificarTokenCSRF()
    {
        $tokenFormulario = $_POST['csrf_token'] ?? '';
        $tokenSesion = $_SESSION['csrf_token'] ?? '';

        if (empty($tokenFormulario) || empty($tokenSesion)) {
            return false;
        }

        return hash_equals($tokenSesion, $tokenFormulario);
    }

    public function showLogin()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        $title = "Iniciar Sesión - CeutaBus";
        $googleClientId = $this->googleClientId;
        $csrfToken = $this->generarTokenCSRF();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/auth/login.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function doLogin()
    {
        if (!$this->verificarTokenCSRF()) {
            $_SESSION['error'] = 'Solicitud no válida. Recarga la página e inténtalo de nuevo.';
            header('Location: /login');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Por favor, rellena todos los campos';
            header('Location: /login');
            exit;
        }

        if (strlen($username) > 50) {
            $_SESSION['error'] = 'Nombre de usuario demasiado largo';
            header('Location: /login');
            exit;
        }

        $stmt = $this->db->prepare("SELECT id, username, password_hash, role FROM usuarios WHERE username = ?");
        $stmt->execute(array($username));
        $user = $stmt->fetch();

        if ($user && $user['password_hash'] && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['ultimo_regenerado'] = time();

            if ($user['role'] === 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: /login');
            exit;
        }
    }

    public function showRegister()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        $title = "Crear Cuenta - CeutaBus";
        $googleClientId = $this->googleClientId;
        $csrfToken = $this->generarTokenCSRF();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/auth/register.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }

    public function doRegister()
    {
        if (!$this->verificarTokenCSRF()) {
            $_SESSION['error'] = 'Solicitud no válida. Recarga la página e inténtalo de nuevo.';
            header('Location: /register');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = 'Todos los campos son obligatorios';
            header('Location: /register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El formato del correo electrónico no es válido';
            header('Location: /register');
            exit;
        }

        if (strlen($email) > 100) {
            $_SESSION['error'] = 'El correo electrónico es demasiado largo';
            header('Location: /register');
            exit;
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: /register');
            exit;
        }

        $errorPassword = $this->validarPassword($password);
        if ($errorPassword) {
            $_SESSION['error'] = $errorPassword;
            header('Location: /register');
            exit;
        }

        if (strlen($username) < 4 || strlen($username) > 50) {
            $_SESSION['error'] = 'El nombre de usuario debe tener entre 4 y 50 caracteres';
            header('Location: /register');
            exit;
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $_SESSION['error'] = 'El nombre de usuario solo puede contener letras, números y guiones bajos';
            header('Location: /register');
            exit;
        }

        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->execute(array($username));
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'El nombre de usuario ya está en uso';
            header('Location: /register');
            exit;
        }

        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute(array($email));
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Este correo electrónico ya está registrado';
            header('Location: /register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';

        try {
            $stmt = $this->db->prepare("INSERT INTO usuarios (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(array($username, $email, $hash, $role));

            session_regenerate_id(true);

            $_SESSION['user_id'] = $this->db->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['ultimo_regenerado'] = time();

            header('Location: /');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error al crear la cuenta. Inténtalo de nuevo.';
            header('Location: /register');
            exit;
        }
    }

    private function validarPassword($password)
    {
        if (strlen($password) < 6) {
            return 'La contraseña debe tener al menos 6 caracteres';
        }
        if (strlen($password) > 100) {
            return 'La contraseña es demasiado larga';
        }
        if (!preg_match('/[A-Za-z]/', $password)) {
            return 'La contraseña debe contener al menos una letra';
        }
        if (!preg_match('/[0-9]/', $password)) {
            return 'La contraseña debe contener al menos un número';
        }
        return null;
    }

    public function doGoogleLogin()
    {
        $credential = $_POST['credential'] ?? '';

        if (empty($credential)) {
            $_SESSION['error'] = 'No se recibió respuesta de Google';
            header('Location: /login');
            exit;
        }

        $googleData = $this->verificarTokenGoogle($credential);

        if (!$googleData) {
            $_SESSION['error'] = 'No se pudo verificar tu cuenta de Google';
            header('Location: /login');
            exit;
        }

        $googleId = $googleData['sub'];
        $email = $googleData['email'];
        $nombre = $googleData['name'] ?? explode('@', $email)[0];

        $stmt = $this->db->prepare("SELECT id, username, role FROM usuarios WHERE google_id = ?");
        $stmt->execute(array($googleId));
        $user = $stmt->fetch();

        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['ultimo_regenerado'] = time();
        } else {
            $stmt = $this->db->prepare("SELECT id, username, role FROM usuarios WHERE email = ?");
            $stmt->execute(array($email));
            $user = $stmt->fetch();

            if ($user) {
                $stmt = $this->db->prepare("UPDATE usuarios SET google_id = ? WHERE id = ?");
                $stmt->execute(array($googleId, $user['id']));

                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['ultimo_regenerado'] = time();
            } else {
                $baseUsername = preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
                $username = $baseUsername;
                $counter = 1;

                while (true) {
                    $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE username = ?");
                    $stmt->execute(array($username));
                    if (!$stmt->fetch()) {
                        break;
                    }
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                try {
                    $stmt = $this->db->prepare(
                        "INSERT INTO usuarios (username, email, google_id, role) VALUES (?, ?, ?, 'user')"
                    );
                    $stmt->execute(array($username, $email, $googleId));

                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $this->db->lastInsertId();
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = 'user';
                    $_SESSION['ultimo_regenerado'] = time();
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Error al crear la cuenta con Google';
                    header('Location: /login');
                    exit;
                }
            }
        }

        if ($_SESSION['role'] === 'admin') {
            header('Location: /admin');
        } else {
            header('Location: /');
        }
        exit;
    }

    private function verificarTokenGoogle($idToken)
    {
        $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);

        $respuesta = @file_get_contents($url);
        if ($respuesta === false) {
            return null;
        }

        $datos = json_decode($respuesta, true);
        if (!$datos || !isset($datos['sub'])) {
            return null;
        }

        if ($datos['aud'] !== $this->googleClientId) {
            return null;
        }

        if (!isset($datos['email_verified']) || $datos['email_verified'] !== 'true') {
            return null;
        }

        return $datos;
    }

    public function logout()
    {
        $_SESSION = array();

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();
        header('Location: /');
        exit;
    }
}