<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Dueno/filtrarFechas" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
    <B>
        <h1> INDIQUE LA FECHA EN LA QUE NECESITE UN GUARDIAN </h1>
        <FONT COLOR="black">Desde: </FONT>
        <input type="date" class="btn" name="desde" min="<?php echo date("Y-m-d") ?>" style="background-color:#DC8E47;color:white;" required />
        <br> <br>
        <B>
            <FONT COLOR="black">Hasta: </FONT>
            <input type="date" class="btn" name="hasta" min="<?php echo date("Y-m-d") ?>" style="background-color:#DC8E47;color:white;" required />
            <br> <br>
            <button type="submit" class="btn" style="background-color:#DC8E47;color:white;">Enviar</button>
</form>
<div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>