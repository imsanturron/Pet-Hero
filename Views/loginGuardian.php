<?php
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Guardian/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
  <button name="opcion" value="indicarDisponibilidad" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Indicar mi disponibilidad</button>
  <button name="opcion" value="verListadReservas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis reservas</button>
  <button name="opcion" value="verPerfil" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis perfil</button>
  <button name="opcion" value="verSolicitudes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver solicitudes</button>
  <button name="opcion" value="verPrimerosPagosPendientes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver pagos pendientes</button>
  <button name="opcion" value="cambiarTamanoACuidar" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Cambiar mi tamaño a cuidar</button>

  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>