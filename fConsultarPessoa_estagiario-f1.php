<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$vez=0;
$rotina='fConsultarPessoa_estagiario-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']='';
}

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
if(isset($_POST['textopesquisa'])){
	$vez=0;
	if($textopesquisa<>$_POST['textopesquisa']){
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
		$ord=$_SESSION['inicial'];
	}
}
if($vez==0){	
	$reclst=fpesquisapessoaestagiario_fi($textopesquisa,$conefi);
	$totallinhas=$reclst->rowCount();
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
			<p>Cadastro de ESTAGIÁRIOS (Arquivo de Usuários)</p>
			<p>Digite o nome ou parte do nome do estagiario a ser cadastrado: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1" > Cadastrar Pessoa<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01t.php" target="_new" > Relação Geral de Estagiários</a>
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
		<th width='10%'>Data Nasc</th>
		<th width='12%'>Fone</th>
		<th width='10%'>Usuário Ativo?</th>
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
	$estagiarioid=0;
	$rest=leestagiarioporpessoaid_fi($pessoaid, $conefi);
	if($rest){$estagiarioid=$rest['id'];}
	$cpf = $rec['cpf'];
	if(empty($cpf))
		$cpf='00000000000';
	$nome = fPrimeiraletramaiuscula($rec['nome']);
	$fone = $rec['fone'];
	//$email = $rec['email'];
	//$nivel = $rec['nivel'];
	//$identificacao = $rec['identificacao'];
	$ativo = $rec['ativo'];
	//$cartaosus = $rec['cartaosus'];
	//$idade = idade($rec['datanascimento']);
	$dtn = formataDataToBr($rec['datanascimento']);
	$status = $rec['situacaoid'];

?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
Pessoa&cpl=p1&id=<?PHP echo($pessoaid);?>'><?PHP echo($pessoaid);?></a></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php //echo(fidentificapessoanae($cpf,$pessoaid,$conpes,$conefi));?>'"><?PHP echo($cpf);?></a></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($dtn);?></td>
		<td><?PHP echo($fone);?></td>
<!--		<td><?PHP echo($status);?></td> -->
		<td><?PHP echo($ativo);?></td> 
<td><a href='chameFormulario.php?op=cadastrar&obj=estagiario&cpl=f1&id=<?PHP echo($pessoaid);?>&idc=<?PHP echo($estagiarioid);?>'><?PHP echo('Estagiário');?></a></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=pessoa_estagiario&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
