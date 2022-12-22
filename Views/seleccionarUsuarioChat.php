<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
    
        <article class="center">
                <div class="div-login"><br>
                <h1 class="text-login"><FONT SIZE=6>Selecccione con quien desea chatear</font></h1>
                </div>
        </article>
        
            <br>
           
            <h2 class="text-login"><FONT SIZE=4> Buscar por nombre de usuario</font></h1>
           
            <?php if ($_SESSION["tipo"] == 'd') { ?>
                <form action="<?php echo FRONT_ROOT ?>Dueno/BuscarUsuario" method="POST">
                <?php } else { ?>
                    <form action="<?php echo FRONT_ROOT ?>Guardian/BuscarUsuario" method="POST">
                    <?php } ?>
                    <input class="input-login" type="text" name="username" placeholder="Username" minlength="1" style="height:35px" required>
                    <button class="btn-login btn" type="submit" style="height:35px" >Buscar</button>
                    </form>
                    <br>
                    <br>

                    <?php if (isset($chatsNuevos) && !empty($chatsNuevos)) { ?>
                  
            <h2 class="text-login"><FONT SIZE=4> Tiene nuevos mensajes en los siguientes chats: </font></h2>
                        <table class="table bg-light-alpha">
                            <thead>
                                <th>Nombre</th>
                                <th>Opcion</th>
                            </thead>
                            <tbody>
                                <?php if ($_SESSION["tipo"] == 'd') { ?>
                                    <form action="<?php echo FRONT_ROOT ?>Dueno/EnviarNuevoMensaje" method="POST">
                                    <?php } else { ?>
                                        <form action="<?php echo FRONT_ROOT ?>Guardian/EnviarNuevoMensaje" method="POST">
                                        <?php } ?>
                                        <?php

                                        if (isset($chatsNuevos) && !empty($chatsNuevos)) {
                                            foreach ($chatsNuevos as $chat) {
                                        ?>
                                                <?php if ($_SESSION["tipo"] == 'd') { ?>
                                                    <tr>
                                                        <td><?php echo $chat->getNombreGuardian(); ?></td>
                                                        <td>
                                                            <button type="submit" name="dni" value="<?php echo $chat->getDniGuardian(); ?>" class="btn btn-danger"> Elegir </button>
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?php echo $chat->getNombreDueno(); ?></td>
                                                        <td>
                                                            <button type="submit" name="dni" value="<?php echo $chat->getDniDueno(); ?>" class="btn btn-danger"> Elegir </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                        <?php
                                            }
                                        } else {
                                            echo " <label><h2> No tiene nuevos chats por ver </label></h2> ";
                                        }
                                        ?>
                                        </form>
                            </tbody>
                        </table>
                        <br>
                        <br>
                    <?php } ?>

                    <?php if (!isset($buscaDeUsername)) { ?>
                        
            <h2 class="text-login"><FONT SIZE=4> Todos los usuarios: </font></h1>
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
                                        echo " <label><h2> no se encontraron usuarios para chatear, o tu busqueda
                                         no encontro similitudes </label></h2> ";
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