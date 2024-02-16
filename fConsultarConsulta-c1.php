<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$connae=conexao('consnae');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$reclst=fleconsultanae($id,$connae);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if($_SESSION['inicial']>0){
		$reclst=fleconsultanae($id,$connae);
		$totallinhas=$reclst->rowCount();
		$leu=true;
	}
}	

// Área de PK
$pvez=true;
$rpessoa=lepessoafisicaporid($id,$conpes);
if($rpessoa){
	$nome=$rpessoa['nome'];
	$apelido=$rpessoa['apelido'];
	$datanascimento=$rpessoa['datanascimento'];
	$idade=idade($datanascimento);
	//$datanascimento=formataDataToBr($rpessoa['datanascimento']);
	$cpf=$rpessoa['cpf'];
	$sexo=$rpessoa['sexo'];
}	
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
		<div id="lblerro"><?php echo($msg); ?></div><br>
		<a href="chameFormulario.php?op=marcar&obj=consulta&cpl=c1&id=<?php echo($id);?>" > Consulta(s) do Paciente <?php echo($id);?>:<a>
	<br>
    <form action="" method="post" id="iformulario">
		<div class="row">
				<div class="form-group col-md-2">
					<label>Apelido:</label>
					<input type="text" id="apelido" name="apelido" size="30" maxlength="30" class="form-control" value='<?php echo($apelido);?>' required>
				</div>
				<div class="form-group col-md-4">
					<label>Nome Completo:</label>
					<input type="text" id="nome" name="nome" size="70" maxlength="70" class="form-control" value='<?php echo($nome);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label>Data Nasc. <?php echo('('.$idade.' anos)');?>:</label>
					<input type="date" id="datanascimento" name="datanascimento" size="10" maxlength="10" class="form-control" value='<?php echo($datanascimento);?>' >
				</div>
				<div class="form-group col-md-2">
					<label>Sexo:</label><br>
					<label for="idfeminino">Fem</label>
					<input type="radio" class="simnao" name="sexo" id="idfeminino" value="F" <?php if($sexo=='F'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idmasculino">Mas</label>
					<input type="radio" class="simnao" name="sexo" id="idmasculino" value="M" <?php if($sexo=='M'){echo("checked");} ?>>
				</div>
		</div>
	</form>
<?php
if($totallinhas>0){
?>
	<p>Consulta(s):</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>Id</th>
		<th width='10%'>Responsável</th>
		<th width='10%'>Convênio</th>
		<th width='10%'>SUS</th>
		<th width='20%'>Médico</th>
		<th width='10%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='10%'>Confirmado?</th>
		<th width='10%'>Realizado?</th>
		<th width='5%'>Del</th>
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
	$consultaid=$rec['consulta_id'];
	$cpfresponsavel=$rec['cpfresponsavel'];
	$convenio=$rec['convenio'];
	$cartaosus=$rec['cartaosus'];;
	$medico = $rec['medico'];
	$convenio=$rec['convenio'];
	$dataconsulta = formataDataToBr($rec['dataconsulta']);
	$horario = $rec['horario'];
	$confirmado = $rec['confirmado'];
	if($confirmado=='S')
		$confirmado='SIM';
	$realizado = $rec['realizado'];
	if($realizado=='S')
		$realizado='Não';
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=marcar&obj=
consulta&&cpl=c1&id=<?PHP echo($id);?>&idc=<?PHP echo($consultaid);?>'><?PHP echo($consultaid);?></td>
		<td><?PHP echo($cpfresponsavel);?></td>
		<td><?PHP echo($convenio);?></td>
		<td><?PHP echo($cartaosus);?></td>
		<td><?PHP echo($medico);?></td>
		<td><?PHP echo($dataconsulta);?></td>
		<td><?PHP echo($horario);?></td>
		<td><?PHP echo($confirmado);?></td>
		<td><?PHP echo($realizado);?></td>
		<td><?PHP echo('Exc');?></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=medico&cpl=m1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
	<br>
	<p><a href='chameFormulario.php?op=marcar&obj=consulta&cpl=c1&id=<?php echo($id); ?>'>Nova Consulta</a></p>
</div>
</div>
</div>
