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

<form action="<?php echo FRONT_ROOT ?>Dueno/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
   
<div class="alert alert-<?php echo $alert->getTipo() ?>">
    <FONT SIZE=4.5 style="color:black;"><?php echo $alert->getMensaje()?></font> 
  </div>
  <br> <br>
  <button name="opcion" value="verMascotas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver mis mascotas</button>
  <br> <br>
  <button name="opcion" value="agregarMascota" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Agregar mascotas</button>
  <br> <br>
  <button name="opcion" value="verGuardianes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver guardianes disponibles</button>
  <br> <br>
  <button name="opcion" value="verSolicitudes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes enviadas</button>
  <br> <br>
  <button name="opcion" value="verReservas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis reservas</button>
  <br> <br>
  <button name="opcion" value="verSolicitudesAceptadasAPagar" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes aceptadas y reservas a pagar</button>
  <br> <br>
  <button name="opcion" value="generarNuevaReview" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Generar nueva review</button>
  <br> <br>
  <button name="opcion" value="historialDePagos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Historial de reservas/pagos</button>
  <br> <br>
  <button name="opcion" value="verPerfil" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mi perfil</button>
  <br> <br>
  <button name="opcion" value="modificarDatos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Modificar datos</button>
  <br> <br>
  <button name="opcion" value="enviarMensaje" type="submit" class="btn" style="background-color:#DC8E47;color:white;"> Chat </button>

 
</form>
<?php
require_once(VIEWS_PATH . "footer.php");
?>