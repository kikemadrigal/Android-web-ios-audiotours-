<?php
    header('Content-Type: application/json');
    include_once("../app/database/MysqliClient.php");
    require_once("../app/config/env.php");
    $usuario=$_POST['user'];
    $clave=$_POST['password'];
    $maxScore=$_POST['score'];
    $basededatos= new MysqliClient();
    $basededatos->conectar_mysql();
    //1. Obtenemos el usuario por su nombre
    $consulta  = "SELECT * FROM users WHERE name='".$usuario."' ";
    $resultado=$basededatos->ejecutar_sql($consulta);
    $total_registros = mysqli_num_rows ($resultado);
    if($total_registros==false){
        //El nombre de usuario no existe.
        $mensaje= "0";
    }else{
        while ($linea = mysqli_fetch_array($resultado )) 
        {
            if($linea['name']==$usuario){
                //2.Comprobamos su contraseña
                if($linea['password']==sha1($clave)){
                    //Si el usurio no está validado...
                    if( $linea['validate'] == '0'){
                        //El usuario necesita ser validado para continuar, vaya a:PATHSERVER."auth/mailValidation/".$linea['name']."/".$linea['password'];
                        $mensaje="3";
                    //Si el usurio si está validado...
                    }else{
                        /*
                        `id` int(10)  NOT NULL AUTO_INCREMENT,
                        `name` varchar(100),
                        `score` int(10),
                        `date` timestamp ,
                        */
                        $fecha = new DateTime();
                        $bd= new MysqliClient();
                        $bd->conectar_mysql();
                        //Comprobamos que ya tiene puntuaciones más altas
                        $sqlMaxPointsUser="SELECT score from scores WHERE name='".$usuario."'";
                        $resultadoMaxPointsUser=$basededatos->ejecutar_sql($sqlMaxPointsUser);
                        $encontradaPuntacionMaximaGuardada=false;
                        while ($lineaMaxPoint = mysqli_fetch_array($resultadoMaxPointsUser)) 
                        {
                            if($maxScore<=$lineaMaxPoint['score']){
                                $mensaje=5;
                                $encontradaPuntacionMaximaGuardada=true;
                            } 
                            
                        }   
                        if(!$encontradaPuntacionMaximaGuardada){
                            $sql="INSERT INTO scores (name, score) VALUES ('".$usuario."', '".$maxScore."')";
                            $success=$bd->ejecutar_sql($sql);
                            $bd->desconectar(); 
                            if($success){
                                $mensaje="1"; 
                            }else{
                                $mensaje="4"; 
                            }    
                        }  





                 
                    
                        //usuario validado, grabamos el score ".$maxScore;  
                         

                    }
                }else{
                    //"La clave del usuario ".$usuario." es incorrecta.<br>";
                    $mensaje="2";
                }
            }
        }
    }
    $basededatos->desconectar();
    $data= json_encode($mensaje);  
    echo $data."\n";
?>