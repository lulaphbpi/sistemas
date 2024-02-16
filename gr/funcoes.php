<?php
function F_LeUsuarios($con){
	$ssql = "select * from usuario order by nome, id";
	$query = mysql_query($ssql, $con);
	return $query;		
}
	
function F_MontaSQLinks($id,$abrangencia,$ordem){
    if($abrangencia==0){
		$where=" where usuario_id='$id' and ativo<>9 ";
	}else{
    if($abrangencia==1){
		$where=" where usuario_id='$id' and ativo=1 ";
	}else{
		$where=" where usuario_id='$id' and ativo=2 ";
	}}
	if($ordem==0){
		$order=" order by id "; 
	}else{
	if($ordem==1){
		$order=" order by site,descricao "; 
	}
	}
	$sqlf="select * from links ".$where.$order;
	return $sqlf;
}
function F_MontaSQLinks2($id,$abrangencia,$ordem){
    if($abrangencia==0){
		$where=" where importante=1 and usuario_id='$id' and ativo<>9 ";
	}else{
    if($abrangencia==1){
		$where=" where importante=1 and usuario_id='$id' and ativo=1 ";
	}else{
		$where=" where importante=1 and usuario_id='$id' and ativo=2 ";
	}}
	if($ordem==0){
		$order=" order by id "; 
	}else{
	if($ordem==1){
		$order=" order by site,descricao "; 
	}
	}
	$sqlf="select * from links ".$where.$order;
	return $sqlf;
}

function F_LeLayOut($id,$con){
	$ssql = "select * from config where usuario_id='$id'";
	$query = mysql_query($ssql, $con);
	$rcfg = mysql_fetch_array($query);
	return $rcfg;
}

function F_Le_Tab($tab,$lim,$con){
	//$ssql = "select * from '$tab' order by id limit '$lim'";
	$ssql = "select * from ".$tab." order by id limit ".$lim;
	$query = mysql_query($ssql, $con);
    return $query;
}

function F_Le_Id_Tab($tab,$id,$con){
	//$ssql = "select * from '$tab' order by id limit '$lim'";
	$ssql = "select * from ".$tab." where id=".$id;
	$query = mysql_query($ssql, $con);
	if($query){
	   $reg = mysql_fetch_array($query);
	}else{
	   $reg="";
	}
    return $reg;
}

function F_Le_Prox_Id_Tab($tab,$con){
	$ssql = "select max(id) as id from ".$tab;
	$query = mysql_query($ssql, $con);
	//$nr=mysql_affected_rows($query);
	//ou
	$nr=mysql_num_rows($query);
	if($nr>0){
	//	die($nr);
	   $reg = mysql_fetch_array($query);
	   $proxid=$reg['id']+1;
	   
	}else{
		die("não gerou:".$ssql);
	   $proxid=1;
	}
    return $proxid;
}

function F_Num_Regs($tabela, $con){
	$ssql="select count(*) as quantidade from ".$tabela;
	$q=mysql_query($ssql, $con);
	if($q) {
  		$r=mysql_fetch_array($q);
	}else{
//		die("nao leu:".$q);
    	return 0;
	}
	return $r['quantidade']; 
}

?>