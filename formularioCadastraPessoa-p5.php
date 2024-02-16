<?php
include('inicio.php');
include('../include/sa000.php');
$conexao=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$cpf=$_SESSION['cpf'];
$cpfc=formatarCNPJCPF($cpf,'cpf');
$cadastro1=$_SESSION['cadastro1'];
$identificacao=soalfanumerico(strtolower($cadastro1['apelido']));
//$identificacao="";
$senha="";
$senhac="";
// Formulário de Entrada para a opção Cadastre-me da Página Inicial, linha do topo
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="cadastrapessoa-p5.php" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
            <br>
			<div class="row">
				<div class="form-group col-md-6">
					<b>COMPLEMENTE O CADASTRO - Conclusão (Anote sua Identificação e Senha para NÃO esquecer)</b>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
            <b>CPF: <?php echo($cpfc); ?></b><br>
            <b>Apelido/Nome: <?php echo($cadastro1['apelido'].'/'.$cadastro1['nome']); ?></b><br>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Identificação Única (nome sem espaços ou sinais especiais):</label>
					<input type="text" id="identificacao" name="identificacao" size="30" maxlength="30" value="<?php echo($identificacao) ?>" class="form-control"><br>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Senha:</label>
					<input type="password" id="senha" name="senha" size="30" maxlength="30" class="form-control"><br>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Confirme a Senha:</label>
					<input type="password" id="senhac" name="senhac" size="30" maxlength="30" class="form-control"><br>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<button type="button" id="ibformulariop5" style="width:90;height:20" class="btn btn-primary btn-block"> Continuar </button>
				</div>
			</div>
        </form>    
    </div>    
</div>	

