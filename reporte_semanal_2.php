<?php require_once('Connections/conexion.php'); 
require('fpdf/fpdf.php');


//obtener registro


class PDF extends FPDF
	{
var $widths;
var $aligns;

//Funcion para definir el tamaño de las columnas
	function SetWidths($w)
	{
    $this->widths=$w;
}
	 
	function SetAligns($a)
	{
	    $this->aligns=$a;
}
//Funcion para Mostrar los datos en filas 
function Row($data)
	{
    $nb=0;
    for($i=0;$i<count($data);$i++)
	        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
   $h=4*$nb;
   $this->CheckPageBreak($h);
	    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
	        $x=$this->GetX();
        $y=$this->GetY();
	        $this->Rect($x,$y,$w,$h);
	        $this->MultiCell($w,4,$data[$i],0,$a);
	        $this->SetXY($x+$w,$y);
		


    }
	    $this->Ln($h);
	}
	 
	function CheckPageBreak($h)
	{
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}
	 
	function NbLines($w,$txt)
	{
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
    $sep=-1;
	    $i=0;
    $j=0;
	    $l=0;
	    $nl=1;
    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
            $i++;
	            $sep=-1;
	            $j=$i;
            $l=0;
	            $nl++;
	            continue;
	        }
        if($c==' ')
	            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}
	 //Funcion Ppara el Encabeado
	function Header()
	{
		
		
    	//$this->Image('imagenes/Logo_gobierno.jpg',30,7,165);
	    $this->SetFont('Arial','B',10);
	    $this->Text(75,30,'Lista de Pasajeros del '.$_POST['desde'].'  al '.$_POST['hasta'].'',0,'C', 0);
	
    $this->Ln(15);
	//04263999925
	}
	 //funcion para el pie de Pagina
	function Footer()
	{
	    $this->SetY(-15);
	    $this->SetFont('Arial','B',10);
	    $this->Cell(100,10,'Inscata',0,0,'L');
	}
	}
	


// creamos el objeto FPDF
	$pdf=new PDF('P','mm','Letter'); // vertical, milimetros y tamaño
	$pdf->Open();
		 $pdf->SetFillColor(0,0,210);
	$pdf->AddPage(); // agregamos la pagina
	$pdf->SetMargins(10,10,10); // definimos los margenes en este caso estan en milimetros
	$pdf->Ln(10); // dejamos un pequeño espacio de 10 milimetros
	
	
		
//obtener los regsitro
mysql_select_db($database_conexion, $conexion);


// Para realizar esto utilizaremos la funcion Row()
	$pdf->SetFont('Times','B',9); // tipo y tamaño de letra
	$pdf->SetWidths(array(15,35,25,65,35,18)); // Definimos el tamaño de las columnas, tomando en cuenta que las declaramos en milimetros, ya que nuestra hoja esta en milimetro15s
	$pdf->SetDrawColor(0,0,210);
	$pdf->Row(array('Nro', 'Nombre y Apellidos', 'cedula', 'Destino', 'Nro de Puesto', 'Unidad')); // creamos nuestra fila con las columnas fecha(fecha de la visita al medico), medico(nombre del medico que nos atendio), consultorio y el diagnostico en esa visita
	$pdf->SetFont('Times','',9);
	$pdf->SetDrawColor(0,0,210);
	

	


		mysql_select_db($database_conexion, $conexion);
		$query_salidas = "SELECT * FROM salidas where fecha>='$_POST[desde]' and fecha<='$_POST[hasta]' order by fecha asc";
		$salidas = mysql_query($query_salidas, $conexion) or die(mysql_error());
		$row_salidas = mysql_fetch_assoc($salidas);

	do   {       
// Realizamos nuestra consulta
	$strConsulta2 = "SELECT * FROM ventas where salida='$row_salidas[id_salida]' order by puesto asc";
	$historial = mysql_query($strConsulta2, $conexion) or die(mysql_error());
	$fila = mysql_fetch_array($historial);   
	
		do{
	// los mostramos con la función Row
	$pdf->Row(array($i+1, $fila['nombres'], $fila['cedula'], $fila['destino'], $fila['puesto'], $row_salidas['autobus']));
		}while($fila = mysql_fetch_array($historial));
	   
	   
	    }while($row_salidas = mysql_fetch_assoc($salidas));
	//La ultima linea $pdf->Output(); lo que hace es cerrar el archivo y enviarlo al navegador.
$pdf->Output();


 ?>
