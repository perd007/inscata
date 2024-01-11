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

$maxRows_salidas = 10;
$pageNum_salidas = 0;
if (isset($_GET['pageNum_salidas'])) {
  $pageNum_salidas = $_GET['pageNum_salidas'];
}
$startRow_salidas = $pageNum_salidas * $maxRows_salidas;

mysql_select_db($database_conexion, $conexion);
$query_salidas = "SELECT * FROM salidas";
$query_limit_salidas = sprintf("%s LIMIT %d, %d", $query_salidas, $startRow_salidas, $maxRows_salidas);
$salidas = mysql_query($query_limit_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);

if (isset($_GET['totalRows_salidas'])) {
  $totalRows_salidas = $_GET['totalRows_salidas'];
} else {
  $all_salidas = mysql_query($query_salidas);
  $totalRows_salidas = mysql_num_rows($all_salidas);
}
$totalPages_salidas = ceil($totalRows_salidas/$maxRows_salidas)-1;

$queryString_salidas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_salidas") == false && 
        stristr($param, "totalRows_salidas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_salidas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_salidas = sprintf("&totalRows_salidas=%d%s", $totalRows_salidas, $queryString_salidas);
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
.Estilo2 {color: #000000}
</style>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar esta salida?');
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
<table width="597" class="lados" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">CONSULTA DE SALIDAS </th>
  </tr>
  <tr>
    <th width="110" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Fecha</th>
    <th width="199" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Destino</th>
    <th width="178" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">Autobus</th>
    <th width="33" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">M</th>
    <th width="24" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">D</th>
    <th width="19" align="center" valign="middle" bgcolor="#d8dfe5" class="Estilo1 Estilo2" scope="col">E</th>
  </tr>
 
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_salidas['fecha']; ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_salidas['destino']; ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_salidas['autobus']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><div align="center"><? if($row_salidas['confirmada']!=1) echo "<a href='modificar_salida.php?id=$row_salidas[id_salida]'>IR</a>" ?></div></td>
      <td align="center" bgcolor="#FFFFFF"><? echo "<a href='detalle_salida.php?id=$row_salidas[id_salida]'>IR</a>" ?></td>
      <td align="center" bgcolor="#FFFFFF"><div align="center"><? if($row_salidas['confirmada']!=1) echo "<a onClick='return validar()' href=' onClick='return validar()' eliminar_salida.php?id=$row_salidas[id_salida]'>IR</a>" ?></div></td>
    </tr>
    <?php } while ($row_salidas = mysql_fetch_assoc($salidas)); ?>

</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_salidas > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_salidas=%d%s", $currentPage, 0, $queryString_salidas); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_salidas > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_salidas=%d%s", $currentPage, max(0, $pageNum_salidas - 1), $queryString_salidas); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_salidas < $totalPages_salidas) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_salidas=%d%s", $currentPage, min($totalPages_salidas, $pageNum_salidas + 1), $queryString_salidas); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_salidas < $totalPages_salidas) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_salidas=%d%s", $currentPage, $totalPages_salidas, $queryString_salidas); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($salidas);
?>
