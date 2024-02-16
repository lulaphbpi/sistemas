<?php
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$idq=$_GET['id'];
$id_tipoquestao = $_POST['id_tipoquestao'];
if($id_tipoquestao==0){
    $_SESSION['msg']='ERRO: (cadastrarQuestao_q1) - Não foi selecionado o tipo da questão!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1");
}
$enunciado = $_POST['enunciado'];
$ordem = $_POST['ordem'];
$nalternativas=0;
if(isset($_POST['nalternativas']) && empty($_POST['nalternativas']) == false)
	$nalternativas = $_POST['nalternativas'];
$ope='';
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];
//echo('idq='.$idq.'  idc='.$idc.'<br>');
if(!($enunciado=='')){
if($idc>0){
    //echo('idc>0<br>');
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from questao where id=$idc";	
	}	
	else {
		$ope='atz';
		$sql = "update questao set 
			id_tipoquestao =    $id_tipoquestao,
			enunciado =    '$enunciado',
			ordem =    $ordem,
			nalternativas = $nalternativas
			where id=$idc";
	}		
}else{
	$id=fproximoid("questao", $conque);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into questao (
			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) 
			values ($id, $idq, $id_tipoquestao, '$enunciado', $ordem, $nalternativas) ";		
   // echo($sql.'<br>');
} 
//die('beginTransaction');
$conque->beginTransaction();/* Inicia a transação */
try {
	$i1= $conque->query($sql);
	$hys=incluihystory('cadastrarQuestao-q1.php', $sql, $usu, $conque);
	$conque->commit();
	if($del=='del'){
		$_SESSION['msg']=' Questão Excluída com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1&id=$idq");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Questão Atualizada com Sucesso!';
			header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1&id=$idq&idc=$idc");
		}	
		else{
			$_SESSION['msg']=' Questão Registrada com Sucesso!';
			header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1&id=$idq");
		}
	}	
} catch(PDOException $e) {
	$conque->rollback();
    $_SESSION['msg']='ERRO: (cadastrarQuestao_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarQuestao_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=questao&cpl=q1");
}	
?>