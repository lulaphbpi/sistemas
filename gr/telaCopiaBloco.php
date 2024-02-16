
<?php
if(!isset($_SESSION)) {session_start();}

include('sa000.php');
include('conexao.php');

$mensagem="";
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>""){
		$mensagem="Mensagem:".$msg;
		$_SESSION['msg']="";
	}
}

$id=$_SESSION['relatorioid'];
$reg=fleidtabela($id,'relatorio',$conexao);
$titulorelatorio=$reg['titulo'];
$titulo="Cópia de Bloco";
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="copiarBloco.php" method="post" id="iformulario" class="formulario">

<table>
	  <tr>
	    <td colspan="2" align="center"><h5><?php echo($titulo);?></h5>
		</td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center"><h4>RELATÓRIO: <?php echo($titulorelatorio); ?></h4>
		</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>

      <tr>
         <td>Copiar do Id: </td>
         <td>           <input type='text' name='id' size='3' maxlength='3' placeholder='Id' value='<?php echo($id);?>' required />
         </td>
      </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulario" value="Copia"/>
		</td>
	  </tr>
</table>    
</form>
</section>
