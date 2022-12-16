<?php
require_once(VIEWS_PATH . "header.php");
?>
<a href="<?php echo FRONT_ROOT ?>Home/Index">Volver al home</a>

<article class="center">
<div class="div-login"><br>
<h1 class="heading underline"><FONT SIZE=7>Login</font></h1>
</article>
 


</div >
<div class="div-login">
  <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post" >
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario"style="height:35px" required>
    <br>
    <input class="input-login" type="password" name="password" placeholder="Contraseña" style="height:35px" required>
    <br>
    <button class="btn-login btn" type="submit" style="height:55px">Ingresar</button>
  </form>
</div>
</div>
</article>
<?php
require_once(VIEWS_PATH . "footer.php");
?>