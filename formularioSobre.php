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
			<td width="35%" valign="top" margin-top="0">
					<h5><strong>QUEM SOMOS </strong></h5>
					<p>Missão REDEDEPROGRAMAS: Desenvolver soluções gerais para automação integrada via WEB.  </p>

			</td>
			<td width="5%">&nbsp;
			</td>
			<td width="25%" valign="top" margin-top="0">
					<h5><strong>RESPONSÁVEL ATUAL</strong></h5><br>
					<h6><strong></strong></h6>
					<p>Luiz Carlos Moraes de Brito - Análista de Sistemas</p>
                    <p></p>

			</td>
			<td width="5%">&nbsp;
			</td>
			<td width="30%" valign="top">
					<h5><strong>Rede de Programas – RP</strong></h5><br>
					<h7><strong>Desenvolvimento de Softwares para WEB</strong></h7>
					<p> </p>
					 <br>	
					Parnaíba - PI, 64.000-000<br>
					<abbr title="Fone">P:</abbr> (86)981888-9999
					<p></p>
	                <div class="thumbnail">
						<img src="img/allhere.png" alt="">
					</div>
            </td>
		</tr>
	</table>
</div>
</section>	
