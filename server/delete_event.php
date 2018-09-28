<?php
session_start();
require('../php/access.php');
require('../php/tablas.php');
require('../php/lib.php');
require('../php/dati.php');
//$_POST['id']=1;

if (isset($_SESSION['username'])) {
  $con=new Conector($host,$user,$pas);
  $response['conessione']=$con->Conessione();
  $response['con_db']=$con->initConessione($db);
  if ($response['conessione']=="OK") {
    if ($response['con_db']=="OK") {
      if($con->eliminarRegistro($tabla_eventos,' id="'.$_POST['id'].'"')){
        $response['msg']="OK";
      }else $response['msg']="No hemos eliminado ningun elemento";
    }else $response['con_db']="problema con el DATABASE";
  }else $response['conessione']="problema con la conessione";
}
echo json_encode($response);


 ?>
