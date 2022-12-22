<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            
        
        <article class="center">
                <div class="div-login"><br>
                <h1 class="text-login"><FONT SIZE=6>Mi perfil</font></h1>
                </div>
        </article>
        

            

            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>User</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Mascotas</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Home/cambiarPerfil" method="POST">
                        <?php if (isset($_SESSION["loggedUser"])  && $_SESSION["tipo"] == 'd') { ?>
                            <td> <?php echo $_SESSION["loggedUser"]->getNombre() . "<br>"; ?> </td>
                            <td><?php echo $_SESSION["loggedUser"]->getUserName(); ?></td>
                            <td><?php echo "***"; ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getEmail(); ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getDireccion(); ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getTelefono(); ?></td>
                            <td> <a href="<?php echo FRONT_ROOT ?>Dueno/verMascotas"> Apreta para ver</a> </td>
                            </tr>
                        <?php } ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>
    <?php
    require_once(VIEWS_PATH . "footer.php");
    ?>