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

<<<<<<< HEAD
            if ($user->getUsername == $element->getUsername()) {
=======
            if ($user->getUsername() == $element->getUsername()) {
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7

                $encontrado = true;
            }
        }
        return $encontrado;
    }

<<<<<<< HEAD
=======
    
    public function getByUsername($user) 
    {
      $this->retrieveData();
      foreach($this->usuarioList as $item) 
      {
        if($item->getUsername() == $user)
          return $item;
      }
      return null;
    }

>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    public function getAll(){
        $this->retrieveData();
        return $this->usuarioList;
    }

    public function saveData(){
        $arrayToEncode = array();

        foreach ($this->usuarioList as $dueno) {

            $valueArray["username"] = $dueno->getUsername();
            $valueArray["password"] = $dueno->getPassword();
<<<<<<< HEAD
=======
            $valueArray["dni"] = $dueno->getDni();
            $valueArray["email"] = $dueno->getEmail();
            $valueArray["mascotas"] = $dueno->getMascotas();
            $valueArray["tipo"] = $dueno->getTipo();
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
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

<<<<<<< HEAD
                $usuario = new Dueno("", "");
                $usuario->setUsername($valueArray["username"]);
                $usuario->setPassword($valueArray["password"]);
=======
                $usuario = new Dueno;
                $usuario->setUsername($valueArray["username"]);
                $usuario->setPassword($valueArray["password"]);
                $usuario->setDni($valueArray["dni"]);
                $usuario->setEmail($valueArray["email"]);
                $usuario->setMascotas($valueArray["mascotas"]);
                $usuario->setTipo($valueArray["tipo"]);
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
                array_push($this->usuarioList, $usuario);
            }
        }
    }

    public function getUsuarioList(){
        return $this->usuarioList;
    }
}
