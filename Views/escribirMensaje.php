<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Dueno/enviarNuevoMensaje" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
    <B>
        <h1> Escriba el mensaje  </h1>
        <FONT COLOR="black">Escribi Mensaje: </FONT>
        <textarea name="mensaje" style="background-color:#DC8E47;color:white;"  cols="30" rows="10"  required ></textarea>
      
        <br> <br>
   
        <input type="hidden" name="dni" value="<?php echo $dni;?>"> <?php //aca se manda el dni del guardian que eligio ?>
        <button type="submit" class="btn" style="background-color:#DC8E47;color:white;">Enviar</button>
</form>
<div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>