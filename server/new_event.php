<?php
session_start();
require('../php/lib.php');
require('../php/access.php');
require('../php/dati.php');
require('../php/tablas.php');

//$data['id']='INT PRIMARY KEY AUTO_INCREMENT';
$data['titulo']="'".$_POST['titulo']."'";
$data['fecha_inicio']="'".$_POST['start_date']."'";
$data['hora_inicio']="'".$_POST['start_hour']."'";
$data['fecha_final']="'".$_POST['end_date']."'";
$data['hora_final']="'".$_POST['end_hour']."'";
if ($_POST['allDay']==true) {
  $data['dia_completo']=1;
}else $data['dia_completo']=0;
//$data['dia_completo']="'".$_POST['allDay']."'";
//$data['fk_usuario']="'".$fila['id']."'";

if (isset($_SESSION['username'])) {
  $con=new Conector($host,$user,$pas);
  $response['conessione']=$con->Conessione();
  $response['con_db']=$con->initConessione($db);
  if ($response['conessione']=='OK') {
    if ($response['con_db']=='OK') {
      $response['msg']='consesione riuscita con el DATABASE';
      if($id=$con->consultar([$tabla_usuarios],['id'],' WHERE email="'.$_SESSION['username'].'"')){
        $fila=$id->fetch_assoc();

        $response['id_session']=$fila['id'];
        $data['fk_usuario']=$fila['id'];

        //echo $data['fk_usuario']." ".$_SESSION['username']."<br>";

      }else $response['id']='Error en conseguir el id del usuario';
      if($con->insertData($tabla_eventos,$data)){
      $response['msg']='OK';

    }else $response['msg']='Error en inserir los datos';
    }else {
      $response['msg']='No hay conession con la base de datos';
    }
  }else {
    $response['msg']='No hay conession con el server';
  }
}else $response['msg']='No hay una sessione abierta';

echo json_encode($response);




 ?>
