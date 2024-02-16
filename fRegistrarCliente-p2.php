<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=$_GET['id'];
$pessoaid=$id;
$ocupacao='';
$contato='';
$nomemae='';
$cor_id=0;
$cartaosus='';
$data=date("Y-m-d");
$diagnosticomedico='';
$motivo='';
$observacoes='';
$servico_id=0;
$totalservicos=0;

$rpes=lepessoafisicaporid($pessoaid,$conpes);
if($rpes){
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome'];
	$datanascimento=$rpes['datanascimento'];
	$idade = idade($rpes['datanascimento']);
	$dtn=formataDataToBr($datanascimento);
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$rreg=lepessoaefi($pessoaid, $conefi);
if($rreg) {
	$idp=$rreg['id'];
	$ocupacao=$rreg['ocupacao'];
	$contato=$rreg['contato'];
	$nomemae=$rreg['nomemae'];
	$cor_id=$rreg['cor_id'];
	$cartaosus=$rreg['cartaosus'];
	$data=$rreg['data'];
	$diagnosticomedico=$rreg['diagnosticomedico'];
	$motivo=$rreg['motivo'];
	$observacoes=$rreg['observacoes'];
	$fservico=fleservicopessoa_fi($pessoaid, $conefi);
	$totalservicos=$fservico->rowCount();
	$trace=ftrace('fRegistrarCliente-p2.php','totalservicos:'.$totalservicos);
}	
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Cliente-p2.php?id='.$pessoaid; //die($act);
if($rreg) {
	$operacao="Atualizar";
	$act='registrarCliente-p2.php?id='.$pessoaid; //die($act);
}	


?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Paciente - Dados Complementares (Pessoa <?php echo($pessoaid);?>)</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Nome Social: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Gênero: </label>
					<p><?php echo($sexo);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Fone: </label>
					<p><?php echo($fone);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-3">
					<label>Ocupação:</label>
					<input type="text" id="ocupacao" name="ocupacao" size="50" maxlength="50" class="form-control" value='<?php echo($ocupacao);?>' >
				</div>
				<div class="form-group col-md-7">
					<label>Nome/ Contato Emergência:</label><br>
					<input type="text" id="contato" name="contato" size=70 maxlength="50" class="form-control" value='<?php echo($contato);?>' >
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Nome da Mãe:</label>
					<input type="text" id="nomemae" name="nomemae" size="100" maxlength="100" class="form-control" value='<?php echo($nomemae);?>' required>
				</div>

				<div class="form-group col-md-2">
					<label>Descendência:</label>
					<select name="cor_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'cor';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$cor_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label>Cartão SUS:</label>
					<input type="text" id="cartaosus" name="cartaosus" size="30" maxlength="30" class="form-control" value='<?php echo($cartaosus);?>'>
				</div>
			</div>	

			<div class="row">
				<div class="form-group col-md-3">
					<label>Data do Atendimento:</label>
					<input type="date" id="data" name="data" size="10" maxlength="10" class="form-control" value='<?php echo($data);?>' >
				</div>
				<div class="form-group col-md-7">
					<label>Diagnóstico Médico:</label><br>
					<textarea name='diagnosticomedico' rows=2 cols=101 class="form-control" ><?php echo($diagnosticomedico);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Motivo/Queixas:</label>
					<textarea name='motivo' rows=2 cols=101 class="form-control" ><?php echo($motivo);?></textarea>
				</div>
				<div class="form-group col-md-5">
					<label>Observações:</label><br>
					<textarea name='observacoes' rows=2 cols=101 class="form-control" ><?php echo($observacoes);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-11">
<?php
if($totalservicos>0){
?>
	<p>Serviço(s) Associado(s):</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>SPId</th>
		<th width='5%'>Serviço</th>
		<th width='20%'>Descrição</th>
		<th width='10%'>Data Atendimento</th>
		<th width='10%'>Status</th>
		<th width='5%'>Excluir</th>
	</tr>
<?php
foreach($fservico->fetchAll() as $tab) {
		$sid=$tab['id'];
		$servicoid=$tab['servico_id'];
		$servico=$tab['servico'];
		$data=formataDataToBr($tab['data']);
		$servicoativo=$tab['ativo'];
		$statusservico=$tab['status'];
?>				
				<tr>
					<td><?PHP echo($sid);?></td>
					<td><?PHP echo($servicoid);?></td>
					<td><?PHP echo($servico);?></td>
					<td><?PHP echo($data);?></td>
					<td><?PHP echo($statusservico);?></td>
<?php 
if($servicoativo=='S'){
?>					
					<td><a href='registrarCliente-p2.php?id=<?php echo($pessoaid);?>&idc=<?PHP echo($sid);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
<?php
}
?>
				</tr>
<?php
}
?>
    </table> 
    <br>
<?php	
}
?>			
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-10">
					<label>Adicionar Serviço:</label>
					<select name="servico_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'servico';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$servico_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],80)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
			</div>	
			<br>	
			<div class="row">
				<div class="form-group col-md-10">
				<button type="submit" id="ibformulariop2" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
<?php
if($rpes && $rreg){		
?>

<?php
}
?>
    </div>    
</div>	