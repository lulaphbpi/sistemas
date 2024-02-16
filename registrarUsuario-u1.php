<?php

// Usuário comum = nível de usuário 4

include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

//die(geraSenha());

$_SESSION['msg']="";
$msg='';
$usu=$_SESSION['identificacao'];
$sistema=$_SESSION['sistema'];
$nivelusuarioid=3;
$sql1=''; $sql2='';
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$pessoaid=$_GET['id'];
	$identificacao=$_POST['identificacao'];
	$niveldousuarioid=$_POST['niveldousuario_id'];
	$grupoid=$_POST['grupo_id'];
	$leusuario=leusuarioporidentificacao2($identificacao,$conpes);
	if(!$leusuario) {
		$id1=fproximoid('usuario',$conpes);
		$senha='';
		$rp=lepessoafisicaporid($pessoaid,$conpes);
//		$pn=primeironome($rp['nome']);
//		$identificacao=geraIdentificacao($pn,$conpes);
		$senha=geraSenha();
		$niveldeusuarioid=4; // nivel de usuario global
		$sql1="insert into usuario 
			(id, identificacao, senha, pessoa_id, niveldeusuario_id, ativo) 
			values (".
				$id1.",'".
				$identificacao."','".
				md5($senha)."',".
				$pessoaid.",".
				$niveldeusuarioid.",".
				"'S'".
				")";
		//die('sql1:'.$sql1);
	}else{
		$ident=$leusuario['identificacao'];
		$nome=$leusuario['nome'];
		$msg=$msg.' Usuário #'.$nome.'# já existe no sistema com a identificação #'.$ident.'#.';
	}	
	$leusuarioefi=leusuarioefi($pessoaid,$conefi);
	if(!$leusuarioefi) {
		$id2=fproximoid("usuario",$conefi);
		$sql2="insert into usuario 
				(id, pessoa_id, niveldousuario_id, grupo_id, ativo) 
				values (".
				$id2.",".
				$pessoaid.",".
				$niveldousuarioid.",".
				$grupoid.",'S')";
		//die('sql2:'.$sql2);		
	}else{
		$sql2="update usuario set 
		niveldousuario_id=$niveldousuarioid,
		grupo_id=$grupoid,
		ativo='S' where pessoa_id = $pessoaid";
//		$msg=$msg.' - Usuário já existe no sistema #'.$sistema.'#.';
	}	
	try {
		if(!$sql1=='') {
			//die('sql1 :'.$sql1);
			$conpes->beginTransaction();
			$sql=$sql1;
			$i1=$conpes->query($sql);
			if($i1){
				$msg=$msg.' Usuário Registrado com Sucesso! Anote Identificação ('.$identificacao.') e Senha ('.$senha.') com segurança.';
				$ssql="insert into sinicial values ('$identificacao', '$senha')";
				$i=$conpes->query($ssql);
				$hys=incluihystory('registrarUsuario-u1.php', $ssql, $usuarioid, $conefi);
				$conpes->commit();
			}else{
				$conpes->rollback();
				$msg=$msg.' Usuário não registrado em pessoal.';
			}	
		}
		if(!$sql2==''){
			//die('sql2 :'.$sql2);
			$conefi->beginTransaction();	
			$sql=$sql2;
			$i2=$conefi->query($sql);
			if($i2){
				$conefi->commit();
				$sql=$sql2;   
				$hys=incluihystory('registrarUsuario-u1.php', $sql, $usu, $conefi);
				$msg=$msg."  Usuário atualizado!";
			}else{
				$conefi->rollback();
				$msg=$msg.' Usuário não atualizado!';
			}	
		}	
	} catch(PDOException $e) {
			$msg=$msg.' ERRO Exception: (registrarUsuario-u1) ' . $e->getMessage(). ' '. $sql;
	} 
}
$_SESSION['msg']=$msg;		
header ("Location: chameFormulario.php?op=consultar&obj=pessoa&cpl=c1");

?>
