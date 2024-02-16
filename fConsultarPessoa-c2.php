<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conexao=conexao('pessoal');
$conpsi=conexao('psicoweb');

$msg="";
$msg=$_SESSION['msg'];
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=true;
$contador=0;

// Área de PK
?>

<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="consultapessoa-c1.php" method="post" id="iformulario" class="formulario">
<?php 
if(!$msg==''){	
?>
			<div id="lblerro"><?php echo($msg); ?></div><br>
            <br>
<?php
}
?>			
			<p>Digite o texto a pesquisar no nome: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rpessoal01.php" target="_new" > Relação Geral de Pessoal</a>
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
		<th width='18%'>Natureza</th>
		<th width='12%'>CPF</th>
		<th width='25%'>Nome</th>
		<th width='12%'>Fone</th>
		<th width='10%'>E-mail</th>
	<!--	<th width='10%'>Nível</th>  -->
		<th width='10%'>Identificação</th>
		<th width='3%'>At?</th>

	</tr>
<?php
if($_SESSION['inicial']>1){
	$contador=0;
	while($contador<$_SESSION['inicial']){
		$rec=$reclst->fetch();
		$contador++;
	}
}
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
//foreach($reclst->fetchAll() as $rec) {
	$rec=$reclst->fetch();
	$ord = $rec['ord'];
	$pessoaid = $rec['pessoaid'];
	$natureza = $rec['natureza'];
	$cpf = $rec['cpf'];
	$nome = $rec['nome'];
	$fone = $rec['fone'];
	$email = $rec['email'];
	$nivel = $rec['nivel'];
	$identificacao = $rec['identificacao'];
	$ativo = $rec['ativo'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=edita&obj=
Pessoa&id=<?PHP echo($pessoaid);?>'><?PHP echo($pessoaid);?></td>
		<td><?PHP echo($natureza);?></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php echo(fidentificapessoaacl($cpf,$pessoaid,$conpes,$conacl));?>'"><?PHP echo($cpf);?></a></td>
		<td><?PHP echo($nome);?></td>
		<td><?PHP echo($fone);?></td>
		<td><?PHP echo($email);?></td>
	<!--	<td><?PHP echo($nivel);?></td>  -->
		<td><?PHP echo($identificacao);?></td>
		<td><?PHP echo($ativo);?></td>

    </tr>
<?php
}
?>
	</table>

	<! -- Início declaração modal -->
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
	<! -- Fim da declaração modal -->
	
	<table class="tabela1">	
	<tr>
		<td>
			Listados <?php echo($ord);?>/<?php echo($totallinhas);?> dos registros pesquisados
		</td>
		<?php
		if($totallinhas>$ord) {
			$inicial=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultarpessoa2&obj=<?php echo($ord); ?>'>Próximos</a></td>
		<?php	
		}
		?>
	</tr>	
	</table>
<?php
}else{
	if($leu) {
?>
<p><strong>Sua consulta não retornou nenhum registro: '<?php echo($tx);?>'</strong></p>
<?php

}
}
?>
</div>
</div>
</div>
