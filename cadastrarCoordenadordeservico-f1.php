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

//$trace=ftrace('cadastrarCoordenadordeservico-f1.php', 'id='.$pid.'  idc='.$idc);
//$nome=addslashes($_POST['nome']);
//$crm=addslashes($_POST['crm']);

$sql=''; 

$crefito=$_POST['crefito'];
$servicoid=$_POST['servico_id'];
//$t=ftrace('cadastrarCoordenadordeservico-f1','Crefito:'.$crefito.'  idc:'.$idc);
if($idc>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from coordenadordeservico where id=$idc";
		$sql = "update coordenadordeservico set ativo='N' where id=$idc";
		$idc=0;	
	}	
	if($del=='des'){
		$ope='des';
		$sql = "update coordenadordeservico set ativo='N' where id=$idc";
		$idc=0;	
	}	
	if($del=='ati'){
		$ope='ati';
		$sql = "update coordenadordeservico set ativo='S' where id=$idc";
		$idc=0;	
	}	
	if($del=='atz'){
		$ope='atz';
		$sql = "update coordenadordeservico set 
			crefito='$crefito',
			servico_id='$servicoid'
			where id=$idc"; 
		$idc=0;	
	}	
$trace=ftrace('cadastrarCoordenadordeservico-f1.php',$sql);
}else{
	$ope='inc';
	$idc=fproximoid("coordenadordeservico", $conefi);
	$sql = "insert into coordenadordeservico (
			id, pessoa_id, servico_id, crefito, ativo) values (
			$idc, $pid, '$servicoid', '$crefito', 'S')";
			
}
//$trace=ftrace('cadastrarCoordenadordeservico-f1.php',$sql);
$conefi->beginTransaction();/* Inicia a transação */
try {
	if(!$sql=='')
		$i1= $conefi->query($sql);
	//$i1= $conefi->query($sql);
	$hys=incluihystory('cadastrarCoordenadordeservico-f1.php', $sql, $usu, $conefi);
	$conefi->commit();
	if($del=='del'){
		$_SESSION['msg']=' Coordenador de Servico Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenadordeservico&cpl=f1");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Coordenador de Servico Atualizado com Sucesso!';
		}else
			$_SESSION['msg']=' Coordenador de Servico Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenadordeservico&cpl=f1&id=$pid");
	}	
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']='ERRO: (cadastrarCoordenadordeservico_fi) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenadordeservico&cpl=f1");
}
header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenadordeservico&cpl=f1&id=".$pid."&idc=".$idc);
exit();
?>