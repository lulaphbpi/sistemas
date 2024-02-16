<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$sistema=$_SESSION['sistema'];
$grupo = $_POST['grupo'];
$descricao = $_POST['descricao'];
$ope='';
if(!($descricao=='')){
if($id>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from grupo where id=$id";	
	}	
	else {
		$ope='atz';
		$sql = "update grupo set 
			grupo='$grupo',
			descricao= '$descricao'
			where id=$id";
	}		
}else{
	$id=fproximoid("grupo", $conefe);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into grupo (
			id, grupo, descricao) 
			values ($id, '$grupo', '$descricao') ";		
} 
//die(' sql:'.$sql);
$conefe->beginTransaction();/* Inicia a transação */
try {
	$i1= $conefe->query($sql);
	$hys=incluihystory('cadastrargrupo-f1.php', $sql, $usu, $conefe);
	$conefe->commit();
	if($del=='del'){
		$_SESSION['msg']=' Grupo Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=consultar&obj=grupo&cpl=f1");
	}else{
		if($ope=='atz')
			$_SESSION['msg']=' Grupo Atualizado com Sucesso!';
		else
			$_SESSION['msg']=' Grupo Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=grupo&cpl=f1&id=$id");
	}	
} catch(PDOException $e) {
	$conefe->rollback();
    $_SESSION['msg']='ERRO: (cadastrargrupo_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=grupo&cpl=f1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrargrupo_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=grupo&cpl=f1");
}	
?>
