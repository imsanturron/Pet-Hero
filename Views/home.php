<?php
require_once(VIEWS_PATH."header.php");
?>
<div id="pageintro" class="hoc clear">
  <article class="center">
    <h3 class="heading underline">PetHero</h3>
    <p>texto....................................</p>
  </article>
</div>
<form action="<?php echo FRONT_ROOT ?>Home/validarTipoDeUsuario" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
  <input type="submit" class="btn" value="login" name="usuario" style="background-color:#DC8E47;color:white;" />
  <input type="submit" class="btn" value="Registrarse dueño" name="usuario" style="background-color:#DC8E47;color:white;" />
  <input type="submit" class="btn" value="Registrarseguardian" name="usuario" style="background-color:#DC8E47;color:white;" />
</form>
<?php
require_once(VIEWS_PATH."footer.php");
?>