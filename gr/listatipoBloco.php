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
$lst=fpesquisa($tx,'tipobloco',$conexao);
$_SESSION['texto']='';

$titulo='Lista Tipos de Bloco';

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
			<a href='chameFormulario.php?op=cadastra&obj=tipoBloco&menu=principal'><img class='botaonovo' id='botao-rnl1' src='img/botaonovo.png'  onmouseover="this.src='img/botaonovoa.png'" onmouseout="this.src='img/botaonovo.png'" alt='Clique para Registrar Novo item de Tipo de Bloco' /></a>
		</td>
		<td>
			<form name='formulariopesquisa' id='iformulariopesquisa' action='pesquisa.php?p=tipoBloco' method='post'>
				<div id='idivformulariopesquisa'>
					<strong>Localize:</strong><input type='text' name='textopesquisa' id='ipesquisa' /><input type='submit' id='ibotaopesquisa' value='Consultar'/>
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
		<th width='5%'>Id</th>
		<th width='50%'>Descrição</th>

	</tr>
<?php
while($rec=mysql_fetch_array($lst)){
	$id = $rec['id'];
	$descricao = $rec['descricao'];

?>
   	<tr>
        <td><a href='chameFormulario.php?op=edita&obj=tipoBloco&menu=principal&id=<?PHP echo($id);?>'><?PHP echo($id);?></a></td>
        <td><?PHP echo($descricao);?></td>

    </tr>
<?php
}
?>
</table>
</section>
