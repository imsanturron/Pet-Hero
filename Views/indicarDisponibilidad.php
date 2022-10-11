<?php 
  include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Guardian/elegirDisponibilidad" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
    <B><FONT COLOR="black">Desde; </FONT> 
    <input type="date" class="btn" name="desde" style="background-color:#DC8E47;color:white;" /> 
    <br> <br>
    <B><FONT COLOR="black">Hasta: </FONT>  
    <input type="date" class="btn"  name="hasta" style="background-color:#DC8E47;color:white;" />
    <br> <br>
    <button type="submit" class="btn"  style="background-color:#DC8E47;color:white;">Enviar</button>

</form>