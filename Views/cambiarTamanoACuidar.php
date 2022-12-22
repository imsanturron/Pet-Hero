<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');

if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == 'g') {
?>
    <div class="wrapper row4">
        <main class="container clear">
            <div class="content">
                <div id="comments">
                    
                        
                <article class="center">
                <div class="div-login"><br>
                <h1 class="text-login"><FONT SIZE=7>Cambiar tamaño</font></h1>
                <h1 class="text-login"><FONT SIZE=5> ¡ATENCION! Este cambio no influye sobre tus reservas actuales o futuras.</font></h1>
                </div>
                </article>
                   
                    <form action="<?php echo FRONT_ROOT ?>Guardian/cambiarTamanoAResguardar" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
                        <?php if ($guardian->getTamanoACuidar() == "chico") { ?>
                            <select name="tamanoMasc" style="height:35px" required>
                                <option value="mediano"> Mediano </option>
                                <option value="grande"> Grande </option>
                            </select>
                        <?php } else if ($guardian->getTamanoACuidar() == "mediano") { ?>
                            <select name="tamanoMasc" style="height:35px" required>
                                <option value="chico"> Chico </option>
                                <option value="grande"> Grande </option>
                            </select>
                        <?php } else if ($guardian->getTamanoACuidar() == "grande") { ?>
                            <select name="tamanoMasc"  style="height:35px" required>
                                <option value="chico"> Chico </option>
                                <option value="mediano"> Mediano </option>
                            </select>
                        <?php }  ?>
                        <button class="btn-login btn" type="submit" style="height:35px">Ingresar</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
<?php }
?>
<!-- ################################################################################################ -->
<div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>