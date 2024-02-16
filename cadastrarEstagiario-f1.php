<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['identificacao'];

$id=0; $idc=0;
$msg='';
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pid=$_GET['id'];

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

//$trace=ftrace('cadastrarEstagiario-f1.php', 'id='.$pid.'  idc='.$idc);
//$nome=addslashes($_POST['nome']);
//$crm=addslashes($_POST['crm']);

$sql=''; 

$matricula=$_POST['matricula'];

if($idc>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from estagiario where id=$idc";
		$idc=0;	
	}	
	if($del=='des'){
		$ope='des';
		$sql = "update estagiario set ativo='N' where id=$idc";
		$idc=0;	
	}	
	if($del=='ati'){
		$ope='ati';
		$sql = "update estagiario set ativo='S' where id=$idc";
		$idc=0;	
	}	
	if($del=='atz'){
		$ope='atz';
		$sql = "update estagiario set 
			matricula='$matricula'
			where id=$idc"; 
		$idc=0;	
	}	
}else{
	$ope='inc';
	$idc=fproximoid("estagiario", $conefi);
	$sql = "insert into estagiario (
				id, pessoa_id, matricula, ativo) values (
				$idc, $pid, '$matricula', 'S')";
				
}
//$trace=ftrace('cadastrarEstagiario-f1.php',$sql);
$conefi->beginTransaction();/* Inicia a transação */
try {
	if(!$sql=='')
		$i1= $conefi->query($sql);
	$i1= $conefi->query($sql);
	$hys=incluihystory('cadastrarEstagiario-f1.php', $sql, $usu, $conefi);
	$conefi->commit();
	if($del=='del'){
		$_SESSION['msg']=' Estagiário Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=estagiario&cpl=f1");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Estagiário Atualizado com Sucesso!';
		}else
			$_SESSION['msg']=' Estagiário Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=estagiario&cpl=f1&id=$pid");
	}	
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']='ERRO: (cadastrarestagiario_fi) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=estagiario&cpl=f1");
}
header ("Location: chameFormulario.php?op=cadastrar&obj=estagiario&cpl=f1&id=".$pid."&idc=".$idc);
exit();
?>