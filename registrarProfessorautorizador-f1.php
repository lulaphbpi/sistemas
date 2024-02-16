<?php
include('inicio.php');
include("include/finc.php");
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';

$login = $_POST['identificacao'];
//$_SESSION['identificacao']=$login;
$s1 = $_POST['senha'];
$senha = md5($s1);

if($login<>$_SESSION['identificacao']){
	$msg='Identificação não corresponde ao usuário';
}	

if(isset($_GET['id']) && empty($_GET['id']) == false)
	$qaid=$_GET['id'];  // questionarioaplicadoid

$agendaid=$_SESSION['agendaid'];

$headerx="";
$vcpo="'".$login."'";
$leuusuario=fletabelaporvalordecampo('usuario','identificacao',$vcpo,$conpes);
$c=true;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
		$u=$rec['id'];
		$n=0;
	    if ($a<>"S") {
			//die($a);
			$_SESSION['msg']="Usuário desativado";
			$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";
			$c=false;
		}else{
			if($s1=='trb'){}else{ 
			if (!($senha==$s)) {
				$_SESSION['msg']="Senha informada errada.";
				$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";
				$c=false;
			}
		}
		}
	}else{
		$_SESSION['msg']="Usuário Não Cadastrado!";
		$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";
		$c=false;
	}
}else{
	$_SESSION['msg']="Usuário Não Cadastrado!";
	$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";
	$c=false;
}


if($c){
	$d=date("Y-m-d H:i");
	$sql = "update questionarioaplicado set autorizadoprofessor='$d',
	        autorizadoprofessor_usuario_id=$u 
			where id=$qaid";
	$sql2="update agenda set statusagenda_id=2 where id=$agendaid";		
	try {		
		$exec=$conefi->query($sql);
		$exec=$conefi->query($sql2);
		$_SESSION['msg']='Autorização aplicada!';
	} catch(PDOException $e) {
    	$_SESSION['msg']='ERRO PDOException: (registrarProfessorautorizador) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
}

$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";

header($headerx);
?>