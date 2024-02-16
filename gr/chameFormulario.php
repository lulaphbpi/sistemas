<?php
// Seleciona arquivo para include no Index

if(!isset($_SESSION)){session_start();}

$login=$_SESSION['login'];
$adm=$_SESSION['adm'];

include("sa001.php");

$op=$_GET['op'];
$obj=$_GET['obj'];
$menu=$_GET['menu'];

$usuarioid=$_SESSION["usuarioid"];
$nomeusuario=$_SESSION['nomeusuario'];

$formulariologin=cod_palavra("formularioLogin.php");
$menuinicial=cod_palavra("menuInicial.php");
$mural=cod_palavra("mural.php");
$formularioinicial=cod_palavra("formularioInicial.php");

$menuadm=cod_palavra("menuAdm.php");
$menutabela=cod_palavra("menuTabela.php");

$formularioerro=cod_palavra("formularioErro.php");
$formulariosenhaalterada=cod_palavra("formulariosenhaalterada.php");

$formulariologado=cod_palavra("formularioLogado.php");
$formulariosobre=cod_palavra("formularioSobre.php");
$formularioajuda=cod_palavra("formularioAjuda.php");
$formulariocontato=cod_palavra("t001contato.html");
$formularioesqueciasenha=cod_palavra("formularioEsqueciaASenha.php");

$formularioalterasenha=cod_palavra("formularioalterasenha.php");
$configuracao=cod_palavra("configuracao.php");
$formulariolistasugestoes=cod_palavra("formulariolistasugestoes.php");

$headerx="";
if($op=='iniciar'){
	if($login){
		header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formularioinicial");
	}else{	
		header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formularioinicial");
	}
	exit;
}

if($op=='errologin'){
	header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formularioerro");
	exit;
}

if($op=='senhaalterada'){
	header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formulariosenhaalterada");
	exit;
}

if($op=='esqueciasenha'){
	header("Location: start.php?plog=".$plog."&pmen=".$pmen."&parq=$formularioesqueciasenha");
	exit;
}

if($op=='importante'){
	header("Location: start.php?plog=".$plog."&pmen=".$pmen."&parq=$formularioimportante");
	exit;
}

if($op=='sobre'){
	if($login){
		header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formulariosobre");
	}else{	
		header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formulariosobre");
	}
	exit;
}	

if($op=='contato'){
	if($login){
		header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formulariocontato");
	}else{	
		header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formulariocontato");
	}
	exit;
}	

if($op=='ajuda'){
	if($login){
		header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formularioajuda");
	}else{	
		header("Location: start.php?plog=$formulariologin&pmen=$menuinicial&pmur=$mural&parq=$formularioajuda");
	}
	exit;
}	

if($op=='utilidades'){
	header("Location: start.php?plog=".$plog."&pmen=".$pmen."&parq=$formularioutilidades");
	exit;
}	

if($op=='sugestoes'){
	header("Location: start.php?plog=".$plog."&pmen=".$pmen."&parq=$formulariosugestoes");
	exit;
}	

if($op=='meusuteis') {
	header("Location: start.php?plog=".$plog."&pmen=".$pmen."&parq=$meusuteis");
	exit;
}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recebe de uma página com menu principal a 'operacao' e o 'objeto', redirecionando à página correta. 
// Se 'operacao' for 'edita', então lê o id do registro de edição salvando na SESSION correspondente.
if($menu=='principal') {
	if($op=='edita'){
		$_SESSION['id']=$_GET['id'];
	}
	$alvo=$op.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($op=='consultaVisita_Previa'){
	$alvo=$op.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='suporte'){
	$alvo="consultaSuporte.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='executaQuery'){
	//die ($obj);
	$alvo=$op.".php&comando=".$obj; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='alterarsenha'){
	$alvo="alterarSenha.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='consultaPlano_de_Negocio'){
	$alvo=$op.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='consultaAnalise_Tecnica'){
	$alvo=$op.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='consultaadm'){
	$alvo="consulta".$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='listaadm'){
	$alvo='lista'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='editaadm'){
	$_SESSION['id']=$_GET['id'];
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='editaadm1'){
	$_SESSION['id1']=$_GET['id1'];
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='cadastraadm'){
	$alvo='cadastra'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='falta'){
	$alvo="formularioEmFaseDeImplantacao.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo&obj=$obj");
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($op=='listamensagem'){
	$alvo="listaMSG.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='editamensagem'){
	$_SESSION['id']=$_GET['id'];
	$alvo="editaMSG.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
if($op=='mensagem'){
	$alvo="consultaMSG.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
if($op=='cadastramsg'){
	$alvo="cadastraMSG.php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=".$alvo);
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($op=='tabela'){
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=$formularioinicial");
	exit;
}
if($op=='listatab'){
	$alvo='lista'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=$alvo");
	exit;
}
if($op=='cadastratab'){
	$alvo='cadastra'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=$alvo");
	exit;
}
if($op=='editatab'){
	$_SESSION['id']=$_GET['id'];
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=$alvo");
	exit;
}
if($op=='editaBanco'){
	$_SESSION['bancoid']=$_GET['id'];
	$alvo=$op.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=$alvo");
	exit;
}
if($op=='consultatab'){
	$alvo='consulta'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menutabela&parq=".$alvo);
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($op=='movimentacao'){
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menufinanceiro&parq=$formularioinicial");
	exit;
}
if($op=='consultafin'){
	$alvo='consulta'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menufinanceiro&parq=".$alvo);
	exit;
}
if($op=='cadastrafin'){
	$alvo='cadastra'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menufinanceiro&parq=$alvo");
	exit;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($op=='cadastro'){
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$formularioinicial");
	exit;
}
if($op=='edita'){
	$_SESSION['id']=$_GET['id'];
	$alvo=$op.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$alvo");
	exit;
}
if($op=='editaComponente'){
	$_SESSION['componenteid']=$_GET['id'];
	$alvo=$op.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$alvo");
	exit;
}
if($op=='edita1'){
	$_SESSION['id1']=$_GET['id1'];
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$alvo");
	exit;
}
if($op=='lista'){
	$alvo=$op.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$alvo");
	exit;
}
if($op=='edita2'){
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menucadastro&parq=$alvo");
	exit;
}
if($op=='edita3'){
	$alvo='edita'.$obj.".php"; 
	header("Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$alvo");
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if($headerx==''){
	if($op=='menusocio'){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menusocio&parq=$formularioinicial";
	}else{
	if($op=='menuadm'){
		//die("Session[adm]:".$_SESSION['adm']);	
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formularioinicial";
	}else{
	if($op=='menuusuario'){
		$headerx="Location: start.php?plog=$formulariologado&pmen=$menuinicial&pmur=$menuadm&parq=$formularioinicial";
	}
	}}
}
header($headerx);

?>