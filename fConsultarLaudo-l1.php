<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$nome='';

$erid='';
$contador=0;
$ritem=false;
$codbarras='';
$act='';
$v1='';
$v2='';
if(isset($_POST['codbarras']) && empty($_POST['codbarras']) == false){
	$codbarras=trim($_POST['codbarras']);
	$ritem=flecodigodebarras($codbarras,$conacl);
	//die($ritem->rowCount());
}else{
	if(isset($_GET['id']) && empty($_GET['id']) == false) {
		$ider=$_GET['id'];
		$rer=leexamerequerido($ider,$conacl);
		$idr=$rer['requisicao_id'];
		$codbarras=fnumero($idr,5).'000';
		$ritem=flecodigodebarras($codbarras,$conacl);
	}
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$rexar=lecomponentedeexame($idc,$conacl);
	if($rexar){
		$exame_id=$rexar['exame_id'];
		$sigla=$rexar['sigla'];
		$componentedeexame_id = $rexar['id'];
		$componente = $rexar['descricao'];
		$material=$rexar['material'];
		$unidade=$rexar['unidade'];
		$nvalor=$rexar['nvalor'];
		$act="registrarResultado-l1.php?id=".$ider."&idc=".$idc;

		$v1='';
		$v2='';
		if(!$ider==''){
			$rcomp=leitemexamerequerido($ider, $componentedeexame_id, $conacl);
			if($rcomp){
				$v1=$rcomp['valor1'];
				$v2=$rcomp['valor2'];
			}
		}
	}
}	
// Área de PK
//$msg="Mensagem:".$msg;
$pvez=true;
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="<?php echo($act); ?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Consulta - Código de barras</p>
			<br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Código:</label>
					<input type="text" name="codbarras" id="codbarras" size="40" maxlength="40" class="form-control" value="<?php echo($codbarras);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>
<?php
if($ritem){
?>	
			<table class="tabela1" width='70%'>
				<tr>
					<th width='5%'>Id</th>
					<th width='30%'>Descrição</th>
					<th width='10%'>Unidade</th>
					<th width='15%'>Resultado</th>
					<th width='5%'>Entrar com</th>
				</tr>
<?php
	$exameid=0; $k=0; $ks='';
	foreach($ritem->fetchAll() as $item) {
		$ider=$item['id'];
		$exame_id=$item['exame_id'];
		$exame=strtoupper($item['exame']);
		$id1=$item['componentedeexame_id'];
		$nvalor=$item['nvalor'];
		if($nvalor=='0')
		  $descricao1=' '.$item['componente'];
		else  
		  $descricao1=' - '.$item['componente'];
		$unidade1=$item['unidade'];
		$codigo1=$item['codigo'];
		$componentedeexame_id=$item['componentedeexame_id'];
		$ritemreq=leitemrequisicaoporcodigo($ider,$componentedeexame_id,$conacl);
		$valor1='';
		$valor2='';
		$vv='';
		if($ritemreq){
			//$ks.=" leu item: <br>";
			//$ks.='  leu ider:'.$ider.' componentedeexame_id:'.$componentedeexame_id.'<br>';
			if($nvalor=='0'){
			}else{	
			$valor1=$ritemreq['valor1'];
			$valor2=$ritemreq['valor2'];
			$vv=$valor1.' - '.$valor2;
			}
		}

		//$k++;
		//if($k>10) die($ks);
		//$ks.=fnumero($exame_id,3).' '.fnumero($exameid,3).'<br>';
		//$ks.=' ider:'.$ider.' compdeexameid:'.$componentedeexame_id.'<br>';
		//$ks.=' valor1:'.$valor1.' valor2:'.$valor2.'<br>';
		if($exame_id==$exameid){
			// emite apenas o componente de exame
		}else{	
			// emite antes o nome do exame
			$exameid=$exame_id;
?>
				<tr>
					<td><strong><?PHP echo($exame_id);?></strong></td>
					<td><strong><?PHP echo($exame);?></strong></td>
					<td><?PHP echo('');?></td>
					<td><?php echo('');?></td>
					<td>&nbsp;
					</td>
				</tr>
<?php			
		}
?>				
				<tr>
					<td><?PHP echo($id1);?></td>
					<td><?PHP echo($descricao1);?></td>
					<td><?PHP echo($unidade1);?></td>
					<td><?php echo($vv);?></td>
<?php
		if(!$nvalor=='0') {
?>					
					<td><a href='chameFormulario.php?op=consultar&obj=laudo&cpl=l1&id=<?PHP echo($ider);?>&idc=<?php echo($componentedeexame_id);?>'><?php echo('Resultado'); ?></a>
					</td>
<?php
		}
?>		
				</tr>
<?php
	}
	//die('  fim');
}
?>			
			</table><br>
<?php 
if(!$codbarras==''){
?>	
			<div class="row">
				<div class="form-group col-md-1">
					<label>Exame:</label>
					<input type="text" name="sigla" id="sigla" size="5" maxlength="5" class="form-control" value="<?php echo($sigla);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group col-md-3">
					<label>Componente:</label>
					<input type="text" name="componente" id="componente" size="40" maxlength="40" class="form-control" value="<?php echo($componente);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group col-md-1">
					<label>Material:</label>
					<input type="text" name="material" id="material" size="40" maxlength="40" class="form-control" value="<?php echo($material);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group col-md-2">
					<label>Valor medido 1:</label>
					<input type="text" name="valor1" id="valor1" size="20" maxlength="20" class="form-control" value="<?php echo($v1);?>"></input>
				</div>
				<div class="form-group col-md-2">
					<label>Valor medido 2:</label>
					<input type="text" name="valor2" id="valor2" size="20" maxlength="20" class="form-control" value="<?php echo($v2);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group col-md-2">
					<label>Unidade:</label>
					<input type="text" name="unidade" id="unidade" size="30" maxlength="30" class="form-control" value="<?php echo($unidade1);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>	
<?php
}
?>
			<div class="row">
	            <div class="form-group col-md-11">
				<button type="submit" class="btn btn-primary btn-block">Ok</button>
				</div>
			</div>
		</form>
		&nbsp;<a href="rmapareq01.php" target="_new"> Mapa de Exames</a><br><br>
	</div>
	</div>
</div>