<?php
include('inicio.php');
include('../include/sa000.php');
$conefi=conexao('efisio');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['identificacao'];

$id=0; $idc=0;
$msg='';
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$pid=$_GET['id'];

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

$trace=ftrace('cadastrarFisioterapeuta-f1.php', 'id='.$pid.'  idc='.$idc);
//$nome=addslashes($_POST['nome']);
//$crm=addslashes($_POST['crm']);

$sql=''; $sqle='';

$especialidade_id=$_POST['especialidade_id'];

if(isset($_POST['crm']) && empty($_POST['crm']) == false) {
	$crm=$_POST['crm'];
	if(fvalidacrm($crm)){
		//echo('nomefisioterapeuta:'.$nomefisioterapeuta.'<br>');
			
		$novaespecialidade=$_POST['novaespecialidade'];
		if($novaespecialidade=='S'){
			$nomeespecialidade=$_POST['nomeespecialidade'];
			$especialidade_id=fproximoid('especialidade', $conefi);
			$sqle="insert into especialidade values (
					$especialidade_id, '$nomeespecialidade')";
		}else{
			$especialidade_id=$_POST['especialidade_id'];
			//echo('post 1 especialidade_id:'.$especialidade_id.'<br>');
			if($especialidade_id==0)
				$msg='Especialidade Não selecionada';
		}	
	}else{
		$msg='CRM inválido!';
	}
}else{
	$msg='CRM não informado!';
}
	
if($idc>0){
	$del='';
	if(isset($_GET['del']) && empty($_GET['del']) == false)
		$del=$_GET['del'];
	if($del=='del'){
		$ope='del';
		$sql = "delete from fisioterapeuta where id=$idc";	
	}	
	else {
		$ope='atz';

		$sql = "update fisioterapeuta set 
			crm='$crm',
			especialidade_id=$especialidade_id
			where id=$idc";
	}		
}else{
	$ope='inc';
	$id=fproximoid("fisioterapeuta", $conefi);
	$sql = "insert into fisioterapeuta (
			id, pessoa_id, crm, especialidade_id) values (
			$id, $pid, '$crm', $especialidade_id)";
			
}
$trace=ftrace('cadastrarFisioterapeuta-f1.php',$sql);
$conefi->beginTransaction();/* Inicia a transação */
try {
	if(!$sqle=='')
		$i1= $conefi->query($sqle);
	$i1= $conefi->query($sql);
	$hys=incluihystory('cadastrarFisioterapeuta-f1.php', $sql, $usu, $conefi);
	$conefi->commit();
	if($del=='del'){
		$_SESSION['msg']=' Fisioterapeuta Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=fisioterapeuta&cpl=f1");
	}else{
		if($ope=='atz'){
			$_SESSION['msg']=' Fisioterapeuta Atualizado com Sucesso!';
		}else
			$_SESSION['msg']=' Fisioterapeuta Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=fisioterapeuta&cpl=f1&id=$pid");
	}	
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']='ERRO: (cadastrarfisioterapeuta_fi) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=fisioterapeuta&cpl=f1");
}	
?>