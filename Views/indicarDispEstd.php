
<?php 
  include('nav-bar.php');
?>
<form action="<?php echo FRONT_ROOT ?>Guardian/elegirDisponibilidad" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
<B><FONT COLOR="black">Desde; </FONT> 
 <input type="date" class="btn" value="desde" style="background-color:#DC8E47;color:white;" /> 
    <br> <br>
    <B><FONT COLOR="black">Hasta: </FONT>  <input type="date" class="btn"  value="hasta"  style="background-color:#DC8E47;color:white;" />
    <br> <br>
    <input type="submit" class="btn"  placeholder="Enviar" style="background-color:#DC8E47;color:white;" />

</form>