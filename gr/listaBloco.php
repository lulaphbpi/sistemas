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

$tx=$_SESSION['texto'];
$lst=fpesquisa($tx,'bloco',$conexao);
$_SESSION['texto']='';

$titulo='Lista de Blocos do Relatório';

$id1=$_SESSION['relatorioid'];
$reg=fleidtabela($id1,'relatorio',$conexao);
$titulorelatorio=$reg['titulo'];

// Área de PK
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>

<div id='iconsulta'>
<table>
 	<tr>
			<td colspan="2" align="center">
				<h4>RELATÓRIO: <?php echo($titulorelatorio); ?></h4>
			</td>
	</tr>
	<tr>
		<td colspan='2' align='center'>
			<h4><?php echo($titulo);?></h4>
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
	<tr>
		<td colspan='2'>&nbsp;</td>
	</tr>
</table>
</div>
<table>
	<tr>
		<th width='10%'>Id</th>
		<th width='40%'>Tipo </th>
		<th width='10%'>Estilo</th>

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
        <td><a href='chameFormulario.php?op=edita&obj=Bloco&menu=principal&id=<?PHP echo($id);?>'><?PHP echo($id);?></a></td>
        <td><?PHP echo($tipobloco);?></td>
        <td><?PHP echo($estilo_id);?></td>

    </tr>
<?php
}
?>
</table>
</section>
