<?php
include('../include/sa000.php');

$d=date('Y-m-d');
$d=formataDataToBr($d);
$r=5;
echo('fgeraguia: d='.$d.'  r='.$r.'<br>');
echo(fgeraguia($d,$r));

?>