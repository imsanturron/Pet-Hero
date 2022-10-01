<?php

namespace Controllers;

class DuenoController
{
    public function verificar($username, $password)
    {
        require_once(VIEWS_PATH . "ControlDeAccesoDueño.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginDueño.php");
    }
}
