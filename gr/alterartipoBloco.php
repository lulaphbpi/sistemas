<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=$_SESSION['id'];
$descricao=$_POST['descricao'];

$altera = falteratipobloco($id,$descricao,$usu,$conexao);

if($altera){
	$_SESSION['msg'] = 'Tipo de Bloco Alterado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível alterar Tipo de Bloco. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=lista&obj=tipoBloco&menu=principal');
?>
