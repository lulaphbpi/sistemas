<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$pid=0; $idc=0;
$matricula='';
$alcunha='';

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pid=$_GET['id'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

//$trace=ftrace('fCadastrarCoordenador-f1.php', 'pid='.$pid.' idc='.$idc);

$servicoid=0;

$rtab=fletabela('servico','id',$conefi); 
	
//$nome='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Coordenador-f1.php?id='.$pid;
if($idc>0){
	$operacao='Atualizar';
	$rest=lecoordenador_fi($idc,$conefi);
	if($rest){
		$pid=$rest['pessoa_id'];
		//echo ('<br>pid='.$pid);
	}
	$act='cadastrarCoordenador-f1.php?id='.$pid.'&idc='.$idc;
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir';
			$act=$act.'&del=del';
		}	
	}	
}

$lepessoa=lepessoafisicaporid($pid, $conpes);
if($lepessoa){
	$nome=$lepessoa['nome'];
	//echo ('<br>nome='.$nome);
}else{
	$_SESSION['msg']='Situação Inesperada ! (fCadastrarCoordenador-m1.php)';
	return;
}

$leCoordenador=leCoordenadorporpessoaid_fi($pid,$conefi);
if($leCoordenador){
	$idc=$leCoordenador['id'];
	//echo ('<br>idc='.$idc);

	//$servicoid=$leCoordenador['servico_id'];
}
//echo ('<br>act='.$act);

//$trace=ftrace('fCadastrarCoordenador-f1.php', $act);
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Cadastrar Coordenador</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Nome:</label>
					<input type="text" id="nome" name="nome" size="50" maxlength="50" class="form-control" value='<?php echo($nome);?>' required>
					<input type="hidden" id="id" name="id" size="5" maxlength="5" class="form-control" value='<?php echo($idc);?>' required>
				</div>
			</div>	
			<!--
			<div class="row">
				<div class="form-group col-md-6">
					<label>Serviço/Área:</label>
					<select name="servico_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php 
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>0){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$servicoid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],80)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>
				</div>
			</div>	
			-->	
			<br>	
			<div class="row">
				<div class="form-group col-md-6">
				<button type="submit" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>	

