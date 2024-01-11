<?php require_once('Connections/conexion.php'); ?>
<? include("login.php"); ?>
<?php 
//validar usuario
if($validacion==true){
	if($Admi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para realizar Operaciones sobre los Usuarios'); location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido');  location.href='fondo.php'  </script>";
 exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

$m=$_POST["modificaciones"];
$c=$_POST["consultas"];
$e=$_POST["eliminaciones"];
$r=$_POST["registros"];
//validar permisos
if($m!=""){
$m=1;
}
else{
$m=0;
}

if($c!=""){
$c=1;
}
else{
$c=0;
}

if($e!=""){
$e=1;
}
else{
$e=0;
}

if($r!=""){
$r=1;
}
else{
$r=0;
}


//chequear usuario
$sql="select usuario from seguridad where usuario='$_POST[usuario]'";
$resultado=mysql_query($sql)or die(mysql_error());
$verificar=mysql_fetch_assoc($resultado);


if($verificar["usuario"]==$_POST['usuario']){
echo "<script type=\"text/javascript\">alert ('Usuario ya Registrado'); location.href='registroUsuario.php' </script>";
 exit;

}



  $insertSQL = sprintf("INSERT INTO seguridad (usuario, clave, nombre, cedula, modificar, consultar, eliminar, registrar) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
					   GetSQLValueString($_POST['nombre'], "text"),
                  
					   GetSQLValueString($_POST['cedula'], "int"),
					   GetSQLValueString($m, "int"),
					   GetSQLValueString($c, "int"),
					   GetSQLValueString($e, "int"),
					   GetSQLValueString($r, "int"));

 mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL,$conexion) or die(mysql_error());
  if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title>Registro Usuario</title>

<style type="text/css">
<!--
.Estilo1 {font-weight: bold}

negrita {
	font-weight: bold;
}
.letrasblancas {
	color: #000000;
}


-->
</style>
</head>
<script language="javascript">
<!--
function validar(){
		   if(document.form1.usuario.value==""){
		   alert("DEBE INGRESAR UN USUARIO");
		   return false;
		   }
		    if(document.form1.clave.value==""){
		   alert("DEBE INGRESAR UNA CLAVE");
		   return false;
		   }
		   
		      if(document.form1.cedula.value==""){
		   alert("DEBE INGRESAR LA CEDULA");
		   return false;
		   }
	
		   
}


		
		 	 
   
//-->
</script>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()" name="form1" id="form1">
  <table width="552" border="0" align="center" cellpadding="1" cellspacing="2" class="bordes">
    <tr valign="baseline" bgcolor="#FF0000">
      <td colspan="2" align="right" nowrap="nowrap" bgcolor="#d8dfe5"><div align="center" class="letrasblancas"><strong>REGISTRO DE USUARIOS </strong></div></td>
    </tr>
    <tr valign="baseline" bgcolor="#FF0000">
      <td width="212" align="right" nowrap="nowrap" bgcolor="#d8dfe5"><div align="right" class="Estilo1"><strong>Usuario:</strong></div></td>
      <td width="324" bgcolor="#d8dfe5"><input name="usuario" type="text" class="Estilo1" value="" size="20" maxlength="10" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FF0000">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5"><div align="right" class="Estilo1"><strong>Clave:</strong></div></td>
      <td bgcolor="#d8dfe5"><input name="clave" type="password" class="Estilo1" value="" size="20" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5"><strong>Nombre:</strong></td>
      <td bgcolor="#d8dfe5"><input name="nombre" type="text" class="Estilo5" size="32" maxlength="20" /></td>
    </tr>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5"><strong>Cedula:</strong></td>
      <td bgcolor="#d8dfe5"><input name="cedula" type="text" class="Estilo5" size="32" maxlength="8" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="Estilo1">Telefono:</td>
      <td bgcolor="#d8dfe5"><input name="cedula2" type="text" class="Estilo5" size="32" maxlength="11" /></td>
    </tr>
    
    <tr valign="baseline" bgcolor="#FF0000">
      <td colspan="2" align="right" nowrap="nowrap" bgcolor="#d8dfe5"><div align="center" class="Estilo1">
        <input name="submit" type="submit" value="Guardar" />
      </div></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<p></p>
<p>&nbsp;</p>
</body>
</html>
