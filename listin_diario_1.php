<?php require_once('Connections/conexion.php'); ?>
<?


mysql_select_db($database_conexion, $conexion);
$query_salidas = "SELECT * FROM salidas where confirmada=1";
$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
$row_salidas = mysql_fetch_assoc($salidas);
$totalRows_salidas = mysql_num_rows($salidas);

if($totalRows_salidas<=0){
	echo "<script type=\"text/javascript\">alert ('No existen salidas Confirmadas');  location.href='registro_salidas.php' </script>";
	exit;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.izq {text-align: left;
	font-weight: bold;
}
.lados {border: medium ridge #0a405c;
}
.negrita {font-weight: bold;
}
</style>
</head>

<body>
<form method="post" onsubmit="return validar()" name="form1" id="form1" action="listin_diario.php">
  <p>&nbsp;</p>
  <table width="255" align="center" class="lados">
    <tr valign="baseline" >
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Imprimir Listin</td>
    </tr>
    <tr valign="baseline">
      <td width="138" align="left" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Salida:</td>
      <td width="175" bgcolor="#d8dfe5"><label for="salida"></label>
        <select name="salida" id="salida">
          <?php
do {  
?>
          <option value="<?php echo $row_salidas['id_salida']?>"><?php echo $row_salidas['fecha']?> <?php echo $row_salidas['destino']?></option>
          <?php
} while ($row_salidas = mysql_fetch_assoc($salidas));
  $rows = mysql_num_rows($salidas);
  if($rows > 0) {
      mysql_data_seek($salidas, 0);
	  $row_salidas = mysql_fetch_assoc($salidas);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Imprimir" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>