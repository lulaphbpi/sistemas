<?php
include('inicio.php');
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$usu=$_SESSION['identificacao'];
//$f=ftrace('registrarCliente-p2.php', 'inicio');

$msg='';
$sql1='';
$sqls='';
$excluirservico=false;

$id=0; $sid=0; $del='';
if(isset($_GET['id']) && empty($_GET['id']) == false) {
	$id=$_GET['id'];
	$pessoaid=$id;
}	
if(isset($_GET['idc']) && empty($_GET['idc']) == false) {
	$sid=$_GET['idc'];
	if(isset($_GET['del']) && empty($_GET['del']) == false){
		$del=$_GET['del'];
		$excluirservico=true;
	}
}

if($excluirservico){
	if (temagendaservico($sid, $conefi))
		$_SESSION['msg']="Serviço agendado Não pode ser excluído!";
	else	
		$sql1 = "zdelete from servicopessoa where id=$sid and statusservico_id<2";
}else{
	$f=ftrace('registrarCliente-p2.php', '1');
	
$ocupacao=$_POST['ocupacao'];
$contato=$_POST['contato'];
$nomemae=$_POST['nomemae'];
$cor_id=$_POST['cor_id'];
$cartaosus=$_POST['cartaosus'];
$data=$_POST['data'];
$diagnosticomedico=$_POST['diagnosticomedico'];
$motivo=$_POST['motivo'];
$observacoes=$_POST['observacoes'];
$_SESSION['msg'] = '';

$d=formataData($data);
//$f=ftrace('registrarCliente-p2.php', '2');

if(!$cartaosus==''){
	//$lesus=lecartaosus($cartaosus,$conefi);
	//if($lesus['pessoa_id']==$pessoaid){
	//}else{
	//	$_SESSION['msg']=' Falha: Cartão SUS já está designado para outra pessoa: id '.$lesus['pessoa_id'];
	//	header ("Location: chameFormulario.php?op=registrar&obj=cliente&cpl=p2&id=$pessoaid");
	//	exit;
	//}
}
//$f=ftrace('registrarCliente-p2.php', '3');

$rreg=lepessoaefi($pessoaid, $conefi);
if($rreg) { // se houver registro, apenas atualiza, nunca inclui novo
	//$data=date('Y-m-d');
	//$d=formataData($data);
	$sql1 = "update pessoa set 
				naturezadapessoa_id=2,
				ocupacao='$ocupacao',
				contato='$contato',
				nomemae='$nomemae',
				cor_id=$cor_id,
				cartaosus='$cartaosus',
				diagnosticomedico='$diagnosticomedico',
				motivo='$motivo',
				observacoes='$observacoes',
				data='$d'
			where pessoa_id=$pessoaid";
}else{
	$id1=fproximoid("pessoa",$conefi);
	$tipo='F';
	$naturezadapessoa_id=2;
	$sql1="insert into pessoa 
			(id, pessoa_id, naturezadapessoa_id, cartaosus, 
			nomemae, cor_id, data, diagnosticomedico, motivo, 
			observacoes, ocupacao, contato) 
			values (".
				$id1.",".
				$pessoaid.",".
				$naturezadapessoa_id.",'".
				$cartaosus."','".
				$nomemae."',".
				$cor_id.",'". 
				$d."','".$diagnosticomedico."'".
				",'".$motivo."'".
				",'".$observacoes."'".
				",'".$ocupacao."'".
				",'".$contato."'".
			")";
}	

$novoservico=$_POST['servico_id'];
if(!empty($novoservico)){
	$leservicopessoa=leservicopessoa_fi($pessoaid, $novoservico,$conefi);
	if($leservicopessoa){
		$msg=' Serviço já se entontra associado ao Paciente!'; //die(' msg='.$msg);
	}else{
		$ids=fproximoid('servicopessoa', $conefi);
		$sqls="insert into servicopessoa (id, servico_id, pessoa_id, ativo, data, statusservico_id) 
			values ($ids, $novoservico, $pessoaid, 'S', '$d', 1)";
	}	
}

}

$conefi->beginTransaction();/* Inicia a transação */
try {
	if($sql1==''){

	}else{
	if(!$sqls==''){ //die($sqls);
		$f=ftrace('registrarCliente-p2.php', $sqls);

		$ex1=$conefi->query($sqls);
	    if($ex1){
		}else{
			$msg=$msg.' Serviço adicionado ao Paciente.';
		}		
	}	
	$sql=$sql1;
	//$f=ftrace('registrarCliente-p2.php', $sql);
	$i1= $conefi->query($sql);
	$hys=incluihystory('registrarCliente-p2.php', $sql, $usu, $conefi);
	$conefi->commit();
	//$f=ftrace('registrarCliente-p2.php', 'apos commit');

	if($rreg)
	$_SESSION['msg']=$msg.' Paciente Atualizado com Sucesso!';
	else
	$_SESSION['msg']=$msg.' Paciente registrado com Sucesso!';
	}
	header ("Location: chameFormulario.php?op=registrar&obj=cliente&cpl=p2&id=$pessoaid");
} catch(PDOException $e) {
	$conefi->rollback();
    $_SESSION['msg']=$msg.' ERROR exception: (registrarCliente_p2) ' . $e->getMessage(). ' '. $sql;
	header ("Location: chameFormulario.php?op=registrar&obj=cliente&cpl=p2&id=$pessoaid");
}	
?>