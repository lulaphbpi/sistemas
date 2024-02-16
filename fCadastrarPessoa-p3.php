<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);

$msg="";
$msg=$_SESSION['msg'];
$cpf=$_SESSION['cpf'];
$cpfc=formatarCNPJCPF($cpf,'cpf');
$cadastro1=$_SESSION['cadastro1'];
$datanascimento="";
$sexo="";
$rg="";
$expedidorrg_id=-1;
$formacaoprofissional_id=-1;
// Formulário de Entrada para a opção Cadastre-me da Página Inicial, linha do topo
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="cadastrapessoa-p3.php" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
            <br>
			<b>COMPLEMENTE O CADASTRO (Dados Complementares)</b>
            <br>
            <br>
            <b>CPF:</b> <?php echo($cpfc); ?><br>
            <b>Apelido/Nome: </b><?php echo($cadastro1['apelido'].'/'.$cadastro1['nome']); ?><br>
			<br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Data de Nascimento:</label>
            <input type="date" id="datanascimento" name="datanascimento" size="10" maxlength="10" class="form-control">
				</div>
				<div class="form-group col-md-3">
					<label>Sexo:</label><br>
            <label for="idfeminino">Feminino</label>
            <input type="radio" class="simnao" name="sexo" id="idfeminino" value="F">
            <label for="idmasculino">Masculino</label>
            <input type="radio" class="simnao" name="sexo" id="idmasculino" value="M">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<label>RG (Documento de Identificação):</label>
            <input type="text" id="rg" name="rg" size="30" maxlength="30" class="form-control">
				</div>
				<div class="form-group col-md-3">
					<label>Órgão Expedidor:</label>
		    <select name="expedidorrg_id" class="form-control" > 
				<option value="" selected="selected"></option>
<?php
			$tabela = 'expedidorrg';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conexao);
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

			<div class="row">
				<div class="form-group col-md-6">
					<label>Categoria Profissional:</label>
            <select name=formacaoprofissional_id class="form-control" >
				<option value="" selected="selected"></option>
<?php
			$tabela = 'formacaoprofissional';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conexao);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$formacaoprofissional_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
<?php
					}
				}
			}
?>
            </select>
			<div class="help-block with-errors"></div>
				</div>
			</div>
			<div class="row">
	            <div class="form-group col-md-6">
					<button type="button" id="ibformulariop3" style="width:90;height:20" class="btn btn-primary btn-block"> Continuar </button><br>
				</div>
			</div>
        </form>    
    </div>    
</div>	

