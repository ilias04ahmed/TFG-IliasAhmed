<?php
require_once __DIR__ . '/../config/database.php';

class ApiController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getBuses()
    {
        $sql = "
            SELECT a.codigo as id, a.matricula, l.codigo as route, l.color,
                   p.lat, p.lon, p.eta_seconds
            FROM autobuses a
            JOIN lineas l ON a.linea_id = l.id
            LEFT JOIN posiciones_gps p ON p.autobus_id = a.id
            WHERE a.activo = TRUE
            ORDER BY p.timestamp DESC
        ";

        $mock = array(
            array(
                "id" => "BUS_01",
                "lat" => 35.8889 + (rand(-10, 10) * 0.0001),
                "lon" => -5.3213 + (rand(-10, 10) * 0.0001),
                "route" => "L1",
                "color" => "#3B82F6",
                "next_stop" => "Plaza África",
                "eta" => "2 min"
            ),
            array(
                "id" => "BUS_02",
                "lat" => 35.8871 + (rand(-10, 10) * 0.0001),
                "lon" => -5.3152 + (rand(-10, 10) * 0.0001),
                "route" => "L2",
                "color" => "#EF4444",
                "next_stop" => "Hospital",
                "eta" => "5 min"
            )
        );

        header('Content-Type: application/json');
        echo json_encode($mock);
    }
}