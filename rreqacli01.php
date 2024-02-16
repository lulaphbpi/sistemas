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
$repident="rreqacli01";
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

//Ver Cabeçalho Inicial
$regbloco=flebloco($relatorioid,1,$confun);
if($regbloco){
	$st=utf8_decode($regbloco['conteudo']);
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
$id=$_GET['id'];
$registros=0;
$req=lerequisicao($id,$conacl);

if(!$req) die($_SESSION['erro']);
$rec=fleexamerequerido($id,$conacl);
foreach($rec->fetchAll() as $reg){
	$ids=$reg['id'];
	if($linha>$nrolinhas){
		if($vez<>1){
			$pdf -> AddPage();
		}
		$vez=2;	
		//Cabeçalho Página
//		$pdf -> SetMargins($margemleft, $margemtop, $margemright);
//		$pdf->Image('aclinica.png',2.8,1,5);
		$pag++;
		$regbloco=flebloco($relatorioid,2,$confun);
		if($regbloco){
			$st=utf8_decode($regbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			while($i<$tam){
				$pdf -> Ln();
				$li=$lin[$i];
				//echo('<br>i:'.$i.'-'.$li.'\n');
				if($i==1){
					$p=substr("00".$pag,-2);
					//die($p);
					$li=str_replace("@@",$p,$li);
					//die($li);
				}
				if($i==0){
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}
				if($i==2 || $i==6){
				}	
				if($i==3){
					$guia=$reg['guia'];
					$guia=fstring($guia,12);
					$li=fpreenche($li,$guia,"s");
					$datreq=$reg['datarequisicao'];
					$li=str_replace("@@/@@/@@@@",formataDataToBr($datreq),$li);
				}	
				if($i==4){
					$nompac=fstring($req['pessoanome'],50);
					$li=fpreenche($li,$nompac,"s");
					$sex=$req['sexo'];
					if($sex=='F') $sx='Fem';
					if($sex=='M') $sx='Mas';
					$li=fpreenche($li,$sx,"s");
					$idade=idade($req['datanascimento']);
					$sidade=fnumero($idade,2).' '.'anos';
					$li=fpreenche($li,$sidade,"s");
				}	
				if($i==5){
					$nommed=fstring(utf8_decode($req['mediconome']),50);
					$li=fpreenche($li,$nommed,"s");
					$crm=fstring($req['crm'],10);
					$li=fpreenche($li,$crm,"s");
					$esp=fstring(utf8_decode($req['especialidade']),30);
					$li=fpreenche($li,$esp,"s");
				}	
				//die('<br>'.$li);
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
			//die('--');
		}			
		//Cabeçalho Detalhe
		$regbloco=flebloco($relatorioid,3,$confun);
		if($regbloco){
			$st=utf8_decode($regbloco['conteudo']);
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
	$regbloco=flebloco($relatorioid,4,$confun);
	if($regbloco){
		$st=utf8_decode($regbloco['conteudo']);
		$lin=explode("\n",$st);
		$tam=sizeof($lin);
		$i=0;
		
		while($i<$tam){
			$cps=$lin[$i];
			$ids=fnumero($ids,5);
			if($i==0){
			$registros++;
			$ord=fnumero($registros,3);
			$cps=fpreenche($cps,$ord,"s");
			$sig=$reg['sigla'];
			$sig=fstring($sig,3);
			$cps=fpreenche($cps,$sig,"s");
			$exa=utf8_decode($reg['exame']);
			$exa=fstring($exa,50);
			$cps=fpreenche($cps,$exa,"s");
			$mat=utf8_decode($reg['tipodeamostra']);
			$mat=fstring($mat, 30);
			$cps=fpreenche($cps,$mat,"s");
			}
			if($i==1){
			$obs=utf8_decode($reg['observacao']);
			$obs=fstring($obs,70);
			$cps=fpreenche($cps,$obs,"s");
			}
			$pdf -> Ln();
			$pdf -> Write($alturalinha, $cps);
			$i++;
		}
	}			
	
}
$regbloco=flebloco($relatorioid,3,$confun);
if($regbloco){
	$st=utf8_decode($regbloco['conteudo']);
	$lin=explode("\n",$st);
	$pdf -> Ln();
	$pdf -> Write($alturalinha, $lin[1]);
}	
$pdf -> Ln();
$pdf -> Ln();$pdf -> Ln();
//$pdf -> Write($alturalinha, '               ------------- End of Report - '.$registros.' Registros Processados.');
$pdf -> Output();
?>
