<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
$conexao=conexao('pessoal');

$id=0;
$apelido=$_POST['apelido'];
$nome=$_POST['nome'];
$fone=$_POST['fone'];
$email=$_POST['email'];
$vemail="'".$email."'";
$leucpf=fletabelaporvalordecampo('pessoa','email',$vemail,$conexao);
if(!$leucpf) {
	$_SESSION['msg'] = "Já existe Pessoa Física cadastrada com o E-mail ".$email;
	header ("Location: chameFormulario.php?op=cadastrarpessoa&obj=pessoa"); 
}

$_SESSION['msg'] = '';
$_SESSION['cadastro1'] = array (
	"apelido" => $apelido,
	"nome" => $nome,
	"fone" => $fone,
	"email" => $email
);	
$c1=$_SESSION['cadastro1'];
//die('c1:'.$c1['apelido']);
header ("Location: chameFormulario.php?op=cadastrarpessoap3");

?>
