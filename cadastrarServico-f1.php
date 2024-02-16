<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa03.php');
$conefi=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$sistema=$_SESSION['sistema'];
$descricao = $_POST['descricao'];
$sigla = strtoupper($_POST['sigla']);
$ope='';
if(!($descricao=='')){
if($id>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from servico where id=$id";	
	}	
	else {
		$ope='atz';
		$sql = "update servico set 
			descricao= '$descricao',
			sigla= '$sigla'
			where id=$id";
	}		
}else{
	$id=fproximoid("servico", $conefi);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into servico (
			id, descricao, sigla) 
			values ($id, '$descricao', '$sigla') ";		
} 
//die(' sql:'.$sql);
$conefi->beginTransaction();/* Inicia a transação */
try {
	$i1= $conefi->query($sql);
	$hys=incluihystory('cadastrarservico-f1.php', $sql, $usu, $conefi);
	$conefi->commit();
	if($del=='del'){
		$_SESSION['msg']=' Serviço Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=servico&cpl=f1");
	}else{
		if($ope=='atz')
			$_SESSION['msg']=' Servico Atualizado com Sucesso!';
		else
			$_SESSION['msg']=' Servico Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=servico&cpl=f1&id=$id");
	}	
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']='ERRO: (cadastrarservico_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=servico&cpl=f1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarservico_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=servico&cpl=f1");
}	
?>
