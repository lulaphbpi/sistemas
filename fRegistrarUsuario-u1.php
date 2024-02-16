<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$nivelusuario=3;
$identificacao='';
$niveldousuarioid=0;
$grupoid=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pessoaid=$_GET['id'];
$rpes=lepessoafisicaporid($pessoaid,$conpes);
if($rpes){
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome'];
	$datanascimento=$rpes['datanascimento'];
	$dtn=formataDataToBr($datanascimento);
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$email=$rpes['email'];
	$rusu=leusuarioefiporpessoaid($pessoaid,$conpes);
	if($rusu){
		$identificacao=$rusu['identificacao'];
		$lusu=leusuariogrupo($pessoaid, $conefi);
		$niveldousuarioid=$lusu['niveldousuario_id'];
		$grupoid=$lusu['grupo_id'];
		$msg=$msg." -- ATENÇÃO: "."Usuário existente! Você poderá registrar apenas o usuário do sistema.";
	}else{
		$identificacao=geraIdentificacao($apelido,$conpes);
		$msg='';
	}
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('Gave shit:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao)."Usuario-u1.php?id=$pessoaid";

?>
<script>
</script>
    <div class="areatrabalho">
    <div class="formularioEntrada">

        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="<?php if(left(trim($msg),5)=='-- AT'){echo('lblatencao');}else{echo('lblerro');}?>"><?php echo($msg); ?></div><br>
			<p>Registro de Usuário (Pessoa Id:<?php echo($pessoaid);?>)</p>
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
					<p><?php echo($dtn);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Sexo: </label>
					<p><?php echo($sexo);?></p>
				</div>
			</div>	
			<br>
			
			<div class="row">
				<div class="form-group col-md-3">
					<label>Identificação Sugerida:</label>
					<input type="text" id="identificacao" name="identificacao" size="30" maxlength="30" class="form-control" value='<?php echo($identificacao);?>' required>
				</div>
			
				<div class="form-group col-md-3">
					<label>Selecione o Nível do Usuário:</label>
					<select name="niveldousuario_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php
			$tabela = 'niveldousuario';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>1){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$niveldousuarioid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label>Selecione o Grupo do Usuário:</label>
					<select name="grupo_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php
			$tabela = 'grupo';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>1){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$grupoid){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],30)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-11">
					<button type="submit" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button>
				</div>
			</div>	
        </form>
		&nbsp;<a href="rusuarios01.php" target="_new" > Relação Geral de Usuários</a>
    </div>    
</div>	
