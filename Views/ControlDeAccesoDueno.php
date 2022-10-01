<?php

use DAO\DuenoDAO as DuenoDAO;;
use Models\Dueno as Dueno;




if ($_POST) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $ingreso = true;
    $repositorioUsers = new DuenoDAO();
    $usuarios = $repositorioUsers->getAll();
    print_r($usuarios[1]->getUsername());
    for ($i = 0; $i < count($usuarios); $i++) {

        if ($username == $usuarios[$i]->getUsername() && $password == $usuarios[$i]->getPassword()) {

            $ingreso = false;
            $loggedUser = new Dueno("", "");//////////
            $loggedUser->setUsername($username);
            $loggedUser->setPassword($password);
            $_SESSION["loggedUser"] = $loggedUser;

            echo "Entro" . "<br>";
            echo $usuarios[1]->getPassword() . "<br>";
            header("location:..\Dueno\login");
        }
    }
}

if ($ingreso == true) {

    // header("location:..\Home\index");
}
