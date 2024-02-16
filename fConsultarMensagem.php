
<?php
if(!isset($_SESSION)) {session_start();}

$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}
?>

<div id="iconsulta">
	<table>
		<tr>
			<td colspan="2" align="center">
				&nbsp;
				<h4><?php echo($msg);?></h4>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<h4>MENSAGEM - Consulta</h4>
			</td>
		</tr>
		<tr>
			<td>
				<a href="chameFormulario.php?op=cadastramsg&obj=MSG"><img class="botaonovo" id="botao-rnl1" src="img/botaonovo.png"  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt="Clique para Registrar Nova Pessoa Física" /></a>
			</td>
			<td>
				<form name="formulariopesquisa" id="iformulariopesquisa" action="pesquisamsg.php" method="post">
					<div id="idivformulariopesquisa">
						<strong>Localize:</strong><input type="text" name="textopesquisa" id="ipesquisa" /><input type="submit" id="ibotaopesquisa" value="Consultar"/>
					</div>
				</form>
			</td>
		</tr>	
    </table>    
</div>