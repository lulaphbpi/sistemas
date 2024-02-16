<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarPaciente-f1.php';
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
//		echo('aqui 1'.$textopesquisa);
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
//		echo('aqui 2:'.$textopesquisa);
		$ord=$_SESSION['inicial'];
	}
}
$grupo=$_SESSION['grupo'];
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=flistapaciente_fi($textopesquisa,$usuarioid,$conefi);
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
			<p>Pacientes - Digite o nome do Paciente a pesquisar: </p>
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
	<p>Lista de Pacientes - Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>SPId</th>
		<th width='17%'>Paciente</th>
		<th width='18%'>Data Nasc</th>
		<th width='30%'>Contato</th>
		<th width='15%'>Diagnóstico</th>
		<th width='10%'>Status</th>
		<th width='15%'>AF?</th>
		<th width='15%'>Doc</th>
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
	$spid = $rec['spid'];
	//$idc = $rec['id'];
	//$sid = $rec['sid'];  //servicopessoa
	$responsavel1=$rec['professor'];
	$pessoaid=$rec['pacienteid'];
	$cliente1=fnumero($rec['pacienteid'],4).'-'.$rec['paciente'];
	$datanascimento=formataDataToBr($rec['datanascimento']);
	$idade = idade($rec['datanascimento']);
	$datanascimento1=$datanascimento.' ('.$idade.' anos)';
	$contato1=$rec['contato'];
	$diagnosticomedico1=$rec['diagnosticomedico'];
	$spstatus=$rec['statuspaciente'];
	//$motivo=$rpes['motivo'];
	//$observacoes=$rpes['observacoes'];
	$servico1=$rec['servico'];
	$fezavaliacao=' - ';
    $fezavaliacao=fezAvaliacao_fi($pessoaid,$spid,$conefi);
	if($contador==1){
?>
	<tr>
		<td colspan='5'>Professor(a): <?PHP echo($responsavel1);?>  Serviço: <?php echo($servico1);?></td>
	</tr>	
<?php
	}
?>		
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=agendamento&cpl=f1&id=<?PHP echo($spid);?>'><?PHP echo($spid);?></a></td>
		<td><?PHP echo($cliente1);?></td>
		<td><?PHP echo($datanascimento1);?></td>
		<td><?PHP echo($contato1);?></td>
		<td><?PHP echo($diagnosticomedico1);?></td>
		<td><?PHP echo($spstatus);?></td>
		<td><?PHP echo($fezavaliacao);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=portifolio&cpl=f1&id=<?PHP echo($spid);?>'><?PHP echo($spid);?></a></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=paciente&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
