<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
$descricao='';
$sigla='';

$operacao=$_SESSION['operacao'];

//$act='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id='.$idq;

$act=lcfirst($operacao).'Servico-f1.php';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$_SESSION['id']=$id;
}
if($id>0){
	$operacao='Atualizar'; 
	$act=$act.'?id='.$id;
	$rtab=leservicoid_fi($id,$conefi);
	if($rtab){
		$descricao=$rtab['descricao'];  
		$sigla=$rtab['sigla'];  
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado: esteja certo de não existir serviço relacionado a outra estrutura';
			$act=$act.'&id='.$id.'&del=del';
		}	
	}	
}
$tx=trim($_SESSION['texto']);
if(empty($tx))
$tx='bb';	
//die($act);
//$titulo='';

// Área de PK
// $operacao='Cadastrar';
?>

<div class="areatrabalho">
    <div class="formularioEntrada">
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Novo Serviço:</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label><br>
					<textarea name='descricao' rows=1 cols=80><?php echo($descricao);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Sigla: </label><br>
					<textarea name='sigla' rows=1 cols=8><?php echo($sigla);?></textarea>
				</div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
			<p><a href='chameFormulario.php?op=consultar&obj=servico&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>		

	</div>
</div>	
