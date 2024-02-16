<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
if(!isset($_SESSION)){session_start();}

date_default_timezone_set('America/Fortaleza');

$tempolimite =  36; //720;

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
//$_SESSION['msg']="";
$_SESSION['texto']="";
$_SESSION['identificacao']='';
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;
$_SESSION['mural']="$"."mural";
$_SESSION['Max_Linhas']=2;
$_SESSION['grupo']='Ini';
$_SESSION['contador']=15;
$_SESSION['time']=date("Y-m-d H:i:s");
$_SESSION['inicial']=0;	
$_SESSION['rotina']='';
$_SESSION['texto']='';	
$_SESSION['registro'] = time(); // armazena o momento em que autenticado //
$_SESSION['limite'] = $tempolimite;
//$_SESSION['MaxLinhas'] = 12;

//if(!$_SESSION['login']) die('');

?>