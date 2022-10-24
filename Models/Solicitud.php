<?php
 namespace Models;
 class Solicitud{

  private $nombreDueño;
  private $direccion;


  public function  __construct(){

    if(isset($_SESSION['loggedUser'])){
      if($_SESSION['loggedUser']->getTipo() == 'd'){
        
        $dueño=$_SESSION['loggedUser'];
        $this->nombreDueño=$dueño->getNombre();
        $this->direccion=$dueño->getDireccion();   
  
      }
    }
  }




  /**
   * Set the value of nombreDueño
   *
   * @return  self
   */ 
  public function setNombreDueño($nombreDueño)
  {
    $this->nombreDueño = $nombreDueño;

    return $this;
  }

  /**
   * Set the value of direccion
   *
   * @return  self
   */ 
  public function setDireccion($direccion)
  {
    $this->direccion = $direccion;

    return $this;
  }

  /**
   * Get the value of nombreDueño
   */ 
  public function getNombreDueño()
  {
    return $this->nombreDueño;
  }

  /**
   * Get the value of direccion
   */ 
  public function getDireccion()
  {
    return $this->direccion;
  }


 }


?>