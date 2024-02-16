<?php
include('inicio.php');
include('sa000.php');
$conexao=conexao('pessoal');

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

$id=0;
$cpf=$_POST['cpf'];
$vcpo="'".$cpf."'";
$leucpf=fletabelaporvalordecampo('pessoa','cnpjcpf',$vcpo,$conexao);
if($leucpf) {
	if($leucpf->rowCount()>0){
		$rusu=leUsuarioPorCPF($cpf,$conexao);
		if($rusu) {
			$identificacao=$rusu['usuario'];
		}else{
			$identificacao='Não Encontrado';
		}
		$_SESSION['msg'] = "1Já existe Pessoa Física cadastrada com o CPF ".$cpf.
		" - Usuário: ".$identificacao;
		header ("Location: chameFormulario.php?op=cadastrarpessoa&obj=pessoa"); 
		exit;
	}
}	
$_SESSION['msg'] = '';
$_SESSION['cpf'] = $cpf;
$_SESSION['tipo'] = 'F';

header ("Location: chameFormulario.php?op=cadastrarpessoap2");

?>
