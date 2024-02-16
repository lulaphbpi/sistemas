<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
$conefi=conexao('efisio');

$_SESSION['time']=date("Y-m-d H:i:s");

$vez=0;
$rotina='fConsultarNiveldousuario-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$vez=1;
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
	$_SESSION['texto']=' ';
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
if($vez==0){	
//	echo('aqui 3:'.$textopesquisa);
	$reclst=fpesquisadescricao('niveldousuario',$textopesquisa,$conefi);
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

<div class="areatrabalho">
    <div class="formularioEntrada">
	<div class="areareduzida">
        <form action="" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p>Nível do Usuário - Digite o texto a pesquisar: </p><br>
			<div class="input0">
			<input class="inputpesquisa" type='text' name='textopesquisa' id='ipesquisa' value="<?php echo($textopesquisa);?>" />
			<button type="submit" id="ibotao" class="lupa"></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=cadastrar&obj=niveldousuario&cpl=f1" > Cadastrar Nível do Usuário</a>
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
		<th width='30%'>Descrição</th>
		<th width='5%'>Exc</th>
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
?>
   	<tr>
		<td><?PHP echo($ord);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
niveldousuario&cpl=f1&id=<?PHP echo($id);?>'><?PHP echo($id);?></td>
		<td><?PHP echo($descricao);?></td>
		<td><a href='chameFormulario.php?op=cadastrar&obj=
niveldousuario&cpl=f1&id=<?PHP echo($id);?>&del=<?php echo('del');?>'><?PHP echo('Exc');?></a></td>
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
		<td><a href='chameFormulario.php?op=consultar&obj=niveldousuario&cpl=f1&id=<?php echo($ord); ?>'>Próximos</a></td>
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
