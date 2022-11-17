<?php
require_once(VIEWS_PATH . "header.php");
?>
<a href="<?php echo FRONT_ROOT ?>Home/Index">Volver al home</a>

<div class="div-login"><br>
  <h1 class="text-login">Login</h1>
</div>
<div class="div-login">
  <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post">
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
    <input class="input-login" type="password" name="password" placeholder="Contraseña" required>
    <button class="btn-login btn" type="submit" name="">Ingresar</button>
  </form>
</div>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>