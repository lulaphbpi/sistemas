
<?php
if(!isset($_SESSION)) {session_start();}

include('sa000.php');
include('conexao.php');

$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}

$id=$_SESSION['relatorioid'];
$reg=fleidtabela($id,'relatorio',$conexao);
$titulorelatorio=$reg['titulo'];
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
				<h4>RELATÓRIO: <?php echo($titulorelatorio); ?></h4>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<h4>BLOCO - Consulta</h4>
			</td>
		</tr>
		<tr>
			<td>
				<a href="chameFormulario.php?op=cadastra&obj=Bloco&menu=principal"><img class="botaonovo" id="botao-rnl1" src="img/botaonovo.png"  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt="Clique para Registrar Novo Bloco" /></a>
			</td>
			<td>
				<form name="formulariopesquisa" id="iformulariopesquisa" action="pesquisa.php?p=Bloco" method="post">
					<div id="idivformulariopesquisa">
						<strong>Localize:</strong><input type="text" name="textopesquisa" id="ipesquisa" /><input type="submit" id="ibotaopesquisa" value="Consultar"/>
					</div>
				</form>
			</td>
		</tr>	
    </table>    
</div>
