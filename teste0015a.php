<script type="text/javascript">
	var variaveljs = prompt('Digite S para Confirmar:'); 
		
</script>
<?php 
$variavelphp = "<script>document.write(variaveljs)</script>";
$variavelphp=trim($variavelphp);
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
		
$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$requisicaoid=$_GET['id'];
if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$idc=$_GET['idc'];

//if($variavelphp=='S'){
	//echo "Olá $variavelphp";
	$sql = "delete from examerequerido
			where id=$idc";
	$conacl->beginTransaction();/* Inicia a transação */
	try {
		$i1= $conacl->query($sql);
		$conacl->commit();
		$_SESSION['msg']=' Exame Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
	} catch(PDOException $e) {
		$conacl->rollback();
		$_SESSION['msg']='ERRO: (excluirExamerequerido_e1) ' . $e->getMessage(). ' '. $sql;
		header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
	}
//}else{
//		$_SESSION['msg']=' Exame NÃO Excluído!';
	//	header ("Location: chameFormulario.php?op=cadastrar&obj=examerequerido&cpl=e1&id=$requisicaoid");
//}	
//echo "Ih $variavelphp";
?>
