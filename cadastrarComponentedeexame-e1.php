<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$usu=$_SESSION['identificacao'];
$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$descricao=addslashes(trim($_POST['descricao']));
$unidade=addslashes(trim($_POST['unidade']));
$metodo=addslashes(trim($_POST['metodo']));
$referencia=addslashes(trim($_POST['referencia']));
$notas=addslashes(trim($_POST['notas']));
$eh=$_POST['nvalor'];
$nvalor='1';
if($eh=='0')
	$nvalor='0';
elseif($eh==2)
	$nvalor='2';
$stc='';
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$stc='&idc='.$idc;
}	
if($idc>0){
	$sql = "update componentedeexame set 
			descricao='$descricao',
			unidade='$unidade',
			metodo='$metodo',
			referencia='$referencia',
			notas='$notas',
			nvalor='$nvalor'
			where id=$idc";
}else{
	$idc=fproximoid("componentedeexame", $conacl);
	$sql = "insert into componentedeexame (
			id, exame_id, descricao, unidade,
			referencia, metodo, notas, nvalor) values (
			$idc, $id, '$descricao', '$unidade', '$referencia', '$metodo', '$notas', 
			'$nvalor')";
			
} // die($sql);
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$_SESSION['msg']=' Componente de Exame Registrado com Sucesso!';
	$hys=incluihystory('cadastrarComponentedeexame-e1.php', $sql, $usu, $conacl);
	header ("Location: chameFormulario.php?op=cadastrar&obj=componentedeexame&cpl=e1&id=$id".$stc);
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarTipodeexame_e1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=componentedeexame&cpl=e1&id=$id");
}	
?>