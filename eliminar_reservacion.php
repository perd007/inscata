<?php require_once('Connections/conexion.php'); ?>


<?php



$id=$_GET["id"];

mysql_select_db($database_conexion, $conexion);
$sql="delete from reservacion where id_resevacion='$id'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Datos Eliminado'); location.href='consultar_reservacion.php' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consultar_reservacion.php' </script>";
	
}
?>