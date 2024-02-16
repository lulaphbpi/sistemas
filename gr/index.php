
<?php
session_start();

$_SESSION["usuarioid"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['texto']="";
$_SESSION['identificacao']='';
$_SESSION['adm']=0;
$_SESSION['login']=false;
$_SESSION['SystemError']=false;
$_SESSION['mural']="$"."mural";

header("Location: chameFormulario.php?op=iniciar");
?>	