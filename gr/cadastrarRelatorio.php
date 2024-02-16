<?php

if(!isset($_SESSION)) {session_start();}
ini_set( 'display_errors', true );
error_reporting( E_ALL );

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=0;
$identificador=$_POST['identificador'];
$titulo=$_POST['titulorelatorio'];
$descricao=$_POST['descricao'];
$origem=$_POST['origem'];
$funcao=$_POST['funcao'];
$estilo_id=$_POST['estilo_id'];

$inclui = fincluirelatorio($id,$identificador,$titulo,$descricao,$origem,$funcao,$estilo_id,$usu,$conexao);

if($inclui){
	$_SESSION['msg'] = 'Relatorio Registrado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível registrar o Relatório. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=ultimos&obj=Relatorio&menu=principal');
break;

?>
