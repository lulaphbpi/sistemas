<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=$_SESSION['id'];
$identificador=$_POST['identificador'];
$titulo=$_POST['titulorelatorio'];
$descricao=$_POST['descricao'];
$origem=$_POST['origem'];
$funcao=$_POST['funcao'];
$estilo_id=$_POST['estilo_id'];

$altera = falterarelatorio($id,$identificador,$titulo,$descricao,$origem,$funcao,$estilo_id,$usu,$conexao);

if($altera){
	$_SESSION['msg'] = 'Relatorio Alterado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível alterar Relatorio. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=ultimos&obj=Relatorio&menu=principal');
?>
