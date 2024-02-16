<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$pessoaid=$_GET['id'];
$medico_id=0;
$tipodeexame_id=0;
$nomemedico='';
$crm='';
$especialidade_id=0;
$especialidade='';
$data=date("Y-m-d");
$rpes=lepessoafisicaporid($pessoaid,$conpes);
if($rpes){
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome']; //die($nome);
	$datanascimento=$rpes['datanascimento'];
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('Gave shit!:'.'ERRO FATAL: Id '.$pessoaid.' não encontrado!');
	return '';
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
$idc=$_GET['idc'];	
$rreq=lerequisicao($idc, $conacl);
if($rreq) {
	$guia=$rreq['guia'];
	$medico_id=$rreq['medico_id'];
	$medico=$rreq['mediconome'];
	$especialidade_id=$rreq['especialidade_id'];
	$crm1=$rreq['crm']; 
	$data=$rreq['data'];
	$status=$rreq['status'];
}}
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Requisicao-r1.php?id='.$pessoaid; //die($act);
if($idc>0) {
	$act=$act.'&idc='.$idc;
	$operacao='Alterar';
}
$ult='';
$rpp=flerequisicaoporpessoa($pessoaid,$conacl);	
if($rpp){
	if($rpp->rowCount()>0){
		$ult=''; $jj=0;
		foreach($rpp->fetchAll() as $rppr) {
		if($jj<2){
			$jj=$jj+1;
			$ult=fnumero($rppr['id'],5).' '.formataDataToBr($rppr['data']).' '.
			$rppr['mediconome'].' '.$rppr['status'].'<br>';
		}
		}
	}else{
		$ult='Nenhuma Requisição Registrada';
	}
}else{
	$ult='Nenhuma Requisição Registrada';
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="POST" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Requisição de Exames</b>
			<br><br>
			Paciente:
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Alcunha: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($datanascimento);?></p>
				</div>
			</div>	
			Últimas Requisições:<br>
			<b><?php echo($ult);?></b>
			<br><br>
			Requisição Atual:
			<div class="row">
	            <div class="form-group col-md-3">
					<label>Data:</label>
					<input type="date" name="data" id="data" class="form-control" value="<?php echo($data);?>" 
                       required></input>
				</div>
				<div class="form-group col-md-3">
					<label>Médico:<?php echo($medico_id); ?></label>
					
					<select name="medico_id" class="form-control" > 
					<option value="" selected="selected"></option>
<?php
			$tabela = 'medico';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$medico_id){echo("selected='selected'");} ?>> <?php echo(fstring(trim($tab['nome']),40).$tab['id']); ?></option>
<?php
					}
				}
			}
?>
					</select>  
					<input type="checkbox" name="novomedico" value="S">Novo Médico
					<input type="text" id="nomemedico" name="nomemedico" size="20" maxlength="50" class="form-control" >
				</div>
				<div class="form-group col-md-2">
					<label>CRM: </label>
					<input type="text" id="crm" name="crm" size="10" maxlength="10" class="form-control"  value='<?php echo($crm1);?>'>
				</div>
				<div class="form-group col-md-3">
					<label>Especialidade:</label>
					<select name="especialidade_id" class="form-control">
					<option value="" selected="selected"></option>
<?php
			$tabela = 'especialidade';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
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
			
			<br><br>	
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
			
        </form>
<?php
if($idc>0){
?>	
		<a href="chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=<?php echo($idc);?>">Incluir, Listar Exames desta Requisição</a>
<?php
}
?>		
    </div>    
</div>