<?php
include('inicio.php');
include('../include/sa000.php');
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$_SESSION['inicial']=0;

$titulo='Cadastrar Tipo de Questão';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$descricao='';
$nalternativas='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Tipoquestao-q1.php';
if($id>0){
	$titulo=$titulo.' '.$id;
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=letabelaporid('tipoquestao',$id,$conque);
	if($rtab){
		$descricao=$rtab['descricao'];
		$nalternativas=$rtab['nalternativas'];
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del == 'del'){
			$titulo='Excluir Tipo de Questão';
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
				<div class="form-group col-md-5">
					<label>Descrição: </label>
					<input type="text" id="descricao" name="descricao" size="120" maxlength="120" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-3">
					<label>Permite Opções ?</label><br>
					<label for="idnao">Não</label>
					<input type="radio" class="simnao" name="nalternativas" id="nalternativas" value="N" <?php if($nalternativas=='N'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Sim</label>
					<input type="radio" class="simnao" name="nalternativas" id="nalternativas" value="S" <?php if($nalternativas=='S'){echo("checked");} ?>>
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="form-group col-md-10">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
		<p><a href="chameFormulario.php?op=consultar&obj=tipoquestao&cpl=q1&id=<?php echo($id);?>">&nbsp;&nbsp;Consulta Anterior</a><p>
		
    </div>    
</div>	