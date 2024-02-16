<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=$_SESSION['id'];
$relatorioid=$_SESSION['relatorioid'];
$tipobloco_id=$_POST['tipobloco_id'];
$estilo_id=$_POST['estilo_id'];
$conteudo=$_POST['conteudo'];

$altera = falterabloco($id,$relatorioid,$tipobloco_id,$estilo_id,$conteudo,$usu,$conexao);

if($altera){
	$_SESSION['msg'] = 'Bloco Alterado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível alterar Bloco. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=ultimos&obj=Bloco&menu=principal');
?>
