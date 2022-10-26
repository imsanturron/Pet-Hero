<?php
include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="container clear">
    <div class="content">
      <div id="comments">
        <h2>Agregar mascota</h2>
        <form action="<?php echo FRONT_ROOT ?>Mascota/Add" method="post" style="background-color: #EAEDED;padding: 2rem !important;" enctype="multipart/form-data">
          <table>
            <thead>
              <tr>
                <th>nombre</th>
                <th>Raza</th>
                <th>Tamaño</th>
                <?php // <th>Imagen</th> ?>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="text" name="nombre" required>
                </td>
                <td>
                  <input type="text" name="raza" required>
                </td>
                <td>
                  <select name="tamano" required>
                    <option value="chico"> Chico </option>
                    <option value="mediano"> Mediano </option>
                    <option value="grande"> Grande </option>
                  </select>
                </td>
                <?php /*
                <td>
                  <input type="file" name="fotoM" required>
                </td>
                */ ?>
                <td>
                  <input type="text" name="observaciones">
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