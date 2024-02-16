
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
				<h4>RELATÓRIO - Consulta</h4>
			</td>
		</tr>
		<tr>
			<td>
				<a href="chameFormulario.php?op=cadastra&obj=Relatorio&menu=principal"><img class="botaonovo" id="botao-rnl1" src="img/botaonovo.png"  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt="Clique para Registrar Novo Relatório" /></a>
			</td>
			<td>
				<form name="formulariopesquisa" id="iformulariopesquisa" action="pesquisa.php?p=Relatorio" method="post">
					<div id="idivformulariopesquisa">
						<strong>Localize:</strong><input type="text" name="textopesquisa" id="ipesquisa" /><input type="submit" id="ibotaopesquisa" value="Consultar"/>
					</div>
				</form>
			</td>
		</tr>	
    </table>    
</div>
