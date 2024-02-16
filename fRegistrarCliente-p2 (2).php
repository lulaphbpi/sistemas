<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=$_GET['id'];
$pessoaid=$id;
$nomemae='';
$cor_id=0;
$cartaosus='';
$medicamentos='';
$ciclomenstrual_id=0;
$bebidaalcoolica='N';
$atividadefisica='N';
$altura='';
$peso='';
$observacoes='';
$data=date("Y-m-d");
$rpes=lepessoafisicaporid($id,$conpes);
if($rpes){
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['pessoanome'];
	$datanascimento=$rpes['datanascimento'];
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$rreg=lepessoaacl($id, $conacl);
if($rreg) {
	$nomemae=$rreg['nomemae'];
	$cor_id=$rreg['cor_id'];
	$cartaosus=$rreg['cartaosus'];
}	
$substitui='N';
$rreg=leestadoacl($id, $conacl);
if($rreg) {
	$medicamentos=$rreg['medicamentos'];
	$ciclomenstrual_id=$rreg['ciclomenstrual_id'];
	$bebidaalcoolica=$rreg['bebidaalcoolica'];
	$atividadefisica=$rreg['atividadefisica'];
	$altura=convertFloatToNumStr($rreg['altura']);
	$peso=convertFloatToNumStr($rreg['peso']);
	$observacoes=$rreg['observacoes'];
	$data=$rreg['data'];
}
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Cliente-p2.php?id='.$id; //die($act);

?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Registrar Cliente - Dados Complementares</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Alcunha: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($datanascimento);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Sexo: </label>
					<p><?php echo($sexo);?></p>
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Nome da Mãe:</label>
					<input type="text" id="nomemae" name="nomemae" size="100" maxlength="100" class="form-control" value='<?php echo($nomemae);?>' required>
				</div>

				<div class="form-group col-md-2">
					<label>Cor:</label>
					<select name="cor_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'cor';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$cor_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label>Cartão SUS:</label>
					<input type="text" id="cartaosus" name="cartaosus" size="30" maxlength="30" class="form-control" value='<?php echo($cartaosus);?>' required>
				</div>
			</div>	

			<div class="row">
				<div class="form-group col-md-3">
					<label>Data:</label>
					<input type="date" id="data" name="data" size="10" maxlength="10" class="form-control" value='<?php echo($data);?>' >
				</div>
				<div class="form-group col-md-7">
					<label>Medicamentos:</label><br>
					<textarea name='medicamentos' rows=2 cols=101 class="form-control" required><?php echo($medicamentos);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Ingere bebida alcoólica?</label><br>
					<label for="idnao">Não</label>
					<input type="radio" class="simnao" name="bebidaalcoolica" id="bebidaalcoolica" value="N" <?php if($bebidaalcoolica=='N'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Sim</label>
					<input type="radio" class="simnao" name="bebidaalcoolica" id="bebidaalcoolica" value="S" <?php if($bebidaalcoolica=='S'){echo("checked");} ?>>
				</div>
				<div class="form-group col-md-3">
					<label>Pratica atividade física?</label><br>
					<label for="idnao">Não</label>
					<input type="radio" class="simnao" name="atividadefisica" id="atividadefisica" value="N" <?php if($atividadefisica=='N'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Sim</label>
					<input type="radio" class="simnao" name="atividadefisica" id="atividadefisica" value="S" <?php if($atividadefisica=='S'){echo("checked");} ?>>
				</div>
				<div class="form-group col-md-1">
					<label>Altura:</label>
					<input type="text" id="altura" name="altura" size="9" maxlength="9" class="form-control" required value='<?php echo($altura);?>'>
				</div>
				<div class="form-group col-md-1">
					<label>Peso:</label>
					<input type="text" id="peso" name="peso" size="6" maxlength="6" class="form-control"  value='<?php echo($peso);?>'>
				</div>
<?php 
if($sexo=='F') {
?>			
				<div class="form-group col-md-2">
					<label>Fase Ciclo Menstrual:</label>
					<select name="ciclomenstrual_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'ciclomenstrual';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$ciclomenstrual_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				
<?php
} 
?>
			</div>
			<div class="row">
				<div class="form-group col-md-7">
					<label>Observações:</label><br>
					<textarea name='observacoes' rows=2 cols=101 class="form-control" required><?php echo($observacoes);?></textarea>
				</div>
				<div class="form-group col-md-3">
					<label><i>Substitui O último Registro?</i></label><br>
					<label for="idnao">Sim</label>
					<input type="radio" class="simnao" name="substitui" id="substitui" value="S" <?php if($substitui=='S'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idsim">Não</label>
					<input type="radio" class="simnao" name="substitui" id="substitui" value="N" <?php if($substitui=='N'){echo("checked");} ?>>
				</div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-10">
				<button type="button" id="ibformulariop2" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>
<?php
if($rpes && $rreg){		
?>
		<a href='chameFormulario.php?op=cadastrar&obj=requisicao&cpl=r1&id=<?PHP echo($pessoaid);?>'><?PHP echo('Cadastrar Requisição');?></a>	
<?php
}
?>
    </div>    
</div>	