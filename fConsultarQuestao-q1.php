<?php
include("include/finc.php");
$conque=conexao('questionario');

$vez=0;
$rotina='fConsultarQuestao-q1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	//$vez=1;
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

$idq=0;
$idc=0;
$squest='';
$sinter='';
$tt=0;
$nquestoes=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$idq=$_GET['id'];
	$rq=lequestionarioid_q1($idq,$conque);
	if($rq){
		$squest=$rq['id'].': '.$rq['sigla'].' - '.$rq['descricao'];
		$sinter=$rq['interessado'];
	}	
	$nquestoes=fnlequestao($idq);
}	
$textopesquisa=$_SESSION['texto'];
$trace=ftrace('fConsultarQuestao-q1.php','textopesquisa:'.$textopesquisa);
if(isset($_POST['textopesquisa'])){
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
	$idc=$textopesquisa; 
	$idc=sonumero($idc);
	if(empty($idc))
		$idc='0';
	$reclst=flistaquestao_q1($idq,$idc,$conque);

	//echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
	$leu=true;
	$ord=$_SESSION['inicial'];
	$totallinhas=$reclst->rowCount();

//	$_SESSION['texto']=$textopesquisa;
}	

$permitealterar=false;
if(permitealterarquestionario($idq)){
	$permitealterar=true;
}
// Área de PK
$pvez=true;
	
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
<!--		<div id="lblerro"><?php echo($msg); ?></div><br>-->
		<p>Questionário <?php echo($squest);?></p>
		<p>Interessado: <?php echo($sinter);?></p>
<?php
if($permitealterar){
?>		
		<p>Pesquisar Número ... : </p>
		<form action='' method="post" id="iformulario" class="formulario">
			<div class="input0">
				<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($tt);?>" />
				<button type="submit" id="ibotao" class="lupa"></button>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=questao&cpl=q1&id=<?php echo($idq);?>" > Cadastrar Questão</a>
			</div>
			<br>
		</form>
<?php
}
?>		
		<br>
<?php
if($totallinhas>0){
?>
	<p>Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>Id</th>
		<th width='20%'>Tipo</th>
		<th width='50%'>Enunciado</th>
		<th width='5%'>ordem</th>
		<th width='5%'>N.Opções</th>
		<th width='5%'>Ver</th>
	</tr>
<?php
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$id = $rec['id']; $tt=$id;
	$tipodequestao = $rec['tipodequestao'];
	$enunciado = $rec['enunciado'];
	$ordem = $rec['ordem'];
	$nalternativas = $rec['nalternativas'];
	$nopcoes=lenopcoes_q1($id, $conque);
	$nalternativas=$nalternativas.' / '.$nopcoes['total'];
	$permiteopcoes=$rec['permiteopcoes'];
	
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
<?php
if($permitealterar){
?>		
		<td><a href='chameFormulario.php?op=cadastrar&obj=
questao&cpl=q1&id=<?PHP echo($idq);?>&idc=<?php echo($id);?>'><?PHP echo($id);?></a></td>
<?php
}else{
?>
		<td><?PHP echo($id);?></td>
<?php	
}
?>
		<td><?PHP echo($tipodequestao);?></td>
		<td><?PHP echo($enunciado);?></td>
		<td><?PHP echo($ordem);?></td>
		<td><?PHP echo($nalternativas);?></td>
<?php
if($permiteopcoes=='S'){
?>		
		<td><a href='chameFormulario.php?op=consultar&obj=
opcao&cpl=q1&id=<?PHP echo($id);?>'><?PHP echo('Opções');?></a></td>
<?php
}else{
?>		
		<td>&nbsp;</td>
<?php
}
?>		
<?php
if($permitealterar){
?>		
		<td><a href='chameFormulario.php?op=cadastrar&obj=
questao&cpl=q1&id=<?PHP echo($idq);?>&idc=<?php echo($id);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
<?php
}
?>		

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
			Listados <?php echo($ord);?>/<?php echo($nquestoes);?> dos registros pesquisados
		</td>
		<?php
		if($nquestoes>$ord) {
			$_SESSION['inicial']=$ord;
			$_SESSION['texto']=$id+1;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?php echo($idq); ?>&idc=<?php echo($id); ?>'>Próximos</a></td>
		<?php	
		}else{
			$_SESSION['inicial']=0;
		}
		?>

	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($idc);?>'</strong></p>
<?php

}
}
?>
<br>
<p><a href='chameFormulario.php?op=ordenar&obj=questoes&cpl=q1&idx=<?PHP echo($idq);?>'>Ordenar Questoes</a>	</p>		
<p><a href='chameFormulario.php?op=visualizar&obj=questionario&cpl=q1&idx=<?PHP echo($idq);?>'>Visualizar Questionário</a>	</p>		
<p><a href='chameFormulario.php?op=visualizar&obj=questionario&cpl=q2&idx=<?PHP echo($idq);?>'>Visão do Aplicador</a>	</p>		
<p><a href='fVisualizarQuestionario-q3.php?idx=<?PHP echo($idq);?>' target='_blank'>Impressão (modo design)</a>	</p>		
<p><a href='fVisualizarQuestionario-q4.php?idx=<?PHP echo($idq);?>' target='_blank'>Impressão (modo formulário)</a>	</p>		
<p><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&idx=<?PHP echo($idq);?>'>Retorna Questionário</a>	</p>		

</div>
</div>
</div>
