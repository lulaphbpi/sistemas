<?php
if(!isset($_SESSION)) {session_start();}

$tx=$_POST['textopesquisa'];
$pr=$_GET['p'];

include("sa000.php");
include("conexao.php");

$lst=fpesquisa($tx,$pr,$conexao);
$nr=mysql_num_rows($lst);
if($nr==0){
	$_SESSION['msg']="Nenhum Registro foi encontrado com a designação:(".$tx.")";
	header("Location: chameFormulario.php?op=consulta&obj=$pr&menu=principal");
	exit();
}else{
if($nr==1){
	$rec=mysql_fetch_array($lst);
	$id=$rec['id'];
	header("Location: chameFormulario.php?op=edita&obj=$pr&menu=principal&id=$id");
	exit();
}else{
	$_SESSION['texto']=$tx;
	header("Location: chameFormulario.php?op=lista&obj=$pr&menu=principal");
	exit();
}}

$rec=mysql_fetch_array($lst);

?>