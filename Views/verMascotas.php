<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<main class="py-5">

     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Listado de mascotas:</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Nombre</th>
                         <th>Raza</th>
                         <th>Tamaño</th>
                         <th>Observaciones</th>
                         <th>Foto</th>
                         <th>Plan de vacunacion</th>
                         <th>Video</th>
                         <th>Opcion</th>
                    </thead>
                    <tbody>
                         <form action="<?php echo FRONT_ROOT ?>Mascota/Remove" method="POST">
                              <?php
                              if (isset($listaMascotas) && !empty($listaMascotas)) {
                                   foreach ($listaMascotas as $mascota) {
                              ?>
                                        <tr>
                                             <td><?php echo $mascota->getNombre(); ?></td>
                                             <td><?php echo $mascota->getRaza(); ?></td>
                                             <td><?php echo $mascota->getTamano(); ?></td>
                                             <td><?php echo $mascota->getObservaciones(); ?></td>
                                             <td><img src="<?php echo FRONT_ROOT . IMG_PATH . $mascota->getFotoMascota() ?>" style="width:680px;height:auto;"></td>
                                             <td><img src="<?php echo FRONT_ROOT . IMG_PATH . $mascota->getPlanVacunacion() ?>" style="width:680px;height:auto;"></td>
                                             <td>
                                                  <?php if ($mascota->getVideo()) { ?>
                                                       <video controls width="220" height="140">
                                                            <source src="<?php echo FRONT_ROOT . VIDEO_PATH . $mascota->getVideo() ?>" type="video/mp4">
                                                       </video>
                                                  <?php } ?>
                                             </td>
                                             <td>
                                                  <button type="submit" name="id" value="<?php echo $mascota->getId(); ?>" class="btn btn-danger" ?> Eliminar </button>
                                             </td>
                                        </tr>
                              <?php
                                   }
                              } else
                                   echo "<h2>No tiene mascotas cargadas!</h2>";
                              ?>
                         </form>
                    </tbody>
               </table>
          </div>
     </section>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>