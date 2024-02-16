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
$idq=0;
$idc=0;
$squest='';
$sinter='';
$id_questionario=0;
$permitealterar=false;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$idq=$_GET['id']; // id da questao
	$rq=lequestaoid_q1($idq,$conque);
	if($rq){
		$id_questionario=$rq['id_questionario'];
		if(permitealterarquestionario($id_questionario)){
			$permitealterar=true;
		}

		$squest=$rq['id_questionario'].': '.$rq['sigla'].' - '.$rq['questionariodescricao'];
		$sinter=$rq['interessado'];
		$squestao=fnumero($rq['ordem'],3).'. '.$rq['enunciado'];
	}	
	if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
		$idc=$_POST['textopesquisa']; 
		$idc=sonumero($idc);
		if(empty($idc))
			$idc='0';
		$tt=$idc+$maxlinhas;
		$reclst=flistaopcao_q1($idq,$idc,$conque);
		if(!$reclst)
			die($_SESSION['msg']);
		$totallinhas=$reclst->rowCount();
		if($totallinhas<=($maxlinhas+$idc))
			$tt=$idc;
		$leu=true;
		$_SESSION['inicial']=0;
	}else{
		if(isset($_GET['idc']) && empty($_GET['idc']) == false){
			$idc=$_GET['idc'];
			$tt=$idc+$maxlinhas;
			$reclst=flistaopcao_q1($idq,$idc,$conque);
			$totallinhas=$reclst->rowCount();
			if($totallinhas<=($maxlinhas+$idc))
				$tt=$idc;
			$leu=true;
			$_SESSION['inicial']=0;
		}else{
			$tt=$idc+$maxlinhas;
			$reclst=flistaopcao_q1($idq,$idc,$conque);
			$totallinhas=$reclst->rowCount();
			if($totallinhas<=($maxlinhas+$idc))
				$tt=$idc;
			$leu=true;
			$_SESSION['inicial']=0;
		}	
	}	
}	

// Área de PK
$pvez=true;
	
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
		<div id="lblerro"><?php echo($msg); ?></div><br>
		<p>Consultar Opções de Questão ... : </p>
		<p>Questionário <?php echo($squest);?></p>
		<p>Interessado: <?php echo($sinter);?></p>
		<p>Questão: <?php echo($squestao);?></p>
		<?php
			if($permitealterar){
		?>		
        <form action="" method="post" id="iformulario" class="formulario">
			<p>Pesquisar Opção Número ... : </p>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($tt);?>" />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=opcao&cpl=q1&id=<?php echo($idq);?>" > Cadastrar Opção<a>
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
		<th width='30%'>Descrição</th>
		<th width='5%'>Valor</th>
		<th width='5%'>Ordem</th>
		<th width='5%'>Excluir</th>
	</tr>
<?php
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$id = $rec['id'];
	$descricao = $rec['descricao'];
	$valor = $rec['valor'];
	$ordem = $rec['ordem'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
opcao&cpl=q1&id=<?PHP echo($idq);?>&idc=<?php echo($id);?>'><?PHP echo($id);?></td>
		<td><?PHP echo($descricao);?></td>
		<td><?PHP echo($valor);?></td>
		<td><?PHP echo($ordem);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
opcao&cpl=q1&id=<?PHP echo($idq);?>&idc=<?php echo($id);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
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
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($idc);?>'</strong></p>
<?php
}}
?>	
<br>
<div>
	<p><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?PHP echo($id_questionario);?>&idc=0'>Lista Questões</a>	</p>		
	<p><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&idx=<?PHP echo($id_questionario);?>'>Retorna Questionário</a>	</p>		
</div>
</div>
</div>
</div>
