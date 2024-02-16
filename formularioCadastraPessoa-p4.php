<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$cpf=$_SESSION['cpf'];
$cpfc=formatarCNPJCPF($cpf,'cpf');
$cadastro1=$_SESSION['cadastro1'];
$tipodevinculo_id=-1;
$matricula="";
$lotacao_id=-1;
$funcao_id=-1;
$local_id=-1;
// Formulário de Entrada para a opção Cadastre-me da Página Inicial, linha do topo
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="cadastrapessoa-p4.php" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>COMPLEMENTE O CADASTRO </b>
            <br>
            <br>
            <b>CPF: </b><?php echo($cpfc); ?><br>
            <b>Apelido/Nome: </b><?php echo($cadastro1['apelido'].'/'.$cadastro1['nome']); ?><br>
			<br>
			<div class="row">
				<div class="form-group col-md-3">
			<label>Tipo de Vínculo com a UFPI:</label>
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
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodevinculo_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
				<div class="form-group col-md-5">
			<label>Matrícula Institucional (Matrícula Curricular/Siape/etc):</label>
            <input type="text" id="matriculainstitucional" name="matriculainstitucional" size="30" maxlength="30" class="form-control">
				</div>
			</div>	
			<P>Endereço</p>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Logradouro:</label>
					<textarea name='logradouro' rows=2 cols=101 class="form-control" required></textarea>
				</div>
				<div class="form-group col-md-2">
					<label>Número:</label>
					<input type="text" id="numero" name="numero" size="6" maxlength="6" class="form-control" >
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Complemento:</label>
					<textarea name='complemento' rows=2 cols=101 class="form-control" ></textarea>
				</div>
				<div class="form-group col-md-3">
					<label>Bairro:</label>
					<input type="text" id="bairro" name="bairro" size="30" maxlength="30" class="form-control" required>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Cidade:</label>
					<input type="text" id="municipio" name="municipio" size="30" maxlength="30" class="form-control" required>
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
					<input type="text" id="cep" name="cep" size="8" maxlength="8" class="form-control" required>
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-8">
					<button type="button" id="ibformulariop4" style="width:90;height:20" class="btn btn-primary btn-block"> Continuar </button>
				</div>
			</div>
					
        </form>    
    </div>    
</div>	

