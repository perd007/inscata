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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
mysql_select_db($database_conexion, $conexion);
$query_validar = "SELECT * FROM salidas where fecha='$_POST[fecha]' and id_salida!='$_POST[id_salida]' ";
$validar = mysql_query($query_validar, $conexion) or die(mysql_error());
$row_validar = mysql_fetch_assoc($validar);
$totalRows_validar = mysql_num_rows($validar);

	if($totalRows_validar>0){
	echo "<script type=\"text/javascript\">alert ('Ya existe una salida registrada para esta fecha: $_POST[fecha]');  location.href='modificar_salida.php?id=$_POST[id]' </script>";
	exit;
}
	
  $updateSQL = sprintf("UPDATE salidas SET fecha=%s, colector=%s, chofer=%s, supervisor=%s, destino=%s, autobus=%s WHERE id_salida=%s",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['colector'], "int"),
                       GetSQLValueString($_POST['chofer'], "int"),
                       GetSQLValueString($_POST['supervisor'], "int"),
                       GetSQLValueString($_POST['destino'], "text"),
                       GetSQLValueString($_POST['autobus'], "text"),
                       GetSQLValueString($_POST['id_salida'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  if($Result1){
  echo "<script type=\"text/javascript\">alert ('Actualizado');  location.href='consultar_salida.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='consultar_salida.php' </script>";
  exit;
  }
}


$id=$_GET["id"];
mysql_select_db($database_conexion, $conexion);
$query_salidas = "SELECT * FROM salidas where id_salida=$id";
$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);
$totalRows_salidas = mysql_num_rows($salidas);


mysql_select_db($database_conexion, $conexion);
$query_colectores = "SELECT * FROM trabajador WHERE tipo = 'colector'";
$colectores = mysql_query($query_colectores, $conexion) or die(mysql_error());
$row_colectores = mysql_fetch_assoc($colectores);
$totalRows_colectores = mysql_num_rows($colectores);

if($totalRows_colectores<=0){
	echo "<script type=\"text/javascript\">alert ('Debe registrar al menos un colector');  location.href='registro_trabajador.php' </script>";
	exit;
}


mysql_select_db($database_conexion, $conexion);
$query_choferes = "SELECT * FROM trabajador WHERE tipo = 'chofer'";
$choferes = mysql_query($query_choferes, $conexion) or die(mysql_error());
$row_choferes = mysql_fetch_assoc($choferes);
$totalRows_choferes = mysql_num_rows($choferes);

if($totalRows_choferes<=0){
	echo "<script type=\"text/javascript\">alert ('Debe registrar al menos un chofer');  location.href='registro_trabajador.php' </script>";
	exit;
}


mysql_select_db($database_conexion, $conexion);
$query_supervisores = "SELECT * FROM trabajador WHERE tipo = 'supervisor'";
$supervisores = mysql_query($query_supervisores, $conexion) or die(mysql_error());
$row_supervisores = mysql_fetch_assoc($supervisores);
$totalRows_supervisores = mysql_num_rows($supervisores);

if($totalRows_supervisores<=0){
	echo "<script type=\"text/javascript\">alert ('Debe registrar al menos un Supervisor');  location.href='registro_trabajador.php' </script>";
	exit;
}
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
	font-weight: bold;
}
</style>
<style type="text/css">
@import url("jscalendar-1.0/calendar-win2k-cold-1.css");
.oscuro {	font-weight: bold;
}
</style>
</head>
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
<script language="javascript">

function validar(){

				if(document.form1.destino.value==""){
						alert("Debe ingresar el destino del viaje");
						return false;
				}
				if(document.form1.fecha.value==""){
						alert("Debe ingresar la fecha de salida");
						return false;
				}
				
				
		}
</script>
<body>
<form action="<?php echo $editFormAction; ?>" onsubmit="return validar()" method="post" name="form1" id="form1">
  <table align="center" class="lados">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="oscuro">Modificacion de Salidas de Autobuses</td>
    </tr>
    <tr valign="baseline">
      <td width="131" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Fecha de la Salida:</td>
      <td width="260" bgcolor="#d8dfe5"><input name="fecha" type="text" id="fecha" value="<?php echo $row_salidas['fecha']; ?>" size="20" maxlength="10" readonly="readonly" />
        <button type="submit" id="cal-button-1" title="Clic Para Escoger la fecha">Fecha</button>
        <script type="text/javascript">
							Calendar.setup({
							  inputField    : "fecha",
							  ifFormat   : "%Y-%m-%d",
							  button        : "cal-button-1",
							  align         : "Tr"
							});
						  </script></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Colector:</td>
      <td bgcolor="#d8dfe5"><label for="colector"></label>
        <select name="colector" id="colector">
          <?php
do {  
?>
          <option value="<?php echo $row_colectores['id_trabajador']?>"<?php if (!(strcmp($row_colectores['id_trabajador'], $row_salidas['colector']))) {echo "selected=\"selected\"";} ?>><?php echo $row_colectores['nombres']?></option>
          <?php
} while ($row_colectores = mysql_fetch_assoc($colectores));
  $rows = mysql_num_rows($colectores);
  if($rows > 0) {
      mysql_data_seek($colectores, 0);
	  $row_colectores = mysql_fetch_assoc($colectores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Chofer:</td>
      <td bgcolor="#d8dfe5"><select name="chofer" id="chofer">
        <?php
do {  
?>
        <option value="<?php echo $row_choferes['id_trabajador']?>"<?php if (!(strcmp($row_choferes['id_trabajador'], $row_salidas['chofer']))) {echo "selected=\"selected\"";} ?>><?php echo $row_choferes['nombres']?></option>
        <?php
} while ($row_choferes = mysql_fetch_assoc($choferes));
  $rows = mysql_num_rows($choferes);
  if($rows > 0) {
      mysql_data_seek($choferes, 0);
	  $row_choferes = mysql_fetch_assoc($choferes);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Supervisor:</td>
      <td bgcolor="#d8dfe5"><select name="select3" id="select3">
        <?php
do {  
?>
        <option value="<?php echo $row_supervisores['id_trabajador']?>"<?php if (!(strcmp($row_supervisores['id_trabajador'], $row_salidas['supervisor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_supervisores['nombres']?></option>
        <?php
} while ($row_supervisores = mysql_fetch_assoc($supervisores));
  $rows = mysql_num_rows($supervisores);
  if($rows > 0) {
      mysql_data_seek($supervisores, 0);
	  $row_supervisores = mysql_fetch_assoc($supervisores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Destino:</td>
      <td bgcolor="#d8dfe5"><textarea name="destino" cols="40" rows="4" onkeydown="if(this.value.length &gt;= 100){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"><?php echo $row_salidas['destino']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="name">Autobus:</td>
      <td bgcolor="#d8dfe5"><input name="autobus" type="text" value="<?php echo $row_salidas['autobus']; ?>" size="40" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="oscuro" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_salida" value="<?php echo $row_salidas['id_salida']; ?>" />
  <input type="hidden" name="id" value="<?php echo $id; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($salidas);
?>
