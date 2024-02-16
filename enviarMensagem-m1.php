
<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$confun=conexao('funcional');
$conefi=conexao('efisio');

$usu=$_SESSION['identificacao'];
$identificacao_destino=$_POST['identificacao_destino'];
$identificacao_origem=$_SESSION["identificacao"];
$msg_assunto_id=$_POST['msg_assunto_id'];
$mensagem=trim($_POST['mensagem']);

if($mensagem==''){
	$_SESSION['msg']='Falha: Mensagem Vazia!';
	header ("Location: chameFormulario.php?op=consultar&obj=mensagem&cpl=m1"); 
}

$msg_status_id=1;
$data_envio='';
$data_leitura='';
$idbase=0;

$usuid=$_SESSION['usuarioid'];

$id=fproximoid('msg',$confun);	

$inclui = fincluimensagem($id,$identificacao_destino,$identificacao_origem,$msg_assunto_id,$mensagem,$msg_status_id,$data_envio,$data_leitura,$idbase, $usuid,$confun);

if($inclui=='Ok'){
	$_SESSION['msg'] = "Mensagem enviada com sucesso. ";
}else{
    $_SESSION['msg'] = $inclui;
}

header ("Location: chameFormulario.php?op=consultar&obj=mensagem&cpl=m1"); 
?>