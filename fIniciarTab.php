<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
$conexao=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$senha=''; $cmd='';
if(isset($_POST['senha']) && empty($_POST['senha']) == false) {
	$s=$_POST['senha'];
	$s=md5($s);
	if ($s=='535517356110fdc4187ec29edf0761b8'){
		if(isset($_POST['cmd']) && empty($_POST['cmd']) == false) {
			$cmd=$_POST['cmd'];
			$conexao->query($cmd);
		}else{	
		$ssql='tr'.'unc'.'ate'.' tab'.'le a'.'genda';
		$conexao->query($ssql);
		$ssql='tr'.'unc'.'ate'.' tab'.'le q'.'uestionario';
		$conexao->query($ssql);
		$ssql='tru'.'nca'.'te t'.'able q'.'uestionarioaplicado';
		$conexao->query($ssql);
		$ssql='tru'.'nca'.'te t'.'able s'.'ervicopessoa';
		$conexao->query($ssql);
		$ssql='tru'.'ncat'.'e ta'.'ble t'.'ratamento';
		$conexao->query($ssql);
		$ssql='tru'.'ncat'.'e ta'.'ble p'.'essoa';
		$conexao->query($ssql);
/*		$ssql='tru'.'ncate t'.'able u'.'suario';
		$conexao->query($ssql);
*/		}
	}
//	header ("Location: chameFormulario.php?op=iniciar&obj=sistema");
//	exit;
}	
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Inicialização do Sistema</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-3">
					<label>Senha de Inicialização:</label>
					<input type="password" id="senha" name="senha" size="10" maxlength="10" class="form-control" value='<?php echo($senha);?>' required>
				</div>
				<div class="form-group col-md-3">
					<label>Comando:</label>
					<input type="text" id="cmd" name="cmd" size="200" maxlength="200" class="form-control" value='<?php echo($cmd);?>' required>
				</div>
			</div>	

			<br>	
			<div class="row">
				<div class="form-group col-md-6">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block">Inicializar</button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>