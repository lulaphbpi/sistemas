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
$_SESSION['blocoid']=$id;
$reg=fleidtabela($id,'bloco',$conexao);

$id=$reg['id'];
$tipobloco_id=$reg['tipobloco_id'];
$estilo_id=$reg['estilo_id'];
$conteudo=$reg['conteudo'];

$titulo='Edita Bloco';

$id1=$_SESSION['relatorioid'];
$reg=fleidtabela($id1,'relatorio',$conexao);
$titulorelatorio=$reg['titulo'];

// Área de PK
//$rtabela=fletabela('tabela',$conexao);
$rtipobloco=fletabela('tipobloco',$conexao);
$pvez=true;
?>

<section id="iformularioentrada">
<?php if($mensagem<>""){echo($mensagem );} ?>
<form action="alterarBloco.php" method="post" id="iformulario" class="formulario">
<table>
   	  <tr>
			<td colspan="2" align="center">
				<h4>RELATÓRIO: <?php echo($titulorelatorio); ?></h4>
			</td>
	  </tr>
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
         <td>Tipo de Bloco: </td>
        <td>
		    <select name="tipobloco_id"> 
				<option value=""></option>
				<?php foreach($rtipobloco->fetchAll() as $rectipobloco){
 ?>
                    <option value="<?php echo($rectipobloco['id']);?>" <?php if($rectipobloco['id']==$tipobloco_id){echo("selected");} ?>><?php echo($rectipobloco['descricao']); ?></option>
				<?php } ?>	
            </select>
		</td>
      </tr>
      <tr>
         <td>Estilo:         </td>
         <td>           <input type='text' name='estilo_id' size='2' maxlength='2' placeholder='Estilo' value='<?php echo($estilo_id);?>' required />
         </td>
      </tr>
	  <tr>
	    <td colspan='2'>&nbsp;</td>
	  </tr>
      <tr>
         <td colspan='2' class="regua">|.........1.........2.........3.........4.........5.........6.........7.........8.........9........10........11........12........13........14........15........16........17........18........19........
         </td>
      </tr>
      <tr>
         <td colspan='2' class="regua">|123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678
         </td>
      </tr>
      <tr>
		 <td colspan='2' class="regua"><textarea name="conteudo"  rows="10" placeholder='Conteúdo' cols="198"><?php echo($conteudo); ?></textarea>
		 </td>
      </tr>

	  <tr>
	    <td colspan='2'>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>
			<input type="button" id="ibformulario" value="Salvar"/>
			&nbsp;&nbsp;&nbsp;<a href="chameFormulario.php?op=ultimos&obj=Bloco&menu=principal">Cancelar</a>
		</td>
	  </tr>
</table>

</form>
</section>

