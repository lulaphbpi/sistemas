<?php
include('inicio.php');
include('../include/sa000.php');
$conacl=conexao('aclinica');

$tx=$_POST['textopesquisa'];

$ident=$_SESSION['identificacao'];
if($tx==""){
	$ssql="select msg.*
		from msg where (identificacao_destino='' or identificacao_destino like '$ident' or identificacao_origem like '$ident')
		order by idbase,id	limit 35";
}else{	
	$ssql="select msg.*
		from msg where (identificacao_destino='' or identificacao_destino like '$ident' or identificacao_origem like '$ident') and mensagem like '$tx' order by idbase,id limit 35";
}
//die($ssqls);
$rs=$conacl->query($conacl);
$nr=$rs->rowCount();

if($nr==0){
	$_SESSION['msg']="Nenhuma Mensagem encontrada";
	header("Location: chameFormulario.php?op=consultar&obj=mensagem");
	exit();
}else{
if($nr==1){
	$rec=$rs->fetch();
	$id=$rec['id'];
	header("Location: chameFormulario.php?op=cadastrar&obj=mensagem&id=$id");
	exit();
}else{
//die($tx.$pr." ".$nr);
	$_SESSION['texto']=$tx;
	header("Location: chameFormulario.php?op=listar&obj=mensagem&id=$ident");
	exit();
}}

//$rec=mysql_fetch_array($rs);

//echo($rec['id']."-".$rec['descricao']." ");

//die($tx.$pr);


?>