<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarTratamento-f1.php';
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
$oppid=$_SESSION['pessoaid']; // operador-pessoaid do login

$spid=0;
//$trace=ftrace('fRegistrarTratamento-f1.php','Inicio:'.$usuarioid);
$data=date('Y-m-d');
$horainicial=date('H:i');
$historico='';

$spid=0; $agendaid=0;

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid

if(isset($_SESSION['agendaid'])) 
	$agendaid=$_SESSION['agendaid'];
if(isset($_GET['idx']) && empty($_GET['idx']) == false)
	$agendaid=$_GET['idx'];  // agendaid
//$t=ftrace('fRegistrarTratamento-f1.php','agendaid='.$agendaid);

$_SESSION['spid']=$spid;
$grupo=$_SESSION['grupo'];	

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
	$servico=$rpes['servico'];
	$status=$rpes['statussp'];
	$statusservicoid=$rpes['statusservico_id'];
	$dtc=$rpes['data'];
	$datacadastro=formataDataToBr($dtc);
	$diagnostico=$rpes['diagnosticomedico'];
	$motivo=$rpes['motivo'];
	//$t=ftrace('aqui','2');

//	$email=$rpes['email'];
}else{
	$_SESSION['msg']='ERRO FATAL: SPId '.$spid.' não encontrado!'; die('Falhou:'.'ERRO FATAL: Id '.$spid.' não encontrado!');
	return '';
}
//$t=ftrace('aqui','3');

$rhis=flehistoricopaciente($spid, $conefi);

$idt=0;
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idt=$_GET['idc'];  // tratamentoid

$observacao='';
$del='';
$operacao='Registrar Tratamento';
$act="registrarTratamento-f1.php?id=$spid";
if($idt>0){
	$rtr=letratamentoid($idt, $conefi);
	$data=$rtr['data'];
	$horainicial=$rtr['hora'];
	$historico=$rtr['historico'];
	$agendaid=$rtr['agenda_id'];
	$observacao=$rtr['observacoesdoprofessor'];
	$act=$act."&idx=$idt";
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];  
		if($del=='del'){
			$operacao="Confirme Excluir o Tratamento";
			$act=$act."&idc=$agendaid&del=del";
		}elseif($del=='coa'){
			$operacao="Confirme para Autorizar";
			$act="registrarProfessorautorizador-f2.php?id=$spid&idc=$idt&idx=$agendaid";
		}elseif($del=='esa'){
			$operacao="Confirme para Assinar";
			$act="registrarAssinaturaestagiario-f2.php?id=$spid&idc=$idt&idx=$agendaid";
		}elseif($del=='obs'){
			$operacao="Confirme para Registrar Observação";
			$act="registrarObservacaotratamento-f1.php?id=$spid&idc=$idt&idx=$agendaid";
		}else{
			$operacao='Atualizar Tratamento';
			$act=$act."&idc=$agendaid&del=alt";
		}
	}		
}else{
	$act="registrarTratamento-f1.php?id=$spid&idc=$agendaid";
}	
//$t=ftrace('fRegistrarTratamento-f1.php','agendaid='.$agendaid.' act='.$act);

?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Tratamento - Pessoa Id nº <?php echo($pessoaid);?></b>
			<br>

			<?php
				include('include/header-paciente.php');
			?>

			<div class="row">
				<div class="form-group col-md-12">
<?php
if ($idt==0){
if($rhis->rowCount()>0){
?>
	<p>Histórico do Paciente:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Id</th>
		<th width='8%'>Data/Hora</th>
		<th width='40%'>Histórico</th>
		<th width='10%'>Estagiário(a)</th>
		<th width='10%'>Professor(a)</th>
		<th width='3%'>Obs</th>
		<th width='5%'>Exc</th>
	</tr>
<?php
foreach($rhis->fetchAll() as $tab) {
	$epid=$tab['epid'];
	if($epid==$oppid or $grupo=='coa' or $usuarioid=1){
		$idt1=$tab['id'];
		$datat=formataDataToBr($tab['data']);
		$horat=$tab['hora'];
		$datat=$datat.' '.$horat;
		$historicot=$tab['historico'];
		$obs=$tab['observacoesdoprofessor'];
		$agendaid=$tab['agenda_id'];
		$estagiario=$tab['nomesocial'];
		if(strlen($obs)>0){
			$historicot=$historicot."<br><strong><font color='red'>OBS:".$obs."</font></strong>";
			//$t=ftrace('fRegistrarTratamento-f1.php',$historicot);
		}
		//$respass=$tab['denominacaocomum'];

		$rassinatura=leassinantetratamentoid($idt1,$conefi);
		$estagiarioassinante=' ** '.$estagiario.' **';
		$ehass=false;
		if($rassinatura){
			$estagiarioassinante=$rassinatura['estagiarioassinante'].' /<br>Matrícula:'.$rassinatura['matricula'];
			$ehass=true;
		}
		$professorautorizador=' **COO**';
		$rautorizador=leautorizadortratamentoid($idt1,$conefi);
		$ehprf=false;
		if($rautorizador){
			//$professorautorizador=$rautorizador['professorautorizador'];
			$professorautorizador=$rautorizador['professorautorizador'].
			' / CREFITO:'.$rautorizador['crefito'];
			$ehprf=true;
		}
		
		$statusagenda=$tab['statusagenda_id'];
?>				
				<tr>
					<td><a href='chameFormulario.php?op=registrar&obj=
tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?php echo($idt1);?>&del=alt'><?PHP echo($idt1);?></a></td>
					<td><?PHP echo($datat);?></td>
					<td><?PHP echo($historicot);?></td>
					<?php
if($statusagenda<3){
	if($grupo == 'esa' and !$ehprf){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?PHP echo($idt1);?>&idx=<?PHP echo($agendaid);?>&del=esa'><?PHP echo($estagiarioassinante);?></a></td>
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
					<td><a href='chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?PHP echo($idt1);?>&idx=<?PHP echo($agendaid);?>&del=coa'><?PHP echo($professorautorizador);?></a></td>
<?php
	}else{
?>		
					<td><?PHP echo($professorautorizador);?></td>
<?php
	}
	if($grupo == 'coa' and $ehass){
?>					
					<td><a href='chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?PHP echo($idt1);?>&idx=<?PHP echo($agendaid);?>&del=obs'><?PHP echo('Obs');?></a></td>

<?php

	}else{
	?>		
						<td><?PHP echo(' -x ');?></td>
	<?php
	}
}
?>

<?php
if($idt1>0 and $statusservicoid<4){
?>					
<?php
if(!$ehprf){
?>
					<td><a href='chameFormulario.php?op=registrar&obj=
tratamento&cpl=f1&id=<?PHP echo($spid);?>&idc=<?php echo($idt1);?>&idx=<?php echo($agendaid);?>&del=del'><?PHP echo('Excluir');?></a></td>
<?php
}else{
?>
					<td>&nbsp;-</td>
<?php
}
}
?>
<!--
-->
				</tr>
<?php
}
}
?>
    </table> 
    <br>
<?php	
}
}
?>							</div>	
			</div>	

<?php 
if($statusservicoid < 4)	{
	if($del=='coa'){
?>	
		<div class="row">
			<div class="form-group col-md-12">
				Autorização (professor) - Tratamento No. <?php echo($idt);?>:<br>
				<label>Digite sua Identificação:</label>
				<input class="textologin" type="text" name="identificacao" title="Digite sua Identificação" placeholder="Identificacao" value="">
				<br><label>Digite sua senha e, após, clique em Assinar:</label>
				<input class="textologin" type="password" name="senha" id="senha" title="Digite sua Senha" placeholder="Senha" value="">
			</div>	
		</div>	
		<br>
<?php
}elseif($del=='esa'){
?>	
	<div class="row">
	<div class="form-group col-md-12">
		Assinatura (estagiário) - Tratamento No. <?php echo($idt);?>:<br>
		<label>Digite sua Identificação:</label>
		<input class="textologin" type="text" name="identificacao" title="Digite sua Identificação" placeholder="Identificacao" value="">
		<br><label>Digite sua senha e, após, clique em Assinar:</label>
		<input class="textologin" type="password" name="senha" id="senha" title="Digite sua Senha" placeholder="Senha" value="">
	</div>	
	</div>	
<?php
}elseif($del=='obs'){
	?>	
		<div class="row">
		<div class="form-group col-md-12">
			<label>Observações) - Tratamento No. <?php echo($idt);?>:</label><br>
			<textarea name="observacao" rows="3" cols="100"><?php echo($observacao);?></textarea>
		</div>	
		</div>	
	<?php
}else{
?>	
			<p>Histórico Nº :<?php echo($idt); ?></p>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Data:</label>
					<input type="date" id="data" name="data" size="10" maxlength="10" class="form-control" value="<?php echo($data);?>">
				</div>
				<div class="form-group col-md-2">
					<label>Hora Inícial:</label>
					<input type="time" id="horainicial" name="horainicial" size="10" maxlength="10" class="form-control" value="<?php echo($horainicial);?>">
				</div>
				<div class="form-group col-md-7">
					<label>Histórico:</label><br>
					<textarea name="historico" rows="6" cols="70" required><?php echo($historico);?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label>Status a Aplicar:</label>
					<select name="statusservico_id" class="form-control" style="font-size:12px;" >
						<option value="" selected="selected"></option>
<?php 
			$tabela = 'statusservico';
			$ordem = 'id';
			$statusinicial=3;
			$rtab=fletabela($tabela,$ordem,$conefi);
			if($rtab) {
				if($rtab->rowCount()>0) {
					foreach($rtab->fetchAll() as $tab) { 
					if($tab['id']>2){
?>
						<option value="<?php echo($tab['id']); ?>" <?php if($tab['id']==$statusinicial){echo("selected='selected'");} ?>> <?php echo(fstring($tab['descricao'],60)); ?></option>
<?php
					}
					}
				}
			}
?>
					</select>

				</div>
				<!--
				<div class="form-group col-md-3">
					<label>Assinatura:</label>
					<input type="text" id="assinantenome" name="assinantenome" size="50" maxlength="50" class="form-control" value="<?php echo($horainicial);?>">
				</div>
				-->
			</div>
			<br>
<?php
}
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