<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['identificacao'];

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$descricao=addslashes($_POST['descricao']);
if($id>0){
	$sql = "update especialidade set 
			descricao='$descricao'
			where id=$id";
}else{
	$id=fproximoid("especialidade", $conacl);
	$sql = "insert into especialidade (
			id, descricao) values (
			$id, '$descricao')";
			
}
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$_SESSION['msg']=' Especialidade Registrada com Sucesso!';
	$hys=incluihystory('cadastrarExpecialidade-e2.php', $sql, $usu, $conacl);
	header ("Location: chameFormulario.php?op=cadastrar&obj=especialidade&cpl=e2&id=$id");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarespecialidade_e2) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=especialidade&cpl=e2");
}	
?>