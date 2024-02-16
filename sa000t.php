<?php
function conexao($banco) {
$con_host='br902.hostgator.com.br';
$con_usuario='rededesi_lula001';
$con_senha='jojoca19@';  //home
$con_base='rededesi_'.$banco;

//Conecta ao servidor de BD
$conexao = conecta($con_host,$con_base,$con_usuario,$con_senha);
	
return $conexao;	
}

function conecta($server,$database,$usuario,$senha){
$con=false;
$dsn="mysql:dbname=$database;host=$server";
try {
    $con = new PDO($dsn, $usuario, $senha);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $dsn;
}
return $con;
}

function fletabelaporvalordecampo($tab,$cpo,$val,$con2) {
try {
	$sql = "select * from ".$tab." where ".$cpo."=".$val;
	$rs= $con2->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

?>