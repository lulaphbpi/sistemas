<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include("sa000.php");
include("conexao.php");
/*
if($login){
	if(!(TemPermissao($usu,'cadastraPessoa_Fisica','i')){
		$_SESSION["msg"]="Você não tem permissão para realizar esta operação.";	
		header ("Location: chameFormulario.php?op=menuadm"); 
		exit();
	}
}else{
	//die('Fatal Error!');
	$_SESSION['SystemError']=true;
}
if($_SESSION['SystemError']){
	header("Location: index.php");
	exit();
}*/
$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}

$tx=$_SESSION['texto'];
$ident=$_SESSION['identificacao'];
if($tx==""){
	$ssql="select msg.*
		from msg where (identificacao_destino='' or identificacao_destino like '$ident' or identificacao_origem like '$ident')
		order by idbase desc,id	limit 35";
}else{	
	$ssql="select msg.*
		from msg where (identificacao_destino='' or identificacao_destino like '$ident' or identificacao_origem like '$ident') and mensagem like '$tx' order by idbase desc,id limit 35";
}
//die($ssqls);
$rs=mysql_query($ssql,$conexao);
$nr=mysql_num_rows($rs);

//$nr=mysql_num_rows($lst);

$titulo="Lista de Mensagens";

$pvez=true; 
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>

<table>
	  <tr>
	    <td colspan="4" align="center"><h5><?php echo($titulo);?></h5>
		</td>
	  </tr>
	<tr>
		<th width="4%">Id</th>
		<th width="12%">Assunto</th>
		<th width="10%">Data Envio</th>
		<th width="20%">Origem/Destino</th>
		<th width="30%">Mensagem</th>
		<th width="10%">Leitura</th>
		<th width="14%">Status</th>
	</tr>
<?php
while($rec=mysql_fetch_array($rs)){
	$id = $rec['id'];
	$assunto = fledescricaotabela($rec['msg_assunto_id'],'msg_assunto',$conexao);
	$dataenvio = formataDataHora($rec['data_envio']);
	$origemdestino=$rec['identificacao_origem']."/".$rec['identificacao_destino'];
	$msg = $rec['mensagem'];
	$dataleitura = formataDataHora($rec['data_leitura']);
	$status = fledescricaotabela($rec['msg_status_id'],'msg_status',$conexao);
	
?>
   	<tr>
        <td><a href="chameFormulario.php?op=editamensagem&id=<?PHP echo($id);?>"><?PHP echo($id);?></a></td>
        <td><?PHP echo($assunto);?></td>
        <td><?PHP echo($dataenvio);?></td>
		<td><?PHP echo($origemdestino);?></td>
        <td> <textarea name="msg"  rows="4" cols="41"><?PHP echo($msg);?></textarea></td>
        <td><?PHP echo($dataenvio);?></td>
        <td><?PHP echo($status);?></td>
    </tr>    
<?php
}
?>
</table>        
</section>

