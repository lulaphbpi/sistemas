<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);
$conque=conexao('questionario');

$rotina='aplicarQuestionario-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$qsid=$_GET['id']; 

$spid=$_SESSION['spid'];
$statusservicoid=0;
$rpes=leservicopessoaid_fi($spid,$conefi);
if($rpes){
	$statusservicoid=$rpes['statusservico_id'];
	if(!($statusservicoid<4)){
		$_SESSION['msg']='Serviço Indisponível para alteração (Alta, Suspenso ou Cancelado - verifique). Não é possível alterar questionário.';	
		header ("Location: chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=$qsid");
		exit();
	}
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}

$rqs=lequestionarioservico($qsid);
$qid=$rqs['questionario_id'];
$rq=lequestionario($qid);
$titulo=$rq['titulo'];
$rquestao=flequestao($qid);
$ret='';
$agendaid=$_SESSION['agendaid'];
$tab1=leagendaoperador2($agendaid, 1, $conefi);
$statusagendaid=0;
if($tab1)
	$statusagendaid=$tab1['statusagenda_id'];
//statusagendaid==1
if($statusagendaid<>1){
	$_SESSION['msg']='Questionário Já Concluído ou Cancelado. Não é possível alterá-lo.';	
	header ("Location: chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=$qsid");
	exit();
}
//$t=ftrace('vai aplicarQuestionario-f1.php','qsid='.$qsid.' agendaid='.$agendaid);
$rqa1=lequestionarioaplicadoheader($qsid, $agendaid);
if($rqa1->rowCount()>0){
	$recrqa=$rqa1->fetch();
	$idrqa=$recrqa['id'];
	$rqa=lequestionarioaplicado($idrqa);
	if($rqa->rowCount()>0){
		$ssql = "delete from questionario where questionarioaplicado_id=$idrqa"; //die($ssql);
		$eexc = fexecutatransacao($ssql, $conefi);
	}
}	
foreach($rquestao->fetchAll() as $recq){
	$ord=$recq['ordem'];
	$tpq=$recq['id_tipoquestao'];
	if($tpq==1){
		$campo="q".fnumero($ord,3);
		$$campo=$_POST[$campo];
		//$ret=$ret.$campo.'='.$$campo.' / '.'<br>';
		$incluiquestionario=fregistraquestionario($idrqa, $ord, 1, $campo, $$campo);
	}else{
		if($tpq==2){
			$campo="q".fnumero($ord,3);
			$$campo=$_POST[$campo];
			$incluiquestionario=fregistraquestionario($idrqa, $ord, 1, $campo, $$campo);
			//$ret=$ret.$campo.'='.$$campo.' / '.'<br>';
		}else{
			if($tpq==3){
				$campo="q".fnumero($ord,3);
				$$campo=$_POST[$campo];
				$incluiquestionario=fregistraquestionario($idrqa, $ord, 1, $campo, $$campo);
				//$ret=$ret.$campo.'='.$$campo.' / '."<br>";
			}else{
				$idquestao=$recq['id'];
				$campo="q".fnumero($ord,3);
				$ropcao=fleopcao($idquestao);
				if($ropcao->rowCount()>0){
					foreach($ropcao->fetchAll() as $ropc){
						$ordop=fnumero($ropc['ordem'],3);
						$cpo=$campo.$ordop;
						$$cpo=$_POST[$cpo];
//						if($$cpo==null){
							//$ret=$ret.$cpo.'='.'Null'.' / '."<br>";
//						}else{	
							//$ret=$ret.$cpo.'='.$$cpo.' / '."<br>";
							$incluiquestionario=fregistraquestionario($idrqa, $ord, $ordop, $cpo, $$cpo);
//						}
					}
				}	
			}	
		}
	}
}
//die($ret);			
header ("Location: chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=$idrqa");
exit();
?>