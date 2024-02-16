<?php
function conexao($banco) {
$a=false;
$local=!$a;	
if($local){	
$con_host='localhost';
$con_usuario='root';
$con_senha='trb';  //home
//if($banco=='arhweb')
//	$con_senha='p4rn41b4';
$con_base=$banco;
}else{
$con_host='br902.hostgator.com.br';
$con_usuario='rededesi_lula001';
$con_senha='jojoca19@';  //home
$con_base='rededesi_'.$banco;
}
//Conecta ao servidor de BD
$conexao = conecta($con_host,$con_base,$con_usuario,$con_senha);
	
return $conexao;	
}

function conecta($server,$database,$usuario,$senha){
$con=false;
$dsn="mysql:dbname=$database;host=$server";
try {
    $con = new PDO($dsn, $usuario, $senha);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $dsn;
}
return $con;
}

function fproximoprotocolo($con){
$p='0';	
$sql="select protocolo from requisicao order by protocolo";
try {
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch();
			$p=$reg['protocolo'];
		}else{
		}
	}else{
		$_SESSION['erro']='ERRO: Ao ler tabela de requisicoes -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
$pega_data = date('Y-m-d H:i:s');
$ano_mes=date('Ym',strtotime($pega_data));
$ns='0001';
if(left($p,6)==$ano_mes){
	$n=substr($p,6,4);
	$ni=(int)$n+1;
	$ns=fnumero($ni,4);
}
$p1=$ano_mes.$ns;
$d=calculaDigitoMod11($p1, 1, 10, true);	
return $p1.$d;
}

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
	$con=conexao('funcional');
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
			$mi=$rec['maxid'];
			if($mi=='' || $mi==0) {
				return 1;
			}else{	
				return $mi+1;
			}
		}else{
			return 1/0;
		}		
	}else{
		return 1/0;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fproximoid) ' . $e->getMessage(). ' '. $dsn;
	return false;
}	
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

function fleprofessores($ordem, $con){
$sql="SELECT pp.id AS pessoaid, 
		pp.nome
		FROM pessoal.pessoa AS pp
		inner join pessoal.pessoafisica as pf on pp.id=pf.id
		inner join pessoal.institucional as i on i.pessoafisica_id=pf.id
		WHERE i.tipodevinculo_id=3 and pp.situacao_id<>3 order by pp.nome";
try {
	$rs=$con->query($sql);
	if($rs) {
		return $rs;
	}else{
		die($sql);
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fleprofessores) ' . $e->getMessage(). ' '. $sql;
	return false;
}	}

/*
function fleestagiarios($ordem, $con){
	$sql="SELECT pp.id AS pessoaid, 
			pp.nome, pu.ativo
			FROM pessoal.pessoa AS pp
			INNER JOIN psicoweb.usuario AS psiu ON psiu.pessoa_id=pp.id
			inner join pessoal.usuario as pu on pu.pessoa_id=pp.id
			INNER JOIN psicoweb.grupo AS pg ON pg.id=psiu.grupo_id
			WHERE pg.id=4 order by pp.nome";
} */
function leestagiarioporpessoaid($pid,$conpsi){
	$sql="SELECT e.*
			FROM psicoweb.estagiario AS e
			WHERE e.pessoa_id=$pid and e.ativo='S'";
try {
	$rs=$conpsi->query($sql);
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
    $_SESSION['msg']='ERROR: (leestagiario) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leestagiario($id,$conpsi){
	$sql="SELECT pp.id AS pessoaid, 
			pp.nome, pu.ativo
			FROM pessoal.pessoa AS pp
			INNER JOIN psicoweb.usuario AS psiu ON psiu.pessoa_id=pp.id
			inner join pessoal.usuario as pu on pu.pessoa_id=pp.id
			INNER JOIN psicoweb.grupo AS pg ON pg.id=psiu.grupo_id
			WHERE pp.id=$id";
try {
	$rs=$conpsi->query($sql);
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
    $_SESSION['msg']='ERROR: (leestagiario) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleoperadores($con){
$sql="SELECT u.identificacao, p.id, p.nome, n.descricao AS nivel, u.ativo
	FROM pessoal.pessoa AS p
	INNER JOIN pessoal.usuario as u ON u.pessoa_id=p.id
	INNER JOIN psicoweb.usuario AS v ON v.pessoa_id=p.id
	INNER JOIN psicoweb.niveldousuario AS n ON v.niveldousuario_id=n.id
	WHERE n.id<5 AND u.ativo='S'
	ORDER BY nivel, nome";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fleoperadores) ' . $e->getMessage(). ' '. $sql;
	return false;
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

function fgerareport($rep, $tit, $sql, $confun, $conpes, $conarh){
date_default_timezone_set("Brazil/East");
//Ler Relatorio
include('../arhweb/varreport.php');
$conpes=conexao('pessoal');
$conarh=conexao('arhweb');
$confun=conexao('funcional');

$rreport=flereport($rep,$confun);
//Inicializar Parametros
if($rreport){
	$relatorioid=$rreport['id'];
	$reptit=utf8_decode($rreport['titulo']);
	$idestilo=$rreport['estilo_id'];
	$restilo=fleestilo($idestilo,$confun);
	if($restilo){
		$papel=$restilo['papel'];
		$orientacao=$restilo['orientacao'];
		$fonte=$restilo['fonte'];
		$estilo=$restilo['estilo'];
		$nrolinhas=$restilo['nrolinhas'];
		$nrocolunas=$restilo['nrocolunas'];
		$alturalinha=$restilo['alturalinha'];
	}	
}else{
	return ("Relatório Não Encontrado:".$rep);
}
$nrolinhas=30;
//Inicializar Contadores
$pag=0; $linha=100; $data=date("d/m/Y");
//Inicializa Report
require_once '../fpdf/fpdf.php';
$pdf = new FPDF($orientacao,$unidade,$papel);
$pdf -> SetMargins($margemleft, $margemtop, $margemright);
$pdf -> SetAuthor($author);
$pdf -> SetTitle($titdoc);
$pdf -> AddPage();
$pdf -> SetXY($absX,$ordY);
$pdf -> SetFont($fonte, $estilofonte, $tamanhofonte);

//Ver Cabeçalho Inicial
$recbloco=flebloco($relatorioid,1,$confun);
if($recbloco){
	$st=utf8_decode($recbloco['conteudo']);
	$lin=explode("\n",$st);
	$tam=sizeof($lin);
	$i=0;
	while($i<$tam){
		$pdf -> Ln();
		$pdf -> Write($alturalinha, $lin[$i]);
		$i++;
	}
}
$vez=1;
$registros=0; //die($sql);
$rec=$conpes->query($sql);
if(!$rec) die($_SESSION['erro']);
foreach($rec->fetchAll() as $reg){
	$ids=$reg['id'];
	if($linha>$nrolinhas){
		if($vez<>1){
			$pdf -> AddPage();
			$pdf -> Ln();
			$pdf -> Ln();
			$pdf -> Ln();
			$pdf -> Ln();
			$pdf -> Ln();
		}
		$vez=2;	
		//Cabeçalho Página
		$pdf -> SetMargins($margemleft, $margemtop, $margemright);
		$pag++;
		$recbloco=flebloco($relatorioid,2,$confun);
		if($recbloco){
			$st=utf8_decode($recbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin); //die("tam".$tam);
			$i=0;
			while($i<$tam){
				$pdf -> Ln();
				$li=$lin[$i];
				//echo('<br>i:'.$i.'-'.$li.'\n');
				if($i==0){
					$p=substr("00".$pag,-2);
					//die($p);
					$li=str_replace("@@",$p,$li);
					//die($li);
				}elseif($i==1){
					$li=str_replace("@@/@@/@@@@",$data,$li);
				}elseif($i==3){
					//die($li);
					$titulo=fstring(utf8_decode($tit),90);
					$li=fpreenche($li,$titulo,"s");
				}elseif($i==4){ 	//				die($li);
				}
	
				//die('<br>'.$li);
				$pdf -> Write($alturalinha, $li);
				$i++;
			}
			//die('--');
		}			
		//Cabeçalho Detalhe
		$recbloco=flebloco($relatorioid,3,$confun);
		if($recbloco){
			$st=utf8_decode($recbloco['conteudo']);
			$lin=explode("\n",$st);
			$tam=sizeof($lin);
			$i=0;
			while($i<$tam){
				$pdf -> Ln();
				$pdf -> Write($alturalinha, $lin[$i]);
				$i++;
			}
		}			

		$linha=$minlinha;
	}
	$linha++;
	//Detalhe
	$recbloco=flebloco($relatorioid,4,$confun);
	if($recbloco){
		$st=utf8_decode($recbloco['conteudo']);
		$lin=explode("\n",$st);
		$tam=sizeof($lin);
		$i=0;
		while($i<$tam){
			$cps=$lin[$i];
			$ids=fnumero($ids,5);
			$cps=fpreenche($cps,$ids,"n");
			//$alcunha=fstring($reg['denominacaocomum'],12);
			//$cps=fpreenche($cps,$alcunha,"s");
			$nome=fstring(utf8_decode($reg['nome']),38);
			$cps=fpreenche($cps,$nome,"s");
			$datanas=formataDataToBr($reg['datanascimento']);
			$datanasc=fstring($datanas,10);
			$cps=fpreenche($cps,$datanasc,"s");
			$siape=fstring($reg['siape'],10);
			$cps=fpreenche($cps,$siape,"s");
			$fone=fstring($reg['fone'],21);
			$cps=fpreenche($cps,$fone,"s");
			$email=fstring(utf8_decode($reg['email']),22);
			$email=str_replace('@','#',$email);
			$cps=fpreenche($cps,$email,"s");
			$categoria=fstring(utf8_decode($reg['categoria']),7);
			$cps=fpreenche($cps,$categoria,"s");
			$cargo=fstring(utf8_decode($reg['cargo']),20);
			$cps=fpreenche($cps,$cargo,"s");
			$situacao=fstring(utf8_decode($reg['situacao']),10);
			$cps=fpreenche($cps,$situacao,"s");
			$cps=str_replace('#','@',$cps);

			$pdf -> Ln();
			$pdf -> Write($alturalinha, $cps);
			$registros++;
			$i++;
		}
	}			
	
}
$pdf -> Ln();
$pdf -> Write($alturalinha, '               ------------- Fim Report - '.$registros.' Registros Processados.');
$pdf -> Output();
return "Ok";
}

function leprotocoloagenda($p, $con){
	$ssql="select p.*, e.data, e.limite, e.quantidade, c.descricao as convenio
			from pessoaagenda as p
			inner join agenda as a on p.agenda_id=a.id
			inner join escala as e on a.escala_id=e.id
			inner join convenio as c on p.convenio_id=c.id
			where p.protocolo='$p'
			";
	try {
		$rs= $con->query($ssql);
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
		$_SESSION['msg']='ERROR PDOException: (leprotocoloagenda) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fleagendamentos($con){
$sql="SELECT p.*, c.descricao as convenio, e.data as datamarcada
	FROM pessoaagenda AS p 
	INNER JOIN convenio as c ON c.id=p.convenio_id
	inner join agenda as a on p.agenda_id=a.id
	inner join escala as e on a.escala_id=e.id
	order by datamarcada, convenio";
try {
	$rs= $con->query($sql);
	return $rs;
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fledisponiveis) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function flepacientesporoperador($op,$con){
$sql="SELECT t.*, p.nome, p.cnpjcpf AS cpf, p.denominacaocomum,
	p.fone, p.email, p2.denominacaocomum, c.descricao as condicao,
	r.id as requisicaoid, r.acompanhante,r.nomeentidade
	FROM psicoweb.triagem AS t 
	INNER JOIN pessoal.pessoa AS p ON p.id=t.pacientepessoa_id
	INNER JOIN pessoal.pessoa AS p2 ON p2.id=t.operadorpessoa_id
	INNER JOIN psicoweb.condicaodopaciente as c on c.id=t.condicaodopaciente_id
	inner join psicoweb.requisicao as r on r.triagem_id=t.id
	WHERE t.situacaotriagem_id=3 and t.operadorpessoa_id=$op";
try {
	$rs= $con->query($sql);
	return $rs;
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fledisponiveis) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fletabela($tab,$ordem,$con2) {
try {
	$sql = "select * from ".$tab." order by ".$ordem;  //die($sql);
	$rs= $con2->query($sql); //die($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function fletabelaporvalordecampo($tab,$cpo,$val,$con2) {
try {
	$sql = "select * from ".$tab." where ".$cpo."=".$val;
	$rs= $con2->query($sql);
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

function fhistoricopsi($id, $conpsi){
	return 'Histórico de Psicologia '.$id;
}

function fidentificasala($salaid,$convin){
    $ret="<h4> Identificando Sala ".$salaid." </h4>";
	return $ret;
}

function fidentificapessoanae($cpf, $pid, $con, $connae){
if($pid>0)	
	$rpes=lepessoafisicaporid($pid,$con);
else
	$rpes=lepessoafisicaporcpf($cpf, $con);
if($rpes){
    $ret="<h4> Identificando CPF ".formatarCNPJCPF($cpf,'cpf')." </h4>";
	$ret=$ret."<h3><strong>Alcunha/Nome:</strong> ".$rpes['apelido']." / ".$rpes['nome']."</h3>";
	$ret=$ret."<br><strong>Data Nascimento:</strong> ".formataDataToBr($rpes['datanascimento']);
	$ret=$ret."<br><strong>Sexo:</strong> ".$rpes['sexo'];
	$ret=$ret."<br><strong>RG:</strong> ".$rpes['rg'];
	$pexp=$rpes['expedidorrg_id'];
	$rrg=leexpedidorrg($pexp,$con);
	if($rrg) {
		$ret=$ret."  <strong>Expedida por:</strong> ".$rrg['descricao'];
	}
	$pfor=$rpes['formacaoprofissional_id'];
	$rfp=leformacaoprofissional($pfor,$con);
	$ret=$ret."<br><strong>Formação Profissional: </strong>".$rfp['descricao'];
	
	$render=fleenderecopessoa($pid,$con);
	$ret=$ret."<br><br><strong>Endereço:</strong>";
	$ret=$ret."<br>Logradouro: ".$render['logradouro']." Número: ".$render['numero'];
	$ret=$ret."<br>Complemento: ".$render['complemento'];
	$ret=$ret."<br>Bairro: ".$render['bairro']." Cidade: ".$render['municipio']." CEP: ".$render['cep'];
	$usu=leusuarioporpessoaid($pid,$con);
	$txusu='';
	if($usu){
		if($usu['ativo']=='S'){
			$txusu="<strong>Usuário Ativo</strong>";
		}else{
			$txusu="<strong>Usuário Desativado</strong>";
		}
		$txusu=$txusu.
		"  Nível: ".$usu['niveldeusuario'];
	}
	$usunae=leusuarionae($pid,$connae);
	if($usunae){
		$txusu=$txusu."<br><strong>Grupo</strong> ".$usunae['descricaogrupo']." ".$usunae['niveldousuario'];
	}	
	if($txusu=='')	{
		$ret=$ret."<br><br><strong>Não é usuário do sistema.</strong>";
	}else{
		$ret=$ret.'<br><br>'.$txusu;
	}
	
	$txpnae='';
	$rpesnae=lepessoanaeporpessoaid($pid,$connae);
	if($rpesnae){
		$csus=(!$rpesnae['cartaosus']=='') ? $rpesnae['cartaosus'] : 'Não apresentou';
		$txpnae="<strong>Paciente</strong><br>Natureza: ".$rpesnae['natureza'].
		"<br><strong>Cartão SUS:</strong> ".$csus.
		"<br><strong>Nome da Mãe:</strong> ".$rpesnae['nomemae'];
	}else{
		$txpnae='<strong>Não é Paciente</strong>';
	}
	if(!$txpnae=='')
		$ret=$ret.'<br><br>'.$txpnae;

	$ret=$ret."<br><br><strong>Fone: </strong>".$rpes['fone'];
	$ret=$ret."<br><strong>Email:</strong> ".$rpes['email'];
	return $ret;
}else{
	return "Registro Não Encontrado no Sistema!";
}	
}

function fidentificapessoaacl($cpf, $pid, $con, $conacl){
if($pid>0)	
	$rpes=lepessoafisicaporid($pid,$con);
else
	$rpes=lepessoafisicaporcpf($cpf, $con);
if($rpes){
    $ret="<h4> Identificando CPF ".formatarCNPJCPF($cpf,'cpf')." </h4>";
	$ret=$ret."<h3><strong>Alcunha/Nome:</strong> ".$rpes['apelido']." / ".$rpes['nome']."</h3>";
	$ret=$ret."<br><strong>Data Nascimento:</strong> ".formataDataToBr($rpes['datanascimento']);
	$ret=$ret."<br><strong>Sexo:</strong> ".$rpes['sexo'];
	$ret=$ret."<br><strong>RG:</strong> ".$rpes['rg'];
	$pexp=$rpes['expedidorrg_id'];
	$rrg=leexpedidorrg($pexp,$con);
	if($rrg) {
		$ret=$ret."  <strong>Expedida por:</strong> ".$rrg['descricao'];
	}
	$pfor=$rpes['formacaoprofissional_id'];
	$rfp=leformacaoprofissional($pfor,$con);
	$ret=$ret."<br><strong>Formação Profissional: </strong>".$rfp['descricao'];
	
	$render=fleenderecopessoa($pid,$con);
	$ret=$ret."<br><br><strong>Endereço:</strong>";
	$ret=$ret."<br>Logradouro: ".$render['logradouro']." Número: ".$render['numero'];
	$ret=$ret."<br>Complemento: ".$render['complemento'];
	$ret=$ret."<br>Bairro: ".$render['bairro']." Cidade: ".$render['municipio']." CEP: ".$render['cep'];
	$usu=leusuarioporpessoaid($pid,$con);
	$txusu='';
	if($usu){
		if($usu['ativo']=='S'){
			$txusu="<strong>Usuário Ativo</strong>";
		}else{
			$txusu="<strong>Usuário Desativado</strong>";
		}
		$txusu=$txusu.
		"  Nível: ".$usu['niveldeusuario'];
	}
	$usuacl=leusuarioacl($pid,$conacl);
	if($usuacl){
		$txusu=$txusu."<br><strong>Grupo</strong> ".$usuacl['descricaogrupo']." ".$usuacl['niveldousuario'];
	}	
	if($txusu=='')	{
		$ret=$ret."<br><br><strong>Não é usuário do sistema.</strong>";
	}else{
		$ret=$ret.'<br><br>'.$txusu;
	}
	
	$txpacl='';
	$rpesacl=lepessoaaclporpessoaid($pid,$conacl);
	if($rpesacl){
		$csus=(!$rpesacl['cartaosus']=='') ? $rpesacl['cartaosus'] : 'Não apresentou';
		$txpacl="<strong>Paciente</strong><br>Natureza: ".$rpesacl['natureza'].
		"<br><strong>Cartão SUS:</strong> ".$csus.
		"<br><strong>Nome da Mãe:</strong> ".$rpesacl['nomemae'];
	}else{
		$txpacl='<strong>Não é Paciente</strong>';
	}
	if(!$txpacl=='')
		$ret=$ret.'<br><br>'.$txpacl;

	$ret=$ret."<br><br><strong>Fone: </strong>".$rpes['fone'];
	$ret=$ret."<br><strong>Email:</strong> ".$rpes['email'];
	return $ret;
}else{
	return "Registro Não Encontrado no Sistema!";
}	
}

function fidentificapessoaarh($cpf, $pid, $con, $conarh){
if($pid>0)	
	$rpes=lepessoafisicaporid($pid,$con);
else
	$rpes=lepessoafisicaporcpf($cpf, $con);
if($rpes){
    $ret="<h4> Identificando CPF ".formatarCNPJCPF($cpf,'cpf')." </h4>";
	$ret=$ret."<h3><strong>Alcunha/Nome:</strong> ".$rpes['apelido']." / ".$rpes['nome']."</h3>";
	$ret=$ret."<br><strong>Data Nascimento:</strong> ".formataDataToBr($rpes['datanascimento']);
	$ret=$ret."<br><strong>Sexo:</strong> ".$rpes['sexo'];
	$ret=$ret."<br><strong>RG:</strong> ".$rpes['rg'];
	$pexp=$rpes['expedidorrg_id'];
	$rrg=leexpedidorrg($pexp,$con);
	if($rrg) {
		$ret=$ret."  <strong>Expedida por:</strong> ".$rrg['descricao'];
	}
	$pfor=$rpes['formacaoprofissional_id'];
	$rfp=leformacaoprofissional($pfor,$con);
	$ret=$ret."<br><strong>Formação Profissional: </strong>".$rfp['descricao'];
	
	$render=fleenderecopessoa($pid,$con);
	$ret=$ret."<br><br><strong>Endereço:</strong>";
	$ret=$ret."<br>Logradouro: ".$render['logradouro']." Número: ".$render['numero'];
	$ret=$ret."<br>Complemento: ".$render['complemento'];
	$ret=$ret."<br>Bairro: ".$render['bairro']." Cidade: ".$render['municipio']." CEP: ".$render['cep'];
	$usu=leusuarioporpessoaid($pid,$con);
	$txusu='';
	
	if($usu){
		if($usu['ativo']=='S'){
			$txusu="<strong>Usuário Ativo</strong>";
		}else{
			$txusu="<strong>Usuário Desativado</strong>";
		}
		$txusu=$txusu.
		"  Nível: ".$usu['niveldeusuario'];
	}
	$usupes=leusuarioarh($pid,$conarh);
	if($usupes){
		$txusu=$txusu."<br><strong>Grupo</strong> ".$usuarh['descricaogrupo']." ".$usupes['niveldousuario'];
	}
	
	if($txusu=='')	{
		$ret=$ret."<br><br><strong>Não é usuário do sistema.</strong>";
	}else{
		$ret=$ret.'<br><br>'.$txusu;
	}
	
	$txparh='';
	$rpesarh=lepessoaarhporpessoaid($pid,$conarh);
	if($rpesarh){
		$siape=(!$rpesarh['siape']=='') ? $rpesarh['siape'] : 'Não informado';
		$txparh="<strong>Siape: </strong>".$siape."<br><strong>Categoria: </strong> ".$rpesarh['categoria'].
		"<br><strong>Cargo: </strong> ".$rpesarh['cargo'].
		"<br><strong>Situação: </strong> ".$rpesarh['situacao'];
	}else{
		$txparh='<strong>Não Cadastrado em RH</strong>';
	}
	if(!$txparh=='')
		$ret=$ret.'<br><br>'.$txparh;

	$ret=$ret."<br><br><strong>Fone: </strong>".$rpes['fone'];
	$ret=$ret."<br><strong>Email:</strong> ".$rpes['email'];
	
	return $ret;
}else{
	return "Registro Não Encontrado no Sistema!";
}	
}

function registrarusuarioarh($pid, $identificacao, $senha, $conpes, $conarh){
$niveldousuarioid=2;
$sql1=''; $sql2='';
$pessoaid=$pid;
$niveldeusuario_id=4;
$grupo_id=3;
$leusuario=leusuarioporpessoaid($pessoaid,$conpes);
if(!$leusuario) {
	$id1=fproximoid('usuario',$conpes);
	$rp=lepessoafisicaporid($pessoaid,$conpes);
	$identificacao=geraIdentificacao($identificacao,$conpes);
	$sql1="insert into usuario 
			(id, identificacao, senha, pessoa_id, nivelusuario_id, ativo) 
			values (".
				$id1.",'".
				$identificacao."','".
				md5($senha)."',".
				$pessoaid.",".
				$niveldousuario_id.",".
				"'S'".
				")";
}
$leusuarioarh=leusuarioarh($pessoaid,$conarh);
if(!$leusuarioarh) {
	$id2=fproximoid("usuario",$conarh);
		$sql2="insert into usuario 
				(id, pessoa_id, niveldousuario_id, grupo_id) 
				values (".
				$id2.",".
				$pessoaid.",".
				$niveldousuario_id.",".
				$grupo_id.")";
		//die('sql2:'.$sql2);		
}
try {
	if(!$sql1=='') {
			//die('sql1 :'.$sql1);
			$conpes->beginTransaction();
			$sql=$sql1;
			$i1=$conpes->query($sql);
			if($i1){
				$msg=$msg.' Usuário Registrado com Sucesso! Anote Identificação ('.$identificacao.') e Senha ('.$senha.') com segurança.';
				$ssql="insert into sinicial values ('$identificacao', '$senha')";
				$i=$conpes->query($ssql);
				$conpes->commit();
				$hys=incluihystory('registrarusuarioarh', $ssql, $identificacao, $conarh);
			}else{
				$conpes->rollback();
				$msg=$msg.' Usuário não registrado em pessoal';
			}	
	}
	if(!$sql2==''){
			//die('sql2 :'.$sql2);
			$conarh->beginTransaction();	
			$sql=$sql2;
			$i2=$conarh->query($sql);
			if($i2){
				$conarh->commit();
				$sql=$sql2;   
				$hys=incluihystory('registrarUsuario-u1.php', $sql, $identificacao, $conarh);
				$msg=$msg."  Usuário atualizado em Arhweb";
			}else{
				$conarh->rollback();
				$msg=$msg.' Usuário não registrado em arhweb';
			}	
	}	
} catch(PDOException $e) {
			$msg=$msg.' ERRO Exception: (registrarusuarioarh) ' . $e->getMessage(). ' '. $sql;
} 
return $msg;	
}

function fleexamerequerido($id,$con){
try {
	$sql = "select er.*, e.sigla, e.descricao as exame,
			e.observacao, r.data as datarequisicao,
			r.guia, m.nome as medico, m.crm,
			c.id as convenio_id, c.descricao as convenio,
			ta.descricao as tipodeamostra
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join tipodeamostra as ta on e.tipodeamostra_id=ta.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			where r.id=$id
			order by exame";
		//die($sql);	
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleexamerequerido) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function fgeracodigo($idc,$con){
	$rexar=leexamerequerido($idc,$con);
	$cod=fnumero($rexar['requisicao_id'],5).
		 fnumero($rexar['exame_id'],3);
	return $cod;	 
}

function leprotocolo($p,$con){
try {
	$sql = "select p.*, e.data, 
			c.descricao as convenio
			from pessoaagenda as p
			inner join agenda as a on p.agenda_id=a.id
			inner join escala as e on a.escala_id=e.id
			inner join convenio as c on p.convenio_id=c.id
			where p.protocolo='$p'
			order by p.id desc";
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: PDOException(leprotocolo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	

}

function fgeraprotocolo($id,$dt){
	$dat=formataDataToBr($dt);
	$data=explode('/',$dat);
	$dd=$data[0];
	$mm=$data[1];
	$yy=$data[2];
	$tt=$dd+$mm+$yy-2000;
	$ss=fnumero($yy,4).fnumero($tt,3).fnumero($mm,2).fnumero($id,5);
	// 1 digito modulo 11 base 9
	$dv=CalculaDigitoMod11($ss,1,9);
	return $ss.$dv;	 
}

function flecodigodebarras($cod,$con){
	$cd=trim($cod);
	$rq=substr($cd,0,5);
	$id=substr($cd,5,3);
	//die('cd='.$cd.' rq='.$rq.' id='.$id);
	$sql = "select er.*, e.sigla, 
			e.descricao as exame, 
			r.guia, m.nome as medico, m.crm,
			ce.descricao as componente,
			ce.id as componentedeexame_id,
			ce.unidade, ce.referencia,
			ce.metodo, ce.notas, ce.nvalor,
			c.descricao as convenio
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			inner join componentedeexame as ce on ce.exame_id=e.id
			where er.requisicao_id=$rq 
			
			order by exame, ce.id"; // and e.id=$id
	//die($sql);
	try{
		$rs= $con->query($sql);
		if($rs) {
			return $rs;
		}else{
			return false;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (flecodigodebarras) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function leitemexamerequerido($ider, $ceid,$con){
try {
	$sql = "select ier.*
			from itemexamerequerido as ier
			where ier.examerequerido_id=$ider and ier.componentedeexame_id=$ceid
			order by ier.id desc";
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (leitemrexameequerido) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leitemrequisicaoporcodigo($ider, $idce, $con){
try {
	$sql = "select er.*, e.sigla, 
			e.descricao as exame, 
			r.guia, m.nome as medico, m.crm,
			c.descricao as convenio,
			ce.id as componentedeexame_id, 
			ir.valor1, ir.valor2
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			inner join componentedeexame as ce on ce.exame_id=er.exame_id
			inner join itemexamerequerido as ir on ir.examerequerido_id=er.id and ir.componentedeexame_id=ce.id
			where er.id=$ider and ce.id=$idce
			order by er.id desc";
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (leitemrequisicaoporcodigo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leexamerequerido($id,$con){
try {
	$sql = "select er.*, e.sigla, 
			e.descricao as exame, 
			r.guia, m.nome as medico, m.crm,
			c.descricao as convenio
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			where er.id=$id
			order by er.id desc";
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (leexamerequerido) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function fleexame($con){
try {
	$sql = "select e.*, t.descricao as material
			from exame as e
			inner join tipodeamostra as t on e.tipodeamostra_id=t.id
			order by e.descricao";
			
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleexame) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function leexame($id,$con){
try {
	$sql = "select e.*, t.descricao as material
			from exame as e
			inner join tipodeamostra as t on e.tipodeamostra_id=t.id
			where e.id=$id
			order by e.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (leexame) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function lecomponentedeexame($id,$con){
try {
	$sql = "select ce.*, e.sigla, e.descricao as exame,
			t.descricao as material
			from componentedeexame as ce 
			inner join exame as e on ce.exame_id=e.id
			inner join tipodeamostra as t on e.tipodeamostra_id=t.id
			where ce.id=$id
			order by e.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (lecomponentedeexame) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function flecomponentedeexame($id,$con){
try {
	$sql = "select e.*
			from componentedeexame as e
			where e.exame_id=$id
			order by e.id";
			
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flecomponentedeexame) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function leultimarequisicao($pid,$con){
try {
	$sql = "select r.*
			from requisicao as r 
			where r.pessoa_id=$pid
			order by r.guia desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (leultimarequisicao) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fatualizastatusreq($rid,$st,$usu,$con){
	$ssql = "update requisicao set statusrequisicao_id=$st where id=$rid"; 
	try {
		$rs= $con->query($ssql);
		if($rs) {
			return $rs;
			$sql=$ssql;   
			$hys=incluihystory('fatualizastatusreq', $sql, $usu, $conacl);

		}else{
			return false;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fatualizastatusreq) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function flemaparequisicao($con){
try {
	$sql = "SELECT r.*, p.nome, f.datanascimento, f.sexo, 
er.exame_id, er.datacoletada, er.horacoletada, codigo, 
e.sigla, e.descricao AS exame, ta.descricao AS material
FROM aclinica.requisicao AS r
INNER JOIN pessoal.pessoa AS p ON p.id=r.pessoa_id
INNER JOIN pessoal.pessoafisica AS f ON f.id=p.id
INNER JOIN aclinica.examerequerido AS er ON er.requisicao_id=r.id
INNER JOIN aclinica.exame AS e ON e.id=er.exame_id
INNER JOIN aclinica.tipodeamostra AS ta ON ta.id=e.tipodeamostra_id
WHERE r.statusrequisicao_id=2
ORDER BY exame, nome";
		//die($sql);	
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		$_SESSION['msg']='ERRO: (flemaparequisicao) Falha:'. $sql;
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO exception: (flemaparequisicao) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function flerequisicaoporpessoa($pid, $con){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, p.fone, p.email,  f.datanascimento, 	
			f.sexo, f.rg, m.id as medico_id, m.nome as mediconome, m.crm, 
			e.id as especialidade_id, e.descricao as especialidade, st.descricao as status
			from aclinica.requisicao as r
			inner join pessoal.pessoa as p on r.pessoa_id=p.id
			inner join pessoal.pessoafisica as f
			  on p.id=f.id
			inner join aclinica.medico as m on r.medico_id=m.id
			inner join aclinica.especialidade as e on e.id=m.especialidade_id
			inner join aclinica.statusrequisicao as st on r.statusrequisicao_id=st.id 
			  where r.pessoa_id=$pid
			order by r.id desc";
		//die($sql);	
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		$_SESSION['msg']='ERRO: (flerequisicaoporpessoa) Falha:'. $sql;
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO exception: (flerequisicaoporpessoa) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function leatendimentoarh($id, $conarh){
try {
	$sql = "select a.*,
			t.descricao as tipo, f.descricao as forma, 
			s.descricao as situacao, u.identificacao, t.descricao as tipodeservico,
			f.descricao as formadeatendimento,
			s.descricao as situacaoatendimento
			from arhweb.atendimento as a 
			inner join arhweb.tipodeservico as t on a.tipodeservico_id = t.id
			inner join arhweb.situacaoatendimento as s on a.situacaoatendimento_id = s.id
			inner join arhweb.formadeatendimento as f on a.formadeatendimento_id = f.id
			inner join pessoal.usuario as u on u.id=a.usuario_id
			  where a.id='$id'";
	$rs= $conarh->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (leatendimentoarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function fleatendimentoarh($prot, $conarh){
try {
	$sql = "select a.*,
			t.descricao as tipo, f.descricao as forma, 
			s.descricao as situacao, u.identificacao, t.descricao as tipodeservico,
			f.descricao as formadeatendimento,
			s.descricao as situacaoatendimento
			from arhweb.atendimento as a 
			inner join arhweb.tipodeservico as t on a.tipodeservico_id = t.id
			inner join arhweb.situacaoatendimento as s on a.situacaoatendimento_id = s.id
			inner join arhweb.formadeatendimento as f on a.formadeatendimento_id = f.id
			inner join pessoal.usuario as u on u.id=a.usuario_id
			  where a.protocolo='$prot' order by a.id";
	$rs= $conarh->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleatendimentoarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function lerequisicaoarhporprotocolo($prot, $conarh, $conpes){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, 
			p.fone, p.email,  f.datanascimento, f.sexo, 
			t.descricao as tipo, s.descricao as situacao
			from arhweb.requisicao as r 
			inner join arhweb.tipodeservico as t on r.tipodeservico_id = t.id
			inner join arhweb.situacaorequisicao as s on r.situacaorequisicao_id = s.id
			inner join pessoal.pessoa as p on p.id=r.pessoa_id
			inner join pessoal.pessoafisica as f on p.id=f.id
			  where r.protocolo='$prot'";
	$rs= $conarh->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lerequisicaoarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function lerequisicaoarh($id, $conarh, $conpes){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, 
			p.fone, p.email,  f.datanascimento, f.sexo, 
			t.descricao as tipo, s.descricao as situacao
			from arhweb.requisicao as r 
			inner join arhweb.tipodeservico as t on r.tipodeservico_id = t.id
			inner join arhweb.situacaorequisicao as s on r.situacaorequisicao_id = s.id
			inner join pessoal.pessoa as p on p.id=r.pessoa_id
			inner join pessoal.pessoafisica as f on p.id=f.id
			  where r.id=$id";
	$rs= $conarh->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lerequisicaoarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function lerequisicao($id, $con){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, p.fone, p.email,  f.datanascimento, 	
			f.sexo, f.rg, m.id as medico_id, m.nome as mediconome, m.crm, 
			e.id as especialidade_id, e.descricao as especialidade, st.descricao as status
			from aclinica.requisicao as r
			inner join pessoal.pessoa as p on r.pessoa_id=p.id
			inner join pessoal.pessoafisica as f
			  on p.id=f.id
			inner join aclinica.medico as m on r.medico_id=m.id
			inner join aclinica.especialidade as e on e.id=m.especialidade_id
			inner join aclinica.statusrequisicao as st on r.statusrequisicao_id=st.id 
			  where r.id=$id
			order by r.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (lerequisicao) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
	
}

function fgeraguia($d,$rid){
    $d1 = substr(implode("", array_reverse(explode("/", trim($d)))),2,6).fnumero($rid,6);
	return $d1;
}

function leescala($con){
try {
	$sql = "select escala.*
			from escala
			where quantidade<limite
			order by data, id";
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: PDOException (leescala) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lemedico($id,$con){
try {
	$sql = "select m.*, e.descricao as especialidade
			from medico as m
			inner join especialidade as e on m.especialidade_id=e.id
			where m.id=$id
			order by m.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (leespecialidade) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lemedicoporcrm($m,$con){
try {
	$sql = "select * from medico 
			where crm = '$m'";
			//die($sql);
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			//die($rec['id']);
			return ($rec['id']);
		}else{
			return 0;
		}
	}else{
		return 0;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lemedicoporcrm) ' . $e->getMessage(). ' '. $sql;
	return 0;
}	
}

function leespecialidadepordescricao($esp,$con){
try {
	$sql = "select * from especialidade 
			where descricao = '$esp'";
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			return $rec['id'];
		}else{
			return 0;
		}
	}else{
		return 0;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leespecialidadepordescricao) ' . $e->getMessage(). ' '. $sql;
	return 0;
}	
}

function fleusuariospsi($con){
try {	
	$ssql="select g.descricao as grupo, u.*, p.nome as pessoanome
			from psicoweb.usuario as pu
			inner join psicoweb.grupo as g on pu.grupo_id=g.id
			inner join pessoal.usuario as u on pu.pessoa_id=u.pessoa_id
			inner join pessoal.pessoa as p on u.pessoa_id=p.id
			order by p.nome";
//$trace=ftrace('fleusuarios',$ssql);			
	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (fleusuariospsi) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleusuariospsi) ' . $e->getMessage(). ' '. $sql;
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
	
function lecartaosus($cartao,$con){
try {
	$sql = "select p.*
			from pessoa as p 
			where p.cartaosus='$cartap'
			order by p.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (lecartaosus) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lepessoapsi($id,$con){
try {
	$sql = "select p.*
			from pessoa as p 
			where p.pessoa_id=$id
			order by p.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (lepessoapsi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lepessoaacl($id,$con){
try {
	$sql = "select p.*
			from pessoa as p 
			where p.pessoa_id=$id
			order by p.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO: (lepessoaacl) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lepessoaarh($id,$con){
try {
	$sql = "select p.*
			from pessoa as p 
			where p.pessoa_id=$id
			order by p.id desc";
			
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lepessoaarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lerequisicaopsiporid($rid,$con){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, p.fone, p.email,  f.datanascimento, f.sexo, f.rg, sr.descricao as situacaorequisicao, ta.descricao as tipodeatendimento
			from psicoweb.requisicao as r
			inner join pessoal.pessoa as p on r.pessoa_id=p.id
			inner join pessoal.pessoafisica as f
			  on p.id=f.id
			inner join psicoweb.situacaorequisicao as sr on r.situacaorequisicao_id=sr.id 
			inner join psicoweb.tipodeatendimento as ta on ta.id=r.tipodeatendimento_id
			  where r.id=$rid
			order by r.id desc";
	//$trace=ftrace('lerequisicaopsiporid ',$sql);		
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lerequisicaopsiporid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lesituacaorequisicaopsi($id,$con){
try {
	$sql = "select s.*
			from situacaorequisicao as s 
			where s.id=$id
			order by s.id desc";
	//die($sql);		
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lesituacaorequisicaopsi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lerequisicaopsi($id,$con){
try {
	$sql = "select r.*
			from requisicao as r 
			where r.pessoa_id=$id
			order by r.id desc";
	//die($sql);		
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lerequisicaopsi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leestadoacl($id,$con){
try {
	$sql = "select e.*
			from estado as e 
			where e.pessoa_id=$id
			order by e.id desc";
	//die($sql);		
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (leestadoacl) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fincluimensagem($id,$identificacao_destino,$identificacao_origem,$msg_assunto_id,$mensagem,$msg_status_id,$data_envio,$data_leitura,$idbase, $usu,$con,$con2) {
	date_default_timezone_set('America/Fortaleza');
	$data_envio=date("y-m-d h:m:s");
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("msg",$con);
	if($idbase==0){$idbase=$id;}
	
	$query = "insert into msg values ('$id','$identificacao_destino','$identificacao_origem','$msg_assunto_id','$mensagem','$msg_status_id','$data_envio','$data_leitura','$idbase')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'msg','$q','$dataalteracao')";
	$msg="Ok";
	try {
		$sql=$q1;
		$insert = $con2->query($sql);
		if($insert){
			$sql=$query;
			$inclui = $con->query($sql);
			if($inclui){
			}else{ 
				$msg='Falha ao enviar mensagem:'.$sql;
			}
		}else{ 
			$msg='Falha ao incluir hystory:'.$sql;
		}
	}catch (PDOException $e) {
		$msg="Erro PDOException (fincluimensagem): ".$e->getMessage()." ".$sql;	
	}	
	return $msg;
}

function fleumensagem($id,$con){
try {
	date_default_timezone_set('America/Fortaleza');
	$dt=date("Y-m-d h:m:s");
	$sql = "update msg set msg_status_id=2, data_leitura='$dt'
		where msg.id=$id";
	$trace=ftrace("leumensagem:$id",$sql);		
	$rs= $con->query($sql);
	if($rs) {
		return true;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleumensagem) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lemensagem($id,$con){
try {
	$sql = "select m.*, a.descricao as assunto, s.descricao as status
		from msg as m
		inner join msg_assunto as a on m.msg_assunto_id=a.id
		inner join msg_status as s on m.msg_status_id=s.id
		where m.id=$id";
	$trace=ftrace("lemensagem:$id",$sql);		
	$rs= $con->query($sql);
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
    $_SESSION['msg']='ERRO PDOException: (lemensagem) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fpesquisamensagem($tx,$ident,$con){
$tx=trim($tx);	
if(!$tx=='')
$sql="select m.*, a.descricao as assunto, s.descricao as status
		from msg as m
		inner join msg_assunto as a on m.msg_assunto_id=a.id
		inner join msg_status as s on m.msg_status_id=s.id
		where (m.identificacao_destino='' or m.identificacao_destino like '$ident' or m.identificacao_origem like '$ident') and m.mensagem like '$tx' order by m.msg_status_id, m.idbase, m.id ";
else		
$sql="select m.*, a.descricao as assunto, s.descricao as status
		from msg as m
		inner join msg_assunto as a on m.msg_assunto_id=a.id
		inner join msg_status as s on m.msg_status_id=s.id
		where (m.identificacao_destino='' or m.identificacao_destino like '$ident' or m.identificacao_origem like '$ident')
		order by m.msg_status_id, m.idbase, m.id";
try {
	//die ($sql);
	$rs= $con->query($sql);
	return $rs;
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fpesquisamensagem) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fpesquisaagenda($cpf,$nom,$dtn,$car,$con){
$dt=formataData($dtn);	
if(!$car=='')
$sql="select * from pessoaagenda 
		where 
		(cnpjcpf='$cpf' and nome='$nom') or 
		(cartaosus='$car') or
		(nome='$nom' and datanascimento='$dt')";
else		
$sql="select * from pessoaagenda 
		where 
		(cnpjcpf='$cpf' and nome='$nom') or 
		(nome='$nom' and datanascimento='$dt')";
		//die($sql);
try {
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$rec=$rs->fetch();
			return $rec;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (fpesquisaagenda) ' .' Não foi possível ler o registro:'.$sql;return false; 		
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisaagenda) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}
		
function fpesquisaexame($tex,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT e.*, t.descricao as tipodeamostra
		from exame as e
		inner join tipodeamostra as t on e.tipodeamostra_id=t.id
		order by e.descricao";
else	
$sql="SELECT e.*, t.descricao as tipodeamostra
		from exame as e
		inner join tipodeamostra as t on e.tipodeamostra_id=t.id
		where e.descricao like '%$tex%' order by e.descricao";
try {
	//die($sql."-".$tex);
	$rs= $con->query($sql);
	//die("rowcount=".$rs->rowCount());
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisaexame) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fIdentificaExame($id,$con){
	return $id;
}

function fidentificarequisicaopsi($rid,$con){
	$rreq=lerequisicaopsiporid($rid,$con);
	$cpf=$rreq['cpf'];
	$apelido=$rreq['apelido'];
	$nome=$rreq['pessoanome'];
    $ret="<h4> Identificando CPF ".formatarCNPJCPF($cpf,'cpf')." </h4>";
	$ret=$ret."<h3><strong> Paciente:</strong> ".$apelido." / ".$nome."</h3>".
	"Requisição N.: ".$rreq['id']."<br>
	Situação: ".$rreq['situacaorequisicao']."<br> "."Tipo: ".$rreq['tipodeatendimento'];
	//$trace=ftrace('fidentificarequisicaopsi',$s);	
	return $ret;
}


function leestagiarioporid($id,$con){
try {
	$ssql="select e.*, p.nome from psicoweb.estagiario as e 
				inner join pessoal.pessoa as p 
				on e.pessoa_id=p.id
				inner join pessoal.pessoa as p1
				on e.professor_pessoa_id=p1.id
				where e.id=$id";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (leestagiarioporid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

/************************** FPESQUISA  INICIO */

function fpesquisaestagiario($tab,$tex,$con) {
	$tex=trim($tex);
	if($tex==''){
		$sql = "select e.*, p.nome,
				p1.nome as nomeprofessor 
				from psicoweb.estagiario as e
				inner join pessoal.pessoa as p 
				on e.pessoa_id=p.id
				inner join pessoal.pessoa as p1
				on e.professor_pessoa_id=p1.id
				order by p.nome";
	}else{		
		$sql = "select e.*, p.nome,
				p1.nome as nomeprofessor 
				from psicoweb.estagiario as e
				inner join pessoal.pessoa as p 
				on e.pessoa_id=p.id
				inner join pessoal.pessoa as p1
				on e.professor_pessoa_id=p1.id
				where p.nome like '%$tex%'
				order by p.nome";
	}
	try {
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisaestagiario) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisadescricao($tab,$tex,$con) {
	$tex=trim($tex);
	if($tex==''){
		$sql = "select * from ".$tab."
			order by id";
	}else{		
		$sql = "select * from ".$tab."
			where descricao like '%$tex%'
			order by id";
	}
	try {
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisadescricao) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisamedico($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select m.*, e.descricao as especialidade
			from medico as m
			inner join especialidade as e on m.especialidade_id=e.id
			order by m.nome ";
	else	
		$sql = "select m.*, e.descricao as especialidade
			from medico as m
			inner join especialidade as e on m.especialidade_id=e.id
			where m.nome like '%$tex%'
			order by m.nome ";
	try {
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisaespecialidade) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

/************************** FPESQUISA  FIM  */
function fpesquisapessoapsi($tex,$conpes,$conpsi){
	// Pesquisa pessoa em pessoal e verifica existência em psicoweb de naturezadapessoa
	//	e niveldousuario. Retorna todas as pessoas de pessoal.pessoa independente de 
	//  existirem em psicoweb.pessoa e psicoweb.usuario
	$sqla="select pessoa.id, cnpjcpf as cpf, 
		nome, fone, email, sexo, datanascimento
		from pessoa inner join pessoafisica on pessoa.id=pessoafisica.id
		where pessoa.situacao_id<3 and nome like '%$tex%'
		and pessoa.id<>1
		order by nome";
	$sqla1="select naturezadapessoa.descricao as naturezadapessoa
		from pessoa
		inner join naturezadapessoa on pessoa.naturezadapessoa_id=naturezadapessoa.id
		where pessoa_id=";
	$sqla2="select niveldousuario.descricao as niveldousuario
		from usuario
		inner join niveldousuario on usuario.niveldousuario_id=niveldousuario.id
		where usuario.pessoa_id=";
	$sqla3="select identificacao, ativo
		from usuario
		where pessoa_id=";
	$cont=0;	
	$sqltruncate="truncate table pes001";
	try {
		//$rsql= $conpsi->query($sql);
		$t=$conpsi->query($sqltruncate);
		$rsql=true;
		if($rsql) {
			$rsqla= $conpes->query($sqla);
			if($rsqla) {
				if($rsqla->rowCount()>0) {
					foreach ($rsqla->fetchAll() as $recsqla) {
						$ord=++$cont;
						$pessoaid=$recsqla['id'];
						$natureza="";
						$cpf=$recsqla['cpf'];
						$nome=$recsqla['nome'];
						$sexo=$recsqla['sexo'];
						$dtn=$recsqla['datanascimento'];
						$fone=$recsqla['fone'];
						$email=$recsqla['email'];
						$natureza="";
						$nivel="";
						$ident="";
						$ativo="";
						$sqlax=$sqla1.$pessoaid;
						$rsqla1=$conpsi->query($sqlax);
						if($rsqla1) {
							if($rsqla1->rowCount()>0) {
								$recsqla1=$rsqla1->fetch();
								$natureza=$recsqla1['naturezadapessoa'];
							}
						}		
						$sqlax=$sqla2.$pessoaid;
						$rsqla2=$conpsi->query($sqlax);
						if($rsqla2) {
							if($rsqla2->rowCount()>0) {
								$recsqla2=$rsqla2->fetch();
								$nivel=$recsqla2['niveldousuario'];
							}
						}		
						$sqlax=$sqla3.$pessoaid;
						$rsqla3=$conpes->query($sqlax);
						if($rsqla3) {
							if($rsqla3->rowCount()>0) {
								$recsqla3=$rsqla3->fetch();
								$ident=$recsqla3['identificacao'];
								$ativo=$recsqla3['ativo'];
							}
						}
						$sqli="insert into pes001 values (
							$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$email','$nivel','$ident','$ativo')";
						$i=$conpsi->query($sqli);
					}	
				}	
			}
		}
		$sqlt="select * from pes001 order by ord";
		$rsqlt=$conpsi->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoapsi) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}

function leconsultadepessoafisicaporid($id,$con){
try {
	$ssql="SELECT c.id AS consulta_id, c.convenio_id, 
	c.medico_id, c.dataregistro, c.dataconsulta, 
	c.horario, c.confirmado, c.realizado, 
	f.*, p.cnpjcpf AS cpf, 
	p.denominacaocomum AS apelido,
	p.nome, p.fone, p.email
	FROM consnae.consulta AS c 
	INNER JOIN pessoal.pessoafisica AS f ON f.id=c.consultapessoa_id
	INNER JOIN pessoal.pessoa AS p ON p.id=f.id
	WHERE c.id=$id";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (leconsultadepessoafisicaporid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function fpesquisapessoanae($tex){
	$conpes=conexao("pessoal");
	$connae=conexao("consnae");
	// pessoal
	$sqla="select pessoa.id, cnpjcpf as cpf, 
		denominacaocomum as apelido, nome, fone, email, sexo, datanascimento
		from pessoa inner join pessoafisica on pessoa.id=pessoafisica.id
		where pessoa.situacao_id<3 and nome like '%$tex%'
		and pessoa.id<>1
		order by nome";
	// consnae
	$sqla1="select naturezadapessoa.descricao as naturezadapessoa, cartaosus
		from pessoa
		inner join naturezadapessoa on pessoa.naturezadapessoa_id=naturezadapessoa.id
		where pessoa_id=";
	$sqla2="select niveldousuario.descricao as niveldousuario
		from usuario
		inner join niveldousuario on usuario.niveldousuario_id=niveldousuario.id
		where usuario.pessoa_id=";
	// pessoal	
	$sqla3="select identificacao, ativo
		from usuario
		where pessoa_id=";
	$cont=0;	
	// consnae
	$sqla4="select * from consulta where dataconsulta>=NOW() and consultapessoa_id=";
	$sqltruncate="truncate table pes001";
	try {
		$t=$connae->query($sqltruncate);
		$rsqla= $conpes->query($sqla);
		if($rsqla) {
			if($rsqla->rowCount()>0) {
				foreach ($rsqla->fetchAll() as $recsqla) {
					$ord=++$cont;
					$pessoaid=$recsqla['id'];
					$cpf=$recsqla['cpf'];
					$nome=$recsqla['nome'];
					$sexo=$recsqla['sexo'];
					$dtn=$recsqla['datanascimento'];
					$fone=$recsqla['fone'];
					$email=$recsqla['email'];
					$natureza="";
					$nivel="";
					$ident="";
					$ativo="";
					$status='Cadastrado';
					$cartaosus='';
					$sqlax=$sqla1.$pessoaid;
					$rsqla1=$connae->query($sqlax);
					if($rsqla1) {
						if($rsqla1->rowCount()>0) {
							$recsqla1=$rsqla1->fetch();
							$natureza=$recsqla1['naturezadapessoa'];
							$cartaosus=$recsqla1['cartaosus'];
						}
					}		
					$sqlax=$sqla2.$pessoaid;
					$rsqla2=$connae->query($sqlax);
					if($rsqla2) {
						if($rsqla2->rowCount()>0) {
							$recsqla2=$rsqla2->fetch();
							$nivel=$recsqla2['niveldousuario'];
						}
					}		
					$sqlax=$sqla3.$pessoaid;
					$rsqla3=$conpes->query($sqlax);
					if($rsqla3) {
						if($rsqla3->rowCount()>0) {
							$recsqla3=$rsqla3->fetch();
							$ident=$recsqla3['identificacao'];
							$ativo=$recsqla3['ativo'];
						}
					}
					$sqlax=$sqla4.$pessoaid." order by dataconsulta desc";
					$rsqla4=$connae->query($sqlax);
					if($rsqla4) {
						if($rsqla4->rowCount()>0) {
							$recsqla4=$rsqla4->fetch();
							$confirmado=$recsqla4['confirmado'];
							$realizado=$recsqla4['realizado'];
							$status='Consulta Marcada';
							if($confirmado=='S')
								$status='Consuta Confirmada';
							if($realizado=='S')
								$status='Consuta Realizada';
							
						}
					}
					$sqli="insert into pes001 values (
						$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$cartaosus','$email','$nivel','$ident','$status','$ativo')";
						$i=$connae->query($sqli);
				}	
			}	
		}
		$sqlt="select * from pes001 order by ord";
		$rsqlt=$connae->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoanae) ' . $e->getMessage(). ' '. $sqlax;
		//return false;
	}	
}

function fpesquisapessoaacl($tex,$conpes,$conacl ){
	$sqla="select pessoa.id, cnpjcpf as cpf, 
		nome, fone, email, sexo, datanascimento
		from pessoa inner join pessoafisica on pessoa.id=pessoafisica.id
		where pessoa.situacao_id<3 and nome like '%$tex%'
		and pessoa.id<>1
		order by nome";
	$sqla1="select naturezadapessoa.descricao as naturezadapessoa, cartaosus
		from pessoa
		inner join naturezadapessoa on pessoa.naturezadapessoa_id=naturezadapessoa.id
		where pessoa_id=";
	$sqla2="select niveldousuario.descricao as niveldousuario
		from usuario
		inner join niveldousuario on usuario.niveldousuario_id=niveldousuario.id
		where usuario.pessoa_id=";
	$sqla3="select identificacao, ativo
		from usuario
		where pessoa_id=";
	$cont=0;	
	$sqltruncate="truncate table pes001";
	try {
		//$rsql= $conpsi->query($sql);
		$t=$conacl->query($sqltruncate);
		$rsql=true;
		if($rsql) {
			$rsqla= $conpes->query($sqla);
			if($rsqla) {
				if($rsqla->rowCount()>0) {
					foreach ($rsqla->fetchAll() as $recsqla) {
						$ord=++$cont;
						$pessoaid=$recsqla['id'];
						$natureza="";
						$cpf=$recsqla['cpf'];
						$nome=$recsqla['nome'];
						$sexo=$recsqla['sexo'];
						$dtn=$recsqla['datanascimento'];
						$fone=$recsqla['fone'];
						$email=$recsqla['email'];
						$natureza="";
						$nivel="";
						$ident="";
						$ativo="";
						$sqlax=$sqla1.$pessoaid;
						$rsqla1=$conacl->query($sqlax);
						if($rsqla1) {
							if($rsqla1->rowCount()>0) {
								$recsqla1=$rsqla1->fetch();
								$natureza=$recsqla1['naturezadapessoa'];
								$cartaosus=$recsqla1['cartaosus'];
							}
						}		
						$sqlax=$sqla2.$pessoaid;
						$rsqla2=$conacl->query($sqlax);
						if($rsqla2) {
							if($rsqla2->rowCount()>0) {
								$recsqla2=$rsqla2->fetch();
								$nivel=$recsqla2['niveldousuario'];
							}
						}		
						$sqlax=$sqla3.$pessoaid;
						$rsqla3=$conpes->query($sqlax);
						if($rsqla3) {
							if($rsqla3->rowCount()>0) {
								$recsqla3=$rsqla3->fetch();
								$ident=$recsqla3['identificacao'];
								$ativo=$recsqla3['ativo'];
							}
						}
						$status='';
						$sqli="insert into pes001 values (
						$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$cartaosus','$email','$nivel','$ident','$status','$ativo')";
						$i=$conacl->query($sqli);
					}	
				}	
			}
		}
		$sqlt="select * from pes001 order by ord";
		$rsqlt=$conacl->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoaacl) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}
/************************** FPESQUISA  FIM  */

function fpesquisapessoaarh($tex,$conpes,$conarh ){
	$sqla="select p.id, p.cnpjcpf as cpf, 
		p.nome, p.fone, p.email, f.sexo, f.datanascimento
		from pessoa as p
		inner join pessoafisica as f on f.id=p.id
		where p.situacao_id<3 and p.nome like '%$tex%'
		and p.id<>1
		order by p.nome";
	$sqla1="select naturezadapessoa.descricao as naturezadapessoa
		from pessoa
		inner join naturezadapessoa on pessoa.naturezadapessoa_id=naturezadapessoa.id
		where pessoa_id=";
	$sqla2="select niveldousuario.descricao as niveldousuario
		from usuario
		inner join niveldousuario on usuario.niveldousuario_id=niveldousuario.id
		where usuario.pessoa_id=";
	$sqla3="select identificacao, ativo
		from usuario
		where pessoa_id=";
	$cont=0;	
	$sqltruncate="truncate table pes001";
	try {
		//$rsql= $conpsi->query($sql);
		$t=$conarh->query($sqltruncate);
		//if ($t) echo($sqltruncate.' ');
		$rsql=true;
		if($rsql) {
			$rsqla= $conpes->query($sqla);
			if($rsqla) {
				if($rsqla->rowCount()>0) {
					foreach ($rsqla->fetchAll() as $recsqla) {
						$ord=++$cont;
						$pessoaid=$recsqla['id'];
						$natureza="";
						$cpf=$recsqla['cpf'];
						$nome=$recsqla['nome'];
						$sexo=$recsqla['sexo'];
						$dtn=$recsqla['datanascimento'];
						$fone=$recsqla['fone'];
						$email=$recsqla['email'];
						$natureza="";
						$nivel="";
						$ident="";
						$ativo="";
						//$sqlax=$sqla1.$pessoaid;
						//$rsqla1=$conarh->query($sqlax);
						//if($rsqla1) {
						//	if($rsqla1->rowCount()>0) {
						//		$recsqla1=$rsqla1->fetch();
						//		$natureza=$recsqla1['naturezadapessoa'];
						//	}
						//}		
						$sqlax=$sqla2.$pessoaid;
						$rsqla2=$conarh->query($sqlax);
						if($rsqla2) {
							if($rsqla2->rowCount()>0) {
								$recsqla2=$rsqla2->fetch();
								$nivel=$recsqla2['niveldousuario'];
							}
						}		
						$sqlax=$sqla3.$pessoaid;
						$rsqla3=$conpes->query($sqlax);
						if($rsqla3) {
							if($rsqla3->rowCount()>0) {
								$recsqla3=$rsqla3->fetch();
								$ident=$recsqla3['identificacao'];
								$ativo=$recsqla3['ativo'];
							}
						}
						$sqli="insert into pes001 values (
							$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$email','$nivel','$ident','$ativo')";
						$i=$conarh->query($sqli);
					}	
				}	
			}
		}
		$sqlt="select * from pes001 order by ord";
		$rsqlt=$conarh->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisapessoaarh) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}

function fpesquisausuarioarh($tex,$conpes,$conarh ){
	$sqla="select p.id, p.cnpjcpf as cpf, 
		p.nome, p.fone, p.email, f.sexo, f.datanascimento
		from pessoa as p
		inner join pessoafisica as f on f.id=p.id
		where p.situacao_id<3 and p.nome like '%$tex%'
		and p.id<>1
		order by p.nome";
	$sqla1="select naturezadapessoa.descricao as naturezadapessoa
		from pessoa
		inner join naturezadapessoa on pessoa.naturezadapessoa_id=naturezadapessoa.id
		where pessoa_id=";
	$sqla2="select niveldousuario.descricao as niveldousuario
		from usuario
		inner join niveldousuario on usuario.niveldousuario_id=niveldousuario.id
		where usuario.pessoa_id=";
	$sqla3="select identificacao, ativo
		from usuario
		where pessoa_id=";
	$cont=0;	
	$sqltruncate="truncate table pes001";
	try {
		//$rsql= $conpsi->query($sql);
		$t=$conarh->query($sqltruncate);
		//if ($t) echo($sqltruncate.' ');
		$rsql=true;
		if($rsql) {
			$rsqla= $conpes->query($sqla);
			if($rsqla) {
				if($rsqla->rowCount()>0) {
					foreach ($rsqla->fetchAll() as $recsqla) {
						$ord=++$cont;
						$pessoaid=$recsqla['id'];
						$natureza="";
						$cpf=$recsqla['cpf'];
						$nome=$recsqla['nome'];
						$sexo=$recsqla['sexo'];
						$dtn=$recsqla['datanascimento'];
						$fone=$recsqla['fone'];
						$email=$recsqla['email'];
						$natureza="";
						$nivel="";
						$ident="";
						$ativo="";
						//$sqlax=$sqla1.$pessoaid;
						//$rsqla1=$conarh->query($sqlax);
						//if($rsqla1) {
						//	if($rsqla1->rowCount()>0) {
						//		$recsqla1=$rsqla1->fetch();
						//		$natureza=$recsqla1['naturezadapessoa'];
						//	}
						//}		
						$sqlax=$sqla2.$pessoaid;
						$rsqla2=$conarh->query($sqlax);
						if($rsqla2) {
							if($rsqla2->rowCount()>0) {
								$recsqla2=$rsqla2->fetch();
								$nivel=$recsqla2['niveldousuario'];
							}
						}		
						$sqlax=$sqla3.$pessoaid;
						$rsqla3=$conpes->query($sqlax);
						if($rsqla3) {
							if($rsqla3->rowCount()>0) {
								$recsqla3=$rsqla3->fetch();
								$ident=$recsqla3['identificacao'];
								$ativo=$recsqla3['ativo'];
							}
						}
						if($nivel<>''){
						$sqli="insert into pes001 values (
							$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$email','$nivel','$ident','$ativo')";
						$i=$conarh->query($sqli);
						}
					}	
				}	
			}
		}
		$sqlt="select * from pes001 where nivel<>'' order by ord";
		$rsqlt=$conarh->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisapessoaarh) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}

function lehorarioporid($hid,$conpsi){
	$sql="SELECT *
			FROM horario
			where id=$hid
			order by id
		"; 
try {
	$rs=$conpsi->query($sql);
	if($rs)
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			return $rec;
		}else{
			return false;
		}
	else
		return false;
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO (flehorario): ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function flehorario($conpsi){
	$sql="SELECT *
			FROM horario
			where id<13
			order by id
		"; 
try {
	$rs=$conpsi->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO (flehorario): ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleestagiariosgrupo($conpsi){
	$sql="SELECT pp.id AS pessoaid, 
			pp.nome, pu.ativo
			FROM pessoal.pessoa AS pp
			INNER JOIN psicoweb.usuario AS psiu ON psiu.pessoa_id=pp.id
			inner join pessoal.usuario as pu on pu.pessoa_id=pp.id
			INNER JOIN psicoweb.grupo AS pg ON pg.id=psiu.grupo_id
			WHERE pg.grupo='Est' order by pp.nome";
try {
	$rs=$conpsi->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fleestagiariosgrupo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleestagiarios($conpsi){
	$sql="SELECT e.*, pp.id AS pessoaid, 
			pp.nome, pu.ativo
			from psicoweb.estagiario as e 
			inner join pessoal.pessoa AS pp on e.pessoa_id=pp.id
			INNER JOIN psicoweb.usuario AS psiu ON psiu.pessoa_id=pp.id
			inner join pessoal.usuario as pu on pu.pessoa_id=pp.id
			INNER JOIN psicoweb.grupo AS pg ON pg.id=psiu.grupo_id
			WHERE pg.grupo='Est' order by pp.nome";
try {
	$rs=$conpsi->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (fleestagiarios) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function flehorariodeestagiario($id, $conpsi){
	$sql="SELECT psihe.id, pp.id as pessoaid,
			pp.nome, 
			psidu.mnemonico AS dia, psidu.descricao AS nomedia,	psih.descricao AS horario
			FROM psicoweb.horarioestagiario AS psihe
			INNER JOIN pessoal.pessoa AS pp ON pp.id=psihe.pessoa_id
			INNER JOIN psicoweb.diautil AS psidu ON psidu.id=psihe.diautil_id
			INNER JOIN psicoweb.horario AS psih ON psih.id=psihe.horario_id where pp.id=$id"; 
$trace=ftrace('flehorariodeestagiario',$sql);			
try {
	$rs=$conpsi->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO (flehorariodeestagiario): ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lehorariododia($pid, $dia, $hora, $conpsi){
	$sql="SELECT *
			FROM psicoweb.horarioestagiario 
			where pessoa_id=$pid and 
				diautil_id=$dia and 
				horario_id=$hora"; 
try {
	$rs=$conpsi->query($sql);
	if($rs){
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
    $_SESSION['msg']='ERRO (lehorariododia): ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lehorariodeestagiario($id, $conpsi){
	$sql="SELECT psihe.*, pp.id as pessoaid,
			pp.nome, 
			psidu.mnemonico AS dia, psidu.descricao AS nomedia,	psih.descricao AS horario
			FROM psicoweb.horarioestagiario AS psihe
			INNER JOIN pessoal.pessoa AS pp ON pp.id=psihe.pessoa_id
			INNER JOIN psicoweb.diautil AS psidu ON psidu.id=psihe.diautil_id
			INNER JOIN psicoweb.horario AS psih ON psih.id=psihe.horario_id where psihe.id=$id"; 
//$trace=ftrace('lehorariodeestagiario',$sql);			
try {
	$rs=$conpsi->query($sql);
	if($rs){
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
    $_SESSION['msg']='ERROR: (lehorariodeestagiario) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leagenda($dt, $h, $s, $conpsi){
if(empty($s)) $s='1';	
$sql="
	SELECT a.*, p.denominacaocomum AS responsavel,
	p1.denominacaocomum AS paciente,
	e.descricao AS evento
	FROM psicoweb.agenda AS a
	INNER JOIN psicoweb.sala AS s ON a.sala_id=s.id
	INNER JOIN psicoweb.horario AS h ON a.horario_id=h.id
	INNER JOIN psicoweb.evento AS e ON a.evento_id=e.id
	INNER JOIN pessoal.pessoa AS p ON a.responsavelpessoa_id=p.id
	INNER JOIN psicoweb.requisicao AS r ON a.requisicao_id=r.id
	LEFT  JOIN pessoal.pessoa AS p1 ON r.pessoa_id=p1.id
	INNER JOIN psicoweb.ocorrenciaagendamento AS o ON a.ocorrenciaagendamento_id=o.id
	where a.data='$dt' and horario_id=$h and sala_id=$s";
//$trace=ftrace('leagenda',$sql);	
try{	
	$rs=$conpsi->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch();
			return $reg;
		}
	}
}catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leagenda) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

//function fmontahorariosemana($adata, $adia, $sala, $pessoa_id, 
function fmontahorariosemana($adata, $conpsi) {
$sql="truncate table tsemana";
$exec=$conpsi->query($sql);	
$rhor=flehorarioestagiario($conpsi);
foreach($rhor->fetchAll() as $reg){
	$pessoaid=$reg['pessoa_id'];
	$diautil_id=$reg['diautil_id'];
	$dia=$reg['diautil'];
	//$trace=ftrace('fmontahorariosemana',$diautil_id);
	$horario_id=$reg['horario_id'];
	$horario=$reg['horario'];
	$data=$adata[$diautil_id];
	$data=formataData($data);
	$nome=$reg['nome'];
	$apelido=$reg['apelido'];
	$sql="insert into tsemana values (
		'$data', '$dia', $horario_id, '$horario', 
		$pessoaid, '$nome', '$apelido')";
	$inc=$conpsi->query($sql);	
}
	
}

function flehorarioestagiario($conpsi){
$sql="SELECT he.*, p.denominacaocomum AS apelido,
	p.nome, d.descricao AS diautil, h.descricao AS horario 
	FROM psicoweb.horarioestagiario AS he
	INNER JOIN psicoweb.diautil AS d ON he.diautil_id=d.id
	INNER JOIN pessoal.pessoa AS p ON he.pessoa_id=p.id
	INNER JOIN psicoweb.horario AS h ON he.horario_id=h.id";
try{	
	$rs=$conpsi->query($sql);
	if($rs) 
		return $rs;
	return false;
}catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flehorarioestagiario) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lehorarioestagiario($du,$h,$conpsi){
$sql="SELECT h.*, p.denominacaocomum AS apelido,
	p.nome 
	FROM psicoweb.horarioestagiario AS h
	INNER JOIN psicoweb.diautil AS d ON h.diautil_id=d.id
	INNER JOIN pessoal.pessoa AS p ON h.pessoa_id=p.id
	where d.codigo=$du and h.horario_id=$h";
//$trace=ftrace('lehorarioestagiario',$sql);	
try{	
	$rs=$conpsi->query($sql);
	if($rs) {
		//if($rs->rowCount()>0) {
			//$reg=$rs->fetch();
			//return $reg;
		//}
		return $rs;
	}
	return false;
}catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lehorarioestagiario) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

function fleocupacao ($d,$du,$h,$s,$conpsi) {
	//$trace=ftrace('fleocupacao',"data:$d horarioid:$h sala:$s");
	$ss='Livre';
	$dtf=formataData($d);
	$ragenda=leagenda($dtf,$h,$s,$conpsi);
	if($ragenda){
		$ss=$ragenda['evento'].'<br>'.
			$ragenda['responsavel'].'<br>'.
			$ragenda['paciente'];
	}else{
		$rhor=lehorarioestagiario($du,$h,$conpsi);
		if($rhor){
			$ape='';
			foreach($rhor->fetchAll() as $thor){	
				$ape=$ape.$thor['apelido'].' ';
			}
			$ss=$ss.'<br>'.$ape;
		}	
	}	
	return $ss;
}

function fleocupacaoest ($du,$h,$conpsi) {
	//$trace=ftrace('fleocupacaoest',"data:$d horarioid:$h ");
	$ss='Livre';
	$rhor=lehorarioestagiario($du,$h,$conpsi);
	if($rhor){
		$ape='';
		foreach($rhor->fetchAll() as $thor){	
			$ape=$ape.$thor['apelido'].' ';
		}
		$ss=$ss.'<br>'.$ape;
	}	
	return $ss;
}

function fverificaagenda($pid, $rid, $sid, $dt, $hid, $conpsi, $conpes){
	$msg='';
	$lreq=lerequisicaopsiporid($rid,$conpsi);
	$spes="";
	if($lreq){
		$pessoaid=$lreq['pessoa_id'];
		$rpes=lepessoafisicaporid($pessoaid,$conpes);
		$spes=$rpes['apelido'];	
	}		
// algum agendamento para pid na data/horario dada?
    $dtf=formataData($dt);
	$sql1="select * from agenda where requisicao_id=$rid and data='$dtf' and horario_id=$hid and ocorrenciaagendamento_id<>3";
	$leu1=$conpsi->query($sql1);
	if($leu1)
		if($leu1->rowCount()>0) {
			$rleu1=$leu1->fetch();
			$sid1=$rleu1['sala_id'];
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$msg="Existe um agendamento para $spes no dia $dt, no horario $shor  na sala $sid1";
		}
//responsavel=estagiario	
	$sql2="select * from agenda where responsavelpessoa_id=$pid and data='$dtf' and horario_id=$hid and ocorrenciaagendamento_id<>3";
	$leu2=$conpsi->query($sql2);
	if($leu2)
		if($leu2->rowCount()>0) {
			$rleu2=$leu2->fetch();
			$sid2=$rleu2['sala_id'];
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$rpes=lepessoafisicaporid($pid,$conpes);
			$spes=$rpes['apelido'];	
			$msg="Existe um agendamento para $spes no dia $dt, no horario $shor na sala $sid2 ";
		}
//sala	
	$sql3="select * from agenda where data='$dtf' and sala_id=$sid and horario_id=$hid and ocorrenciaagendamento_id<>3";
	$leu3=$conpsi->query($sql3);
	if($leu3)
		if($leu3->rowCount()>0) {
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$msg="Existe um agendamento para a sala $sid no dia $dt, no horario $shor";
		}
	return $msg;	
}

function fverificaplantao($pid, $rid, $sid, $dt, $hid, $conpsi, $conpes){
	$msg='';
	$lreq=lerequisicaopsiporid($rid,$conpsi);
	$spes="";
	if($lreq){
		$pessoaid=$lreq['pessoa_id'];
		$rpes=lepessoafisicaporid($pessoaid,$conpes);
		$spes=$rpes['apelido'];	
	}		
// algum agendamento para pid na data/horario dada?
    $dtf=formataData($dt);
	$sql1="select * from plantao where requisicao_id=$rid
    	and data='$dtf' and horarioi_id<=$hid and horariof_id=0";
	$leu1=$conpsi->query($sql1);
	if($leu1)
		if($leu1->rowCount()>0) {
			$rleu1=$leu1->fetch();
			$sid1=$rleu1['sala_id'];
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$msg="Ocorre um plantao com $spes no dia $dt, iniciado no horario $shor  na sala $sid1";
		}
//responsavel=estagiario	
	$sql2="select * from plantao where responsavelpessoa_id=$pid 
		and data='$dtf' and horarioi_id<=$hid and horariof_id=0";
	$leu2=$conpsi->query($sql2);
	if($leu2)
		if($leu2->rowCount()>0) {
			$rleu2=$leu2->fetch();
			$sid2=$rleu2['sala_id'];
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$rpes=lepessoafisicaporid($pid,$conpes);
			$spes=$rpes['apelido'];	
			$msg="Ocorre um plantao com $spes no dia $dt, iniciado no horario $shor na sala $sid2 ";
		}
//sala	
	$sql3="select * from plantao where data='$dtf' 
	and sala_id=$sid and horarioi_id<=$hid and horariof_id=0";
	$leu3=$conpsi->query($sql3);
	if($leu3)
		if($leu3->rowCount()>0) {
			$rhor=lehorarioporid($hid,$conpsi);
			$shor=$rhor['descricao'];	
			$msg="Ocorre um plantão na sala $sid no dia $dt, iniciado no horario $shor";
		}
	return $msg;	
}

function letriagemporid($id, $conpsi) {
try {
	$sql="SELECT r.*,s.descricao AS situacao,
		p.denominacaocomum AS apelido,
		p.nome, p.cnpjcpf AS cpf, p.fone, p.email,
		t.id as triagemid,
		t.triagemmarcadaporusuario_cpf,t.triagemfeitaporusuario_cpf,
		t.pacientepessoa_id,t.condicaodopaciente_id,t.coordenador_cpf,
		t.datacontato,t.datatriagem,t.horatriagem, t.observacoes as tobservacoes,
		t.situacaotriagem_id
		FROM psicoweb.requisicao AS r
		INNER JOIN psicoweb.triagem AS t ON t.id=r.triagem_id
		INNER JOIN psicoweb.situacaotriagem AS s
		ON s.id = t.situacaotriagem_id
		INNER JOIN pessoal.pessoa AS p ON p.id=r.pessoa_id
		WHERE t.id=$id";
		//die ($sql);
	$rs= $conpsi->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch();
			return $reg;
		}else{
			$_SESSION['erro']='ERRO: Ao ler registro de pessoal -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler Requisicão -> ' . $sql;
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

/************************** FPESQUISA  FIM  */

function fpesquisatriagem ($sit,$dati,$datf,$cpfm,$cpfr,$conpes,$conpsi){
	if($sit<1){
	$sql="SELECT r.*,s.descricao AS situacao,
		p.denominacaocomum AS apelido,
		p.nome, p.cnpjcpf AS cpf, p.fone, p.email,
		t.triagemmarcadaporusuario_cpf,t.triagemfeitaporusuario_cpf,
		t.pacientepessoa_id,t.condicaodopaciente_id,t.coordenador_cpf,
		t.datacontato,t.datatriagem,t.horatriagem,
		t.situacaotriagem_id
		FROM psicoweb.requisicao AS r 
		INNER JOIN psicoweb.triagem AS t ON t.id=r.triagem_id
		INNER JOIN psicoweb.situacaotriagem AS s
		ON s.id = t.situacaotriagem_id
		INNER JOIN pessoal.pessoa AS p ON p.id=r.pessoa_id
		WHERE t.dataregistro BETWEEN '$dati' AND '$datf' ";
	}else{	
	$sql="SELECT r.*,s.descricao as situacao,
		p.denominacaocomum as apelido,
		p.nome, p.cnpjcpf as cpf, p.fone, p.email, 
		t.triagemmarcadaporusuario_cpf,t.triagemfeitaporusuario_cpf,
		t.pacientepessoa_id,t.condicaodopaciente_id,t.coordenador_cpf,
		t.datacontato,t.datatriagem,t.horatriagem,
		t.situacaotriagem_id
		FROM psicoweb.requisicao AS r 
		INNER JOIN psicoweb.triagem AS t ON t.id=r.triagem_id
		INNER JOIN psicoweb.situacaotriagem AS s
		ON s.id = t.situacaotriagem_id
		INNER JOIN pessoal.pessoa AS p ON p.id=r.pessoa_id
		where t.situacaotriagem_id=$sit and t.dataregistro between '$dati' and '$datf'";
	}
	//die($sql);
	try {
		$rs=$conpes->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function flerequisicaoarh($id, $con) {
try {
	$sql="SELECT requisicao.*, 		situacaorequisicao.descricao as situacao 
		from requisicao inner join situacaorequisicao
		on situacaorequisicao.id = requisicao.situacaorequisicao_id
		where pessoa_id = $id order by id desc limit 5";
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (flerequisicaoarh) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fpesquisarequisicaoarhporpessoaid($pid,$dati,$datf,$con){
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		t.descricao as tipo, s.descricao as situacao
		from arhweb.requisicao as r 
		inner join arhweb.tipodeservico as t
		on r.tipodeservico_id = t.id
		inner join arhweb.situacaorequisicao as s
		on r.situacaorequisicao_id = s.id
		inner join pessoal.pessoa as p on p.id=r.pessoa_id
		where r.pessoa_id=$pid and r.data between '$dati' and '$datf' order by id desc";
		//die($sql);
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisarequisicaoarhporpessoaid) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisarequisicaoarh ($nom,$dati,$datf,$con){
	if($nom==''){
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		t.descricao as tipo, s.descricao as situacao
		from arhweb.requisicao as r 
		inner join arhweb.tipodeservico as t
		on r.tipodeservico_id = t.id
		inner join arhweb.situacaorequisicao as s
		on r.situacaorequisicao_id = s.id
		inner join pessoal.pessoa as p on p.id=r.pessoa_id
		where r.data between '$dati' and '$datf' order by p.nome";
	}else{	
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		t.descricao as tipo, s.descricao as situacao
		from arhweb.requisicao as r 
		inner join arhweb.tipodeservico as t
		on r.tipodeservico_id = t.id
		inner join arhweb.situacaorequisicao as s
		on r.situacaorequisicao_id = s.id
		inner join pessoal.pessoa as p on p.id=r.pessoa_id
		where p.nome like '%$nom%' and r.data between '$dati' and '$datf' order by p.nome";
	}
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisarequisicaoarh) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisahistoricopsi($pid,$con){
	$sql="SELECT h.*, s.descricao as situacao
		from psicoweb.historico as h
		inner join psicoweb.requisicao as r on h.requisicao_id=r.id 
		inner join psicoweb.situacaorequisicao as s
		on r.situacaorequisicao_id = s.id
		where r.pessoa_id=$pid order by h.id";
	$trace=ftrace('fpesquisahistoricopsi',$sql);
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisahistoricopsi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisaagendapsi ($nom,$dati,$datf,$con){
	if($nom==''){
	$sql="SELECT a.*, p.denominacaocomum AS responsavel, p1.nome AS paciente, h.descricao as horario, e.descricao AS evento,
	o.descricao as ocorrencia
	FROM psicoweb.agenda AS a
	INNER JOIN psicoweb.sala AS s ON a.sala_id=s.id
	INNER JOIN psicoweb.horario AS h ON a.horario_id=h.id
	INNER JOIN psicoweb.evento AS e ON a.evento_id=e.id
	INNER JOIN pessoal.pessoa AS p ON a.responsavelpessoa_id=p.id
	INNER JOIN psicoweb.requisicao AS r ON a.requisicao_id=r.id
	LEFT  JOIN pessoal.pessoa AS p1 ON r.pessoa_id=p1.id
	INNER JOIN psicoweb.ocorrenciaagendamento AS o ON a.ocorrenciaagendamento_id=o.id
	where a.data between '$dati' and '$datf' order by a.data, h.descricao, paciente";
	}else{	
	$sql="SELECT a.*, p.denominacaocomum AS responsavel, p1.nome AS paciente, h.descricao as horario, e.descricao AS evento,
	o.descricao as ocorrencia
	FROM psicoweb.agenda AS a
	INNER JOIN psicoweb.sala AS s ON a.sala_id=s.id
	INNER JOIN psicoweb.horario AS h ON a.horario_id=h.id
	INNER JOIN psicoweb.evento AS e ON a.evento_id=e.id
	INNER JOIN pessoal.pessoa AS p ON a.responsavelpessoa_id=p.id
	INNER JOIN psicoweb.requisicao AS r ON a.requisicao_id=r.id
	LEFT  JOIN pessoal.pessoa AS p1 ON r.pessoa_id=p1.id
	INNER JOIN psicoweb.ocorrenciaagendamento AS o ON a.ocorrenciaagendamento_id=o.id
	where p1.nome like '%$nom%' and a.data between '$dati' and '$datf' order by a.data, h.descricao, paciente";
	}
	try {
		$trace=ftrace('fpesquisaagendapsi',addslashes($sql));
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisaagendapsi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisapacientepsi ($nom,$dati,$datf,$con){
	// pesquisa pessoal.pessoa presente em psicoweb.requisicao e psicoweb.pessoa
	if($nom==''){
	$sql="SELECT p.*, f.sexo, f.datanascimento,
		r.nomeacompanhante, t.descricao as tipodeacompanhante,
		r.docacompanhante, r.curso, r.plantao, r.data, 
		r.id as requisicaoid, n.descricao as naturezadapessoa
		from pessoal.pessoa as p 
		inner join pessoal.pessoafisica as f on f.id=p.id
		inner join psicoweb.pessoa as pp on pp.pessoa_id=p.id
		inner join psicoweb.naturezadapessoa as n on n.id=pp.naturezadapessoa_id
		inner join psicoweb.requisicao as r on r.pessoa_id=pp.pessoa_id
		inner join psicoweb.tipodeacompanhante as t on t.id=r.tipodeacompanhante_id
		where p.situacao_id<3 and r.situacaorequisicao_id<6 and r.data between '$dati' and '$datf' order by p.nome, p.id desc, r.id desc";
	}else{	
	$sql="SELECT p.*, f.sexo, f.datanascimento,
		r.nomeacompanhante, t.descricao as tipodeacompanhante,
		r.docacompanhante, r.curso, r.plantao,r.data, 
		r.id as requisicaoid, n.descricao as naturezadapessoa
		from pessoal.pessoa as p 
		inner join pessoal.pessoafisica as f on f.id=p.id
		inner join psicoweb.pessoa as pp on pp.pessoa_id=p.id
		inner join psicoweb.naturezadapessoa as n on n.id=pp.naturezadapessoa_id
		inner join psicoweb.requisicao as r on r.pessoa_id=pp.pessoa_id
		inner join psicoweb.tipodeacompanhante as t on t.id=r.tipodeacompanhante_id
		where p.situacao_id<3 and p.nome like '%$nom%' and r.situacaorequisicao_id<6 and  r.data between '$dati' and '$datf' order by p.nome, p.id desc, r.id desc";
	}
	try {
		//$trace=ftrace('fpesquisapacientepsi',addslashes($sql));
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisapacientepsi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisarequisicao ($nom,$dati,$datf,$con){
	if($nom==''){
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		m.nome as medico
		from aclinica.requisicao as r 
		inner join aclinica.medico as m
		on r.medico_id = m.id
		inner join pessoal.pessoa as p on p.id=r.pessoa_id
		where r.data between '$dati' and '$datf' order by id desc";
	}else{	
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		m.nome as medico
		from aclinica.requisicao as r 
		inner join aclinica.medico as m
		on r.medico_id = m.id
		inner join pessoal.pessoa as p on p.id=r.pessoa_id
		where p.nome like '%$nom%' and r.data between '$dati' and '$datf' order by id desc";
	}
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisarequisicao) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisasala($txt, $con) {
	$txt = trim($txt);
	$blc = substr($txt,0,3);
	if(is_numeric($blc)){
		$sql = "select s.*, b.codigo as bloco, t.sigla as tipo, t.descricao as descricaotipo 
				from sala as s
				inner join bloco as b on s.id_bloco=b.id
				inner join tipodesala as t on s.id_tipodesala=t.id 
				where s.codigo like '%txt%'
				order by s.id_bloco, t.sigla, s.numero";
	}else{
		$sql = "select s.*, b.codigo as bloco, t.sigla as tipo, t.descricao as descricaotipo 
				from sala as s
				inner join bloco as b on s.id_bloco=b.id
				inner join tipodesala as t on s.id_tipodesala=t.id 
				where s.descricao like '%txt%'
				order by s.id_bloco, t.sigla, s.numero";
	}
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisasala) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisabloco($txt, $con) {
	$txt = trim($txt);
	$blc = substr($txt,0,2);
	if(is_numeric($blc)){
		$sql = "select b.*
				from bloco as b
				where b.codigo = $txt
				order by b.codigo";
	}else{
		$sql = "select b.*
				from bloco as b
				where descricao like '%$txt%' or localizacao like '%$txt%'
				order by b.codigo";
	}
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisabloco) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisatipodesala($txt, $con) {
	$txt = trim($txt);
	if($txt=='') {
		$sql = "select t.*
				from tipodesala as t
				order by t.sigla";
	}else{
		$sql = "select t.*
				from tipodesala as t
				where descricao like '%$txt%' 
				order by t.sigla";
	}	
	try {
		$rs=$con->query($sql);
		return $rs;
	}catch (PDOException $e) {
		$_SESSION['msg']='ERRO PDOException: (fpesquisatipodesala) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function lepessoaarhsiapeativo($siape,$con) {
try {
	$sql="SELECT p.id AS pessoaid, p.cnpjcpf AS cpf, p.denominacaocomum AS apelido, p.nome, p.fone, p.email
	FROM pessoal.pessoa AS p
	INNER JOIN arhweb.pessoa AS pp ON pp.pessoa_id=p.id
	WHERE pp.siape='$siape' AND pp.situacao_id<>3";
	
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoaarhsiapeativo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function lepessoaarhcpfativo($cpf,$con) {
try {
	$sql="SELECT p.id AS pessoaid, p.cnpjcpf AS cpf, p.denominacaocomum AS apelido, p.nome, p.fone, p.email
	FROM pessoal.pessoa AS p
	INNER JOIN arhweb.pessoa AS pp ON pp.pessoa_id=p.id
	WHERE p.cnpjcpf='$cpf' AND pp.situacao_id<>3";
	
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoaarhcpfativo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function lePessoaPorCPF($cpf,$con) {
try {
	$sql="SELECT pessoa.id as pessoaid, pessoa.cnpjcpf AS cpf,pessoa.denominacaocomum AS apelido, 
			pessoa.nome, pessoa.fone, pessoa.email
			FROM pessoa
			WHERE pessoa.cnpjcpf='$cpf'";
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['erro']='ERRO: Nenhuma pessoa encontrada -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['erro']='ERRO: Não leu pessoa -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (lePessoaPorCPF) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leusuarioporcpf($cpf,$con) {
try {
	$sql="SELECT usuario.id, usuario.identificacao AS usuario,
			usuario.nivelusuario_id AS nivel, niveldeusuario.descricao as nomenivel, usuario.ativo AS ativo,
			pessoa.id as pessoaid, pessoa.cnpjcpf AS cpf,pessoa.denominacaocomum AS apelido, 
			pessoa.nome, pessoa.fone, pessoa.email
			FROM usuario
			INNER JOIN pessoa 
			ON usuario.pessoa_id=pessoa.id
			INNER JOIN niveldeusuario ON usuario.nivelusuario_id=niveldeusuario.id
			WHERE pessoa.cnpjcpf='$cpf'";
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: (leusuarioporcpf) Nenhum usuario encontrado -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (leusuarioporcpf) Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: ((leusuarioporcpf)) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leusuarioporidentificacao($id,$con) {
try {
	$sql="SELECT usuario.identificacao AS usuario,usuario.nivelusuario_id AS nivel, usuario.ativo AS ativo,
			pessoa.id as pessoaid, pessoa.cnpjcpf AS cpf,pessoa.denominacaocomum AS apelido, 
			pessoa.nome, pessoa.fone, pessoa.email
			FROM usuario
			INNER JOIN pessoa 
			ON usuario.pessoa_id=pessoa.id
			WHERE usuario.identificacao='$id'";
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['erro']='ERRO: Nenhum usuario encontrado -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['erro']='ERRO: Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function letabelaporid($tab,$id,$con) {
try {
	$sql="SELECT * from ".$tab." WHERE id=$id";
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

function levinculo($pid,$con) {
try {
	$ssql = "select i.*, t.descricao as tipovinculo
	from institucional as i
	inner join tipodevinculo as t on t.id=i.tipodevinculo_id
	where i.pessoafisica_id=$pid";
//die($ssql);
	$rs= $con->query($ssql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch();
			return $reg;
		}else{
			$_SESSION['msg']='Registro institucional inexiste para o Id-> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler o registro institucional -> ' . $ssql;
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (levinculo) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}

function leusuarioporpessoaid($pid,$con) {
try {
	$sql = "SELECT u.*, 
			n.descricao as niveldeusuario,
			p.id as pessoaid, p.cnpjcpf AS cpf, 
			p.denominacaocomum AS apelido, 
			p.nome, p.fone, p.email
			FROM usuario as u 
			inner join niveldeusuario as n on n.id=u.nivelusuario_id
			INNER JOIN pessoa as p on u.pessoa_id=p.id
			WHERE u.pessoa_id=$pid"; 
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
//			$_SESSION['msg']='Falha (leusuarioporpessoaid): Não encontrou usuario -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='Falha (leusuarioporpessoaid): Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuarioporpessoaid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leusuarioporid($id,$con) {
try {
	$sql="SELECT u.*, n.descricao as niveldeusuario,
			p.id as pessoaid, p.cnpjcpf AS cpf, 
			p.denominacaocomum AS apelido, 
			p.nome, p.fone, p.email
			FROM usuario as u 
			inner join niveldeusuario as n on n.id=u.nivelusuario_id
			INNER JOIN pessoa as p on u.pessoa_id=p.id
			WHERE u.id=$id"; 
	//$trace=ftrace('leusuarioporid',$sql);		
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO (leusuarioporid): Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuarioporid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function lepessoaarhporpessoaid($pid,$con){
try {
	$ssql="select p.*,
		c.descricao as categoria, 
		cg.descricao as cargo,
		s.descricao as situacao
		from pessoa as p
		inner join categoria as c on p.categoria_id=c.id
		inner join cargo as cg on p.cargo_id=cg.id
		inner join situacao as s on p.situacao_id=s.id
		where p.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoaarhporpessoaid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function lepessoapsiporpessoaid($pid,$con){
try {
	$ssql="select p.*, n.descricao as natureza
		from pessoa as p
		inner join naturezadapessoa as n on p.naturezadapessoa_id=n.id	
		where p.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoapsiporpessoaid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function lepessoanaeporpessoaid($pid,$con){
try {
	$ssql="select p.*, n.descricao as natureza
		from pessoa as p
		inner join naturezadapessoa as n on p.naturezadapessoa_id=n.id	
		where p.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoanaeporpessoaid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function lepessoaaclporpessoaid($pid,$con){
try {
	$ssql="select p.*, n.descricao as natureza
		from pessoa as p
		inner join naturezadapessoa as n on p.naturezadapessoa_id=n.id	
		where p.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoaaclporpessoaid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leusuarionae($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo,
		n.descricao as niveldousuario
		from usuario as u 
		inner join niveldousuario as n on u.niveldousuario_id=n.id
		inner join grupo as g on u.grupo_id=g.id
		where u.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (leusuarionae) Ao ler registro de usuario -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuarionae) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leusuarioacl($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo,
		n.descricao as niveldousuario
		from usuario as u 
		inner join niveldousuario as n on u.niveldousuario_id=n.id
		inner join grupo as g on u.grupo_id=g.id
		where u.pessoa_id= $pid";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (leusuarioacl) Ao ler registro de usuario -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuarioacl) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leusuarioarh($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo,
		n.descricao as niveldousuario
		from usuario as u 
		inner join niveldousuario as n on u.niveldousuario_id=n.id
		inner join grupo as g on u.grupo_id=g.id
		where u.pessoa_id= $pid"; 
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuarioarh) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leusuariopsi($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo,
		n.descricao as niveldousuario
		from usuario as u 
		inner join niveldousuario as n on u.niveldousuario_id=n.id
		inner join grupo as g on u.grupo_id=g.id
		where u.pessoa_id= $pid"; 
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuariopsi) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leformacaoprofissional($id,$con){
try {
	$ssql="select f.*
		from formacaoprofissional as f
		where f.id= $id";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: Ao ler formacaoprofissional -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler formacaoprofissional -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leformacaoprofissional) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leexpedidorrg($id,$con){
try {
	$ssql="select e.*
		from expedidorrg as e
		where e.id= $id";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: Ao ler expedidor rg -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler expedidor rg -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leexpedidorrg) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function lepessoafisicaporid($id,$con){
try {
	$ssql="select f.*, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido,
		p.nome, p.fone, p.email
		from pessoafisica as f
		inner join pessoa as p on p.id=f.id
		where p.id= $id";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoafisicaporid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function lepessoafisicaporcpf($cpf,$con){
try {
	$ssql="select f.*, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido,
		p.nome, p.fone, p.email
		from pessoafisica as f
		inner join pessoa as p on p.id=f.id
		where p.cnpjcpf= '$cpf'";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='Falha: Registro não encontrado em pessoal -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='Falha: Não foi possível ler o registro de Pessoal -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (flepessoafisicaporcpf) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function fproxnumero($tab,$campo,$ano,$con){
	$ssql = "SELECT SUBSTRING(".$campo.",7,4) AS ano,SUBSTRING(".$campo.",1,5) AS num FROM ".$tab.
			" where SUBSTRING(".$campo.",7,4)=".$ano.
			" ORDER BY SUBSTRING(".$campo.",7,4),SUBSTRING(".$campo.",1,5)";
			//die($ssql);
	$leu = mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$reg=mysql_fetch_array($leu);
		$v=$reg['num'];
		if($v>0){
			$n=$v+1;
		}else{
			$n=1;
		}
		return substr('00000'.$n,-5)."/".$ano;
	}else{
		return "00001/".$ano;
	}		
}

function falterasenha($id,$senhaatual,$senha,$usu,$con) {
	date_default_timezone_set('America/Fortaleza');
		$dataalteracao=date("y-m-d h:m:s");
		$query = "UPDATE usuario set senha='$senha'
				  where
				  id=$id ";
		$q=addslashes($query." - Senha anterior:".$senhaatual);
		$q1 = "INSERT INTO hystory (objeto, ssql, data) VALUES (
			  'usuario','$q','$dataalteracao')";
		$insert = mysql_query($q1,$con);
		if($insert){
			$altera = mysql_query($query,$con);
			//die($query);
		}else{ die ($q1);
		}
		if($altera){
		}else{
		}
		return $altera;
}

function fincluiusuario($id,$identificacao,$senha,$pessoafisica_id,$tipousuario_id,$ativo, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$idd=fproximoid("usuario",$con);
	$query = "insert into usuario values ('$idd','$identificacao','$senha','$pessoafisica_id','$tipousuario_id','$ativo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'usuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
		$idd=0;
	}
	return $idd;
}

function falterausuario($id,$identificacao,$senha,$pessoafisica_id,$tipousuario_id,$ativo, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	if($senha<>""){
		$query="UPDATE usuario set senha='$senha',tipousuario_id='$tipousuario_id',ativo='$ativo' where id=$id";
	}else{
		$query="UPDATE usuario set tipousuario_id='$tipousuario_id',ativo='$ativo' where id=$id";
	}	

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'usuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function flesql($sql, $con) {
	$leit=mysql_query($sql,$con);	
	//die($sql);
	//$reg=mysql_fetch_array($leit);
	return $leit;
}

function fexcluiid($id,$tab,$usu,$con){
	date_default_timezone_set('America/Fortaleza');
	$tab=strtolower($tab);	
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "delete from $tab where id=$id";
	//die($query);
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', '$tab','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$exclui = mysql_query($query,$con);
		//die("Excluindo... ".$query);
	}else{ die("NÃ£o Excluiu... ".$q1); $exclui=false;}
	//die($id);
	return ($exclui);
}

function fexcluiPermissao($id, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "delete from permissao where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'associacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	//die($id);
	return ($id);
}

function falterapermissao($id,$perfil_id,$funcionalidade_id,$permissao,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE permissao set perfil_id='$perfil_id',funcionalidade_id='$funcionalidade_id',
	permissao='$permissao',ativo='$ativo' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'permissao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluipermissao($id,$perfil_id,$funcionalidade_id,$permissao,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("permissao",$con);
	$query = "insert into permissao values ('$id','$perfil_id','$funcionalidade_id','$permissao','$ativo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'permissao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fexcluiperfil_usuario($id, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "delete from perfil_usuario where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'associacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	//die($id);
	return ($id);
}

function falteraperfil_usuario($id,$usuario_id,$perfil_id,$expiraem,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE perfil_usuario set usuario_id='$usuario_id',perfil_id='$perfil_id',expiraem='$expiraem',ativo='$ativo' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'perfil_usuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiperfil_usuario($id,$usuario_id,$perfil_id,$expiraem,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("perfil_usuario",$con);
	$query = "insert into perfil_usuario values ('$id','$usuario_id','$perfil_id','$expiraem','$ativo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'perfil_usuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function flefuncionalidade($id,$con){
	$ssql="select * from funcionalidade where id=$id";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$reg=mysql_fetch_array($leu);
	}else{
		$reg=false;
	}
	if($reg){
		return $reg['descricao'];
	}else{return '';}
}
	                      
function flepesarh01($con){
try {	
	$ssql = "select p.*, f.datanascimento, f.sexo, f.rg, f.expedidorrg_id,
			f.formacaoprofissional_id, c.descricao as categoria,
			cg.descricao as cargo, s.descricao as situacao
			from arhweb.pessoa as pp
			inner join categoria as c on pp.categoria_id=c.id
			inner join cargo as cg on pp.cargo_id=cg.id
			inner join situacao as s on pp.situacao_id=s.id
			inner join pessoal.pessoa as p on pp.pessoa_id=p.id
			inner join pessoal.pessoafisica as f on p.id=f.id
			order by p.nome";
	$rs= $con->query($ssql);
	return $rs;
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO exception: (flepesarh01) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

function flePessoaAclinica($con){
try {	
	$ssql = "select p.*, f.datanascimento, f.sexo, f.rg, f.expedidorrg_id,
			f.formacaoprofissional_id, nnp.descricao as naturezadapessoa
			from aclinica.pessoa as pp
			inner join aclinica.naturezadapessoa as nnp on pp.naturezadapessoa_id=nnp.id
			inner join pessoal.pessoa as p on pp.pessoa_id=p.id
			inner join pessoal.pessoafisica as f on p.id=f.id
			order by p.nome";
	$rs= $con->query($ssql);
	return $rs;
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO exception: (flePessoaAclinica) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

function flebloco($rid,$tipo,$con){
	$ssql="select * from bloco where relatorio_id=$rid and tipobloco_id=$tipo";

	try {
		$rs= $con->query($ssql); 
		if($rs) {
			if($rs->rowCount()>0) {
				$reg=$rs->fetch(); 
				return $reg;
			}else{
				//$_SESSION['msg']='ERRO: Ao ler bloco -> ' . $ssql;
				return false;
			}
		}else{
			$_SESSION['msg']='ERRO: Ao ler bloco -> ' . $ssql;
			return false;
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO exception: (flebloco) ' . $e->getMessage(). ' '. $ssql;
		return false;
	}	

}
	                      
function fleestilo($estiloid,$con){
	$ssql = "select * from estilo where id = $estiloid";
	try {
		$rs= $con->query($ssql); 
		if($rs) {
			if($rs->rowCount()>0) {
				$reg=$rs->fetch(); 
				return $reg;
			}else{
				$_SESSION['msg']='ERRO: Ao ler estilo -> ' . $ssql;
				return false;
			}
		}else{
			$_SESSION['msg']='ERRO: Ao ler estilo -> ' . $ssql;
			return false;
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO exception: (fleestilo) ' . $e->getMessage(). ' '. $ssql;
		return false;
	}	
}

function flereport($repident,$con){
	$ssql = "select * from relatorio where identificador = '$repident'";
	try {
		$rs= $con->query($ssql); 
		if($rs) {
			if($rs->rowCount()>0) {
				$reg=$rs->fetch(); 
				return $reg;
			}else{
				$_SESSION['msg']='ERRO: Ao ler relatório -> ' . $ssql;
				return false;
			}
		}else{
			$_SESSION['msg']='ERRO: Ao ler relatório -> ' . $ssql;
			return false;
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO exception: (flereport) ' . $e->getMessage(). ' '. $ssql;
		return false;
	}	
}

function falteramsg_status($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE msg_status set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'msg_status','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluimsg_status($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("msg_status",$con);
	$query = "insert into msg_status values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'msg_status','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterafuncionalidade($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE funcionalidade set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'funcionalidade','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluifuncionalidade($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("funcionalidade",$con);
	$query = "insert into funcionalidade values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'funcionalidade','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraperfil($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE perfil set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'perfil','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiperfil($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("perfil",$con);
	$query = "insert into perfil values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'perfil','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratipousuario($id,$descricao,$gerencia_regional_id,$orgao_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipousuario set descricao='$descricao',gerencia_regional_id='$gerencia_regional_id',
	orgao_id='$orgao_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'tipousuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluitipousuario($id,$descricao,$gerencia_regional_id,$orgao_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipousuario",$con);
	$query = "insert into tipousuario values ('$id','$descricao','$gerencia_regional_id','$orgao_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'tipousuario','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraSituacao($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE situacao set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Situacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiSituacao($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("situacao",$con);
	$query = "insert into situacao values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Situacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraFormacao_Profissional($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE formacao_profissional set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Formacao_Profissional','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiFormacao_Profissional($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("formacao_profissional",$con);
	$query = "insert into formacao_profissional values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Formacao_Profissional','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraExpedidor_RG($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE expedidor_rg set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Expedidor_RG','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiExpedidor_RG($id,$descricao, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("expedidor_rg",$con);
	$query = "insert into expedidor_rg values ($id,'$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Expedidor_RG','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiUnidade_Federativa(
$id,$descricao,$sigla, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("unidade_federativa",$con);
	$query = "insert into unidade_federativa values ('$id','$descricao','$sigla')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Unidade_Federativa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
	
function falteraUnidade_Federativa($id,$descricao,$sigla, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE unidade_federativa set descricao='$descricao',sigla='$sigla' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'Unidade_Federativa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
	
function fleenderecopessoa($pid,$con){
try {
	$ssql="select endereco.* from endereco
			where pessoa_id=$pid order by id desc";
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			//$_SESSION['msg']='Alerta: (fleenderecopessoa) Id não encontrado $pid -> ' . $ssql;
			return false;
		}
	}else{
		//$_SESSION['msg']='ERRO: (fleenderecopessoa) Ao ler registro de Pessoal -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleenderecopessoa) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
		
}	

function fleendereco($id,$con){
$ssql="select endereco.*, municipio.descricao as municipio_nome
		from endereco,municipio
		where endereco.municipio_id=municipio.id and endereco.pessoa_id=$id";
$ler=mysql_query($ssql,$con);
return $ler;		
}	

function falteraFone($id,$fone,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE pessoa set fone='$fone' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'fone','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}	

function falteraEndereco($pessoa_id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");
	$leu=fleendereco($pessoa_id,$con);
	if(mysql_num_rows($leu)>0){
		$query="delete from endereco where pessoa_id=$pessoa_id";
		$altera = mysql_query($query,$con);
	}
//	if(mysql_num_rows($leu)>0){
//		$query = "UPDATE endereco set logradouro='$logradouro',numero='$numero',
//		complemento='$complemento',bairro='$bairro',cep='$cep',municipio_id='$municipio_id',
//		email='$email' where pessoa_id=$pessoa_id";
//	}else{
		$id=fproximoid("endereco",$con);
		$query="insert into endereco values ('$id', '$logradouro', '$numero', '$complemento',
		'$bairro', '$cep', '$municipio_id', '$email','$pessoa_id')";
//	}	
//die($query);
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'endereco','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}	

function fincluiMunicipio($descricao,$e_sede,$populacao_rural,$populacao,$populacao_urbana,
	$num_familias,$num_domicilios,$area,$idh,$pib,$num_domicio_rede_geral,$num_domicio_poco,
	$num_domicio_outro,$num_domicio_possui_rede_eletrica,$num_domicio_n_possui_rede_eletrica,
	$num_domicio_possui_banheiro,$num_domicio_n_possui_banheiro,$cnpj,$gerencia_regional_id,
	$unidade_federativa_id,$codigo_siafi,$area_emergencia,$territorio,$selecionado,
	$prioritario,  $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");	
	$id=fproximoid("municipio",$con);
	$query = "insert into municipio values (
				'$id','$descricao','$e_sede','$populacao_rural',
				'$populacao','$populacao_urbana','$num_familias','$num_domicilios',
				'$area','$idh','$pib','$num_domicio_rede_geral','$num_domicio_poco',
				'$num_domicio_outro','$num_domicio_possui_rede_eletrica','$num_domicio_n_possui_rede_eletrica',
				'$num_domicio_possui_banheiro','$num_domicio_n_possui_banheiro','$cnpj',
				'$gerencia_regional_id','$unidade_federativa_id','$codigo_siafi','$area_emergencia',
				'$territorio','$selecionado','$prioritario'
			 )";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'municipio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($inclui){
	}else{
		die($query);
	}
	return $inclui;
}	

function falteraMunicipio($id,$descricao,$e_sede,$populacao,$populacao_rural,$populacao_urbana,
	$num_familias,$num_domicilios,$area,$idh,$pib,$num_domicio_rede_geral,$num_domicio_poco,
	$num_domicio_outro,$num_domicio_possui_rede_eletrica,$num_domicio_n_possui_rede_eletrica,
	$num_domicio_possui_banheiro,$num_domicio_n_possui_banheiro,$cnpj,$gerencia_regional_id,
	$unidade_federativa_id,$codigo_siafi,$area_emergencia,$territorio,$selecionado,
	$prioritario,   $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "UPDATE municipio set descricao='$descricao',e_sede='$e_sede',populacao='$populacao',
				populacao_rural='$populacao_rural',populacao_urbana='$populacao_urbana',
				num_familias='$num_familias',num_domicilios='$num_domicilios',area='$area',
				idh='$idh',pib='$pib',num_domicio_rede_geral='$num_domicio_rede_geral',
				num_domicio_poco='$num_domicio_poco',num_domicio_outro='$num_domicio_outro',
				num_domicio_possui_rede_eletrica='$num_domicio_possui_rede_eletrica',
				num_domicio_n_possui_rede_eletrica='$num_domicio_n_possui_rede_eletrica',
				num_domicio_possui_banheiro='$num_domicio_possui_banheiro',
				num_domicio_n_possui_banheiro='$num_domicio_n_possui_banheiro',cnpj='$cnpj',
				gerencia_regional_id='$gerencia_regional_id',
				unidade_federativa_id='$unidade_federativa_id',
				codigo_siafi='$codigo_siafi',area_emergencia='$area_emergencia' ,
				territorio_desenvolvimento_id='$territorio',
				selecionado='$selecionado',prioritario='$prioritario'
			where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'municipio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return $altera;
}	

function fincluiComunidade($descricao,$numero_homens,$numero_mulheres,
		$numero_criancas,$casas_concentradas,$casas_dispersas,$zona_id,
		$municipio_id,$tipo_estrada_id,$distanciaKMSede, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("comunidade",$con);
	$query = "insert into comunidade values ('$id','$descricao','$numero_homens',
		'$numero_mulheres','$numero_criancas','$casas_concentradas',
		'$casas_dispersas','$zona_id','$municipio_id','$tipo_estrada_id',
		'$distanciaKMSede')";
	//die($query);

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'comunidade','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}	
	return $inclui;
}

function falteraComunidade($id,$descricao,$numero_homens,$numero_mulheres,$numero_criancas,
	$casas_concentradas,$casas_dispersas,$zona_id,$municipio_id,$tipo_estrada_id,
	$distanciaKMSede, $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE comunidade set descricao='$descricao',numero_homens='$numero_homens',
				numero_mulheres='$numero_mulheres',numero_criancas='$numero_criancas',casas_concentradas='$casas_concentradas',
				casas_dispersas='$casas_dispersas',zona_id='$zona_id',municipio_id='$municipio_id',
				tipo_estrada_id='$tipo_estrada_id',distanciaKMSede='$distanciaKMSede' 
			where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'comunidade','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return $altera;
	
}	

function fincluiMSG($id,$identificacao_destino,$identificacao_origem,$msg_assunto_id,$mensagem,$msg_status_id,$data_envio,$data_leitura,$idbase, $usu,$con) {
	$data_envio=date("y-m-d h:m:s");
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("msg",$con);
	if($idbase==0){$idbase=$id;}
	
	$query = "insert into msg values ('$id','$identificacao_destino','$identificacao_origem','$msg_assunto_id','$mensagem','$msg_status_id','$data_envio','$data_leitura','$idbase')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'msg','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	return $inclui;
}

function fincluiPessoaFisica($id,$nome,$fone,$cpf,$rg,$datanascimento,$sexo,$formacaoprofissional_id,
$expedidorrg_id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$dtn=formataData($datanascimento);
	$id=fproximoid("pessoa",$con);
	
	$q0="insert into pessoa values ($id,'$nome','$fone')";
	
	$query = "insert into pessoafisica values ('$id','$dtn','$sexo','$cpf','$rg','$expedidorrg_id',
	'$formacaoprofissional_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'pessoafisica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		//die($q1);
		$r=mysql_query($q0,$con);
		if($r){
			$inclui = mysql_query($query,$con);
		}else{ //die($q0);
		}		
	}else{ die ($q1);}
	if($inclui){
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con);
		//$conta=falteraConta_Corrente($id,'F',$agencia_id,$contacorrente,$usu,$con);
	}else{
		$id=0;
	}
	return $id;
}

function falteraPessoaFisica($id,$nome,$cpf,$rg,$datanascimento,$sexo,$formacaoprofissional_id,
$expedidorrg_id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone,$email, $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	
	$dtn=formataData($datanascimento);

	$query = "UPDATE pessoafisica set cpf='$cpf',rg='$rg',datanascimento='$dtn',sexo='$sexo',
	formacaoprofissional_id='$formacaoprofissional_id',expedidorrg_id='$expedidorrg_id' where id=$id";
	//die($query);
	$q2 = "UPDATE pessoa set nome='$nome',fone='$fone' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'pessoafisica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
		$altera2 = mysql_query($q2,$con);
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con);
		//$conta=falteraConta_Corrente($id,'F',$agencia_id,$contacorrente,$usu,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return ($altera && $altera2);
}	

function fincluiPessoa_Juridica($id,$nome,$cnpj,$nome_razao_social,$data_cadastro,$situacao_id,$fornecedor,
                                $logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone,$email,
								$usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");

	$id=fproximoid("pessoa",$con);
	$q0="insert into pessoa values ($id,'$nome','$fone')";
	
	$data_cadastro=formataData($data_cadastro);
	$query = "insert into pessoa_juridica values ('$id','$cnpj','$nome_razao_social','$data_cadastro',
	'$situacao_id', '$fornecedor')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'pessoa_juridica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$r=mysql_query($q0,$con);
		if($r){
			$inclui = mysql_query($query,$con);
		}else{ die("NÃ£o foi possÃ­vel incluir pessoa :".$q0);
		}		
	}else{ die ($q1);}
	if($inclui){
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con);
		//$conta=falteraConta_Corrente($id,'J',$agencia_id,$contacorrente,$usu,$con);
	}else{
	}
	return $inclui;
}

function falteraPessoa_Juridica($id,$cnpj,$nome,$nome_razao_social,$data_cadastro,$situacao_id, 
$fornecedor,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone,$email,  $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE pessoa_juridica set cnpj='$cnpj',nome_razao_social='$nome_razao_social',data_cadastro='$data_cadastro',situacao_id='$situacao_id',fornecedor='$fornecedor' where id=$id";
	$q2 = "UPDATE pessoa set nome='$nome',fone='$fone' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario, objeto, ssql, data) VALUES (
			'$usu', 'pessoa_juridica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
		$altera2 = mysql_query($q2,$con);
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$email, $usu,$con);
		//$conta=falteraConta_Corrente($id,'J',$agencia_id,$contacorrente,$usu,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return ($altera && $altera2);
	
}	

function fverificaPessoaFisica($nome,$cpf, $con){
	$ssql = "select * from pessoa,pessoafisica where pessoa.id=pessoafisica.id 
			and (upper(pessoa.nome) = '$nome' or pessoafisica.cpf = '$cpf')";
	$rs=mysql_query($ssql,$con);
	if(mysql_num_rows($rs)>0) {
		return true;
	}
	return false;
}	
	
function fverificaPessoaJuridica($nome,$cnpj, $con){
	$ssql = "select * from pessoa,pessoajuridica where pessoa.id=pessoajuridica.id 
			and (upper(pessoa.nome) = '$nome' or pessoajuridica.cnpj = '$cnpj')";
	$rs=mysql_query($ssql,$con);
	if(mysql_num_rows($rs)>0) {
		return true;
	}
	return false;
}	
	
function fverificaPessoa($nome, $con){
	$ssql = "select * from pessoa where upper(pessoa.nome) = '$nome'";
	$rs=mysql_query($ssql,$con);
	if(mysql_num_rows($rs)>0) {
		return true;
	}
	return false;
}

function fpesquisapermissao($perfilid,$con){
	$ssql="select * from permissao where perfil_id=$perfilid";
	$rs=mysql_query($ssql,$con);
	return $rs;
}
	


function fpesquisaobra($txt,$con){
	if($txt==''){
		$ssql="select obra.*, tipoobra.descricao as tipoobradescricao, 
		       local.descricao as localdescricao, editora.descricao as editoradescricao
		FROM obra
		inner join tipoobra on tipoobra.codigo=obra.tipoobra_codigo
		inner join local on local.id=obra.local_id
		inner join editora on editora.id=obra.editora_id
		ORDER BY obra.titulo
		limit 35";
	}else{
		$ssql="select obra.*, tipoobra.descricao as tipoobradescricao, 
		       local.descricao as localdescricao, editora.descricao as editoradescricao
		FROM obra
		inner join tipoobra on tipoobra.codigo=obra.tipoobra_codigo
		inner join local on local.id=obra.local_id
		inner join editora on editora.id=obra.editora_id
		where titulo like '%$txt%'
		ORDER BY obra.titulo
		limit 35";
	}
//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fpesquisaperfilusuario($txt,$id,$con){
	$ssql="SELECT perfil_usuario.*,perfil.descricao
		FROM perfil_usuario
		INNER JOIN perfil ON perfil.id=perfil_usuario.perfil_id
		WHERE perfil_usuario.usuario_id=$id
		ORDER BY perfil.descricao,perfil_usuario.id";
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;

}

function flemunicipio($id,$con) {
	$ssql="select * from municipio where id=$id";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function fleidentificacaoUsuario($ident,$con) {
	$ssql="select usuario.*
		from usuario 
		where identificacao='$ident'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}



function fleusuarioPessoaFisica($id,$con) {
	$ssql="select usuario.*
		from usuario 
		where pessoafisica_id=$id";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecpfPessoaFisica($cpf,$con) {
	$ssql="select pessoafisica.*
		from pessoafisica 
		where pessoafisica.cpf='$cpf'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		//die($ssql);
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecnpjPessoaJuridica($cnpj,$con) {
	$ssql="select pessoajuridica.*
		from pessoajuridica 
		where pessoajuridica.cnpj='$cnpj'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function fleidMSG($id,$tab,$con){
	$ssql="select msg.*
		from msg
		where id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidtabela($id,$tab,$con){
	$tab=strtolower($tab);
	
 	if($tab=='pessoafisica'){
		$ssql="select pessoafisica.*,pessoa.nome as pessoanome
		from pessoafisica,pessoa where pessoafisica.id=pessoa.id and pessoafisica.id = $id";
	}else{
 	if($tab=='pessoa_juridica'){
		$ssql="select pessoa_juridica.*,pessoa.nome as pessoa_nome
		from pessoa_juridica,pessoa where pessoa_juridica.id=pessoa.id and pessoa_juridica.id = $id";
	}else{
 	if($tab=='usuario'){
		$ssql="select usuario.*, pessoafisica.cpf,pessoa.nome as pessoanome,
		tipousuario.descricao as tipousuariodescricao
		from usuario
		inner join pessoafisica on usuario.pessoafisica_id=pessoafisica.id
		inner join pessoa on pessoa.id=pessoafisica.id
		left join tipousuario on usuario.tipousuario_id=tipousuario.id
		where usuario.id=$id";
	}else{
		$ssql='select * from '.$tab.' where id='.$id;
		}
	}}
	
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	return $reg;
}

function fledescricaotabela($id,$tabela,$con){
	$reg=fleidtabela($id,$tabela,$con);
	return $reg['descricao'];
}	

function fleidentificacaonomeusuario($id,$con){
	$reg=fleidtabela($id,"usuario",$con);
	$ident=$reg['identificacao'];
	$idpes=$reg['pessoa_fisica_id'];
	$reg=fleidtabela($idpes,"pessoa",$con);
	return $ident."/".$reg['nome'];
}	

function fleidPessoa_JuridicaEndereco($id,$tab,$con){
	$ssql="select pessoa_juridica.*,pessoa.id as pessoa_id,
		pessoa.nome as pessoa_nome, pessoa.fone as pessoa_fone,
		endereco.id as endereco_id, endereco.logradouro,endereco.numero,
		endereco.complemento, endereco.bairro, endereco.cep, 
		endereco.municipio_id as endereco_municipio_id, endereco.email
		from pessoa_juridica,pessoa 
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id
		where pessoa_juridica.id=pessoa.id and pessoa.id = $id
		order by endereco.id desc";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

//************ ok
function fleidPessoaFisicaEndereco($id,$tab,$con){
	$ssql="SELECT pessoafisica.*,pessoa.id AS pessoa_id, pessoa.nome AS pessoanome, pessoa.fone AS pessoafone, 
			endereco.id AS endereco_id, endereco.logradouro,endereco.numero, endereco.complemento, endereco.bairro,	endereco.cep, endereco.municipio_id AS enderecomunicipio_id, endereco.email
		from pessoafisica,pessoa 
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id and endereco.pessoa_id=$id
		where pessoafisica.id=pessoa.id and pessoa.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die('Retorno nÃ£o permitido - '.$ssql);}
	return $reg;
}	

function flenomcpf($cpf,$con){
	$ssql="select pessoafisica.*,pessoa.nome as pessoanome
		from pessoafisica,pessoa where pessoafisica.id=pessoa.id 
		and pessoafisica.cpf= '$cpf'";
	//die($ssql);	
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if($reg){
		return $reg['pessoanome'];
	}else{	
		return 'NÃ£o Identificado';
	}	
}	
//************ fim ok

function flenomcnpj($cnpj,$con){
	$ssql="select pessoa_juridica.*,pessoa.nome as pessoa_nome
		from pessoa_juridica,pessoa where pessoa_juridica.id=pessoa.id 
		and pessoa_juridica.cnpj= '$cnpj'";
	//die($ssql);	
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if($reg){
		return $reg['pessoa_nome'];
	}else{	
		return 'NÃ£o Identificado';
	}	
}	

function flepessoajuridicaporcnpj($cnpj,$con){
	$ssql="select pessoa_juridica.*,pessoa.nome as pessoa_nome
		from pessoa_juridica,pessoa where pessoa_juridica.cnpj= '$cnpj'";
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	return $reg;
}	

function fletabelad($tabela,$con){
	$ssql="select * from ".$tabela." order by descricao";
	$leit=mysql_query($ssql,$con);
	return $leit;
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

function fletiposusuarios($con) {
		$sql="SELECT * FROM tipousuario order by id";
		$regs=mysql_query($sql,$con);
		return $regs;
}

function fleusuario($usu,$con) {
		$sql="SELECT * FROM tipousuario where id=$usu";
		$regs=mysql_query($sql,$con);
		return $regs;
}

function flegrupo($usu,$con) {
		$sql="SELECT distinct * FROM usuario,grupo where usuario.grupoprincipal_id=grupo.id and grupo.ativo=0 
		and usuario.id=$usu order by grupo.nome";
		$regs=mysql_query($sql,$con);
		return $regs;
}

//($id,$tipo,$nome,$sexo,$datanascimento,$email,$identificacao,$senha,$ciente,$conexao);
function ftempermissao($id,$acao,$con) {
	$q1="select * from usuario where id=$id";
	$leu1=mysql_query($q1,$con);
	$q2="select * from configuracao";
	$leu2=mysql_query($q2,$con);
	$r2=mysql_fetch_array($leu2);
	if($r2['tudodesativado']=='S'){
		return false;
	}
	$r1=mysql_fetch_array($leu1);
	if($acao=='registraaposta'){
		if($r2['registraaposta']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='registraresultado'){
		if($r2['registraresultado']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='verificaaposta'){
		if($r2['verificaaposta']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='permiteprocessar'){
		if($r2['permiteprocessar']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='registrauniverso15'){
		if($r2['registrauniverso15']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='registrauniverso14'){
		if($r2['registrauniverso14']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='atualizaresumo'){
		if($r2['atualizaresumo']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='geraestatistica'){
		if($r2['geraestatistica']=='S'){
		}else{
			return false;
		}
	}
	if($acao=='geradistribuicao'){
		if($r2['geradistribuicao']=='S'){
		}else{
			return false;
		}
	}
	
	if($acao=='geraprognostico'){
		if($r1['tipousuario_id']==0){
		//die('tipo de usuario 0:'.$q1);
		}else{
			return false;
		}
	}
	
	if($r1['tipousuario_id']==2){
		return false;
	}

	if($acao=='geraestatistica'){
//	die("kkkk");
		if(!$r1['tipousuario_id']==0){
			return false;
		}	
	}

	return true;
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

function validadatadeevento($dt){
	if($dt < date('Y-m-d')){
		return false;
	}	
	return true;
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
?>