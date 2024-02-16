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
$descricao='';

$titulo='Novo Tipo de Bloco';

// Área de PK
//$rtabela=fletabela('tabela',$conexao);
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="cadastrartipoBloco.php" method="post" id="iformulario" class="formulario">
<table>
	  <tr>
	    <td colspan="2" align="center"><h5><?php echo($titulo);?></h5>
		</td>
	  </tr>

      <tr>
         <td>Id:         </td>
         <td>           <input type='text' name='id' size='2' maxlength='0' placeholder='Id' value='<?php echo($id);?>' required />
         </td>
      </tr>
      <tr>
         <td>Descrição:         </td>
         <td>           <input type='text' name='descricao' size='32' maxlength='30' placeholder='Descrição' value='<?php echo($descricao);?>' required />
         </td>
      </tr>

	  <tr>
	    <td colspan='2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulario" value="Salvar"/>
		</td>
	  </tr>
</table>

</form>
</section>

<!--

