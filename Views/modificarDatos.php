<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="content">

    <div>

        <form action="<?php echo FRONT_ROOT . "Utils/modificarDatos" ?>" method="post">

            <h3>
                <p>Modificar Informacion</p>
            </h3>
            Lo que no quiera modificar dejarlo en blanco.

            <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" minlength="3">

            <input class="input-login" type="password" name="password" placeholder="Contraseña" minlength="4">

            <input class="input-login" type="text" name="nombre" placeholder="Nombre" minlength="2">

            <input class="input-login" type="email" name="email" placeholder="Email" minlength="3">

            <input class="input-login" type="text" name="direccion" placeholder="Direccion">

            <input name="telefono" placeholder="Telefono" pattern=".{6,20}" title="6 to 20 characters">

            <div>
                <button class="formButton" type="submit">Modificar datos </button>
                <button class="formButton" type="reset"> Limpiar campos </button>
            </div>

        </form>
    </div>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>