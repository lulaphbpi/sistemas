<?php

// Usuário comum = nível de usuário 4

include('inicio.php');
include('sa000.php');
$conpes=conexao('pessoal');

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

$id=0;
$tipodevinculo_id=$_POST['tipodevinculo_id'];
$matriculainstitucional=$_POST['matriculainstitucional'];
//$lotacao_id=$_POST['lotacao_id'];
//$funcao_id=$_POST['funcao_id'];
//$local_id=$_POST['local_id'];
$_SESSION['msg'] = '';

$_SESSION['cadastro3'] = array (
	"tipodevinculo" => $tipodevinculo_id,
	"matriculainstitucional" => $matriculainstitucional,
	"lotacao" => 999,
	"funcao" => 9,
	"local" => 1
);
$_SESSION['endereco'] = array (
	"logradouro" => $_POST['logradouro'],
	"numero" => $_POST['numero'],
	"complemento" => $_POST['complemento'],
	"bairro" => $_POST['bairro'],
	"cep" => $_POST['cep'],
	"municipio" => $_POST['municipio'],
	"uf" => $_POST['uf']
);

$c1=$_SESSION['cadastro1'];
$c2=$_SESSION['cadastro2'];
$c3=$_SESSION['cadastro3'];
$c4=$_SESSION['endereco'];

$id1=fproximoid("pessoa",$conpes);
$tipo=$_SESSION['tipo'];
$cpf=$_SESSION['cpf'];
$sql1="insert into pessoa 
	(id, tipo, cnpjcpf, denominacaocomum, nome, fone, email) 
	values (".
		$id1.",'".
		$tipo."','".
		$cpf."','".
		$c1['apelido']."','". 
		$c1['nome']."','".
		$c1['fone']."','".
		$c1['email']."'".
	")";
//die("sql1:".$sql1);
$sql2="insert into pessoafisica 
	(id, datanascimento, sexo, rg, expedidorrg_id, formacaoprofissional_id) 
	values (".
		$id1.",'".
		formataData($c2['datanascimento'])."','".
		$c2['sexo']."','".
		$c2['rg']."',".
		$c2['expedidorrg'].",".
		$c2['formacaoprofissional'].
	")";
//die("sql2:".$sql2);
$id3=fproximoid("institucional",$conpes);
$sql3="insert into institucional
	(id, pessoafisica_id, tipodevinculo_id, matriculainstitucional, lotacao_id, funcao_id, local_id) 
	values (".
		$id3.",".
		$id1.",".
		$c3['tipodevinculo'].",'".
		$c3['matriculainstitucional']."',".
		$c3['lotacao'].",".
		$c3['funcao'].",".
		$c3['local'].
	")";
$id4=fproximoid("endereco",$conpes);
$sql4="insert into endereco
	(id, pessoa_id, logradouro, numero, complemento, bairro, 
	cep, municipio, uf) 
	values (".
		$id4.",".
		$id1.",'".
		$c4['logradouro']."',".
		$c4['numero'].",'".
		$c4['complemento']."','".
		$c4['bairro']."','".
		$c4['cep']."','".
		$c4['municipio']."','".
		$c4['uf']."'".
	")";
	
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
	$_SESSION['msg']=' Cadastro realizado com Sucesso!';
} catch(PDOException $e) {
	$conpes->rollback();
    $_SESSION['msg']='ERROR: (cadastrapessoa_p4) ' . $e->getMessage(). ' '. $sql;
}	

header ("Location: chameFormulario.php?op=cadastrarpessoa&obj=pessoa");

?>
