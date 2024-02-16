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
$repident="rcompexame";
$rreport=flereport($repident,$confun);
$secho='';
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
$nomerp="Componentes por Exame";
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
//$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);

//Ver Cabeçalho Inicial
$regbloco=flebloco($relatorioid,1,$confun);
if($regbloco){
	$st=utf8_decode($regbloco['conteudo']);
	$lin=explode("\n",$st);
	$tam=sizeof($lin);
	$i=0;
	while($i<$tam){
//		$pdf -> Ln();
//		$pdf -> Write($alturalinha, $lin[$i]);
		$i++;
	}
}
$vez=1; $minlinha=10;
$registros=0;
$rec=fleexame($conacl);
foreach($rec->fetchAll() as $reg){
	$ids=$reg['id'];
	$rcomp=flecomponentedeexame($ids,$conacl);
	if($linha>$nrolinhas){
		if($vez<>1){
			$pdf -> AddPage();
		}
		$vez=2;	
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
				if($i==1){
					$p=substr("00".$pag,-2);
					$li=str_replace("@@",$p,$li);
				}
				if($i==0){
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}
				if($i==2 || $i==6){
				}	
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
		}			
		//Cabeçalho Detalhe
		$regbloco=flebloco($relatorioid,3,$confun);
		if($regbloco){
			$st=utf8_decode($regbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			while($i<$tam){
				if($i==1){
					$salvatraco=$lin[$i];	
				}
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


		$y=$pdf -> getY();
		
//// Se posição próxima ao fim da página, imprime cabeçalho		
			if($y>20){
//// Início cabeçalho
		if($vez<>1){
			$pdf -> AddPage();
		}
		$vez=2;	
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
				if($i==1){
					$p=substr("00".$pag,-2);
					$li=str_replace("@@",$p,$li);
				}
				if($i==0){
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}
				if($i==2 || $i==6){
				}	
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
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
		$y=$pdf -> getY();
		$x=$pdf -> getX();
		$pdf -> SetX(3.556);
			$secho.=' --> y='.fnumero($y,5).' - x='.fnumero($x,5);
			//die($secho);
		$y=6.0;
		$pdf -> SetY($y);
//// Fim cabeçalho			
			}		
		
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
			$exa=utf8_decode($reg['descricao']);
			$exa=fstring($exa,65);
			$cps=fpreenche($cps,$exa,"s");
			$mat=utf8_decode($reg['material']);
			$mat=fstring($mat, 30);
			$cps=fpreenche($cps,$mat,"s");
			}
			if($i==1){
			$obs=utf8_decode($reg['observacao']);
			$obs=fstring($obs,95);
			$cps=fpreenche($cps,$obs,"s");
			}
			$pdf -> Ln();
			$pdf -> Write($alturalinha, $cps);
			$i++;
		}
		$temcomponente=false;
		foreach($rcomp->fetchAll() as $rcom){
		$y=$pdf -> getY();
		$x=$pdf -> getX();

//// Se posição próxima ao fim da página, imprime cabeçalho		
			if($y>20){
//// Início cabeçalho
		if($vez<>1){
			$pdf -> AddPage();
		}
		$vez=2;	
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
					$li=str_replace("@@",$p,$li);
				}
				if($i==0){
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}
				if($i==2 || $i==6){
				}	
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
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
		$y=$pdf -> getY();
		$x=$pdf -> getX();
		$pdf -> SetX(3.556);
			$secho.=' --> y='.fnumero($y,5).' - x='.fnumero($x,5);
		$y=6.0;
		$pdf -> SetY($y);
//// Fim cabeçalho			
			}
			
		$pdf -> SetX(3.556);
		$y=$pdf -> getY();	
			$c1=utf8_decode($rcom['descricao']).' '.utf8_decode($rcom['unidade']);
			$r1=utf8_decode($rcom['referencia']);
			$m1=utf8_decode($rcom['metodo']);
			$secho.=' y='.fnumero($y,5).' - x='.fnumero($x,5);
			$pdf -> MultiCell(10, 0.3, $c1, 0, 'J', false);
			$x=$pdf -> getX();
			$pdf -> setXY($x+8.2, $y);
			$pdf -> MultiCell(5, 0.3, $r1, 0, 'J', false);
			$y1=$pdf -> getY();
			$x=$pdf -> getX();
			$pdf -> setXY($x+14.2, $y);
			$pdf -> MultiCell(4.2, 0.3, $m1, 0, 'J', false);

			$y=$pdf -> getY();
			if($y1>$y){
				$y=$y1;
			}
			$pdf -> setXY($x, $y);
			//$pdf -> Ln();
			//$pdf -> Write($alturalinha, $salvatraco);
			//$temcomponente=true;
		}	
	}			
	if(!$temcomponente){
		$pdf -> Ln();
		$pdf -> Write($alturalinha, $salvatraco);
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
$pdf -> Output();
?>
