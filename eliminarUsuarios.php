<?php require_once('Connections/conexion.php'); ?>
<? include("login.php"); ?>

<?php

$id=$_GET['id'];
mysql_select_db($database_conexion, $conexion);
$query_usuarios = "SELECT * FROM usuarios ";
$usuarios = mysql_query($query_usuarios, $conexion) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

if($totalRows_usuarios==1){
echo"<script type=\"text/javascript\">alert ('Debe existir al menos un usuario '); location.href='consultaUsuarios.php' </script>";
exit;
}



 //conexion 
mysql_select_db($database_conexion, $conexion);
  

$sql="delete from usuarios where id_usuario='$id'";
$verificar=mysql_query($sql,$conexion) or die(mysql_error());

if($verificar){
	echo"<script type=\"text/javascript\">alert ('Datos Eliminado'); location.href='consultaUsuarios.php' </script>";
}
else
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consultaUsuarios.php' </script>";
	



?>