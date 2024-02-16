<?php
include('inicio.php');
include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$idc=0;
$id_tipoquestao=0;
$enunciado='';
$ordem=0;
$nalternativas=0;
$squest='';
$sinter='';
$permiteopcoes='';

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Questao-q1.php';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$idq=$_GET['id'];
	$act=$act.'?id='.$idq;
	$rq=lequestionarioid_q1($idq,$conque);
	if($rq){
		$squest=$rq['id'].': '.$rq['sigla'].' - '.$rq['descricao'];
		$sinter=$rq['interessado'];
	}	
	$_SESSION['id']=$idq;
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];
if($idc>0){
	$operacao='Atualizar'; 
	$act=$act.'&idc='.$idc;
	$rtab=letabelaporid('questao',$idc,$conque);
	if($rtab){
		$id_tipoquestao=$rtab['id_tipoquestao'];  
		$enunciado=$rtab['enunciado'];
		$ordem=$rtab['ordem'];
		$nalternativas=$rtab['nalternativas'];
		$rtq=letabelaporid('tipoquestao',$id_tipoquestao,$conque);
		$permiteopcoes=$rtq['nalternativas'];
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
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Questionário <?php echo($squest);?></p>
			<p>Interessado: <?php echo($sinter);?></p>
			<p>Cadastro de Questão</p>
			<br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Tipo de Questão:</label>
					<select name="id_tipoquestao" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'tipoquestao';
			$ordemc = 'descricao';
			$rtab=fletabela($tabela,$ordemc,$conque);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$id_tipoquestao){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],50)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Enunciado: </label><br>
					<textarea name='enunciado' rows=3 cols=75><?php echo($enunciado);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Órdem:</label><br>
					<input type='text' name='ordem' size='5' maxlength='5' placeholder='' value='<?php echo($ordem);?>' required />	
			    </div>
			</div>
<?php
if($permiteopcoes=='S'){
?>			<div class="row">
				<div class="form-group col-md-2">
					<label>Número de Opções:</label><br>
					<input type='text' name='nalternativas' size='2' maxlength='2' placeholder='' value='<?php echo($nalternativas);?>' required />	
			    </div>
			</div>
<?php
}
?>	
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
<?php
if($idc>0)
if($permiteopcoes=='S'){
?>	
			<p><a href='chameFormulario.php?op=consultar&obj=opcao&cpl=q1&id=<?PHP echo($idc);?>'>Lista Opções</a>	</p>		
<?php
}
?>	
<?php
if($idq>0){
?>	
			<p><a href='chameFormulario.php?op=consultar&obj=questao&cpl=q1&id=<?PHP echo($idq);?>&idc=0'>Lista Questões</a>	</p>		
<?php
}
?>	
			<p><a href='chameFormulario.php?op=consultar&obj=questionario&cpl=q1&idx=<?PHP echo($tx);?>'>Retorna Questionário</a>	</p>		

	</div>
</div>	
