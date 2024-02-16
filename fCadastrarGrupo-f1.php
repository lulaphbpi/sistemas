<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
$grupo='';
$descricao='';

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'grupo-f1.php';

if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$_SESSION['id']=$id;
}
if($id>0){
	$operacao='Atualizar'; 
	$act=$act.'?id='.$id;
	$rtab=legrupoid_f1($id,$conefi);
	if($rtab){
		$grupo=$rtab['grupo'];
		$descricao=$rtab['descricao'];  
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado: esteja certo de não existir Grupo relacionado a outra estrutura';
			$act=$act.'&del=del';
		}	
	}	
}
$tx=trim($_SESSION['texto']);
if(empty($tx))
$tx='bb';	
//$titulo='';

// Área de PK
// $operacao='Cadastrar';
?>

<div class="areatrabalho">
    <div class="formularioEntrada">
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Novo Grupo de Usuário:</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Grupo (Sigla): </label>
					<input type="text" id="grupo" name="grupo" size="3" maxlength="5" class="form-control" value='<?php echo($grupo);?>' required>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label><br>
					<input type="text" id="descricao" name="descricao" size="30" maxlength="30" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
			<p><a href='chameFormulario.php?op=consultar&obj=grupo&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>		

	</div>
</div>	
