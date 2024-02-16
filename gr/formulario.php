<?php
// Seleciona arquivo para include no Index

session_start();
include("sa001.php");
$op=$_GET['op'];
if($op<>'Iniciar'){
$adm=0;
if(isset($_SESSION['usuario_id'])){
	if($_SESSION['usuario_id']==0){
	    $_SESSION["usuario_id"]=-1;
	}else{
		//$adm=$_SESSION['adm'];
		if($op=='MeusDados'){
			$meusdados=cod_palavra("meusdados.php");
			$formulariologado=cod_palavra("formulariologado.php");
			$menuadm=cod_palavra("menuadm.php");
			$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$meusdados";	
			header($headerx);			
			exit();
		}else{
		if($op=='CadastrarInfo'){
			$formularioinfo=cod_palavra("formularioinfo.php");
			$formulariologado=cod_palavra("formulariologado.php");
			$menuadm=cod_palavra("menuadm.php");
			$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioinfo";	
			header($headerx);			
			exit();
		}else{
			
		}
		}
	}
}else{
    $_SESSION["usuario_id"]=-1;
    $_SESSION["nomeusuario"]="";
	$_SESSION['msg']="";
}
$usuarioid=$_SESSION['usuario_id'];
$nomeusuario=$_SESSION['nomeusuario'];
}

$formulariologin=cod_palavra("formulariologin.php");

$formulariologado=cod_palavra("formulariologado.php");
$menuusuario=cod_palavra("menuusuario.php");

$formularioquemsomos=cod_palavra("formularioquemsomos.php");
$formularioajuda=cod_palavra("formularioajuda.php");
$formulariocontato=cod_palavra("formulariocontato.php");
$menuesquerda=cod_palavra("menuesquerda.php");
$formulariousuario=cod_palavra("formulariousuario.php");
$formularioinicial=cod_palavra("formularioinicialbranco.php");
$formularioerro=cod_palavra("formularioerro.php");
$menuadm=cod_palavra("menuadm.php");
$meusuteis=cod_palavra("meusuteis.php");
$meusuteis2=cod_palavra("meusuteis2.php");
$links=cod_palavra("links.php");
$linksa=cod_palavra("linksa.php");
$links2=cod_palavra("links2.php");
$links2a=cod_palavra("links2a.php");
$formulariolink=cod_palavra("formulariolink.php");
$formularioconfiguracao=cod_palavra("formularioconfiguracao.php");
$listausuarios=cod_palavra("listausuarios.php");
$formulariousuariodesativado=cod_palavra("formulariousuariodesativado.php");
$formularioutilidades=cod_palavra("formularioutilidades.php");
$formulariosugestoes=cod_palavra("formulariosugestoes.php");
$formularioimportante=cod_palavra("formularioimportante.php");
$formularioesqueciasenha=cod_palavra("formularioesqueciasenha.php");

$formulariomoeda=cod_palavra("formulariomoeda.php");
$cadastrarmoeda=cod_palavra("cadastrarmoeda.php");

if($op=='Moeda'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioinicial";
	}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariomoeda&op=Cadastrar";
	}
}else{
    if($op=='CadastrarMoeda'){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$cadastrarmoeda";
	}
}

if($op=='MenuUsuario'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$links";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioinicial";
		}
	}
}else{
if($op=='ListarLinks2'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$links2";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$links2";
		}
	}
}else{
if($op=='CadastrarLink'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formulariolink&op=Cadastrar";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariolink&op=Cadastrar";
		}
	}
}else{
if($op=='Cadastrar' || $op=='Alterar'){
	$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formulariousuario&op=$op";
}else{
if($op=='Iniciar'){
	$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioinicial";
}else{
if($op=='ErroLogin'){
	$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioerro";
}else{
if($op=='esqueciasenha'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioesqueciasenha";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioesqueciasenha";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioesqueciasenha";;
		}
	}
}else{
if($op=='importante'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioimportante";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioimportante";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioimportante";;
		}
	}
}else{
if($op=='quemsomos'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioquemsomos";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioquemsomos";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioquemsomos";;
		}
	}
}else{
if($op=='ajuda'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioajuda";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioajuda";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioajuda";;
		}
	}
}else{
if($op=='contato'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formulariocontato";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formulariocontato";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariocontato";;
		}
	}
}else{
if($op=='Utilidades'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formularioutilidades";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioutilidades";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioutilidades";;
		}
	}
}else{
if($op=='Sugestoes'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuesquerda&parq=$formulariosugestoes";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formulariosugestoes";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariosugestoes";;
		}
	}
}else{
if($op=='MeusUteis') {
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$meusuteis";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$meusuteis";
		}
	}
}else{
if($op=='MeusUteis2') {
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$meusuteis2";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$meusuteis2";
		}
	}
}else{
if($op=='TrocarLayOut1'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$linksa";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$linksa";
		}
	}
}else{
if($op=='TrocarLayOut2'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$links2a";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$links2a";
		}
	}
}else{
if($op=='AlterarUsuario'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formulariousuario&op=$op";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariousuario&op=$op";
		}
	}
}else{
if($op=='AlterarLink'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		$id=$_GET['id'];
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formulariolink&op=Alterar&id=$id";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariolink&op=Alterar&id=$id";
		}
	}
}else{
if($op=='UsuarioConfiguracoes'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$formularioconfiguracao";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioconfiguracao";
		}
	}
}else{
if($op=='GerenciarUsuarios'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$listausuarios";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formularioinicial";
		}
	}
}else{
if($op=='UsuarioDesativado'){
	if($usuarioid < 0 || $nomeusuario=='') {
		$headerx="Location: start.php?plog=$formulariologin&pmen=$menuusuario&parq=$formularioinicial";
	}else{
		if($adm==1){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuadm&parq=$listausuarios";	
		}else{
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuusuario&parq=$formulariousuariodesativado";
		}
	}
}
}}}}}}}}}}}}}}}}}}}}}
header($headerx);
?>