<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<?php if ($_SESSION["tipo"] == 'd') { ?>
    <form action="<?php echo FRONT_ROOT ?>Dueno/EnviarNuevoMensaje" method="POST" style="background-color: #EAEDED;padding: 2rem !important;">
    <?php } else { ?>
        <form action="<?php echo FRONT_ROOT ?>Guardian/EnviarNuevoMensaje" method="POST" style="background-color: #EAEDED;padding: 2rem !important;">
        <?php } ?>
        <B>
            <?php
            if (isset($historialMensajes) && !empty($historialMensajes)) {
                foreach ($historialMensajes as $msj) {
                    if ($msj->getSenderMsj() == 'd') {
                        echo "<p style='color:red;'>" . $msj->getFecha() . "<br>";
                        echo "<p style='color:red;'>" . $chat->getNombreDueno() . ": " . $msj->getMensaje() . "<br><br>";
                    } else {
                        echo "<p style='color:green;'>" . $msj->getFecha() . "<br>";
                        echo "<p style='color:green;'>" . $chat->getNombreGuardian() . ": " . $msj->getMensaje() . "<br><br>";
                    }
                }
            }
            ?>
            <input type="hidden" name="dni" value="<?php echo $dni; ?>">
            <br>
            <FONT COLOR="black"> Escriba aqui: </FONT>
            <textarea name="mensaje" style="background-color:#DC8E47;color:white;" cols="110" rows="8" required></textarea>

            <br> <br>


            <button type="submit" class="btn" style="background-color:#DC8E47;color:white;"> Enviar </button>
        </form>

        <div class="alert alert-<?php echo $alert->getTipo() ?>">
            <?php echo $alert->getMensaje() ?>
        </div>
        <?php
        require_once(VIEWS_PATH . "footer.php");
        ?>