<?php

namespace Controllers;
class GuardianController
{
    public function verificar($username, $password)
    {
        require_once(VIEWS_PATH . "ControlDeAccesoGuardian.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginGuardian.php");
    }
}
