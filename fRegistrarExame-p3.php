<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');
$conpes=conexao('pessoal');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$id=$_GET['id'];
$medico_id=2;
$tipodeexame_id=0;
$nomemedico='';
$crm='';
$especialidade_id=0;
$especialidade='';
$data=date("Y-m-d");
$rpes=lepessoafisicaporid($id,$conpes);
if($rpes){
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['pessoanome'];
	$datanascimento=$rpes['datanascimento'];
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$rreq=lerequerimentoacl($id, $conacl);
if($rreq) {
	$guia=$rreq['guia'];
	$medico_id=$rreq['medico'];
	$data=$rreq['data'];
	$recexa=fleexameacl($guia, $conacl);
}
$operacao=$_SESSION['operacao'];
$act=lcfirst($operacao).'Exame-p3.php?id='.$id; //die($act);

?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Registro de Exames</b>
			<br><br>
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
					<p><?php echo($datanascimento);?></p>
				</div>
			</div>	
			<b>Requerimento</b>
			<br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Médico:</label>
					<input list="medicos">
					<datalist id="medicos">
<?php
			$tabela = 'medico';
			$ordem = 'id';
			$rtab=fletabela($tabela,$ordem,$conacl);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
?>
						<option value="<?php echo(utf8_encode(fstring($tab['nome'],40).' - '.fstring($tab['crm'],15))); ?>" <?php if($tab['id']==$medico_id){echo("selected='selected'");} ?>></option>
<?php
					}
				}
			}
?>
					</datalist>
				</div>
			</div>
			
        </form>
    </div>    
</div>