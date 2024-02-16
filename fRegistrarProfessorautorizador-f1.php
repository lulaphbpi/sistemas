<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$conefi=conexao('efisio');
$conpes=conexao('pessoal');

$rotina='fRegistrarAssinaturaestagiario-f1.php';
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

$qaid=0; $agendaid=0;

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$qaid=$_GET['id'];  // questionarioaplicadoid

if($qaid>0){
	$recqa=lequestionarioaplicadoid($qaid,$conefi);
	$agendaid=$recqa['agenda_id'];
	$_SESSION['agendaid']=$agendaid;
}else{
	$_SESSION['msg']='ERRO FATAL: questionário aplicado '.$qaid.' não encontrado!'; die('deu ruim:'.'ERRO FATAL: Id '.$qaid.' não encontrado!');
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
	$status=$rpes['statusservico'];
	$statusservicoid=$rpes['statusservico_id'];
	$servico=$rpes['servico'];
	$rqa=flequestionarioaplicado($agendaid);
//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: servicopessoa_id '.$agendaid.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$spid.' não encontrado!');
	return '';
}

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

$act="registrarProfessorautorizador-f1.php?id=$qaid";

//$t=ftrace('fRegistrarAvaliacaofisica-f1.php',$act);
//die('fim');
?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Avaliação Física - Pessoa <?php echo($pessoaid);?></b>
			<br>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Serviço: </label>
					<p><?php echo($servico);?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Status: </label>
					<p><?php echo($status);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data/Hora: </label>
					<p><?php echo($data1.' '.$hora1);?></p>
				</div>
<!--			<div class="form-group col-md-1">
					<label>Hora: </label>
					<p><?php //echo($hora1);?></p>
				</div> -->
			</div>	
			<div class="row">
				<div class="form-group col-md-12">
<?php
if($rqa->rowCount()>0){
?>
	<p>Questionários Aplicado:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Id</th>
		<th width='15%'>Questionário</th>
		<th width='15%'>Responsável</th>
		<th width='10%'>Fisioterapia</th>
		<th width='10%'>Status</th>
		<th width='10%'>Cadastrado</th>
		<th width='10%'>Tipo</th>
		<th width='10%'>Agenda</th>
		<th width='10%'>Realizado</th>
		<th width='10%'>Assinado</th>
		<th width='10%'>Autorizado</th>
	</tr>
<?php
foreach($rqa->fetchAll() as $tab) {
		$qaid=$tab['id'];
		$titulo1=$tab['titulo'];
		$sigla1=$tab['sigla'];
		$operador1=$tab['operador'];
		$servico1=$tab['servico'];
		$dataagenda1=formataDataToBr($tab['dataagenda']);
		$tipodeagenda1=$tab['tipodeagenda'];
		$statusagenda1=$tab['statusagenda'];
		$realizadoem1=formataDataToBr($tab['data']);
		$rassinatura=leassinantequestionarioaplicadoid($qaid,$conefi);
		$estagiarioassinante=' **EST**';
		$ehass=false;
		if($rassinatura){
			$estagiarioassinante=$rassinatura['estagiarioassinante'];
			$ehass=true;
		}
		$professorautorizador=' **COO**';
		$rautorizador=leautorizadorquestionarioaplicadoid($qaid,$conefi);
		if($rautorizador){
			$professorautorizador=$rassinatura['professorautorizador'];
		}
		$status1=$tab['situacao'];
		$qsid1=$tab['questionarioservico_id'];
		//$ativo1=$tab['spativo'];
		$agendaid=$tab['agenda_id'];
		$statusagenda=$tab['statusagenda_id'];
?>				
				<tr>
					<td><a href='registrarAvaliacaofisica-f1.php?id=<?PHP echo($agendaid);?>&idx=<?php echo($qsid1);?>'><?PHP echo($agendaid);?></a></td>
					<td><?PHP echo($sigla1);?></td>
					<td><?PHP echo($operador1);?></td>
					<td><?PHP echo($servico1);?></td>
					<td><?PHP echo($status1);?></td>
					<td><?PHP echo($dataagenda1);?></td>
					<td><?PHP echo($tipodeagenda1);?></td>
					<td><?PHP echo($statusagenda1);?></td>
					<td><?PHP echo($realizadoem1);?></td>
<?php
if($statusagenda<2){
	if($grupo == 'esa'){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=assinaturaestagiario&cpl=f1&id=<?PHP echo($qaid);?>'><?PHP echo($estagiarioassinante);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($estagiarioassinante);?></td>			
<?php
	}
?>						
<?php
	if($grupo == 'coa' and $ehass){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=professorautorizador&cpl=f1&id=<?PHP echo($qaid);?>'><?PHP echo($professorautorizador);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($professorautorizador);?></td>
<?php
		 }
}
?>
				</tr>
<?php
}
?>
    </table> 
    <br>
<?php	
}
?>							</div>	
			</div>	
<?php	
if($statusservicoid<4){
?>	
			<div class="row">
				<div class="form-group col-md-12">
					Autorização (professor) - Questionário No. <?php echo($qaid);?>:<br>
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