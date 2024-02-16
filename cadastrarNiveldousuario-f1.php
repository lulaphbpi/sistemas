<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$conefe=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$sistema=$_SESSION['sistema'];
$descricao = $_POST['descricao'];
$ope='';
if(!($descricao=='')){
if($id>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from niveldousuario where id=$id";	
	}	
	else {
		$ope='atz';
		$sql = "update niveldousuario set 
			descricao= '$descricao'
			where id=$id";
	}		
}else{
	$id=fproximoid("niveldousuario", $conefe);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into niveldousuario (
			id, descricao) 
			values ($id, '$descricao') ";		
} 
//die(' sql:'.$sql);
$conefe->beginTransaction();/* Inicia a transação */
try {
	$i1= $conefe->query($sql);
	$hys=incluihystory('cadastrarNiveldousuario-f1.php', $sql, $usu, $conefe);
	$conefe->commit();
	if($del=='del'){
		$_SESSION['msg']=' Nível do usuário Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=consultar&obj=niveldousuario&cpl=f1");
	}else{
		if($ope=='atz')
			$_SESSION['msg']=' Nível do usuário Atualizado com Sucesso!';
		else
			$_SESSION['msg']=' Nível do usuário Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=niveldousuario&cpl=f1&id=$id");
	}	
} catch(PDOException $e) {
	$conefe->rollback();
    $_SESSION['msg']='ERRO: (cadastrarNiveldousuario_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=niveldousuarioo&cpl=f1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarNiveldousuario_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=niveldousuario&cpl=f1");
}	
?>
