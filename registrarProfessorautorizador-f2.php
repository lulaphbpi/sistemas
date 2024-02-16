<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
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
	$spid=$_GET['id'];  // servicopessoaid

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$tid=$_GET['idc'];  // tratamentoid

$agendaid=$_SESSION['agendaid'];
$rect=letratamentoid($tid,$conefi);
$agendaid=$rect['agenda_id'];

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
			$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";
			$c=false;
		}else{
			if($s1=='trb'){}else{ 
			if (!($senha==$s)) {
				$_SESSION['msg']="Senha informada errada.";
				$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";

				$c=false;
			}}
		}
	}else{
		$_SESSION['msg']="Usuário Não Cadastrado!";
		$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";
		$c=false;
	}
}else{
	$_SESSION['msg']="Usuário Não Cadastrado!";
	$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";
	$c=false;
}


if($c){
	if($u==$usuarioid){
	$d=date("Y-m-d H:i");
	$sql = "update tratamento set autorizadoprofessor='$d',
	        autorizadoprofessor_usuario_id=$u 
			where id=$tid";
	$sql2="update agenda set statusagenda_id=2 where id=$agendaid";		
	try {		
		$exec=$conefi->query($sql);
		$exec=$conefi->query($sql2);
		$_SESSION['msg']='Autorização aplicada!';
	} catch(PDOException $e) {
    	$_SESSION['msg']='ERRO PDOException: (registrarProfessorautorizador-f2) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	}else{
		$_SESSION['msg']="Usuário não é o mesmo da sessão!";
	}	
}

$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";

header($headerx);
?>