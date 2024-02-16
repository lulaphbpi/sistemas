<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$rotina='registrarAvaliacaofisica-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}
$usuid=$_SESSION['usuarioid'];

$spid=0; $agendaid=0;
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$spid=$_GET['idc'];  // servicopessoaid

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$agendaid=$_GET['id'];  // servicopessoaid

$qsid=0;
if(isset($_POST['questionarioservico_id']) && empty($_POST['questionarioservico_id']) == false){
	$qsid=$_POST['questionarioservico_id']; 
}else{
	if(isset($_GET['idx']) && empty($_GET['idx']) == false)
		$qsid=$_GET['idx'];
}	
if($qsid>0){
	//$agendaid=$_SESSION['agendaid'];  
	$trace=ftrace('registrarAvaliacaofisica-f1.php','qsid='.$qsid.'  agendaid='.$agendaid);
	$lequestionarioaplicado=lequestionarioaplicadoheader($qsid, $agendaid);
	if($lequestionarioaplicado->rowCount()==0){
		$data=date('Y-m-d');
		$idqa=fproximoid('questionarioaplicado',$conefi);
		$sql="insert into questionarioaplicado values (
			$idqa, $qsid, $agendaid, '$data', null, null, 0, 0)";
		$conefi->beginTransaction();/* Inicia a transação */
		try {
			$i1= $conefi->query($sql);
			$hys=incluihystory('registrarAvaliacaofisica-f1.php', $sql, $usuid, $conefi);
			$conefi->commit();
			$_SESSION['msg']=$msg.' Questionário Aplicado Iniciado com Sucesso!';
		} catch(PDOException $e) {
			$conefi->rollback();
			$_SESSION['msg']=$msg.' ERROR exception: (registrarAvaliacaofisica-f1) ' . $e->getMessage(). ' '. $sql;
			header ("Location: chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$spid");
			exit();
		}	
	}else{
		$rlqa=$lequestionarioaplicado->fetch();
		$idqa=$rlqa['id'];
	}	
}
	
if(isset($_GET['del']) && empty($_GET['del']) == false){
	$fec=$_GET['del'];  
	if($fec=='concluir'){
		$concluiagenda=fconcluiravaliacaofisica($agendaid, $spid, $conefi);
		if($concluiagenda){
			$_SESSION['msg']="Avaliação Física Concluída";
		}	
	}
}	
if($qsid>0)
	header ("Location: chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=$idqa");
else
	header ("Location: chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid&idc=$spid");
?>