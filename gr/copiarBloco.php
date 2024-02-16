<?php
if(!isset($_SESSION)){session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

//Ler Relatorio
$idv=$_SESSION['relatorioid'];
$idrel=$_POST['id'];
$ssql="select * from bloco where relatorio_id=$idrel order by id";
$leu=mysql_query($ssql,$conexao);
$_SESSION['msg'] = 'NÃO Leu: '.$ssql;
if(mysql_num_rows($leu)>0){
  $_SESSION['msg'] = 'Leu. ';
  while($r=mysql_fetch_array($leu)) {
	  $id=fproximoid("bloco",$conexao);
	  $conteudo=$r['conteudo'];
	  $tipoblocoid=$r['tipobloco_id'];
	  $estiloid=$r['estilo_id'];
	  $sql="insert into bloco values ($id,$idv,$tipoblocoid,$estiloid,'$conteudo')";
	  //die ($sql);
	  $insert=mysql_query($sql,$conexao);
  }	
}	

header ('Location: chameFormulario.php?op=ultimos&obj=Bloco&menu=principal');
break;

?>