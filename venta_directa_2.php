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
		

 //verificamos si el pasajeros esta registrado
 if($_POST["pasajero"]==0){
  $insertSQL = sprintf("INSERT INTO pasajero (nombres, cedula, telefono) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['telefono'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   if($Result1){
	   $veri=1;
  }else{
 $veri=0;
  }
 }
 
 


/////////////////////////////////////////////////////////
  $contador=0;
//contamos la cantidad de puestos selecconados	
	for($i=1;$i<=55;$i++){
		if($_POST[$i]==on){
			$arreglo[$i]=$i;
			$contador++;
			}else{
			$arreglo[$i]==0;
			}
			//echo "puesto: $i<br> el arreglo: $arreglo[$i] <br>  contador: $contador <br><br><br>";
	}
 

  for($i=1;$i<=55;$i++){
	    
	  //verificamos si el arreglo tieene uno o cero
	  if($arreglo[$i]!=""){
		  $puesto=$arreglo[$i];
		  }
		  }





  $insertSQL2 = sprintf("INSERT INTO ventas (nombres, cedula, destino, puesto, directa, salida) VALUES ( %s, %s, %s, %s, %s, %s)",
                     
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['cedula'], "text"),
					   GetSQLValueString($_POST['destino'], "text"),
					   GetSQLValueString($puesto, "int"),
					   GetSQLValueString('S', "text"),
					   GetSQLValueString($_POST['salida'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($insertSQL2, $conexion) or die(mysql_error());
   if($Result2){
	   $veri2++;
  }else{
  $veri2=-100;
  }
	 

  
  
      if($veri2<=0){
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }else{
   echo "<script type=\"text/javascript\">alert ('Venta Realizada');  location.href='venta_directa_1.php' </script>";
  }
  
  
}




mysql_select_db($database_conexion, $conexion);
$query_pasajeros = "SELECT * FROM pasajero where cedula='$_POST[cedula]'";
$pasajeros = mysql_query($query_pasajeros, $conexion) or die(mysql_error());
$row_pasajeros = mysql_fetch_assoc($pasajeros);
$totalRows_pasajeros = mysql_num_rows($pasajeros);

for($i=1;$i<=55;$i++){

mysql_select_db($database_conexion, $conexion);
$query_salidas = "SELECT * FROM reservacion where salida='$_POST[salida]' and puesto=$i";
$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);
$totalRows_salidas = mysql_num_rows($salidas);

	
	$puestos[$i]=$totalRows_salidas;
	
	if($totalRows_salidas==0){
		mysql_select_db($database_conexion, $conexion);
		$query_ventas = "SELECT * FROM ventas where salida='$_POST[salida]' and puesto=$i";
		$ventas = mysql_query($query_ventas, $conexion) or die(mysql_error());
		$row_ventas = mysql_fetch_assoc($ventas);
		$totalRows_ventas = mysql_num_rows($ventas);
		
			if($totalRows_ventas==1){	
				$puestos[$i]=$totalRows_ventas;
				}
		
		}

}


mysql_select_db($database_conexion, $conexion);
$query_reservacion = "SELECT * FROM reservacion  where salida='$_POST[salida]' and pasajero='$_POST[cedula]'";
$reservacion = mysql_query($query_reservacion, $conexion) or die(mysql_error());
$row_reservacion = mysql_fetch_assoc($reservacion);
$totalRows_reservacion = mysql_num_rows($reservacion);

if($totalRows_reservacion>=1){
echo "<script type=\"text/javascript\">alert ('Este pasajero ya tiene reservacion para esta salida');  location.href='fondo.php' </script>";
  exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.izq {	text-align: left;
	font-weight: bold;
}
.lados {
	border: medium ridge #0a405c;
	text-align: left;
	font-weight: bold;
}
.negrita {	font-weight: bold;
}
</style>
</head>
<script language="javascript">





function validar(){
var cont=0;
				if(document.form2.cedula.value!=""){
	 			var filtro = /^(\d)+$/i;
		        if (!filtro.test(document.getElementById('cedula').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN LA CEDULA DEL PASAJERO');
				return false;
		   		}
				}
				
				if(document.form2.cedula.value==""){
						alert("Debe ingresar la cedula del Pasajero");
						return false;
				}
				if(document.form2.nombres.value==""){
						alert("Debe ingresar los nombres del Pasajero");
						return false;
				}
				
				for(var i=1; i<=55; i++) {
				if (document.getElementById(i).checked==true){
					cont++;
					}
				}
				
				if(cont<=0){	
					alert("Debe seleccionar  un puesto");
					return false;		
				}
				if(cont>=2){	
					alert("Solo se acepta un pasaje por persona");
					return false;		
				}
				
				
		}
		

		
</script>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" onsubmit="return validar()" name="form2" id="form2">

<? if($totalRows_pasajeros<1){?>
  <table align="center" class="lados">
    <tr valign="baseline" >
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Venta Directa de Pasajes</td>
    </tr>
    <tr valign="baseline">
      <td width="154" align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Cedula del Pasajero:</td>
      <td width="318" bgcolor="#d8dfe5"><span class="izq">
        <input name="cedula" type="text" id="cedula" value="<?=$cedula?>" size="12" maxlength="8" readonly="readonly" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Nombres y Apellidos:</td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="nombres" type="text" id="nombres" value="" size="50" maxlength="50" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Telefono:</td>
      <td bgcolor="#d8dfe5"><span class="izq">
        <input name="telefono" type="text" value="" size="20" maxlength="11" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="left" nowrap="nowrap" bgcolor="#d8dfe5">Destino:</td>
      <td bgcolor="#d8dfe5"><label for="destino"></label>
        <select name="destino" id="destino">
          <option value="Maracay" selected="selected">Maracay</option>
          <option value="Valencia">Valencia</option>
          <option value="Caracas">Caracas</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5">Puestos</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="1" id="1"  <? if($puestos[1]==1) echo "disabled"; ?>/>
      1  
        <label for="1">
          <input type="checkbox" name="2" id="2"  <? if($puestos[2]==1) echo "disabled"; ?>/>
2
<input type="checkbox" name="3" id="3"  <? if($puestos[3]==1) echo "disabled"; ?> />
3
<input type="checkbox" name="4" id="4" <? if($puestos[4]==1) echo "disabled"; ?> /> 
4
<input type="checkbox" name="5" id="5" <? if($puestos[5]==1) echo "disabled"; ?>/>
5
<input type="checkbox" name="6" id="6" <? if($puestos[6]==1) echo "disabled"; ?>/>
6
<input type="checkbox" name="7" id="7" <? if($puestos[7]==1) echo "disabled"; ?>/>
7
<input type="checkbox" name="8" id="8" <? if($puestos[8]==1) echo "disabled"; ?> />
8
<input type="checkbox" name="9" id="9" <? if($puestos[9]==1) echo "disabled"; ?>/>
9
<input type="checkbox" name="10" id="10" <? if($puestos[10]==1) echo "disabled"; ?>/>
10
<input type="checkbox" name="11" id="11" <? if($puestos[11]==1) echo "disabled"; ?>/>
11
<input type="checkbox" name="12" id="12" <? if($puestos[12]==1) echo "disabled"; ?>/>
12
<input type="checkbox" name="13" id="13" <? if($puestos[13]==1) echo "disabled"; ?>/>
13
<input type="checkbox" name="14" id="14" <? if($puestos[14]==1) echo "disabled"; ?>/>
14
<input type="checkbox" name="15" id="15" <? if($puestos[15]==1) echo "disabled"; ?>/>
15
<input type="checkbox" name="16" id="16" <? if($puestos[16]==1) echo "disabled"; ?>/>
16</label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><label for="16">
    <input type="checkbox" name="17" id="17" <? if($puestos[17]==1) echo "disabled"; ?>/>
    17
    <input type="checkbox" name="18" id="18" <? if($puestos[18]==1) echo "disabled"; ?>/>
    18
    <input type="checkbox" name="19" id="19" <? if($puestos[19]==1) echo "disabled"; ?>/>
    19
    <input type="checkbox" name="20" id="20" <? if($puestos[20]==1) echo "disabled"; ?>/>
    20
    <input type="checkbox" name="21" id="21" <? if($puestos[21]==1) echo "disabled"; ?>/>
    21
    <input type="checkbox" name="22" id="22" <? if($puestos[22]==1) echo "disabled"; ?> />
    22
    <input type="checkbox" name="23" id="23" <? if($puestos[23]==1) echo "disabled"; ?>/>
    23
    <input type="checkbox" name="24" id="24" <? if($puestos[24]==1) echo "disabled"; ?>/>
    24
    <input type="checkbox" name="25" id="25" <? if($puestos[25]==1) echo "disabled"; ?>/>
    25
    <input type="checkbox" name="26" id="26" <? if($puestos[26]==1) echo "disabled"; ?>/>
    26
    <input type="checkbox" name="27" id="27" <? if($puestos[27]==1) echo "disabled"; ?>/>
    27
    <input type="checkbox" name="28" id="28" <? if($puestos[28]==1) echo "disabled"; ?>/>
    28
    <input type="checkbox" name="29" id="29" <? if($puestos[29]==1) echo "disabled"; ?>/>
    29
    <input type="checkbox" name="30" id="30" <? if($puestos[30]==1) echo "disabled"; ?>/>
    30
  </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="31" id="31" <? if($puestos[31]==1) echo "disabled"; ?>/>
31
  <label for="31">
    <input type="checkbox" name="32" id="32" <? if($puestos[32]==1) echo "disabled"; ?>/>
    32
    <input type="checkbox" name="33" id="33" <? if($puestos[33]==1) echo "disabled"; ?> />
    33
    <input type="checkbox" name="34" id="34" <? if($puestos[34]==1) echo "disabled"; ?>/>
    34
    <input type="checkbox" name="35" id="35" <? if($puestos[35]==1) echo "disabled"; ?>/>
    35
    <input type="checkbox" name="36" id="36" <? if($puestos[36]==1) echo "disabled"; ?>/>
    36
    <input type="checkbox" name="37" id="37" <? if($puestos[37]==1) echo "disabled"; ?>/>
    37
    <input type="checkbox" name="38" id="38" <? if($puestos[38]==1) echo "disabled"; ?>/>
    38
    <input type="checkbox" name="39" id="39" <? if($puestos[39]==1) echo "disabled"; ?>/>
    39
    <input type="checkbox" name="40" id="40"<? if($puestos[40]==1) echo "disabled"; ?> />
    40
    <input type="checkbox" name="41" id="41" <? if($puestos[41]==1) echo "disabled"; ?>/>
    41
  <input type="checkbox" name="42" id="42" <? if($puestos[42]==1) echo "disabled"; ?>/>
    42
    <input type="checkbox" name="43" id="43" <? if($puestos[43]==1) echo "disabled"; ?>/>
    43
    <input type="checkbox" name="44" id="44" <? if($puestos[44]==1) echo "disabled"; ?>/>
    44    </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="45" id="45" <? if($puestos[45]==1) echo "disabled"; ?>/>
45
  <label for="312">
    <input type="checkbox" name="46" id="46" <? if($puestos[46]==1) echo "disabled"; ?>/>
    46
    <input type="checkbox" name="47" id="47" <? if($puestos[47]==1) echo "disabled"; ?>/>
    47
    <input type="checkbox" name="48" id="48" <? if($puestos[48]==1) echo "disabled"; ?>/>
    48
    <input type="checkbox" name="49" id="49" <? if($puestos[49]==1) echo "disabled"; ?>/>
    49
    <input type="checkbox" name="50" id="50" <? if($puestos[50]==1) echo "disabled"; ?>/>
    50
    <input type="checkbox" name="51" id="51" <? if($puestos[51]==1) echo "disabled"; ?>/>
    51
    <input type="checkbox" name="52" id="52"<? if($puestos[52]==1) echo "disabled"; ?> />
    52
    <input type="checkbox" name="53" id="53" <? if($puestos[53]==1) echo "disabled"; ?>/>
    53
    <input type="checkbox" name="54" id="54" <? if($puestos[54]==1) echo "disabled"; ?>/>
    54
    <input type="checkbox" name="55" id="55" <? if($puestos[55]==1) echo "disabled"; ?>/>
    55</label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Comprar" /></td>
    </tr>
  </table>
<? }// fin del primer if ?>

<? if($totalRows_pasajeros==1){?>
<table width="638" align="center" class="lados">
<tr valign="baseline"></tr>
<tr valign="baseline" >
  <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Venta Directa  de Pasajes</td>
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
  <td align="left" nowrap="nowrap" bgcolor="#d8dfe5">Destino:</td>
  <td bgcolor="#d8dfe5"><label for="destino"></label>
    <select name="destino" id="destino">
      <option value="Maracay">Maracay</option>
      <option value="Valencia">Valencia</option>
      <option value="Caracas">Caracas</option>
    </select></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5">Puestos</td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="1" id="1"  <? if($puestos[1]==1) echo "disabled"; ?>/>
      1  
        <label for="1">
          <input type="checkbox" name="2" id="2"  <? if($puestos[2]==1) echo "disabled"; ?>/>
2
<input type="checkbox" name="3" id="3"  <? if($puestos[3]==1) echo "disabled"; ?> />
3
<input type="checkbox" name="4" id="4" <? if($puestos[4]==1) echo "disabled"; ?> /> 
4
<input type="checkbox" name="5" id="5" <? if($puestos[5]==1) echo "disabled"; ?>/>
5
<input type="checkbox" name="6" id="6" <? if($puestos[6]==1) echo "disabled"; ?>/>
6
<input type="checkbox" name="7" id="7" <? if($puestos[7]==1) echo "disabled"; ?>/>
7
<input type="checkbox" name="8" id="8" <? if($puestos[8]==1) echo "disabled"; ?> />
8
<input type="checkbox" name="9" id="9" <? if($puestos[9]==1) echo "disabled"; ?>/>
9
<input type="checkbox" name="10" id="10" <? if($puestos[10]==1) echo "disabled"; ?>/>
10
<input type="checkbox" name="11" id="11" <? if($puestos[11]==1) echo "disabled"; ?>/>
11
<input type="checkbox" name="12" id="12" <? if($puestos[12]==1) echo "disabled"; ?>/>
12
<input type="checkbox" name="13" id="13" <? if($puestos[13]==1) echo "disabled"; ?>/>
13
<input type="checkbox" name="14" id="14" <? if($puestos[14]==1) echo "disabled"; ?>/>
14
<input type="checkbox" name="15" id="15" <? if($puestos[15]==1) echo "disabled"; ?>/>
15
<input type="checkbox" name="16" id="16" <? if($puestos[16]==1) echo "disabled"; ?>/>
16</label></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><label for="16">
    <input type="checkbox" name="17" id="17" <? if($puestos[17]==1) echo "disabled"; ?>/>
    17
    <input type="checkbox" name="18" id="18" <? if($puestos[18]==1) echo "disabled"; ?>/>
    18
    <input type="checkbox" name="19" id="19" <? if($puestos[19]==1) echo "disabled"; ?>/>
    19
    <input type="checkbox" name="20" id="20" <? if($puestos[20]==1) echo "disabled"; ?>/>
    20
    <input type="checkbox" name="21" id="21" <? if($puestos[21]==1) echo "disabled"; ?>/>
    21
    <input type="checkbox" name="22" id="22" <? if($puestos[22]==1) echo "disabled"; ?> />
    22
    <input type="checkbox" name="23" id="23" <? if($puestos[23]==1) echo "disabled"; ?>/>
    23
    <input type="checkbox" name="24" id="24" <? if($puestos[24]==1) echo "disabled"; ?>/>
    24
    <input type="checkbox" name="25" id="25" <? if($puestos[25]==1) echo "disabled"; ?>/>
    25
    <input type="checkbox" name="26" id="26" <? if($puestos[26]==1) echo "disabled"; ?>/>
    26
    <input type="checkbox" name="27" id="27" <? if($puestos[27]==1) echo "disabled"; ?>/>
    27
    <input type="checkbox" name="28" id="28" <? if($puestos[28]==1) echo "disabled"; ?>/>
    28
    <input type="checkbox" name="29" id="29" <? if($puestos[29]==1) echo "disabled"; ?>/>
    29
    <input type="checkbox" name="30" id="30" <? if($puestos[30]==1) echo "disabled"; ?>/>
    30
  </label></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="31" id="31" <? if($puestos[31]==1) echo "disabled"; ?>/>
31
  <label for="31">
    <input type="checkbox" name="32" id="32" <? if($puestos[32]==1) echo "disabled"; ?>/>
    32
    <input type="checkbox" name="33" id="33" <? if($puestos[33]==1) echo "disabled"; ?> />
    33
    <input type="checkbox" name="34" id="34" <? if($puestos[34]==1) echo "disabled"; ?>/>
    34
    <input type="checkbox" name="35" id="35" <? if($puestos[35]==1) echo "disabled"; ?>/>
    35
    <input type="checkbox" name="36" id="36" <? if($puestos[36]==1) echo "disabled"; ?>/>
    36
    <input type="checkbox" name="37" id="37" <? if($puestos[37]==1) echo "disabled"; ?>/>
    37
    <input type="checkbox" name="38" id="38" <? if($puestos[38]==1) echo "disabled"; ?>/>
    38
    <input type="checkbox" name="39" id="39" <? if($puestos[39]==1) echo "disabled"; ?>/>
    39
    <input type="checkbox" name="40" id="40"<? if($puestos[40]==1) echo "disabled"; ?> />
    40
    <input type="checkbox" name="41" id="41" <? if($puestos[41]==1) echo "disabled"; ?>/>
    41
  <input type="checkbox" name="42" id="42" <? if($puestos[42]==1) echo "disabled"; ?>/>
    42
    <input type="checkbox" name="43" id="43" <? if($puestos[43]==1) echo "disabled"; ?>/>
    43
    <input type="checkbox" name="44" id="44" <? if($puestos[44]==1) echo "disabled"; ?>/>
    44    </label></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="left" nowrap="nowrap" bgcolor="#d8dfe5"><input type="checkbox" name="45" id="45" <? if($puestos[45]==1) echo "disabled"; ?>/>
45
  <label for="312">
    <input type="checkbox" name="46" id="46" <? if($puestos[46]==1) echo "disabled"; ?>/>
    46
    <input type="checkbox" name="47" id="47" <? if($puestos[47]==1) echo "disabled"; ?>/>
    47
    <input type="checkbox" name="48" id="48" <? if($puestos[48]==1) echo "disabled"; ?>/>
    48
    <input type="checkbox" name="49" id="49" <? if($puestos[49]==1) echo "disabled"; ?>/>
    49
    <input type="checkbox" name="50" id="50" <? if($puestos[50]==1) echo "disabled"; ?>/>
    50
    <input type="checkbox" name="51" id="51" <? if($puestos[51]==1) echo "disabled"; ?>/>
    51
    <input type="checkbox" name="52" id="52"<? if($puestos[52]==1) echo "disabled"; ?> />
    52
    <input type="checkbox" name="53" id="53" <? if($puestos[53]==1) echo "disabled"; ?>/>
    53
    <input type="checkbox" name="54" id="54" <? if($puestos[54]==1) echo "disabled"; ?>/>
    54
    <input type="checkbox" name="55" id="55" <? if($puestos[55]==1) echo "disabled"; ?>/>
    55</label></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Comprar" /></td>
</tr>
</table>
<p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <? }// fin del primer if ?>
    
  </p>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form2" />
  <input type="hidden" name="pasajero" value="<?=$totalRows_pasajeros?>" />
   <input type="hidden" name="salida" value="<?=$_POST["salida"]?>" />
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pasajeros);

mysql_free_result($salidas);

mysql_free_result($reservacion);
?>
