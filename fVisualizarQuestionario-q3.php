<?php
if(!isset($_SESSION)) {session_start();}

include("include/finc.php");
$conque=conexao('questionario');

$rotina='fVisualizarQuestionario-q3.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$operacao='Ok';
$act='?';
if(isset($_GET['idx']) && empty($_GET['idx']) == false){
	$idq=$_GET['idx'];
    $rq=lequestionario($idq);
    $titulo=$rq['titulo'];
    $rquestao=flequestao($idq);
    $operacao="Voltar";
	$act='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id='.$idq;
}    
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
			
			<p><b>QUESTIONÁRIO No <?php echo($idq);?></b></p>
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
					<label>(<?php echo($recq['ordem']);?>) <?php echo($recq['enunciado']);?></label> 
<?php
}else{
?>	
					<label><?php echo($recq['ordem']);?>. <?php echo($recq['enunciado']);?></label> 
<?php 
}
if($tpq==1){
	$campo="q".fnumero($ord,3); //$$campo='';
?>			
					<br>&nbsp;&nbsp;&nbsp; <textarea name='<?php echo($campo);?>' rows="3" cols="70" ><?php echo('');?></textarea>
<?php 
}else{
if($tpq==2){
	$campo="q".fnumero($ord,3);
?>
					<br>
					<label for="idnao">&nbsp;&nbsp;&nbsp;&nbsp;Não</label>
					<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="N" <?php if(false){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Sim</label>
					<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="S" <?php if(false){echo("checked");} ?>>
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
		if($lent<5){
		?>
			<br>
		<?php
		foreach($ropcao->fetchAll() as $ropc){
			$nopcao=$ropc['descricao'];
			$valor=$ropc['valor'];
		?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="<?php echo($valor);?>" <?php if(false){echo("checked");} ?>>&nbsp;&nbsp;
					<label for="<?php echo($nopcao); ?>"><?php echo($nopcao); ?></label>
		<?php
		}
		}else{
		foreach($ropcao->fetchAll() as $ropc){
			$nopcao=$ropc['descricao'];
			$valor=$ropc['valor'];
?>
					<br>
<!--					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="<?php echo($valor);?>" <?php if(false){echo("checked");} ?>>&nbsp;&nbsp;
					<label for="<?php echo($nopcao); ?>">(<?php echo(fnumero($ropc['ordem'],2));?>) <?php echo($nopcao); ?></label>  -->
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="simnao" name="<?php echo($campo);?>" id="<?php echo($campo);?>" value="<?php echo($valor);?>" <?php if(false){echo("checked");} ?>>&nbsp;&nbsp;
					<label for="<?php echo($nopcao); ?>"><?php echo($nopcao); ?></label>
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
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="<?php echo($cpo);?>" name="<?php echo($cpo);?>" <?php if(false) echo('checked');?>>
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
			<h3>_______________________________________________</h3>	
	</div>
</div>	
</div>
</div>