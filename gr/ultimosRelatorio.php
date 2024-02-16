<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$mensagem='';
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>''){
		$mensagem='Mensagem:'.$msg;
		$_SESSION['msg']='';
	}
}

$tx="";
$lst=fpesquisaultimos($tx,'relatorio',$conexao);
$_SESSION['texto']='';

$titulo='Consulta Relatórios';

// Área de PK
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>

<div id='iconsulta'>
<table>
	<tr>
		<td colspan='2' align='center'>
			<h4><?php echo($titulo);?></h4>
		</td>
	</tr>
	<tr>
			<td>
				<a href="chameFormulario.php?op=cadastra&obj=Relatorio&menu=principal"><img class="botaonovo" id="botao-rnl1" src="img/botaonovo.png"  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt="Clique para Registrar Novo Relat�rio" /></a>
			</td>
			<td>
				<form name="formulariopesquisa" id="iformulariopesquisa" action="pesquisa.php?p=Relatorio" method="post">
					<div id="idivformulariopesquisa">
						<strong>Localize:</strong><input type="text" name="textopesquisa" id="ipesquisa" /><input type="submit" id="ibotaopesquisa" value="Consultar"/>
					</div>
				</form>
			</td>
	</tr>	
	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>
</table>
</div>
<table>
	<tr>
		<td colspan='2' align='left'>
			<h5><?php echo('Últimos Relatórios :');?></h5>
		</td>
	</tr>
	<tr>
		<th width='5%'>Id</th>
		<th width='15%'>Identificador</th>
		<th width='35%'>Título</th>
		<th width='20%'>Descrição</th>
		<th width='10%'>Origem</th>
		<th width='10%'>Função</th>
		<th width='5%'>Estilo</th>

	</tr>
<?php
foreach($lst->fetchAll() as $rec){
//while($rec=mysql_fetch_array($lst)){
	$id = $rec['id'];
	$identificador = $rec['identificador'];
	$titulo = $rec['titulo'];
	$descricao = $rec['descricao'];
	$origem = $rec['origem'];
	$funcao = $rec['funcao'];
	$estilo_id = $rec['estilo_id'];

?>
   	<tr>
        <td><a href='chameFormulario.php?op=edita&obj=Relatorio&menu=principal&id=<?PHP echo($id);?>'><?PHP echo($id);?></a></td>
        <td><?PHP echo($identificador);?></td>
        <td><?PHP echo($titulo);?></td>
        <td><?PHP echo($descricao);?></td>
        <td><?PHP echo($origem);?></td>
        <td><?PHP echo($funcao);?></td>
        <td><?PHP echo($estilo_id);?></td>

    </tr>
<?php
}
?>
<tr>
	<td colspan="7">__ 
	</td>
</tr>
</table>
</section>
