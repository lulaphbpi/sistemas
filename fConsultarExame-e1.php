<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
$ord=0;
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisaexame($tx,$conacl);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if(isset($_GET['id']) && empty($_GET['id']) == false){
		if($_SESSION['inicial']>0){
			$ord=$_GET['id'];
			$tx=$_SESSION['texto'];
			$reclst=fpesquisaexame($tx,$conacl);
			$totallinhas=$reclst->rowCount();
			$leu=true;
		}else{
			$tx=$_SESSION['texto'];
			$reclst=fpesquisaexame($tx,$conacl);
			$totallinhas=$reclst->rowCount();
			$leu=true;
			$_SESSION['inicial']=0;
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
			<p>Digite o texto a pesquisar (arquivo de Exames): </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=exame&cpl=e1" > Cadastrar Exame<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rexa01.php" target="_new" > Relação Geral de Exames</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rcompexa01.php" target="_new" > Relação  de Componentes por Exame</a>
			</div>
			<br>
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
		<th width='10%'>Sigla</th>
		<th width='38%'>Descrição</th>
		<th width='12%'>Amostra</th>
		<th width='20%'>Observação</th>
		<th width='10%'>Comp</th>
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
	$id = $rec['id'];
	$descricao = $rec['descricao'];
	$sigla = $rec['sigla'];
	$tipodeamostra=$rec['tipodeamostra'];
	$observacao=$rec['observacao'];
	//echo("Contador:".$contador." Maxlinhas:".$maxlinhas."<br>" );
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
exame&cpl=e1&id=<?PHP echo($id);?>'><?PHP echo($id);?></td>
		<td data-toggle="modal" data-target="#mIdentifica"><a href="#mIdentifica" onclick="javascript: mresultado.innerHTML = '<?php echo(fIdentificaExame($id,$conacl));?>'"><?PHP echo($sigla);?></a></td>
		<td><?PHP echo($descricao);?></td>
		<td><?PHP echo($tipodeamostra);?></td>
		<td><?PHP echo($observacao);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
componentedeexame&cpl=e1&id=<?PHP echo($id);?>'><?PHP echo('Comp Exa');?></a></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
exame&cpl=e1&id=<?PHP echo($id);?>&idc=S'>Del</a></td>
    </tr>
<?php
	}
}	//die("Contador:".$contador." Maxlinhas:".$maxlinhas."<br>" );

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
			$_SESSION['inicial']=$ord;
		?>
		<td><a href='chameFormulario.php?op=consultar&obj=exame&cpl=e1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
