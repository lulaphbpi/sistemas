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

$sql = "delete from exame
			where id=$id";
$conacl->beginTransaction();/* Inicia a transação */
try {
		$i1= $conacl->query($sql);
		$conacl->commit();
		$hys=incluihystory('excluirExame-e1.php', $sql, $usu, $conacl);
		$_SESSION['msg']=' Exame Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=consultar&obj=exame&cpl=e1");
} catch(PDOException $e) {
		$conacl->rollback();
		$_SESSION['msg']='ERRO PDOException: (excluirExame-e1) ' . $e->getMessage(). ' '. $sql;
		header ("Location: chameFormulario.php?op=cadastrar&obj=exame&cpl=e1&id=$id");
}
?>