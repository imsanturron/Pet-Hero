<?php

use DAO\MYSQL\MascotaDAO;
use Models\Mascota as Mascota;

include('nav-bar.php');
$mascota = new MascotaDAO;
$mascotas = $mascota->getMascotasByDniDueno($_SESSION["loggedUser"]->getDni());
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
                            <td> <a href="<?php echo FRONT_ROOT ?>Dueno/verMascotas"> Apreta para ver</a> </td>
                            </tr>
                        <?php } ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>