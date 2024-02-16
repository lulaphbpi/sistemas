<?php
header('Content-type: text/html; charset=utf-8');
if(!isset($_SESSION)){session_start();}

include('../include/sa000.php');
include('varreport.php');
$confun=conexao('funcional');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');
//Ler Relatorio
$repident="rpes01";
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
$nomerp="Lista de Pessoal";
require_once '../fpdf/fpdf.php';

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('aclinica.png',1.6,1,5);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
//$pdf = new FPDF($orientacao,$unidade,$papel);
$pdf = new PDF($orientacao,$unidade,$papel);

$pdf -> SetMargins($margemleft, $margemtop, $margemright);
$pdf -> SetAuthor($author);
$pdf -> SetTitle($titdoc);
$pdf -> AddPage();
$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);

//Ver Cabeçalho Inicial
$recbloco=flebloco($relatorioid,1,$confun);
if($recbloco){
	$st=utf8_decode($recbloco['conteudo']);
	$lin=explode("\n",$st);
	$tam=sizeof($lin);
	$i=0;
	while($i<$tam){
		$pdf -> Ln();
		$pdf -> Write($alturalinha, $lin[$i]);
		$i++;
	}
}
$vez=1;
//Ler Query
//echo('NroLinhas'.$nrolinhas.' NroColunas:'.$nrocolunas);
$registros=0;
$rec=flePessoaAclinica($conacl);
if(!$rec) die($_SESSION['erro']);
foreach($rec->fetchAll() as $reg){
	$ids=$reg['id'];
	if($linha>$nrolinhas){
		if($vez<>1){
			$pdf -> AddPage();
		}
		$vez=2;	
		//Cabeçalho Página
		$pag++;
		$recbloco=flebloco($relatorioid,2,$confun);
		if($recbloco){
			$st=utf8_decode($recbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			while($i<$tam){
				$pdf -> Ln();
				$li=$lin[$i];
				//echo('<br>i:'.$i.'-'.$li.'\n');
				if($i==0){
					$p=substr("00".$pag,-2);
					//die($p);
					$li=str_replace("@@",$p,$li);
					//die($li);
				}else{
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}
				//die('<br>'.$li);
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
			//die('--');
		}			
		//Cabeçalho Detalhe
		$recbloco=flebloco($relatorioid,3,$confun);
		if($recbloco){
			$st=utf8_decode($recbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			while($i<$tam){
				$pdf -> Ln();
				$pdf -> Write($alturalinha, $lin[$i]);
				$i++;
			}
		}			
		$linha=$minlinha;
	}
	$linha++;
	//Detalhe
	$recbloco=flebloco($relatorioid,4,$confun);
	if($recbloco){
		$st=utf8_decode($recbloco['conteudo']);
		$lin=explode("\n",$st);
		$tam=sizeof($lin);
		$i=0;
		while($i<$tam){
			$cps=$lin[$i];
			$ids=fnumero($ids,5);
			$cps=fpreenche($cps,$ids,"n");
			$alcunha=fstring($reg['denominacaocomum'],15);
			$cps=fpreenche($cps,$alcunha,"s");
			$nome=fstring(utf8_decode($reg['nome']),39);
			$cps=fpreenche($cps,$nome,"s");
			$datanasc=fstring($reg['datanascimento'],10);
			$cps=fpreenche($cps,$datanasc,"s");
			$sexo=fstring($reg['sexo'],1);
			$cps=fpreenche($cps,$sexo,"s");
			$fone=fstring($reg['fone'],22);
			$cps=fpreenche($cps,$fone,"s");
			$email=fstring(str_replace('@','#',$reg['email']),29);
			$cps=fpreenche($cps,$email,"s");
			$natureza=fstring($reg['naturezadapessoa'],19);
			$cps=fpreenche($cps,$natureza,"s");
			$cps=str_replace('#','@',$cps);

			$pdf -> Ln();
			$pdf -> Write($alturalinha, $cps);
			$registros++;
			$i++;
		}
	}			
	
}
$pdf -> Ln();
$pdf -> Write($alturalinha, '               ------------- Fim Report - '.$registros.' Registros Processados.');
$pdf -> Output();
?>
