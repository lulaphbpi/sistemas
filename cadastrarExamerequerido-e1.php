<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$requisicaoid=$_GET['id'];
	$rreq=lerequisicao($requisicaoid,$conacl);
	if($rreq){
		$statusrequisicao=$rreq['statusrequisicao_id']
;
		if($statusrequisicao>1){
			$_SESSION['msg']='Não é permitido atualizar ou incluir novo exame a essa requisição!';
			header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
			exit;
		}
	}	
	if(isset($_POST['confirmacao']) && empty($_POST['confirmacao']) == false){
		$confirmacao=$_POST['confirmacao'];
		//die('confirmacao:'.$confirmacao.'<br>');
		if($confirmacao>0){
			$exec=fatualizastatusreq($requisicaoid,2,$usuarioid,$conacl);
			if($exec){
				$_SESSION['msg']='Status Atualizado!';
				header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
				exit;
			}else{
				$_SESSION['msg']='Falha: Status Não  Atualizado!';
				header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
				exit;
			}	
		}
	}
}

$exame_id=$_POST['exame_id'];
$convenio_id=$_POST['convenio_id'];
$datacoleta=$_POST['datacoleta']; $dt=formataData($datacoleta);
$horacoleta=$_POST['horacoleta'];

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

if($idc>0){
	$sql = "update examerequerido set 
			exame_id=$exame_id,
			convenio_id=$convenio_id,
			datacoleta='$dt',
			horacoleta='$horacoleta'
			where id=$idc";
}else{
	$id=fproximoid("examerequerido", $conacl);
	$sql = "insert into examerequerido (
			id, requisicao_id, exame_id, convenio_id, datacoleta, horacoleta, 
			datacoletada, horacoletada, dataresultado, horaresultado, 
			dataentrega, horaentrega, documentoentrega, entregouguia,codigo,statusexamerequerido_id) values (
			$id, $requisicaoid, $exame_id, $convenio_id, '$dt', '$horacoleta',
			'','','','','','','','','',1)";
}
$conacl->beginTransaction();/* Inicia a transação */
try {
	$i1= $conacl->query($sql);
	$conacl->commit();
	$_SESSION['msg']=' Exame Registrado com Sucesso!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarExamerequerido_e1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
}	
?>