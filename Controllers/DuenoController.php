<?php

namespace Controllers;

class DuenoController
{
    public function verificar($username, $password)
    {
        require_once(VIEWS_PATH . "ControlDeAccesoDueno.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function registro()
    {
        require_once(VIEWS_PATH . "registroDueno.php");
    }
}