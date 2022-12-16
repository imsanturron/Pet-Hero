<?php
require_once(VIEWS_PATH . "header.php");
?>
<a href="<?php echo FRONT_ROOT ?>Home/Index">Volver al home</a>

<article class="center">
<div class="div-login"><br>
  <h1 class="text-login"><FONT SIZE=7>Registro Dueño</font></h1>
</div>
</article>

<div class="div-login">
  <form action="<?php echo FRONT_ROOT ?>Dueno/add" method="post">
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario*" minlength="3" style="height:35px" required>
    <input class="input-login" type="password" name="password" placeholder="Contraseña*" minlength="4" style="height:35px"required>
    <input class="input-login" type="text" name="nombre" placeholder="Nombre*" minlength="2" style="height:35px" required>
    <input name="dni" placeholder="DNI*" pattern=".{6,12}" required title="6 to 12 characters"style="height:35px">
    <input class="input-login" type="email" name="email" placeholder="Email*" minlength="3" style="height:35px" required>
    <input class="input-login" type="text" name="direccion" placeholder="Direccion*" style="height:35px" required>
    <input name="telefono" placeholder="Telefono*" pattern=".{6,20}" required title="6 to 20 characters" style="height:35px">
    <br>
    <button class="btn-login btn" type="submit" style="height:55px" >Ingresar</button>
  </form>
</div>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>