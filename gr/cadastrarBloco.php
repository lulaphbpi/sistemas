<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$id=0;
$relatorio_id=$_SESSION['relatorioid'];
$tipobloco_id=$_POST['tipobloco_id'];
$estilo_id=$_POST['estilo_id'];
$conteudo=$_POST['conteudo'];

$inclui = fincluibloco($id,$relatorio_id,$tipobloco_id,$estilo_id,$conteudo,$usu,$conexao);

if($inclui){
	$_SESSION['msg'] = 'Bloco Registrado com sucesso. ';
}else{
    $_SESSION['msg'] = 'Não foi possível registrar o Bloco. Tente repetir a operação.';
}

header ('Location: chameFormulario.php?op=edita&obj=Relatorio&menu=principal&id='.$relatorio_id);
break;

?>
