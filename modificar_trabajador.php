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
	
mysql_select_db($database_conexion, $conexion);$query_validar = "SELECT * FROM trabajador where cedula='$_POST[cedula]' and id_trabajador!='$_POST[id_trabajador]'";
$validar = mysql_query($query_validar, $conexion) or die(mysql_error());
$row_validar = mysql_fetch_assoc($validar);
$totalRows_validar = mysql_num_rows($validar);

if($totalRows_validar>0){
	echo "<script type=\"text/javascript\">alert ('Ya otro Trabajador Posee esta cedula');  location.href='modificar_trabajador.php?cedula=$_POST[valor]' </script>";
	exit;
}
	
  $updateSQL = sprintf("UPDATE trabajador SET cedula=%s, nombres=%s, telefono=%s, tipo=%s WHERE id_trabajador=%s",
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['id_trabajador'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Actualizados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}
$cedula=$_GET["cedula"];
mysql_select_db($database_conexion, $conexion);
$query_trabajador = "SELECT * FROM trabajador where cedula=$cedula";
$trabajador = mysql_query($query_trabajador, $conexion) or die(mysql_error());
$row_trabajador = mysql_fetch_assoc($trabajador);
$totalRows_trabajador = mysql_num_rows($trabajador);
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
</head>
<script language="javascript">
function validar(){

		
	if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN LA CEDULA DEL TRABAJADOR');
				return false;
		   		}
				}
				
				if(document.form1.telefono.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('telefono').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN TELEFONO DEL TRABAJADOR');
				return false;
		   		}
				}
			
				if(document.form1.nombres.value==""){
						alert("Ingrese el nombre y el apellido del trabajador");
						return false;
				}
				
				if(document.form1.cedula.value==""){
						alert("Ingrese la cedula del trabajador");
						return false;
				}
				
				if(document.form1.telefono.value==""){
						alert("Ingrese el telefono del trabajador");
						return false;
				}
				
		
				
				

				
				
		}
</script>
<body>
<form action="<?php echo $editFormAction; ?>" onsubmit="return validar()" method="post" name="form1" id="form1">
  <table align="center" class="lados">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Modifcar Trabajadores</td>
    </tr>
    <tr valign="baseline">
      <td width="168" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Cedula del Trabajador:</td>
      <td width="234" bgcolor="#d8dfe5"><input name="cedula" type="text" value="<?php echo $row_trabajador['cedula']; ?>" size="12" maxlength="8" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Nombres y Apellidos:</td>
      <td bgcolor="#d8dfe5"><input name="nombres" type="text" value="<?php echo $row_trabajador['nombres']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Telefono:</td>
      <td bgcolor="#d8dfe5"><input name="telefono" type="text" value="<?php echo $row_trabajador['telefono']; ?>" size="20" maxlength="11" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Tipo:</td>
      <td bgcolor="#d8dfe5"><label for="tipo"></label>
        <select name="tipo" id="tipo">
          <option value="Chofer" <?php if (!(strcmp("Chofer", $row_trabajador['tipo']))) {echo "selected=\"selected\"";} ?>>Chofer</option>
          <option value="Colector" <?php if (!(strcmp("Colector", $row_trabajador['tipo']))) {echo "selected=\"selected\"";} ?>>Colector</option>
          <option value="Supervisor" <?php if (!(strcmp("Supervisor", $row_trabajador['tipo']))) {echo "selected=\"selected\"";} ?>>Supervisor</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Modificar Datos" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_trabajador" value="<?php echo $row_trabajador['id_trabajador']; ?>" />
  <input type="hidden" name="valor" value="<?php echo $cedula; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($trabajador);
?>
