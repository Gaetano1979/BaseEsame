<?php
//session_start();
require('../php/access.php');
require('../php/tablas.php');
require('../php/lib.php');
require('../php/dati.php');

$email=$_POST['username'];
$password=$_POST['password'];
/*$email='gaetano@mail.com';
$password='Gaetano1979';*/

$con = new Conector($host,$user,$pas);
$response['conessione']=$con->Conessione();

if ($response['conessione']=="OK") {

  if ($con->nueva_DB($db)) {
    $response['con_db']=$con->initConessione($db);
  }else {
    $response['con_db']='No hay Conessione con la DATABASE';
  }

  if ($response['con_db']=='OK') {
    if ($con->nueva_tabla($tabla_usuarios,$dati_usuario)) {
      $response['tabla_us']='Tabla creada';
    }else $response['tabla_us']='No hay Conessione con la tabla';
    if ($con->nueva_tabla($tabla_eventos,$dati_eventos)) {
      $response['tabla_ev']='Tabla creada';
    }else $response['tabla_ev']='No hay Conessione con la tabla';

    if ($con->nuevaRelacion($tabla_eventos,$tabla_usuarios,'fk_usuario','id')) {
      $response['rel']='riuscita';
    }else $response['rel']='non riuscita';

    if ($con->insertData($tabla_usuarios,$dati_usuarios_uno)) {
      $response['datos_1']='inserito';
    }else $response['datos_1']='no inserito';
    if ($con->insertData($tabla_usuarios,$dati_usuarios_due)) {
      $response['datos_2']='inserito';
    }else $response['datos_2']='no inserito';
    if ($con->insertData($tabla_usuarios,$dati_usuarios_tres)) {
      $response['datos_3']='inserito';
    }else $response['datos_3']='no inserito';

    //$resultado_consulta=$con->consultar([$tabla_usuarios],['email,pasw'],' WHERE email="'.$_POST['username'].'"');
    $resultado_consulta=$con->consultar([$tabla_usuarios],['email,pasw,id'],' WHERE email="'.$email.'"');
        /*while ($fila=$resultado_consulta->fetch_assoc()) {
          echo "Los elementos encontrados son ".$fila['email']." y ".$fila['pasw']."<br>";
          if (password_verify($password,$fila['pasw'])) {
            echo "La password ".$password." coresponde " ;
            $response['password']='coresponde';
            $response['acceso']='concedido';
          }else {
            echo "la password no coresponde";
            $response['password']='no coresponde';
            $response['acceso']='denegado';
        }
        echo "Se han consultado los datos corectamente <br>";
      }

    }else echo "Se ha podido consultar los datos <br>";*/



    if ($resultado_consulta->num_rows !=0) {
      $fila = $resultado_consulta->fetch_assoc();
      if (password_verify($_POST['password'],$fila['pasw'])) {
      //if (password_verify('Gaetano1979',$fila['pasw'])) {
      //echo "La ".$password."corresponde";
        $response['password']='corisponde';
        $response['acceso']='concedido';
        if($_SESSION['username']=$fila['email']){
          session_start();
          $response['sessione']="sessione avenuta";
          $_SESSION['username']=$fila['email'];
          $_SESSION['id']=$fila['id'];
          //echo "La sessiones se han capturados".$_SESSION['username']." ".$_SESSION['id'];
        }

      }else{
        $response['motivo']='Contraseña incorecta';
        $response['acesso']='rechazado';
      }
    }else{
      $response['motivo']='Email incorecto';
      $response['acesso']='rechazado';
    }
  }
}else $response['conessione'];
echo json_encode($response);
$con->cerrarConexion();






 ?>
