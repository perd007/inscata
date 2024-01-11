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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_reservacion = 10;
$pageNum_reservacion = 0;
if (isset($_GET['pageNum_reservacion'])) {
  $pageNum_reservacion = $_GET['pageNum_reservacion'];
}
$startRow_reservacion = $pageNum_reservacion * $maxRows_reservacion;

mysql_select_db($database_conexion, $conexion);
$query_reservacion = "SELECT * FROM reservacion where salida='$_POST[salida]' ";
$query_limit_reservacion = sprintf("%s LIMIT %d, %d", $query_reservacion, $startRow_reservacion, $maxRows_reservacion);
$reservacion = mysql_query($query_limit_reservacion, $conexion) or die(mysql_error());
$row_reservacion = mysql_fetch_assoc($reservacion);

if (isset($_GET['totalRows_reservacion'])) {
  $totalRows_reservacion = $_GET['totalRows_reservacion'];
} else {
  $all_reservacion = mysql_query($query_reservacion);
  $totalRows_reservacion = mysql_num_rows($all_reservacion);
}
$totalPages_reservacion = ceil($totalRows_reservacion/$maxRows_reservacion)-1;



$queryString_reservacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_reservacion") == false && 
        stristr($param, "totalRows_reservacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_reservacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_reservacion = sprintf("&totalRows_reservacion=%d%s", $totalRows_reservacion, $queryString_reservacion);



mysql_select_db($database_conexion, $conexion);
$query_salidas = "SELECT * FROM salidas where id_salida='$_POST[salida]'";
$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);
$totalRows_salidas = mysql_num_rows($salidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.Estilo2 {color: #000000}
.lados {	border: medium ridge #0a405c;
}
</style>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar esta reservacion?');
			if(valor==false){
			return false;
			}
			else{
			return true;
			}
		
}
//-->
</script>
<body>
<table width="599" class="lados" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="5" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">CONSULTA DE ELECTORES </th>
  </tr>
  <tr>
    <th colspan="5" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Salida del:<?php echo $row_salidas['fecha']?> <?php echo $row_salidas['destino']?></th>
  </tr>
  <tr>
    <th width="211" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Pasajero</th>
    <th width="121" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Cedula</th>
    <th width="141" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Telefono</th>
    <th width="73" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Puestos</th>
    <th width="23" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">E</th>
  </tr>
 
  <?php do { 
  
  
mysql_select_db($database_conexion, $conexion);
$query_pasajeros = "SELECT * FROM pasajero where cedula='$row_reservacion[pasajero]'";
$pasajeros = mysql_query($query_pasajeros, $conexion) or die(mysql_error());
$row_pasajeros = mysql_fetch_assoc($pasajeros);
$totalRows_pasajeros = mysql_num_rows($pasajeros);

$puesto=$row_reservacion['puesto'];
  ?>
    <tr bgcolor="#FFFFFF">
      <td align="center" valign="middle"><?php echo $row_pasajeros['nombres']; ?></td>
      <td align="center" valign="middle"><?php echo $row_pasajeros['cedula']; ?></td>
      <td align="center" valign="middle"><?php echo $row_pasajeros['telefono']; ?></td>
      <td align="center" valign="middle"><?php echo $puesto; ?></td>
      <td align="center"><div align="center"><? echo "<a onClick='return validar()' href='eliminar_reservacion.php?id=$row_reservacion[id_resevacion]'>IR</a>" ?></div></td>
    </tr>
    <?php } while ($row_reservacion = mysql_fetch_assoc($reservacion)); ?>

</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_reservacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_reservacion=%d%s", $currentPage, 0, $queryString_reservacion); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_reservacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_reservacion=%d%s", $currentPage, max(0, $pageNum_reservacion - 1), $queryString_reservacion); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_reservacion < $totalPages_reservacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_reservacion=%d%s", $currentPage, min($totalPages_reservacion, $pageNum_reservacion + 1), $queryString_reservacion); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_reservacion < $totalPages_reservacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_reservacion=%d%s", $currentPage, $totalPages_reservacion, $queryString_reservacion); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($reservacion);

mysql_free_result($salidas);

mysql_free_result($pasajeros);
?>
