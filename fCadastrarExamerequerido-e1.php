<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$requisicaoid=$_GET['id'];
$rreq=lerequisicao($requisicaoid,$conacl);
if($rreq){
	$pessoaid=$rreq['pessoa_id'];
    $cpf=$rreq['cpf'];
	$apelido=$rreq['apelido'];
	$nome=$rreq['pessoanome'];
	$datanascimento=$rreq['datanascimento'];
	$datareq=$rreq['data'];
	$medico=$rreq['mediconome'];
	$guia=$rreq['guia'];
	$status=$rreq['status'];
	$statusid=$rreq['statusrequisicao_id'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$requisicaoid.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$requisicaoid.' não encontrado!');
	return '';
}

$exame_id=0;
$convenio_id=0;
$datacoleta=date('Y-m-d');
$horacoleta=date('H:i');
//die('datacoleta:'.$datacoleta.' horacoleta:'.$horacoleta);
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$rexar=leexamerequerido($idc,$conacl);
	if($rexar){
		$sigla=$rexar['sigla'];
		$exame_id=$rexar['exame_id'];
		$exame=$rexar['exame'];
		$convenio_id=$rexar['convenio_id'];
		$convenio=$rexar['convenio'];
		$datacoleta=$rexar['datacoleta'];
		$horacoleta=$rexar['horacoleta'];
	}
}	
$rtab=fleexamerequerido($requisicaoid,$conacl);
$nex=$rtab->rowCount();

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Examerequerido-e1.php';
if($requisicaoid>0){
	$act=$act.'?id='.$requisicaoid;
	if($idc>0){
		$operacao='Atualizar';
		$act=$act.'&idc='.$idc;
	}	
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div>
			Requisição de Exames
			<br><br>
			Paciente:
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Alcunha: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($datanascimento);?></p>
				</div>
			</div>	
			Requisição:
			<div class="row">
				<div class="form-group col-md-2">
					<label>Status: </label>
					<p><?php echo($status);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Data: </label>
					<p><?php echo(formataDataToBr($datareq));?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Guia: </label>
					<p><?php echo($guia);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Médico: </label>
					<p><?php echo($medico);?></p>
				</div>
			</div>	
			Exames já requisitados:
			<table class="tabela1">
				<tr>
					<th width='5%'>Id</th>
					<th width='5%'>Sigla</th>
					<th width='40%'>Exame</th>
					<th width='40%'>Convênio</th>
					<th width='5%'>Exc</th>
			
				</tr>
<?php
foreach($rtab->fetchAll() as $tab) {
		$id1=$tab['id'];
		$sigla1=$tab['sigla'];
		$exame1=$tab['exame'];
		$convenio1=$tab['convenio'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=cadastrar&obj=
examerequerido&cpl=e1&id=<?php echo($requisicaoid);?>&idc=<?PHP echo($id1);?>'><?PHP echo($id1);?>
					</td>
					<td><?PHP echo($sigla1);?></td>
					<td><?PHP echo($exame1);?></td>
					<td><?PHP echo($convenio1);?></td>
<?php
if($statusid==1){		
?>			
					<td><a href='excluirExamerequerido-e1.php?id=<?php echo($requisicaoid);?>&idc=<?php echo($id1);?>'>Del</a>
					</td>
<?php
}
?>					
				</tr>
<?php
}
?>			
			</table>
			<a href="rreqacli01.php?id=<?php echo($requisicaoid);?>" target="_new" > Emitir Requisição</a>
			<br><br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Exame a ser requisitado:</label>
					<select name="exame_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'exame';
			$ordem = 'descricao';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$exame_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],50)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Convênio:</label>
					<select name="convenio_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'convenio';
			$ordem = 'descricao';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$convenio_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],20)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Data para Coleta:</label>
					<input type="date" id="datacoleta" name="datacoleta" size="10" maxlength="10" class="form-control" value="<?php echo($datacoleta);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Hora para Coleta:</label>
					<input type="time" id="horacoleta" name="horacoleta" size="10" maxlength="10" class="form-control" value="<?php echo($horacoleta);?>">
				</div>
<?php
if($nex>0){
?>	
				<input type="hidden" name="confirmacao" value="0">
				<div class="form-checkbox">
					<input class="form-check-input" type="checkbox"
                   value="1" name="confirmacao" id="confirmacao" required></input>
					<label class="form-check-label btn btn-xs" for="confirmacao">
                Sem mais exames</label>
				</div>
<?php
}
?>				
			</div>

			<br>	
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form> 
<?php 
if($idc>0){
?>
		<p><a href="chameformulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=<?php echo($requisicaoid);?>">Novo Exame</a></p>
<?php 
}
?>		
    </div>    
</div>	

