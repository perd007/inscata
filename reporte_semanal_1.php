<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
<style type="text/css">
 @import url("jscalendar-1.0/calendar-win2k-cold-1.css");
.izq {text-align: left;
	font-weight: bold;
}
.lados {border: medium ridge #0a405c;
}
.negrita {font-weight: bold;
}
</style>
</head>
<script language="javascript">

function validar(){

				if(document.form1.desde.value==""){
						alert("Debe ingresar una fecha inicial");
						return false;
				}
				if(document.form1.hasta.value==""){
						alert("Debe ingresar una fecha final");
						return false;
				}
				
				
		}
</script>
<body>
<form method="post" onsubmit="return validar()" name="form1" id="form1" action="reporte_semanal_2.php">
  <p>&nbsp;</p>
  <table width="359" align="center" class="lados">
    <tr valign="baseline" >
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5" class="negrita" >Reporte Semanal</td>
    </tr>
    <tr valign="baseline">
      <td width="92" align="left" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Desde:</td>
      <td width="249" bgcolor="#d8dfe5"><label for="salida">
        <input name="desde" type="text" id="desde" value="" size="20" maxlength="10" readonly="readonly" />
        <button type="submit" id="cal-button-1" title="Clic Para Escoger la fecha">Fecha</button>
        <script type="text/javascript">
							Calendar.setup({
							  inputField    : "desde",
							  ifFormat   : "%Y-%m-%d",
							  button        : "cal-button-1",
							  align         : "Tr"
							});
						  </script>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="left" nowrap="nowrap" bgcolor="#d8dfe5" class="izq">Hasta:</td>
      <td bgcolor="#d8dfe5"><input name="hasta" type="text" id="hasta" value="" size="20" maxlength="10" readonly="readonly" />
        <button type="submit" id="cal-button-2" title="Clic Para Escoger la fecha">Fecha</button>
      <script type="text/javascript">
							Calendar.setup({
							  inputField    : "hasta",
							  ifFormat   : "%Y-%m-%d",
							  button        : "cal-button-2",
							  align         : "Tr"
							});
						  </script></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#d8dfe5"><input type="submit" class="negrita" value="Generar" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>