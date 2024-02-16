<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$usuarioid=$_SESSION['usuarioid'];
$leuusuario=fletabelaporvalordecampo('usuario','id',$usuarioid,$conpes);
$c=true;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
	}
}	
$act='alterarSenha-s1.php';
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Alterar Senha</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Senha atual:</label>
					<input type="password" id="senhaatual" name="senhaatual" size="30" maxlength="30" class="form-control" required>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-3">
					<label>Nova Senha:</label>
					<input type="password" id="novasenha" name="novasenha" size="30" maxlength="30" class="form-control" required>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-3">
					<label>Confirme a Nova Senha:</label>
					<input type="password" id="novasenhac" name="novasenhac" size="30" maxlength="30" class="form-control" required>
				</div>
			</div>	

			<br>	
			<div class="row">
				<div class="form-group col-md-3">
				<button type="submit" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> Salvar Nova Senha </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>	

