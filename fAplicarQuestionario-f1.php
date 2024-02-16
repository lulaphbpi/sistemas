<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);
$conque=conexao('questionario');

$rotina='fAplicarQuestionario-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

//$questionarioservicoid=0;

$spid=0; $agendaid=0; $qaid=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$qaid=$_GET['id'];  // questionarioaplicadoid

$recqa=lequestionarioaplicadoid($qaid,$conefi);
$agendaid=$recqa['agenda_id'];

$_SESSION['agendaid']=$agendaid;	
//$idc=$spid;

$ragenda=leagenda_fi($agendaid,$conefi);
if($ragenda){
	$spid=$ragenda['servicopessoa_id'];
	$_SESSION['spid']=$spid;
}

//$spid=$_SESSION['spid'];
$statusservicoid=0;
$qsid=0;
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

	$rqa=flequestionarioaplicado($agendaid);
	$rrqa=$rqa->fetch();
	$qsid=$rrqa['questionarioservico_id'];

	//$rquestao=flequestao($qid);
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}

$rqs=lequestionarioservico($qsid);
$qid=$rqs['questionario_id'];
$rquestao=flequestao($qid);
$ss='';
foreach($rquestao->fetchAll() as $recq){
	$ord=$recq['ordem'];
	$tpq=$recq['id_tipoquestao'];
	if($tpq==1){
	$campo="q".fnumero($ord,3); $$campo='';}
	else
	if($tpq==2){
	$campo="q".fnumero($ord,3); $$campo='N';}
	else
	if($tpq==3){
	$campo="q".fnumero($ord,3); $$campo='';}
	else{
		$campo="q".fnumero($ord,3); $$campo='';}
	
	$ss=$ss.'ord='.$ord.' campo='.$campo.';'.chr(13);
}
$t=ftrace('fAplicarQuestionario-f1.php',$ss);

$tab1=leagendaoperador2($agendaid, 1, $conefi);
if($tab1){
	$servico1=$tab1['servico'];
	$sid=$tab1['servicoid'];
	$data1=formataDataToBr($tab1['data']);
	$hora1=$tab1['horainicial'];
}	

$rqa1=lequestionarioaplicadoheader($qsid, $agendaid);
if($rqa1->rowCount()>0){
	$recrqa=$rqa1->fetch();
	$idrqa=$recrqa['id'];
	$rqa=lequestionarioaplicado($idrqa);
	//$t=ftrace('fAplicarQuestionario-f1.php','cpo:'.$cpo.'  ddcpo:'.$$cpo);	
	if($rqa->rowCount()>0){
		foreach($rqa->fetchAll() as $recqa){
			$cpo=$recqa['campo'];
			$$cpo=$recqa['valor'];
		}		
	}
}	

$rqs=lequestionarioservico($qsid);
$qid=$rqs['questionario_id'];
$rq=lequestionario($qid);
$titulo=$rq['titulo'];
$rquestao=flequestao($qid);
$operacao="Aplicar Questionário";
if(!($statusservicoid<4))
$operacao='Ver Questionário';
$act="aplicarQuestionario-f1.php?id=$qsid";
$t=ftrace('fAplicarQuestionario-f1.php','act='.$act);
?>

<div class="areatrabalho">
    <div class="formularioEntrada">
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario" target="_self">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<div class="row">
				<div class="form-group col-md-1">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Serviço: </label>
					<p><?php echo($servico1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Status: </label>
					<p><?php echo($status);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Data: </label>
					<p><?php echo($data1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Hora: </label>
					<p><?php echo($hora1);?></p>
				</div>
			</div>	
			
			<p><b>APLICAÇÃO DO QUESTIONÁRIO <?php echo($qid);?></b></p>
			<p><b>Título : <?php echo($titulo);?></b></p>
			<br>
<?php 
foreach($rquestao->fetchAll() as $recq){
	$ord=$recq['ordem'];
	$tpq=$recq['id_tipoquestao'];
?>
			<div class="row">
				<div class="form-group col-md-5">
<?php 
if($tpq==5){
?>
					<label><?php echo($recq['enunciado']);?></label> 
<?php
}else{
?>	
					<label><?php echo($recq['ordemf']);?>. <?php echo($recq['enunciado']);?></label> 
<?php 
}
if($tpq==1){
	$campo="q".fnumero($ord,3); //$$campo='';
?>			
					<br>&nbsp;&nbsp;&nbsp; <textarea name='<?php echo($campo);?>' rows="3" cols="70" ><?php echo($$campo);?></textarea>
<?php 
}else{
if($tpq==2){
	$campo="q".fnumero($ord,3);
?>
					<br>
					<label for="idnao">&nbsp;&nbsp;&nbsp;&nbsp;Não</label>
					<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="N" <?php if($$campo=='N'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Sim</label>
					<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="S" <?php if($$campo=='S'){echo("checked");} ?>>
<?php					
}else{
if($tpq==3){
	$idquestao=$recq['id'];
	$campo="q".fnumero($ord,3); //$$campo='';
	$ropcao=fleopcao($idquestao);
	if($ropcao->rowCount()>0){
		foreach($ropcao->fetchAll() as $ropc){
			$nopcao=$ropc['descricao'];
			$valor=$ropc['valor'];
?>
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="<?php echo($valor);?>" <?php if($$campo==$valor){echo("checked");} ?>>&nbsp;&nbsp;
					<label for="<?php echo($nopcao); ?>">(<?php echo(fnumero($ropc['ordem'],2));?>) <?php echo($nopcao); ?></label>
<?php
		}
    }
}else{
	$idquestao=$recq['id'];
	$campo="q".fnumero($ord,3);
	$ropcao=fleopcao($idquestao);
	if($ropcao->rowCount()>0){
		foreach($ropcao->fetchAll() as $ropc){
			$nopcao=$ropc['descricao'];
			$valor=$ropc['valor'];
			$ordop=fnumero($ropc['ordem'],3);
			$cpo=$campo.$ordop; //echo($$cpo.' - '.$cpo.'<br>');
?>	
					<br>
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="<?php echo($cpo);?>" name="<?php echo($cpo);?>" <?php if(!empty($$cpo)) echo('checked');?>>
					<label for="<?php echo($cpo);?>"> <?php echo($nopcao);?></label>	
<?php
		}
	}	
	//die('fim');
}	
}
}
?>
				</div>
			</div>
<?php 
}
?>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
<!--		<p><a href='chameFormulario.php?op=consultar&obj=tipodeagenda&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>
-->		
	</div>
</div>	
