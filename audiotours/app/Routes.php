<?php


class Routes {
    function __construct(){
        //I btenemos la URL
        $componentesUrl=parse_url($_SERVER["REQUEST_URI"]);
        //sacamos solo la ruta del final, toda la dirección menos la parte del servivor
        $ruta=$componentesUrl["path"];
        //Obtenemos los partes de la ruta
        $partesRuta=explode("/", $ruta);
        //echo var_dump($partesRuta);
        $nparams=sizeof($partesRuta);
        //echo " nparams; ".$nparams."<br>";
        //echo "<p>".$nparams."</p>";
        //La estructura o las partes de ruta de una URL son las sisguientes:
        //http://PATHSERVER//controller/method/parameter1/parameter2..
         //Controlador definido
        //1.Comprobamos que existe el archivo controlador o la 1 parte de la ruta
        if (PRODUCTION==0){
            $controller="app/controllers/".$partesRuta[1]."Controller.php";
            //echo "Controlador: ".$controller."<br><br>";
            if (file_exists($controller)){
                require_once($controller);
                $class=$partesRuta[1]."Controller";
                $controller=new $class;
                if ($nparams==2){
                    $controller->index();
                }else if($nparams>2){
                    //Comprobamos que existe el método
                    if(method_exists($controller, $partesRuta[2])) {
                        if ($nparams>3){
                            //echo "<h3>Tienes mas de 3 parametros ".$nparams."</h3>";
                            $param=[];
                            for($i=3;$i<$nparams;$i++){
                                //echo "<h3>parametro ".$i.": ".$partesRuta[$i]."</h3>";
                                array_push($param,$partesRuta[$i]);
                            }
                            $controller->{$partesRuta[2]}($param); 
                        }else{
                            $controller->{$partesRuta[2]}(); 
                        }
                    }
                    else {
                        $errorController=new ErrorController();
                        $errorController->error("Method ".$partesRuta[2]." not found");
                    } 
                }
            }else{
                //otra posibilidad es mostrar un error
              
                //$errorController=new ErrorController();
                //$errorController->error("Controller/file not found: ".$controller);
               
                
                $controller="app/controllers/HomeController.php";
                require_once($controller);
                $controller=new HomeController();
                $controller->index();
                
            }
        //Si estamos en produccion o PRODUCCION==1
        }else{
            $controller="app/controllers/".$partesRuta[2]."Controller.php";
            //echo "Controlador: ".$controller."<br><br>";
            if (file_exists($controller)){
                require_once($controller);
                $class=$partesRuta[2]."Controller";
                $controller=new $class;
                if ($nparams==3){
                    $controller->index();
                }else if($nparams>3){
                    //echo "<h3>Mayor de 3</h3>";
                    //Comprobamos que existe el método
                    if(method_exists($controller, $partesRuta[3])) {
                        if ($nparams>3){
                            $param=[];
                            for($i=4;$i<$nparams;$i++){
                                //echo "<h3>parametro ".$i.": ".$partesRuta[$i]."</h3>";
                                array_push($param,$partesRuta[$i]);
                            }
                            //echo "<h3>Partes de ruta 3:  ".$partesRuta[3]."</h3>";
                            //echo "<h3>Param:  ".$param[0]."</h3>";
                            $controller->{$partesRuta[3]}($param); 
                        }else{
                            $controller->{$partesRuta[3]}(); 
                        }
                    }
                    else {
                        $errorController=new ErrorController();
                        $errorController->error("Method not found");
                    } 
                }
            }else{
                //otra posibilidad es mostrar un error
                //$errorController=new ErrorController();
                //$errorController->error("Controller/file not found: ".$controller);

                $controller="app/controllers/HomeController.php";
                require_once($controller);
                $controller=new HomeController();
                $controller->index();
            }
        }
    }//final construct
}//final clase