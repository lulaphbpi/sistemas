<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';

$obs = htmlspecialchars(trim($_POST['observacao']));

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$tid=$_GET['idc'];  // tratamentoid

$agendaid=$_SESSION['agendaid'];
$rect=letratamentoid($tid,$conefi);
$agendaid=$rect['agenda_id'];

$sql = "update tratamento set 
	        observacoesdoprofessor='$obs' 
			where id=$tid";
try {		
	$exec=$conefi->query($sql);
	$_SESSION['msg']='Observação registrada';
} catch(PDOException $e) {
	$_SESSION['msg']='ERRO PDOException: (registrarObservacaotratamento-f1) ' . $e->getMessage(). ' '. $sql;
	$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";
}

$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";

header($headerx);
?>