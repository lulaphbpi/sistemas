<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarEstagiario-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']='';
}
//echo('rotinaanterior:'.$rotinaanterior.' vez:'.$vez.'<br>');

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
//		echo('aqui 1'.$textopesquisa);
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
//		echo('aqui 2:'.$textopesquisa);
		$ord=$_SESSION['inicial'];
	}
}
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=fpesquisaestagiario_fi($textopesquisa,$conefi);
	$totallinhas=$reclst->rowCount();
//	echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
	$leu=true;
	$ord=$_SESSION['inicial'];
	$_SESSION['texto']=$textopesquisa;
}	
if(!$leu){$_SESSION['rotina']='xxx'; 
//	echo('<br>nao leu<br>');
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
			<p>Digite o texto a pesquisar no nome (Arquivo de Estagiários): </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=consultar&obj=pessoa_estagiario&cpl=f1" > Cadastrar Estagiário<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="restagiario01.php" target="_new" > Relação Geral de Estagiários</a>
			</div>
			<br><br>
		</form>
	<br>
<?php
if($totallinhas>0){
?>
	<p>Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width='5%'>Ord</th>
		<th width='5%'>Id</th>
		<th width='10%'>Matrícula</th>
		<th width='30%'>Nome</th>
		<th width='10%'>CPF</th>
		<th width='5%'>Ativo?</th>
		<th width='10%'>Ação</th>
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
	$estagiarioid = $rec['id'];
	$pid = $rec['pessoa_id'];
	$matricula = $rec['matricula'];
	$nome = $rec['nome'];
	$cpf = $rec['cpf'];
	$ativo=$rec['ativo'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
estagiario&cpl=f1&id=<?PHP echo($pid);?>&idc=<?PHP echo($estagiarioid);?>&del=atz'><?PHP echo($estagiarioid);?></td>
		<td><?PHP echo($matricula);?></td>
		<td><?PHP echo($nome);?></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php $cpfbase=$cpf;echo(fIdentificaCPF($cpfbase,$pid,$conpes,$conefi));?>'"><?PHP echo($cpf);?></a></td>
		<td><?PHP echo('&nbsp;&nbsp;'.$ativo);?></td>
<?php 
if($ativo=='S'){
?>			
		<td><a href='chameFormulario.php?op=cadastrar&obj=
estagiario&cpl=f1&id=<?PHP echo($pid);?>&idc=<?PHP echo($estagiarioid);?>&del=<?php echo('des');?>'><?PHP echo('Desativa');?></a></td>
<?php 
}else{
?>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
estagiario&cpl=f1&id=<?PHP echo($pid);?>&idc=<?PHP echo($estagiarioid);?>&del=<?php echo('ati');?>'><?PHP echo('Ativa');?></a></td>
<?php
}
?>
    </tr>
<?php
	}
}
?>
	</table>


	<table class="tabela1">	
	<tr>
		<td>
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		if($totallinhas>$ord) {
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=estagiario&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($textopesquisa);?>'</strong></p>
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
					<?php //echo(fIdentificaCPF($cpfbase,0,$conpes,$conefi));?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
				</div>		
			</div>		
		</div>		
	</div>		
