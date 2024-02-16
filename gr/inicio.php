
<?php
session_start();

if(isset($_SESSION['usuario_id'])){
	if($_SESSION['usuario_id']>0){
		header("Location:formulario.php?op=ListarLinks");
		break;
	}
}

$_SESSION["usuario_id"]=-1;
$_SESSION["nomeusuario"]="";
$_SESSION['msg']="";
$_SESSION['adm']=0;

header("Location: formulario.php?op=Iniciar");
break;
	
?>	