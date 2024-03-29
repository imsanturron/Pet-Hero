<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<main class="py-5">
  <section id="listado" class="mb-5">
    <div class="container">
      <h2 class="mb-4">Generar review de Guardian</h2>
      <table class="table bg-light-alpha">
        <thead>
          <th>Opcion</th>
          <th>Nombre</th>
          <th>Usuario</th>
          <th>Precio</th>
          <th>Direccion</th>
          <th>Reputacion Actual</th>
          <th>Inicio reserva en comun</th>
          <th>Fin de reserva</th>
          <th>Mascotas cuidadas</th>
        </thead>
        <tbody>
          <form action="<?php echo FRONT_ROOT ?>Dueno/crearResena" method="POST">
            <?php
            $disponibilidad = false; //Sirve para alfinal verificar si habia guardianes o no en la fecha
            if (isset($ress) && !empty($ress)) {
              foreach ($ress as $reserva) {
                if ($reserva->getResHechaOrechazada() == false && $reserva->getCrearResena() == true) {
                  $guardian = $guardianDAO->GetByDni($reserva->getDniGuardian());

                  $count = 0;
                  foreach ($mascXres as $tabla) {
                    if ($tabla->getIdReserva() == $reserva->getId()) {
                      $idMascotaX = $tabla->getIdMascota();
                      foreach ($mascotas as $masc) {
                        if ($masc->getId() == $idMascotaX) {
                          $count++;
                        }
                      } //contar para hacer el rowspan
                    }
                  }
            ?>
                  <tr>
                    <td rowspan="<?php echo $count; ?>">
                      <button type="submit" name="operacion" value="crear-<?php echo $reserva->getId(); ?>-<?php echo $guardian->getDni(); ?>" class="btn btn-danger">Crear review </button>
                      <button type="submit" name="operacion" value="noCrear-<?php echo $reserva->getId(); ?>-<?php echo $guardian->getDni(); ?>" class="btn btn-danger">Omitir / no crear </button>
                    </td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getNombre(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getUserName(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getPrecio(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getDireccion(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getPuntajePromedio(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getFechaInicio(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getFechaFin(); ?></td>
                    <?php foreach ($mascXres as $tabla) {
                      if ($tabla->getIdReserva() == $reserva->getId()) {
                        $idMascotaX = $tabla->getIdMascota();
                        foreach ($mascotas as $masc) {
                          if ($masc->getId() == $idMascotaX) { ?>
                            <td><?php echo $masc->getNombre(); ?></td>
                  </tr>
    <?php
                          }
                        }
                      }
                    }
                  }
                }
              } else { ///podria haber if para q muestre esto tambien si no hay para crear
                echo " <label><h2>  No tiene reseñas por realizar </label></h2> ";
              }
    ?>


          </form>
        </tbody>
      </table>
      <div class="alert alert-<?php echo $alert->getTipo() ?>">
        <?php echo $alert->getMensaje() ?>
      </div>
    </div>
  </section>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>