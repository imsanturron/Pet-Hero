<?php   require_once(VIEWS_PATH."header.php"); ?>
<main class="content">

<div>

    <form action="<?php echo FRONT_ROOT."Dueno/modificarDatos"?>" method="post" >
    
            <h3><p>Modificar Informacion</p></h3>
       
                    
                    <input type="text" id="username" name="username" placeholder="Username">

                    <input type="text" id="password" name="password" placeholder="Password">       
                   
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">    
                    
                    <input type="text" id="email" name="email" placeholder="Email">
 
                    <input type="text" id="direccion" name="direccion" placeholder="Direccion">
                    
                    <input type="number" class="number" id="telefono" name="telefono" placeholder="Telefono">

       
              
                    <div >
                        <button class="formButton" type="submit"  >Modificar datos </button>
                        <button class="formButton" type="reset" >Borrar Todo </button>
                    
                    </div>    

    </form>


</div>

</main>
<?php   require_once(VIEWS_PATH."footer.php"); ?>
