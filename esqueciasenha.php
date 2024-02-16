<?php
session_start();

date_default_timezone_set('America/Fortaleza');

$_SESSION['msg']="Envie solicitação para o e-mail cmrv@ufpi.edu.br";

header("Location: chameFormulario.php?op=iniciar&obj=sistema");
?>