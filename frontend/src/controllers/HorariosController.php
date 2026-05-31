<?php

class HorariosController
{
    public function index()
    {
        $title = "Horarios - CeutaBus";
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/horarios.php';
        require_once __DIR__ . '/../views/layout/footer.php';
    }
}
