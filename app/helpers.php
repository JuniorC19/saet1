<?php 

use Fpdf\Fpdf;

class PdfTuc extends Fpdf
{
    public function Header()
    {
        // $this->SetY(15);
        // $this->SetX(5);
    }
    public function Footer()
    {
        // $this->SetY(-15);
        // $this->SetFont('Arial','I',8);

        // $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
    }
} 

?>