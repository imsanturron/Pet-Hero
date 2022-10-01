<?php 
    include_once('header.php');
?>


  <div class="div-login"><br>
    <h1 class="text-login">Login Dueño</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Dueno/verificar" method="post">
        
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <button class="btn-login btn" type="submit" name="">Ingresar</button>
     
    </form>
  </div>
</div>


<?php 
  include('footer.php');
?>