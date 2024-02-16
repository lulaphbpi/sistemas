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

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$spid=$_GET['idc'];  // servicopessoaid

$qsid=0;
if(isset($_POST['questionarioservico_id']) && empty($_POST['questionarioservico_id']) == false){
	$qsid=$_POST['questionarioservico_id']; 
}else{
	if(isset($_GET['idx']) && empty($_GET['idx']) == false)
		$qsid=$_GET['idx'];
}	
if($qsid>0){
	$agendaid=$_SESSION['agendaid'];  // $trace=ftrace('registrarAvaliacaofisica-f1.php','qsid='.$qsid.'  agendaid='.$agendaid);
	$lequestionarioaplicado=lequestionarioaplicadoheader($qsid, $agendaid);
	if($lequestionarioaplicado->rowCount()==0){
		$data=date('Y-m-d');
		$id=fproximoid('questionarioaplicado',$conefi);
		$sql="insert into questionarioaplicado values (
			$id, $qsid, $agendaid, '$data')";
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
	}	
}
	
if(isset($_GET['del']) && empty($_GET['del']) == false){
	$fec=$_GET['del'];  
	if($fec=='concluir'){
		if(isset($_GET['idc']) && empty($_GET['idc']) == false){
			$idc=$_GET['idc'];
			$concluiagenda=fconcluiravaliacaofisica($idc);
			if($concluiagenda){
				$_SESSION['msg']="Avaliação Física Concluída";
			}	
		}
	}
}	
if($qsid>0)
	header ("Location: chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=$qsid");
else
	header ("Location: chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$spid");
?>