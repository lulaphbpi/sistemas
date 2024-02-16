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
$repident="rmapareq01";
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
		//$nrolinhas=30;
		$nrocolunas=$restilo['nrocolunas'];
		$alturalinha=$restilo['alturalinha'];
	}	
}else{
	$_SESSION['msg'] = 'Relatório Não Encontrado:'.$repident;
	//header ('Location: chameFormulario.php?op=consulta&obj=Associacao');
	return;	
}
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
//$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);

//Inicializar Contadores
$pag=0; $linha=100; $data=date("d/m/Y");
$vez=1; $minlinha=16;
$registros=0; $ord=0;

//Inicializa Report
$nomerp="Componentes por Exame";

//Le registros
$rec=flemaparequisicao($conacl);
/////////////////////////////////////// loop principal
$exame=0;
foreach($rec->fetchAll() as $reg){
	$ord++;
	$ide=$reg['exame_id'];
	if($ide<>$exame){
		//// muda de pagina

		if($linha>$nrolinhas){
			if($vez<>1){
				$pdf -> AddPage();
			}
			$vez=2;	
			$pag++;
			//cabecalho de pagina
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
			$linha=$minlinha;
		}

		//// fim muda de pagina
		$regbloco=flebloco($relatorioid,5,$confun);
		$cps='';
		if($regbloco){
			$st=utf8_decode($regbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			$cps=$lin[$i];
			$sig=$reg['sigla'];
			$sig=fstring($sig,3);
			$cps=fpreenche($cps,$sig,"s");
			$exa='-'.utf8_decode($reg['exame']);
			$exa=fstring($exa,57);
			$cps=fpreenche($cps,$exa,"s");
			$mat=utf8_decode($reg['material']);
			$mat=fstring($mat, 30);
			$cps=fpreenche($cps,$mat,"s");
			$pdf -> Ln();
			$pdf -> Write($alturalinha, $cps);
			$linha++;
			$i++;
		}	
		$exame=$ide;
	}
	$pid=0;
	$pessoaid=$reg['pessoa_id'];
	
	//Le Campo Detalhe
	$regbloco=flebloco($relatorioid,3,$confun);
	if($regbloco){
		$st=utf8_decode($regbloco['conteudo']);
		$lin=explode("\n",$st);
		$tam=sizeof($lin);
		$i=0;
		$traco=$lin[1];
		while($i<$tam-1){
				//if($i==1){
				//	$salvatraco=$lin[$i];	
				//}
				$cps=$lin[$i];
				$nome=$reg['nome'];
				$nome=fstring($nome,40);
				$cps=fpreenche($cps,$nome,"s");
				$dtn=$reg['datanascimento'];
				$idade=idade($dtn);
				$sidade=fnumero($idade,3).' anos';
				$cps=fpreenche($cps,$sidade,"s");
				$sex=$reg['sexo'];
				if($sex='M'){
					$ssex='Mas';
				}else{
					$ssex='Fem';
				}
				$cps=fpreenche($cps,$ssex,"s");
				$guia=$reg['guia'];
				$guia=fstring($guia, 12);
				$cps=fpreenche($cps,$guia,"s");
				$pdf -> SetFont($fonte,'B',$tamanhofonte);

				$pdf -> Ln();
				$pdf -> Write($alturalinha, $cps);
				$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);
				$i++;
				$linha++;
		}
	}	
	$rcomp=flecomponentedeexame($ide,$conacl);
	$regbloco=flebloco($relatorioid,4,$confun);
	$linx='';
	if($regbloco){
		$st=utf8_decode($regbloco['conteudo']);
		$lin=explode("\n",$st);
		$tam=sizeof($lin);
		$i=0;
		$linx=$lin[0];
	}
	foreach($rcomp->fetchAll() as $rcom){
			$cps=$linx;
//// Se posição próxima ao fim da página, imprime cabeçalho		
		//// muda de pagina

		if($linha>$nrolinhas){
			if($vez<>1){
				$pdf -> AddPage();
			}
			$vez=2;	
			$pag++;
			//cabecalho de pagina
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
			$linha=$minlinha;
		}

		//// fim muda de pagina


			$nvalor=$rcom['nvalor'];
			$c1=utf8_decode($rcom['descricao']);
			$u1=utf8_decode($rcom['unidade']);
			$r1='______________________________';
			if($nvalor==0){
				$r1=' ';
			}elseif($nvalor==1){
			}else{
			$r1='______________  ______________';
			}	
			if($nvalor<>0)
				$c1=' - '.$c1;
			$c1=fstring($c1,40);
			$cps=fpreenche($cps,$c1,"s");
			$r1=fstring($r1,30);
			$cps=fpreenche($cps,$r1,"s");
			$u1=fstring($u1,10);
			$cps=fpreenche($cps,$u1,"s");
			$pdf -> Ln();
			if($nvalor==0)
				$pdf -> SetFont($fonte,'B',$tamanhofonte);
			else	
				$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);
			$pdf -> Write($alturalinha, $cps);
			$temcomponente=true;
			$linha++;
	}	
	if($temcomponente){
		$pdf -> Ln();
		$pdf -> Write($alturalinha, $traco);
	}
}

$pdf -> Ln();
$pdf -> Ln();$pdf -> Ln();
$pdf -> Output();
?>