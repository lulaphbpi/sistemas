<?php
function conexao($banco) {
$a=false;
$local=!$a;	
if($local){	
$con_host='localhost';
$con_usuario='root';
$con_senha			= "sqls3rv3rbitbyte";  //home
$con_base=$banco; 
}else{
$con_host='localhost';
$con_usuario='root';
$$con_senha			= "sqls3rv3rbitbyte";  //home
$con_base=$banco; 
}
$con_senha			= 'trb';  //home
$conexao = conecta($con_host,$con_base,$con_usuario,$con_senha);
	
return $conexao;	
}

////////////////////////////////////////////////////////////////

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

////////////////////////////////////////////////////////////////

$servidor		= "localhost";

$usuario		= "root";

$senha			= "sqls3rv3rbitbyte";

$banco			= "prex_certificado_antigo";

$senha			= "trb";

$conn = conecta($servidor, $banco, $usuario, $senha);

if ($conn){

    $banco=$conn;

	if (!$banco){

		echo "Erro no banco";

	}
//echo ("conectou");
}

else{

echo ('Não conectou');
}

?>
