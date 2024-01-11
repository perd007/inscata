<?php require_once('Connections/conexion.php'); ?>
<? include("login.php"); ?>

<?php

 

$id=$_POST["salida"];

$sql="update salidas set confirmada=1 where id_salida='$id'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Salida Realizada'); location.href='fondo.php' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='fondo.php' </script>";
	
}
?>