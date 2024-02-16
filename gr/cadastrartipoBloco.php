<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=0;
$descricao=$_POST['descricao'];

$inclui = fincluitipobloco($id,$descricao,$usu,$conexao);

if($inclui){
	$_SESSION['msg'] = 'Tipo de Bloco Registrado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível registrar Tipo de Bloco. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=lista&obj=tipoBloco&menu=principal');
break;

?>
