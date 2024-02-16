<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$formacaoprofissional_id=999;
$tipodevinculo_id=1;
$matricula="";
$apelido='';
$nome='';
$datanascimento='';
$sexo='F';
$rg="";
$expedidorrg_id=1;
$logradouro='';
$numero='';
$complemento='';
$bairro='';
$municipio='';
$ufsigla='PI';
$cep='';
$fone='';
$email='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Pessoa-p1.php';
if($id>0){
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=lepessoafisicaporid($id,$conpes);
	if($rtab){
		$cpf=$rtab['cpf'];
		$formacaoprofissional_id=$rtab['formacaoprofissional_id'];
		$apelido=$rtab['apelido'];
		$nome=$rtab['nome'];
		$datanascimento=$rtab['datanascimento'];
		$sexo=$rtab['sexo'];
		$rg=$rtab['rg'];
		$expedidorrg_id=$rtab['expedidorrg_id'];
		$fone=$rtab['fone'];
		$email=$rtab['email'];
	}
	$rvin=levinculo($id,$conpes);
	if($rvin){
		$matricula=$rvin['matriculainstitucional'];
		$tipodevinculo_id=$rvin['tipodevinculo_id'];
	}
	$rend=fleenderecopessoa($id,$conpes);
	if($rend) {
		$logradouro=$rend['logradouro'];
		$numero=$rend['numero'];
		$complemento=$rend['complemento'];
		$bairro=$rend['bairro'];
		$municipio=$rend['municipio'];
		$ufsigla=$rend['uf']; //die($ufsigla);
		$cep=$rend['cep'];
	}
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Cadastro</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>CPF: </label>
					<input type="text" id="cpf" name="cpf" size="15" maxlength="11" class="form-control" value='<?php echo($cpf);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label>Categoria Profissional:</label>
					<select name=formacaoprofissional_id class="form-control" >
					<option value="" selected="selected"></option>
<?php
			$tabela = 'formacaoprofissional';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conpes);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$formacaoprofissional_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-3">
				<label>Vínculo com a UFPI:</label>
				<select name=tipodevinculo_id class="form-control">
				<option value="" selected="selected"></option>
<?php
			$tabela = 'tipodevinculo';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conpes);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodevinculo_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
				<div class="form-group col-md-2">
				<label>Matrícula/Siape:</label>
				<input type="text" id="matricula" name="matricula" size="30" maxlength="30" class="form-control" value='<?php echo($matricula);?>'>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-3">
			<label>Alcunha (Ex: D Maria, Dr José):</label>
            <input type="text" id="apelido" name="apelido" size="30" maxlength="30" class="form-control" value='<?php echo($apelido);?>' required>
				</div>
				<div class="form-group col-md-8">
					<label>Nome Completo:</label>
					<input type="text" id="nome" name="nome" size="70" maxlength="70" class="form-control" value='<?php echo($nome);?>' required>
				</div>
			</div>	

			<div class="row">
				<div class="form-group col-md-3">
					<label>Data de Nascimento:</label>
            <input type="date" id="datanascimento" name="datanascimento" size="10" maxlength="10" class="form-control" value='<?php echo($datanascimento);?>' >
				</div>
				<div class="form-group col-md-3">
					<label>Sexo:</label><br>
					<label for="idfeminino">Feminino</label>
					<input type="radio" class="simnao" name="sexo" id="idfeminino" value="F" <?php if($sexo=='F'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idmasculino">Masculino</label>
					<input type="radio" class="simnao" name="sexo" id="idmasculino" value="M" <?php if($sexo=='M'){echo("checked");} ?>>
				</div>
				<div class="form-group col-md-3">
					<label>RG (Documento de Identificação):</label>
            <input type="text" id="rg" name="rg" size="30" maxlength="30" class="form-control" value='<?php echo($rg);?>'>
				</div>
				<div class="form-group col-md-2">
					<label>Órgão Expedidor:</label>
		    <select name="expedidorrg_id" class="form-control" > 
				<option value="0" selected="selected"></option>
<?php
			$tabela = 'expedidorrg';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conpes);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$expedidorrg_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
			</div>
			Endereço
			<div class="row">
				<div class="form-group col-md-5">
					<label>Logradouro:</label>
					<input type="text" id="logradouro" name="logradouro" size="99" maxlength="120" class="form-control" required value='<?php echo($logradouro);?>'>
				</div>
				<div class="form-group col-md-2">
					<label>Número:</label>
					<input type="text" id="numero" name="numero" size="6" maxlength="6" class="form-control"  value='<?php echo($numero);?>'>
				</div>
				<div class="form-group col-md-4">
					<label>Complemento:</label>
					<input type="text" id="complemento" name="complemento" size="99" maxlength="120" class="form-control" required value='<?php echo($complemento);?>'>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Bairro:</label>
					<input type="text" id="bairro" name="bairro" size="30" maxlength="30" class="form-control" required value='<?php echo($bairro);?>'>
				</div>
				<div class="form-group col-md-3">
					<label>Cidade:</label>
					<input type="text" id="municipio" name="municipio" size="30" maxlength="30" class="form-control" required value='<?php echo($municipio);?>'>
				</div>
				<div class="form-group col-md-2">
					<label>UF:</label>
					<select name="uf" class="form-control"> 
						<option value="" selected="selected"></option>
<?php
			$tabela = 'unidadefederativa';
			$ordem = 'sigla';
			$rtab=fletabela($tabela,$ordem,$conpes);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['sigla']); ?>" <?php if($tab['sigla']==$ufsigla){echo("selected='selected'");} ?>> <?php echo(fnumero($tab['sigla'],2)).'-'.fstring($tab['descricao'],30); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
				<div class="form-group col-md-2">
					<label>Cep:</label>
					<input type="text" id="cep" name="cep" size="10" maxlength="10" class="form-control" required value='<?php echo($cep);?>'>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
			<label>Telefones (Fixos, celulares, etc):</label>
            <input type="text" id="fone" name="fone" size="99" maxlength="120" class="form-control" required value='<?php echo($fone);?>'>
				</div>
				<div class="form-group col-md-5">
			<label>E-mail (preferencialmente o institucional, se for da UFPI):</label>
            <input type="email" id="email" name="email" size="99" maxlength="120" class="form-control" required value='<?php echo($email);?>'>
				</div>
			</div>
			
			<br>	
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibformulariop1" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
<?php 
	if($id>0){
?>		
	    <a href='chameFormulario.php?op=registrar&obj=
cliente&cpl=p2&id=<?PHP echo($id);?>'><?PHP echo('Registrar Cliente');?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='chameFormulario.php?op=registrar&obj=
usuario&cpl=u1&id=<?PHP echo($id);?>'><?PHP echo('Registrar Usuário');?></a>	
	
<?php
	}
?>	
	<a href='chameFormulario.php?op=registrar&obj=cliente&cpl=p2&id=<?PHP echo($pessoaid);?>'>Cancelar</a>

	</div>    
</div>	

