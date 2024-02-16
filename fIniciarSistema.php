<?php 
include("include/finc.php");

$confun=conexao('funcional');
$tm=imensagensnaolidas($_SESSION['identificacao'], $confun);
if($tm==1){
	$_SESSION['msg']='Você tem '.$tm.' Mensagem Não Lida!';
}elseif($tm>1){
	$_SESSION['msg']='Você tem '.$tm.' Mensagens Não Lidas!';
}	
//$_SESSION['msg']='Você tem '.$tm.' mensagens Não Lidas!';
$msg=$_SESSION['msg'];  

$_SESSION['msg']=''; 

?>

<div id="formularioinicial">

			<div id="lblerro"><?php echo($msg); ?></div>

</div>