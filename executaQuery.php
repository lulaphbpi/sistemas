<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include("../include/sa000.php");
include("conexao.php");
$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}

$resposta="SAIDA:";
$comando=$_GET['comando'];
$comando = str_replace("**", "%", $comando);//die($comando);
$comando = str_replace("\\", " ", $comando);
//die ($comando);
$rec=mysql_query($comando,$conexao);
//$r=mysql_fetch_array($rec);
//die($r[1]);
//die($comando);
if(strtoupper(left($comando,6))=="DELETE" || strtoupper(left($comando,6))=="UPDATE"){
}else{
if($rec){
	while($r=mysql_fetch_array($rec)){
		$nc=count($r);
		//die("tamanho:".$nc." - ".$r[0]." - ".$r[1]);
		$l="";
		
		for($i = 0; $i < $nc/2; $i++){
			$l=$l.$r[$i]." ";
		}
		$resposta=$resposta."\n".$l;
	}	
}
}
$titulo="SUPORTE - Query consultor";

$pvez=true; 
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="leQuery.php" method="post" id="iformulariosuporte" class="formulario">
<table>
	  <tr>
	    <td colspan="2" align="center"><h5><?php echo($titulo);?></h5>
		</td>
	  </tr>

      <tr>
         <td>Comando: </td>
         <td><textarea name="comando"  rows="10" cols="100" ><?php echo($comando); ?></textarea>
         </td>
      </tr>
      <tr>
		<td>Resposta: </td>
         <td><textarea name="resposta"  rows="20" cols="100"><?php echo($resposta); ?></textarea>
         </td>
      </tr>
 	  <tr>
	    <td colspan="2">&nbsp;</td>
	  </tr>

	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulariosuporte" value="Enviar Resposta"/>
		</td>
	  </tr>
</table>

</form>
</section>
