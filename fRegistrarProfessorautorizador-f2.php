<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarProfessorautorizador-f2.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];

$spid=0; $tid=0; $agendaid=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$tid=$_GET['id'];  // tratamentoid

if($tid>0){
	$rect=letratamentoid($tid,$conefi);
	$agendaid=$rect['agenda_id'];
	$_SESSION['agendaid']=$agendaid;
}else{
	$_SESSION['msg']='ERRO FATAL: tratamento '.$tid.' não encontrado!'; die('Ai! Deu ruim:'.'ERRO FATAL: Id '.$tid.' não encontrado!');
	return '';
}
	
$ragenda=leagenda_fi($agendaid,$conefi);
if($ragenda){
	$spid=$ragenda['servicopessoa_id'];
}

$statusservicoid=0;
$rpes=leservicopessoaid_fi($spid,$conefi);
if($rpes){
	$pessoaid=$rpes['pessoa_id'];
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome'];
	$datanascimento=$rpes['datanascimento'];
	$idade = idade($rpes['datanascimento']);
	$dtn=formataDataToBr($datanascimento);
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$status=$rpes['statussp'];
	$statusservicoid=$rpes['statusservico_id'];
}else{
	$_SESSION['msg']='ERRO FATAL: servicopessoa_id '.$agendaid.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$spid.' não encontrado!');
	return '';
}

$rhis=flehistoricopaciente($spid, $conefi);

$grupo=$_SESSION['grupo'];	
//$t=ftrace('fRegistrarAvaliacaofisica-f1.php','pessoaid='.$usuarioid.' agendaid='.$id.' grupo='.$grupo);
$tab1=leagendaoperador($usuarioid, $agendaid, $grupo, $conefi);
if($tab1){
	//$t=ftrace('fRegistrarAvaliacaofisica-f1','leuagendaoperador idc='.$idc);
	$servico1=$tab1['servico'];
	$sid=$tab1['servicoid'];
	$data1=formataDataToBr($tab1['data']);
	$hora1=$tab1['horainicial'];
	$rtab=flequestionarioservico($sid); 
}	

$operacao='Assinar';

$act="registrarProfessorautorizador-f2.php?id=$tid";
$historicot=''; 
//$t=ftrace('fRegistrarAvaliacaofisica-f1.php',$act);
//die('fim');
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Tratamento - Pessoa <?php echo($pessoaid);?></b>
			<br>
			<div class="row">
				<div class="form-group col-md-1">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Serviço: </label>
					<p><?php echo($servico1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Status: </label>
					<p><?php echo($status);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Data: </label>
					<p><?php echo($data1);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Hora: </label>
					<p><?php echo($hora1);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-12">
				</div>	
			</div>	
<?php	
if($statusservicoid<4){
?>	
			<div class="row">
				<div class="form-group col-md-12">
					Autorização (professor) - Tratamento No. <?php echo($tid);?>:<br>
					<label>Digite sua Identificação:</label>
				    <input class="textologin" type="text" name="identificacao" title="Digite sua Identificação" placeholder="Identificacao" value="">
					<br><label>Digite sua senha e, após, clique em Assinar:</label>
					<input class="textologin" type="password" name="senha" id="senha" title="Digite sua Senha" placeholder="Senha" value="">
				</div>	
			</div>	
			<br>
<?php
if(!$operacao==''){
?>			
			<div class="row">
				<div class="form-group col-md-10">
				<button type="submit" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
<?php
}
}
?>			
        </form>
    </div>    
</div>	