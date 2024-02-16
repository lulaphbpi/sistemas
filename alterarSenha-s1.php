<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';

$senhaatual=''; $sql='';
if(isset($_POST['senhaatual']) && empty($_POST['senhaatual']) == false) {
	$senhaatual=$_POST['senhaatual'];
	$novasenha=$_POST['novasenha'];
	$novasenhac=$_POST['novasenhac'];
	if($novasenha<>$novasenhac){
		$_SESSION['msg']='Não Confirmado: Senhas diferentes!';
	}else{
	$usuarioid=$_SESSION['usuarioid'];
	$leuusuario=fletabelaporvalordecampo('usuario','id',$usuarioid,$conpes);
	$c=true;
	if($leuusuario) {
		if($leuusuario->rowCount()>0){
			$rec=$leuusuario->fetch();  
			$s=$rec['senha'];
			$a=$rec['ativo'];
			if($a=='S'){
				$ns=md5($novasenha);
				$sa=md5($senhaatual);
				if($s==$sa){
					$sql="update usuario set senha='$ns' where id=$usuarioid";
				}else{
					$_SESSION['msg']='Senha atual errada!'; 
				}
			}else{
				$_SESSION['msg']='Usuário Inativo! Procure o Administrador do Sistema!';
			}
		}else{
			$_SESSION['msg']='Usuário Não Localizado!';	
		}
	}else{
		$_SESSION['msg']=$_SESSION['msg'].' - Usuário Não Localizado!';	
	}
	}
}
if (!$sql==''){
	$conpes->beginTransaction();	
	try {
		$i1= $conpes->query($sql);
		$conpes->commit();
		$_SESSION['msg']=' Senha Alterada com Sucesso! ';
		$hys=incluihystory('alterarSenha-s1.php', $sql, $usuarioid, $conefi);
	} catch(PDOException $e) {
		$conpes->rollback();
		$_SESSION['msg']='ERRO: (alterarsenha-s1.php) ' . $e->getMessage(). ' '. $sql;
	}	
}
header ("Location: chameFormulario.php?op=alterar&obj=senha&cpl=s1");
?>
