<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Selecccione con quien desea chatear</h2>
            <br>
            Buscar por nombre de usuario
            <?php if ($_SESSION["tipo"] == 'd') { ?>
                <form action="<?php echo FRONT_ROOT ?>Dueno/BuscarUsuario" method="POST">
                <?php } else { ?>
                    <form action="<?php echo FRONT_ROOT ?>Guardian/BuscarUsuario" method="POST">
                    <?php } ?>
                    <input class="input-login" type="text" name="username" placeholder="Username" minlength="1" required>
                    <button class="btn-login btn" type="submit">Buscar</button>
                    </form>
                    <br>
                    <?php if (!isset($buscaDeUsername)) { ?>
                        Todos los usuarios
                    <?php } ?>
                    <table class="table bg-light-alpha">
                        <thead>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Opcion</th>
                        </thead>
                        <tbody>
                            <?php if ($_SESSION["tipo"] == 'd') { ?>
                                <form action="<?php echo FRONT_ROOT ?>Dueno/EnviarNuevoMensaje" method="POST">
                                <?php } else { ?>
                                    <form action="<?php echo FRONT_ROOT ?>Guardian/EnviarNuevoMensaje" method="POST">
                                    <?php } ?>
                                    <?php
                                    if (isset($buscaDeUsername))
                                        echo "<b> usuarios mas similares al buscado:<b>";

                                    if (isset($listaUsuarios) && !empty($listaUsuarios)) {
                                        foreach ($listaUsuarios as $user) {
                                    ?>
                                            <tr>
                                                <td><?php echo $user->getNombre(); ?></td>
                                                <td><?php echo $user->getUserName(); ?></td>
                                                <td>
                                                    <button type="submit" name="dni" value="<?php echo $user->getDni(); ?>" class="btn btn-danger"> Elegir </button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo " <label><h2> no se encontraron guardianes para chatear </label></h2> ";
                                    }
                                    ?>
                                    </form>
                        </tbody>
                    </table>
        </div>
    </section>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>