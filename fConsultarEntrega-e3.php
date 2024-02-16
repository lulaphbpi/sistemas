<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$nome='';
$datai=DateToStr(date('Y-m-d'));
$dataf=$datai;
$datai='2000-01-01';

$contador=0;
if(isset($_POST['nome'])){
	$nome=trim(addslashes($_POST['nome']));
	$datai=$_POST['datai'];
	$dataf=$_POST['dataf'];
	$reclst=fpesquisarequisicao($nome,$datai,$dataf,$conacl);
	if($reclst){
		$totallinhas=$reclst->rowCount();
		$leu=true;
		$_SESSION['parametros'] = array (
			"nome" => $nome,
			"datai" => $datai,
			"dataf" => $dataf
		);	
		$_SESSION['inicial']=0;
		$ord=0;
	}else{
		$msg=$_SESSION['msg'];
	}	
}else{
	if(isset($_SESSION['inicial']) && empty($_SESSION['inicial']) == false){
	if($_SESSION['inicial']>0){
		$parametros=$_SESSION['parametros'];
		$reclst=fpesquisarequisicao($parametros['nome'],$parametros['datai'],
				$parametros['dataf'], $conacl);
		$totallinhas=$reclst->rowCount();
		$leu=true;
		$nome=$parametros['nome'];
		$datai=$parametros['datai'];
		$dataf=$parametros['dataf'];
	}}
}
// Área de PK
//$msg="Mensagem:".$msg;
$pvez=true;
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Entrega de Laudos - Selecione parâmetros - ROTINA INCOMPLETA !!! (Funcionando inadequadamente! NÃO CLIQUE Ok) </p>
			<br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Nome do Paciente:</label>
					<input type="text" name="nome" id="nome" size="40" maxlength="40" class="form-control" value="<?php echo($nome);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
	            <div class="form-group col-md-3">
					<label>Data Inicial:</label>
					<input type="date" name="datai" id="datai" class="form-control" value="<?php echo($datai);?>" 
                       required></input>
				</div>
	            <div class="form-group col-md-3">
					<label> Data Final:</label>
					<input type="date" name="dataf" id="dataf" class="form-control" value="<?php echo($dataf);?>" 
                       required></input>
				</div>
			</div>
			<div class="row">
	            <div class="form-group col-md-9">
				<button type="submit" class="btn btn-primary btn-block">Ok</button>
				</div>
			</div>
		</form>
	<br>
<?php
if($totallinhas>0){
?> 
	<p>Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width='03%'>Ord</th>
		<th width='05%'>Id</th>
		<th width='10%'>Data</th>
		<th width='30%'>Cliente</th>
		<th width='12%'>Fone</th>
		<th width='30%'>Médico</th>
		<th width='12%'>Guia</th>
		<th width='05%'>Op</th>
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
//foreach($reclst->fetchAll() as $rec) {
	$rec=$reclst->fetch();
	if($rec){
	$ord++;
	$pessoaid = $rec['pessoa_id'];
	$id = $rec['id'];
	$data = $rec['data'];
	$nome = $rec['pessoanome'];
	$fone = $rec['fone'];
	$medico = $rec['medico'];
	$guia = $rec['guia'];
?>
   	<tr>
<!--        <td><a href='chameFormulario.php?op=edita&obj=usuario&id=
	<?PHP //echo($id);?>'><?PHP //echo($id);?></a></td>
-->
		<td><?PHP echo($ord);?></td>
		<td><?PHP echo($id);?></td>
		<td><?PHP echo($data);?></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($medico);?></td>
		<td><?PHP echo($guia);?></td>
        <td><a href='chameFormulario.php?op=cadastrar&obj=requisicao&cpl=r1&id=<?PHP echo($pessoaid);?>&idc=<?PHP echo($id);?>'>Laudo</a></td>
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
			$inicial=$ord;
		?>
		<td><a href='chameFormulario.php?op=listarrequisicoes2&obj=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
	&nbsp;&nbsp;&nbsp;<a href="rreq01.php?<?php echo('sit='.$csit.'&datai='.$datai.'&dataf='.$dataf);?>" target="_new" > Relatório</a>
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
<?php 
$_SESSION['msg']='';
?>
