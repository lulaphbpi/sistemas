<?php

define ('APHRASES', array (
   'Nowadays people know the price of everything and the value of nothing',
   'We do not see things as they are, we see things as we are',
   'Life becomes easier when you learn to accept an apology you never got',
   'Life has no limitation, except the ones you make',
   'Its fun to do the impossible. It always seems impossible until its done',
   'A mans true wealth is the good he does in the world',
   'The revelation of thought takes men out of servitude into freedom',
   'There is no easy way from the earth to the stars.',
   'Nearly all men can stand adversity, but if you want to test a man s character, give him power',
   'When you learn to survive without anyone, you can survive anything',
   'amazing')
);

define ('APHRASE', 'HOJE');

// Gerador de número aleatórios
// Faixa considerada: de 1 a 9
// Limites considerados: de 1 a 18
// Condição: se o número gerado for maior do que 9,
// então o número será o quociente inteiro da metade.
function naleat($n1, $n2) {
	$n=rand($n1, $n2);
	//if ($n>5){
		//echo('<br>'.$n.', ');	
	//	$n = (int)($n / 2);
	//}
    return $n;
}
function fdupc($cc, $con){
  $sql="select * from mapachar1 where cchar='".$cc."'";
  try {
	$rs=$con->query($sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			return chr($rec['tord']);
		}else{
			return $cc;
		}
	}else{
		return $cc;
	}
  } catch(PDOException $e) {
       die($e->getMessage().' '.$sql);
  }  
}

function fdupcr($ord, $con){
  $sql="select * from mapachar1 where tord=".$ord;
  try {
	$rs=$con->query($sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			return $rec['cchar'];
		}else{
			return $cc;
		}
	}else{
		return $cc;
	}
  } catch(PDOException $e) {
       die($e->getMessage().' '.$sql);
  }  
}

// alterado em 08/11/2021 para retornar palavra sem codificação

function cod2_palavra($palavra){
	return $palavra;
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
$a=str_split($palavra);
//echo('a='.$a.'<br>');
$paridade=0; 
$e='';
for($i=0;$i<count($a); $i++){ 
$e=$e.'('.ord($a[$i]).')';
	if($paridade==0){
	   $a[$i]=ord($a[$i])+4;
     $paridade=1;	   
	}elseif($paridade==2){
	   $a[$i]=ord($a[$i])+2; 
     $paridade=0;	   
	}else{
	   $a[$i]=ord($a[$i])+3; 
     $paridade=2;	   
  }     
	if($a[$i]>255){
    ftrace('ai',$a[$i]);
	  // $a[$i]=$a[$i]-255+20-1;
    ftrace('novo ai',$a[$i]); 
	}
}
//echo('e='.$e.'<br>'); 
$s='';
for($i=0;$i<count($a); $i++){ 
    $s=$s.'('.$a[$i].')';
    $a[$i]=chr($a[$i]);
}	
//echo('s='.$s.'<br>');
$sa=implode('',$a);
return($sa);
}

function decod_palavra($palavra){
	return $palavra;
$a=str_split($palavra);
//echo('a='.$a.'<br>');
$paridade=0;
//$e='';
for($i=0;$i<count($a); $i++){ 
//$e=$e.'('.ord($a[$i]).')';
	if($paridade==0){
	   $a[$i]=ord($a[$i])-4;
     $paridade=1;	   
	}elseif($paridade==2){
	   $a[$i]=ord($a[$i])-2; 
     $paridade=0;	   
	}else{
	   $a[$i]=ord($a[$i])-3; 
     $paridade=2;	   
  }
    if($a[$i]>18 and $a[$i]<32){
      ftrace('ai',$a[$i]);
     //  $a[$i]=255 - (20 - $a[$i])+1;
      ftrace('novo ai',$a[$i]); 
    }
} 
//echo('e='.$e.'<br>'); 
//$s='';
for($i=0;$i<count($a); $i++){ 
//    $s=$s.'('.$a[$i].')';
    $a[$i]=chr($a[$i]);
}	
//echo('s='.$s.'<br>');
$sa=implode('',$a);
return($sa);
}
function decod2_palavra($palavra){
	return $palavra;
$a=str_split($palavra);
$paridade=0;
for($i=0;$i<count($a); $i++){ 
	if($paridade==1){
	   $a[$i]=ord($a[$i])-3;
       $paridade=0;	   
	}else{
	   $a[$i]=ord($a[$i])-5; 
       $paridade=1;	   
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
function c_palavra($palavra){
 //$p = convert_uuencode($palavra);
 //$p = convert_uudecode($p);
 return $palavra;
}

function Kripto_v2($texto, $conexao){
$tamlinha=31; $ir='';
$ng=naleat(0,9); 
$ng=5;
$fpe1 = $texto;
$pord=ord($fpe1[0]);
if($pord>47 and $pord<58){ //de '0' a '9'
  $fpe1=chr(219).$fpe1;
//  ftrace('sa01.Kripto_v2','fpe1:'.$fpe1);
}  
$ti=strlen($fpe1); //die($fpe1.' '.$ti);
if($ti<8){
  $pfx=$ti.$fpe1.APHRASES[10]; 	
}else{
  $pfx=$fpe1; 	
} 
//ftrace('sa01.Kripto_v2','pfx:'.$pfx);
$ta=strlen($pfx);
$frase=APHRASES[$ng];
//$frase='Meu limão, meu limoeiro, meu pé de jacarandá';
//$frase='aeiouaeiouaeiouaeiouaeiouaeiou';
$lf=strlen($frase);
$kont=0;
$kp=0;
$sl = chr($ng+210); $st='';
//ftrace('sa01.Kripto_v2','sl:'.$sl);
for($i=0;$i<$ta;$i++) {
  $sl=$sl.$pfx[$i]; //ftrace('sa01.Kripto_v2 frase','sl:'.$sl);
  $sl=$sl.$frase[$kp]; //ftrace('sa01.Kripto_v2 frase','sl:'.$sl);
  $kp++;
  if ($kp>($lf-1)) {
    $kp=0;
  }
}
//----------------------------------------------------
$frase='aeiouuoiea';
$lf=strlen($frase);
$kp=0;
$sle=$sl; $sl='';
$ta=strlen($sle);
for($i=0;$i<$ta;$i++) {
  $sl=$sl.$sle[$i]; //ftrace('sa01.Kripto_v2 - aeiou...','sl:'.$sl);
  $sl=$sl.$frase[$kp]; //ftrace('sa01.Kripto_v2 - aeiou...','sl:'.$sl);
  $kp++;
  if ($kp>($lf-1)) {
    $kp=0;
  }
}
//----------------------------------------------------
$cc=''; $c1=''; $c2=''; $ct=''; $ir='';
$sle=$sl; $sl='';
$ta=strlen($sle);
for($i=0;$i<$ta;$i++) {
  $char=$sle[$i]; 	
  $tord=ord($char);	//ftrace('sa01.Kripto_v2','tord:'.$tord);
  if($tord>96 and $tord<123){ //de 'a' a 'z'
    if($c1=='') $c1=$char; else $c2=$char;
	$ct=$ct.$char; //ftrace('sa01.Kripto_v2','ct:'.$ct);
	if(strlen($ct)==2){
      $cc=fdupc($ct, $conexao);
      if(strlen($cc)==2){
        $ir=$ir.$c1;
	      $c1=$c2; $ct=$c2;
	    }else{
        $ir=$ir.$cc;
        $c1=''; $c2='';	$ct='';	
	    }
	}
  }else{
  	$ct=$ct.$char;
    $ir=$ir.$ct;
    $c1=''; $c2='';	$ct='';	
  }	  
}
if($ct<>'')
  $ir=$ir.$ct; 
//ftrace('sa01.Kripto_v2','ir:'.$ir);
//----------------------------------------------------
$sle=$ir;
$sl=''; $ir='';
$ta=strlen($sle);
for($i=0;$i<$ta;$i++) {
  $sl=$sl.$sle[$i];
  if(strlen($sl)==$tamlinha){
    $ir=$ir.cod_palavra($sl); //ftrace('sa01.Kripto_v2 - cod','ir:'.$ir);
    $sl='';
  }
}
if(strlen($sl)>0){
  $ir=$ir.cod_palavra($sl); //ftrace('sa01.Kripto_v2 - cod','ir:'.$ir);
}
return $ir;
}

function DKripto_v2($texto, $conexao){
$tamlinha=31;
//--------f03rev.php--------------------------------------------
$sle=$texto; //echo($sle);
$ti=strlen($sle);
$sl=''; $ir='';
for($i=0;$i<$ti;$i++){
  $sl=$sl.$sle[$i];	
  if(strlen($sl)==$tamlinha){
	$ir=$ir.decod_palavra($sl);
    $sl='';
  }  
}
if(strlen($sl)>0){
  $ir=$ir.decod_palavra($sl);
}
//---------f02rev.php-------------------------------------------
$cc=''; $c1=''; $c2=''; $ct='';
$sle=$ir; $ir='';
$ta=strlen($sle);
for($i=0;$i<$ta;$i++) {
  $char=$sle[$i];
  $tord=ord($char);	
  if($tord>219 and $tord<245){
    $cc=fdupcr($tord, $conexao);
    $ir=$ir.$cc; 
  }else{
    $ir=$ir.$char;
  }	  
}
//------------f01passo2rev.php----------------------------------------
$kp=0;
$sle=$ir; $ir='';
$ta=strlen($sle);
for($i=0;$i<$ta;$i++) {
  $char=$sle[$i];
  if($kp==0)	{
    $ir=$ir.$char;
    $kp=1;
  }else{
	$kp=0;  
  }	
}
//-----------f01rev.php-----------------------------------------
$sle=$ir; $ir='';
$ta=strlen($sle);
$sord='';
for($j=0;$j<$ta;$j++){
    $sord=$sord.'('.ord($sle[$j]).')';
}
//echo($sord);
$i=0;
$char=$sle[$i]; $i++;
$char=$sle[$i]; 
$tord=ord($char);
if ($tord>48 and $tord<58){
  $nc=intval($char);
  $j=0; $tx=''; $b=0;
  $i++;
  $char=$sle[$i];
  while($j<$nc){
    $i++;
    $char=$sle[$i];
    if($b==0){
      if($char==chr(219)){
        $i++;
        $j++;
      }else{
	    $tx=$tx.$char; 
        $j++;
        $b=1;
      }
	}else{
	  $b=0;
	}
  }
}else{
  $tx=''; $b=0; 
  $kont=true;
  while($kont){
	if($b==0){
      if(ord($char)==219){
        $i++;  
      }else{
        $tx=$tx.$char; 
	    $b=1;
      }
    }else{
	  $b=0;
	}
	$i++;
	if($i==$ta){
      $kont=false;
    }else{
      $char=$sle[$i];
    }
  }
}
return $tx;
}

//fim sa01
?>