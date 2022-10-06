<?php

use DAO\DuenoDAO as DuenoDAO;;
use Models\Dueno as Dueno;




if ($_POST) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $ingreso = true;
    $repositorioUsers = new DuenoDAO();
    $usuarios = $repositorioUsers->getAll();
    //print_r($usuarios[1]->getUserName());
    for ($i = 0; $i < count($usuarios); $i++) {

        if ($username == $usuarios[$i]->getUserName() && $password == $usuarios[$i]->getPassword()) {

            $ingreso = false;
            $loggedUser = new Dueno();
            $loggedUser->setUserName($username);
            $loggedUser->setPassword($password);
            $loggedUser->setDni($usuarios[$i]->getDni());
            $_SESSION["loggedUser"] = $loggedUser;

            echo "Entro" . "<br>";
            //echo $usuarios[1]->getPassword() . "<br>";
            header("location:..\Dueno\login");
        }
    }
}

if ($ingreso == true) {
     header("location:..\Home\index");
}
