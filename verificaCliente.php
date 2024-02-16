<?php
//verificaCliente.php
if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$consnae=conexao('consnae');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
}	
if($id==0){
	$_SESSION['msg']='Sem id do cliente!';
	header("Location: chameFormulario.php?op=consultar&obj=pessoa&cpl=c1");
	exit();
}

$sql1="SELECT * FROM consulta WHERE consultapessoa_id=$id AND dataconsulta > DATE_FORMAT(NOW(),'%Y-%m-%d')";
$leconsulta=$consnae->query($sql1);
if($leconsulta->rowCount()>0){	
	$rleconsulta=$leconsulta->fetch();
	$idc=$rleconsulta['id'];
	header("Location: chameFormulario.php?op=mostrar&obj=consulta&cpl=c1&idc=$idc");	
	exit();
}	

$sql1="SELECT * FROM consulta WHERE consultapessoa_id=$id AND dataconsulta = DATE_FORMAT(NOW(),'%Y-%m-%d')";
$leconsulta=$consnae->query($sql1);
if($leconsulta->rowCount()>0){	
	$rleconsulta=$leconsulta->fetch();
	$realizado=$rleconsulta['realizado'];
	$idc=$rleconsulta['id'];
	if($realizado=='S'){
		header("Location: chameFormulario.php?op=marcar&obj=retorno&cpl=c1&idc=$idc");	
		exit();
	}else{
		header("Location: chameFormulario.php?op=confirmar&obj=consulta&cpl=c1&idc=$idc");	
		exit();
	}	
}	

$sql1="SELECT * FROM consulta WHERE consultapessoa_id=$id AND dataconsulta < DATE_FORMAT(NOW(),'%Y-%m-%d')";
$leconsulta=$consnae->query($sql1);
if($leconsulta->rowCount()>0){	
	$rleconsulta=$leconsulta->fetch();
	$realizado=$rleconsulta['realizado'];
	$idc=$rleconsulta['id'];
	if($realizado=='S'){
		$_SESSION['msg']='Consulta Realizada. Marcar Retorno!';
		header("Location: chameFormulario.php?op=marcar&obj=retorno&cpl=c1&idc=$idc");	
		exit();
	}else{
		$_SESSION['msg']='Perdeu consulta!';
		header("Location: chameFormulario.php?op=marcar&obj=consulta&cpl=c1&id=$id");	
		exit();
	}	
}	
$_SESSION['msg']='Nova consulta!';
$_SESSION['msg']='';
header("Location: chameFormulario.php?op=marcar&obj=consulta&cpl=c1&id=$id");	
exit();

