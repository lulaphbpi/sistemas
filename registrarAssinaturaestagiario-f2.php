<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
$usuarioid=$_SESSION['usuarioid'];

$msg='';
$t=ftrace('registrarAssinaturaestagiario-f2.php','usuarioid:'.$usuarioid);

$login = $_POST['identificacao'];
//$_SESSION['identificacao']=$login;
$s1 = $_POST['senha'];
$senha = md5($s1);

if($login<>$_SESSION['identificacao']){
	$msg='Identificação não corresponde ao usuário';
}	

$agendaid=$_SESSION['agendaid'];
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid

if(isset($_GET['idc']) && empty($_GET['idc']) == false)
	$tid=$_GET['idc'];  // tratamentoid

$agendaid=$_SESSION['agendaid'];
if(isset($_GET['idx']) && empty($_GET['idx']) == false)
	$agendaid=$_GET['idx'];  // agendaid

$rect=letratamentoid($tid,$conefi);
$agendaid=$rect['agenda_id'];
$estagiarioid=0;
$ragenda=leagenda_fi($agendaid,$conefi);
if($ragenda){
	$estagiarioid=$ragenda['estagiario_id'];
	$leusuarioestagiario=leusuarioestagiario($estagiarioid,$conefi);
	$eusuarioid=$leusuarioestagiario['eusuarioid'];
}

$headerx="";
$vcpo="'".$login."'";
$leuusuario=fletabelaporvalordecampo('usuario','identificacao',$vcpo,$conpes);
$c=true;
$pid=0;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
		$u=$rec['id'];
		$pid=$rec['pessoa_id'];
		$t=ftrace('registrarAssinaturaestagiario-f2.php','usuarioid:'.$usuarioid. ' u:'.$u);
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
			}elseif($eusuarioid<>$u){
				$_SESSION['msg']="Identificação ".$eusuarioid." Não corresponde ao Usuário Corrente ".$u;
				$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";
				$c=false;

			}
			
			}
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
	//$d=date("Y-m-d H:i:s");
	$d=date("Y-m-d");
	$sql = "update tratamento set assinaturaestagiario='$d',
	        assinaturaestagiario_id=$estagiarioid 
			where id=$tid";
	$t=ftrace('registrarAssinaturaestagiario-f2.php',$sql);		
	try {		
		$exec=$conefi->query($sql);
		$_SESSION['msg']='Assinatura aplicada!';
	} catch(PDOException $e) {
    	$_SESSION['msg']='ERRO PDOException: (registrarAssinaturaestagiario) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	}else{
		$_SESSION['msg']="Usuário não é o mesmo da sessão!";
	}	
}

$headerx="Location:chameFormulario.php?op=registrar&obj=tratamento&cpl=f1&id=$spid";

header($headerx);
?>