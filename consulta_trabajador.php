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

$maxRows_trabajadores = 10;
$pageNum_trabajadores = 0;
if (isset($_GET['pageNum_trabajadores'])) {
  $pageNum_trabajadores = $_GET['pageNum_trabajadores'];
}
$startRow_trabajadores = $pageNum_trabajadores * $maxRows_trabajadores;

mysql_select_db($database_conexion, $conexion);
$query_trabajadores = "SELECT * FROM trabajador";
$query_limit_trabajadores = sprintf("%s LIMIT %d, %d", $query_trabajadores, $startRow_trabajadores, $maxRows_trabajadores);
$trabajadores = mysql_query($query_limit_trabajadores, $conexion) or die(mysql_error());
$row_trabajadores = mysql_fetch_assoc($trabajadores);

if (isset($_GET['totalRows_trabajadores'])) {
  $totalRows_trabajadores = $_GET['totalRows_trabajadores'];
} else {
  $all_trabajadores = mysql_query($query_trabajadores);
  $totalRows_trabajadores = mysql_num_rows($all_trabajadores);
}
$totalPages_trabajadores = ceil($totalRows_trabajadores/$maxRows_trabajadores)-1;

$queryString_trabajadores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_trabajadores") == false && 
        stristr($param, "totalRows_trabajadores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_trabajadores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_trabajadores = sprintf("&totalRows_trabajadores=%d%s", $totalRows_trabajadores, $queryString_trabajadores);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title><style type="text/css">
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
.Estilo2 {color: #000000}
</style>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Trabajador?');
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
<table width="632" class="lados" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">CONSULTA DE ELECTORES </th>
  </tr>
  <tr>
    <th width="176" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Nombres y Apellidos</th>
    <th width="134" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Cedula</th>
    <th width="143" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Telefono </th>
    <th width="118" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Tipo</th>
    <th width="17" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">M</th>
    <th width="17" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">E</th>
  </tr>
 
  <?php do { ?>
    <tr bgcolor="#FFFFFF">
      <td align="center" valign="middle"><?php echo $row_trabajadores['nombres']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trabajadores['cedula']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trabajadores['telefono']; ?></td>
      <td align="center"><?php echo $row_trabajadores['tipo']; ?></td>
      <td align="center"><div align="center"><? echo "<a href='modificar_trabajador.php?cedula=$row_trabajadores[cedula]'>IR</a>" ?></div></td>
      <td align="center"><div align="center"><? echo "<a onClick='return validar()' href='eliminar_trabajador.php?cedula=$row_trabajadores[cedula]'>IR</a>" ?></div></td>
    </tr>
    <?php } while ($row_trabajadores = mysql_fetch_assoc($trabajadores)); ?>
 
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_trabajadores > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_trabajadores=%d%s", $currentPage, 0, $queryString_trabajadores); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_trabajadores > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_trabajadores=%d%s", $currentPage, max(0, $pageNum_trabajadores - 1), $queryString_trabajadores); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_trabajadores < $totalPages_trabajadores) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_trabajadores=%d%s", $currentPage, min($totalPages_trabajadores, $pageNum_trabajadores + 1), $queryString_trabajadores); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_trabajadores < $totalPages_trabajadores) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_trabajadores=%d%s", $currentPage, $totalPages_trabajadores, $queryString_trabajadores); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($trabajadores);
?>
