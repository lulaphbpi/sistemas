<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';
$sql1=''; $sql2='';
$alterartratamento=false;
$excluirtratamento=false;
$spid=0; $agendaid=0; $tid=0; 

if(isset($_GET['id']) && empty($_GET['id']) == false) 
	$spid=$_GET['id'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false) 
	$agendaid=$_GET['idc'];

$idx=0;
if(isset($_GET['idx']) && empty($_GET['idx']) == false){
	$tid=$_GET['idx'];  // tratamentoid
	$idx=$tid;
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del')
			$excluirtratamento=true;
		if($del=='alt')
			$alterartratamento=true;	
	}
}

if($excluirtratamento){
	$sql1 = "delete from tratamento where id=$tid";
}else{
	$ragen=leagenda_fi($agendaid,$conefi);
	$data=$_POST['data']; $d=formataData($data);
	$hora=$_POST['horainicial'];
	$historico=htmlspecialchars(str_replace('\\', '\\\\', $_POST['historico']));
	$statusservicoid=$_POST['statusservico_id'];

	$_SESSION['msg'] = '';

	if($tid>0){
		if(!$excluirtratamento)
			$sql1 = "update tratamento set data='$d', hora='$hora', historico='$historico' where id=$tid";
		$spid=$_SESSION['spid'];
		if($spid>0)
			$sql2="update servicopessoa set statusservico_id=$statusservicoid where id=$spid";
	}else{
		$tid=fproximoid('tratamento', $conefi);
		$sql1 = "insert into tratamento values (
				$tid, $agendaid, '$d', '$hora', '$historico', '', null, null, 0, 0)";
		$sql2 = "update agenda set statusagenda_id=2 where id=$agendaid";
	}
}
	
$conefi->beginTransaction();/* Inicia a transação */
try {
	$sql=$sql1;
	$i1= $conefi->query($sql);
	if(!empty($sql2))
		$i2=$conefi->query($sql2);
	$hys=incluihystory('registrarTratamento-f1.php', $sql.' '.$sql2, $usuarioid, $conefi);
	$conefi->commit();
	$_SESSION['msg']=$msg.' Tratamento registrado com Sucesso!';
	if($del=='del')
		$_SESSION['msg']=$msg.' Tratamento excluído com Sucesso!';
	else
		if($idx>0)
			$_SESSION['msg']=$msg.' Tratamento alterado com Sucesso!';
		
	header ("Location: chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid&cpl=f1&idx=$agendaid");
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']=$msg.' ERROR exception: (registrarTratamento-f1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid&cpl=f1&idx=$agendaid");
}	
?>