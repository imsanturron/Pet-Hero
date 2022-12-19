<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<div id="pageintro" class="hoc clear">
  <article class="center">
    &nbsp; <!-- Espacio !--> 
    <h3 class="heading underline"><FONT SIZE=7>Menu De Principal</font></h3>
    &nbsp; <!-- Espacio !--> 
    <h4 ><FONT SIZE=5>Indique lo que desea hacer</font></h3>

  </article>
  &nbsp;  <!-- Espacio !--> 
</div >

<form action="<?php echo FRONT_ROOT ?>Guardian/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
   <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <FONT SIZE=4.5 style="color:black;"><?php echo $alert->getMensaje()?></font> 
  </div>
  <br> <br> 
  <button name="opcion" value="indicarDisponibilidad" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Indicar mi disponibilidad</button>
  <br> <br>
  <button name="opcion" value="cambiarTamanoACuidar" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Cambiar mi tamaño a cuidar</button>
  <br> <br>
  <button name="opcion" value="verSolicitudes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes recibidas</button>
  <br> <br>
  <button name="opcion" value="verListadReservas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis reservas</button>
  <br> <br>
  <button name="opcion" value="verPrimerosPagosPendientes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver pagos pendientes</button>
  <br> <br>
  <button name="opcion" value="historialDePagos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Historial de reservas/pagos</button>
  <br> <br>
  <button name="opcion" value="verPerfil" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mi perfil</button>
  <br> <br>
  <button name="opcion" value="modificarDatos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Modificar datos</button>
  <br> <br>
  <button name="opcion" value="enviarMensaje" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Chat</button>


</form>
<?php
require_once(VIEWS_PATH . "footer.php");
?>