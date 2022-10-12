<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
<<<<<<< HEAD
      <h1>PETSHOP</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <li><a href="">ADD</a></li>
            <li><a href="">LIST/REMOVE</a></li>
      </ul>
=======
      <h1>PetHero</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <?php if(isset($_SESSION['loggedUser'])) { ?>
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <?php if($_SESSION['loggedUser']->getTipo() == 'd') { ?>
            <li><a href="<?php echo FRONT_ROOT ?>Dueno/login">Home</a></li>
            <?php } else{ ?>
            <li><a href="<?php echo FRONT_ROOT ?>Guardian/login">Home</a></li>
            <?php } ?>
            <!--<li><a href="<?php // echo FRONT_ROOT ?>Service/List">LIST</a></li>-->
            <li><a href="<?php echo FRONT_ROOT ?>Auth/Logout">LOGOUT</a></li>
          </ul>
        </li>
      </ul>
      <?php } ?>
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    </nav>
  </header>
</div>