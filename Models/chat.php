<?php
namespace Models;

class chat{

 private $id;
 private $dniDueno;
 private $dniGuardian;
 private $nombreDueno;
 private $nombreGuardian;
 private $mensaje;
 

 public function  __construct(Guardian $guardian = null, Dueno $dueno = null, $mensaje = null)
 {
     if (isset($guardian) && isset($dueno) ) {
       
         $this->nombreDueno = $dueno->getNombre();
         $this->dniDueno = $dueno->getDni();
         $this->nombreGuardian = $guardian->getNombre();
         $this->dniGuardian = $guardian->getdni();
         $this->mensaje = $mensaje;
     }
 }




 /**
  * Get the value of id
  */ 
 public function getId()
 {
  return $this->id;
 }

 /**
  * Set the value of id
  *
  * @return  self
  */ 
 public function setId($id)
 {
  $this->id = $id;

  return $this;
 }

 /**
  * Get the value of dniDueno
  */ 
 public function getDniDueno()
 {
  return $this->dniDueno;
 }

 /**
  * Set the value of dniDueno
  *
  * @return  self
  */ 
 public function setDniDueno($dniDueno)
 {
  $this->dniDueno = $dniDueno;

  return $this;
 }

 /**
  * Get the value of dniGuardian
  */ 
 public function getDniGuardian()
 {
  return $this->dniGuardian;
 }

 /**
  * Set the value of dniGuardian
  *
  * @return  self
  */ 
 public function setDniGuardian($dniGuardian)
 {
  $this->dniGuardian = $dniGuardian;

  return $this;
 }

 /**
  * Get the value of nombreDueno
  */ 
 public function getNombreDueno()
 {
  return $this->nombreDueno;
 }

 /**
  * Set the value of nombreDueno
  *
  * @return  self
  */ 
 public function setNombreDueno($nombreDueno)
 {
  $this->nombreDueno = $nombreDueno;

  return $this;
 }

 /**
  * Get the value of nombreGuardian
  */ 
 public function getNombreGuardian()
 {
  return $this->nombreGuardian;
 }

 /**
  * Set the value of nombreGuardian
  *
  * @return  self
  */ 
 public function setNombreGuardian($nombreGuardian)
 {
  $this->nombreGuardian = $nombreGuardian;

  return $this;
 }

 /**
  * Get the value of mensaje
  */ 
 public function getMensaje()
 {
  return $this->mensaje;
 }

 /**
  * Set the value of mensaje
  *
  * @return  self
  */ 
 public function setMensaje($mensaje)
 {
  $this->mensaje = $mensaje;

  return $this;
 }
}
 


?>