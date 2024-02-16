<?php
if(!isset($_SESSION)){session_start();}

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;

include("sa000.php");
include("conexao.php");

$login = $_POST['identificacao'];
$s1 = $_POST['senha'];
$senha = md5($s1);

$headerx="";
$smsg="Login e/ou senha incorretos!";
$verifica = $conexao->query("SELECT * FROM usuario WHERE identificacao = '$login' AND senha = '$senha'"); 
//$verifica = mysql_query("SELECT * FROM usuario WHERE identificacao = '$login'",$conexao); 
if(!$verifica){
	//die("Erro de Acesso - Contactar administrador de Banco de Dados!");
	$_SESSION['msg']="Erro de Acesso - Identificação e/ou Senha Inválida!";
	$headerx="Location: chameFormulario.php?op=errologin";
}else{
if ($verifica->rowCount()<=0){
	//die("Erro 2 de Acesso - Contactar administrador de Banco de Dados!");
	$_SESSION['msg']="Usuário Não Cadastrado ou Desativado - Contactar administrador de usuários!";
	$headerx="Location: chameFormulario.php?op=errologin";
}else{
	//die("entrou");
	$linha=$verifica->fetch();
	$_SESSION["usuarioid"]=$linha["id"];
	$_SESSION["identificacao"]=$login;
	//$_SESSION["nomeusuario"]=$linha["nome"];
	
	$_SESSION['vez']=0;
	$_SESSION['login']=true;
		
   //setcookie("login",$login);
   
	$_SESSION['adm']=0;
	$_SESSION['adm']=1;
 	$headerx="Location:chameFormulario.php?op=menuadm";
}}
header($headerx);
?>

