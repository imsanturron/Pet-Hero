<?php
include('nav-bar.php');
?>
<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Mi perfil</h2>
            <small>Tu perfil</small>
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
                        <?php if (isset($_SESSION["loggedUser"])) { ?>
                            <td> <?php echo $_SESSION["loggedUser"]->getNombre() . "<br>"; ?> </td>
                            <td><?php echo $_SESSION["loggedUser"]->getUserName(); ?></td>
                            <td><?php echo "***"; ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getEmail(); ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getDireccion(); ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getTelefono(); ?></td>
                            <td><?php if ($_SESSION["loggedUser"]->getMascotas())
                                    print_r($_SESSION["loggedUser"]->getMascotas());
                                else
                                    echo "No hay mascotas cargadas";
                                ?></td>
                            </tr>
                        <?php } ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>