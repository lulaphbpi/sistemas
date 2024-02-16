<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarAgendamento-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']='';
}

$_SESSION['tipodeagendaid']=1;

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$textopesquisa=" ";
$ord=0;

$textopesquisa=$_SESSION['texto'];
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$vez=0;
	if($textopesquisa<>$_POST['textopesquisa']){
//		echo('aqui 1'.$textopesquisa);
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
//		echo('aqui 2:'.$textopesquisa);
		$ord=$_SESSION['inicial'];
	}
}
$servicoid=$_SESSION['servicoid'];
$rser=leservicoid_fi($servicoid, $conefi);
$descricaoservico='Serviço Id '.$rser['id'].' - '.$rser['sigla'].' - '.$rser['descricao'];
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=fpesquisaservicopessoacadastrada_fi($textopesquisa, $servicoid, $conefi);
	$totallinhas=$reclst->rowCount();
//	echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
	$leu=true;
	$ord=$_SESSION['inicial'];
	$_SESSION['texto']=$textopesquisa;
}	
if(!$leu){$_SESSION['rotina']='xxx';}
// Área de PK
$pvez=true;

?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Agendamento - Digite o nome do Paciente a pesquisar : </p>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1" > Cadastrar Pessoa<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01t.php" target="_new" > Relação Geral de Pacientes</a>
			</div>
		</form>
<?php
if($totallinhas>0){
?>
	<br>
	<p>Resultado da Consulta:</p>
	<p><?php echo($descricaoservico); ?></p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>SPId</th>
		<th width='36%'>Paciente</th>
		<th width='4%'>Gên</th>
		<th width='05%'>Idade</th>
		<th width='12%'>Fone</th>
		<th width='8%'>Data</th>
		<th width='10%'>Status</th>
		<th width='15%' colspan='2'> &nbsp;&nbsp;&nbsp;Agendar</th>

	</tr>
<?php
if($_SESSION['inicial']>0){
	$contador=0;
	while($contador<$_SESSION['inicial']){
		$rec=$reclst->fetch();
		$contador++;
	}
}
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$spid=$rec['id'];
	$pessoaid = $rec['pessoa_id'];
	$nome = $rec['nome'];
	$pn=fnumero($pessoaid,4).'-'.$nome;
	//$nome = $rec['nomesocial'];
	$sexo = $rec['sexo'];
	$fone = $rec['fone'];
	$idade = idade($rec['datanascimento']);
	$servico = $rec['servico'];
	$data = formataDataToBr($rec['data']);
	$status = $rec['status'];
	$_SESSION['tipodeagendaid']=1;
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><?PHP echo($spid);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=
cliente&cpl=p2&id=<?PHP echo($pessoaid);?>'><?PHP echo($pn);?></a></td>
		<td><?PHP echo($sexo);?></td>
		<td><?PHP echo($idade);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($data);?></td>
		<td><?PHP echo($status);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=agendamento&cpl=f1&id=<?PHP echo($spid);?>'><?PHP echo('Ver Agenda');?></a></td>
    </tr>
<?php
	}
}
?>
	</table>

	<! -- Início declaração modal -->
	<! -- Fim da declaração modal -->
	
	<table class="tabela1">	
	<tr>
		<td>
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		$_SESSION['inicial']=0;
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=agendamento&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<div>
<br><br>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($textopesquisa);?>'</strong></p>
</div>
<?php

}
}
?>
</div>
</div>
</div>
	<div class="modal fade" id="mIdentifica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<div id="mresultado">xx
					</div>
					<?php //echo(fIdentificaCPF($cpf,$conpes));?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
				</div>		
			</div>		
		</div>		
	</div>		
