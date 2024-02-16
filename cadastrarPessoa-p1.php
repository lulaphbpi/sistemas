<?php

// Usuário comum = nível de usuário 4

include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);
$usu=$_SESSION['identificacao'];

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];
$cpf=$_POST['cpf'];
$formacaoprofissional_id=$_POST['formacaoprofissional_id'];
$tipodevinculo_id=$_POST['tipodevinculo_id'];
$matricula=$_POST['matricula'];
$apelido=$_POST['apelido'];
$nome=$_POST['nome'];
//$apelido=primeironome($nome);
$apelido=$_POST['apelido'];
$datanascimento=$_POST['datanascimento'];
$sexo=$_POST['sexo'];
$rg=$_POST['rg'];
$expedidorrg_id=$_POST['expedidorrg_id'];
$logradouro=$_POST['logradouro'];
$numero=$_POST['numero'];
$complemento=$_POST['complemento'];
$bairro=$_POST['bairro'];
$municipio=$_POST['municipio'];
$ufsigla=$_POST['uf'];
$cep=$_POST['cep'];
$fone=$_POST['fone'];
$email=$_POST['email'];

$_SESSION['msg'] = '';

$id1=fproximoid("pessoa",$conpes);
$tipo='F';
if($id>0){$id1=$id;}

if($id==0){
	$rpes=lepessoafisicaporcpf($cpf,$conpes);
	if($rpes){
		$pessoaid=$rpes['id'];
		$_SESSION['msg']=' Já existe pessoa cadastrada com o CPF informado';
		header ("Location: chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1&id=$pessoaid");
		exit;
	}
}

if($id==0){
$sql1="insert into pessoa 
	(id, tipo, cnpjcpf, denominacaocomum, nome, fone, email, situacao_id) 
	values (".
		$id1.",'".
		$tipo."','".
		$cpf."','".
		$apelido."','". 
		$nome."','".
		$fone."','".
		$email."', 0".
	")";
}else{
	$sql1="update pessoa set 
			cnpjcpf='$cpf',
			denominacaocomum='$apelido',
			nome='$nome',
			fone='$fone',
			email='$email'
			where id=$id";
}	
//die("sql1:".$sql1);
if($id==0){
$sql2="insert into pessoafisica 
	(id, datanascimento, sexo, rg, expedidorrg_id, formacaoprofissional_id) 
	values (".
		$id1.",'".
		formataData($datanascimento)."','".
		$sexo."','".
		$rg."',".
		$expedidorrg_id.",".
		$formacaoprofissional_id.
	")";
//die("sql2:".$sql2);
}else{
	$sql2="update pessoafisica set
			datanascimento='".formataData($datanascimento)."',
			sexo='$sexo',
			rg='$rg',
			expedidorrg_id=$expedidorrg_id,
			formacaoprofissional_id=$formacaoprofissional_id
			where id=$id";
}	
if($id==0){
$id3=fproximoid("institucional",$conpes);
$sql3="insert into institucional
	(id, pessoafisica_id, tipodevinculo_id, matriculainstitucional, lotacao_id, funcao_id, local_id) 
	values (".
		$id3.",".
		$id1.",".
		$tipodevinculo_id.",'".
		$matricula."',999,9,1".
	")";
}else{
	$sql3="update institucional set 
		tipodevinculo_id=$tipodevinculo_id,
		matriculainstitucional='$matricula'
		where pessoafisica_id=$id";
}	
if($id==0){
$id4=fproximoid("endereco",$conpes);
$sql4="insert into endereco
	(id, pessoa_id, logradouro, numero, complemento, bairro, 
	cep, municipio, uf) 
	values (".
		$id4.",".
		$id1.",'".
		$logradouro."','".
		$numero."','".
		$complemento."','".
		$bairro."','".
		$cep."','".
		$municipio."','".
		$ufsigla."'".
	")";
}else{
	$sql4="update endereco set logradouro='$logradouro', numero='$numero', complemento='$complemento', bairro='$bairro', cep='$cep', municipio='$municipio', uf='$ufsigla' where pessoa_id='$id'";
}	
	
$conpes->beginTransaction();/* Inicia a transação */
try {
	$sql=$sql1;
	$i1= $conpes->query($sql);
	$sql=$sql2;
	$i1= $conpes->query($sql);
	$sql=$sql3;
	$i1= $conpes->query($sql);
	$sql=$sql4;
	$i1= $conpes->query($sql);
	$conpes->commit();
	$sql=$sql1.' '.$sql2.' '.$sql3.' '.$sql4;   
	$hys=incluihystory('cadastrarPessoa-p1.php', $sql, $usu, $conefi);
	$_SESSION['msg']=' Cadastro realizado com Sucesso!';
	header ("Location: chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1&id=$id1");
} catch(PDOException $e) {
	$conpes->rollback();
    $_SESSION['msg']='ERRO: (cadastrarpessoa_p1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1");
}	
?>
