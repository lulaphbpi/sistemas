<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarAgendaavaliacao-f1.php';
$rotinaanterior=$_SESSION['rotina'];
$ordenacao='';
if(isset($_SESSION['ordenacao']))
	$ordenacao=$_SESSION['ordenacao'];

if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']=' ';
	$_SESSION['ordenacao']='';
	$ordenacao='';
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
if(isset($_GET['del']) && empty($_GET['del']) == false) {
	$ordenacao='id';
	$_SESSION['ordenacao']=$ordenacao;
}	

$grupo=$_SESSION['grupo'];
$pessoaid=$_SESSION['pessoaid'];
if($vez==0 or $ordenacao=='id'){	
//	echo('aqui 3:'.$textopesquisa);
//	$reclst=fpesquisaagendaoperador_fi($textopesquisa,1,$usuarioid,$grupo,$conefi);
	$reclst=fpesquisaagendaservico_fi($textopesquisa,1,$ordenacao,$usuarioid,$pessoaid,$grupo,$conefi);
	$totallinhas=$reclst->rowCount();
//	echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
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
			<p>Avaliação Física - Digite o nome do Paciente a pesquisar: </p>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
<!--			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=consultar&obj=agenda&cpl=f1" > Ver Minha Agenda</a>
-->
			</div>
			&nbsp;&nbsp;<a href='chameFormulario.php?op=consultar&obj=agendaavaliacao&cpl=f1&del=<?php echo('id');?>'>Ordenar por Agenda</a>
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
		<th width='15%'>Fisioterapia</th>
		<th width='20%'>Estagiário</th>
		<th width='10%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='20%'>Serv em</th>
		<th width='5%'>AF?</th>
		<th width='5%'>Status</th>
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
	$id = $rec['id'];  // agendaid
	//$idc = $rec['id'];
	$sid = $rec['sid'];  //servicopessoa
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
	$statusagenda=$rec['statusagenda'];
	$statusagendaid=$rec['statusagenda_id'];
	$tipodeagendaid=$rec['tipodeagenda_id'];
	$fezavaliacao1=fezAvaliacao2_fi($id,$conefi);

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
		<td><a href='chameFormulario.php?op=registrar&obj=agendamento&cpl=f1&id=<?php echo($sid);?>'><?PHP echo($id);?></a></td>
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
		<td><?PHP echo($fezavaliacao1);?></td>
<?php 
if($statusagendaid<3){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=<?php echo($id);?>&idc=<?PHP echo($sid);?>'><?PHP echo($statusagenda);?></a></td>
<?php
}else{
?>
					<td><?PHP echo($statusagenda);?></td>
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
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		$_SESSION['inicial']=0;
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=agendaavaliacao&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
