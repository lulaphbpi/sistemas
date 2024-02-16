<?php
include('inicio.php');
include('../include/sa000.php');
$conefi=conexao('efisio');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0; $idc=0;
$crm='';
$especialidade_id=0;

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pid=$_GET['id'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

$lepessoa=lepessoafisicaporid($pid, $conpes);
if($lepessoa){
	$nome=$lepessoa['nome'];
}else{
	$_SESSION['msg']='Situação Inesperada ! (fCadastrarFisioterapeuta-m1.php)';
	return;
}

$lefisioterapeuta=lefisioterapeutaporpessoaid_fi($pid,$conefi);
if($lefisioterapeuta){
	$idc=$lefisioterapeuta['id'];
	$crm=$lefisioterapeuta['crm'];
	$especialidade_id=$lefisioterapeuta['especialidade_id'];
}
	
//$nome='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Fisioterapeuta-f1.php?id='.$pid;
if($idc>0){
	$operacao='Atualizar';
	$act=$act.'&idc='.$idc;
	$rtab=lefisioterapeuta_fi($idc,$conefi);
	if($rtab){
		//$nome=$rtab['nome'];
		$crm=$rtab['crm'];
		$especialidade_id=$rtab['especialidade_id'];
	}
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		if($del=='del'){
			$operacao='Excluir - Cuidado: esteja certo de não existir registro relacionado a outra estrutura';
			$act=$act.'&del=del';
		}	
	}	
}
$trace=ftrace('fCadastrarFisioterapeuta-f1.php', $act);
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Cadastrar Fisioterapeuta</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Nome:</label>
					<input type="text" id="nome" name="nome" size="50" maxlength="50" class="form-control" value='<?php echo($nome);?>' required>
					<input type="hidden" id="id" name="id" size="5" maxlength="5" class="form-control" value='<?php echo($idc);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>CRM:</label>
					<input type="text" id="crm" name="crm" size="20" maxlength="20" class="form-control" value='<?php echo($crm);?>' required>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-6">
					<label>Especialidade:</label>
		    <select name="especialidade_id" class="form-control" > 
				<option value="0" selected="selected"></option>
<?php
			$tabela = 'especialidade';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$especialidade_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
				}
			}
?>
			</select>
					<input type="checkbox" name="novaespecialidade" value="S">Nova Especialidade
					<input type="text" id="nomeespecialidade" name="nomeespecialidade" size="20" maxlength="30" class="form-control" >
				</div>
			</div>	

			<br>	
			<div class="row">
				<div class="form-group col-md-6">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>	

