<?php

// Usuário comum = nível de usuário 4

include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

$usu=$_SESSION['identificacao'];
$adm=$_SESSION['adm'];

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$p=$_GET['id'];
	$ritem=leprotocoloagenda($p,$conacl);
}
$cpf=$ritem['cnpjcpf'];
$formacaoprofissional_id=$ritem['formacaoprofissional_id'];
$tipodevinculo_id=$ritem['tipodevinculo_id'];
$matricula=$ritem['matriculainstitucional'];
$apelido=$ritem['denominacaocomum'];
$nome=$ritem['nome'];
$datanascimento=$ritem['datanascimento'];
$sexo=$ritem['sexo'];
$rg=$ritem['rg'];
$expedidorrg_id=$ritem['expedidorrg_id'];
$logradouro=$ritem['logradouro'];
$numero=$ritem['numero'];
$complemento=$ritem['complemento'];
$bairro=$ritem['bairro'];
$municipio=$ritem['municipio'];
$ufsigla=$ritem['uf'];
$cep=$ritem['cep'];
$fone=$ritem['fone'];
$email=$ritem['email'];
$nomemae=$ritem['nomemae'];
$cor_id=$ritem['cor_id'];
$cartaosus=$ritem['cartaosus'];

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
	(id, tipo, cnpjcpf, denominacaocomum, nome, fone, email) 
	values (".
		$id1.",'".
		$tipo."','".
		$cpf."','".
		$apelido."','". 
		$nome."','".
		$fone."','".
		$email."'".
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
			rg=$rg,
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

if($id==0){
	$id5=fproximoid("pessoa",$conacl);
	$sql5="insert into pessoa 
			(id, pessoa_id, naturezadapessoa_id, nomemae, cor_id, cartaosus, planodesaude_id, cartaosaude) 
			values (".
				$id5.",".
				$id1.",2,'".
				$nomemae."',".
				$cor_id.",'". 
				$cartaosus."',0,''".
			")";
}			
$i1=false;	
try {
	$conpes->beginTransaction();/* Inicia a transação */
	$sql=$sql1;
	$i1= $conpes->query($sql);
	$sql=$sql2;
	$i1= $conpes->query($sql);
	$sql=$sql3;
	$i1= $conpes->query($sql);
	$sql=$sql4;
	$i1= $conpes->query($sql);
	if($i1) {
		$conpes->commit();
		$sql=$sql1.' '.$sql2.' '.$sql3.' '.$sql4;   
		$hys=incluihystory('cadastrarAgenda-a1.php', $sql, $usu, $conacl);
	}else{
		$conpes->rollback();
	}
} catch(PDOException $e) {
	$conpes->rollback();
    $_SESSION['msg']='ERRO: (cadastrarAgenda_a1) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1");
	exit;
}
if($i1)	{
	$sql=$sql5;
	$i1= $conacl->query($sql);
	if($i1)
		$_SESSION['msg']=' Cadastro realizado com Sucesso!';
	else
		$_SESSION['msg']=' Falha registro de paciente : '.$sql;
	header ("Location: chameFormulario.php?op=cadastrar&obj=pessoa&cpl=p1&id=$id1");
}	
?>
