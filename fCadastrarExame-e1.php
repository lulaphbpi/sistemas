<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$_SESSION['inicial']=0;

$titulo='Cadastrar Exame';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$sigla='';
$descricao='';
$tipodeamostra_id=0;
$observacao='';
$setor_id=0;
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Exame-e1.php';
if($id>0){
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=leexame($id,$conacl);
	if($rtab){
		$sigla=$rtab['sigla'];
		$descricao=$rtab['descricao'];
		$tipodeamostra_id=$rtab['tipodeamostra_id'];
		$material=$rtab['material'];
		$observacao=$rtab['observacao'];
		$setor_id=$rtab['setor_id'];
	}
	if(isset($_GET['idc']) && empty($_GET['idc']) == false){
		$idc=$_GET['idc'];
		if($idc == 'S'){
			$titulo='Excluir Exame';
			$operacao='Clique para Excluir';
			$act='excluirExame-e1.php?id='.$id;
		}
	}	
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b><?php echo($titulo);?></b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Sigla: </label>
					<input type="text" id="sigla" name="sigla" size="5" maxlength="5" class="form-control" value='<?php echo($sigla);?>' required>
				</div>
				<div class="form-group col-md-5">
					<label>Descrição: </label>
					<input type="text" id="descricao" name="descricao" size="120" maxlength="120" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label>Tipo de Amostra:</label>
					<select name="tipodeamostra_id" class="form-control">
					<option value="" selected="selected"></option>
<?php
			$tabela = 'tipodeamostra';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
					<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodeamostra_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],20)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-8">
					<label>Observações: </label>
					<input type="text" id="observacao" name="observacao" size="120" maxlength="120" class="form-control" value='<?php echo($observacao);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>Setor:</label>
					<select name="setor_id" class="form-control">
					<option value="" selected="selected"></option>
<?php
			$tabela = 'setor';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
					<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$setor_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],20)); ?></option>
<?php
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
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
		<p><a href="chameFormulario.php?op=consultar&obj=exame&cpl=e1&id=<?php echo($id);?>">&nbsp;&nbsp;Consulta Anterior</a><p>
		
    </div>    
</div>	

