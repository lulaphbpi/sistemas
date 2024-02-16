<?php

if(!isset($_SESSION)) {session_start();}

$login=$_SESSION['login'];
$usu=$_SESSION['usuarioid'];
$adm=$_SESSION['adm'];

include('sa000.php');
include('conexao.php');

$mensagem='';
$msg=$_SESSION['msg'];
if(isset($msg)){
	if($msg<>''){
		$mensagem='Mensagem:'.$msg;
		$_SESSION['msg']='';
	}
}

$id=0;
$bloco_id=0;
$linha=0;
$mascara='';

$titulo='Nova Linha';

$id1=$_SESSION['relatorioid'];
$reg1=fleidtabela($id1,'relatorio',$conexao);
$titulorelatorio=$reg1['titulo'];

$id2=$_SESSION['blocoid'];
$tipobloco=fletipobloco($id2,$conexao);
$titulorelatorio=$reg1['titulo']." - ".$tipobloco;

// Ãrea de PK
//$rtabela=fletabela('tabela',$conexao);
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="cadastrarlinha.php" method="post" id="iformulariolinha" class="formulario">
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
         <td>Id:         </td>
         <td>           <input type='text' name='id' size='2' maxlength='0' placeholder='Id' value='<?php echo($id);?>' required />
         </td>
      </tr>
      <tr>
         <td>NºLinha:         </td>
         <td>           <input type='text' name='linha' size='2' maxlength='0' placeholder='NºLinha' value='<?php echo($linha);?>' required />
         </td>
      </tr>
      <tr>
         <td>Máscara:         </td>
         <td><textarea name="mascara"  rows="1" placeholder='Máscara' cols="132"><?php echo($mascara); ?></textarea> 
         </td>
      </tr>
      <tr>
         <td>&nbsp;        </td>
         <td>12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789
         </td>
      </tr>

	  <tr>
	    <td colspan='2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulariolinha" value="Salvar"/>
		</td>
	  </tr>
</table>

</form>
</section>

<!--

