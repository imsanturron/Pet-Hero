<?php

use Config\Autoload as Autoload;
use DAO\MascotaDAO;

Autoload::Start();

$mascotasDao = new MascotaDAO();     
$listaMascotas = $mascotasDao->GetAll();

?>
<main class="py-5">
     
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Listado de mascotas</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Nombre</th>
                         <th>Raza</th>
                         <th>Tamaño</th>
                         <th>Observaciones</th>
                    </thead>
                    <tbody>
                         <form action="<?php echo FRONT_ROOT ?>Mascota/Remove" method="POST" >
                         <?php 
                              if(isset($listaMascotas) && !empty($listaMascotas)){
                                   
                                   foreach($listaMascotas as $mascota){
                                   ?> 
                                   <?php if($mascota->getdniDueno() == $_SESSION["loggedUser"]->getDni()){?>
                                        <tr> 
                                             <td><?php echo $mascota->getNombre(); ?></td>
                                             <td><?php echo "Raza: ".$mascota->getRaza(); ?></td>
                                             <td><?php echo $mascota->getTamano(); ?></td>
                                             <td><?php echo $mascota->getObservaciones(); ?></td>
                                             <td>
                                                  <button type="submit" name="btnRemove" class="btn btn-danger" value="123"> Eliminar </button>
                                             </td>
                                        </tr>
                                   <?php
                                   }}
                              }
                         ?>
                         </form>
                    </tbody>
               </table>
          </div>
     </section>

     <div class="container">
          <div class="bg-light-alpha p-1">
               <div class="row">
                    <div class="col-lg-3">
                         <div class="form-group text-white">
                              <label for="" class="ml-1"><b>IMPORTE TOTAL FACTURADO</b></label>
                              <input type="text" value="<?php echo 23; ?>" class="form-control ml-1 text-strong" disabled>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</main>

