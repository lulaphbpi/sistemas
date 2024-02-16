<?php
if(!isset($_SESSION)){session_start();}

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;
$_SESSION['txtpesquisa']='';

include("../include/sa000.php");
$conexao=conexao('pessoal');

$login = $_SESSION['identificacao'];
$s1 = $_SESSION['ssenha'];
$senha = md5($s1);

$headerx="";
$smsg="Login e/ou senha incorretos!";
$vcpo="'".$login."'";
$leuusuario=fletabelaporvalordecampo('usuario','identificacao',$vcpo,$conexao);
$c=true;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
		//die(" Senha dada:".$senha."  Senha gravada:".$s);
		$n=$rec['nivelusuario_id'];
		$_SESSION['identificacao']=$login;
		$_SESSION['usuarioid']=$rec['id'];
		$_SESSION['pessoaid']=$rec['pessoa_id'];
	    if (!$a=='S') {
			$_SESSION['msg']="Você está desativado, envie email para cmrv.nti@ufpi.edu.br para as devidas providências.";
			$headerx="Location: chameFormulario.php?op=errologin";
			$c=false;
		}else{
		//die(" Senha dada:".$senha."  Senha gravada:".$s);
			if (!($senha==$s)) {
				$_SESSION['msg']="Senha informada errada.";
				$headerx="Location: chameFormulario.php?op=errologin";
				$c=false;
			}
		}	
	}else{
		$_SESSION['msg']="Usuário Não Cadastrado!";
		$headerx="Location: chameFormulario.php?op=errologin";
		$c=false;
	}
}else{
	$_SESSION['msg']="Usuário Não Cadastrado!";
	$headerx="Location: chameFormulario.php?op=errologin";
	$c=false;
}
if($c) {	
	$_SESSION['vez']=0;
	$_SESSION['login']=true;
		
	//setcookie("login",$login);
   
	$_SESSION['adm']=0;
	if($n<4){ // usuario adm
		$_SESSION['adm']=$n;
		$headerx="Location:chameFormulario.php?op=menuadm";
	}else{
		$_SESSION['adm']=$n;
		$headerx="Location:chameFormulario.php?op=menupaciente";
	}	
}
header($headerx);
?>

