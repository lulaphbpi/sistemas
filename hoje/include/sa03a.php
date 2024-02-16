<?php

function fvermensagem($login){
try {
	if($login=='') return '';
	$sql='';
	$con=conexao('funcional');
	$res='';
	$sql="select * from msg where identificacao_destino='$login' and msg_status_id=1 order by id ";
	//die($sql);
	$leconf=$con->query($sql); 
	if($leconf->rowCount()>0){
		$res='Chegou nova mensagem para você. Favor entrar no Sistema de Mensagens!';
	}
	return $res;
}catch(PDOException $e) {
	$msg="Falha (fvermensagem): ".$e->getMessage().' - '.$sql;
	die($msg);
}
}

function ftrace($rotina, $descricao){
try {
	$des=addslashes($descricao);
	$sql='';
	echo('<br>ftrace1');

	$con=conexao('funcional', true);
	echo('<br>ftrace2');
	$sql="select * from configuracao order by id desc";
	$leconf=$con->query($sql);
	$rconf=$leconf->fetch();
	$permite=($rconf['permitetrace']=='S');
	if(!$permite) return true;	
	date_default_timezone_set('America/Fortaleza');	
	$data=date("y-m-d");
	$hora=date("H:i");
	$id=fproximoid('trace',$con);
	$sql="insert into trace (id, data, hora, rotina, descricao) values (
	$id, '$data', '$hora', '$rotina', '$des')";
	$exectrace=$con->query($sql);
}catch(PDOException $e) {
	$msg="Falha (ftrace): ".$e->getMessage().' - '.$sql;
	die($msg);
}
}

function floginout($login, $tipo, $conpes){
date_default_timezone_set('America/Fortaleza');	
//$sip=$_SERVER["REMOTE_ADDR"];
$sip=get_client_ip();
try{
	$data=date("y-m-d");
	$hora=date("H:i");
	$id=fproximoid("loginout",$conpes);
	$sql="insert into loginout (id, identificacao, data, hora, sinout,sip) values (
	$id, '$login', '$data', '$hora', '$tipo', '$sip' 
	)";
	$ins=$conpes->query($sql);
	if($ins){
		return true;
	}else{
		$_SESSION['msg']='Falha (floginout): '.$sql;
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (floginout) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fproximoid($tabela,$con) {
try {
	$q="select max(id) as maxid from ".$tabela;
	//die($q);
	$leu=$con->query($q);
	if($leu) {
		if($leu->rowCount()>0){
			$rec=$leu->fetch();
			$mi=$rec['maxid']; //die($mi);
			if(empty($mi) || $mi == null)
				$mi=0;
			if($mi=='' || $mi==0) {
				return 1;
			}else{	
				return $mi+1;
			}
		}else{
			die('aqui dd');
			return 1/0;
		}		
	}else{
		die('aqui 2 ss');
		return 1/0;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fproximoid) ' . $e->getMessage(). ' '. $dsn;
	return false;
}	
}

function leidtabela($tab,$id,$con){
    $sql="select * from $tab where id=$id";
	$leu=$con->query($sql);
	if($leu)
		if($leu->rowCount()>0){
			$reg=$leu->fetch();
			return $reg;
		}else
			return false;
	else
		return false;
}

function registraSenha($usu,$sen,$con){
	$senha=md5($sen);
	$sql="update usuario set senha='".$senha.
	"' where id=$usu";
	$exec=false;
	try {
		$exec= $con->query($sql);
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (registraSenha) ' . $e->getMessage(). ' '. $sql;
	}
	return $exec;
}

function fsimnao($sn) {
	if($sn==null) {
		$sn='N';
	}	
	if($sn=='S' or $sn=='s') {
		return 'S';
	}else{
		return 'N';
	}	
}

function incluihystory($obj,$sql,$usu,$con){
date_default_timezone_set('America/Fortaleza');	
try{
	$dataalteracao=date("y-m-d h:m:s");
	$q=addslashes($sql);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', '$obj', '$q', '$dataalteracao')";
	$inser = $con->query($q1); 
	if($inser) {
		return true;
	}else{
		return false;	
	}	
}catch(PDOException $e) {	
	$_SESSION['msg']='ERRO PDOException: (incluihystory) ' . $e->getMessage(). ' '. $q1;
	return false;
}
}

function fletabeladesc($tab,$ordem,$con2) {
try {
	$sql = "select * from ".$tab." order by ".$ordem." desc";  //die($sql);
	$rs= $con2->query($sql); //die($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (fletabeladesc) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function fletabela($tab,$ordem,$con2) {
try {
	$sql = "select * from ".$tab." order by ".$ordem;  //die($sql);
	$rs= $con2->query($sql); //die($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (fletabela) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function letabelaporid($tab,$id,$con) {
try {
	$sql="SELECT * from ".$tab." WHERE id=$id";
	//$trace=ftrace('letabelaporid',$sql);
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: Nenhum usuario encontrado -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Não leu tabela -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO exception: (letabelaporid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function fletabelaporvalordecampo($tab,$cpo,$val,$con2) {
try {
	$sql = "select * from ".$tab." where ".$cpo."=".$val;
	$rs= $con2->query($sql); // die($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fletabelaporvalordecampo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leregistroporvalordecampo($tab,$cpo,$val,$con2) {
try {
	$sql = "select * from ".$tab." where ".$cpo."=".$val;
	$rs= $con2->query($sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			return $rec;
		}else{
			return false;
		}
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleusuarios($con){
try {	
	$ssql="select u.*, p.nome as pessoanome
			from usuario as u
			inner join pessoa as p on u.pessoa_id=p.id
			order by p.nome";
//$trace=ftrace('fleusuarios',$ssql);			
	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (fleusuarios) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleusuarios) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function formataData($data){
	  $rData="";	
      $rData = implode("-", array_reverse(explode("/", trim($data))));
      return $rData;
}

function formataDataToBr($data){	  
	  $rData='';	
	  $d=explode(' ',$data);
	  if (!empty($d[0])){
                   $d1 = explode('-', $d[0]);
                   $rData= $d1[2].'/'.$d1[1].'/'.$d1[0]; 
				   //$trace=ftrace('formataDataToBr',$rData);
      }
	  if(!empty($d[1]))
		  $rData.=' '.$d[1];
	  return $rData;
}

function formataDataHora($data){	  
	  $rData="";	
	  if (!empty($data)){
				$sdt = explode(" ",$data);	
                $data = explode("-", $sdt[0]);
                $rData= $data[2].'/'.$data[1].'/'.$data[0]." ".$sdt[1];
      }
	  return $rData;
}

function pegaDatadeDataHora($datahora){
	  $rData="";	
	  if (!empty($datahora)){
				$sdt = explode(" ",$datahora);	
                $data = explode("-", $sdt[0]);
                $rData= $data[2].'/'.$data[1].'/'.$data[0];
      }
	  return $rData;
}

function sonumero($st) {
	$s1 = preg_replace( '/[^0-9]/', '', $st);
    $s1 = (string)$s1;
	return $s1;
}

function soalfanumerico($st) {
	$s1 = preg_replace( '/[^0-9a-zA-Z]/', '', $st);
    $s1 = (string)$s1;
	return $s1;
}

function convertNumStrToFloat($n){
	$ss = str_replace(',', '.', $n);
	return ($ss);
}

function convertFloatToNumStr($n){
	$ss = str_replace('.', ',', $n);
	return ($ss);
}

function fnumero($v,$t){
	$l=strlen($v);
	if($t<$l){
		return(right($v,$t));
	}else{
		if($t==$l){
			return($v);
		}else{
			$s='';
			for($i=0;$i<$t-$l;$i++){
				$s=$s.'0';
			}
			return($s.$v);
		}
	}
}

function fstring($s,$t){
	$l=strlen($s);
	if($t<$l){
		return(left($s,$t));
	}else{
		if($t==$l){
			return($s);
		}else{
			$x='';
			for($i=0;$i<$t-$l;$i++){
				$x=$x.' ';
			}
			return($s.$x);
		}
	}
}

function right($value, $count){
    return substr($value, ($count*-1));
}
 
function left($string, $count){
    return substr($string, 0, $count);
}
function formatarCNPJCPF ($string, $tipo)
{
    //$string = ereg_replace("[^0-9]", "", $string);
	$string = str_replace("[^0-9]", "", $string);
    if (!$tipo)
    {
        switch (strlen($string))
        {
        /*    case 10:    $tipo = 'fone';     break;
            case 8:     $tipo = 'cep';      break; 
            case 11:    $tipo = 'cpf';      break;
            case 14:    $tipo = 'cnpj';     break; */
        }
    }
    switch ($tipo)
    {
        case 'fone':
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . 
                '-' . substr($string, 6);
        break;
        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
        break;
        case 'cpf':
			if(strlen($string)<>11){return $string;}
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . 
                '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
        break;
        case 'cnpj':
			if(strlen($string)<>14){return $string;}
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . 
                '.' . substr($string, 5, 3) . '/' . 
                substr($string, 8, 4) . '-' . substr($string, 12, 2);
        break;
        case 'rg':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . 
                '.' . substr($string, 5, 3);
        break;
    }
    return $string;
}

function fpreenche($cpo,$val,$tip){
	//die("Campo:".$cpo);
	$lv=strlen($val);
	$lc=strlen($cpo);
	$ipoco=strpos($cpo,"@");
	if(!$ipoco){
	   if(substr($cpo,0,1)=='@'){
	   }else{	
			return $cpo;
	   }	
	}else{
		
	}   
	/*
	echo($cpo.'<br>');
	echo($val.'<br>');
	echo($lv.'<br>');
	echo($lc.'<br>');
	echo($ipoco.'<br>'); */
	
    $esq=left($cpo,$ipoco);
	$dir=substr($cpo,$ipoco+$lv,$lc-($ipoco+$lv));
	$ncpo=$esq.$val.$dir;
	//echo("/campo/".$cpo."/ esq/".$esq."/ dir/".$dir."/ novocampo/".str_replace(' ', '#',$ncpo).'<br>');
	return ($ncpo);
}

function fpreenchex($cpo,$val,$tip){
	//die("Campo:".$cpo);
	$lv=strlen($val);
	$lc=strlen($cpo);
	$ipoco=strpos($cpo,"@"); 
	if(empty($ipoco))
	   return $cpo;
    $esq=left($cpo,$ipoco);
	$dir=substr($cpo,$ipoco+$lv,$lc-($ipoco+$lv));
	$ncpo=$esq.$val.$dir;
	die("/campo/".$cpo."/ esq/".$esq."/ dir/".$dir."/ novocampo/".$ncpo);
	return ($ncpo);
}

function moedatobanco($get_valor) {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}	

function freplicate($char,$t){
	$s='';
	for($i=0;$i<$t;$i++){$s=$s.$char;}
	return $s;
}
	
function geraCodigoBarra($numero){
		$fino = 1;
		$largo = 3;
		$altura = 50;
		
		$barcodes[0] = '00110';
		$barcodes[1] = '10001';
		$barcodes[2] = '01001';
		$barcodes[3] = '11000';
		$barcodes[4] = '00101';
		$barcodes[5] = '10100';
		$barcodes[6] = '01100';
		$barcodes[7] = '00011';
		$barcodes[8] = '10010';
		$barcodes[9] = '01010';
		
		for($f1 = 9; $f1 >= 0; $f1--){
			for($f2 = 9; $f2 >= 0; $f2--){
				$f = ($f1*10)+$f2;
				$texto = '';
				for($i = 1; $i < 6; $i++){
					$texto .= substr($barcodes[$f1], ($i-1), 1).substr($barcodes[$f2] ,($i-1), 1);
				}
				$barcodes[$f] = $texto;
			}
		}
		
		echo '<img src="imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		
		echo '<img ';
		
		$texto = $numero;
		
		if((strlen($texto) % 2) <> 0){
			$texto = '0'.$texto;
		}
		
		while(strlen($texto) > 0){
			$i = round(substr($texto, 0, 2));
			$texto = substr($texto, strlen($texto)-(strlen($texto)-2), (strlen($texto)-2));
			
			if(isset($barcodes[$i])){
				$f = $barcodes[$i];
			}
			
			for($i = 1; $i < 11; $i+=2){
				if(substr($f, ($i-1), 1) == '0'){
  					$f1 = $fino ;
  				}else{
  					$f1 = $largo ;
  				}
  				
  				echo 'src="imagens/p.gif" width="'.$f1.'" height="'.$altura.'" border="0">';
  				echo '<img ';
  				
  				if(substr($f, $i, 1) == '0'){
					$f2 = $fino ;
				}else{
					$f2 = $largo ;
				}
				
				echo 'src="imagens/b.gif" width="'.$f2.'" height="'.$altura.'" border="0">';
				echo '<img ';
			}
		}
		echo 'src="imagens/p.gif" width="'.$largo.'" height="'.$altura.'" border="0" />';
		echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
		echo '<img src="imagens/p.gif" width="1" height="'.$altura.'" border="0" />';
		echo '<br>';
		echo $numero;
}

function datainicialdasemana($d) {
	$ts=strtotime($d);
	$numerododia=diadasemana($d,"d"); 
	//echo('<br>Numerododia:'.$numerododia);
	$dt=date("Ymd",$ts); 
	//echo('<br>'.$dt);
	$nextdate = subtraiDias($dt, $numerododia-1); //echo('<br>Proximo:'.$nextdate);    
    return $nextdate;	
}

function timeStamp($date){
	// $date no formato yyyymmdd
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $timestamp = mktime ( 0, 0, 0, $thismonth, $thisday, $thisyear );
	 return $timestamp;
}

function adicionaDias($date,$dias) {
	 // função corrigida em 30/08/2018
	 // 'date' de entrada no formato YYYYmmdd
	 // 'nextdate' é o timestamp calculado
	 // retorna 'date'+'dias' no formato Y-m-d
	 // tanto entrada como saída são datas
	 // no formato Ymd. $date pode ser uma string
	 // nesse formato:yyyymmaa
	 //$trace=ftrace('adicionadias:',$date);
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday + $dias, $thisyear );
	 return date('Ymd',$nextdate);
}
 
function subtraiDias($date,$dias) {
	// idem adicionaDias
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday - $dias, $thisyear );
	 return date('Ymd',$nextdate);
}

function diautil($data){
// retorna a data de um dia util mais próximo de $data ($data é uma data)
$ts=strtotime($data);
$dt=date('Ymd',$ts);
$pd=$dt;
$dd=diadasemana($data,'d');
//$trace=ftrace('diautil:',"data:$data diadasemana:$dd");
if($dd==1){
	$pd=adicionaDias($dt,1);
	//$trace=ftrace('diautil',"data:$dt proximodia:$pd");
}	
if($dd==7){
	$pd=subtraiDias($dt,1);
	//$trace=ftrace('diautil',"data:$dt proximodia:$pd");
}	
if($dd==8){
	$pd=subtraiDias($dt,2);
	//$trace=ftrace('diautil',"data:$dt proximodia:$pd");
}	
return $pd;
}

function diadasemana($data,$tipo){
	//$data é uma data 
	$semana=array(
			array(1, "sun", "dom", "domingo"),
			array(2, "mon", "seg", "segunda"),
			array(3, "tue", "ter", "terça"),
			array(4, "wed", "qua", "quarta"),
			array(5, "thu", "qui", "quinta"),
			array(6, "fri", "sex", "sexta"),
			array(7, "sat", "sab", "sábado"));
	$timestamp = strtotime($data);
	$diasem=date("w", $timestamp);
	if($tipo=="d")
		return $semana[$diasem][0];
	elseif ($tipo=="n")
		return $semana[$diasem][2];
	elseif ($tipo=="N")
		return $semana[$diasem][3];
	else
		return $semana[$diasem][1];
}

function geraIdentificacao($a, $con){
	$identificacao=soalfanumerico(strtolower($a));
	$sql="select * from usuario where identificacao = '$identificacao'";
	$k=0;
	$continua=true;
	while ($continua) {
		$leu=leUsuarioPorIdentificacao($identificacao,$con);
		if($leu) {
			$k=$k+1;
			$identificacao=$identificacao.$k;
			$identificacao=soalfanumerico(strtolower($identificacao));
			//die($identificacao);
		}else{
			$continua=false;
			return $identificacao;
		}
	}
}

/**
* Função para gerar senhas aleatórias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

function DateToStr($d) {
	if(gettype($d) == 'string') return $d;
	return date('Y-m-d', $d);
}

function datahoraatual(){
	$socket = fsockopen('udp://pool.ntp.br', 123, $err_no, $err_str, 1);
	if ($socket) {
    if (fwrite($socket, chr(bindec('00'.sprintf('%03d', decbin(3)).'011')).str_repeat(chr(0x0), 39).pack('N', time()).pack("N", 0)))
    {
        stream_set_timeout($socket, 1);
        $unpack0 = unpack("N12", fread($socket, 48));
        $data= date('Y-m-d H:i:s', $unpack0[7]);
    }

    fclose($socket);
	}
	return $data;
}

function convertestringparadata($sd){
	//formato sd: aaaa-mm-dd
	$ts=strtotime($sd);
	$dt=date("Y-m-d",$ts); //echo('<br>'.$dt);
	return $dt;
}

function CalculaDigitoMod11($NumDado, $NumDig, $LimMult){ 

$Dado = $NumDado; 
for($n=1; $n<=$NumDig; $n++){ 
$Soma = 0; 
$Mult = 2; 
for($i=strlen($Dado) - 1; $i>=0; $i--){ 
$Soma += $Mult * intval(substr($Dado,$i,1)); 
if(++$Mult > $LimMult) $Mult = 2; 
} 
$Dado .= strval(fmod(fmod(($Soma * 10), 11), 10)); 
} 
return substr($Dado, strlen($Dado)-$NumDig); 
} 

function idade($datnasc){
$data = new DateTime($datnasc ); 
$interval = $data->diff( new DateTime( date('Y-m-d') ) ); 
return $interval->format( '%Y');
}

function primeironome($nom){
if(isset($nom) && empty($nom) == false){
	$n=trim($nom);
	$noms=explode(' ',$n);
	return $noms[0];
}else{
	return '';
}
}

function validaCNS($cns) { 
		if ((strlen(trim($cns))) != 15) { 
			return false;
		}
		$pis = substr($cns,0,11);
		$soma = (((substr($pis, 0,1)) * 15) +
		         ((substr($pis, 1,1)) * 14) +
			     ((substr($pis, 2,1)) * 13) +
			     ((substr($pis, 3,1)) * 12) +
			     ((substr($pis, 4,1)) * 11) +
			     ((substr($pis, 5,1)) * 10) +
			     ((substr($pis, 6,1)) * 9) +
			     ((substr($pis, 7,1)) * 8) +
			     ((substr($pis, 8,1)) * 7) +
			     ((substr($pis, 9,1)) * 6) +
			     ((substr($pis, 10,1)) * 5));
		$resto = fmod($soma, 11);
		$dv = 11  - $resto;
		if ($dv == 11) { 
			$dv = 0;	
		}
		if ($dv == 10) { 
			$soma = ((((substr($pis, 0,1)) * 15) +
		              ((substr($pis, 1,1)) * 14) +
			          ((substr($pis, 2,1)) * 13) +
			          ((substr($pis, 3,1)) * 12) +
			          ((substr($pis, 4,1)) * 11) +
			          ((substr($pis, 5,1)) * 10) +
			          ((substr($pis, 6,1)) * 9) +
			          ((substr($pis, 7,1)) * 8) +
			          ((substr($pis, 8,1)) * 7) +
			          ((substr($pis, 9,1)) * 6) +
			          ((substr($pis, 10,1)) * 5)) + 2);
			$resto = fmod($soma, 11);
			$dv = 11  - $resto;
			$resultado = $pis."001".$dv;	
		} else { 
			$resultado = $pis."000".$dv;
		}
		if ($cns != $resultado){
            return validaCNS_PROVISORIO($cns);
        } else {
        	return true;
		}
}

function validaCNS_PROVISORIO($cns) {
		if ((strlen(trim($cns))) != 15) {
			return false;
		}
		$soma = (((substr($cns,0,1)) * 15) +
			((substr($cns,1,1)) * 14) +
			((substr($cns,2,1)) * 13) +
			((substr($cns,3,1)) * 12) +
			((substr($cns,4,1)) * 11) +
			((substr($cns,5,1)) * 10) +
			((substr($cns,6,1)) * 9) +
			((substr($cns,7,1)) * 8) +
			((substr($cns,8,1)) * 7) +
			((substr($cns,9,1)) * 6) +
			((substr($cns,10,1)) * 5) +
			((substr($cns,11,1)) * 4) +
			((substr($cns,12,1)) * 3) +
			((substr($cns,13,1)) * 2) +
			((substr($cns,14,1)) * 1));	
		$resto = fmod($soma,11);
		if ($resto != 0) {
			return false;
		} else {
			return true;
		}
}

function fvalidacrm($crm){
return true;
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
//function dateDifference($date_1 , $date_2 , $differenceFormat = '%h' )
//{
//    $datetime1 = date_create($date_1);
//    $datetime2 = date_create($date_2);
//    
//    $interval = date_diff($datetime1, $datetime2);
//    
//    return $interval->format($differenceFormat);
//    
//}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}	

function fpesquisatxt($tex,$cpo,$tab,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT t.*
		from $tab as t
		order by t.$cpo";
else	
$sql="SELECT t.*
		from $tab as t
		where t.$cpo like '%$tex%' order by t.$cpo";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisatxt) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function finiciarmatriztridimensional($m, $d1, $d2, $d3){
for ($k=0; $k<$d1; $k++){ // grupos
	for($i=0; $i<$d2; $i++){  // linhas
		for ($j=0; $j<$d3; $j++){ // colunas
			//echo($x[$k][$i][$j].'  ' );
			$m[$k][$i][$j]='';
		}	
	}	
}		
return $m;	
}	

function fmontareg_csv($l, $ac, $info, $nc){
	//print_r ($ac);
	// j = numero de campos
	// k = numero de linhas
	$l=trim(rtrim($l));
	$lt=strlen($l);
	$iniciou=$ac[0][0][0];
	$s=$ac[0][0][1];
	$j=$ac[0][0][2];
	$k=$ac[0][0][3];
	$trace=ftrace('fmontareg_csv','Parametros: l=%'.$l.'% info='.$info.' nc='.$nc.' lt='.$lt.' s='.$s.' j='.$j.' k='.$k);
	for($i=0;$i<$lt;$i++){
		$c=substr($l,$i,1);
		if($c=='"')
			if(!$iniciou){
				$iniciou=true;
				$s='';
			}else{
				$iniciou=false;
				$j++;
				if($j==$nc){
					$ac[$info][$k][$j]=$s;
					$trace=ftrace('j=nc ','info='.$info.' k='.$k.' j='.$j.' s='.$s);
					$j=0;
					$k++;
				}else{
					$ac[$info][$k][$j]=$s;		
					$trace=ftrace('j=<> ','info='.$info.' k='.$k.' j='.$j.' s='.$s);
				}		
			}
		else
			if($iniciou)
				$s=$s.$c;
	}	
	$ac[0][0][0]=$iniciou;
	$ac[0][0][1]=$s;
	$ac[0][0][2]=$j;
	$ac[0][0][3]=$k;
	
	return $ac;			
}	
/// Alterações a partir de 19/09/2022

function fidentifica_cd(){
	$m1="<h1>Ajuda</h1>";
	$m1=$m1."<p>1. Digite parte do texto e clique na lupa para consultar. Considere acentuação.</p>";
	return $m1;	
}

function fincluicodigo($id,$texto,$codigo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$idd=fproximoid("codigos",$con);
	$query = "insert into codigos (id, texto, codigo) values ('$idd','$texto','$codigo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'codigos','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
		$idd=0;
	}
	return $idd;
}

function tempermissaofuncional($t, $con){
	$sql="select * from configuracao";
	$rec=$con->query($sql);
	$reg=$rec->fetch();
	$i=$reg['permiteincluir'];
	$a=$reg['permitealterar'];
	$e=$reg['permiteexcluir'];
	$r=false;
	if($t=='i' and $i=='S'){$r=true;}
	if($t=='a' and $a=='S'){$r=true;}
	if($t=='e' and $e=='S'){$r=true;}
	return $r;
}

?>