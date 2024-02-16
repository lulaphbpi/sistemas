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
if(isset($_POST['sigla']) && empty($_POST['sigla']) == false){
	$sigla=strtoupper(addslashes($_POST['sigla']));
	$descricao=ucfirst(addslashes($_POST['descricao']));
	$tipodeamostra_id=$_POST['tipodeamostra_id']; 
	$observacao=addslashes($_POST['observacao']);
	$setor_id=$_POST['setor_id'];
}	
if(!($descricao=='' || $tipodeamostra_id==0)){
if($id>0){
	$sql = "update exame set 
			sigla='$sigla',
			descricao='$descricao',
			tipodeamostra_id=$tipodeamostra_id,
			observacao='$observacao',
			setor_id=$setor_id
			where id=$id";
}else{
	$id=fproximoid("exame", $conacl); 
	$sql = "insert into exame (
			id, sigla, descricao, tipodeamostra_id, observacao, setor_id, nvalor) values (
			$id, '$sigla', '$descricao', $tipodeamostra_id, '$observacao', 
			$setor_id)";		
} 
//die(' sql:'.$sql);
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$_SESSION['msg']=' Exame Registrado com Sucesso!';
	$hys=incluihystory('cadastrarExame-e1.php', $sql, $usu, $conacl);

	header ("Location: chameFormulario.php?op=cadastrar&obj=componentedeexame&cpl=e1&id=$id");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarExame_e1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=exame&cpl=e1");
}}else{	
   $_SESSION['msg']='ERRO: (cadastrarExame_e1). Sem dados para processar:'.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=exame&cpl=e1");
}	
?>