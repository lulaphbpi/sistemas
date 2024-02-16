<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$confun=conexao('funcional');

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarMensagem-m1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']='';
}
//$t=ftrace('fConsultarMensagem-m1.php','inicio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;

$ident=$_SESSION['identificacao'];
$textopesquisa=$_SESSION['texto'];
if(isset($_POST['textopesquisa'])){//echo('tem post de textopesquisa');
//if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$vez=0;
	if($textopesquisa<>$_POST['textopesquisa']){
	//	echo('aqui 1'.$textopesquisa);
		$textopesquisa=trim($_POST['textopesquisa']);
		$_SESSION['inicial']=0;
	}else{
//		echo('aqui 2:'.$textopesquisa);
		$ord=$_SESSION['inicial'];
	}
}
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=fpesquisamensagem($textopesquisa,$ident,$confun);
	$totallinhas=$reclst->rowCount();
//	echo('aqui 3:'.$textopesquisa.' '.$totallinhas);
	$leu=true;
	$ord=$_SESSION['inicial'];
	$_SESSION['texto']=$textopesquisa;
}	
if(!$leu){$_SESSION['rotina']='xxx'; 
	//echo('<br>nao leu<br>');
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
			<p>Digite o texto a pesquisar na mensagem (Arquivo de Mensagens): </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=enviar&obj=mensagem&cpl=m1" > Enviar Mensagem<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rmensagem.php" target="_new" > Relação Mensagens</a>
			</div>
		</form>
<?php
if($totallinhas>0){
?>
	<br>
	<p>Resultado da Consulta:</p>
	<table class="tabela1">
	<tr>
		<th width="4%">Id</th>
		<th width="12%">Assunto</th>
		<th width="10%">Data Envio</th>
		<th width="20%">Origem/Destino</th>
		<th width="30%">Mensagem</th>
		<th width="10%">Leitura</th>
		<th width="14%">Status</th>
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
	$msgid = $rec['id'];
	$identificacao_origem = $rec['identificacao_origem'];
	$identificacao_destino = $rec['identificacao_destino'];
	$assunto = $rec['assunto'];
	$status = $rec['status'];
	$data_envio = formataDataHora($rec['data_envio']);
	$data_leitura = formataDataHora($rec['data_leitura']);
	$mensagem = $rec['mensagem'];

?>
   	<tr>
		<td><a href='chameFormulario.php?op=ler&obj=
mensagem&cpl=m1&id=<?PHP echo($msgid);?>'><?PHP echo($msgid);?></a></td>
		<td><?PHP echo($assunto);?></td>
		<td><?PHP echo($data_envio);?></td>
		<td><?PHP echo(' de '.trim($identificacao_origem).' para '.trim($identificacao_destino));?></td>
		<td><textarea name="msg" rows="4" cols="41"><?PHP echo($mensagem);?></textarea></td>
<!--		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php echo('');?>'"><?PHP echo('');?></a></td>  -->
		<td><?PHP echo($data_leitura);?></td>
		<td><?PHP echo($status);?></td>
    </tr>
<?php
	}
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
					<?php echo(''); //echo(fIdentificaCPF($cpf,$conpes));?>
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
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=mensagem&cpl=m1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
