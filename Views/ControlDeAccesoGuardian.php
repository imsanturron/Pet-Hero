<?php

use DAO\GuardianDAO;
use Models\Guardian as Guardian;

if ($_POST) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $ingreso = true;
    $repositorioUsers = new GuardianDAO();
    $usuarios = $repositorioUsers->getAll();

    for ($i = 0; $i < count($usuarios); $i++) {

        if ($username == $usuarios[$i]->getUsername() && $password == $usuarios[$i]->getPassword()) {
        ///// error en login cuando no hay json.
            $ingreso = false;
            $loggedUser = new Guardian("", "");
            $loggedUser->setUsername($username);
            $loggedUser->setPassword($password);
            $_SESSION["loggedUser"] = $loggedUser;

            header("location:..\Guardian\login");
        }
    }
}

if ($ingreso == true) {
    header("location:..\Home\index");
}
