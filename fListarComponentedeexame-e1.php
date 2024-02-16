<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$leexame=leexame($id,$conacl);
if($leexame){
	$siglaexame=$leexame['sigla'];
	$descricaoexame=$leexame['descricao'];
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$id=$_GET['idc'];
$descricao='';
$unidade='';
$valrefhi=0;
$valrefhf=0;
$valrefmi=0;
$valrefmf=0;
$observacoes='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Componentedeexame-e1.php';
if($id>0){
	$act=$act.'?id='.$id;
	if($idc>0){
		$operacao='Atualizar';
		$act=$act.'&idc='.$idc;
	}	
	$rtab=flecomponentedeexame($id,$conacl);
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Componente de Exame</b>
			<br><br>
			Exame: <?php echo($siglaexame.' '.$descricaoexame)?>
			<br>
			<table class="tabela1">
				<tr>
					<th width='5%'>Id</th>
					<th width='20%'>Descrição</th>
					<th width='20%'>Unidade</th>
					<th width='20%'>Min Hom</th>
					<th width='20%'>Max Hom</th>
					<th width='20%'>Min Mul</th>
					<th width='20%'>Max Mul</th>
				</tr>
<?php
foreach($rtab->fetchAll() as $tab) {
		$descricao=$tab['descricao'];
		$unidade=$tab['unidade'];
		$valrefhi=$tab['valrefhi'];
		$valrefhf=$tab['valrefhf'];
		$valrefmi=$tab['valrefmi'];
		$valrefmf=$tab['valrefmf'];
?>				
				<tr>
					<td><?PHP echo($descricao);?></td>
					<td><?PHP echo($unidade);?></td>
					<td><?PHP echo($valrefhi);?></td>
					<td><?PHP echo($valrefhf);?></td>
					<td><?PHP echo($valrefmi);?></td>
					<td><?PHP echo($valrefmf);?></td>
				</tr>
<?php
}
?>			
			</table>
			<br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label>
					<input type="text" id="descricao" name="descricao" size="30" maxlength="30" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
				<div class="form-group col-md-1">
					<label> Unidade: </label>
					<input type="text" id="unpeso" name="unpeso" size="5" maxlength="5" class="form-control" value='<?php echo($unpeso);?>' required>
				</div>
			</div>
			Valores de Referência<br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Homem, &nbsp;&nbsp;&nbsp;de: </label>
					<input type="text" id="valrefhi" name="valrefhi" size="5" maxlength="5" class="form-control" value='<?php echo($valrefhi);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label> a: </label>
					<input type="text" id="valrefhf" name="valrefhf" size="5" maxlength="5" class="form-control" value='<?php echo($valrefhf);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>Mulher, &nbsp;&nbsp;&nbsp;de: </label>
					<input type="text" id="valrefmi" name="valrefmi" size="5" maxlength="5" class="form-control" value='<?php echo($valrefmi);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label> a: </label>
					<input type="text" id="valrefmf" name="valrefmf" size="5" maxlength="5" class="form-control" value='<?php echo($valrefmf);?>' required>
				</div>
			</div>
				
			<br>	
			<div class="row">
				<div class="form-group col-md-3">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>	

