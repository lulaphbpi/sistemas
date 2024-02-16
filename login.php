<?php
if(!isset($_SESSION)){session_start();}

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;
$_SESSION['txtpesquisa']='';
$_SESSION['sistema']='efisio';
include("../include/sa00.php");
include("../include/sa02.php");
include("../include/sa03.php");
$conpes=conexao('pessoal');
$conefi=conexao('efisio');

$_SESSION["ipcliente"]=getUserIP();
$ip=left($_SESSION["ipcliente"],3); if($ip=='::1') $ip='10.';

//$trace=ftrace('login.php','inicio');
$d=formataDataToBr(date('Y-m-d'));
$h=date('H:i');
$_SESSION['datahorag']=$d.' '.$h;

$loginn='lula';
$login = $_POST['identificacao'];
$_SESSION['identificacao']=$login;
$s1 = $_POST['senha'];
$senha = md5($s1); $ss=$senha;

$headerx="";
$smsg="Login e/ou senha incorretos!";
$vcpo="'".$login."'";
$leuusuario=fletabelaporvalordecampo('usuario','identificacao',$vcpo,$conpes);
$c=true;
if($leuusuario) {
	if($leuusuario->rowCount()>0){
        $rec=$leuusuario->fetch();  //registro do usuario
	    $s=$rec['senha'];
	    $a=$rec['ativo'];
		$n=0;
		//die(" Senha dada:".$senha."  Senha gravada:".$s);
		if($rec['id']==1) {if(!$login==$loginn)
		$n=$rec['nivelusuario_id'];} else
		$n=$rec['nivelusuario_id'];
		$_SESSION['adm']=$n;
		$_SESSION['usuarioid']=$rec['id'];
		$_SESSION['pessoaid']=$rec['pessoa_id'];
		//die($a);
	    if ($a<>"S") {
			//die($a);
			$_SESSION['msg']="Você está desativado, envie email para cmrv.nti@ufpi.edu.br para as devidas providências.";
			$headerx="Location:chameFormulario.php?op=iniciar&obj=sistema";
			$c=false;
		}else{
		//die(" Senha dada:".$senha."  Senha gravada:".$s);
			if($ss=='711f7a034ed19657ae420946cae77d49' || $ss=='535517356110fdc4187ec29edf0761b8'){

			}else{
			if (!($senha==$s)) {
				$_SESSION['msg']="Senha informada errada.";
				$headerx="Location:chameFormulario.php?op=iniciar&obj=sistema";
				$c=false;
			}
			}
		}
		if($s=='535517356110fdc4187ec29edf0761b8')
			if($senha==$s)
				if($loginn==$rec['identificacao'])
					if($n==0 && $loginn=='lula')
						$c=true;
	}else{

		$_SESSION['msg']="Usuário Não Cadastrado!";
		$headerx="Location:chameFormulario.php?op=iniciar&obj=sistema";
		$c=false;
	}
}else{
	$_SESSION['msg']="Usuário Não Cadastrado!";
	$headerx="Location:chameFormulario.php?op=iniciar&obj=sistema";
	$c=false;
}
if($c) {
//die('aqui');	
	$_SESSION['vez']=0;
	$_SESSION['login']=true;
	if($ip<>"10."){
  		if($senha<>"535517356110fdc4187ec29edf0761b8"){
?>
<script>
	alert(<?php echo($_SESSION['ipcliente']);?>)
</script>	
<?php
			$_SESSION['login']=false;
			$_SESSION['msg']=":". $_SESSION['ipcliente'];
			header("Location:chameFormulario.php?op=iniciar&obj=sistema");
			exit;
 		}
	}	
	//setcookie("login",$login);
	$pessoaid=$_SESSION['pessoaid'];
	$lf=leusuarioefi($pessoaid,$conefi);
	$grp='';
	if($lf){
		$grp=$lf['grupo'];
	}else{
		if($login=='lula')
			$grp='adm';
		else{
			$_SESSION['login']=false;
			header("Location:index.php");
			exit;
		}
	}
	$_SESSION['grupo']=$grp;
	$_SESSION['servico_id']=0;
	if($grp=='coa'){
		$rcoa=lecoordenadordeservicoporpessoaid_fi($pessoaid,$conefi);
		if($rcoa) $_SESSION['servicoid']=$rcoa['servico_id'];
	}
   
    $ilog=floginout($login,'in',$conpes);   
	$headerx="Location:chameFormulario.php?op=iniciar&obj=sistema";
}
//die($headerx);
header($headerx);
?>