<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$confun=conexao('funcional');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$titulo='Enviar Mensagem';
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];

$identificacao_destino='';
$identificacao_origem='';
$msg_assunto_id=0;
$mensagem='';
$msg_status_id=1;

$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Mensagem-m1.php';
if($id>0){
	$operacao='Atualizar';
	$act=$act.'?id='.$id;
	$rtab=lemensagem($id,$conacl);
	if($rtab){
		$sigla=$rtab['sigla'];
		$descricao=$rtab['descricao'];
		$tipodeamostra_id=$rtab['tipodeamostra_id'];
		$material=$rtab['material'];
		$observacao=$rtab['observacao'];
	}
	if(isset($_GET['idc']) && empty($_GET['idc']) == false){
		$idc=$_GET['idc'];
		if($idc == 'S'){
			$titulo='Excluir Mensagem';
			$operacao='Clique para Excluir';
			$act='excluirMensagem-m1.php?id='.$id;
		}
	}	
}
?>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b><?php echo($titulo);?></b>
			<br><br>
			<div class="row">
				<div class="form-group col-md-4">
					<label>Destinatário: </label>
					<select name="identificacao_destino" class="form-control">
					<option value="" selected="selected"></option>
<?php
			$rectab=fleusuarios($conpes);
			if($rectab) {
				if($rectab->rowCount()>0) {
					foreach($rectab->fetchAll() as $rtab) { 
?>
					<option value="<?php echo($rtab['identificacao']);?>" <?php if($rtab['identificacao']==$identificacao_destino){echo("selected");} ?>><?php echo($rtab['pessoanome']); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>Assunto:</label>
					<select name="msg_assunto_id" class="form-control">
					<option value="" selected="selected"></option>
<?php
			$tabela = 'msg_assunto';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$confun);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
					<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$msg_assunto_id){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],20)); ?></option>
<?php
					}
				}
			}
?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-8">
					<label>Mensagem: </label>
					<textarea name="mensagem"  rows="5" cols="100" class="form-control"><?php echo($mensagem); ?></textarea>
				</div>
			</div>	
			<br>
			<div class="row">
				<div class="form-group col-md-8">
				<button type="submit" id="ibotao" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
        </form>    
    </div>    
</div>