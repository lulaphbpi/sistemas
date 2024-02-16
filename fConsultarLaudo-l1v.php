<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$nome='';

$icb='';
$contador=0;
$ritem=false;
if(isset($_POST['codbarras']) && empty($_POST['codbarras']) == false){
	$codbarras=trim($_POST['codbarras']);
	$ritem=flecodigodebarras($codbarras,$conacl);
	//die($ritem->rowCount());
}else{
	if(isset($_GET['idc']) && empty($_GET['idc']) == false) {
		$icb=$_GET['idc'];
		$codbarras=$icb;
		$ritem=flecodigodebarras($icb,$conacl);
	}
}
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$rexar=lecomponentedeexame($id,$conacl);
	if($rexar){
		$exame_id=$rexar['exame_id'];
		$sigla=$rexar['sigla'];
		$componentedeexame_id = $rexar['id'];
		$componente = $rexar['descricao'];
		$material=$rexar['material'];
		$unidade=$rexar['unidade'];
		$valor='';
		$laudo='';
		$observacoes='';
		if(!$icb==''){
			$rcomp=leitemexamerequerido($ider, $componentedeexame_id, $conacl);
			if($rcomp){
				$valor=$comp['valor'];
				$laudo=$comp['laudo'];
				$observacoes=$comp['observacoes'];
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
        <form action="" method="post" id="iformulario" class="formulario">
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
	foreach($ritem->fetchAll() as $item) {
		$id1=$item['componentedeexame_id'];
		$requisicaoid=$item['requisicao_id'];
		$descricao1=$item['componente'];
		$unidade1=$item['unidade'];
		$codigo1=$item['codigo'];
		$componentedeexame_id=$item['componentedeexame_id'];
		$ritemreq=leitemrequisicaoporcodigo($requisicaoid,$id1,$conacl);
		$valor1='';
		if($ritemreq){
			$valor1=$ritemreq['valor'];
			$laudo1=$ritemreq['laudo'];
			$observacoes1=$ritemreq['observacoes'];
		}
?>				
				<tr>
					<td><?PHP echo($id1);?></td>
					<td><?PHP echo($descricao1);?></td>
					<td><?PHP echo($unidade1);?></td>
					<td><?php echo($valor1);?></td>
					<td><a href='chameFormulario.php?op=consultar&obj=laudo&cpl=l1&id=<?PHP echo($componentedeexame_id);?>&idc=<?php echo($codigo1);?>'><?php echo('Resultado'); ?></a>
					</td>
				</tr>
<?php
	}
}
?>			
			</table><br>
<?php 
if(!$icb==''){
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
				<div class="form-group col-md-3">
					<label>Valor medido:</label>
					<input type="text" name="valor" id="valor" size="30" maxlength="30" class="form-control" value="<?php echo($valor);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group col-md-2">
					<label>Unidade:</label>
					<input type="text" name="unidade" id="unidade" size="30" maxlength="30" class="form-control" value="<?php echo($unidade);?>"></input>
					<div class="help-block with-errors"></div>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-5">
					<label>Laudo: </label>
					<textarea name="laudo" rows=2 cols=30 class="form-control"> <?php echo($laudo);?>
					</textarea>
				</div>
				<div class="form-group col-md-5">
					<label>Observações: </label>
					<textarea name="observacoes" rows=2 cols=30 class="form-control"> <?php echo($observacoes);?>
					</textarea>
				</div>
			</div>	
<?php
}
?>
			<div class="row">
	            <div class="form-group col-md-10">
				<button type="submit" class="btn btn-primary btn-block">Ok</button>
				</div>
			</div>
		</form>
		&nbsp;&nbsp;&nbsp;<a href="rmapareq01.php" target="_new"> Mapa de Exames</a>
	</div>
	</div>
</div>