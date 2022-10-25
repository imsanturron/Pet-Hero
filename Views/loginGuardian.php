<?php
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Guardian/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">

  <input type="submit" class="btn" value="indicarDisponibilidad" name="opcion" placeholder="Ver mis mascotas" style="background-color:#DC8E47;color:white;" />
  <input type="submit" class="btn" value="verListadReservas" name="opcion" placeholder="Agregar mascotas" style="background-color:#DC8E47;color:white;" />
  <input type="submit" class="btn" value="verPerfil" name="opcion" placeholder="Ver guardianes" style="background-color:#DC8E47;color:white;" />
  <input type="submit" class="btn" value="verSolicitudes" name="opcion" placeholder="Ver Solicitudes" style="background-color:#DC8E47;color:white;" />

  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>