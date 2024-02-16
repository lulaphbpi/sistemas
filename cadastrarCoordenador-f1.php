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

//$trace=ftrace('cadastrarCoordenador-f1.php', 'id='.$pid.'  idc='.$idc);
//$nome=addslashes($_POST['nome']);
//$crm=addslashes($_POST['crm']);

$sql=''; 

//$matricula=$_POST['matricula'];
//$servicoid=$_POST['servico_id'];

if($idc>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "update coordenador set ativo='N' where id=$idc";
		$idc=0;	
	}	
	else {
		$ope='atz';

		$sql = "update coordenador set 
			pessoa_id='$pid'
			where id=$idc";
	}		
}else{
	$ope='inc';
	$idc=fproximoid("coordenador", $conefi);
	$sql = "insert into coordenador (
			id, pessoa_id, ativo) values (
			$idc, $pid, 'S')";
			
}
//$trace=ftrace('cadastrarCoordenador-f1.php',$sql);
$conefi->beginTransaction();/* Inicia a transação */
try {
	if(!$sqle=='')
		$i1= $conefi->query($sqle);
	$i1= $conefi->query($sql);
	$hys=incluihystory('cadastrarCoordenador-f1.php', $sql, $usu, $conefi);
	$conefi->commit();
	if($del=='del'){
		$_SESSION['msg']=' Coordenador Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenador&cpl=f1");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Coordenador Atualizado com Sucesso!';
		}else
			$_SESSION['msg']=' Coordenador Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenador&cpl=f1&id=$pid&idc=$idc");
	}	
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']='ERRO: (cadastrarCoordenador_fi) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenador&cpl=f1");
}
header ("Location: chameFormulario.php?op=cadastrar&obj=Coordenador&cpl=f1&id=".$pid."&idc=".$idc);
exit();
?>