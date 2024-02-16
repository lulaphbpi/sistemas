<?php
if(!isset($_SESSION)) {session_start();}

include("include/finc.php");
$conque=conexao('questionario');

$rotina='fVisualizarQuestionario-q1.php';
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

<div class="areatrabalho">
    <div class="formularioEntrada">
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario" target="_self">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			
			<p><b>VISUALIZAÇÃO DO QUESTIONÁRIO No <?php echo($idq);?></b></p>
			<p><b>Título : <?php echo($titulo);?></b></p>
			<br>
<?php 
foreach($rquestao->fetchAll() as $recq){
	$ord=$recq['ordem'];
	$tpq=$recq['id_tipoquestao'];
?>
			<div class="row">
				<div class="form-group col-md-8">
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
		if($lent<11){
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
			<br>	
			<div class="row">
				<div class="form-group col-md-7">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
	</div>
</div>	
