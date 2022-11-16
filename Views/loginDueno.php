<?php
require_once(VIEWS_PATH."header.php");
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Dueno/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
  <button name="opcion" value="verMascotas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver mis mascotas</button>
  <button name="opcion" value="agregarMascota" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Agregar mascotas</button>
  <button name="opcion" value="verGuardianes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver guardianes disponibles</button>
  <button name="opcion" value="verPerfil" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mi perfil</button>
  <button name="opcion" value="verSolicitudes" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes enviadas</button>
  <button name="opcion" value="verReservas" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Mis reservas</button>
  <button name="opcion" value="verSolicitudesAceptadasAPagar" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Solicitudes aceptadas y reservas a pagar</button>
  <button name="opcion" value="generarNuevaReview" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Generar nueva review</button>
  <button name="opcion" value="modificarDatos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Modificar datos</button>
  <button name="opcion" value="historialDePagos" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Ver historial de pagos</button>

  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>
<?php
require_once(VIEWS_PATH."footer.php");
?>