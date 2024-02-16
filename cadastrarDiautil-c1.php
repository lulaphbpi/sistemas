<?php
include('inicio.php');
include('../include/sa000.php');
$connae=conexao('consnae');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];
$diautil='';
$turno_id=0;
$statusdiautil_id=0;
$descricao='';
$limite=0;
$confirmados='';
$efetivados='';

$id=0; $descricao=''; $ok=true; $op='';
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
}
if(isset($_GET['del']) && empty($_GET['del']) == false){
	$del=$_GET['del'];
	if($del=='del'){
		$op='del';
		$sql = "delete from diautil where id=$id";
		$ok=false;
	}		
}	
if($ok){
	$dia=$_POST['diautil'];
	$turno_id=$_POST['turno_id'];
	$statusdiautil_id=$_POST['statusdiautil_id'];
	$limite=$_POST['limite'];
	//$confirmados=$_POST['confirmados'];
	//$efetivados=$_POST['efetivados'];
	$descricao=ucfirst(addslashes($_POST['descricao']));
	if(!($dia=='')){
		if($id>0){
			$op='atz';
			$sql = "update diautil set 
				turno_id=$turno_id,
				statusdiautil_id=$statusdiautil_id,
				descricao='$descricao',
				limite=$limite
				where id=$id";
		}else{
			$op='inc';
			$id=fproximoid("diautil", $connae); 
			$sql = "insert into diautil (
					id, dia, turno_id, statusdiautil_id,
					descricao, limite,
					confirmados, efetivados) values (
					$id, '$dia', $turno_id, $statusdiautil_id, 
					'$descricao', $limite, 
					0, 0)";		
		}			
	}else{
		$_SESSION['msg']='ERRO: (cadastrardiautil-q1.php). Sem dados para processar:'.$sql;
		header ("Location: chameFormulario.php?op=cadastrar&obj=diautil&cpl=c1");
		exit();
	}	
}	
//die(' sql:'.$sql);
$connae->beginTransaction();/* Inicia a transação */
try {
	$i1= $connae->query($sql);
	$connae->commit();
	if($ok){
		if($op=='atz')
			$_SESSION['msg']=' Dia Útil Atualizado com Sucesso!';
		else	
			$_SESSION['msg']=' Dia Útil Registrado com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=diautil&cpl=c1&id=$id");
	}else{
		$_SESSION['msg']=' Dia Útil Excluído com Sucesso!';
		header ("Location: chameFormulario.php?op=cadastrar&obj=diautil&cpl=c1");
	}	
	$hys=incluihystory('cadastrarDiautil-c1.php', $sql, $usu, $connae);
} catch(PDOException $e) {
	$connae->rollback();
    $_SESSION['msg']='ERRO: (cadastrarDiautil_c1.php) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=diautil&cpl=c1");
}
?>