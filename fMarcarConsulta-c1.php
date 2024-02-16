<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$connae=conexao('consnae');
$trace=ftrace('fMarcarConsulta-c1.php','Inicio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0; $datahoje=date('Y-m-d');
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
}	
if($id==0){
	$_SESSION['msg']='Sem id do cliente!';
	header("Location: chameFormulario.php?op=consultar&obj=pessoa&cpl=c1");
	exit();
}

$operacao='Marcar Nova Consulta'; //$_SESSION['operacao'];
$act='marcarConsulta-c1.php?id='.$id; //die($act);

$rpessoa=lepessoafisicaporid($id,$conpes);
if($rpessoa){
	$nome=$rpessoa['nome'];
	$apelido=$rpessoa['apelido'];
	$datanascimento=$rpessoa['datanascimento'];
	$idade=idade($datanascimento);
	//$datanascimento=formataDataToBr($rpessoa['datanascimento']);
	$cpf=$rpessoa['cpf'];
	$sexo=$rpessoa['sexo'];
	$fone=$rpessoa['fone'];
	$email=$rpessoa['email'];
	 
	$logradouro='';
	$numero='';
	$complemento='';
	$bairro='';
	$cep='';
	$municipio='';
	$uf='';
	$lbl='Preencha e Selecione dados para Marcar Nova Consulta';
	
	$convenio_id=1; $cpfresponsavel=''; $tipodeacompanhante_id=0; 
	$medico_id=1; $dataconsulta=date('Y-m-d'); $horario='12:00h';

	$status='Nova Consulta';
	if(isset($_GET['idc']) && empty($_GET['idc']) == false){
		$operacao='Retornar'; //$_SESSION['operacao'];
		$act='chameFormulario.php?op=consultar&obj=consulta&cpl=c1&id='.$id; //die($act);
		$idc=$_GET['idc'];
		$lbl='Consulta Registrada Nº. '.fnumero($idc,4);
		$leconsulta=leconsultadepessoafisicaporid($idc, $connae);
		$cpfresponsavel=$leconsulta['cpfresponsavel'];
		$tipodeacompanhante_id=$leconsulta['tipodeacompanhante_id'];
		$dataconsulta=$leconsulta['dataconsulta'];
		$medico_id=$leconsulta['medico_id'];
		$horario=$leconsulta['horario'];
		$confirmado=$leconsulta['confirmado'];
		$realizado=$leconsulta['realizado'];
		$status='Consulta Marcada';
		if($confirmado=='S'){
			$status='Consulta Confirmada';
			if($realizado=='S'){
				$status='Consulta Confirmada e Realizada';
			}else{
				if($dataconsulta<$datahoje)
					$status=$status.' - Vencida';
			}	
		}else{
			if($dataconsulta<$datahoje)
				$status=$status.' - Vencida';
		}	
	}	
	
	
	$render=fleenderecopessoa($id,$conpes);
	if($render){
		$logradouro=$render['logradouro'];
		$numero==$render['numero'];
		$complemento==$render['complemento'];
		$bairro==$render['bairro'];
		$cep=$render['cep'];
		$municipio=$render['municipio'];
		$uf=$render['uf'];
	}
	$rpessoanae=lepessoanaeporpessoaid($id,$connae);
	if($rpessoanae){
		$pid=$rpessoanae['id'];
		$natureza=$rpessoanae['natureza'];
		$nomemae=$rpessoanae['nomemae'];
		$cor_id=$rpessoanae['cor_id'];
		$cartaosus=$rpessoanae['cartaosus'];
		$planodesaude_id=$rpessoanae['planodesaude_id'];
		$cartaosaude=$rpessoanae['cartaosaude'];
	}	
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die(' deu merda:'.'ERRO FATAL: Id de requisicao '.$id.' não encontrado!');
	return '';
}

$trace=ftrace('fMarcarConsulta-c1.php',$act);
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Dados do Paciente <?php echo($id);?>:</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Apelido:</label>
					<input type="text" id="apelido" name="apelido" size="30" maxlength="30" class="form-control" value='<?php echo($apelido);?>' required>
				</div>
				<div class="form-group col-md-4">
					<label>Nome Completo:</label>
					<input type="text" id="nome" name="nome" size="70" maxlength="70" class="form-control" value='<?php echo($nome);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label>Data Nasc. <?php echo('('.$idade.' anos)');?>:</label>
					<input type="date" id="datanascimento" name="datanascimento" size="10" maxlength="10" class="form-control" value='<?php echo($datanascimento);?>' >
				</div>
				<div class="form-group col-md-2">
					<label>Sexo:</label><br>
					<label for="idfeminino">Fem</label>
					<input type="radio" class="simnao" name="sexo" id="idfeminino" value="F" <?php if($sexo=='F'){echo("checked");} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idmasculino">Mas</label>
					<input type="radio" class="simnao" name="sexo" id="idmasculino" value="M" <?php if($sexo=='M'){echo("checked");} ?>>
				</div>
			</div>
			
			
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
			$rtab=fletabela($tabela,$ordem,$connae);
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
				<div class="form-group col-md-2">
					<label>Convênio:</label>
					<select name="convenio_id" class="form-control" > 
						<option value="0" selected="selected"></option>
<?php
			$tabela = 'convenio';
			$ordem = 'descricao';
			$rtab=fletabela($tabela,$ordem,$connae);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$convenio_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],20)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label>Cartão SUS:</label>
					<input type="text" id="cartaosus" name="cartaosus" size="30" maxlength="30" class="form-control" value='<?php echo($cartaosus);?>' required>
				</div>
			</div>	
			
			Endereço:
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
			<label>E-mail (preferencialmente o institucional, se for da UFDPAR):</label>
            <input type="email" name="email" size="99" maxlength="120" class="form-control" required value='<?php echo($email);?>'>
				</div>
			</div>
			<br>
			<?php echo($lbl);?>
			<div class="row">
				<div class="form-group col-md-3">
					<label>CPF do Responsável (Acompanhante):</label>
					<input type="text" id="cpfresponsavel" name="cpfresponsavel" size="12" maxlength="11" class="form-control" value='<?php echo($cpfresponsavel);?>' >
				</div>
				<div class="form-group col-md-2">
					<label>Tipo de Acompanhante:</label>
					<select name="tipodeacompanhante_id" class="form-control"> 
						<option value="" selected="selected"></option>
<?php
			$tabela = 'tipodeacompanhante';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$connae);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$tipodeacompanhante_id){echo("selected='selected'");} ?>> <?php echo($tab['descricao']); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
				<div class="form-group col-md-2">
					<label>Médico:</label>
					<select name="medico_id" class="form-control"> 
						<option value="" selected="selected"></option>
<?php
			$tabela = 'medico';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$connae);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$medico_id){echo("selected='selected'");} ?>> <?php echo(fnumero($tab['id'],2)).'-'.fstring($tab['nome'],30); ?></option>
<?php
					}
				}
			}
?>
            </select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Data da Consulta:</label>
					<input type="date" id="dataconsulta" name="dataconsulta" size="10" maxlength="10" class="form-control" value='<?php echo($dataconsulta);?>' >
				</div>
				<div class="form-group col-md-2">
					<label>A partir das:</label>
					<input type="text" id="horario" name="horario" size="10" maxlength="10" class="form-control" value='<?php echo($horario);?>' required>
				</div>
				<div class="form-group col-md-2">
					<label>Status:</label>
					<input type="text" id="status" name="status" size="20" maxlength="20" class="form-control" value='<?php echo($status);?>' required>
				</div>
				<div class="form-group col-md-2">
				<input type="hidden" name="atualiza_dados" value="0">
				<div class="form-checkbox">
					<input class="form-check-input" type="checkbox"
                   value="1" name="atualiza_dados" id="atualiza_dados" required></input>
					<label class="form-check-label btn btn-xs" for="atualiza_dados">
                Marque para atualizar dados</label>
				</div>
				</div>
				<div class="form-group col-md-2"  onload="piscar();" id="piscante">
					<strong style="color:red;"><?php echo($msg);?></strong>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-11">
				<button type="button" id="ibformulariop2" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
		<p><a href='chameFormulario.php?op=consultar&obj=consulta&cpl=c1&id=<?php echo($id); ?>'>Listar Consultas</a></p>
	</div>    
</div>	