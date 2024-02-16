<?php
class PDF extends FPDF
{
var $col = 0;

function SetCol($col)
{
    // Move a posição para a coluna especificada
    $this->col = $col;
    $x = 10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    if($this->col<2)
    {
        // Vai para a próxima coluna
        $this->SetCol($this->col+1);
        $this->SetY(10);
        return false;
    }
    else
    {
        // Volta para a primeira coluna e permite a quebra de página
        $this->SetCol(0);
        return true;
    }
}
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
for($i=1;$i<=300;$i++)
    $pdf->Cell(0,5,"Line $i",0,1);
$pdf->Output();
?>