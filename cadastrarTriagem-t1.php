<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['identificacao'];

$requisicaoid=$_GET['id'];
$rreq=lerequisicao($requisicaoid,$conacl);
if($rreq){
	$statusrequisicao=$rreq['statusrequisicao_id'];
	if($statusrequisicao>1){
		$_SESSION['msg']='Não é permitido atualizar ou incluir novo exame a essa requisição!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=triagem&cpl=t1&id=$requisicaoid");
		exit;
	}
}	
	
$id=0;
if(isset($_POST['datacoletada']) && empty($_POST['datacoletada']) == false){
	if(isset($_POST['horacoletada']) && empty($_POST['horacoletada']) == false){
		$datacoletada=$_POST['datacoletada'];
		$horacoletada=$_POST['horacoletada'];
		$dt=formataData($datacoletada);
		$emitecodigo=$_POST['emitecodigo'];
		$requisicaoid=$_GET['id'];
		$idc=$_GET['idc'];
		$codigo=fgeracodigo($idc,$conacl);
	}
}
$sql='';
if($requisicaoid>0 && $idc>0){
	$sql = "update examerequerido set 
			datacoletada='$dt',
			horacoletada='$horacoletada',
			codigo='$codigo'
			where requisicao_id=$requisicaoid and id=$idc";
}
if(!$sql==''){
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$hys=incluihystory('cadastrarTriagem-t1.php', $sql, $usu, $conacl);
	$_SESSION['msg']=' Triagem Registrada com Sucesso!';
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarExamerequerido_e1) ' . $e->getMessage(). ' '. $sql;
}
}
header ("Location: chameFormulario.php?op=cadastrar&obj=triagem&cpl=t1&id=$requisicaoid");
?>