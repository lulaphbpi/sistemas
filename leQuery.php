<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include("../include/sa000.php");
include("conexao.php");
$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}

$c=$_POST['comando'];
//die($c);
//$q=addslashes($c);
$h="Location: chameFormulario.php?op=executaQuery&obj=".$c;
//die ($h);
header ($h);
break;

?>

