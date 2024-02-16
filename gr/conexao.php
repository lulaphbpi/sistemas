<?php
 if(!isset($_SESSION)){session_start();}

date_default_timezone_set("Brazil/East");
$tempolimite =  36; //720;
$_SESSION['registro'] = time(); // armazena o momento em que autenticado //
$_SESSION['limite'] = $tempolimite;

$con_host="localhost";
$con_usuario="root";
$con_senha="trb";  //home
$con_base="funcional";

//Conecta ao servidor de BD

$conexao = conecta($con_host,$con_base,$con_usuario,$con_senha);

?>
