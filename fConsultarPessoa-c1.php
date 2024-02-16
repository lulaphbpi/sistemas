<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarPessoa-c1.php';
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

//echo(' inicial:'.$_SESSION['inicial'].'<br>');

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
    if(isset($_get['pesquisa'])){
		$textopesquisa=$_GET['pesquisa'];
	}
	$reclst=fpesquisapessoa_fi($textopesquisa,$conpes,$conefi);
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
			<p>Consultar Pessoas - Digite o nome a pesquisar : </p>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1" > Cadastrar Pessoa<a>
<!--		
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?pesquisa=pacientes" target="_self" > Lista de Pacientes</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01t.php" target="_new" > Lista de Usuários</a>	
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01t.php" target="_new" > Lista de Pacientes</a>
-->
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
		<th width='6%' colspan='2'> &nbsp;&nbsp;&nbsp;Registrar</th>

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
	$cpfbase='';

?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
Pessoa&cpl=p1&id=<?PHP echo($pessoaid);?>'><?PHP echo($pessoaid);?></a></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php $cpfbase=$cpf;echo(fIdentificaCPF($cpfbase,$pessoaid,$conpes,$conefi));?>'"><?PHP echo($cpf);?></a></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($idade);?></td>
		<td><?PHP echo($natureza);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($status);?></td>
		<td><a href='chameFormulario.php?op=registrar&obj=cliente&cpl=p2&id=<?PHP echo($pessoaid);?>'><?PHP echo('Paciente');?></a></td>
		<td><a href='chameFormulario.php?op=registrar&obj=usuario&cpl=u1&id=<?PHP echo($pessoaid);?>'><?PHP echo('Usuário');?></a></td>
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
		<td><a href='consultarPessoa-c1.php'>&nbsp; Nova Consulta | </a>
		<a href='chameFormulario.php?op=consultar&obj=pessoa&cpl=c1&id=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}else{
			$_SESSION['inicial']=0;
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

<!-- Modal -->
<div id="mIdentifica" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Consulta Modal</h4>
      </div>
      <div class="modal-body" id="mresultado">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>

<!--
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
-->