<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$ordenacao='';

$rotina='fConsultarAgendatratamento-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']=' ';
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
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
		$ord=$_SESSION['inicial'];
	}
}
$grupo=$_SESSION['grupo'];
$pessoaid=$_SESSION['pessoaid'];
if($vez==0){	
	$reclst=fpesquisaagendaservico_fi($textopesquisa,2,$ordenacao,$usuarioid,$pessoaid,$grupo,$conefi);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$ord=$_SESSION['inicial'];
	$_SESSION['texto']=$textopesquisa;
}	
if(!$leu){$_SESSION['rotina']='xxx';}
// Área de PK
$pvez=true;
//if(empty($textopesquisa)) {$textopesquisa=' ';}

?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Tratamento (Evolução) - Digite o nome do Paciente a pesquisar: </p>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
<!--			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=consultar&obj=agenda&cpl=f1" > Ver Minha Agenda</a>
-->
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
		<th width='5%'>AgId</th>
		<th width='15%'>Responsável</th>
		<th width='20%'>Paciente</th>
		<th width='20%'>Serviço</th>
		<th width='20%'>Estagiário</th>
		<th width='10%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='15%'>Status</th>
		<th width='5%'>Agenda</th>
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
	$id = $rec['id']; // agendaid
	//$idc = $rec['id'];
	$sid = $rec['sid'];  //servicopessoa
	$eid = $rec['estagiario_id'];
	$responsavel1=$rec['operador'];
	$cliente1=fnumero($rec['pacienteid'],4).'-'.$rec['paciente'];
	$servico1=$rec['siglaservico'];
	//$estagiario1=$rec['estagiario'];
	$estagiario1=$rec['epid'].'-'.$rec['estagiario'];
	$data1=formataDataToBr($rec['data']);
	$horainicial1=$rec['horainicial'];
	$statusservico1=$rec['statusservico'];
	$statusservicoid1=$rec['statusservico_id'];
	$tipodeagenda=$rec['tipodeagenda'];
	$tipodeagendaid=$rec['tipodeagenda_id'];
	$_SESSION['agendaid']=$id;

?>
   	<tr>
		<td><?PHP echo($ord);?></td>
	<?php	
		if($grupo == 'esa'){
	?>		
		<td><?PHP echo($id);?></td>
	<?php
		}else{	
	?>		
		<td><a href='chameFormulario.php?op=registrar&obj=agendamento&cpl=f1&id=<?PHP echo($sid);?>&idc=<?php echo($id);?>&idx=<?php echo($eid);?>'><?PHP echo($id);?></a></td>
	<?php
		}	
	?>		
		<td><?PHP echo($responsavel1);?></td>
		<td><?PHP echo($cliente1);?></td>
		<td><?PHP echo($servico1);?></td>
		<td><?PHP echo($estagiario1);?></td>
		<td><?PHP echo($data1);?></td>
		<td><?PHP echo($horainicial1);?></td>
		<td><?PHP echo($statusservico1);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=<?php echo($sid);?>&idx=<?php echo($id);?>'><?PHP echo($tipodeagenda);?></a></td>
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
		$_SESSION['inicial']=0;
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=agendatratamento&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
