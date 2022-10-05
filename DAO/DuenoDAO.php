<?php

namespace DAO;

use Models\Dueno as Dueno;

class DuenoDAO
{
    private $usuarioList = array();
    private $filename;

    public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Dueno" . ".json";
    }

    public function add(Dueno $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->SaveData();
    }

    public function remove(Dueno $user)
    {

        $this->retrieveData();

        if (($clave = array_search($user, $this->usuarioList)) !== false) {

            unset($this->usuarioList[$clave]);
        }


        $this->SaveData();
    }
    /**Busca factura por numero y tipo  en archivo retorna true o false */
    public function search(Dueno $user)
    {

        $this->retrieveData();
        $encontrado = false;

        foreach ($this->usuarioList as $element) {

            if ($user->getUsername == $element->getUsername()) {

                $encontrado = true;
            }
        }
        return $encontrado;
    }

    public function getAll(){
        $this->retrieveData();
        return $this->usuarioList;
    }

    public function saveData(){
        $arrayToEncode = array();

        foreach ($this->usuarioList as $dueno) {

            $valueArray["username"] = $dueno->getUsername();
            $valueArray["password"] = $dueno->getPassword();
            $valueArray["dni"] = $dueno->getDni();
            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonContent);
    }

    private function retrieveData(){

        $this->usuarioList = array();

        if (file_exists($this->filename)) {

            $jsonContent = file_get_contents($this->filename);
            $arrayToEncode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToEncode as $valueArray) {

                $usuario = new Dueno("", "");
                $usuario->setUsername($valueArray["username"]);
                $usuario->setPassword($valueArray["password"]);
                $usuario->setDni($valueArray["dni"]);
                array_push($this->usuarioList, $usuario);
            }
        }
    }

    public function getUsuarioList(){
        return $this->usuarioList;
    }
}
