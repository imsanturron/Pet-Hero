<?php 
    include_once('header.php');
?>


  <div class="div-login"><br>
    <h1 class="text-login">Login Guardian</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post">
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="hidden" name="tipo" value="g">
        <button class="btn-login btn" type="submit" name="">Ingresar</button>
      </form>
  </div>
</div>


<?php 
  include('footer.php');
?>