<?php

use DAO\GuardianDAO;
use Models\Guardian as Guardian;

/*
$user1 = new ClientUser("SSoler", "cosme1234");
$user2 = new ClientUser("AzarJ", "alAzar123");
$user3 = new ClientUser("Mari123", "123456Mari");
$usuarios = array($user1,$user2,$user3);
*/

if ($_POST) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $ingreso = true;
    $repositorioUsers = new GuardianDAO();
    $usuarios = $repositorioUsers->getAll();

    for ($i = 0; $i < count($usuarios); $i++) {

        if ($username == $usuarios[$i]->getUsername() && $password == $usuarios[$i]->getPassword()) {

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
