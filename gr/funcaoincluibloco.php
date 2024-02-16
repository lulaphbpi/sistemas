<?php

// funcao inclui
function fincluibloco($id,$tipobloco_id,$estilo_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("bloco",$con);
	$query = "insert into bloco values ('$id','$tipobloco_id','$estilo_id')";

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
