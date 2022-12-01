<?php
require_once(VIEWS_PATH . "header.php");
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
                <th>Especie*</th>
                <th>Nombre*</th>
                <th>Raza*</th>
                <th>Tamaño*</th>
                <th>Imagen*</th>
                <th>Plan de vacunacion*</th>
                <th>Video</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <select name="especie" required>
                    <option value="gato"> Gato </option>
                    <option value="perro"> Perro </option>
                </td>
                <td>
                  <input type="text" name="nombre" required>
                </td>
                <td>
                  <select name="raza" required>
                    <option value="Terrier"> Terrier </option>
                    <option value="Abisinio"> Abisinio </option>
                    <option value="Akita"> Akita </option>
                    <option value="Airedale"> Airedale </option>
                    <option value="Basenji"> Basenji </option>
                    <option value="Balines"> Balines </option>
                    <option value="Beagle"> Beagle </option>
                    <option value="Bengala"> Bengala </option>
                    <option value="Border "> Border  </option>
                    <option value="Boxer"> Boxer </option>
                    <option value="Bulldog "> Bulldog  </option>
                    <option value="Cartujo"> Cartujo </option>
                    <option value="Cavalier"> Cavalier </option>
                    <option value="Chihuahua"> Chihuahua </option>
                    <option value="Cocker"> Cocker </option>
                    <option value="Collie"> Collie </option>
                    <option value="Dalmata"> Dalmata </option>
                    <option value="Doberman"> Doberman </option>
                    <option value="Dogo"> Dogo </option>
                    <option value="Gato esfinge"> Gato esfinge </option>
                    <option value="Galgo"> Galgo </option>
                    <option value="Golden"> Golden </option>
                    <option value="Gran danes"> Gran danes </option>
                    <option value="Husky"> Husky </option>
                    <option value="Labrador"> Labrador </option>
                    <option value="Pastor"> Pastor </option>
                    <option value="Pekines"> Pekines </option>
                    <option value="Persa"> Persa </option>
                    <option value="Pug"> Pug </option>
                    <option value="Mau egipcio"> Mau egipcio </option>
                    <option value="Ocicat"> Ocicat </option>
                    <option value="Rottweiler"> Rottweiler </option>
                    <option value="San Bernardo"> San Bernardo </option>
                    <option value="Shar Pei"> Shar Pei </option>
                    <option value="Staffordshire "> Staffordshire  </option>
                    <option value="Siames"> Siames </option>
                    <option value="Yorkshire"> Yorkshire </option>
                  </select>
                </td>
                <td>
                  <select name="tamano" required>
                    <option value="chico"> Chico </option>
                    <option value="mediano"> Mediano </option>
                    <option value="grande"> Grande </option>
                  </select>
                </td>
                <td>
                  <input type="file" name="fotoM" required>
                </td>
                <td>
                  <input type="file" name="planVacunacion" required>
                </td>
                <td>
                  <input type="file" name="video">
                </td>
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
<?php
require_once(VIEWS_PATH . "footer.php");
?>