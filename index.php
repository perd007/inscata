<?php require_once('Connections/conexion.php'); ?>
<?php
session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

//recepcion de datos
$usuario= $_POST["usuario"];
$contrasena= $_POST["clave"];

mysql_select_db($database_conexion, $conexion);
//ejecucuion de la sentemcia sql
$sql="select usuario from usuarios where usuario='$usuario' and clave='$contrasena'";
$resultado= mysql_query($sql)or die(mysql_error());
$fila=mysql_fetch_array($resultado);

//verificar si  son validos los datos
if($fila["usuario"]!=$usuario){
echo "<script type=\"text/javascript\">alert ('Usted no es un usuario registrado');  location.href='index.php' </script>";
exit;
}
else{



header("Location:Principal.php");

}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0155)http://webcache.googleusercontent.com/search?q=cache:OSe-XuxLYKoJ:www.me.gob.ve/+ministerio+de+educacion+venezuela&cd=1&hl=es&ct=clnk&source=www.google.com -->
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="estilos.css" rel="stylesheet" type="text/css" />
<!--<base href="http://www.me.gob.ve/index.php">-->
<base href="." />
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_0503104418_0) return;
              window.mm_menu_0503104418_0 = new Menu("root",77,18,"",12,"#000000","#FFFFFF","#CCCCCC","#000084","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_0503104418_0.addMenuItem("Registro","location='Principal.php?link=link7'");
  mm_menu_0503104418_0.addMenuItem("Consulta","location='Principal.php?link=link71'");
   mm_menu_0503104418_0.hideOnMouseOut=true;
   mm_menu_0503104418_0.bgColor='#555555';
   mm_menu_0503104418_0.menuBorder=1;
   mm_menu_0503104418_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0503104418_0.menuBorderBgColor='#777777';

mm_menu_0503104418_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
#menu8 {        width: 200px;
        margin-top: 10px;
}
.lb {
	color: #FFF;
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
		  
   }
   
//-->
</script>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" background="./Ministerio del Poder Popular para la Educación_files/fondo.jpg" >

<script language="JavaScript1.2">mmLoadMenus();
ventana=windows.open("principal.php");
</script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td width="3"></td>
      <td width="574" style="padding-top:5px;"><!-- Columna de Contenido Central -->
        <!-- Fin de Columna de Contenido Central -->
        <form id="form1" name="form1" onsubmit="return validar()" method="post" action="<?php echo $editFormAction; ?>">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <table width="780" height="383" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
            <tr>
              <td height="56" align="center"><img src="imagenes/LOGO INSCATA 3 - copia.jpg" width="886" height="161" /></td>
            </tr>
            <tr valign="top" align="left">
              <td width="676" height="278" valign="top"><p>&nbsp;</p>
                <p>&nbsp;</p>
                <table width="34%" border="1" class="bordes" align="center" bgcolor="#000000">
                  <tr bgcolor="#CCCCCC">
                  <th colspan="2" bgcolor="#0a405c" align="center" class="lb" scope="col">Ingreso al Sistema </th>
                </tr>
                <tr bgcolor="#CCCCCC">
                  <td width="33%" bgcolor="#0a405c" class="lb"><div align="right"><strong><em>Usuario:</em></strong></div></td>
                  <td width="67%" bgcolor="#0a405c"><label>
                    <input name="usuario" type="text" id="usuario" maxlength="20" />
                  </label></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                  <td bgcolor="#0a405c" class="lb"><div align="right"><strong><em>Clave:</em></strong></div></td>
                  <td bgcolor="#0a405c"><input name="clave" type="password" id="clave" maxlength="10" /></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                  <td height="28" colspan="2" bgcolor="#0a405c"><div align="center">
                    <input type="submit" name="Submit2" value="Ingresar" />
                  </div></td>
                </tr>
            </table></td>
            </tr>
            <tr>
              <td height="21" bgcolor="#0a405c">&nbsp;</td>
            </tr>
          </table>
          <p>
            <input type="hidden" name="MM_insert" value="form1" />
          </p>
        </form></td>
    </tr>
  </tbody>
</table>
</body></html>