<?php

// funcao altera
function falteratipobloco($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipobloco set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipobloco','$q','$dataalteracao')";
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
