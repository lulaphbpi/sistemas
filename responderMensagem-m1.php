<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$confun=conexao('funcional');

$identificacao_destino=$_POST['identificacao_origem'];
$identificacao_origem=$_SESSION["identificacao"];
$msg_assunto_id=$_POST['msg_assunto_id'];
$mensagem=' Mensagem Original:\n';
$mensagem.=trim($_POST['mensagem']).'\n';
$mensagem.=' Resposta:\n'.trim($_POST['resposta']);

if($mensagem==''){
	$_SESSION['msg']='Falha: Resposta Vazia!';
	header ("Location: chameFormulario.php?op=consultar&obj=mensagem&cpl=m1"); 
}

$msg_status_id=1;
$data_envio='';
$data_leitura='';
$idbase=0;

$usu=$_SESSION['usuarioid'];

$inclui = fincluimensagem($id,$identificacao_destino,$identificacao_origem,$msg_assunto_id,$mensagem,$msg_status_id,$data_envio,$data_leitura,$idbase, $usu,$confun);

if($inclui=='Ok'){
	$_SESSION['msg'] = "Mensagem enviada com sucesso. ";
}else{
    $_SESSION['msg'] = $inclui;
}

header ("Location: chameFormulario.php?op=consultar&obj=mensagem&cpl=m1"); 
?>