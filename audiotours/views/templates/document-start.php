<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="AudioTour" />
    <meta name="author" content="tipolisto.es">
    <meta name="description" content="Audios to listen while seeing tourist places or tourist atractions">
    <meta name="generator" content="Bootstrap" />
	<meta name="keywords" content="Guia turístico tour guide audio" />
    <link rel="icon" type="image/png" href="<?php echo PATHIMAGES ?>icon.ico" />
	<title><?php echo APPNAME; ?></title>
    <!--<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>-->
    <!-- Bootstrap:5.3, para trabajar con boostrap necesitas incluir 2 líneas más (pooper y su librería js)=https://getbootstrap.com/docs/5.3/getting-started/introduction/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!--Font awesome CDN para kikemadrigal: https://fontawesome.com/icons-->
    <!--<script src="https://use.fontawesome.com/9db6168ffb.js"></script>-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
    <link href="<?php echo PATHCSS; ?>styles.css" rel="stylesheet">
  </head>
  <body>
  	<!--<div class="container">-->


        <!------------------------    BARRA DE INICIO --------------------------------->
        <?php //require_once('views/templates/barrainicio.php'); ?>
        <!--Para el estudi de navBar: https://getbootstrap.com/docs/5.0/components/navbar/-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand ms-4" href="<?php echo PATHSERVER.'home';?>"><img src="<?php echo PATHIMAGES ?>ico.ico" width='32px' > <?php echo APPNAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."Tour/showAll" ?>"><i class="fa-solid fa-list"></i>  List tours</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo PATHSERVER."About" ?>"><i class="fa-solid fa-address-card"></i>  About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="https://blog.audiotours.es" target="_blanck"><i class="fa-solid fa-align-left"></i>  Blog </a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa-solid fa-share-nodes"></i> Social</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-brands fa-twitter"></i> Twitter</a></li>
                            <li><a class="dropdown-item" href="email:adm@audiotours.es"><i class="fa-solid fa-envelope"></i> Email</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa-brands fa-apple"></i>  Apps</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fa-brands fa-android"></i> Android</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa-brands fa-apple"></i> Iphone</a></li>
                        </ul>
                    </li>

                </ul>
        
                <!--CONTROL DE USUARIOS -->
                <ul class="navbar-nav mx-2">
                <?php
                //Si no existe la sesión del usuario
                if(!isset($_SESSION['idusuario'])){
                    echo"<li class='nav-item'><a class='nav-link active' href='".PATHSERVER."Auth/register'>Register</a></li><li><a class='nav-link active' href='".PATHSERVER."Auth/login'>Login</a></li>";
                }else{
                    if($_SESSION['nivelaccesousuario']==0){
                        $roll="Sin validar";
                    }else { 
                        if($_SESSION['nivelaccesousuario']==1){
                                $roll="Administrador";
                                echo "<li class='nav-item m-2 text-white'>Admin: ".$_SESSION['nombreusuario']."</li>";
                        }else{
                                $roll="Usuario normal";
                                echo "<li class='nav-item m-2 text-white'>User: ".$_SESSION['nombreusuario']."</li>";
                        }          
                    } 
                    echo "<li class='nav-item m-2'><a href='".PATHSERVER."Auth/logout' class='text-white ' >Logout</a></li>";
                }
             
                ?>
                </ul>
            



                <!--Busqyeda de tours -->     
                <form class="d-flex my-auto" method=post action='<?php echo PATHSERVER; ?>Tour/search' >
                    <input class="form-control " type="search" name="search" id="search" placeholder="Search" aria-label="Search" ></input>
                    <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                </form>
            </div><!--Final del div del collapse o de uls-->    
        </div><!--fin clase container fluid -->
        </nav>
        <!------------------------   FIN DE BARRA DE INICIO --------------------------------->  








        <!------------------------    BARRA DE MENU USUARIO --------------------------------->
        <?php  //include_once('barramenu.php');?>    
        <?php 
        if(isset($_SESSION['idusuario']) && $_SESSION['nivelaccesousuario']==3){
            //Si el usuario es un administrador
            if($_SESSION['nivelaccesousuario']==1){
                ?>
                    <nav aria-label="breadcrumb">
                        <ol class='breadcrumb'>
                            <!--Estos enlaces van a la direccion http://www.gestorwebs.tipolisto.es/gestionarwebs.php?idCategoria=66 por ejemplo
                            Pero han sido sobreescritos con mod_rewrite del archivo .htacces fichero de configuración de apache-->
                            <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>Tour/showAll'>Tours</a></li>
                            <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>User/showAll'>Users</a></li>
                        </ol> 
                        <form class="d-flex col-md-4" method=post action='<?php echo PATHSERVER; ?>Tour/searchUser'>
                            <input class="form-control" type="search" name="search" id="search" placeholder="Search your Tours" aria-label="search your games">
                            <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                        </form> 
                    </nav>
                <?php                   
                }
            ?>
                <nav aria-label="breadcrumb">
                    <ol class='breadcrumb'>
                        <!--Estos enlaces van a la direccion http://www.gestorwebs.tipolisto.es/gestionarwebs.php?idCategoria=66 por ejemplo
                        Pero han sido sobreescritos con mod_rewrite del archivo .htacces fichero de configuración de apache-->
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>Tour/showAllByUser'>My favourites</a></li>
                        <li class="breadcrumb-item"><a href='<?php echo PATHSERVER ?>User/update'>My data</a></li>
                    </ol> 
                    <form class="d-flex col-md-4" method=post action='<?php echo PATHSERVER; ?>Tour/searchUser'>
                        <input class="form-control" type="search" name="search" id="search" placeholder="Search your Tours" aria-label="search your games">
                        <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                    </form> 
                </nav>
            <?php                   
            
        }//Fin de sesion
        ?>
        <!------------------------    FIN DE BARRRA DE USUARIO --------------------------------->





         
   
   <!--<div class="col-xs-12 col-sm-8 col-md-10">-->
   <!--<div class="mueble">-->

   <div class="container">