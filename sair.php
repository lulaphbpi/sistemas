<?php
if(!isset($_SESSION)){session_start();}
include("../include/sa00.php");
include("../include/sa03.php");
$conpes=conexao('pessoal');
$login=$_SESSION['identificacao'];
$ilog=floginout($login,'out',$conpes);  

session_start();

date_default_timezone_set('America/Fortaleza');

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['texto']="";
$_SESSION['identificacao']='';
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;
$_SESSION['mural']="$"."mural";
$_SESSION['Max_Linhas']=2;
$_SESSION['grupo']='Ini';
$_SESSION['contador']=3;
$_SESSION['time']=date("Y-m-d H:i:s");
$_SESSION['inicial']=0;	
$_SESSION['rotina']='';
$_SESSION['texto']='';	

header("Location: chameFormulario.php?op=iniciar&obj=sistema");
?>