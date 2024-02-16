<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$conefi=conexao('efisio');
$conque=conexao('questionario');

$_SESSION['time']=date("Y-m-d H:i:s");
$rotina='fDefinirQuestionario-f1.php';
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
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;
$lepresentes=$leausentes='';

$servicoid=0;
if(isset($_POST['servico_id']) && empty($_POST['servico_id']) == false){
	$servicoid=$_POST['servico_id'];
	if(isset($_POST['questionario_id']) && empty($_POST['questionario_id']) == false){
		$questionarioid=$_POST['questionario_id'];
		$qselecionado=lequestionarioselecionado($servicoid, $questionarioid);
		if($qselecionado){
			$ret=fexcluiquestionariodoservico($servicoid, $questionarioid);
		}else{
			$ret=fincluiquestionariodoservico($servicoid, $questionarioid);
		}	
	}
}	

$questionarioid=0;
$sistema=$_SESSION['sistema'];
if($servicoid>0){
	$leausentes=trim(fleausentes($sistema,$servicoid));
	$lepresentes=trim(flepresentes($servicoid));
}

// Área de PK
$pvez=true;
$tt=$_SESSION['texto'];
if(empty($tt))
	$tt=' ';
$operacao='Continuar';	
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Questionário por Serviço: </p>
			<div class="row">
				<div class="form-group col-md-11">
			<p><strong>Primeiramente selecione o Serviço e 
				clique em Continuar. Abaixo, à esquerda, 
				estarão os questionários disponíveis 
				para o serviço selecionado, e, à direita, 
				estarão os questionários já vinculados 
				à este serviço. Para vincular, selecione o Serviço, 
				selecione o Questionário, e clique em Continuar. 
			    Para desvincular, execute o mesmo procedimento, 
			    desde que o Questionário selecionado esteja
			    vinculado ao Serviço selecionado.</strong></p>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Selecione o Serviço:</label>
					<select name="servico_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php
			$tabela = 'servico';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>0){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$servicoid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],60)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>
				</div>	
				<div class="form-group col-md-6">
					<label>Selecione o Questionário p/ incluir/excluir da lista do Serviço:</label>
					<select name="questionario_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php
			$tabela = 'questionario';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conque);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>0){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$questionarioid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['titulo'],60)); ?></option>
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
				<div class="form-group col-md-11">
					<button type="submit" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button>
				</div>
			</div>	
		</form>
		<br>
		<div class="row">
			<div class="form-group col-md-5">
				<label>Questionários disponíveis:</label>
				<textarea rows="20" cols="72" style="background-color:#99ffff;color:#3300cc;height:225px">
					<?php echo($leausentes); ?>
				</textarea>
			</div>
			<div class="form-group col-md-5">
				<label>Questionários vinculados:</label>
				<textarea rows="20" cols="62" style="background-color:#99ffff;color:#3300cc;height:225px">
					<?php echo($lepresentes); ?>
				</textarea>
			</div>
		</div>
	</div>
	</div>
</div>
