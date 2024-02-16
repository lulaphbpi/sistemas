<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conefi=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisafisioterapeuta_fi($tx,$conefi);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if($_SESSION['inicial']>0){
		$tx=$_SESSION['texto'];
		$reclst=fpesquisafisioterapeuta_fi($tx,$conefi);
		$totallinhas=$reclst->rowCount();
		$leu=true;
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
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Digite o texto a pesquisar no nome (Arquivo de Fisioterapeutas): </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=consultar&obj=pessoa_fisioterapeuta&cpl=f1" > Cadastrar Fisioterapeuta<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rfisioterapeuta01.php" target="_new" > Relação Geral de Fisioterapeutas</a>
			</div>
			<br><br>
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
		<th width='40%'>Nome</th>
		<th width='10%'>CRM</th>
		<th width='30%'>Especialidade</th>

	</tr>
<?php
if($_SESSION['inicial']>0){
	$contador=0;
	while($contador<$_SESSION['inicial']){
		$rec=$reclst->fetch();
		$contador++;
	}
	$ord=$contador;
}
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$fisioterapeutaid = $rec['id'];
	$pid = $rec['pessoa_id'];
	$nome = $rec['nome'];
	$crm = $rec['crm'];
	$especialidade = $rec['especialidade'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
fisioterapeuta&&cpl=f1&id=<?PHP echo($fisioterapeutaid);?>'><?PHP echo($fisioterapeutaid);?></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($crm);?></td>
		<td><?PHP echo($especialidade);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
fisioterapeuta&cpl=f1&id=<?PHP echo($pid);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
    </tr>
<?php
	}
}
?>
	</table>


	<table class="tabela1">	
	<tr>
		<td>
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=fisioterapeuta&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
