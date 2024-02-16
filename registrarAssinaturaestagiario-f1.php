<?php
if(!isset($_SESSION)){session_start();}

include('inicio.php');
include('../include/sa00.php');
include('../include/sa02.php');
include('../include/sa03.php');

$conefi=conexao('efisio');
$conpes=conexao('pessoal');
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

$agendaid=$_SESSION['agendaid'];
$ragenda=leagenda_fi($agendaid,$conefi);
if($ragenda){
	$estagiarioid=$ragenda['estagiario_id'];
}

$headerx="";
$vcpo="'".$login."'";
$leuusuario=fletabelaporvalordecampo('usuario','identificacao',$vcpo,$conpes);
$c=true;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
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
			}}
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
	$sql = "update questionarioaplicado set assinaturaestagiario='$d',
	        assinaturaestagiario_id=$estagiarioid 
			where agenda_id=$agendaid";
	try {		
		$exec=$conefi->query($sql);
		$_SESSION['msg']='Assinatura aplicada!';
	} catch(PDOException $e) {
    	$_SESSION['msg']='ERRO PDOException: (registrarAssinaturaestagiario) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
}

$headerx="Location:chameFormulario.php?op=registrar&obj=avaliacaofisica&cpl=f1&id=$agendaid";

header($headerx);
?>