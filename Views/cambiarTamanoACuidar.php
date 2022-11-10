<?php
include('nav-bar.php');

use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ReservaDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use DAO\MYSQL\SolixMascDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Mascota as Mascota;

if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == 'g') {
    $guardianDAO = new GuardianDAO;
    $guardian = $guardianDAO->GetByDni($_SESSION["dniguard"]);
?>
    <div class="wrapper row4">
        <main class="container clear">
            <div class="content">
                <div id="comments">
                    <h2>Cambiar tamaño</h2>
                    <label>¡ATENCION! Este cambio no influye sobre tus reservas actuales o futuras</label>
                    <form action="<?php echo FRONT_ROOT ?>Guardian/cambiarTamanoAResguardar" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
                        <?php if ($guardian->getTamanoACuidar() == "chico") { ?>
                            <select name="tamanoMasc" required>
                                <option value="mediano"> Mediano </option>
                                <option value="grande"> Grande </option>
                            </select>
                        <?php } else if ($guardian->getTamanoACuidar() == "mediano") { ?>
                            <select name="tamanoMasc" required>
                                <option value="chico"> Chico </option>
                                <option value="grande"> Grande </option>
                            </select>
                        <?php } else if ($guardian->getTamanoACuidar() == "grande") { ?>
                            <select name="tamanoMasc" required>
                                <option value="chico"> Chico </option>
                                <option value="mediano"> Mediano </option>
                            </select>
                        <?php }  ?>
                        <button class="btn-login btn" type="submit">Ingresar</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
<?php } /////////// 
?>
<!-- ################################################################################################ -->
<div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
</div>