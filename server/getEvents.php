<?php
session_start();
require('../php/access.php');
require('../php/tablas.php');
require('../php/lib.php');
require('../php/dati.php');

if (isset($_SESSION['username'])) {

  $con=new Conector($host,$user,$pas);
  $response['conessione']=$con->Conessione();
  $response['con_db']=$con->initConessione($db);
  if ($response['conessione']=="OK") {
    if ($response['con_db']=="OK") {
      $response['msg']="OK";
      if ($resultado=$con->consultar([$tabla_eventos],['*']," WHERE fk_usuario='".$_SESSION['id']."'")) {
        $i=0;
        while ($fila=$resultado->fetch_assoc()) {
          $response['eventos'][$i]['id']=$fila['id'];
          $response['eventos'][$i]['title']=$fila['titulo'];
          $response['eventos'][$i]['start']=$fila['fecha_inicio'];
          $response['eventos'][$i]['end']=$fila['fecha_final'];
          $response['eventos'][$i]['allDay']=$fila['dia_completo']==1 ? true : false;
          $response['eventos'][$i]['time_start']=$fila['hora_inicio'];
          $response['eventos'][$i]['time_end']=$fila['hora_final'];
          $i++;
          }


      }
    }else {
      $response['msg']="No tenemos la conession con la tabla";
    }

  }else {
    $response['msg']="No tenemos la conession con el server";
  }
}else $response['msg']="No se ha iniziato una SESSION";

echo json_encode($response);
//$con->cerrarConexion();


 ?>
