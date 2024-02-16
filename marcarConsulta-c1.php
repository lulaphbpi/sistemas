<?php
include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$connae=conexao('consnae');
$trace=ftrace('marcarConsulta-c1.php','Inicio');

$usu=$_SESSION['usuarioid'];

$id=0;
if(isset($_GET['id']) && empty($_GET['id']) == false){
	$id=$_GET['id'];
}	
$trace=ftrace('marcarConsulta-c1.php',$id);
if($id==0){
	$_SESSION['msg']='Sem id do cliente!';
	header("Location: chameFormulario.php?op=consultar&obj=pessoa&cpl=c1");
	exit();
}
$atualiza_dados=$_POST['atualiza_dados'];
if($atualiza_dados==1){
	$nome=$_POST['nome'];
	$apelido=$_POST['apelido'];
	$datanascimento=$_POST['datanascimento'];
	$sexo=$_POST['sexo'];
	$fone=$_POST['fone'];
	$email=$_POST['email'];
	
	$logradouro=$_POST['logradouro'];
	$numero==$_POST['numero'];
	$complemento==$_POST['complemento'];
	$bairro==$_POST['bairro'];
	$cep=$_POST['cep'];
	$municipio=$_POST['municipio'];
	$uf=$_POST['uf'];

	$nomemae=$_POST['nomemae'];
	$cor_id=$_POST['cor_id'];
	$cartaosus=$_POST['cartaosus'];
	$data=date('Y-m-d');
	$dt=formataData($data);
	$sql1="update pessoa set 
			denominacaocomum='$apelido',
			nome='$nome',
			fone='$fone',
			email='$email'
			where id=$id";	
	$sql2="update pessoafisica set
			datanascimento='".formataData($datanascimento)."',
			sexo='$sexo'
			where id=$id";
	$sql3="update pessoa set 
			cartaosus='$cartaosus',
			nomemae='$nomemae',
			cor_id=$cor_id,
			data='$dt'
			where id=$id";	
	$sql4="update endereco set logradouro='$logradouro', 
			numero='$numero', complemento='$complemento', 
			bairro='$bairro', cep='$cep', municipio='$municipio', 
			uf='$uf' where pessoa_id='$id'";
}	
$cpfresponsavel=$_POST['cpfresponsavel'];
$tipodeacompanhante_id=$_POST['tipodeacompanhante_id'];
$convenio_id=$_POST['convenio_id'];
$medico_id=$_POST['medico_id'];
$dataconsulta=$_POST['dataconsulta'];
$horario=$_POST['horario'];
$planodesaude_id=0;
$diautil=lediautil($dataconsulta, $connae)

$cid=fproximoid('consulta',$connae);

$dtr=date('Y-m-d');
$sql = "insert into consulta values (
		$cid,
		'$cpfresponsavel',
		$tipodeacompanhante_id,
		$convenio_id,
		'$cartaosus',
		$planodesaude_id,
		$medico_id,
		'$dtr',
		'$dataconsulta',
		'$horario',
		$id,
		'N',
		'N')";
$trace=ftrace('marcarConsulta-c1.php',$sql);
try {		
	if($atualiza_dados==1){
		$atz1=$connae->query($sql1);
		$atz2=$connae->query($sql2);
		$atz3=$connae->query($sql3);
		$atz4=$connae->query($sql4);
	}	
	$inc1=$connae->query($sql);
	$hys=incluihystory('marcarConsulta-c1.php', $sql, $usu, $connae);
	if($hys)
		$_SESSION['msg']='Consulta Marcada com Sucesso ';
	else
		$_SESSION['msg']='Ocorreu alguma falha durante a inclusão do registro. Verifique';
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (marcarConsulta-c1.php) ' . $e->getMessage(). ' '. $sql;
}		

header("Location: chameFormulario.php?op=consultar&obj=consulta&cpl=c1&id=".$id);
?>
