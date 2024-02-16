<?php

include('../include/sa000.php');
$conpes=conexao('pessoal');
$conacl=conexao('aclinica');

require_once '../mpdf/vendor/autoload.php';

//$stylesheet = file_get_contents('../include/css/estilo_doc1.css');
//$mpdf->WriteHTML($stylesheet,1);
$html="<style>
*{
    margin: 0;
    padding: 0;
}
html, body{
    width: 100%;
    height:100%;
    min-height: 90%;
    background-color: #FFF;
}
.pagina {
    margin-left: 120px;
    width: 94.11764705882353;
    height: 100%;
    min-height: 80%;
}
.logomarca {
	margin-top:100px;
    width: 80%;
	height: 100px;
    float: left;
}
.logomarca img {
    width: 280px;
	height: 100px;
    float: left;
}
.header-left {
    float: left;
}
.header-right {
    float: right;
}
.titulo {
	margin-top:35px;
	margin-left:10px;
    width:300px;
    float: left;
}
.referenciadepagina {
	margin-top:0px;
    width: 200px;
    float: left;
}
.conteudo {
    width: 80%;
	min-height: 820px;
    float: left;
	background-color: #FED;
}
.rodape {
    float: left;
    width: 80%;
    height: 100px;
    margin-top: 0px;
	background-color: #75F;
    font-size: 0.8em;
	bottom : 0;
	
    display: -webkit-flex;
    display: flex;
    -webkit-align-items: center;
    align-items: center;
    -webkit-justify-content: center;
    justify-content: center;

}

</style>
<div class='pagina'>
	<div class='header'>
		<div class='logomarca'>
			<img src='../include/img/aclinica.png'></img>
		<div>
		<div class='titulo'>
			<h5>Laboratório de Análises Clínicas</h5>
		</div>
		<div class='referenciadepagina'>
			<h5>Pág:</h5>
			<h5>Impresso em:</h5>
		</div>
	</div>
	<div class='conteudo'>
	
	</div>
	<div class='rodape'>
	</div>
</div>";
ob_end_clean();
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);

$mpdf->Output();

?>


