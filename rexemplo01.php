<?php
header('Content-type: text/html; charset=utf-8');
if(!isset($_SESSION)){session_start();}
date_default_timezone_set('America/Fortaleza');
include('../include/sa000.php');
include('varreport.php');
$confun=conexao('funcional');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');
//Ler Relatorio
$repident="rexa01";
$rreport=flereport($repident,$confun);
//Inicializar Parametros
if($rreport){
	$relatorioid=$rreport['id'];
	$reptit=utf8_decode($rreport['titulo']);
	$idestilo=$rreport['estilo_id'];
	$restilo=fleestilo($idestilo,$confun);
	if($restilo){
		$papel=$restilo['papel'];
		$orientacao=$restilo['orientacao'];
		$fonte=$restilo['fonte'];
		$estilo=$restilo['estilo'];
		$nrolinhas=$restilo['nrolinhas'];
		$nrolinhas=30;
		$nrocolunas=$restilo['nrocolunas'];
		$alturalinha=$restilo['alturalinha'];
	}	
}else{
	$_SESSION['msg'] = 'Relatório Não Encontrado:'.$repident;
	//header ('Location: chameFormulario.php?op=consulta&obj=Associacao');
	return;	
}
//Inicializar Contadores
$pag=0; $linha=100; $data=date("d/m/Y");
//Inicializa Report
$nomerp="Lista de Exames";
require_once '../fpdf/fpdf.php';
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('aclinica.png',2.8,1,5);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    //$this->Cell(1);
    // Title
    $this->Cell(25,3,utf8_decode('Laboratório de Análises Clínicas'),1,0,'C');
    // Line break
    //$this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,25,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
//$pdf = new PDF();
//$pdf->AliasNbPages();
//$pdf->AddPage();
//$pdf->SetFont('Times','',12);
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
//$pdf->Output();

$pdf = new PDF($orientacao,$unidade,$papel);
$pdf -> SetMargins($margemleft, $margemtop, $margemright);
$pdf -> SetAuthor($author);
$pdf -> SetTitle($titdoc);
$pdf -> AddPage();
$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);
$pdf -> SetFont('Arial', 'B', 8);
$tx="Prints a character string. The origin is on the left of the first character, on the baseline. \nThis method allows to place a string precisely on the page, but it is usually easier to use Cell(), MultiCell() or Write() which are the standard methods to print text.";
$pdf -> Ln();
$pdf -> Write($alturalinha, $tx);
$pdf -> Ln();
$pdf -> Ln();
$y=$pdf -> getY();
$pdf -> MultiCell(10, 0.3, $tx, 0, 'J', false);
$pdf -> Ln();
$pdf -> Ln();
$x=$pdf -> getX();
$pdf -> setXY($x+10.2, $y);
$pdf -> MultiCell(5, 0.3, $tx, 0, 'J', false);
$vez=1; $minlinha=10;
$pdf -> Ln();
$pdf -> Ln();$pdf -> Ln();
$pdf -> Output();
?>
