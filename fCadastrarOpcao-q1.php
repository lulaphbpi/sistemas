<?php
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
$id_tipoopcao=0;
$enunciado='';
$descricao='';
$valor='';
$ordem=0;
$nalternativas=0;
$squest='';
$sinter='';
$permitealterar=false;
$id_questionario=0;
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Opcao-q1.php';
$idc=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$idq=$_GET['id'];
	$rq=lequestaoid_q1($idq,$conque);
	if($rq){
		$id_questionario=$rq['id_questionario'];
		if(permitealterarquestionario($id_questionario)){
			$permitealterar=true;
		}

		$squest=$rq['id_questionario'].': '.$rq['sigla'].' - '.$rq['questionariodescricao'];
		$sinter=$rq['interessado'];
		$squestao=fnumero($rq['ordem'],3).'. '.$rq['enunciado'];
	}	
	$act=$act.'?id='.$idq;
	$_SESSION['id']=$idq;
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];
if($idc>0){
	$operacao='Atualizar'; 
	$act=$act.'&idc='.$idc;
	$rtab=letabelaporid('opcao',$idc,$conque);
	if($rtab){
		$ordem=$rtab['ordem'];  
		$descricao=$rtab['descricao'];
		$valor=$rtab['valor'];
	}	
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir';
			$act=$act.'&del=del';
		}	
	}	
}
//die($act.'<br>');

?>

<div class="areatrabalho">
    <div class="formularioEntrada">
		<div id="lblerro"><?php echo($msg); ?></div><br>
		<p>Questionário <?php echo($squest);?></p>
		<p>Interessado: <?php echo($sinter);?></p>
		<p>Questão: <?php echo($squestao);?></p>
		<?php
			if($permitealterar){
		?>		
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<p>Registro de Opção:</p>
			<br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição: </label><br>
					<textarea name='descricao' rows=3 cols=75><?php echo($descricao);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Valor (numérico):</label><br>
					<input type='text' name='valor' size='5' maxlength='5' placeholder='' value='<?php echo($valor);?>' required />	
			    </div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Ordem:</label><br>
					<input type='text' name='ordem' size='5' maxlength='5' placeholder='' value='<?php echo($ordem);?>' required />	
			    </div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
		<?php
		}
		?>		

		<p><a href='chameFormulario.php?op=consultar&obj=opcao&cpl=q1&id=<?PHP echo($idq);?>'>Lista Opções</a>	</p>		
		<p><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?PHP echo($id_questionario);?>&idc=0'>Lista Questões</a>	</p>		
		<p><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&idx=<?PHP echo($id_questionario);?>'>Retorna Questionário</a>	</p>		

	</div>
</div>	
