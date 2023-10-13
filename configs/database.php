<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database = "votacion";

$conn = mysqli_connect($localhost, $username, $password, $database);
$sql = mysqli_query($conn, "SET NAMES 'UTF8'");

if($conn){
    //echo "Se ha conectado exitosamente a DB";
    session_start();
    //echo "Se ha iniciado la sesion";
}else{
    echo "No se ha podido establecer correctamente la conexion a DB";
}

?>