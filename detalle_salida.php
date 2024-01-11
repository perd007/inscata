<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$id=$_GET["id"];
mysql_select_db($database_conexion, $conexion);
$query_salida = "SELECT * FROM salidas where id_salida=$id";
$salida = mysql_query($query_salida, $conexion) or die(mysql_error());
$row_salida = mysql_fetch_assoc($salida);
$totalRows_salida = mysql_num_rows($salida);

mysql_select_db($database_conexion, $conexion);
$query_colectores = "SELECT * FROM trabajador WHERE id_trabajador = '$row_salida[colector]'";
$colectores = mysql_query($query_colectores, $conexion) or die(mysql_error());
$row_colectores = mysql_fetch_assoc($colectores);
$totalRows_colectores = mysql_num_rows($colectores);



mysql_select_db($database_conexion, $conexion);
$query_choferes = "SELECT * FROM trabajador WHERE id_trabajador = '$row_salida[chofer]'";
$choferes = mysql_query($query_choferes, $conexion) or die(mysql_error());
$row_choferes = mysql_fetch_assoc($choferes);
$totalRows_choferes = mysql_num_rows($choferes);




mysql_select_db($database_conexion, $conexion);
$query_supervisores = "SELECT * FROM trabajador WHERE id_trabajador = '$row_salida[supervisor]'";
$supervisores = mysql_query($query_supervisores, $conexion) or die(mysql_error());
$row_supervisores = mysql_fetch_assoc($supervisores);
$totalRows_supervisores = mysql_num_rows($supervisores);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.negrita {
	font-weight: bold;
}
.izq {
	text-align: left;
	font-weight: bold;
}
.lados {
	border: medium ridge #0a405c;
	
}
</style>

<style type="text/css">
.oscuro {	font-weight: bold;
}
</style>
</head>

<body>
<table align="center" class="lados">
  <tr valign="baseline">
    <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="oscuro">Detalles de Salidas de Autobuses</td>
  </tr>
  <tr valign="baseline">
    <td width="131" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Fecha de la Salida:</td>
    <td width="260" bgcolor="#d8dfe5"><?php echo $row_salida['fecha']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Colector:</td>
    <td bgcolor="#d8dfe5"><?php echo $row_colectores['nombres']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Chofer:</td>
    <td bgcolor="#d8dfe5"><?php echo $row_choferes['nombres']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Supervisor:</td>
    <td bgcolor="#d8dfe5"><?php echo $row_supervisores['nombres']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Destino:</td>
    <td bgcolor="#d8dfe5"><?php echo $row_salida['destino']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita">Autobus:</td>
    <td bgcolor="#d8dfe5"><?php echo $row_salida['autobus']; ?></td>
  </tr>
  <tr valign="baseline">
    <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><a href="consultar_salida.php"><input type="submit" class="oscuro" value="Regresar" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($salida);
?>
