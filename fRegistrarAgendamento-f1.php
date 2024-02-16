<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarAgendamento-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];

//$trace=ftrace('fRegistrarAgendamento-f1.php','Inicio:'.$usuarioid);

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid
$data=date('Y-m-d');
$horainicial=''; //date('H:i');
$idagenda=''; $datainicial='';
$estagiario_id=0; $horainicial_id=0;
$tipodeagendaid=0;
$rpes=leservicopessoaid_fi($spid,$conefi);
if($rpes){
	$pessoaid=$rpes['pessoa_id'];
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome'];
	$datanascimento=$rpes['datanascimento'];
	$idade = idade($rpes['datanascimento']);
	$dtn=formataDataToBr($datanascimento);
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$data=$rpes['data'];
	$diagnosticomedico=$rpes['diagnosticomedico'];
	$motivo=$rpes['motivo'];
	$observacoes=$rpes['observacoes'];
	$contato=$rpes['contato'];
	$servicoid=$rpes['servico_id'];
	$statussp=$rpes['statussp'];
//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='fRegistrarAgendamento-f1.php - ERRO FATAL: Id '.$id.' não encontrado!'; die('Fatal :'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$tipodeagendaid=0;
$grupo=$_SESSION['grupo'];
$nomeservico=lenomeservico($servicoid, $conefi);
$rreg=fleagendaservico($spid, $usuarioid, $grupo, $conefi);
if($rreg)
	$totalagendas=$rreg->rowCount();
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Agendamento-f1.php?id='.$spid; //die($act);
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc']; $estagiario_id=$_GET['idx'];
	//$trace=ftrace('fRegistrarAgendamento-f1.php','Vai ler agenda idc='.$idc);
	$rage=leagendaoperador($usuarioid, $idc, $grupo, $conefi);
	if($rage){
		$idagenda=$rage['id'];
		$tipodeagendaid=$rage['tipodeagenda_id'];
		$datainicial=$rage['data'];
		$horainicial=$rage['horainicial']; //$trace=ftrace('fRegistrarAgendamento-f1.php',$data.' '.$horainicial);
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Confirme p/ Excluir';
			$act='registrarAgendamento-f1.php?id='.$spid.'&idc='.$idc.'&del=del'; //die($act);
		}	
	}else{
		$operacao='Confirme p/ Alterar';
		$act='registrarAgendamento-f1.php?id='.$spid.'&idc='.$idc; //die($act);
	}		
}
//$f=ftrace('fRegistrarAgendamento-f1.php','Operacao='.$act);	
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Paciente - Agendamento para Avaliação Física (Pessoa <?php echo($pessoaid);?>)</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Nome Social: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Gênero: </label>
					<p><?php echo($sexo);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Fone: </label>
					<p><?php echo($fone);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-2">
					<label>Data:</label>
					<p><?php echo($data);?></p>
				</div>
				<div class="form-group col-md-6">
					<label>Nome/ Contato Emergência:</label><br>
					<p><?php echo($contato);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Status:</label><br>
					<p><?php echo($statussp);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-4">
					<label>Diagnóstico Médico:</label><br>
					<p><?php echo($diagnosticomedico);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Motivo/Queixas:</label>
					<p><?php echo($motivo);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Observações:</label><br>
					<p><?php echo($observacoes);?></p>
				</div>
			</div>	
			<p>Agendar para:</p>
			<div class="row">
				<div class="form-group col-md-1">
					<label>Agenda:</label>
					<input type="text" id="idagenda" name="idagenda" size="10" maxlength="5" class="form-control" value="<?php echo($idagenda);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Tipo:</label>
					<select name="tipodeagendaid" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			//$tabela = 'horainicial';
			//$ordem = 'id';
			$rtab=fletipodeagenda_fi($conefi);
			//$f=ftrace('fleestagiario','1');
			if($rtab) {
				//$f=ftrace('fleestagiario','2');
				if($rtab->rowCount()>0) {
					//$f=ftrace('fleestagiario','3');
					foreach($rtab->fetchAll() as $tab) { 
						//$f=ftrace('fleestagiario',$tab['id']);
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodeagendaid){echo("selected='selected'");} ?>> <?php echo($tab['descricao2']); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Data Inicial:</label>
					<input type="date" id="datainicial" name="datainicial" size="10" maxlength="10" class="form-control" value="<?php echo($datainicial);?>" required>
				</div>
				<div class="form-group col-md-2">
					<label>Hora:</label>
					<select name="horainicial" class="form-control" required > 
						<option value="0" selected="selected"></option>
<?php
			//$tabela = 'horainicial';
			//$ordem = 'id';
			$rtab=flehorainicial_fi($conefi);
			//$f=ftrace('fleestagiario','1');
			if($rtab) {
				//$f=ftrace('fleestagiario','2');
				if($rtab->rowCount()>0) {
					//$f=ftrace('fleestagiario','3');
					foreach($rtab->fetchAll() as $tab) { 
						//$f=ftrace('fleestagiario',$tab['id']);
?>
						<option value="<?php echo($tab['horainicial']); ?>" <?php if($tab['horainicial']==$horainicial){echo("selected='selected'");} ?>> <?php echo($tab['horainicial']); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Estagiário:</label>

					<select name="estagiario_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			//$tabela = 'estagiario';
			//$ordem = 'denominacaocomum';
			$rtab=fleestagiario_fi($conefi);
			//$f=ftrace('fleestagiario','1');
			if($rtab) {
				//$f=ftrace('fleestagiario','2');
				if($rtab->rowCount()>0) {
					//$f=ftrace('fleestagiario','3');
					foreach($rtab->fetchAll() as $tab) { 
						//$f=ftrace('fleestagiario',$tab['id']);
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$estagiario_id){echo("selected='selected'");} ?>> <?php echo(fstring(fnumero($tab['id'],3).'-'.$tab['nomesocial'],30)); ?></option>
<?php
					}
				}
			}
?>
					</select>


				</div>
				<div class="form-group col-md-2">
					<br><button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
			<br>	
        </form>
		<div class="row">
				<div class="form-group col-md-12">
<?php
if($totalagendas>0){
?>
	<p>Agenda de Serviço/Área: <strong><?php echo($nomeservico);?></strong></p>
	<table class="tabela1">
	<tr>
		<th width='5%'>AgId</th>
		<th width='15%'>Responsável</th>
		<th width='15%'>Paciente</th>
		<th width='10%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='15%'>Estagiário</th>
		<th width='20%'>Agenda</th>
		<th width='5%'>AF?</th>
		<th width='10%'>Status</th>
		<th width='5%'>Excluir</th>
	</tr>
<?php
foreach($rreg->fetchAll() as $tab) {
		$sid=$tab['id'];  // agendaid
		$responsavel1=$tab['operador'];
		$cliente1=fstring($tab['pacienteid'],4).'-'.$tab['paciente'];
		$servico1=$tab['servico'];
		$data1=formataDataToBr($tab['data']);
		$horainicial1=$tab['horainicial'];
		//$estagiario1=$tab['estagiario'];
		$estagiario1=fnumero($tab['espessoaid'],4).'-'.$tab['estagiario'];
		$estagiarioid1=$tab['estagiario_id'];
		$tipodeagenda1=$tab['tipodeagenda'];
		$statusagenda1=$tab['statusagenda'];
		$statusagendaid1=$tab['statusagenda_id'];
		$fezavaliacao1=fezAvaliacao2_fi($sid,$conefi);

		//$trace=ftrace('fRegistrarAgendamento-f1.php',$statusagendaid1);
?>				
				<tr>
					<td><a href='chameFormulario.php?op=registrar&obj=Agendamento&cpl=f1&id=<?php echo($spid);?>&idc=<?PHP echo($sid);?>&idx=<?php echo($estagiarioid1); ?>'><?PHP echo($sid);?></a></td>
					<td><?PHP echo($responsavel1);?></td>
					<td><?PHP echo($cliente1);?></td>
					<td><?PHP echo($data1);?></td>
					<td><?PHP echo($horainicial1);?></td>
					<td><?PHP echo($estagiario1);?></td>
					<td><?PHP echo($tipodeagenda1);?></td>
					<td><?PHP echo($fezavaliacao1);?></td>
					<td><?PHP echo($statusagenda1);?></td>
<?php 
// se agenda não realizada
if($statusagendaid1<>2){ 
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=Agendamento&cpl=f1&id=<?php echo($spid);?>&idc=<?PHP echo($sid);?>&idx=<?php echo($estagiarioid1); ?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
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
}
?>			
				</div>
		</div>
<?php
if($rpes && $rreg){		
?>

<?php
}
?>
	<p><a href='chameFormulario.php?op=consultar&obj=agendamento&cpl=f1'>Retornar</a>	</p>		

    </div>    
</div>	