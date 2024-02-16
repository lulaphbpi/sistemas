<?php

//include('inicio.php');
include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');
//die('aqui');
require_once '../mpdf/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
//$mpdf->AddSpotColor('PANTONE 534 EC', 85, 65, 47, 9);

$mpdf->WriteHTML('<h1>MEU PRIMEIRO RELATÓRIO PDF!</h1><hr/>');

$mpdf->SetColumns(2);
$mpdf->WriteHTML('Some text...');
$mpdf->AutosizeText('Nome: Luiz Carlos Moraes de Brito',60,'','');
$mpdf->AddColumn();
$mpdf->AutosizeText('Luiz Carlos Moraes de Brito',60,'','');
$mpdf->WriteHTML('Next column...');
$tx="<div><span>Especifique um arquivo PDF externo para usar como modelo. Cada página do arquivo PDF de origem externa será usada como um modelo para a página correspondente em seu novo documento. Se o documento atual do mPDF tiver mais páginas do que o documento de origem do PDF externo, a última página continuará (opcionalmente) a ser usada para as páginas restantes.</span></div>";
$mpdf->writeHTML($tx);
$mpdf->CircularText(25,35,25,'Luiz Carlos M Brito');
$mpdf->Output();

?>


