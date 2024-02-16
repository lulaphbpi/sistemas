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
	$pessoaid=$_GET['id'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];
$requisicaoid=$idc;
$rreq=lerequisicao($requisicaoid,$conacl);
if($rreq){
	$statusrequisicao=$rreq['statusrequisicao_id'];
	if($statusrequisicao>1){
		$_SESSION['msg']='Não é permitido atualizar ou incluir novo exame a essa requisição!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=requisicao&cpl=r1&id=$pessoaid&idc=$requisicaoid");
		exit;
	}
}
$novomedico=$_POST['novomedico'];
$msg='';
if($novomedico=='S'){
	$nomemedico=$_POST['nomemedico'];
	if(isset($_POST['crm']) && empty($_POST['crm']) == false) {
		$crm=$_POST['crm'];
		if(fvalidacrm($crm)){
				//echo('nomemedico:'.$nomemedico.'<br>');
			
			$novaespecialidade=$_POST['novaespecialidade'];
			if($novaespecialidade=='S'){
				$nomeespecialidade=$_POST['nomeespecialidade'];
				//$msg=$validaespecialidade($nomeespecialidade,$conacl);
			}else{
				$especialidade_id=$_POST['especialidade_id'];
				//echo('post 1 especialidade_id:'.$especialidade_id.'<br>');
				if($especialidade_id==0)
					$msg='Especialidade Não selecionada';
			}	
		}else{
			$msg='CRM inválido!';
		}
	}else{
		$msg='CRM não informado!';
	}
}else{
	$medico_id=$_POST['medico_id'];
	$rmed=lemedico($medico_id,$conacl); 
	$nomemedico=$rmed['nome'];
	$crm=$rmed['crm']; 
}
//echo('post2 especialidade_id:'.$especialidade_id.'<br>');
$sqle='';
$sqlm='';
$sqlr='';		
if($msg==''){
	if($novomedico=='S') {
		if($novaespecialidade=='S'){
			$especialidade_id=fproximoid('especialidade', $conacl);
			$sqle="insert into especialidade values (
					$especialidade_id, '$nomeespecialidade')";
		}
		$medico_id=fproximoid('medico', $conacl);
		$sqlm="insert into medico values (
				$medico_id, '$nomemedico', '$crm', $especialidade_id)";
		//echo('sqlm:'.$sqlm.'<br>');
				
	}
}
if($msg==''){
	$data=date('Y-m-d');
	$dt=formataDataToBr($data);	
	$hora=time();
	if($idc>0){
	$requisicao_id=$idc;	
	$guia=fgeraguia($dt,$requisicao_id,$conacl);
	$sqlr="update requisicao set 
			data='".formataData($data)."',
			medico_id=$medico_id,
			guia='$guia'
			where id=$idc";
	}else{
	$requisicao_id=fproximoid('requisicao',$conacl);
	$guia=fgeraguia($dt,$requisicao_id,$conacl);
	$sqlr="insert into requisicao values (
			$requisicao_id,'".
			formataData($data)."',
			$pessoaid,
			$medico_id,
			'$guia',1)";
	}		
}
//die('sqlr:'.$sqlr.'<br>');

if($msg==''){
$conacl->beginTransaction();/* Inicia a transação */
try {
	if(!$sqle=='')
		$i1= $conacl->query($sqle);
	if(!$sqlm=='')
		$i2= $conacl->query($sqlm);
	$i3=$conacl->query($sqlr);
	
	$conacl->commit();
	$sql=$sqle.' '.$sqlm;   
	$hys=incluihystory('cadastrarRequisicao-r1.php', $sql, $usu, $conacl);

	$_SESSION['msg']=' Requisição Registrada com Sucesso!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicao_id");
} catch(PDOException $e) {
	$conacl->rollback();
    $_SESSION['msg']='ERRO: (cadastrarRequisicao_r1) ' . $e->getMessage(). ' '. $sqle.' '.$sqlm.' '.$sqlr;
	header ("Location: chameFormulario.php?op=cadastrar&obj=requisicao&cpl=r1&id=$pessoaid");
}
}else{
	$_SESSION['msg']=$msg;
	header ("Location: chameFormulario.php?op=cadastrar&obj=requisicao&cpl=r1&id=$pessoaid");
}	
?>