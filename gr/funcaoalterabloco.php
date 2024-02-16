<?php

// funcao altera
function falterabloco($id,$tipobloco_id,$estilo_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE bloco set tipobloco_id='$tipobloco_id',estilo_id='$estilo_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'bloco','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
?>
