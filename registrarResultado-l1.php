<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

$msg="";
$msg=$_SESSION['msg'];
$usu=$_SESSION['identificacao'];

if(isset($_GET['id']) && empty($_GET['id']) == false) {
	$ider=$_GET['id'];
}
if(isset($_GET['idc']) && empty($_GET['idc']) == false){
	$idc=$_GET['idc'];
	$v1=$_POST['valor1'];
	$v2=$_POST['valor2'];
}	
$ritem=leitemexamerequerido($ider, $idc, $conacl);

$act="Location: chameFormulario.php?op=consultar&obj=laudo&cpl=l1&id=".$ider."&idc=".$idc;
$sql = "";

if($ritem){
	$idi=$ritem['id'];
	$sql = "update itemexamerequerido set valor1 = '$v1', valor2 = '$v2' where id = $idi";
}else{
	$id=fproximoid('itemexamerequerido', $conacl);
	$sql = "insert into itemexamerequerido (id, examerequerido_id, componentedeexame_id, valor1, valor2) values (
		$id,
		$ider,
		$idc,
		'$v1',
		'$v2'
	)";
}
try {
	if(!$sql=='') {
		$conacl->beginTransaction();
		$i1=$conacl->query($sql);
		if($i1){
			$msg=$msg.' Resultado registrado com Sucesso!';
			$hys=incluihystory('registrarResultado-l1.php', $sql, $usu, $conacl);
			$conacl->commit();
		}else{
			$conacl->rollback();
			$msg=$msg.' Falha. Resultado não registrado: '.$sql;
		}	
	}
} catch(PDOException $e) {
			$msg=$msg.' ERRO Exception: (registrarResultado-l1) ' . $e->getMessage(). ' '. $sql;
} 
//die("$act");
$_SESSION['msg']=$msg;		
header ($act);

?>
