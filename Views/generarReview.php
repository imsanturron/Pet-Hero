<?php
include('nav-bar.php');

use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;
use Models\Guardian as Guardian;
use Models\Reserva as Reserva;
use Models\Resena as Resena;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
  if ($_SESSION['tipo'] == 'g') {
    $guardian = $_SESSION['loggedUser'];
    $reservas = new ReservaDAO();
    $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
    $mascota = new MascotaDAO(); ///get all by id desp
    $mascotas = $mascota->GetAll(); ///get all by id desp
    $resXmascDAO = new ResxMascDAO();
    $mascXres = $resXmascDAO->GetAll();
    $guardianDAO = new GuardianDAO();
  }
}
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
                if ($reserva->getResHechaOrechazada() == false && $reserva->crearReserva() == true) {
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
                      <input type="hidden" name="idReserva" value="<?php echo $reserva->getId(); ?>">
                      <input type="hidden" name="idGuardian" value="<?php echo $guardian->getDni(); ?>">
                      <button type="submit" name="operacion" value="crear" class="btn btn-danger">Crear review </button>
                      <button type="submit" name="operacion" value="noCrear" class="btn btn-danger">Omitir / no crear </button>
                    </td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getNombre(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getUserName(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getPrecio(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php echo $guardian->getDireccion(); ?></td>
                    <td rowspan="<?php echo $count; ?>"><?php //php echo $guardianx->getReputacion(); 
                                                        ?></td>
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


///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
<input type="range" list="tickmarks" name="puntos">

<datalist id="tickmarks">
  <option value="0">
  <option value="10">
  <option value="20">
  <option value="30"> <? //elige valores del 1 al 100 
                      ?>
  <option value="40">
  <option value="50">
  <option value="60">
  <option value="70">
  <option value="80">
  <option value="90">
  <option value="100">
</datalist>

<input type="text-area" maxlength="700" name="observaciones">

<!--<? // <td> <a href="<?php echo FRONT_ROOT <?//Home/verMascotasSoliRes/<?php echo $solicitud->getId(); 
    ?> <?  //"> Ver mascotas</a> </td>  
        ?> -->

lsajasjsnajksnkasnksnkas
/*$fini = explode("-", $finic);
if ($ffin)
$ff = explode("-", $ffin);

if ($ffin && $despDeHoy == false) {

if ($fini[0] < $ff[0]) return true; else if ($fini[0]==$ff[0] && $fini[1] < $ff[1]) return true; elseif ($fini[0]==$ff[0] && $fini[1]==$ff[1] && $fini[2] <=$ff[2]) return true; else return false; } else if ($ffin==null) { $fechaHoy=date("Y-m-d", strtotime("now")); $compar=explode("-", $fechaHoy); ///echo $compar[3]; if ($compar[0] < $fini[0]) return true; else if ($compar[0]==$fini[0] && $compar[1] < $fini[1]) return true; elseif ($compar[0]==$fini[0] && $compar[1]==$fini[1] && $compar[2] <=$fini[2]) return true; else return false; ///seguir caso de las 2 fechas y verificar este } else if ($ffin && $despDeHoy==true) { return true; }*/