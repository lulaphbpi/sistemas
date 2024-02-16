<?php

include('inicio.php');
include('sa000.php');
$conexao=conexao('pessoal');

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

$id=0;
$datanascimento=$_POST['datanascimento'];
$sexo=$_POST['sexo'];
$rg=$_POST['rg'];
$expedidorrg_id=$_POST['expedidorrg_id'];
$formacaoprofissional_id=$_POST['formacaoprofissional_id'];
//echo("==> "); die($datanascimento."-".$sexo." - ".$expedidorrg_id."/".$formacaoprofissional_id);
$_SESSION['msg'] = '';
$_SESSION['cadastro2'] = array (
	"datanascimento" => $datanascimento,
	"sexo" => $sexo,
	"rg" => $rg,
	"expedidorrg" => $expedidorrg_id,
	"formacaoprofissional" => $formacaoprofissional_id
);
header ("Location: chameFormulario.php?op=cadastrarpessoap4");

?>
