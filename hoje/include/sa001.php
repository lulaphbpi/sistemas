<?php

function cod2_palavra($palavra){
if($palavra=='') return $palavra;	
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==1){
	   $a[$i]=ord($a[$i])+3;
       $paridade=0;	   
	}else{
	   $a[$i]=ord($a[$i])+5; 
       $paridade=1;	   
	}
	if($a[$i]>255){
	   $a[$i]=$a[$i]-255+20-1;
	}
}
for($i=0;$i<count($a); $i++){ 
    $a[$i]=chr($a[$i]);
}	
$sa=implode('',$a);
return($sa);
}

function cod_palavra($palavra){
	return $palavra;
if($palavra=='') return $palavra;	
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==0){
	   $a[$i]=ord($a[$i])+3;
       $paridade=1;	   
	}else{
	   $a[$i]=ord($a[$i])+5; 
       $paridade=0;	   
	}
	if($a[$i]>255){
	   $a[$i]=$a[$i]-255+20-1;
	}
}
for($i=0;$i<count($a); $i++){ 
    $a[$i]=chr($a[$i]);
}	
$sa=implode('',$a);
return($sa);
}

function decod_palavra($palavra){
	return $palavra;	
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==0){
	   $a[$i]=ord($a[$i])-3;
       $paridade=1;	   
	}else{
	   $a[$i]=ord($a[$i])-5; 
       $paridade=0;	   
	}
    if($a[$i]<20){
       $a[$i]=255 - (20 - $a[$i])+1;
	}
} 
for($i=0;$i<count($a); $i++){ 
    $a[$i]=chr($a[$i]);
}	
$sa=implode('',$a); echo($sa);
return($sa);
}

function c_palavra($palavra){
 //$p = convert_uuencode($palavra);
 //$p = convert_uudecode($p);
 return $palavra;
}

function xcod_palavra($palavra){
	//return $palavra;
if($palavra=='') return $palavra;	
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==0){
	   $a[$i]=ord($a[$i])+3;
       $paridade=1;	   
	}else{
	   $a[$i]=ord($a[$i])+5; 
       $paridade=0;	   
	}
	if($a[$i]>255){
	   $a[$i]=$a[$i]-255+20-1;
	}
}
for($i=0;$i<count($a); $i++){ 
    $a[$i]=chr($a[$i]);
}	
$sa=implode('',$a);
return($sa);
}

function xdecod_palavra($palavra){
	//return $palavra;	
if($palavra=='') return $palavra;	
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==0){
	   $a[$i]=ord($a[$i])-3;
       $paridade=1;	   
	}else{
	   $a[$i]=ord($a[$i])-5; 
       $paridade=0;	   
	}
    if($a[$i]<20){
       $a[$i]=255 - (20 - $a[$i])+1;
	}
} 
for($i=0;$i<count($a); $i++){ 
    $a[$i]=chr($a[$i]);
}	
$sa=implode('',$a);
return($sa);
}


?>