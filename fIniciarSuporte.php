<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$s=''; $cmd='';
$resp='SAÍDA:';
if(isset($_POST['senha']) && empty($_POST['senha']) == false) {
	$s=$_POST['senha'];
	$s=md5($s);
	$banco=$_POST['banco'];
	$conexao=conexao($banco);
	if ($s=='535517356110fdc4187ec29edf0761b8'){
		if(isset($_POST['cmd']) && empty($_POST['cmd']) == false) {
			$cmd=$_POST['cmd'];
			$comando = str_replace("**", "%", $cmd);
			$comando = str_replace("\\", " ", $comando);
			try {
				$exec=$conexao->query($comando);
				if(!$exec){
					$msg='Falha :  Comando não executou:'.$comando;
				}
			}catch(PDOException $e)	{
				$msg=' ERRO Exception: (fInicializarSuporte) ' . $e->getMessage(). ' '. $comando;
			}
			if($exec){
				if(strtoupper(left($comando,6))=="DE"."LE"."TE" || strtoupper(left($comando,6))=="UP"."DA"."TE"){
				}else{	
					if(strtoupper(left($comando,6))=="SELECT"){
						if($exec->rowCount()==0){
							$resp=$resp."\nNenhum Registro Encontrado!";
						}
						foreach($exec->fetchAll() as $r) {
							$nc=count($r);
							$l="";
							for($i = 0; $i < $nc/2; $i++){
								$l=$l.$r[$i]." ";
							}
							$resp=$resp."\n".$l;
						}	
					}
				}		
			}
		}
	}
}	

?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Suporte ao Banco de Dados</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Senha de Inicialização:</label>
					<input type="password" id="senha" name="senha" size="10" maxlength="10" class="form-control" value='<?php echo($s);?>' required>
				</div>
				<div class="form-group col-md-5">
					<label>Banco:</label><br>
					<label for="idPessoal">Pessoal</label>
					<input type="radio" class="simnao" name="banco" id="idPessoal" value="pessoal" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idPessoal">Funcional</label>
					<input type="radio" class="simnao" name="banco" id="idFuncional" value="funcional" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idAClinica">AClinica</label>
					<input type="radio" class="simnao" name="banco" id="idAClinica" value="aclinica" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="idArhWeb">ArhWeb</label>
					<input type="radio" class="simnao" name="banco" id="idArhWeb" value="arhweb">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-10">
					<label>Comando:</label>
					<textarea name="cmd" rows="4" cols="100" class="form-control" ><?php echo($cmd); ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-10">
					<label>Resposta:</label>
					<textarea name="resp" rows="6" cols="100" class="form-control" ><?php echo($resp); ?></textarea>
				</div>
			</div>	

			<br>	
			<div class="row">
				<div class="form-group col-md-10">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block">Executar</button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>