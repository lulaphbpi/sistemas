<?php
session_start();

date_default_timezone_set('America/Fortaleza');

include("include/iniciasessao.php");

include("include/finc.php");
//$trace=ftrace('index2.php','inicio');

$tab="sistema";
$cpo="sistema";
$val="'efisio'";
$confun=conexao('funcional');
$rs=fletabelaporvalordecampo($tab,$cpo,$val,$confun);
if($rs){ 
	if($rs->rowCount()>0){
		$rec=$rs->fetch();
		if($rec['ativo']<>'S'){
		}else{
			header("Location: chameFormulario.php?op=iniciar&obj=sistema");
		}
	}
}else{
	echo('Não leu funcional.sistema!');
}
?>