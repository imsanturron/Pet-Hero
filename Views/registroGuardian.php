<?php 
    include_once('header.php');
    echo "okkk";
?>

  <div class="div-login"><br>
    <h1 class="text-login">Registro Guardian</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Guardian/add" method="post">
        
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" required >
        <input class="input-login" type="text" name="cuil" placeholder="Cuil" required >
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="text" name="disponibilidad" placeholder="Disponibilidad" required >
        <input class="input-login" type="text" name="precio" placeholder="Precio" required >
        <button class="btn-login btn" type="submit">Ingresar</button>
     
    </form>
  </div>
</div>

<?php 
  include('footer.php');
?>