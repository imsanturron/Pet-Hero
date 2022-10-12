
<?php 
  include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Dueno/opcionMenuPrincipal" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
    <input type="submit" class="btn" value="verMascotas" name="opcion" placeholder="Ver mis mascotas" style="background-color:#DC8E47;color:white;" />
    <input type="submit" class="btn" value="agregarMascota" name="opcion" placeholder="Agregar mascotas" style="background-color:#DC8E47;color:white;" />
    <input type="submit" class="btn" value="verGuardianes" name="opcion" placeholder="Ver guardianes" style="background-color:#DC8E47;color:white;" />
    <input type="submit" class="btn" value="verPerfil" name="opcion" placeholder="Ver guardianes" style="background-color:#DC8E47;color:white;" />

</form>