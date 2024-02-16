<?php
if(!isset($_SESSION)){session_start();}
$mensagem="Erro de Login";
if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	if($msg<>"") {
		$mensagem="Mensagem: ".$msg;
	}
}
?>
<div id="formularioerro">
<p>&nbsp;</p>
<p><?php echo($mensagem);?></p>
</div>
