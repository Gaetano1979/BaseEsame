<?php
/**
 *
 */
class Conector{
  private $host;
  private $user;
  private $pas;
  private $con;

  function __construct($host,$user,$pas){
    $this->host=$host;
    $this->user=$user;
    $this->pas=$pas;
  }

  function Conessione(){
    $this->con = new mysqli($this->host, $this->user, $this->pas);
    if ($this->con->connect_error) {
      return "Error ".$this->con->connect_error;
    }else return "OK";
  }

  function initConessione($nombre_db){
    $this->con = new mysqli($this->host, $this->user, $this->pas, $nombre_db);
    if ($this->con->connect_error) {
      return "Error: ".$this->con->connect_error;
    }else return "OK";
  }

  function nueva_DB($db){
    $sql='CREATE DATABASE IF NOT EXISTS '.$db;
    if ($this->ejecutarQuery($sql)) {
      return true;
    }else return false;
    //return $sql;
  }

  function nueva_tabla($tabla,$colonne){
    $sql='CREATE TABLE IF NOT EXISTS '.$tabla.' (';
    $length_array=count($colonne);
    $i=1;
    foreach ($colonne as $key => $value) {
      $sql.=$key.' '.$value;
      if ($i!=$length_array) {
        $sql.=', ';
      }else {
        $sql.=');';
      }
      $i++;
    }
    if ($this->ejecutarQuery($sql)) {
      return true;
    }else return false;
    //echo $sql;
    //return $sql;
  }

  function nuevaRestrincion($nombre_tbl,$restrinciones){
    $sql='ALTER TABLE '.$nombre_tbl.' '.$restrinciones;
    if ($this->ejecutarQuery($sql)) {
      return true;
    }else {
      return false;
    }
  }

  function nuevaRelacion($from_tbl,$to_tbl,$from_field,$to_field){
    $sql='ALTER TABLE '.$from_tbl.' ADD FOREIGN KEY ('.$from_field.') REFERENCES '.$to_tbl.'('.$to_field.');';
    //echo $sql;
    return $this->ejecutarQuery($sql);
  }

  function insertData($tabla, $data){
    $sql = 'INSERT INTO '.$tabla.' (';
    $i = 1;
    foreach ($data as $key => $value) {
      $sql .= $key;
      if ($i<count($data)) {
        $sql .= ', ';
      }else $sql .= ')';
      $i++;
    }
    $sql .= ' VALUES (';
    $i = 1;
    foreach ($data as $key => $value) {
      $sql .= $value;
      if ($i<count($data)) {
        $sql .= ', ';
      }else $sql .= ');';
      $i++;
    }
    //echo $sql;
    return $this->ejecutarQuery($sql);
  }

  function actualizarRegistro($tabla, $data, $condicion){
    $sql = 'UPDATE '.$tabla.' SET ';
    $i=1;
    foreach ($data as $key => $value) {
      $sql .= $key.'='.$value;
      if ($i<sizeof($data)) {
        $sql .= ', ';
      }else $sql .= ' WHERE '.$condicion.';';
      $i++;
    }
    return $this->ejecutarQuery($sql);
  }

  function consultar($tablas, $campos, $condicion = ""){
      $sql = "SELECT ";
      $a = array_keys($campos);
      $ultima_key = end($a);
      foreach ($campos as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .=" FROM ";
      }

      $b = array_keys($tablas);
      $ultima_key = end($b);
      foreach ($tablas as $key => $value) {
        $sql .= $value;
        if ($key!=$ultima_key) {
          $sql.=", ";
        }else $sql .= " ";
      }

      if ($condicion == "") {
        $sql .= ";";
      }else {
        $sql .= $condicion.";";
      }
      //echo $sql;
      return $this->ejecutarQuery($sql);
    }

  function eliminarRegistro($tabla, $condicion){
    $sql = "DELETE FROM ".$tabla." WHERE ".$condicion.";";
    return $this->ejecutarQuery($sql);
    // echo $sql;
  }

  function ejecutarQuery($query){
    return $this->con->query($query);
  }

  function getConexion(){
      return $this->conexion;
    }

  function cerrarConexion(){
    $this->con->close();
  }
}










 ?>
