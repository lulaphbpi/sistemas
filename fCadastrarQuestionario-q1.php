<?php
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
$sigla='';
$titulo='';
$descricao='';
$interessado='';
$nquestoes='';

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Questionario-q1.php';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
	$_SESSION['id']=$id;
}
if($id>0){
	$operacao='Atualizar'; 
	$act=$act.'?id='.$id;
	$rtab=lequestionarioid_q1($id,$conque);
	if($rtab){
		$sigla=$rtab['sigla'];  
		$titulo=$rtab['titulo'];
		$descricao=$rtab['descricao'];  
		$interessado=$rtab['interessado'];
		$nquestoes=$rtab['nroquestoes'];
		$status='';
		$st = $rtab['status'];
		if($st=='F') $status=" - Este Questionário NÃO está aberto para alterações";
	
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado: esteja certo de não existir conteúdo (questões) neste questionário';
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
			<?php
			if($id>0){
			?>
			Questionário No <?php echo($id); ?><b style="color:red"><?php echo($status);?></b> 
			<i><a href='copiaQuestionario.php?id=<?PHP echo($id);?>'>Clique aqui para fazer uma cópia </a></i>
			<?php
			}else{
			?>
			<b>Novo Questionário:</b>
			<?php
			}
			?>
			<br><br>
			<div class="row">
				<div class="form-group col-md-1">
					<label>Sigla: </label>
					<input type='text' name='sigla' size='20' maxlength='20' placeholder='' value='<?php echo($sigla);?>' required />	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Título: </label><br>
					<input type='text' name='titulo' size='70' maxlength='70' placeholder='' value='<?php echo($titulo);?>' required />	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label><br>
					<textarea name='descricao' rows=3 cols=75><?php echo($descricao);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Interessado: </label><br>
					<textarea name='interessado' rows=3 cols=75><?php echo($interessado);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Número de questões:</label><br>
					<input type='text' name='nquestoes' size='5' maxlength='5' placeholder='' value='<?php echo($nquestoes);?>' required />	
			    </div>
			</div>
			<br>	
			<?php
			if($id>0){
			if(permitealterarquestionario($id)){
			?>
			<p><a href='fFecharQuestionario-q1.php?id=<?PHP echo($id);?>'>Fechar Questionário</a>	</p>		
			<div class="row">
				<div class="form-group col-md-8">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	

			<?php
			}
			}else{
			?>	
			<div class="row">
				<div class="form-group col-md-8">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
			<?php
			}	
			?>
		</form>
<?php
if($id>0){
?>	
			<p><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?PHP echo($id);?>&idc=0'>Lista Questões</a>	</p>		
<?php
}
?>	
			<p><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>		

	</div>
</div>	
