<?php
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	//die("aqui");
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisatxt($tx,'descricao','tipoquestao',$conque);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if(isset($_GET['id']) && empty($_GET['id']) == false){
		if($_SESSION['inicial']>0){
			$ord=$_GET['id'];
			$tx=$_SESSION['texto'];
			$reclst=fpesquisatxt($tx,'descricao','tipoquestao',$conque);
			$totallinhas=$reclst->rowCount();
			$leu=true;
		}else{ 
			$tx=$_SESSION['texto'];
			$reclst=fpesquisatxt($tx,'descricao','tipoquestao',$conque);
			$totallinhas=$reclst->rowCount();
			$leu=true;
			$_SESSION['inicial']=0;
		}	
	}
}	

// Área de PK
$pvez=true;
$tt=$_SESSION['texto'];
if(empty($tt))
	$tt=' ';
	
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Tipo de Questão - Digite o texto a pesquisar: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($tt);?>" />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=tipoquestao&cpl=q1" > Cadastrar Tipo de Questão<a>
			</div>
			<br>
		</form>
	<br>
<?php
if($totallinhas>0){
?>
	<p>Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>Id</th>
		<th width='40%'>Descrição</th>
		<th width='10%'>Permite Opções ?</th>
		<th width='5%'>Del</th>
	</tr>
<?php
if($_SESSION['inicial']>0){
	$contador=0;
	while($contador<$_SESSION['inicial']){
		$rec=$reclst->fetch();
		$contador++;
	}
}
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$id = $rec['id'];
	$descricao = $rec['descricao'];
	$nalternativas = $rec['nalternativas'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
tipoquestao&cpl=q1&id=<?PHP echo($id);?>'><?PHP echo($id);?></td>
		<td><?PHP echo($descricao);?></td>
		<td><?PHP echo($nalternativas);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
tipoquestao&cpl=q1&id=<?PHP echo($id);?>&del=<?php echo('del');?>'><?PHP echo('Del');?></td>
    </tr>
<?php
	}
}	

?>
	</table>

	<! -- Início declaração modal -->
	<! -- Fim da declaração modal -->
	
	<table class="tabela1">	
	<tr>
		<td>
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=tipoquestao&cpl=q1&id=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($tx);?>'</strong></p>
<?php

}
}
?>
</div>
</div>
</div>
