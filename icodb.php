<?php
include('../include/sa000.php');
$conacl=conexao('aclinica');

$requisicaoid=$_GET['id'];
$lereq=fleexamerequerido($requisicaoid,$conacl);
if($lereq){
}else{
	return;
}
$cod=$_GET['n'];
 
function fbarcode($valor){

$fino = 1 ;
$largo = 3 ;
$altura = 40 ;

  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1=9;$f1>=0;$f1--){
    for($f2=9;$f2>=0;$f2--){
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i=1;$i<6;$i++){
        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      }
      $barcodes[$f] = $texto;
    }
  }


//Desenho da barra


//Guarda inicial
?>
  <img src="p.gif" width="<?php echo $fino; ?>" height="<?php echo $altura; ?>" border="0">
  <img src="b.gif" width="<?php echo $fino; ?>" height="<?php echo $altura; ?>" border="0">
  <img src="p.gif" width="<?php echo $fino; ?>" height="<?php echo $altura; ?>" border="0">
  <img src="b.gif" width="<?php echo $fino; ?>" height="<?php echo $altura; ?>" border="0">
<?php
$texto = $valor ;
if((strlen($texto) % 2) <> 0){
	$texto = "0" . $texto;
}

// Draw dos dados
while (strlen($texto) > 0) {
  $i = round(esquerda($texto,2));
  $texto = direita($texto,strlen($texto)-2);
  $f = $barcodes[$i];
  for($i=1;$i<11;$i+=2){
    if (substr($f,($i-1),1) == "0") {
      $f1 = $fino ;
    }else{
      $f1 = $largo ;
    }
?>
   <img src="p.gif" width="<?php echo $f1; ?>" height="<?php echo $altura; ?>" border="0">
<?php
    if (substr($f,$i,1) == "0") {
      $f2 = $fino ;
    }else{
      $f2 = $largo ;
    }
?>
  <img src="b.gif" width="<?php echo $f2; ?>" height="<?php echo $altura; ?>" border="0">
<?php
  }
}

// Draw guarda final
?>
<img src="p.gif" width="<?php echo $largo; ?>" height="<?php echo $altura; ?>" border="0">
<img src="b.gif" width="<?php echo $fino; ?>" height="<?php echo $altura; ?>" border="0">
<img src="p.gif" width="<?php echo 1; ?>" height="<?php echo $altura; ?>" border="0">
  <?php
} //Fim da função

function esquerda($entra,$comp){
	return substr($entra,0,$comp);
}

function direita($entra,$comp){
	return substr($entra,strlen($entra)-$comp,$comp);
}?>
<html>
<head>
<title>Código de Barras</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
img { float:left; }	
</style>

</head>
<?php 
	foreach($lereq->fetchAll() as $rreq){
		$idc=$rreq['id'];
		$cod=fgeracodigo($idc,$conacl);
?>		
<div style="width:150px; float:left;">
	<div style="margin:10px 0 0 30; float:left;">
		<?php fbarcode($cod); // basta chamar essa função com o valor do código para gerar o código de barras ?>
	</div>
	<div style="margin:30px 0 20px 40px; text-align:center; float:left; position:absolute;">
		<h5><?php echo $cod; ?></h5>
	</div>
</div>
<!--
<div style="width:150px; float:left;">
	<div style="margin:10px 0 0 0; float:left;">
		<?php fbarcode($cod); // basta chamar essa função com o valor do código para gerar o código de barras ?>
	</div>
</div>
<br>
<div>
	<div style="margin:10px 0 20px 0; text-align:center; float:left; position:absolute;">
		<h5><?php echo $cod; ?></h5>
	</div>
</div>
--->
<?php
}
?>
