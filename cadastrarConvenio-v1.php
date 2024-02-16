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
	$sql = "update convenio set 
			descricao='$descricao'
			where id=$id";
}else{
	$id=fproximoid("convenio", $conacl);
	$sql = "insert into convenio (
			id, descricao) values (
			$id, '$descricao')";
			
}
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$_SESSION['msg']=' Convênio Registrada com Sucesso!';
	$hys=incluihystory('cadastrarConvenio-v1.php', $sql, $usu, $conacl);
	header ("Location: chameFormulario.php?op=cadastrar&obj=convenio&cpl=v1&id=$id");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarconvenio_v1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=convenio&cpl=v1");
}	
?>