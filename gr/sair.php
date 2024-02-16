
<?php
session_start();

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;

header("Location: chameFormulario.php?op=iniciar");
?>	