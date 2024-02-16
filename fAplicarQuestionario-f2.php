<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);
$conque=conexao('questionario');

$rotina='fAplicarQuestionario-f2.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$iid=$_SESSION['identificacao'].' uid:'.$_SESSION['usuarioid'].' pid:'.$_SESSION['pessoaid'];
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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="www.rededesistemas.com.br - Luiz de Brito" />
    <meta name="description" content="Desenvolvimento de Sites Dinamicos de diversas naturezas" />
    <meta name="keywords" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade, Biblioteca, Sistema Academico" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><meta property="og:image" content=""/>
    <meta property="og:title" content="" />
    <meta property="og:description" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade" />
    <meta property="og:site_name" content="efisio :: Escola Clínica de Fisioterapia - efisio - UFDPar " />
    <meta name="City" content="Parnaíba-PI">
	
<!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
-->
    <link href="css/custom2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilo1.css" />
    <link rel="stylesheet" type="text/css" href="css/estilo2.css" />
	<script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/validator.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/bootstrap-combobox.js"></script>
	
    <script type="text/javascript" src="js/js1.js"></script>
    <title>efisio-UFDPAR</title>
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body data-spy="scroll">
    <div class="tudo">

<div class="areatrabalho">
    <div class="formularioEntrada">
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
			</div>	
			<div class="row">
				<div class="form-group col-md-6">
					<p><?php echo($iid);?></p>
				</div>
			</div>		
			<div class="row">
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
				<div class="form-group col-md-6">
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
	$tcpo=strlen($$campo);
	$nlcpo=intdiv($tcpo, 80)+2;
?>			
					<br>&nbsp;&nbsp;&nbsp; <textarea name='<?php echo($campo);?>' rows="<?php echo($nlcpo); ?>" cols="80" ><?php echo($$campo);?></textarea>
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
	$ropcaot=flemaxlenopcao($idquestao);
	$rropcaot=$ropcaot->fetch();
	$lent=$rropcaot['t'];
	if($ropcao->rowCount()>0){
		if($lent<12){
			?>
				<br>
			<?php
		foreach($ropcao->fetchAll() as $ropc){
			$nopcao=$ropc['descricao'];
			$valor=$ropc['valor'];
?>
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="<?php echo($valor);?>" <?php if($$campo==$valor){echo("checked");} ?>>&nbsp;&nbsp;
					<label for="<?php echo($nopcao); ?>">(<?php echo(fnumero($ropc['ordem'],2));?>) <?php echo($nopcao); ?></label>
<?php
		}
	}else{
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
<!--		<p><a href='chameFormulario.php?op=consultar&obj=tipodeagenda&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>
-->		
	</div>
</div>	
