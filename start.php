<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
  if(!isset($_SESSION)){session_start();}
  if (isset($_SERVER['HTTPS']) )
  {
    //$_SESSION['msg']="SECURE: This page is being accessed through a secure connection.";
  }
  else
  {
    //$_SESSION['msg']="ATENÇÃO: Esta página está sendo acessada através de uma conexão insegura! Use https:// ao invés de http://";
  }  

  //////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%i' )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);
    
		$interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
	}	
  
  date_default_timezone_set('America/Fortaleza');
  $d1=date("Y-m-d H:i:s");
  $d2=$_SESSION['time'];
  $dif= dateDifference($d1,$d2);
  $contador=$_SESSION['contador'];
  //$contador++;
  //$_SESSION['contador']=$contador;


   if($dif>$contador){
//  echo('sessao: '.$_SESSION['time'].'<br>');
//  echo('d1 ...: '.$d1.'<br>');
//  die('dif: '.$dif);
	  $_SESSION['msg']='Sua sessão foi fechada pois ficou muito tempo inativa!';		
/*      
      echo('<br>');
      echo('<br>d1:'.$d1);
      echo('<br>d2:'.$d2);
      echo('<br>dif:'.$dif);
      echo('<br>Contador:'.$_SESSION['contador']);
      die('<br>'.$_SESSION['msg']);
*/      
	  header ("Location: index2.php");  //descomentar aqui e a próxima linha
	  exit;
  }
  
  $_SESSION['time']=$d1;
  
  include('../include/sa01.php');

  $plog=decod_palavra($_GET['plog']);
  $pmen=decod_palavra($_GET['pmen']);
  $pmur=decod_palavra($_GET['pmur']);
  $parq=decod_palavra($_GET['parq']);
  //$_SESSION['msg']=$parq;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="www.rededesistemas.com.br - Luiz de Brito" />
    <meta name="description" content="Desenvolvimento de Sites Dinamicos de diversas naturezas" />
    <meta name="keywords" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade, Biblioteca, Sistema Academico" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><meta property="og:image" content=""/>
    <meta property="og:title" content="" />
    <meta property="og:description" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade" />
    <meta property="og:site_name" content="efisio :: Escola Clínica de Fisioterapia - efisio - UFDPar " />
    <meta name="City" content="Parnaíba-PI">
	
<!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
-->
    <link href="css/custom2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilo1.css" />
    <link rel="stylesheet" type="text/css" href="css/estilo2.css" />
 <!--   <link rel="stylesheet" type="text/css" href="css/estilo3.css" />-->
	<script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/validator.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/bootstrap-combobox.js"></script>
	
    <script type="text/javascript" src="js/js1.js"></script>
    <title>efisio-UFDPAR</title>
	<link rel="shortcut icon" href="efisio.ico" />
</head>
<body data-spy="scroll">
    <div class="tudo">
        <div class="barra1login"> 
            <?php include($plog); ?>
        </div>
        <div class="barra2">
            <div class="barra2logo">
                <a href="index.php">
				<img src="img/efisio-2.png" alt="Consultório NAE">
                </a>
            </div>
            <div class="barra2menu">
                <?php include($pmen); ?>
            </div>
        </div>

        <div class="centro">
            <div class="mural">
                <?php include($pmur); ?>
            </div>
            <div class="areadetrabalho" style="background-image: url(../include/img/consultorio1.jpg);">
            <?php
            //$img = WideImage::load('../include/img/consultorio1.jpg');
            //$img = $_FILES('upLoad_img');
            //print_r($img);
            //$img=$img->crop('50% - 50', '50% - 50', '00, '00);
            //$img = new Imagick(__DIR__.'/include/img/consultorio1.jpg');
            //echo $img;
            ?>
		        <?php include($parq); ?>
            </div>
	</div>
	
	<div class="rodape">
            <address>
                <strong>Universidade Federal do Delta do Parnaíba - UFDPar</strong><br>
                <strong>Escola Clínica de Fisioterapia</strong><br>
		Avenida São Sebastião, 2819 - Nossa Sra. de Fátima - Parnaíba - PI, 64.202-020<br>
		<abbr title="Fone">Fone:</abbr> (86)0000-0000 
		<br><strong>Portal: </strong>
		<a href="https://ufdpar.edu.br" target="_blank">UFDPar</a><br />
            </address>
	</div>

    </div>     
</body>
</html>