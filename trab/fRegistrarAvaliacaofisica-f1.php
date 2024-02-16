<?php
include('inicio.php');
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

$trace=ftrace('fRegistrarAgendamento-f1.php','Inicio:'.$usuarioid);

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid
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
//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];  // agendaid
$tab=leagendaoperador($idc, $conefi);
if($tab){
	$servico1=$tab['servico'];
	$sid=$tab['servico_id'];
	$data1=$tab['data'];
	$horainicial1=$tab['horainicial'];
}	
/*
if($rreg)
	$totalagendas=$rreg->rowCount();
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Agendamento-f1.php?id='.$id; //die($act);
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$trace=ftrace('fRegistrarAgendamento-f1.php','Vai ler agenda idc='.$idc);
	$rage=leagendaoperador($idc, $conefi);
	if($rage){
		$data=$rage['data'];
		$horainicial=$rage['horainicial']; $trace=ftrace('fRegistrarAgendamento-f1.php',$data.' '.$horainicial);
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Confirme para Excluir';
			$act='registrarAgendamento-f1.php?id='.$id.'&idc='.$idc.'&del=del'; //die($act);
		}	
	}else{
		$operacao='Confirme para Alterar';
		$act='registrarAgendamento-f1.php?id='.$id.'&idc='.$idc; //die($act);
	}		
}
*/	
$operacao='Aplicar Questionário';
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Avaliação Física - Pessoa <?php echo($pessoaid);?></b>
			<br>
			<div class="row">
				<div class="form-group col-md-1">
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
				<div class="form-group col-md-2">
					<label>Serviço: </label>
					<p><?php echo($servico1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Data: </label>
					<p><?php echo($data1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Hora: </label>
					<p><?php echo($horainicial1);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-5">
					<label>Selecione o Questionário a Aplicar:</label>
					<select name="questionarioservico_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php
			$rtab=flequestionarioservico($sid); die('1');
			$questionarioservicoid=0;
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>0){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$questionarioservicoid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['questionario'],60)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>
				</div>	
			</div>	
			<br>	
			<div class="row">
				<div class="form-group col-md-10">
				<button type="button" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
    </div>    
</div>	