<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Guardian/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
  <button name="opcion" value="indicarDisponibilidad" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Indicar mi disponibilidad</button>
  <button name="opcion" value="cambiarTamanoACuidar" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Cambiar mi tamaño a cuidar</button>
  <button name="opcion" value="verSolicitudes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes recibidas</button>
  <button name="opcion" value="verListadReservas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis reservas</button>
  <button name="opcion" value="verPrimerosPagosPendientes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver pagos pendientes</button>
  <button name="opcion" value="historialDePagos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Historial de reservas/pagos</button>
  <button name="opcion" value="verPerfil" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mi perfil</button>
  <button name="opcion" value="modificarDatos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Modificar datos</button>
  <button name="opcion" value="enviarMensaje" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Chat</button>

  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>
<?php
require_once(VIEWS_PATH . "footer.php");
?>