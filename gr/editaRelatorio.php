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

$id=$_SESSION['id'];
$_SESSION['relatorioid']=$id;
$reg=fleidtabela($id,'relatorio',$conexao);

$id=$reg['id'];
$identificador=$reg['identificador'];
$titulorelatorio=$reg['titulo'];
$descricao=$reg['descricao'];
$origem=$reg['origem'];
$funcao=$reg['funcao'];
$estilo_id=$reg['estilo_id'];

$titulo='Edita Relatório';

// Área de PK
//$rtabela=fletabela('tabela',$conexao);
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="alterarRelatorio.php" method="post" id="iformulario" class="formulario">
<table>
	  <tr>
	    <td colspan="2" align="center"><h5><?php echo($titulo);?></h5>
		</td>
	  </tr>

      <tr>
         <td>Id:         </td>
         <td>           <input type='text' name='id' size='5' maxlength='5' placeholder='Id' value='<?php echo($id);?>' required />
         </td>
      </tr>
      <tr>
         <td>Identificador:         </td>
         <td>           <input type='text' name='identificador' size='32' maxlength='30' placeholder='Identificador' value='<?php echo($identificador);?>' required />
         </td>
      </tr>
      <tr>
         <td>Título:         </td>
		 <td><textarea name="titulorelatorio"  rows="2" placeholder='Título' cols="100"><?php echo($titulorelatorio); ?></textarea> </td>
      </tr>
      <tr>
         <td>Descrição:         </td>
		 <td><textarea name="descricao"  rows="2" placeholder='Descrição' cols="100"><?php echo($descricao); ?></textarea> </td>
      </tr>
      <tr>
         <td>Origem:         </td>
         <td>           <input type='text' name='origem' size='32' maxlength='30' placeholder='Origem' value='<?php echo($origem);?>' required />
         </td>
      </tr>
      <tr>
         <td>Função:         </td>
         <td>           <input type='text' name='funcao' size='32' maxlength='30' placeholder='Função' value='<?php echo($funcao);?>' required />
         </td>
      </tr>
      <tr>
         <td>Estilo:         </td>
         <td>           <input type='text' name='estilo_id' size='2' maxlength='2' placeholder='Estilo' value='<?php echo($estilo_id);?>' required /> (1-Padrão)
         </td>
      </tr>

	  <tr>
	    <td colspan='2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulario" value="Salvar"/>
			&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=ultimos&obj=Relatorio&menu=principal">Cancelar</a>
			&nbsp;&nbsp;&nbsp;<input type="button" id="ibformulariobloco" value="Blocos"/>
		</td>
	  </tr>
</table>

</form>
</section>

<!--

