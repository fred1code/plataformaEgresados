
<?php
	require 'fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('../img/logo.png', 30, 5, 23 );
			$this->SetFont('Arial','B',14);
			$this->Cell(30);
			$this->Cell(150,10, 'Universidad de g ',0,1,'R');
		    $this->Cell(210, 10, 'Reporte de Egresados', 0, 0, 'R');
			$this->Ln(20);
	
		}
		
		function Footer()
		{
			
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}