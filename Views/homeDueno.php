<?php 
    include_once('header.php');
?>


  <div class="div-login"><br>
    <h1 class="text-login">Login Dueño</h1>
</div>
  <div class="div-login">  
<<<<<<< HEAD
    <form action="<?php echo FRONT_ROOT ?>Dueno/verificar" method="post">
        
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <button class="btn-login btn" type="submit" name="">Ingresar</button>
=======
    <form action="<?php echo FRONT_ROOT ?>Auth/Login" method="post">
        
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="hidden" name="tipo" value="d">
        <button class="btn-login btn" type="submit">Ingresar</button>
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
     
    </form>
  </div>
</div>


<?php 
  include('footer.php');
?>