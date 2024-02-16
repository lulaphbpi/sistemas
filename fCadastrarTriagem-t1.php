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
$datacoletada=date('Y-m-d');
$horacoletada=date('H:i');
//die('datacoleta:'.$datacoleta.' horacoleta:'.$horacoleta);
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$rexar=leexamerequerido($idc,$conacl);
	if($rexar){
		$examerequeridoid=$idc;
		$sigla=$rexar['sigla'];
		$exame_id=$rexar['exame_id'];
		$exame=$rexar['exame'];
		$convenio_id=$rexar['convenio_id'];
		$convenio=$rexar['convenio'];
		$datacoleta=$rexar['datacoleta'];
		$horacoleta=$rexar['horacoleta'];
		$datacoletada=$rexar['datacoletada'];
		$horacoletada=$rexar['horacoletada'];
		if(empty($datacoletada) || ($datacoletada=='0000-00-00')){
			$datacoletada=date('Y-m-d');
			$horacoletada=date('H:i');
		}
	}
}	
$rtab=fleexamerequerido($requisicaoid,$conacl);

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Triagem-t1.php';
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
			<div id="lblerro"><?php echo($msg); ?></div><br>
			Triagem
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
					<p><?php echo($apelido);?></p>
				</div>
			</div>	
			Exames Requisitados:
			<table class="tabela1">
				<tr>
					<th width='5%'>Id</th>
					<th width='5%'>Sigla</th>
					<th width='30%'>Exame</th>
					<th width='15%'>Convênio</th>
					<th width='10%'>Data Coleta</th>
					<th width='5%'>Hora</th>
					<th width='10%'>Coletado em</th>
					<th width='5%'>às</th>
					<th width='5%'>Coleta</th>
				</tr>
<?php
foreach($rtab->fetchAll() as $tab) {
		$id1=$tab['id'];
		$sigla1=$tab['sigla'];
		$exame1=$tab['exame'];
		$convenio1=$tab['convenio'];
		$dtc=$tab['datacoleta'];
		$datacoleta1=formataDataToBr($dtc);
		$horacoleta1=$tab['horacoleta'];
		$dtcd=$tab['datacoletada'];
		$datacoletada1=formataDataToBr($dtcd);
		$horacoletada1=$tab['horacoletada'];
		$codigo1=$tab['codigo'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=cadastrar&obj=
examerequerido&cpl=e1&id=<?php echo($requisicaoid);?>&idc=<?PHP echo($id1);?>'><?PHP echo($id1);?>
					</td>
					<td><?PHP echo($sigla1);?></td>
					<td><?PHP echo($exame1);?></td>
					<td><?PHP echo($convenio1);?></td>
					<td><?PHP echo($datacoleta1);?></td>
					<td><?PHP echo($horacoleta1);?></td>
					<td><?PHP echo($datacoletada1);?></td>
					<td><?PHP echo($horacoletada1);?></td>
					<td><a href='chameFormulario.php?op=cadastrar&obj=triagem&cpl=t1&id=<?PHP echo($requisicaoid);?>&idc=<?php echo($id1);?>'><?php if(empty($horacoletada1)) echo('Coleta'); else echo('Coletada'); ?></a>
					</td>
<?php
if(!$codigo1==''){			
?>		
					<td><a href="icodb.php?id=<?php echo($requisicaoid);?>&n=<?php echo($codigo1);?>" target="_blank">Etq</a></td>
<?php
}	
?>				
				</tr>
<?php
}
?>			
			</table>
			<br>
<?php
if($idc>0){
?>	
			Coleta
			<div class="row">
				<div class="form-group col-md-1">
					<label>Item:</label>
					<input type="text" id="examerequeridoid" name="examerequeridoid" size="5" maxlength="5" class="form-control" value="<?php echo($examerequeridoid);?>">
				</div>
				<div class="form-group col-md-3">
					<label>Exame:</label>
					<input type="text" id="exame" name="exame" size="20" maxlength="20" class="form-control" value="<?php echo($exame);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Data Coleta:</label>
					<input type="date" id="datacoletada" name="datacoletada" size="10" maxlength="10" class="form-control" value="<?php echo($datacoletada);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Hora Coleta:</label>
					<input type="time" id="horacoletada" name="horacoletada" size="10" maxlength="10" class="form-control" value="<?php echo($horacoletada);?>">
				</div>
				<div class="form-group col-md-2">
					<label><i>Emite Código?</i></label><br>
					<label for="idnao">Sim</label>
					<input type="radio" class="simnao" name="emitecodigo" id="emitecodigo" value='S'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Não</label>
					<input type="radio" class="simnao" name="emitecodigo" id="emitecodigo" value="N" <?php echo("checked"); ?>>
				</div>
				
			</div>

			<br>	
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
<?php
}
?>			
        </form> 
    </div>    
</div>	

