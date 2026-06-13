<?php
require_once __DIR__ . '/../config/database.php';

class ReportesController
{
    private $apiUrl = 'https://tfg-backend-api.onrender.com/api';

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tokenEnviado = $_POST['csrf_token'] ?? '';
            $tokenSesion = $_SESSION['csrf_reportes'] ?? '';

            if (empty($tokenEnviado) || !hash_equals($tokenSesion, $tokenEnviado)) {
                $error = 'Solicitud no válida. Recarga la página.';
            } else {
                $mensaje = trim($_POST['mensaje'] ?? '');

                if (empty($mensaje)) {
                    $error = 'El mensaje es obligatorio.';
                } else if (strlen($mensaje) > 2000) {
                    $error = 'El mensaje es demasiado largo (máximo 2000 caracteres).';
                } else {
                    $data = array(
                        'usuario_id' => $userId,
                        'mensaje' => $mensaje
                    );

                    $ch = curl_init($this->apiUrl . '/reportes');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($httpCode === 201) {
                        $success = 'Reporte enviado correctamente.';
                    } else {
                        $error = 'Error al enviar el reporte. Código HTTP: ' . $httpCode;
                    }
                }
            }
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_reportes'] = $csrfToken;

        $reportes = array();
        $ch = curl_init($this->apiUrl . '/reportes/user/' . intval($userId));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $reportes = json_decode($response, true);
        }

        $title = "Soporte - CeutaBus";
        require __DIR__ . '/../views/reportes.php';
    }
}
