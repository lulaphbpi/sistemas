<?php
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$sistema=$_SESSION['sistema'];
$sigla = $_POST['sigla'];
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$interessado = $_POST['interessado'];
$nquestoes = $_POST['nquestoes'];
if(empty($nquestoes))
	$nquestoes=0;
$ope='';
if(!($descricao=='')){
if($id>0){
	if(permitealterarquestionario($id)){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from questionario where id=$id";	
	}	
	else {
		$ope='atz';
		$sql = "update questionario set 
			sigla =    '$sigla',
			titulo=   '$titulo',
			descricao= '$descricao',
			interessado = '$interessado',
			nroquestoes =    $nquestoes
			where id=$id";
	}
	}else{
		$_SESSION['msg']=' Questionário INDISPONÍVEL PARA ALTERAÇÃO ';
		header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$id");
	}		
}else{
	$id=fproximoid("questionario", $conque);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into questionario (
			id, titulo, sigla, descricao, interessado, nroquestoes, sistema, status) 
			values ($id, '$titulo', '$sigla', '$descricao', '$interessado', $nquestoes, '$sistema', '') ";		
} 
//die(' sql:'.$sql);
$conque->beginTransaction();/* Inicia a transação */
try {
	$i1= $conque->query($sql);
	$hys=incluihystory('cadastrarQuestionario-q1.php', $sql, $usu, $conque);
	$conque->commit();
	if($del=='del'){
		$_SESSION['msg']=' Questionario Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1");
	}else{
		if($ope=='atz')
			$_SESSION['msg']=' Questionario Atualizado com Sucesso!';
		else
			$_SESSION['msg']=' Questionario Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$id");
	}	
} catch(PDOException $e) {
	$conque->rollback();
    $_SESSION['msg']='ERRO: (cadastrarQuestionario_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarQuestionario_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1");
}	
?>
