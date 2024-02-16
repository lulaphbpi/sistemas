<?php
include('../include/sa000.php');
$conefi=conexao('efisio');
$conpes=conexao('pessoal');

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

$trace=ftrace('fAgendarTratamento-f1.php','Inicio:'.$usuarioid);

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];  // servicopessoaid
$data=date('Y-m-d');
$horainicial=date('H:i');
$rpes=leservicopessoaid_fi($id,$conefi);
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
//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}

$rreg=fleagendaoperador($usuarioid, $conefi);
if($rreg)
	$totalagendas=$rreg->rowCount();
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Tratamento-f1.php?id='.$id; //die($act);
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$trace=ftrace('fAgendarTratamento-f1.php','Vai ler agenda idc='.$idc);
	$rage=leagendaoperador($idc, 2, $conefi);
	if($rage){
		$data=$rage['data'];
		$horainicial=$rage['horainicial']; $trace=ftrace('fAgendarTratamento-f1.php',$data.' '.$horainicial);
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Confirme para Excluir';
			$act='agendarTratamento-f1.php?id='.$id.'&idc='.$idc.'&del=del'; //die($act);
		}	
	}else{
		$operacao='Confirme para Alterar';
		$act='agendarTratamento-f1.php?id='.$id.'&idc='.$idc; //die($act);
	}		
}	
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Paciente - Agendamento para Tratamento (Pessoa <?php echo($pessoaid);?>)</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Alcunha: </label>
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
					<label>Sexo: </label>
					<p><?php echo($sexo);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Fone: </label>
					<p><?php echo($fone);?></p>
				</div>
			</div>	
			<p>Agendar para:</p>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Data:</label>
					<input type="date" id="data" name="data" size="10" maxlength="10" class="form-control" value="<?php echo($data);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Hora Inícial:</label>
					<input type="time" id="horainicial" name="horainicial" size="10" maxlength="10" class="form-control" value="<?php echo($horainicial);?>">
				</div>
			</div>	
			<br>	
			<div class="row">
				<div class="form-group col-md-10">
				<button type="button" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
		<div class="row">
				<div class="form-group col-md-11">
<?php
if($totalagendas>0){
?>
	<p>Agenda do Operador:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Id</th>
		<th width='12%'>Responsável</th>
		<th width='20%'>Cliente</th>
		<th width='25%'>Serviço</th>
		<th width='8%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='10%'>Agenda</th>
		<th width='10%'>Status</th>
		<th width='5%'>Excluir</th>
	</tr>
<?php
foreach($rreg->fetchAll() as $tab) {
		$sid=$tab['id'];
		$responsavel1=$tab['operador'];
		$cliente1=$tab['cliente'];
		$servico1=$tab['servico'];
		$data1=formataDataToBr($tab['data']);
		$horainicial1=$tab['horainicial'];
		$tipodeagenda1=$tab['tipodeagenda'];
		$statusagenda1=$tab['statusagenda'];
		$statusagendaid1=$tab['statusagenda_id'];
		$trace=ftrace('fAgendarTratamento-f1.php',$statusagendaid1);
?>				
				<tr>
					<td><a href='chameFormulario.php?op=agendar&obj=Tratamento&cpl=f1&id=<?php echo($id);?>&idc=<?PHP echo($sid);?>'><?PHP echo($sid);?></a></td>
					<td><?PHP echo($responsavel1);?></td>
					<td><?PHP echo($cliente1);?></td>
					<td><?PHP echo($servico1);?></td>
					<td><?PHP echo($data1);?></td>
					<td><?PHP echo($horainicial1);?></td>
					<td><?PHP echo($tipodeagenda1);?></td>
					<td><?PHP echo($statusagenda1);?></td>
<?php 
// se agenda não realizada
if($statusagendaid1<>2){ 
?>					
					<td><a href='chameFormulario.php?op=agendar&obj=tratamento&cpl=f1&id=<?php echo($id);?>&idc=<?PHP echo($sid);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
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
    </div>    
</div>	