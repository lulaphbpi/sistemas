<?php
include('inicio.php');
$_SESSION['rotina']='consultarPessoa-c1.php';
header ("Location: chameFormulario.php?op=consultar&obj=pessoa&cpl=c1");
exit();

?>