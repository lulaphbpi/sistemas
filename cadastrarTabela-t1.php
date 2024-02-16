<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['identificacao'];

$tabela=$_SESSION['texto'];
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$descricao=addslashes($_POST['descricao']);
if($id>0){
	$sql = "update ".$tabela." set 
			descricao='$descricao'
			where id=$id";
}else{
	$id=fproximoid($tabela, $conacl);
	$sql = "insert into ".$tabela." (
			id, descricao) values (
			$id, '$descricao')";
			
}
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$hys=incluihystory('cadastrarTabela-t1.php', $sql, $usu, $conacl);
	$_SESSION['msg']=$tabela.' Registrada com Sucesso!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=tabela&cpl=t1&id=$id");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrartabela_t1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=tabela&cpl=t1");
}	
?>