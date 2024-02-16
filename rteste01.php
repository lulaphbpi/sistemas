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
		//$nrolinhas=30;
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

$pdf = new PDF($orientacao,$unidade,$papel);
$pdf -> SetMargins($margemleft, $margemtop, $margemright);
$pdf -> SetAuthor($author);
$pdf -> SetTitle($titdoc);
$pdf -> AddPage();
$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);

$vez=1; $minlinha=10;
$registros=0;

$pdf -> Ln();
$pdf -> Ln();$pdf -> Ln();
//$pdf -> Write($alturalinha, '               ------------- End of Report - '.$registros.' Registros Processados.');
$pdf -> Output();
?>
