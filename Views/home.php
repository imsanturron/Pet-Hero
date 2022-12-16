<?php
require_once(VIEWS_PATH . "header.php");
?>
<div id="pageintro" class="hoc clear">
  <article class="center">
    &nbsp; <!-- Espacio !--> 
    <h3 class="heading underline"><FONT SIZE=7>Pet Hero</font></h3>
    &nbsp; <!-- Espacio !--> 
    <h4 ><FONT SIZE=5>Bienvenido a la mejor app de cuidado de mascotas</font></h3>

  </article>
  &nbsp;  <!-- Espacio !--> 
</div >
&nbsp; &nbsp; &nbsp; <!-- Espacio !--> 
<form action="<?php echo FRONT_ROOT ?>Home/validarTipoDeUsuario" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
 <div class= "center">

  <button name="usuario"   value="login" type="submit" class="btn" style="background-color:#DC8E47;color:white;  
   width:300px; height:55px;" >Login</button>

  <button name="usuario" value="Registrarsedueno" type="submit" class="btn" style="background-color:#DC8E47;color:white;width:300px;height:55px;">Registro de dueño</button>
 
    <button name="usuario" value="Registrarseguardian" type="submit" class="btn" style="background-color:#DC8E47;color:white;width:300px; height:55px;">Registro de guardian</button>

  </div>
  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>
<?php
require_once(VIEWS_PATH . "footer.php");
?>