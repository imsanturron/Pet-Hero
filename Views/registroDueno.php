<?php 
    include_once('header.php');
    echo "okkk";
?>

  <div class="div-login"><br>
    <h1 class="text-login">Registro Dueño</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Dueno/add" method="post">
        
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" required >
        <input class="input-login" type="text" name="dni" placeholder="DNI" required >
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="text" name="telefono" placeholder="Telefono" required >
        <button class="btn-login btn" type="submit">Ingresar</button>
     
    </form>
  </div>
</div>

<?php 
  include('footer.php');
?>