<!-- Pasado al document-start hasta que consiga que funcione en producción -->

<!------------------------    BARRA DE INICIO --------------------------------->
<?php //require_once('views/templates/barrainicio.php'); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo PATHSERVER.'home';?>">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."about" ?>">About</a></li>
            <li class="nav-item"><a class="nav-link active" href="http://msx.tipolisto.es">msx.tipolisto.es</a></li>
         </ul>
    </div>




    <!--CONTROL DE USUARIOS -->

    <ul class="navbar-nav mr-4">
    <?php
        //Si no existe la sesión del usuario
        
        if(!isset($_SESSION['idusuario'])){
            echo"<li class='nav-item'><a class='nav-link active' href='".PATHSERVER."register'>Register</a></li><li><a class='nav-link active' href='".PATHSERVER."login'>Login</a></li>";
        }else{
            if($_SESSION['nivelaccesousuario']==0){
                $roll="Sin validar";
            }else { 
            if($_SESSION['nivelaccesousuario']==1){
                    $roll="Administrador";
            }else{
                    $roll="Usuario normal";
            }          
            } 
            
            echo "<li class='nav-item m-2'>User: ".$_SESSION['nombreusuario']."</li>";
            echo "<li class='nav-item'><a class='nav-link' href='".PATHSERVER."logout'>Logout</a></li>";
        }
        ?>
        </ul>




     <!--Busqyeda de games -->     
    <form class="d-flex" method=post action='<?php echo PATHSERVER; ?>"game/search' >
        <input class="form-control form-control me-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search" disabled>
        <button class="btn btn-outline-success" type="submit" name="submit" onclick="alert('disabled')" disabled>Search</button>
    </form>

  </div><!--fin clase container fluid -->
</nav>
<!------------------------   FIN DE BARRA DE INICIO --------------------------------->  