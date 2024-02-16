<?php
if(!isset($_SESSION)){session_start();}
$data=date("d-m-y h:m:s");
$usu=$_SESSION['identificacao'];
?>
<!-- Formulario Logado -->
	<!--		<div id="arealivre">
				
			</div> -->
        	<table id="itablelogado">
            	<tr>
                	<td>&nbsp;&nbsp;Sessão aberta em:&nbsp;&nbsp;</td>
                    <td><?php echo($data); ?></td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                	<td>&nbsp;&nbsp;Usuário:&nbsp;&nbsp;</td>
                    <td><a href="formulario.php?op=AlterarUsuario"><?php echo($usu);?></a></td>
                    <td></a></td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    	            <td><a href="sair.php" id="ifecharsessao">Sair</a></td>
        	        <td></td>
				</tr>
            </table>
