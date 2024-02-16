<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
if(!isset($_SESSION)){session_start();}

//date_default_timezone_set("Brazil/East");
date_default_timezone_set('America/Fortaleza');
$tempolimite =  36; //720;
$_SESSION['registro'] = time(); // armazena o momento em que autenticado //
$_SESSION['limite'] = $tempolimite;
$_SESSION['MaxLinhas'] = 5;
if(!$_SESSION['login']) die('');

define("BEFISIO", 'efisio');
define("BPESSOAL", 'pessoal');

?>