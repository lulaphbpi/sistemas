<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$descricao='';
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'convenio-v1.php';
if($id>0){
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=letabelaporid('convenio',$id,$conacl);
	if($rtab){
		$id=$rtab['id'];
		$descricao=$rtab['descricao'];
	}
}
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Cadastrar Convênio</b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Descrição:</label>
					<input type="text" id="descricao" name="descricao" size="50" maxlength="50" class="form-control" value='<?php echo($descricao);?>' required>
				</div>
			</div>	

			<br>	
			<div class="row">
				<div class="form-group col-md-5">
				<button type="button" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>	

