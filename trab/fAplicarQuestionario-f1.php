<?php

if(!isset($_SESSION)) {session_start();}

include('inicio.php');
include('../include/sa000.php');
$conefe=conexao('efisio');
$conque=conexao('questionario');

$rotina='fRegistrarAvaliacaofisica-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

if(isset($_POST['questionarioservico_id']) && empty($_POST['questionarioservico_id']) == false)
	$qsid=$_POST['questionarioservico_id']; 

$rqs=lequestionarioservico($qsid);
$qid=$rqs['questionario_id'];
$rq=lequestionario($qid);
$titulo=$rq['titulo'];
$rquestao=flequestao($qid);
?>

<div class="areatrabalho">
    <div class="formularioEntrada">
		<form action="<?php echo($act);?>" method="post" id="iformulario" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<b>Título : <?php echo();?></b>
			<br>
			<div class="row">
				<div class="form-group col-md-5">
					<label>Aplicação do Questionário de número <?php echo($qid);?></label><br>
				</div>
			</div>
			<br>	
			<div class="row">
				<div class="form-group col-md-5">
					<button type="button" id="ibformulario" style="width:90;height:20" class="btn btn-primary btn-block"> <?php echo($operacao);?> </button><br>
				</div>
			</div>	
		</form>
<!--		<p><a href='chameFormulario.php?op=consultar&obj=tipodeagenda&cpl=f1&idx=<?PHP echo($tx);?>'>Retorna Consulta</a>	</p>
-->		
	</div>
</div>	
