<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<div class="wrapper row4">
  <main class="container clear">
    <div class="content">
      <div id="comments">
        <h2>Review de <?php echo $guardian->getNombre() ?></h2>
        <form action="<?php echo FRONT_ROOT ?>Dueno/asentarResena" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <input type="hidden" name="idReserva" value="<?php echo $reserva->getId(); ?>">
          <input type="hidden" name="dniGuard" value="<?php echo $guardian->getDni(); ?>">
          <table>
            <thead>
              <tr>
                <th>Puntaje</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="range" list="tickmarks" name="puntos" required>
                  <datalist id="tickmarks">
                    <option value="0">
                    <option value="10">
                    <option value="20">
                    <option value="30">
                    <option value="40">
                    <option value="50">
                    <option value="60">
                    <option value="70">
                    <option value="80">
                    <option value="90">
                    <option value="100">
                  </datalist>
                </td>
                <td>
                  <input type="text-area" maxlength="700" name="observaciones">
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;" />
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->
<div class="alert alert-<?php echo $alert->getTipo() ?>">
  <?php echo $alert->getMensaje() ?>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>