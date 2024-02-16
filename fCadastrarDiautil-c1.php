<?php
include('inicio.php');
include('../include/sa000.php');
$connae=conexao('consnae');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$_SESSION['inicial']=0;

$titulo='Cadastrar Dia Útil';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$diautil='';
$turno_id=0;
$statusdiautil_id=0;
$descricao='';
$limites='';
$confirmados='';
$efetivados='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'diautil-c1.php';
if($id>0){
	$titulo=$titulo.' '.$id;
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=letabelaporid('diautil',$id,$connae);
	if($rtab){
		$diautil = $rtab['dia'];
		$turno_id = $rtab['turno_id'];
		$statusdiautil_id = $rtab['statusdiautil_id'];
		$descricao = $rtab['descricao'];
		$limite = $rtab['limite'];
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del == 'del'){
			$titulo='Excluir Dia Útil';
			$operacao='Clique para Excluir';
			$act=$act.'&del=del';
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
					<label>Dia:</label>
					<input type="date" id="diautil" name="diautil" size="10" maxlength="10" class="form-control" value='<?php echo($diautil);?>' >
				</div>
				<div class="form-group col-md-2">
					<label>Turno:</label>
					<select name="turno_id" class="form-control"> 
						<option value="" selected="selected"></option>
<?php
			$tabela = 'turno';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$connae);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$turno_id){echo("selected='selected'");} ?>> <?php echo($tab['descricao']); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Status</label>
					<select name="statusdiautil_id" class="form-control"> 
						<option value="" selected="selected"></option>
<?php
			$tabela = 'statusdiautil';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$connae);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$statusdiautil_id){echo("selected='selected'");} ?>> <?php echo($tab['descricao']); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-6">
					<label>Descrição: </label>
					<input type="text" id="descricao" name="descricao" size="120" maxlength="120" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-2">
					<label>Limite de Consultas: </label>
					<input type="text" id="limite" name="limite" size="2" maxlength="2" class="form-control" value='<?php echo($limite);?>' required>
				</div>
<!--			<div class="form-group col-md-2">
					<label>Consultas Confirmadas: </label>
					<input type="text" id="confirmados" name="confirmados" size="2" maxlength="2" class="form-control" value='<?php echo($confirmados);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>Consultas Realizadas: </label>
					<input type="text" id="efetivados" name="efetivados" size="2" maxlength="2" class="form-control" value='<?php echo($efetivados);?>' required>
				</div>
-->			</div>	
			<br>
			<div class="row">
				<div class="form-group col-md-6">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
		<p><a href="chameFormulario.php?op=consultar&obj=diautil&cpl=c1&id=<?php echo($id);?>">&nbsp;&nbsp;Consulta Anterior</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=diautil&cpl=c1"><?PHP echo('Cadastrar Dia Útil');?></a></p>	
		
    </div>    
</div>	