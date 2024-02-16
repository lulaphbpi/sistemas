<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conefe=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
$descricao='';

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Tipodeagenda-f1.php';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$_SESSION['id']=$id;
}
if($id>0){
	$operacao='Atualizar'; 
	$act=$act.'?id='.$id;
	$rtab=letipodeagendaid_fi($id,$conefe);
	if($rtab){
		$descricao=$rtab['descricao'];  
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado: esteja certo de não existir Tipo de Agenda relacionado a outra estrutura';
			$act=$act.'&id='.$id.'&del=del';
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
			<b>Novo Tipo de Agenda:</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label><br>
					<textarea name='descricao' rows=1 cols=80><?php echo($descricao);?></textarea>
				</div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="button" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
			<p><a href='chameFormulario.php?op=consultar&obj=tipodeagenda&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>		

	</div>
</div>	
