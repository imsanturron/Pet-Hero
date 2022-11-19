<?php
require_once(VIEWS_PATH . "header.php");
?>
<div id="pageintro" class="hoc clear">
  <article class="center">
    <h3 class="heading underline">PetHero</h3>
    <p>Bienvenido a la mejor app de cuidado de mascotas</p>
  </article>
</div>
<form action="<?php echo FRONT_ROOT ?>Home/validarTipoDeUsuario" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
  <button name="usuario" value="login" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Login</button>
  <button name="usuario" value="Registrarsedueno" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Registro de dueño</button>
  <button name="usuario" value="Registrarseguardian" type="submit" class="btn" style="background-color:#DC8E47;color:white;">Registro de guardian</button>
  <div class="alert alert-<?php echo $alert->getTipo() ?>">
    <?php echo $alert->getMensaje() ?>
  </div>
</form>
<?php
require_once(VIEWS_PATH . "footer.php");
?>