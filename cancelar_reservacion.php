<?php require_once('Connections/conexion.php'); ?>
<? include("login.php"); ?>

<?php



$cedula=$_GET["cedula"];
$salida=$_GET["salida"];

mysql_select_db($database_conexion, $conexion);
$sql="delete from reservacion where cedula='$cedula' and salida='$salida'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Reservacion Cancelada'); location.href='confirmar_reservacion.php' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='confirmar_reservacion.ph' </script>";
	
}
?>