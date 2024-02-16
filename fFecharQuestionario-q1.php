<?php
include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$ope='atz';
$sql = "update questionario set status = 'F'
			where id=$id";
$conque->beginTransaction();/* Inicia a transação */
try {
	$i1= $conque->query($sql);
	$hys=incluihystory('fFecharQuestionario-q1.php', $sql, $usu, $conque);
	$conque->commit();
	$_SESSION['msg']=' Questionario Fechado com Sucesso!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$id");
} catch(PDOException $e) {
	$conque->rollback();
    $_SESSION['msg']='ERRO: (fFecharQuestionario-q1.php) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$id");
}	
?>
