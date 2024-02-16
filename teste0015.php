<html>
<head>
	<title>Passar Variável Javascript para PHP</title>
	<script type="text/javascript">
		var variaveljs = prompt('Digite s'); 
		
	</script>
</head>
<body>
	<?php 
		$variavelphp = "<script>document.write(variaveljs)</script>";
		echo "Olá $variavelphp";
	?>
</body>
</html>
