<?php

class MapController
{
    public function index()
    {
        $title = "Mapa en Tiempo Real - CeutaBus";

        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/map.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
