<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;

$textopesquisa=$_SESSION['texto'];
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisapessoa_fi($tx, $conpes, $conefi);
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
			$reclst=fpesquisapessoa_fi($tx, $conpes, $conefi);
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
			<p>Cadastro de COORDENADORES DE SERVIÇO</p>
			<p>Digite o nome ou parte do nome do Coordenador a ser cadastrado: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1" > Cadastrar Pessoa<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01t.php" target="_new" > Relação Geral de Coordenadores</a>
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
		<th width='10%'>CPF</th>
		<th width='25%'>Nome</th>
		<th width='05%'>Idade</th>
		<th width='15%'>Natureza</th>
		<th width='12%'>Fone</th>
		<th width='15%'>Status</th>
		<th width='5%'>Registrar</th>

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
	$pessoaid = $rec['pessoaid'];
	if(empty($rec['nivel']))
		$natureza = $rec['natureza'];
	else
		if(empty($rec['natureza']))
			$natureza = $rec['nivel'];
		else
			$natureza = $rec['natureza'].' - '.$rec['nivel'];
	$cpf = $rec['cpf'];
	if(empty($cpf))
		$cpf='00000000000';
	$nome = $rec['nome'];
	$fone = $rec['fone'];
	$email = $rec['email'];
	$nivel = $rec['nivel'];
	$identificacao = $rec['identificacao'];
	$ativo = $rec['ativo'];
	$cartaosus = $rec['cartaosus'];
	$idade = idade($rec['datanascimento']);
	$status = $rec['status'];

?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
Pessoa&cpl=p1&id=<?PHP echo($pessoaid);?>'><?PHP echo($pessoaid);?></a></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php //echo(fidentificapessoanae($cpf,$pessoaid,$conpes,$conefi));?>'"><?PHP echo($cpf);?></a></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($idade);?></td>
		<td><?PHP echo($natureza);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($status);?></td>
		<?php
		if(left($nivel,3)=='Usu'){
		?>	
		<td><a href='chameFormulario.php?op=cadastrar&obj=coordenadordeservico&cpl=f1&id=<?PHP echo($pessoaid);?>'><?PHP echo('Cordenador de Serviço');?></a></td>
		<?php
		}
		?>
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
		<td><a href='chameFormulario.php?op=consultar&obj=pessoa_coordenadordeservico&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
