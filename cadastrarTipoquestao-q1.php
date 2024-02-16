<?php
return true;
include('inicio.php');
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; $descricao=''; $ok=true; $op='';
if(isset($_GET['id']) && empty($_GET['id']) == false){
}	$id=$_GET['id'];
if(isset($_GET['del']) && empty($_GET['del']) == false){
	$del=$_GET['del'];
	if($del=='del'){
		$op='del';
		$sql = "delete from tipoquestao where id=$id";
		$ok=false;
	}		
}	
if($ok){
	$descricao=ucfirst(addslashes($_POST['descricao']));
	$nalternativas=$_POST[nalternativas];
	if(!($descricao=='')){
		if($id>0){
			$op='atz';
			$sql = "update tipoquestao set 
				descricao='$descricao',
				nalternativas='$nalternativas'
				where id=$id";
		}else{
			$op='inc';
			$id=fproximoid("tipoquestao", $conque); 
			$sql = "insert into tipoquestao (
					id, descricao, nalternativas) values (
					$id, '$descricao', '$nalternativas')";		
		}			
	}else{
		$_SESSION['msg']='ERRO: (cadastrarTipoquestao-q1.php). Sem dados para processar:'.$sql;
		header ("Location: chameFormulario.php?op=cadastrar&obj=tipoquestao&cpl=q1");
		exit();
	}	
}	
//die(' sql:'.$sql);
$conque->beginTransaction();/* Inicia a transação */
try {
	$i1= $conque->query($sql);
	$conque->commit();
	if($ok){
		if($op=='atz')
			$_SESSION['msg']=' Tipo de Questão Atualizado com Sucesso!';
		else	
			$_SESSION['msg']=' Tipo de Questão Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=tipoquestao&cpl=q1&id=$id");
	}else{
		$_SESSION['msg']=' Tipo de Questão Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=tipoquestao&cpl=q1");
	}	
	$hys=incluihystory('cadastrarTipoquestao-q1.php', $sql, $usu, $conque);
} catch(PDOException $e) {
	$conque->rollback();
    $_SESSION['msg']='ERRO: (cadastrartipoquestao_q1.php) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=tipoquestao&cpl=q1");
}
?>