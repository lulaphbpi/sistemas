<?php

// Usuário comum = nível de usuário 4

include('inicio.php');
include('../include/sa000.php');
$conefi=conexao('efisio');
$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';
$sql1=''; $sql2='';
$sqls='';
$excluiragenda=false;

$spid=0; $sid=0; $del='';
if(isset($_GET['id']) && empty($_GET['id']) == false) {
	$spid=$_GET['id'];
	//$pessoaid=$id;
}	
if(isset($_GET['idc']) && empty($_GET['idc']) == false) {
	$sid=$_GET['idc'];
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		$excluiragendamento=true;
	}
}
$trace=ftrace('agendarTratamento-f1.php','Inicio');
if($excluiragendamento){
	$sql1 = "delete from agenda where id=$sid and statusagenda_id<2";
}else{
	
$data=$_POST['data'];
$horainicial=$_POST['horainicial'];
$_SESSION['msg'] = '';

if($sid>0){
	$sql1 = "update agenda set data='$data', horainicial='$horainicial' 
			where id=$sid and statusagenda_id<2";
}else{

$d=formataData($data);
$tipodeagendaid=2;
$statusagendaid=1;
$agendaid=fproximoid('agenda', $conefi);
$sql1 = "insert into agenda values (
		$agendaid, $spid, $usuarioid, $tipodeagendaid, '$d', '$horainicial', $statusagendaid )";
$sql2 = "update servicopessoa set statusservico_id=3 where id=$spid";
}
}
$trace=ftrace('agendarTratamento-f1.php',$sql1.'  '.$sql2);

$conefi->beginTransaction();/* Inicia a transação */
try {
	$sql=$sql1;
	$i1= $conefi->query($sql);
	if(!empty($sql2))
		$i2=$conefi->query($sql2);
	$hys=incluihystory('agendarTratamento-f1.php', $sql.' '.$sql2, $usu, $conefi);
	$conefi->commit();
	$_SESSION['msg']=$msg.' Agendamento registrado com Sucesso!';
	if($del=='del')
		$_SESSION['msg']=$msg.' Agendamento excluído com Sucesso!';
	else
		if($sid>0)
			$_SESSION['msg']=$msg.' Agendamento alterado com Sucesso!';
		
	header ("Location: chameFormulario.php?op=agendar&obj=tratamento&cpl=f1&id=$spid");
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']=$msg.' ERROR exception: (agendarTratamento-f1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=agendar&obj=tratamento&cpl=f1&id=$spid");
}	
?>