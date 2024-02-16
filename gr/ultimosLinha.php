
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

$idrelatorio=$_SESSION['relatorio_id'];
$reg=fleidtabela($idrelatorio,'relatorio',$conexao);
$blocoid=$_SESSION['blocoid'];
$tipobloco=fletipobloco($blocoid,$conexao);
$titulorelatorio=$reg['titulo']." - ".$tipobloco;

$tx="";
$lst=fpesquisaultimoslinha($tx,'linha',$blocoid,$conexao);
$_SESSION['texto']='';

?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
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
				<h4>Consulta Linhas</h4>
			</td>
		</tr>
		<tr>
			<td>
				<a href="chameFormulario.php?op=cadastra&obj=Linha&menu=principal"><img class="botaonovo" id="botao-rnl1" src="img/botaonovo.png"  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt="Clique para Registrar Nova Linha" /></a>
			</td>
			<td>
				<form name="formulariopesquisa" id="iformulariopesquisa" action="pesquisa.php?p=Linha" method="post">
					<div id="idivformulariopesquisa">
						<strong>Localize:</strong><input type="text" name="textopesquisa" id="ipesquisa" /><input type="submit" id="ibotaopesquisa" value="Consultar"/>
					</div>
				</form>
			</td>
		</tr>	
    </table>    
</div>
<table>
	<tr>
		<td colspan='2' align='left'>
			<h5><?php echo('Linhas :');?></h5>
		</td>
	</tr>
	<tr>
		<th width='10%'>Id</th>
		<th width='10%'>Bloco</th>
		<th width='10%'>NºLinha</th>
		<th width='10%'>Máscara</th>
	</tr>
<?php
while($rec=mysql_fetch_array($lst)){
	$id = $rec['id'];
	$tipobloco_id = $rec['tipobloco_id'];
    $reg1=fleidtabela($tipobloco_id,'tipobloco',$conexao);
	$tipobloco=$reg1['descricao'];
	$estilo_id = $rec['estilo_id'];

?>
   	<tr>
        <td><a href='chameFormulario.php?op=edita&obj=Linha&menu=principal&id=<?PHP echo($id);?>'><?PHP echo($id);?></a></td>
        <td><?PHP echo($bloco_id);?></td>
        <td><?PHP echo($linha);?></td>
        <td><?PHP echo($mascara);?></td>

    </tr>
<?php
}
?>
	<tr>
		<td>&nbsp;		
		</td>
		<td>&nbsp;
		</td>
	</tr>
	<tr>
		<td align='left'>
			<a href="chameFormulario.php?op=ultimos&obj=Relatorio&menu=principal">>> Relatórios</a>
			<a href="chameFormulario.php?op=ultimos&obj=Bloco&menu=principal">>> Blocos</a>
		</td>
		<td>&nbsp;		
		</td>
	</tr>
</table>
</section>
