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
                    <th>Disponibilidad actual</th>
                    <th>Precio</th>
                    <th>Reservas</th>
                    <th>Solicitudes</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Home/cambiarPerfil" method="POST">
                        <?php if (isset($_SESSION["loggedUser"])) { ?>
                            <td> <?php echo $_SESSION["loggedUser"]->getNombre() . "<br>"; ?> </td>
                            <td><?php echo $_SESSION["loggedUser"]->getUserName(); ?></td>
                            <td><?php echo "***"; ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getEmail(); ?></td>
                            <td><?php echo $_SESSION["loggedUser"]->getDireccion(); ?></td>
                            <td><?php if ($_SESSION["loggedUser"]->getDisponibilidadInicio()) {
                                    echo $_SESSION["loggedUser"]->getDisponibilidadInicio() .
                                        " hasta " . $_SESSION["loggedUser"]->getDisponibilidadFin();
                                } else {
                                    echo "no ha seleccionado disponibilidad";
                                } ?> </td>
                            <td><?php echo $_SESSION["loggedUser"]->getPrecio(); ?></td>
                            <td><a href="<?php echo FRONT_ROOT ?>Guardian/verReservas"> Apreta para ver</a></td>
                            <td><a href="<?php echo FRONT_ROOT ?>Guardian/verSolicitudes"> Apreta para ver</a></td>
                            </tr>
                        <?php } ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>