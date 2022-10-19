<?php 
    include_once('header.php');
?>
<a href="<?php echo FRONT_ROOT ?>Home/Index">Volver al home</a>

  <div class="div-login"><br>
    <h1 class="text-login">Registro Guardian</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Guardian/add" method="post">
        
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" minlength="3" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" minlength="4" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" minlength="2" required >
        <input name="dni" placeholder="DNI"  pattern=".{6,12}" required title="6 to 12 characters">
        <input class="input-login" type="email" name="email" placeholder="Email" minlength="3" required >
        <input name="cuil" placeholder="Cuil" pattern=".{7,14}" required title="7 to 14 characters">
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="number" name="precio" placeholder="Precio" min="1" max="999999" required >
        <button class="btn-login btn" type="submit">Ingresar</button>
     
    </form>
  </div>
</div>

<?php 
  include('footer.php');
?>