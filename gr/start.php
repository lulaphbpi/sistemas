<?php
  if(!isset($_SESSION)){session_start();}
  
  include("sa001.php");

  $plog=decod_palavra($_GET['plog']);
  $pmen=decod_palavra($_GET['pmen']);
  $pmur=decod_palavra($_GET['pmur']);
  $parq=decod_palavra($_GET['parq']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="www.rededeprogramas.com.br - Luiz de Brito" />
    <meta name="description" content="Desenvolvimento de Sites Dinamicos de diversas naturezas" />
    <meta name="keywords" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><meta property="og:image" content=""/>
    <meta property="og:title" content="" />
    <meta property="og:description" content="Criacao e Desenvolvimento de Sites Dinamicos, Lojas Virtuais, Site para qualquer finalidade" />
    <meta property="og:site_name" content="GR :: Programa de GERADOR DE RELATÓRIOS" />
    <meta name="City" content="Teresina-PI">
    <script type="text/javascript" src="js/js1.js"></script>
	<title>RDP/Lulaphbpi</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="css/style2.css" />
</head>
<body data-spy="scroll">
	<section id="barradelogin">
		<div class="row">
			<div id="login"  class="login col-md-12 col-lg-12 ">
				<div class="col-md-7 col-lg-7 ">
				</div>
				<div class="col-md-5 col-lg-5 ">
				<ul>
					<?php include($plog); ?>
				</ul>
				</div>
			</div>	
		</div>
	</section>
	<div id="container" class="row">
		<nav class="navbar navbar-default navbar-cls-top navbar-fixed-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header col-md-3 col-lg-3">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menubarra">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.html" class="navbar-brand">GR/RDP-Lulaphbpi</a>
			</div>
			<div class="collapse navbar-collapse col-md-9 col-lg-9" id="menubarra">
                <ul class="nav navbar-nav">
					<?php include($pmen); ?>
                </ul>
			</div>			
		</nav>
	</div>
	<section id="inicio">
	<div id="div0" class="row">
		<div id="div0a" class="col-md-12 col-lg-12">
			;nbspadfa
		</div>
	</div>	
	<div id="div1"  class="row">
		<div id="div11" class="col-md-3 col-lg-3">
			<ul>
				<?php include($pmur); ?>
			</ul>
		</div>
		<div id="div12" class="col-md-9 col-lg-9">
			<?php include($parq); ?>
		</div>
	</div>
	</section>
	
	<div id="rodp"  class="row">
		<div id="r1" class="col-md-12 col-lg-12">
			<div class="col-md-4 col-lg-4">
				<address>
				</address>	
			</div>
			<div class="col-md-4 col-lg-4">
				<address>
					<strong>Projeto Gerador de Relatórios - GR / RDP/Lulaphbpi</strong><br>
					<br>	
					Teresina - PI, 64057-400<br>
					<abbr title="Fone">P:</abbr> (86) 98104-9421
					<br><strong>Email</strong><br>
					<a href="mailto:#">lulaphbpi@rededeprogramas.com.br</a><br />
				</address>
			</div>
			<div class="col-md-4 col-lg-4">
				<address>
				</address>	
			</div>
		</div>
	</div>


	<script src="js/jq211.js" type="text/javascript"></script>	
	<script src="js/bootstrap.js" type="text/javascript"></script>	

</body>
</html>