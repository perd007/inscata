<?php require_once('Connections/conexion.php'); ?>


<?php



$id=$_GET["cedula"];

$sql="delete from trabajador where cedula='$id'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Datos Eliminado'); location.href='consulta_trabajador.php' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consulta_trabajador.php' </script>";
	
}
?>