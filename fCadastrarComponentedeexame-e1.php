<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$_SESSION['inicial']=0;

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$leexame=leexame($id,$conacl);
if($leexame){
	$siglaexame=$leexame['sigla'];
	$descricaoexame=$leexame['descricao'];
}
$descricao='';
$tipodeamostra_id=0;
$unidade='';
$referencia='';
$metodo='';
$notas='';
$nvalor='1';
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$rcomp=lecomponentedeexame($idc,$conacl);
	if($rcomp){
		$descricao=$rcomp['descricao'];
		$tipodeamostra_id=$rcomp['tipodeamostra_id'];
		$unidade=$rcomp['unidade'];
		$referencia=$rcomp['referencia'];
		$metodo=$rcomp['metodo'];
		$notas=$rcomp['notas'];
		$nvalor=$rcomp['nvalor'];
	}
}	
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Componentedeexame-e1.php';
if($id>0){
	$act=$act.'?id='.$id;
	if($idc>0){
		$operacao='Atualizar';
		$act=$act.'&idc='.$idc;
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del == 'S'){
			$_SESSION['exameid']=$id;
			$titulo='Excluir Componente';
			$operacao='Clique para Excluir';
			$act='excluirComponente-e1.php?id='.$idc;
		}
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
					<th width='40%'>Descrição</th>
					<th width='20%'>Unidade</th>
					<th width='5%'>N Valor</th>
				</tr>
<?php
foreach($rtab->fetchAll() as $tab) {
		$id1=$tab['id'];
		$descricao1=$tab['descricao'];
		$unidade1=$tab['unidade'];
		$nvalor1=$tab['nvalor'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=cadastrar&obj=
componentedeexame&cpl=e1&id=<?PHP echo($id);?>&idc=<?PHP echo($id1);?>'><?PHP echo($id1);?></td>
					<td><?PHP echo($descricao1);?></td>
					<td><?PHP echo($unidade1);?></td>
					<td><?PHP echo($nvalor1);?></td>
					<td><a href='chameFormulario.php?op=cadastrar&obj=
componentedeexame&cpl=e1&id=<?PHP echo($id);?>&idc=<?PHP echo($id1);?>&del=S'>Del</a></td>
					
				</tr>
<?php
}
?>			
			</table>
			<br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição do componente: </label>
					<input type="text" id="descricao" name="descricao" size="50" maxlength="50" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label> Unidade: </label>
					<input type="text" id="unidade" name="unidade" size="20" maxlength="20" class="form-control" value='<?php echo($unidade);?>' required>
				</div>
				<div class="form-group col-md-1">
					<label> N Valor: </label>
					<input type="text" id="nvalor" name="nvalor" size="50" maxlength="50" class="form-control" value='<?php echo($nvalor);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label> Método: </label>
					<input type="text" id="metodo" name="metodo" size="50" maxlength="50" class="form-control" value='<?php echo($metodo);?>' required>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Valores de Referência: </label>
					<textarea name="referencia" rows=2 cols=100 class="form-control"> <?php echo($referencia);?>
					</textarea>
				</div>
				<div class="form-group col-md-5">
					<label>Notas: </label>
					<textarea name="notas" rows=2 cols=100 class="form-control"> <?php echo($notas);?>
					</textarea>
				</div>
			</div>
				
			<br>	
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
		<p><a href="chameFormulario.php?op=consultar&obj=exame&cpl=e1&id=<?php echo($id);?>">&nbsp;&nbsp;Consulta Anterior</a><p>
	</div>    
</div>	

