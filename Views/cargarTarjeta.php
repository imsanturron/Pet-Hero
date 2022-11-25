<?php
require_once(VIEWS_PATH . "header.php");
?>
<a href="<?php echo FRONT_ROOT ?>Home/Index">Volver al home</a>

<div class="div-login"><br>
    <h1 class="text-login">Registro Guardian</h1>
</div>
<div class="div-login">
    <form action="<?php echo FRONT_ROOT ?>Guardian/add" method="post">

        <input class="input-login" type="text" name="nombreTarj" placeholder="Nombre* (como aparece en tarjeta)" minlength="2" required>
        <input name="numeroTarj" placeholder="Numero tarjeta*" pattern=".{16,16}" required title="16 numbers">
        <input class="input-login" type="number" name="Mvencimiento" placeholder="Mes vencimiento*" min="1" max="12" required>
        <input class="input-login" type="number" name="Avencimiento" placeholder="Año vencimiento*" min="1" max="99" required>
        <input class="input-login" type="number" name="codigoSeg" placeholder="Codigo de seguridad*" min="1" max="999" required>
        <button class="btn-login btn" type="submit">Aceptar</button>

    </form>
</div>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>