
<?php 
  include('nav-bar.php');
?>
<?php

use Config\Autoload as Autoload;
use DAO\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;

Autoload::Start();
if(isset($_SESSION['loggedUser'])){
    $guardian=$_SESSION['loggedUser'];
    $solicitudes=$guardian->getSolicitudes();
}
?>
<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Solicitudes de dueños</h2>
            <table class="table bg-light-alpha">
            <?php if (isset($solicitudes) && !empty($solicitudes)) {
                        ?>  
              <thead>
                    <th>Nombre</th>
                    <th>Direccion</th>
       
                </thead>
                <tbody>
                    <form action="" method="">
                        <?php
                            foreach ($solicitudes as $solicitud) {     
                        ?>
                                <tr>
                                   <td><?php  echo $solicitud->getNombreDueño(); ?></td>
                                   <td><?php echo $solicitud->getDireccion(); ?></td>
    
                            <?php }?>
                    
                        <?php }else{
                            echo "NO TIENE SOLICITUDES"; }
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
                
                </div>
            </div>
        </div>
    </div>
</main>