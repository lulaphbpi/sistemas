<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
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
$operacao='Registrar';
$act='registrarAgendamento.php';
?>
<html>
<head>
<!--    <link href="css/bootstrap-combobox.css" rel="stylesheet" type="text/css">  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/custom2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilo1.css" />

	<script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/validator.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/bootstrap-combobox.js"></script>

    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">
    <script type="text/javascript" src="js/js1.js"></script>
    <title>AGENDA | NTI | UFDPAR</title>
</head>
<body  data-spy="scroll">
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
	<nav class="navbar navbar-default">
	  <div class="container-fluid">

		<div class="navbar-header">
			<img src="img/ufdpar-pp.png" class="img-responsive " />
		</div>

	    <ul class="nav navbar-nav navbar-right">
	      <!--- <li><a href="*">Novo</a></li> -->
	    </ul>

	    <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav" >
				<H6><strong>&nbsp;&nbsp;UNIVERSIDADE FEDERAL DO DELTA DO PARNAÍBA - UFDPAR</strong></H6>
				<h6><strong>&nbsp;&nbsp;Núcleo de Tecnologia da Informação</strong></h6>
				<H6><strong>&nbsp;&nbsp;Laboratório de Análises Clínicas
				&nbsp;-&nbsp;ACLINICA - Agendamento</strong></h6>
          </ul>
          <ul class="nav navbar-nav" >
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
              <!-- Authentication Links -->
                                <!-- <li><a href="https://cadastro.ufpi.br/login">Login</a></li> -->
		  <li>
                    <a href="/password/reset"loc>
                      <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
			 Esqueci minha senha
                    </a>
                  </li>

                  <li>
                    <a href="https://cadastro.ufpi.br/login">
                      <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    </a>
                  </li>
                        </ul>
      </div>

	  </div>
	</nav>

    
    <!-- <h1>AMBIENTE DE TESTE - Novo Usuário</h1> -->

    
    <div class="alert alert-warning" role="alert">
        <strong>ATENÇÃO!!</strong> - As informações aqui prestadas são de sua inteira responsabilidade. 
    </div>
	
        <form action="<?php echo($act);?>" method="post" id="iformulario">
			<div id="lblerro"><?php echo($msg); ?></div>
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
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$formacaoprofissional_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
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
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodevinculo_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30).' - '.fnumero($tab['id'],2)); ?></option>
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
					<input type="text" id="cep" name="cep" size="8" maxlength="8" class="form-control" required value='<?php echo($cep);?>'>
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
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibotao"  class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
</div>
</div>
</div>		
</body>
</html>