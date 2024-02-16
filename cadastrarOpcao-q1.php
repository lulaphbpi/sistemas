<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$idc=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$idq=$_GET['id'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$ordem = $_POST['ordem'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];
//echo('idq='.$idq.'  idc='.$idc.'<br>');
if(!($descricao=='')){
if($idc>0){
    //echo('idc>0<br>');
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from opcao where id=$idc";	
	}	
	else {
		$ope='atz';
		$sql = "update opcao set 
			descricao =    '$descricao',
			valor =    $valor,
			ordem =    $ordem
			where id=$idc";
	}		
}else{
	$id=fproximoid("opcao", $conque);  //	die('id='.$id);
	$ope='inc';
	$sql = "insert into opcao (
			id, ordem, id_questao, descricao, valor) 
			values ($id, $ordem, $idq, '$descricao', $valor) ";		
//    echo($sql.'<br>');
} 
//die('beginTransaction');
$conque->beginTransaction();/* Inicia a transação */
try {
	$i1= $conque->query($sql);
	$hys=incluihystory('cadastrarOpcao-q1.php', $sql, $usu, $conque);
	$conque->commit();
	if($del=='del'){
		$_SESSION['msg']=' Opção Excluída com Sucesso!';
		header ("Location: chameFormulario.php?op=consultar&obj=opcao&cpl=q1&id=$idq");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Opçtão Atualizada com Sucesso!';
			header ("Location: chameFormulario.php?op=consultar&obj=opcao&cpl=q1&id=$idq&idc=$idc");
		}	
		else{
			$_SESSION['msg']=' Opção Registrada com Sucesso!';
			header ("Location: chameFormulario.php?op=cadastrar&obj=opcao&cpl=q1&id=$idq");
		}
	}	
} catch(PDOException $e) {
	$conque->rollback();
    $_SESSION['msg']='ERRO: (cadastrarOpcao_q1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=opcao&cpl=q1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarOpcao_q1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=opcao&cpl=q1");
}	
?>