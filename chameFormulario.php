<?php
if(!isset($_SESSION)){session_start();}

$login=$_SESSION['login'];
$adm=$_SESSION['adm'];

include('../include/sa01.php'); //functions

$op='';   //operacao
$obj='';  //objeto
$cpl='';  //complemento
$grp=$_SESSION['grupo'];
$tlogin='Login';
if($login)
	$tlogin='Logado';
if(isset($_GET['op']) && empty($_GET['op']) == false){
	$op=ucfirst($_GET['op']); 
	$_SESSION['operacao']=$op;
}	
if(isset($_GET['obj']) && empty($_GET['obj']) == false)
	$obj=ucfirst($_GET['obj']);
if(isset($_GET['cpl']) && empty($_GET['cpl']) == false)
	$cpl='-'.$_GET['cpl'];
$pid='';
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pid='&id='.$_GET['id'];  // parametro id
$pidc='';
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$pidc='&idc='.$_GET['idc'];  // parametro idc
$pidx='';
if(isset($_GET['idx']) && empty($_GET['idx']) == false)
	$pidx='&idx='.$_GET['idx'];  // parametro idx
$pdel='';
if(isset($_GET['del']) && empty($_GET['del']) == false)
	$pdel='&del='.$_GET['del'];  // parametro del

$grp=ucfirst($_SESSION["grupo"]); //grupo

$headerx="";
$plg=cod_palavra('f'.$tlogin.'.php');
$pmn=cod_palavra('mPrincipal.php');
$pmu=cod_palavra('m'.$grp.'.php');
$par=cod_palavra('f'.$op.$obj.$cpl.'.php').$pid.$pidc.$pidx.$pdel;

$headerx="Location: start.php?plog=$plg&pmen=$pmn&pmur=$pmu&parq=$par";

//$trace=ftrace('chameFormulario.php',$headerx);

header($headerx);
?>