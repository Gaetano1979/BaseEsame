<?php

$tabla_usuarios='usuarios';


$dati_usuario['id']='INT PRIMARY KEY AUTO_INCREMENT';
$dati_usuario['nombre']='VARCHAR(200) NOT NULL';
$dati_usuario['pasw']='VARCHAR(200) NOT NULL UNIQUE';
$dati_usuario['email']='VARCHAR(200) NOT NULL UNIQUE';
$dati_usuario['fecha_nac']='DATE NOT NULL';
//$dati_usuario['fk_eventos']='INT';



$tabla_eventos='eventos';
$dati_eventos['id']='INT PRIMARY KEY AUTO_INCREMENT';
$dati_eventos['titulo']='VARCHAR(200) NOT NULL';
$dati_eventos['fecha_inicio']='DATE NOT NULL';
$dati_eventos['hora_inicio']='TIME NOT NULL';
$dati_eventos['fecha_final']='DATE';
$dati_eventos['hora_final']="TIME";
$dati_eventos['dia_completo']='BOOLEAN';
$dati_eventos['fk_usuario']='INT NOT NULL';








?>
