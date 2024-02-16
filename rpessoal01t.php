<?php
header('Content-type: text/html; charset=utf-8');
if(!isset($_SESSION)){session_start();}

include("include/finc.php");
$conpes=conexao(BPESSOAL);
$confun=conexao('funcional');
$conefi=conexao(BEFISIO);

include('varreport.php');

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
$pdf = new FPDF($orientacao,$unidade,$papel);
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
		$pdf -> SetMargins($margemleft, $margemtop, $margemright);
		$pdf->Image('img\consnae.png',2.8,1,5);
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
				}elseif($i==1){
					$orgao=fstring(utf8_decode('CONSULTÓRIO MÉDICO DO NAE'),50);
					$li=fpreenche($li,$orgao,"s");
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}elseif($i==3){
					$tit=fstring(utf8_decode('Relação Geral de Pessoas - Alfabética'),50);
					$li=fpreenche($li,$tit,"s");
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
