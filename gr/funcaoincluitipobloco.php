<?php

// funcao inclui
function fincluitipobloco($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipobloco",$con);
	$query = "insert into tipobloco values ('$id','$descricao')";

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
