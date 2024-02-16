<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");
$rotina='fConsultarAgendamento-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
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
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisaservicopessoaemtratamento_fi($tx);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount(); //die('t='.$totallinhas);
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if(isset($_GET['id']) && empty($_GET['id']) == false){
		if($_SESSION['inicial']>0){
			$ord=$_GET['id'];
			$tx=$_SESSION['texto'];
			$reclst=fpesquisaservicopessoaemtratamento_fi($tx);
			$totallinhas=$reclst->rowCount();
			$leu=true;
		}
	}
}	

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
			<p>Agendamento de Tratamento - Digite o nome do Paciente a pesquisar : </p>
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
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>Id</th>
		<th width='25%'>Nome</th>
		<th width='5%'>Sexo</th>
		<th width='05%'>Idade</th>
		<th width='12%'>Fone</th>
		<th width='15%'>Serviço</th>
		<th width='15%'>Status</th>
		<th width='6%' colspan='2'> &nbsp;&nbsp;&nbsp;Agendar</th>

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
	$sexo = $rec['sexo'];
	$fone = $rec['fone'];
	$idade = idade($rec['datanascimento']);
	$servico = $rec['servico'];
	$status = $rec['status'];
	$_SESSION['tipodeagendaid']=1;
	$agendaid=$rec['agendaid'];
	$_SESSION['agendaid']=$agendaid;
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=
cliente&cpl=p2&id=<?PHP echo($pessoaid);?>'><?PHP echo($pessoaid);?></a></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($sexo);?></td>
		<td><?PHP echo($idade);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($servico);?></td>
		<td><?PHP echo($status);?></td>
		<td><a href='chameFormulario.php?op=agendar&obj=tratamento&cpl=f1&id=<?PHP echo($spid);?>'><?PHP echo('Tratamento');?></a></td>
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
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($tx);?>'</strong></p>
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
