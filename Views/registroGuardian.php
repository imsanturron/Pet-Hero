<?php 
    include_once('header.php');
<<<<<<< HEAD
    echo "okkk";
=======
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
?>

  <div class="div-login"><br>
    <h1 class="text-login">Registro Guardian</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Guardian/add" method="post">
        
<<<<<<< HEAD
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" required >
        <input class="input-login" type="text" name="cuil" placeholder="Cuil" required >
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="text" name="disponibilidad" placeholder="Disponibilidad" required >
        <input class="input-login" type="text" name="precio" placeholder="Precio" required >
=======
    <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" minlength="3" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" minlength="4" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" minlength="2" required >
        <input name="dni" placeholder="DNI"  pattern=".{6,12}" required title="6 to 12 characters">
        <input class="input-login" type="email" name="email" placeholder="Email" minlength="3" required >
        <input name="cuil" placeholder="Cuil" pattern=".{7,14}" required title="7 to 14 characters">
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="number" name="precio" placeholder="Precio" min="1" max="999999" required >
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
        <button class="btn-login btn" type="submit">Ingresar</button>
     
    </form>
  </div>
</div>

<?php 
  include('footer.php');
?>