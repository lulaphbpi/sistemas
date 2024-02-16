<?php
if(!isset($_SESSION)){session_start();}

$mensagem="TESte teSte testE teste TESTE TESTe" ;
if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	if($msg<>"") {
		$mensagem="Mensagem: ".$msg;
	}
}
?>

<section id="iformularioentrada">

<div id="formularioerro">
	<table>
		<tr>
			<td width="10%">&nbsp;
			</td>
			<td width="38%" valign="top" margin-top="0">
				<h5><strong>SAloc - Agendamento de Espaço Físico Virtual pela Internet</strong></h5>
				<p class="peqtexto"></p>
				<p class="peqtexto"></p>
			</td>
			<td width="5%">&nbsp;
			</td>
			<td width="40%" valign="top" margin-top="0">
					<p><br></p>
			</td>
			<td width="7%">&nbsp;
			</td>
		</tr>
	</table>
</div>
</section>	
