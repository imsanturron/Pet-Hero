<?php 
    include_once('header.php');
<<<<<<< HEAD
    echo "okkk";
=======
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
?>

  <div class="div-login"><br>
    <h1 class="text-login">Registro Dueño</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT ?>Dueno/add" method="post">
<<<<<<< HEAD
        
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" required >
        <input class="input-login" type="text" name="dni" placeholder="DNI" required >
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input class="input-login" type="text" name="telefono" placeholder="Telefono" required >
        <button class="btn-login btn" type="submit">Ingresar</button>
     
=======
        <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" minlength="3" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" minlength="4" required >
        <input class="input-login" type="text" name="nombre" placeholder="Nombre" minlength="2" required >
        <input name="dni" placeholder="DNI"  pattern=".{6,12}" required title="6 to 12 characters">
        <input class="input-login" type="email" name="email" placeholder="Email" minlength="3" required >
        <input class="input-login" type="text" name="direccion" placeholder="Direccion" required >
        <input name="telefono" placeholder="Telefono"  pattern=".{6,20}" required title="6 to 20 characters">
        <button class="btn-login btn" type="submit">Ingresar</button>
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    </form>
  </div>
</div>

<?php 
  include('footer.php');
?>