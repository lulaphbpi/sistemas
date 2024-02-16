<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarAssinaturaestagiario-f2.php';
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

//$trace=ftrace('fRegistrarTratamento-f1.php','Inicio:'.$usuarioid);
$data=date('Y-m-d');
$horainicial=date('H:i');

$spid=0; $tid=0; $agendaid=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$tid=$_GET['id'];  // questionarioaplicadoid

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
	//$t=ftrace('aqui','1');
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
	//$t=ftrace('aqui','2');

//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: Id '.$id.' não encontrado!'; die('deu merda:'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
//$t=ftrace('aqui','3');

$rhis=flehistoricopaciente($spid, $conefi);

$grupo=$_SESSION['grupo'];	
$t=ftrace('fRegistrarAssinaturaestagiario-f2.php','pessoaid='.$usuarioid.' agendaid='.$agendaid.' grupo='.$grupo);
$tab1=leagendaoperador($usuarioid, $agendaid, $grupo, $conefi);
if($tab1){
	//$t=ftrace('fRegistrarAvaliacaofisica-f1','leuagendaoperador idc='.$idc);
	$servico1=$tab1['servico'];
	$sid=$tab1['servicoid'];
	$data1=formataDataToBr($tab1['data']);
	$hora1=$tab1['horainicial'];
	//$rtab=flequestionarioservico($sid); 
}	

$operacao='Assinar';
$act="registrarAssinaturaestagiario-f2.php?id=$tid";
//$t=ftrace('fRegistrarTratamento-f1.php',' act='.$act);
$historicot=''; 
//$t=ftrace('fRegistrarTratamento-f1.php','statusservicoid='.$statusservicoid);

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
<?php
if($rhis->rowCount()>0){
?>
	<p>Histórico do Paciente:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Id</th>
		<th width='8%'>Data</th>
		<th width='5%'>Hora</th>
		<th width='40%'>Histórico</th>
		<th width='10%'>Assinado</th>
		<th width='10%'>Autorizado</th>
		<th width='5%'>Alt</th>
		<th width='5%'>Del</th>
	</tr>
<?php
foreach($rhis->fetchAll() as $tab) {
		$idt=$tab['id'];
		$datat=formataDataToBr($tab['data']);
		$horat=$tab['hora'];
		$historicot=$tab['historico'];
		//$respass=$tab['denominacaocomum'];

		$rassinatura=leassinantetratamentoid($idt,$conefi);
		$estagiarioassinante=' **EST**';
		$ehass=false;
		if($rassinatura){
			$estagiarioassinante=$rassinatura['estagiarioassinante'];
			$ehass=true;
		}
		$professorautorizador=' **COO**';
		$rautorizador=leautorizadortratamentoid($idt,$conefi);
		$ehprf=false;
		if($rautorizador){
			$professorautorizador=$rautorizador['professorautorizador'];
			$ehprf=true;
		}
		
		$statusagenda=$tab['statusagenda_id'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=registrar&obj=
tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?php echo($idc);?>&idx=<?php echo($idt);?>'><?PHP echo($idt);?></a></td>
					<td><?PHP echo($datat);?></td>
					<td><?PHP echo($horat);?></td>
					<td><?PHP echo($historicot);?></td>
					<?php
if($statusagenda<3){
	if($grupo == 'esa' and !$ehprf){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=assinaturaestagiario&cpl=f2&id=<?PHP echo($idt);?>'><?PHP echo($estagiarioassinante);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($estagiarioassinante);?></td>			
<?php
	}
?>						
<?php
	if($grupo == 'coa' and $ehass and !$ehprf){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=professorautorizador&cpl=f2&id=<?PHP echo($idt);?>'><?PHP echo($professorautorizador);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($professorautorizador);?></td>
<?php
		 }
}
?>

<?php
if($idt>0 and $statusservicoid<4){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=
tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?php echo($idc);?>&idx=<?php echo($idt);?>&del=alt'><?PHP echo('Alterar');?></a></td>
					<td><a href='chameFormulario.php?op=registrar&obj=
tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?php echo($idc);?>&idx=<?php echo($idt);?>&del=del'><?PHP echo('Excluir');?></a></td>
<?php
}
?>
<!--
-->
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
if($statusservicoid < 4)	{
?>	
			<div class="row">
				<div class="form-group col-md-12">
					Assinatura (estagiário):<br>
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
?>
<?php 
}
?>	
			
        </form>
    </div>    
</div>	