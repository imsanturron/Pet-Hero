<div class="wrapper row1">
  <header id="header" class="clear">
    <div id="logo" class="fl_left">
      <h1>PetHero</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <?php if (isset($_SESSION['loggedUser'])) { ?>
        <ul class="clear">
          <li class="active"><a class="drop" href="#">Actions</a>
            <ul>
              <?php if ($_SESSION['loggedUser']->getTipo() == 'd') { ?>
                <li><a href="<?php echo FRONT_ROOT ?>Dueno/login">Home</a></li>
              <?php } else { ?>
                <li><a href="<?php echo FRONT_ROOT ?>Guardian/login">Home</a></li>
              <?php } ?>
              <li><a href="<?php echo FRONT_ROOT ?>Auth/Logout">LOGOUT</a></li>
            </ul>
          </li>
        </ul>
      <?php } ?>
    </nav>
  </header>
</div>