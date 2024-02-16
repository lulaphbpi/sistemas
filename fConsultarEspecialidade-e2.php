<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$_SESSION['time']=date("Y-m-d H:i:s");
$rotina='fConsultarEspecialidade-e2.php';
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
$maxlinhas=$_SESSION['MaxLinhas'];
$totallinhas=0;
$leu=false;
$contador=0;
if(isset($_POST['textopesquisa']) && empty($_POST['textopesquisa']) == false){
	$tx=$_POST['textopesquisa'];
	if(strlen($tx)>1)
		$tx=trim($tx);
	$reclst=fpesquisadescricao('especialidade',$tx,$conacl);
	if(!$reclst)
		die($_SESSION['msg']);
	$totallinhas=$reclst->rowCount();
	$leu=true;
	$_SESSION['texto']=$tx;
	$_SESSION['inicial']=0;
}else{
	if($_SESSION['inicial']>0){
		$tx=$_SESSION['texto'];
		$reclst=fpesquisadescricao('especialidade',$tx,$conacl);
		$totallinhas=$reclst->rowCount();
		$leu=true;
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
			<p>Digite o texto a pesquisar no nome (Arquivo de Especialidades): </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value=" " />
			<button type="button" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=especialidade&cpl=e2" > Cadastrar Especialidade<a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="respecialidade01.php" target="_new" > Relação Geral de Especialidades</a>
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
		<th width='40%'>Descricao</th>
	</tr>
<?php
if($_SESSION['inicial']>0){
	$contador=0;
	while($contador<$_SESSION['inicial']){
		$rec=$reclst->fetch();
		$contador++;
	}
	$ord=$contador;
}
$contador=0;
while ($contador<$maxlinhas){
	$contador++;
	$rec=$reclst->fetch();
	if($rec){
	$ord = $ord+1;
	$descricao = $rec['descricao'];
	$id = $rec['id'];
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
especialidade&&cpl=e2&id=<?PHP echo($id);?>'><?PHP echo($id);?></td>
		<td><?PHP echo($descricao);?></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=especialidade&cpl=e2&id=<?php echo($ord); ?>'>Próximos</a></td>
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
