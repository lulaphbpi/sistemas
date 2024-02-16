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

//$trace=ftrace('fCadastrarEstagiario-f1.php', 'pid='.$pid.' idc='.$idc);

//$servicoid=0;

$rtab=fletabela('servico','id',$conefi); 
	
//$nome='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Estagiario-f1.php?id='.$pid;
if($idc>0){
	$operacao='Atualizar';
	$act=$act.'&idc='.$idc;
	$rest=leEstagiario_fi($idc,$conefi);
	if($rest){
		$pid=$rest['pessoa_id'];
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado! Esteja certo da integridade relacional';
			$act=$act.'&del=del';
		}	
		if($del=='des'){
			$operacao='Desativar Estagiário';
			$act=$act.'&del=des';
		}	
		if($del=='ati'){
			$operacao='Ativar Estagiário';
			$act=$act.'&del=ati';
		}	
		if($del=='atz'){
			//$operacao='Ativar Estagiário';
			$act=$act.'&del=atz';
		}	
	}	
}

$lepessoa=lepessoafisicaporid($pid, $conpes);
if($lepessoa){
	$nome=$lepessoa['nome'];
}else{
	$_SESSION['msg']='Situação Inesperada ! (fCadastrarEstagiario-m1.php)';
	return;
}

$leEstagiario=leEstagiarioporpessoaid_fi($pid,$conefi);
if($leEstagiario){
	$idc=$leEstagiario['id'];
	$matricula=$leEstagiario['matricula'];
//	$servicoid=$leEstagiario['servico_id'];
}

//$trace=ftrace('fCadastrarEstagiario-f1.php', $act);
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Cadastrar Estagiário</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Nome:</label>
					<input type="text" id="nome" name="nome" size="50" maxlength="50" class="form-control" value='<?php echo($nome);?>' required>
					<input type="hidden" id="id" name="id" size="5" maxlength="5" class="form-control" value='<?php echo($idc);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>Matrícula:</label>
					<input type="text" id="matricula" name="matricula" size="10" maxlength="10" class="form-control" value='<?php echo($matricula);?>' required>
					<input type="hidden" id="id" name="id" size="5" maxlength="5" class="form-control" value='<?php echo($idc);?>' required>
				</div>
			</div>	
<!--		<div class="row">
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

