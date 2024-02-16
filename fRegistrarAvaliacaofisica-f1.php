<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarAvaliacaofisica-f1.php';
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

//$trace=ftrace('fRegistrarAvaliacaofisica-f1.php','usuarioid:'.$usuarioid);

$questionarioservicoid=0;

$spid=0; $agendaid=0;
/*
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$spid=$_GET['idc'];  // servicopessoaid

if(isset($_SESSION['agendaid'])) 
	$agendaid=$_SESSION['agendaid'];
*/	
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$agendaid=$_GET['id'];  // servicopessoaid

$_SESSION['agendaid']=$agendaid;	
$_SESSION['spid']=$spid;
$idc=$spid;

$ragenda=leagenda_fi($agendaid,$conefi);
if($ragenda){
	$spid=$ragenda['servicopessoa_id'];
}
//$t=ftrace('fRegistraravaliacaofisica-f1','x: agendaid='.$agendaid.' spid='.$spid);

$statusservicoid=0;
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
	$status=$rpes['statussp'];
	$statusservicoid=$rpes['statusservico_id'];
	$servico=$rpes['servico'];
	$rqa=flequestionarioaplicado($agendaid);

//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: servicopessoa_id '.$agendaid.' não encontrado!'; die('ERRO FATAL: Id '.$spid.' não encontrado!');
	return '';
}

$grupo=$_SESSION['grupo'];	
//$t=ftrace('fRegistrarAvaliacaofisica-f1.php','usuarioid='.$usuarioid.' agendaid='.$agendaid.' grupo='.$grupo);
$tab1=leagendaoperador($usuarioid, $agendaid, $grupo, $conefi);
if($tab1){
	//$t=ftrace('fRegistrarAvaliacaofisica-f1','leuagendaoperador idc='.$idc);
	$servico1=$tab1['servico'];
	$sid=$tab1['servicoid'];
	$data1=formataDataToBr($tab1['data']);
	$hora1=$tab1['horainicial'];
	$rtab=flequestionarioservico($sid); 
}	

$operacao='Ver Questionário';
if($statusservicoid<4)
$operacao='Aplicar Questionário';
$act="registrarAvaliacaofisica-f1.php?id=$agendaid&idc=$spid";
if(isset($_GET['del']) && empty($_GET['del']) == false){
	$fec=$_GET['del'];  
	if($fec=='concluir'){
		$operacao="Confirme Concluir o Questionário";
		$act=$act."&idc=$idc&del=concluir";
	}
}	
//$t=ftrace('fRegistrarAvaliacaofisica-f1.php',$act);
//die('fim');
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
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Serviço: </label>
					<p><?php echo($servico);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Status: </label>
					<p><?php echo($status);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data/Hora: </label>
					<p><?php echo($data1.' '.$hora1);?></p>
				</div>
<!--			<div class="form-group col-md-1">
					<label>Hora: </label>
					<p><?php //echo($hora1);?></p>
				</div> -->
			</div>	
			<div class="row">
				<div class="form-group col-md-12">
<?php
if($rqa->rowCount()>0){
?>
	<p>Questionário Aplicado:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Id</th>
		<th width='15%'>Questionário</th>
		<th width='15%'>Responsável</th>
		<th width='10%'>Fisioterapia</th>
		<th width='10%'>Cadastrado</th>
		<th width='10%'>Agenda</th>
		<th width='10%'>Status</th>
		<th width='10%'>Estagiário</th>
		<th width='10%'>Realizado</th>
		<th width='10%'>Assinado</th>
		<th width='10%'>Autorizado</th>
		<th width='3%'>Imp</th>
	</tr>
<?php
foreach($rqa->fetchAll() as $tab) {
		$qaid=$tab['id'];
		$titulo1=$tab['titulo'];
		$sigla1=$tab['sigla'];
		$operador1=$tab['operador'];
		$servico1=$tab['servico'];
		$dataagenda1=formataDataToBr($tab['dataagenda']);
		$tipodeagenda1=$tab['tipodeagenda'];
		$statusagenda1=$tab['statusagenda'];
		$estagiario1=$tab['estagiario'];
		$realizadoem1=formataDataToBr($tab['data']);
		$rassinatura=leassinantequestionarioaplicadoid($qaid,$conefi);
		$estagiarioassinante=' **EST**';
		$ehass=false;
		if($rassinatura){
			$estagiarioassinante=$rassinatura['estagiarioassinante'];
			$ehass=true;
		}
		$professorautorizador=' **COO**';
		$rautorizador=leautorizadorquestionarioaplicadoid($qaid,$conefi);
		$ehprf=false;
		if($rautorizador){
			$professorautorizador=$rautorizador['professorautorizador'].
			' / CREFITO:'.$rautorizador['crefito'];
			$ehprf=true;
		}

		$status1=$tab['situacao'];
		$qsid1=$tab['questionarioservico_id'];
		//$ativo1=$tab['spativo'];
		$agendaid=$tab['agenda_id'];
		$statusagenda=$tab['statusagenda_id'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=aplicar&obj=questionario&cpl=f1&id=<?php echo($qaid);?>'><?PHP echo($qaid);?></a></td>
					<td><?PHP echo($sigla1);?></td>
					<td><?PHP echo($operador1);?></td>
					<td><?PHP echo($servico1);?></td>
					<td><?PHP echo($dataagenda1);?></td>
					<td><?PHP echo($tipodeagenda1);?></td>
					<td><?PHP echo($statusagenda1);?></td>
					<td><?PHP echo($estagiario1);?></td>
					<td><?PHP echo($realizadoem1);?></td>
<?php
if($statusagenda<3){
	if($grupo == 'esa' and !$ehprf){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=assinaturaestagiario&cpl=f1&id=<?PHP echo($qaid);?>'><?PHP echo($estagiarioassinante);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($estagiarioassinante);?></td>			
<?php
	}
?>						
<?php
	if($grupo == 'coa' and $ehass and !$ehprf){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=professorautorizador&cpl=f1&id=<?PHP echo($qaid);?>'><?PHP echo($professorautorizador);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($professorautorizador);?></td>
<?php
		 }
}
?>
					<td><a href='fAplicarQuestionario-f2.php?id=<?php echo($qaid);?>' target='_blank'><?PHP echo($qaid);?></a></td>

				</tr>
<?php
}
?>
    </table> 
    <br>
<?php	
}
?>							</div>	
			</div>	
<?php	
if($statusservicoid<4){
?>	
			<div class="row">
				<div class="form-group col-md-5">
					<label>Selecione o Questionário a Aplicar:</label>
					<select name="questionarioservico_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php 
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
<?php
if(!$operacao==''){
?>			
			<div class="row">
				<div class="form-group col-md-10">
				<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
<?php
}
}
?>			
        </form>
    </div>    
</div>	