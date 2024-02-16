<?php
include("include/finc.php");
$conque=conexao('questionario');

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarQuestionario-q1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']='';
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;

$textopesquisa=$_SESSION['texto'];
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$vez=0;
	if($textopesquisa<>$_POST['textopesquisa']){
//		echo('aqui 1'.$textopesquisa);
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
//		echo('aqui 2:'.$textopesquisa);
		$ord=$_SESSION['inicial'];
	}
}
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=fpesquisaquestionarioid_q1($textopesquisa,$conque);
	$totallinhas=$reclst->rowCount();
//	echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
	$leu=true;
	$ord=$_SESSION['inicial'];
	$_SESSION['texto']=$textopesquisa;
}	
if(!$leu){$_SESSION['rotina']='xxx'; 
	//echo('<br>nao leu<br>');
}
// Área de PK
$pvez=true;

?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Questionário - Digite o texto a pesquisar: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1" > Cadastrar Questionário</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=consultar&obj=tipoquestao&cpl=q1" > Consultar Tipo de Questão</a>
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
		<th width='5%'>Sigla</th>
		<th width='20%'>Título</th>
		<th width='30%'>Descrição</th>
		<th width='15%'>Interessado</th>
		<th width='5%'>N.Questões</th>
		<th width='5%'>Sistema</th>
		<th width='5%'>Exc</th>
		<th width='5%'>Questões</th>
		<th width='5%'>Fechado?</th>
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
	$titulo = $rec['titulo'];
	$sigla = $rec['sigla'];
	$descricao = $rec['descricao'];
	$interessado = $rec['interessado'];
	$nquestoes = $rec['nroquestoes'];
	$sistema = $rec['sistema'];
	$st = $rec['status'];
	$status=' Não';
	if($st=='F') $status=' Sim';

?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
questionario&cpl=q1&id=<?PHP echo($id);?>'><?PHP echo($id);?></td>
		<td><?PHP echo($sigla);?></td>
		<td><?PHP echo($titulo);?></td>
		<td><?PHP echo($descricao);?></td>
		<td><?PHP echo($interessado);?></td>
		<td><?PHP echo($nquestoes);?></td>
		<td><?PHP echo($sistema);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
questionario&cpl=q1&id=<?PHP echo($id);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
		<td><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?PHP echo($id);?>'>Questões</a></td>
		<td><?PHP echo($status);?></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&id=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($textopesquisa);?>'</strong></p>
<?php

}
}
?>
</div>
</div>
</div>
