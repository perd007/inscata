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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
		
  mysql_select_db($database_conexion, $conexion);
$query_validar = "SELECT * FROM trabajador where cedula='$_POST[cedula]'";
$validar = mysql_query($query_validar, $conexion) or die(mysql_error());
$row_validar = mysql_fetch_assoc($validar);
$totalRows_validar = mysql_num_rows($validar);

if($totalRows_validar>0){
	echo "<script type=\"text/javascript\">alert ('Ya otro Trabajador Posee esta cedula');  location.href='registro_trabajador.php' </script>";
	exit;
}
	
  $insertSQL = sprintf("INSERT INTO trabajador (id_trabajador, cedula, nombres, telefono, tipo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_trabajador'], "int"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['tipo'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
    if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
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
  <p>&nbsp;</p>
  <table align="center" class="lados">
    <tr valign="baseline" >
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Registro de Trabajadores</td>
    </tr>
    <tr valign="baseline">
      <td width="154" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq"><span class="izq">Cedula del Trabajador:</span></td>
      <td width="318" bgcolor="#d8dfe5"><span class="izq">
        <input name="cedula" type="text" value="" size="12" maxlength="8" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq"><span class="izq">Nombres y Apellidos:</span></td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="nombres" type="text" value="" size="50" maxlength="50" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq"><span class="izq">Telefono:</span></td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="telefono" type="text" value="" size="20" maxlength="11" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq"><span class="izq">Tipo:</span></td>
      <td bgcolor="#d8dfe5">        <span class="izq">
        <select name="tipo" id="tipo">
          <option value="Chofer">Chofer</option>
          <option value="Colector">Colector</option>
          <option value="Supervisor">Supervisor</option>
        </select>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5">
        <input type="submit" class="negrita" value="Guardar Datos" />
     </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>