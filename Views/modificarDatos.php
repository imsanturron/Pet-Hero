<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="content">

    <div>

        <form action="<?php echo FRONT_ROOT . "Utils/modificarDatos" ?>" method="post">

                 
                <article class="center">
                <div class="div-login"><br>
                <h1 class="text-login"><FONT SIZE=7>Modificar Informacion</font></h1>
                <h1 class="text-login"><FONT SIZE=5> Lo que no quiera modificar dejarlo en blanco.</font></h1>
                </div>
                </article>

                <div >

            <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" minlength="3" style="height:35px" required>

            <input class="input-login" type="password" name="password" placeholder="Contraseña" minlength="4" style="height:35px" required>

            <input class="input-login" type="text" name="nombre" placeholder="Nombre" minlength="2" style="height:35px" required>

            <input class="input-login" type="email" name="email" placeholder="Email" minlength="3" style="height:35px" required>

            <input class="input-login" type="text" name="direccion" placeholder="Direccion" style="height:35px" required>

            <input name="telefono" placeholder="Telefono" pattern=".{6,20}" title="6 to 20 characters"style="height:35px" required>

            <div>
                <button class="formButton" type="submit" style="height:35px" required> Modificar datos </button>
                <button class="formButton" type="reset" style="height:35px" required> Limpiar campos </button>
            </div>
            </div>
           
        </form>
    </div>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>