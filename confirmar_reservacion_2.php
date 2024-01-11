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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	
for($i=0;$i<=$_POST["cont"]-1;$i++){
	
	
	
  $insertSQL = sprintf("INSERT INTO ventas (reservacion, nombres, cedula, destino, directa, salida) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['reservacion'.$i], "int"),
                       GetSQLValueString($_POST['nombre'.$i], "text"),
                       GetSQLValueString($_POST['cedula'.$i], "text"),
					   GetSQLValueString($_POST['destino'.$i], "text"),
					   GetSQLValueString('S', "text"),
					   GetSQLValueString($_POST['salida'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
    if($Result1){
	   $veri++;
  }else{
  $veri=-100;
  }
  }//fin del for
  
      if($veri==0){
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }else{
   echo "<script type=\"text/javascript\">alert ('Confirmacion Realizada');  location.href='fondo.php' </script>";
  }
}








/////////////////////////////////////////////////////////////////////////////////////////

mysql_select_db($database_conexion, $conexion);
$query_pasajeros = "SELECT * FROM pasajero where cedula='$_POST[cedula]'";
$pasajeros = mysql_query($query_pasajeros, $conexion) or die(mysql_error());
$row_pasajeros = mysql_fetch_assoc($pasajeros);
$totalRows_pasajeros = mysql_num_rows($pasajeros);
mysql_select_db($database_conexion, $conexion);


$query_salidas = "SELECT * FROM reservacion where salida='$_POST[salida]' ";
$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);
$totalRows_salidas = mysql_num_rows($salidas);




mysql_select_db($database_conexion, $conexion);
$query_reservacion = "SELECT * FROM reservacion  where salida='$_POST[salida]' and pasajero='$_POST[cedula]' order by puesto asc";
$reservacion = mysql_query($query_reservacion, $conexion) or die(mysql_error());
$row_reservacion = mysql_fetch_assoc($reservacion);
$totalRows_reservacion = mysql_num_rows($reservacion);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.izq {text-align: left;
	font-weight: bold;
}
.lados {	border: medium ridge #0a405c;
	text-align: left;
	font-weight: bold;
}
.negrita {font-weight: bold;
}
</style>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar esta Reservacion? Si cancela se perderan todos los datos relacionados con la reservacion');
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="638" align="center" class="lados">
    <tr valign="baseline" >
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Confirmar Reservacion </td>
    </tr>
    <tr valign="baseline">
      <td width="214" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Cedula del Pasajero:</td>
      <td width="406" bgcolor="#d8dfe5"><span class="izq">
        <input name="cedula" type="text" id="cedula" value="<?=$row_pasajeros["cedula"]?>" readonly="readonly" size="12" maxlength="8" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Nombres y Apellidos:</td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="nombres" type="text" id="nombres" value="<?=$row_pasajeros["nombres"]?>" size="50" maxlength="50" readonly="readonly" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Telefono:</td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="telefono" type="text" readonly="readonly" id="telefono" value="<?=$row_pasajeros["telefono"]?>" size="20" maxlength="11" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5">Pasajeros por Puestos</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><table width="636" border="0">
        <tr>
          <th width="310" scope="col">Nombres y Apellidos</th>
          <th width="66" scope="col">Cedula</th>
          <th width="92" scope="col">Destino</th>
          <th width="150" scope="col">Puesto</th>
        </tr>
        <?php 
	  
	  $cont=0;
	  
	  do { ?>
        <tr>
          <th scope="col"><span class="izq">
            <input name="nombre<?=$cont?>" type="text" id="nombre<?=$cont?>" value="" size="50" maxlength="20"  />
          </span></th>
          <th scope="col"><span class="izq">
            <input name="cedula<?=$cont?>" type="text" id="cedula<?=$cont?>" value=""  size="12" maxlength="8" />
          </span></th>
          <th scope="col"><select name="destino<?=$cont?>" id="destino<?=$cont?>">
            <option value="Maracay">Maracay</option>
            <option value="Valencia">Valencia</option>
            <option value="Caracas">Caracas</option>
          </select></th>
          <th scope="col"><?php echo $row_reservacion['puesto']; ?></th>
        </tr>
         <input type="hidden" name="reservacion<?=$cont?>" value="<?=$row_reservacion['id_reservacion']?>" />
        <?php 
		
		$cont++;
		} while ($row_reservacion = mysql_fetch_assoc($reservacion)); ?>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Confirmar Reservacion" />
        <label>
          <a onclick="return validar()" href="cancelar_reservacion.php?cedula=<?=$_POST['cedula']?>&salida=<?=$_POST['salida']?>"  ><input name="button" type="submit" class="negrita" id="button" value="Cancelar Reservacion" /></a>
      </label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
    <input type="hidden" name="cont" value="<?=$cont?>" />
    <input type="hidden" name="salida" value="<?=$_POST['salida']?>" />
    
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($reservacion);

mysql_free_result($salidas);
?>
