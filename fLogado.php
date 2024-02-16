<?php
if(!isset($_SESSION)){session_start();}
include('inicio.php');
//$data=date("d-m-y h:m:s");
$usu=$_SESSION['identificacao'];

$data=date('Y-m-d H:i:s');	

try{
/*
$socket = fsockopen('udp://pool.ntp.br', 123, $err_no, $err_str, 1);
if ($socket)
{
    if (fwrite($socket, chr(bindec('00'.sprintf('%03d', decbin(3)).'011')).str_repeat(chr(0x0), 39).pack('N', time()).pack("N", 0)))
    {
        stream_set_timeout($socket, 1);
        $unpack0 = unpack("N12", fread($socket, 48));
       $data= date('Y-m-d H:i:s', $unpack0[7]);
    }

    fclose($socket);
}*/
}catch (PDOException $e) {
	$data=date('Y-m-d H:i:s');	
}	
?>
<!-- Formulario Logado -->
	<!--		<div id="arealivre">
				
			</div> -->
        	<table id="itablelogado">
            	<tr>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                	<td>&nbsp;&nbsp;Sessão aberta em:&nbsp;&nbsp;</td>
                    <td><?php echo($_SESSION['datahorag']); ?></td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                	<td>&nbsp;&nbsp;Usuário:&nbsp;&nbsp;</td>
                    <td><a href="sair.php"><?php echo($usu);?></a></td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    	            <td><a href="sair.php" id="ifecharsessao">Sair </a></td>
        	        <td><?php echo("&nbsp;&nbsp;&nbsp; - ".$_SESSION["ipcliente"]);?></td>
				</tr>
            </table>
