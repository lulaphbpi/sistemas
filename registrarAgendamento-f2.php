<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';
$sql1=''; $sql2='';
$sqls='';
$excluiragendamento=false;

$spid=0; $sid=0; $del='';
if(isset($_GET['id']) && empty($_GET['id']) == false) {
	$spid=$_GET['id']; //servicopessoa id
	//$pessoaid=$id;
}	
if(isset($_GET['idc']) && empty($_GET['idc']) == false) {
	$sid=$_GET['idc'];
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		$excluiragendamento=true;
	}
}
//$trace=ftrace('registrarAgendamento-f1.php','Inicio');
if($excluiragendamento){
	$sql1 = "delete from agenda where id=$sid and statusagenda_id<2";
	$sql2 = "update servicopessoa set statusservico_id=1 where id=$spid";
}else{
	
$tipodeagendaid=$_POST['tipodeagendaid'];
$datainicial=$_POST['datainicial'];
$d=formataData($datainicial);
$horainicial=$_POST['horainicial'];
$estagiarioid=$_POST['estagiario_id'];
$_SESSION['msg'] = '';

if($tipodeagendaid==0){
	$_SESSION['msg']=$msg.' Tipo de Agenda Não Informado!';
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
	exit;
} 	
if($datainicial==''){
	$_SESSION['msg']=$msg.' Data inicial Não Informada!';
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
	exit;
}
if($horainicial==0){
	$_SESSION['msg']=$msg.' Hora Inicial Não Informada!';
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
	exit;
}
if($estagiarioid==0){
	$_SESSION['msg']=$msg.' Estagiário Não Informado!';
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
	exit;
} 	

if($sid>0){
	$sql1 = "update agenda set tipodeagenda_id=$tipodeagendaid,
			data='$d', horainicial='$horainicial',
			estagiario_id=$estagiarioid 
			where id=$sid and statusagenda_id<2";
}else{

//$tipodeagendaid=$_SESSION['tipodeagendaid'];
$statusagendaid=1;
$agendaid=fproximoid('agenda', $conefi);
$sql1 = "insert into agenda values (
		$agendaid, $usuarioid, $estagiarioid, $spid, $tipodeagendaid, '$d', '$horainicial', $statusagendaid )";
$sql2 = "update servicopessoa set statusservico_id=2 where id=$spid";
}

}

//$trace=ftrace('registrarAgendamento-f1.php',$sql1.'  '.$sql2);

$conefi->beginTransaction();/* Inicia a transação */
try {
	$sql=$sql1;
	$i1= $conefi->query($sql);
	if(!empty($sql2))
		$i2=$conefi->query($sql2);
	$hys=incluihystory('registrarAgendamento-f2.php', $sql.' '.$sql2, $usu, $conefi);
	$conefi->commit();
	$_SESSION['msg']=$msg.' Agendamento registrado com Sucesso!';
	if($del=='del')
		$_SESSION['msg']=$msg.' Agendamento excluído com Sucesso!';
	else
		if($sid>0)
			$_SESSION['msg']=$msg.' Agendamento alterado com Sucesso!';
		
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']=$msg.' ERROR exception: (registrarAgendamento-f1.php) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=registrar&obj=agendamento&cpl=f2&id=$spid");
}	
?>