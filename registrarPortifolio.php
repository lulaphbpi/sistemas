<?php
include('inicio.php');
include("include/finc.php");
	header ("Location: chameFormulario.php?op=registrar&obj=portifolio&cpl=f1&id=$spid");
    exit();
}

// Tratando envio de arquivo de Imagem (um por um)
if(isset($_FILES['arquivos'])){
       // var_dump($_FILES);
       // die("aqui ");
	$arquivos=$_FILES['arquivos'];
	$narq=count($arquivos['name']);
    $msg_erro='';
	if($narq > 0 and !$arquivos['name'][0]==''){ //die ("<p>Número de arquivos para enviar : $narq.</p>");
	    foreach($arquivos['name'] as $index => $arq){
			$msg_erro = $msg_erro . enviarImagem($arqdescricao, $arquivos['error'][$index], $arquivos['size'][$index], 
                                        $arquivos['name'][$index], $arquivos['tmp_name'][$index], $usuarioid, $pessoaid, $conefi) ;
		}	
        if($msg_erro!=''){ 
			$_SESSION['msg'] = "Um ou mais arquivos não foram enviados com sucesso!";
			$_SESSION['msg'] = $msg_erro;
		}	
        else    
            $_SESSION['msg'] = "Todos os arquivos foram enviados com sucesso!";
	}else{
		$_SESSION['msg'] = "<p>Nenhum arquivo selecionado para enviar!</p>";
	}
}else{
//if($rotina==$rotinaanterior) 
    die("SEM FILES ");
}
header ("Location: chameFormulario.php?op=registrar&obj=portifolio&cpl=f1&id=$spid");

?>