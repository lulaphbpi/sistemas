<?php

function fincluimensagem($id,$identificacao_destino,$identificacao_origem,$msg_assunto_id,$mensagem,$msg_status_id,$data_envio,$data_leitura,$idbase, $usu,$con) {
	date_default_timezone_set('America/Fortaleza');
	$data_envio=date("Y-m-d H:i:s");
	$data_leitura=date("Y-m-d H:i:s");
	$dataalteracao=date("Y-m-d H:i:s");
	$id=fproximoid("msg",$con);
	if($idbase==0){$idbase=$id;}
	
	$query = "insert into msg values ('$id','$identificacao_destino','$identificacao_origem','$msg_assunto_id','$mensagem','$msg_status_id','$data_envio','$data_leitura','$idbase')";
//$t=ftrace('fincluimensagem',$query);
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'msg','$q','$dataalteracao')";
	$msg="Ok";
	try {
		$sql=$q1;
		$insert = $con->query($sql);
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

function imensagensnaolidas($user, $con){
try {
	$t=0;
	$sql="select count(*) as tot from msg where identificacao_destino='$user' 
		and msg_status_id=1";
	$rs=$con->query($sql); //echo('<br>'.$sql);
	if($rs) {
		if($rs->rowCount()>0){
			$rec=$rs->fetch();
			$t=$rec['tot'];
			//echo('<br>Nro msg não lidas:'.$t);
		}	
	}
	return $t;
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (imensagensnaolidas) ' . $e->getMessage(). ' '. $sql;
	return false;
}
}

function fleumensagem($id,$con){
try {
	date_default_timezone_set('America/Fortaleza');
	$dt=date("Y-m-d H:i");
	$sql = "update msg set msg_status_id=2, data_leitura='$dt'
		where msg.id=$id";
	//$trace=ftrace("leumensagem:$id",$sql);		
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
	//$trace=ftrace("lemensagem:$id",$sql);		
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

function leservicoid_fi($id,$con){
	$rec=false;
	$sql="select s.*
		FROM servico as s
		where s.id = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (leservico_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	//if($rec) die($sql); else die('nao leu');
	return $rec;
}

function fpesquisaservico_fi($tex,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT s.*
		from servico as s
		order by s.id";
else	
$sql="SELECT s.*
		from servico as s
		where (s.descricao like '%$tex%'))
		order by descricao";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisaservico_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fletipodeagenda_fi($con){
try {
	$sql = "select ta.*
			from tipodeagenda as ta
			order by id";
			
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fletipodeagenda_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function flehorainicial_fi($con){
try {
	$sql = "select h.*
			from horainicial as h
			order by id";
			
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flehorainicial_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleestagiario_fi($con){
try {
	$sql = "select e.*, pp.denominacaocomum as nomesocial
			from estagiario as e
			inner join pessoal.pessoa as pp on pp.id=e.pessoa_id 
			order by nomesocial";
			
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleestagiario_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leestagiario_fi($id,$con){
try {
	$sql = "select e.*, pp.denominacaocomum as nomesocial
			from estagiario as e
			inner join pessoal.pessoa as pp on pp.id=e.pessoa_id 
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
    $_SESSION['msg']='ERRO: (leestagiario_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lecoordenador_fi($id,$con){
try {
	$sql = "select e.*
			from coordenador as e
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
    $_SESSION['msg']='ERRO: (lecoordenador_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lecoordenadorporpessoaid_fi($pid,$con){
	$sql="SELECT e.*
			FROM coordenador AS e
			WHERE e.pessoa_id=$pid";
try {
	$rs=$con->query($sql);
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
    $_SESSION['msg']='ERROR: (lecoordenadorporpessoaid_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function lecoordenadordeservico_fi($id,$con){
try {
	$sql = "select e.*
			from coordenadordeservico as e
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
    $_SESSION['msg']='ERRO: (lecoordenadordeservico_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lecoordenadordeservicoporpessoaid_fi($pid,$con){
	$sql="SELECT e.*
			FROM coordenadordeservico AS e
			WHERE e.pessoa_id=$pid";
try {
	$rs=$con->query($sql);
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
    $_SESSION['msg']='ERROR: (lecoordenadordeservicoporpessoaid_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leestagiarioporpessoaid_fi($pid,$con){
	$sql="SELECT e.*
			FROM estagiario AS e
			WHERE e.pessoa_id=$pid";
	$t=ftrace('leestagiarioporpessoaid_fi',$sql);		
try {
	$rs=$con->query($sql);
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
    $_SESSION['msg']='ERROR: (leestagiarioporpessoaid_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function fpesquisacoordenador_fi($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select e.*, p.nome, 
			p.cnpjcpf as cpf
			from coordenador as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id
			where ativo
			order by p.nome";
	else	
		$sql = "select e.*, p.nome, 
			p.cnpjcpf as cpf 
			from coordenador as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id 
			where ativo and p.nome like '%$tex%' 
			order by p.nome ";
	try {
		//$t=ftrace('fpesquisacoordenador_fi', $sql);
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisacoordenador_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisacoordenadordeservico_fi($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select e.*, p.nome, 
			p.cnpjcpf as cpf,
			s.descricao as servico
			from coordenadordeservico as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id
			inner join servico as s on s.id=e.servico_id
			where ativo
			order by p.nome";
	else	
		$sql = "select e.*, p.nome, 
			p.cnpjcpf as cpf, 
			s.descricao as servico
			from coordenadordeservico as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id 
			inner join servico as s on s.id=e.servico_id
			where ativo and p.nome like '%$tex%' 
			order by p.nome ";
	try {
		//$t=ftrace('fpesquisacoordenadordeservico_fi', $sql);
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisacoordenadordeservico_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisaestagiario_fi($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select e.*, p.nome, 
				p.cnpjcpf as cpf
			from estagiario as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id
			order by p.nome";
	else	
		$sql = "select e.*, p.nome, 
				p.cnpjcpf as cpf 
			from estagiario as e
			inner join pessoal.pessoa as p on p.id=e.pessoa_id 
			where p.nome like '%$tex%' or e.matricula='%$tex%'
			order by p.nome ";
	try {
		$t=ftrace('fpesquisaestagiario_fi', $sql);
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisaestagiario_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisafisioterapeuta_fi($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select f.*, p.nome, e.descricao as especialidade
			from fisioterapeuta as f
			inner join pessoal.pessoa as p on p.id=f.pessoa_id 
			inner join especialidade as e on f.especialidade_id=e.id
			order by p.nome ";
	else	
		$sql = "select f.*, p.nome, e.descricao as especialidade
			from fisioterapeuta as f
			inner join pessoal.pessoa as p on p.id=f.pessoa_id 
			inner join especialidade as e on f.especialidade_id=e.id
			where p.nome like '%$tex%'
			order by p.nome ";
	try {
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisafisioterapeuta_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

function fpesquisamedico_fi($tex,$con){
	$tex=trim($tex);
	if($tex=='')
		$sql = "select m.*, p.nome, e.descricao as especialidade
			from medico as m
			inner join pessoal.pessoa as p on p.id=m.pessoa_id 
			inner join especialidade as e on m.especialidade_id=e.id
			order by p.nome ";
	else	
		$sql = "select m.*, p.nome, e.descricao as especialidade
			from medico as m
			inner join pessoal.pessoa as p on p.id=m.pessoa_id 
			inner join especialidade as e on m.especialidade_id=e.id
			where p.nome like '%$tex%'
			order by p.nome ";
	try {
		$rs= $con->query($sql);
		return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisamedico_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}	
}

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

function fpesquisatipodeagenda_fi($tex,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT s.*
		from tipodeagenda as s
		order by s.id";
else	
$sql="SELECT s.*
		from tipodeagenda as s
		where (s.descricao like '%$tex%'))
		order by descricao";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisatipodeagenda_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fpesquisastatusservico_fi($tex,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT s.*
		from statusservico as s
		order by s.id";
else	
$sql="SELECT s.*
		from statusservico as s
		where (s.descricao like '%$tex%'))
		order by descricao";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisastatusservico_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fexecutatransacao($ssql, $con){
$con->beginTransaction();
try {
	$rs = $con -> query($ssql);
	if($rs) {
		$con->commit();
		return true;
	}else{
		return false;
	}
} catch(PDOException $e) {
	$con->rollBack();
    $_SESSION['msg']='ERRO: (fexecutatransacao) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function leniveldousuarioid_fi($id,$con){
	$rec=false;
	$sql="select n.*
		FROM niveldousuario as n
		where n.id = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (leniveldousuarioid_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	//if($rec) die($sql); else die('nao leu');
	return $rec;
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

function leusuariogrupo($pid,$con) {
try {
	$sql = "SELECT u.*, 
			n.descricao as niveldousuario,
			g.descricao as grupo
			FROM usuario as u 
			inner join niveldousuario as n on n.id=u.niveldousuario_id
			INNER JOIN grupo as g on u.grupo_id=g.id
			WHERE u.pessoa_id=$pid"; 
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='Falha (leusuariogrupo): Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuariogrupo) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leusuarioporidentificacao($id,$con) {
try {
	$sql="SELECT usuario.identificacao AS usuario,usuario.nivelusuario_id AS nivel, usuario.ativo AS ativo,
			pessoa.id as pessoaid, pessoa.cnpjcpf AS cpf,pessoa.denominacaocomum AS apelido, 
			pessoa.nome, pessoa.fone, pessoa.email
			FROM pessoal.usuario
			INNER JOIN pessoal.pessoa 
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

function flemaxlenopcao($idq){
$conque=conexao('questionario');
$ssql = "SELECT MAX(LENGTH(trim(descricao))) AS t
		FROM opcao AS o
		where o.id_questao=$idq";
try {
	$rs= $conque->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flemaxlenopcao) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fleopcao($idq){
$conque=conexao('questionario');
$ssql = "select o.*
		from opcao as o
		where o.id_questao=$idq
		order by o.ordem";
		//die($ssql.'<br>');
try {
	$rs= $conque->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleopcao) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fordenaquestoes($q){
$conque=conexao('questionario');
$ssql = "select q.*
		from questao as q
		where q.id_questionario=$q
		order by q.ordem, q.id";
		//die($ssql.'<br>');
try {
	$rs= $conque->query($ssql);
	if($rs) {
		$ord=0; $ordf=0;
		foreach($rs->fetchAll() as $rec){
			$ord=$ord+1;
			$id=$rec['id'];
			$id_tq=$rec['id_tipoquestao'];
			if($id_tq <> 5) {$ordf=$ordf+1;}
			$sql="update questao set ordem=$ord, ordemf=$ordf where id=$id";
			fexecutatransacao($sql, $conque);
		}
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fordenaquestoes) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function flequestao($q){
$conque=conexao('questionario');
$ssql = "select q.*
		from questao as q
		where q.id_questionario=$q
		order by q.ordem";
		//die($ssql.'<br>');
try {
	$rs= $conque->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flequestao) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fnlequestao($q){
$conque=conexao('questionario');
$ssql = "select count(*) as nquestoes
		from questao as q
		where q.id_questionario=$q
		";
try {
	$rs= $conque->query($ssql);
	if($rs) {
		$rec=$rs->fetch();
		$nq=$rec['nquestoes'];
		return $nq;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fnlequestao) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function permitealterarquestionario($q){
$conque=conexao('questionario');
$r=lequestionario($q);
if($r['status']=='F'){return false;}else{return true;}	
}	

function lequestionario($qid){
$conque=conexao('questionario');
$ssql = "select q.*
		from questionario as q
		where q.id=$qid";
try {
	$rs= $conque->query($ssql);
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
    $_SESSION['msg']='ERRO: (lequestionario) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function lequestionarioservico($qsid){
$conefi=conexao('efisio');
$ssql = "select qs.*, s.descricao as servico, q.titulo as questionario 
		from efisio.questionarioservico as qs
		inner join efisio.servico as s on qs.servico_id=s.id
		inner join questionario.questionario as q on q.id=qs.questionario_id
		where qs.id=$qsid";
$t=ftrace('lequestionarioservico',$ssql);		
try {
	$rs= $conefi->query($ssql);
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
    $_SESSION['msg']='ERRO: (lequestionarioservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fregistraquestionario($idq, $ordque, $ordop, $campo, $val){
$conefi=conexao('efisio');
$id=fproximoid('questionario',$conefi);	
$ssql="insert into questionario values (
		$id, $idq, $ordque, $ordop, '$campo', '$val')"; //die($ssql);
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fregistraquestionario) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function lequestionarioaplicado($qaid){
$conefi=conexao('efisio');
$ssql = "select qa.*
		from questionario as qa
		where qa.questionarioaplicado_id=$qaid order by qa.id"; 
//$t=ftrace('lequestionarioaplicado',$ssql);		
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lequestionarioaplicado) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function lequestionarioaplicadoheader($qsid, $agendaid){
$conefi=conexao('efisio');
$ssql = "select qa.*
		from questionarioaplicado as qa
		where qa.questionarioservico_id=$qsid 
		  and qa.agenda_id=$agendaid order by id"; //die($ssql);
$t=ftrace('lequestionarioaplicadoheader',$ssql);		
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lequestionarioaplicadoheader) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fexcluiquestionariodoservico($servicoid,$questionarioid){
$conefi=conexao('efisio');
$ssql = "delete from questionarioservico 
		where servico_id=$servicoid and questionario_id=$questionarioid";
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return true;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fexcluiquestionariodoservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function fincluiquestionariodoservico($servicoid,$questionarioid){
$conefi=conexao('efisio');
$id=fproximoid('questionarioservico',$conefi);
$ssql = "insert into questionarioservico 
		values ($id, $servicoid, $questionarioid)";
		//echo($ssql.'<br>');
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return true;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fincluiquestionariodoservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function lequestionarioselecionado($servicoid,$questionarioid){
$conefi=conexao('efisio');
$ssql = "select * from questionarioservico 
		where servico_id=$servicoid and questionario_id=$questionarioid";
		//echo($ssql.'<br>');
try {
	$rs= $conefi->query($ssql);
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
    $_SESSION['msg']='ERRO: (lequestionarioselecionado) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function flepresentes($servicoid){
$ssql=$ssql1='';	
$conefi=conexao('efisio');
$conque=conexao('questionario');
$lpresentes="&nbsp;\n";
$ssql = "select * from questionarioservico where servico_id=$servicoid order by questionario_id";
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		if($rs->rowCount()>0){
			foreach($rs->fetchAll() as $tab) { 
				$qid=$tab['questionario_id'];
				$ssql1 = "select * from questionario where id=$qid order by id";
				//$trace=ftrace('flepresentes',$sql1);
				$rs1= $conque->query($ssql1);
				if($rs1->rowCount()>0){
					$rec=$rs1->fetch();
					$qtit=$rec['titulo'];
					$lpresentes=$lpresentes.fnumero($qid,4).' - '.$qtit."\n";
				}	
			}
		}else{
			return '';
		}
	}else{
		return '';
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flepresentes) ' . $e->getMessage(). ' '. $ssql. ' '.$ssql1;
	return '';
}	
return $lpresentes;	
}

function fleausentes($sistema, $servicoid){
$ssql=$ssql1='';	
$conefi=conexao('efisio');
$conque=conexao('questionario');
$lausentes="&nbsp;\n";
$ssql = "select * from questionario where sistema='$sistema' order by id";
try {
	$rs= $conque->query($ssql);
	if($rs) {
		if($rs->rowCount()>0){
			foreach($rs->fetchAll() as $tab) { 
				$qid=$tab['id'];
				$qtit=$tab['titulo'];
				$ssql1 = "select * from questionarioservico where servico_id=$servicoid and questionario_id=$qid";
				//$trace=ftrace('fleausentes',$sql1);
				$rs1= $conefi->query($ssql1);
				if($rs1->rowCount()>0){
				}else{	
					$lausentes=$lausentes.fnumero($qid,4).' - '.$qtit."\n";
				}	
			}
		}else{
			return '';
		}
	}else{
		return '';
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleausentes) ' . $e->getMessage(). ' '. $ssql. ' '.$ssql1;
	return '';
}	
return $lausentes;	
}

function flequestionarioservico($servicoid){
$conefi=conexao('efisio');
$ssql = "select qs.*, s.descricao as servico, q.titulo as questionario 
		from efisio.questionarioservico as qs
		inner join efisio.servico as s on qs.servico_id=s.id
		inner join questionario.questionario as q on q.id=qs.questionario_id
		where qs.servico_id=$servicoid 
		order by s.descricao";
		//die($ssql.'<br>');
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flequestionarioservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function leagendaoperador2($agendaid, $tipoagendaid, $con){
try {	
	$ssql="select a.*, pu.denominacaocomum as operador, p.nome as cliente, 
			ta.descricao as tipodeagenda, ss.descricao as statusservico,
			s.descricao as servico, s.id as servicoid, ta.descricao as tipodeagenda
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusservico as ss on ss.id=sp.statusservico_id
		inner join efisio.servico as s on sp.servico_id=s.id
		where a.id=$agendaid and ta.id=$tipoagendaid
		order by a.data desc, a.horainicial";
//die($ssql);
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
    $_SESSION['msg']='ERRO PDOException: (leagendaoperador) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function leagendaoperador($usu, $agendaid, $grp, $con){
try {	
	if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pe.denominacaocomum AS operador, 
			p.id AS pacienteid, p.denominacaocomum AS paciente, 
			ta.descricao AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS servico, pe.denominacaocomum AS estagiario,
			u.id as usuarioid, s.id as servicoid
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		INNER JOIN pessoal.usuario AS u ON u.pessoa_id = es.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (u.id=$usu) AND a.id=$agendaid
		ORDER BY a.data DESC, a.horainicial"; 
	}else{	
	$ssql="select a.*, pu.denominacaocomum as operador, 
			p.id as pacienteid, p.denominacaocomum as paciente, 
			ta.descricao as tipodeagenda, sa.descricao as statusagenda,
			s.descricao as servico, pe.denominacaocomum as estagiario,
			u.id as usuario_id, s.id as servicoid
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		inner join pessoal.pessoa as pe on pe.id=es.pessoa_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusagenda as sa on sa.id=a.statusagenda_id
		inner join efisio.servico as s on sp.servico_id=s.id
		where (a.usuario_id=$usu) and a.id=$agendaid
		order by a.usuario_id, estagiario, a.data desc, a.horainicial"; 
    }
	//$t=ftrace('leagendaoperador',$ssql);
	$rs= $con->query($ssql);
	if($rs){
	   $rec=$rs->fetch();	
	   return $rec;
    }else{
		$_SESSION['msg']='ERRO: (leagendaoperador) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (leagendaoperador) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function fleagendaservico($servico, $usu, $grp, $con){
try {	
	if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pe.denominacaocomum AS operador, 
			p.id AS pacienteid, p.denominacaocomum AS paciente, 
			ta.descricao AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS nomeservico, s.sigla as servico, 
			pe.denominacaocomum AS estagiario, sp.id as spid
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		INNER JOIN pessoal.usuario AS u ON u.pessoa_id = es.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (sp.servico_id=$servico) AND a.statusagenda_id=1 and u.id=$usu
		ORDER BY a.data DESC, a.horainicial"; 
	}else{	
	$ssql="select a.*, pu.denominacaocomum as operador, 
			p.id as pacienteid, p.denominacaocomum as paciente, 
			ta.descricao as tipodeagenda, sa.descricao as statusagenda,
			s.descricao as nomeservico, s.sigla as servico, 
			pe.denominacaocomum as estagiario, sp.id as spid
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		inner join pessoal.pessoa as pe on pe.id=es.pessoa_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusagenda as sa on sa.id=a.statusagenda_id
		inner join efisio.servico as s on sp.servico_id=s.id
		where (sp.servico_id=$servico) and a.statusagenda_id=1
		order by a.usuario_id, estagiario, a.data desc, a.horainicial"; 
    }
	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (fleagendaservico) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleagendaservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function lenomeservico($sid, $con){
$ssql = "select s.id as servicoid, s.descricao as nomeservico, s.sigla
		from efisio.servico as s
		where s.id=$sid";

try {
	$rs= $con->query($ssql);
	if($rs) {
		$ns='Não Encontrado';
		$reg=$rs->fetch();
		if($reg) $ns=$reg['nomeservico'].' ('.$reg['sigla'].')';
		return $ns;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lenomeservico) ' . $e->getMessage(). ' '. $ssql;
	return false;
}
	
}	

function fleagendaoperadorX($usu, $grp, $con){
try {	
	if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pe.denominacaocomum AS operador, 
			p.id AS pacienteid, p.denominacaocomum AS paciente, 
			ta.descricao AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS servico, pe.denominacaocomum AS estagiario
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		INNER JOIN pessoal.usuario AS u ON u.pessoa_id = es.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (u.id=$usu) AND a.statusagenda_id=1
		ORDER BY a.data DESC, a.horainicial"; 
	}else{	
	$ssql="select a.*, pu.denominacaocomum as operador, 
			p.id as pacienteid, p.denominacaocomum as paciente, 
			ta.descricao as tipodeagenda, sa.descricao as statusagenda,
			s.descricao as servico, pe.denominacaocomum as estagiario
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		inner join pessoal.pessoa as pe on pe.id=es.pessoa_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusagenda as sa on sa.id=a.statusagenda_id
		inner join efisio.servico as s on sp.servico_id=s.id
		where (a.usuario_id=$usu or $usu=1) and a.statusagenda_id=1
		order by a.usuario_id, estagiario, a.data desc, a.horainicial"; 
    }
	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (fleagendaoperador) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleagendaoperador) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function fleagendapaciente($pid, $usu, $grp, $con){
try {	
	if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pe.denominacaocomum AS operador, 
			p.id AS pacienteid, p.denominacaocomum AS paciente, 
			ta.descricao AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS nomeservico, s.sigla as servico, 
			pe.denominacaocomum AS estagiario, sp.id as spid
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		INNER JOIN pessoal.usuario AS u ON u.pessoa_id = es.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (u.id=$usu and p.id=$pid) AND a.statusagenda_id<3 and sp.ativo='S'
		ORDER BY a.data DESC, a.horainicial"; 
	}else{	
	$ssql="select a.*, pu.denominacaocomum as operador, 
			p.id as pacienteid, p.denominacaocomum as paciente, 
			ta.descricao as tipodeagenda, sa.descricao as statusagenda,
			s.descricao AS nomeservico, s.sigla as servico,
			pe.denominacaocomum as estagiario, sp.id as spid
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		inner join pessoal.pessoa as pe on pe.id=es.pessoa_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusagenda as sa on sa.id=a.statusagenda_id
		inner join efisio.servico as s on sp.servico_id=s.id
		where (a.usuario_id=$usu or $usu=1) and p.id=$pid and a.statusagenda_id<3 and sp.ativo='S'
		order by a.usuario_id, estagiario, a.data desc, a.horainicial"; 
    }
	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (fleagendaoperador) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fleagendaoperador) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function flehistoricopaciente($spid, $con){
try {	
	$ssql="select t.*, p.denominacaocomum 
		from efisio.tratamento as t
		inner join pessoal.usuario as u on t.assinatura_usuario_id=u.id
		inner join pessoal.pessoa as p on u.pessoa_id=p.id
		inner join efisio.agenda as a on a.id=t.agenda_id
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		where sp.id=$spid
		order by t.data desc, t.hora"; 

	$rs= $con->query($ssql);
	if($rs)
	   return $rs;
    else{
		$_SESSION['msg']='ERRO: (flehistoricopaciente) ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (flehistoricopaciente) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function leservicopessoaid_fi($id,$con){
try {
	$sql = "select sp.*, sv.descricao as nomeservico,
			sv.sigla as servico,
			ss.descricao as statusservico,
			p.cnpjcpf as cpf, 
			p.denominacaocomum as apelido,
			p.nome, p.fone, p.email,
			f.datanascimento, f.sexo,
			ep.data, ep.diagnosticomedico, ep.motivo, 
			ep.observacoes, ep.contato, ss.descricao as statussp
			from efisio.servicopessoa as sp 
			inner join efisio.statusservico as ss on sp.statusservico_id=ss.id
			inner join efisio.servico as sv on sv.id=sp.servico_id
			inner join pessoal.pessoafisica as f on f.id=sp.pessoa_id
			inner join pessoal.pessoa as p on p.id=f.id
			inner join efisio.pessoa as ep on ep.pessoa_id=p.id
			where sp.id=$id and sp.ativo='S' 
			order by sp.id desc";
	//$f=ftrace('leservicopessoaid_fi',$sql)	;	
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
    $_SESSION['msg']='ERRO: (leservicopessoaid_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leservicopessoa_fi($pid, $sid,$con){
try {
	$sql = "select s.*, sv.descricao as servico
			from servicopessoa as s 
			inner join servico as sv on sv.id=s.servico_id
			where s.pessoa_id=$pid and s.id=$id
			order by s.id desc";
			
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
    $_SESSION['msg']='ERRO: (leservicopessoa_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lenopcoes_q1($id,$con){
	$rec=false;
	$sql="select count(*) as total 
		FROM opcao as o
		where o.id_questao = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (lenopcoes_q1) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	return $rec;
}

function flistaopcao_q1($idq, $idc, $con){
$sql = "select o.*, q.id_questionario, q.id_tipoquestao, 
		q.enunciado, q.ordem as ordemquestao, q.nalternativas,
		t.nalternativas as permiteopcoes
		from opcao as o
		inner join questao as q on o.id_questao=q.id
		inner join tipoquestao as t on q.id_tipoquestao=t.id
		where o.id_questao=$idq order by o.ordem, o.id";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flistaopcao_q1) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function flistaquestao_q1($idq, $idc, $con){
$sql = "select q.*, t.nalternativas as permiteopcoes,
		t.descricao as tipodequestao
		from questao as q
		inner join tipoquestao as t on q.id_tipoquestao=t.id
		where id_questionario=$idq and q.id>=$idc order by q.id";
try {
	$trace=ftrace('flistaquestao-q1',$sql);
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flistaquestao_q1) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

function lequestaoid_q1($id,$con){
	$rec=false;
	$sql="select q.*, qn.titulo, qn.sigla, qn.descricao as questionariodescricao,
		qn.interessado, qn.nroquestoes, t.descricao as tipoquestao, t.nalternativas as permiteopcoes
		FROM questao as q
		inner join questionario as qn on q.id_questionario=qn.id
		inner join tipoquestao as t on q.id_tipoquestao=t.id
		where q.id = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (lequestaoid_q1) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	//if($rec) die($sql); else die('nao leu');
	return $rec;
}

function lequestionarioid_q1($id,$con){
	$sistema=$_SESSION['sistema'];
	$rec=false;
	$sql="select q.*
		FROM questionario as q
		where sistema='$sistema' and q.id = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (leqiestopmaropid_q1) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	//if($rec) die($sql); else die('nao leu');
	return $rec;
}

function legrupoid_f1($id,$con){
	$rec=false;
	$sql="select g.*
		FROM grupo as g
		where g.id = $id"; 
	try {
		$exec= $con->query($sql); 
		if($exec){
			if($exec->rowCount()>0)
				$rec=$exec->fetch();
		}	
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (legrupoid_fi) ' . $e->getMessage(). ' '. $sql;
		return false;
	}
	//if($rec) die($sql); else die('nao leu');
	return $rec;
}

function fpesquisaquestionario_q1($tex,$con){
$sistema=$_SESSION['sistema'];	
$tex=trim($tex);
if($tex=='')
$sql="SELECT q.*
		from questionario as q
		where sistema='$sistema'
		order by q.id";
else	
$sql="SELECT q.*
		from questionario as q
		where sistema='$sistema'
		  and (q.descricao like '%$tex%' or
		       q.titulo like '%$tex%' or
			   q.sigla like '%$tex%' or
			   q.interessado like '%$tex%')
		order by q.interessado, q.descricao";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisaquestionario) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fpesquisaquestionarioid_q1($tex,$con){
$sistema=$_SESSION['sistema'];	
$tex=trim($tex);
if($tex=='')
$sql="SELECT q.*
		from questionario as q
		where sistema='$sistema'
		order by q.id";
else	
$sql="SELECT q.*
		from questionario as q
		where sistema='$sistema'
		  and (q.id = '$tex')
		order by q.interessado, q.descricao";
try {
	$rs= $con->query($sql);
	return $rs; 
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fpesquisaquestionarioid_q1) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leusuarionae($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo
		from consnae.usuario as u 
		inner join consnae.grupo as g on u.grupo_id=g.id
		where u.pessoa_id= $pid"; //die ($ssql);
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
}	
}	

function leassinantequestionarioaplicadoid($qaid,$con){
$ssql = "SELECT qa.*, pp.denominacaocomum as estagiarioassinante
		from efisio.questionarioaplicado as qa
		inner join efisio.estagiario as ee on qa.assinaturaestagiario_id=ee.id
		inner join efisio.agenda as ea on qa.agenda_id=ea.id
		inner join pessoal.pessoa as pp on ee.pessoa_id=pp.id
		where qa.id=$qaid
		order by qa.id";
$t=ftrace('leassinantequestionarioaplicadoid',$ssql);		
try {
	$rs= $con->query($ssql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}	
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leassinantequestionarioaplicadoid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	

}	

function leautorizadorquestionarioaplicadoid($qaid,$con){
$ssql = "SELECT qa.*, ppp.denominacaocomum as professorautorizador
		from efisio.questionarioaplicado as qa
		inner join pessoal.usuario as pu on qa.autorizadoprofessor_usuario_id=pu.id
		inner join pessoal.pessoa as ppp on pu.pessoa_id=ppp.id
		where qa.id=$qaid
		order by qa.id";
$t=ftrace('leautorizadorquestionarioaplicadoid',$ssql);		
try {
	$rs= $con->query($ssql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}	
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leautorizadorquestionarioaplicadoid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	

}	

function lequestionarioaplicadoid($qaid, $con){
$ssql = "SELECT qa.*
		from efisio.questionarioaplicado as qa
		where qa.id=$qaid
		order by qa.id";
try {
	$rs= $con->query($ssql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}	
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (lequestionarioaplicadoid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	

}
	
function flequestionarioaplicado($agid){
$conefi=conexao('efisio');
$ssql = "SELECT qa.*, pp.denominacaocomum AS operador, 
		a.data as dataagenda, qq.titulo, qq.sigla, ta.descricao2 as tipodeagenda,
		sa.descricao as statusagenda, pe.denominacaocomum as estagiario,
		a.statusagenda_id, ss.descricao AS situacao,
		s.descricao AS nomeservico, s.sigla as servico, sp.ativo as spativo
	FROM efisio.questionarioaplicado AS qa
	INNER JOIN efisio.agenda AS a ON a.id=qa.agenda_id
	inner join efisio.statusagenda as sa on a.statusagenda_id=sa.id
	inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
	INNER JOIN efisio.servicopessoa AS sp ON sp.id=a.servicopessoa_id
	INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
	INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
	INNER JOIN efisio.questionarioservico AS qs ON qs.id=qa.questionarioservico_id AND sp.servico_id=qs.servico_id
	INNER JOIN questionario.questionario AS qq ON qq.id=qs.questionario_id
	INNER JOIN efisio.statusservico AS ss ON ss.id=sp.statusservico_id
	INNER JOIN pessoal.usuario AS pu ON pu.id=a.usuario_id
	INNER JOIN pessoal.pessoa AS pp ON pp.id=pu.pessoa_id
	INNER JOIN efisio.servico AS s ON s.id=sp.servico_id
WHERE qa.agenda_id=$agid";
try {
	$rs= $conefi->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (flequestionarioaplicado) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}

function flistapaciente_fi($txt, $usu, $con){
$ssql = "SELECT ep.id, pc.denominacaocomum AS professor, 
	pp.id AS pacienteid, pp.nome as nomepaciente, 
	pp.denominacaocomum AS paciente, pf.datanascimento,
	ep.contato, ep.diagnosticomedico, 
	s.sigla AS servico, sp.id as spid
	FROM efisio.pessoa AS ep
	INNER JOIN efisio.servicopessoa AS sp ON sp.pessoa_id=ep.pessoa_id
	INNER JOIN pessoal.pessoa AS pp ON pp.id=ep.pessoa_id
	INNER JOIN pessoal.pessoafisica AS pf ON pf.id=ep.pessoa_id
	INNER JOIN efisio.servico AS s ON s.id=sp.servico_id
	INNER JOIN efisio.coordenadordeservico AS ec ON ec.servico_id = s.id
	INNER JOIN pessoal.pessoa AS pc ON pc.id=ec.pessoa_id
	INNER JOIN pessoal.usuario AS pu ON pu.pessoa_id = ec.pessoa_id
	WHERE ((pu.id=$usu and pp.nome like '%$txt%' or $usu=1) and sp.ativo='S')
	ORDER BY professor, paciente, pacienteid";
try {	
	$rs= $con->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (flistapaciente_fi) ' . $e->getMessage(). ' '. $ssql;
	return false;
}
}	

function fpesquisapaciente_fi($tx, $tipoagendaid, $id, $grp, $con){
try {	
if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pu.denominacaocomum AS operador, 
			p.id AS pacienteid, p.denominacaocomum AS cliente, sp.id as sid, 
			sp.statusservico_id, ss.descricao as statusservico,
			ta.descricao AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS servico, pe.denominacaocomum AS estagiario,
			ta.descricao as tipodeagenda
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		inner join pessoal.usuario as ue on ue.pessoa_id = pe.id  
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		inner join efisio.statusservico as ss on ss.id=sp.statusservico_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (ue.id=$id) AND a.statusagenda_id=1
		ORDER BY a.data DESC, a.horainicial"; 

}else{	
	$ssql="select ep.cartaosus, ep.nomemae, ep.data as datacadastro,
			ep.diagnosticomedico, ep.motivo, ep.contato,
			a.*, pu.denominacaocomum as operador, 
			p.id as pacienteid, p.denominacaocomum as cliente, 
			ta.descricao as tipodeagenda, ss.descricao as statusservico,
			sp.id as sid, sp.statusservico_id,  pe.denominacaocomum AS estagiario,
			s.descricao as servico, ta.descricao as tipodeagenda
		from efisio.pessoa as ep	
		inner join efisio.servicopessoa as sp on sp.pessoa_id=ep.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.servico as s on s.id=sp.servico_id
		left join efisio.agenda as a on a.servicopessoa_id=sp.id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		inner join efisio.statusservico as ss on ss.id=sp.statusservico_id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		where (a.usuario_id=$id or $id=1) AND p.nome LIKE '%$tx%'
		order by a.data desc, a.horainicial";
}		
//$f=ftrace('fpesquisaagendaoperador_fi',$ssql);
	$rs= $con->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fpesquisaagendaoperador_fi) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function fpesquisaagendaoperador_fi($tx, $tipoagendaid, $id, $grp, $con){
try {	
if($grp == 'esa'){
	$ssql="SELECT u.id AS usuario, a.*, pu.denominacaocomum AS operador, 
			p.id AS pacienteid, p.nome AS cliente, sp.id as sid, 
			sp.statusservico_id, ss.descricao as statusservico,
			ta.descricao2 AS tipodeagenda, sa.descricao AS statusagenda,
			s.descricao AS servico, s.sigla as siglaservico, 
			pe.denominacaocomum AS estagiario, p.denominacaocomum as paciente,
			p.id as pacienteid
		FROM efisio.agenda AS a
		INNER JOIN efisio.servicopessoa AS sp ON a.servicopessoa_id=sp.id
		INNER JOIN efisio.estagiario AS es ON es.id=a.estagiario_id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		INNER JOIN pessoal.pessoa AS p ON p.id=sp.pessoa_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		inner join pessoal.usuario as ue on ue.pessoa_id = pe.id  
		INNER JOIN efisio.tipodeagenda AS ta ON a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		inner join efisio.statusservico as ss on ss.id=sp.statusservico_id
		INNER JOIN efisio.servico AS s ON sp.servico_id=s.id
		WHERE (ue.id=$id) AND  a.tipodeagenda_id=$tipoagendaid and a.statusagenda_id<3 and sp.ativo='S' and ss.id<4
		ORDER BY a.data DESC, a.horainicial"; 

}else{	
	$ssql="select a.*, pu.denominacaocomum as operador, p.nome as cliente, 
			ta.descricao2 as tipodeagenda, ss.descricao as statusservico,
			sa.descricao AS statusagenda,
			sp.id as sid, sp.statusservico_id,  pe.denominacaocomum AS estagiario,
			s.descricao as servico, s.sigla as siglaservico, 
			p.denominacaocomum as paciente, p.id as pacienteid
		from efisio.agenda as a
		inner join efisio.servicopessoa as sp on a.servicopessoa_id=sp.id
		inner join pessoal.usuario as u on u.id = a.usuario_id
		inner join pessoal.pessoa as pu on pu.id=u.pessoa_id
		inner join pessoal.pessoa as p on p.id=sp.pessoa_id
		inner join efisio.tipodeagenda as ta on a.tipodeagenda_id=ta.id
		INNER JOIN efisio.statusagenda AS sa ON sa.id=a.statusagenda_id
		inner join efisio.statusservico as ss on ss.id=sp.statusservico_id
		inner join efisio.servico as s on sp.servico_id=s.id
		inner join efisio.estagiario as es on es.id=a.estagiario_id
		INNER JOIN pessoal.pessoa AS pe ON pe.id=es.pessoa_id
		where (a.usuario_id=$id or $id=1) AND p.nome LIKE '%$tx%'
		  and a.tipodeagenda_id=$tipoagendaid and a.statusagenda_id<3 and sp.ativo='S' 
		  and ss.id<4
		order by a.data desc, a.horainicial";
}		
//$f=ftrace('fpesquisaagendaoperador_fi',$ssql);
	$rs= $con->query($ssql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (fpesquisaagendaoperador_fi) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function fpesquisaservicopessoacadastrada_fi($tex, $conefi){
	
	$sql="SELECT sp.*, es.descricao AS servico,
	pp.nome, pp.fone, pf.datanascimento, pf.sexo,
	ss.descricao as status, pp.denominacaocomum as nomesocial
	FROM efisio.servicopessoa AS sp 
	inner join efisio.statusservico as ss on sp.statusservico_id=ss.id
	INNER JOIN efisio.pessoa AS ep ON sp.pessoa_id=ep.pessoa_id
	INNER JOIN pessoal.pessoa AS pp ON sp.pessoa_id=pp.id
	INNER JOIN pessoal.pessoafisica AS pf ON pp.id=pf.id
	INNER JOIN efisio.servico AS es ON sp.servico_id=es.id
	WHERE sp.ativo='S' AND sp.statusservico_id<4 
		AND pp.nome LIKE '%$tex%'
	ORDER BY pp.nome, sp.data desc, servico";
	try {
		$rs= $conefi->query($sql); 
		if($rs) 
			return $rs; 
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisaservicopessoacadastrada_fi) ' . $e->getMessage(). ' '. $sql;
	}	
}

function lepessoaefiporpessoaid($pid,$con){
try {
	$ssql="select p.*, n.descricao as natureza
		from efisio.pessoa as p
		inner join efisio.naturezadapessoa as n on p.naturezadapessoa_id=n.id	
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
    $_SESSION['msg']='ERRO PDOException: (lepessoaefiporpessoaid) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function leusuarioporpessoaid($pid,$con) {
try {
	$sql = "SELECT u.*, 
			n.descricao as niveldousuario,
			p.id as pessoaid, p.cnpjcpf AS cpf, 
			p.denominacaocomum AS apelido, 
			p.nome, p.fone, p.email
			FROM pessoal.usuario as u 
			inner join pessoal.niveldeusuario as n on n.id=u.niveldeusuario_id
			INNER JOIN pessoal.pessoa as p on u.pessoa_id=p.id
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
	
function leusuarioporidentificacao2($ident,$con) {
try {
	$sql = "SELECT u.*, 
			n.descricao as niveldousuario,
			p.id as pessoaid, p.cnpjcpf AS cpf, 
			p.denominacaocomum AS apelido, 
			p.nome, p.fone, p.email
			FROM pessoal.usuario as u 
			inner join pessoal.niveldeusuario as n on n.id=u.niveldeusuario_id
			INNER JOIN pessoal.pessoa as p on u.pessoa_id=p.id
			WHERE u.identificacao='$ident'"; 
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
//			$_SESSION['msg']='Falha (leusuarioporidentificacao2): Não encontrou usuario -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='Falha (leusuarioporidentificacao2): Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuarioporidentificacao2) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function leusuarioefiporpessoaid($pid,$con) {
try {
	$sql = "SELECT eu.*, 
			en.descricao as niveldousuario,
			pp.id as pessoaid, pp.cnpjcpf AS cpf, 
			pp.denominacaocomum AS apelido, 
			pp.nome, pp.fone, pp.email,
			pu.identificacao, pu.niveldeusuario_id
			FROM efisio.usuario as eu 
			inner join pessoal.pessoa as pp on pp.id=eu.pessoa_id
			inner join pessoal.usuario as pu on pu.pessoa_id=pp.id
			inner join pessoal.niveldeusuario as pn on pn.id=pu.niveldeusuario_id
			inner join efisio.niveldousuario as en on en.id=eu.niveldousuario_id
			WHERE eu.pessoa_id=$pid"; 
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
//			$_SESSION['msg']='Falha (leusuarioefiporpessoaid): Não encontrou usuario -> ' . $sql;
			return false;
		}
	}else{
		$_SESSION['msg']='Falha (leusuarioefiporpessoaid): Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuarioefiporpessoaid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	
	
function fleenderecopessoa($pid,$con){
try {
	$ssql="select endereco.* from endereco
			where pessoa_id=$pid order by id desc"; //die($ssql);
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

function fidentificaCPF($cpf, $pid, $con, $conefi){
if($pid>0)	
	$rpes=lepessoafisicaporid($pid,$con);
else
	$rpes=lepessoafisicaporcpf($cpf, $con);
if($rpes){
	$pid=$rpes['id'];
	$ret='';
	//$ret=$ret."ID:".$pid."<br>";
    $ret=$ret."<h4> Identificando CPF ".formatarCNPJCPF($cpf,'cpf')." </h4>";
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
	if($render){
	//$ret=$ret."<br><br>".$render['id'];
	$ret=$ret."<br><br><strong>Endereço:</strong>";
	$ret=$ret."<br>Logradouro: ".$render['logradouro']." Número: ".$render['numero'];
	$ret=$ret."<br>Complemento: ".$render['complemento'];
	$ret=$ret."<br>Bairro: ".$render['bairro']." Cidade: ".$render['municipio']." CEP: ".$render['cep'];
	}
	$usu=leusuarioporpessoaid($pid,$con);
	$txusu='';
	if($usu){
		if($usu['ativo']=='S'){
			$txusu="<strong>Usuário Ativo</strong>";
		}else{
			$txusu="<strong>Usuário Desativado</strong>";
		}
		$txusu=$txusu.
		"  Nível: ".$usu['niveldousuario'];
	}
	$usuefi=leusuarioefi($pid,$conefi);
	if($usuefi){
		$txusu=$txusu."<br><strong>Grupo</strong> ".$usuefi['descricaogrupo'];
	}	
	if($txusu=='')	{
		$ret=$ret."<br><br><strong>Não é usuário do sistema.</strong>";
	}else{
		$ret=$ret.'<br><br>'.$txusu;
	}
	
	$txpefi='';
	$rpesefi=lepessoaefiporpessoaid($pid,$conefi);
	if($rpesefi){
		$csus=(!$rpesefi['cartaosus']=='') ? $rpesefi['cartaosus'] : 'Não apresentou';
		$txpefi="<strong>Paciente</strong><br>Natureza: ".$rpesefi['natureza'].
		"<br><strong>Cartão SUS:</strong> ".$csus.
		"<br><strong>Nome da Mãe:</strong> ".$rpesefi['nomemae'];
	}else{
		$txpefi='<strong>Não é Paciente</strong>';
	}
	if(!$txpefi=='')
		$ret=$ret.'<br><br>'.$txpefi;

	$ret=$ret."<br><br><strong>Fone: </strong>".$rpes['fone'];
	$ret=$ret."<br><strong>Email:</strong> ".$rpes['email'];
	return $ret;
}else{
	return "Registro Não Encontrado no Sistema!";
}	
}
	
function leservicopessoa2_fi($tab, $ser, $ord, $con){
try {
	$sql = "select s.*, sv.descricao as servico, ss.descricao as status,
			pp.denominacaocomum as nomesocial
			from $tab as s 
			inner join servico as sv on sv.id=s.servico_id
			inner join statusservico as ss on ss.id=s.statusservico_id
			inner join pessoal.pessoa as pp on s.pessoa_id=pp.id
			where s.servico_id=$ser
			order by $ord";
	//$trace=ftrace('leservicopessoa_fi',$sql);		
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leservicopessoa2_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function fleservicopessoa_fi($id,$con){
try {
	$sql = "select s.*, sv.descricao as servico, ss.descricao as status
			from servicopessoa as s 
			inner join servico as sv on sv.id=s.servico_id
			inner join statusservico as ss on ss.id=s.statusservico_id
			where s.pessoa_id=$id
			order by s.id desc";
	//$trace=ftrace('fleservicopessoa_fi',$sql);		
	$rs= $con->query($sql);
	if($rs) {
		return $rs;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (fleservicopessoa_fi) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function lepessoaefi($id,$con){
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
    $_SESSION['msg']='ERRO: (lepessoaefi) ' . $e->getMessage(). ' '. $sql;
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

function lepessoafisicaporid($id,$con){
try {
	$ssql="select f.*, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido,
		p.nome, p.fone, p.email
		from pessoal.pessoafisica as f
		inner join pessoal.pessoa as p on p.id=f.id
		where p.id= $id";
	$rs= $con->query($ssql); //die($ssql);
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
}	
}	

function lepessoafisicaporcpf($cpf,$con){
try {
	$ssql="select f.*, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido,
		p.nome, p.fone, p.email
		from pessoal.pessoafisica as f
		inner join pessoal.pessoa as p on p.id=f.id
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

function fpesquisapessoa_fi($tex, $conpes, $conefi){
	//$conpes=conexao("pessoal");
	//$conefi=conexao("efisio");
	// pessoal
	if($tex=='pacientes'){
	$sqla="select p.id, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido, p.nome, p.fone, p.email, pf.sexo, pf.datanascimento
		from pessoal.pessoa as p inner join pessoal.pessoafisica as pf on p.id=pf.id
		inner join efisio.pessoa as ep on ep.pessoa_id=p.id 
		where ep.naturezadapessoa_id=2 and p.situacao_id<3 
		and p.id<>1
		order by nome";
	}else
	if($tex=='usuarios'){
	$sqla="select p.id, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido, p.nome, p.fone, p.email, pf.sexo, pf.datanascimento
		from pessoal.pessoa as p inner join pessoal.pessoafisica as pf on p.id=pf.id
		inner join efisio.usuario as eu on eu.pessoa_id=p.id 
		where p.situacao_id<3 
		and p.id<>1
		order by nome";
	}else	
		
	$sqla="select pessoa.id, cnpjcpf as cpf, 
		denominacaocomum as apelido, nome, fone, email, sexo, datanascimento
		from pessoal.pessoa inner join pessoal.pessoafisica on pessoa.id=pessoafisica.id
		where pessoa.situacao_id<3 and nome like '%$tex%'
		and pessoa.id<>1
		order by nome";
	// efisio
	//$t=ftrace('fpesquisapessoa_fi sqla: ',$sqla);
	$sqla1="select n.descricao as naturezadapessoa, p.nomemae, c.id, c.descricao as cor 
		from efisio.pessoa as p
		inner join efisio.naturezadapessoa as n on p.naturezadapessoa_id=n.id
		inner join efisio.cor as c on p.cor_id=c.id
		where p.pessoa_id=";
	$sqla2="select u.ativo, n.descricao as niveldousuario, g.grupo, g.descricao as nomegrupo
		from efisio.usuario as u
		inner join efisio.niveldousuario as n on u.niveldousuario_id=n.id 
		inner join efisio.grupo as g on u.grupo_id=g.id
		where u.pessoa_id=";
	// pessoal	
	$sqla3="select u.identificacao, u.ativo
		from pessoal.usuario as u
		where u.pessoa_id=";
	$cont=0;	
	// efisio
	//$sqla4="select * from efisio.consulta as c where c.dataconsulta>=NOW() and c.consultapessoa_id=";
	$sqltruncate="truncate table pes001";
	try {
		$t=$conefi->query($sqltruncate);
		$sql=$sqla;
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
					$cartaosus="";
					$status='Cadastrado';
					$cor='';
					$sqlax=$sqla1.$pessoaid;

					//$t=ftrace('fpesquisapessoa_fi sqla1: ',$sqlax);

					$rsqla1=$conefi->query($sqlax);
					if($rsqla1) {
						if($rsqla1->rowCount()>0) {
							$recsqla1=$rsqla1->fetch();
							$cor=$recsqla1['cor'];
							//$natureza=$recsqla1['naturezadapessoa'].'/'.$cor;
							$natureza=$recsqla1['naturezadapessoa'];
						}
					}		
					$sqlax=$sqla2.$pessoaid;

					//$t=ftrace('fpesquisapessoa_fi sqla2: ',$sqlax);

					$rsqla2=$conefi->query($sqlax);
					if($rsqla2) {
						if($rsqla2->rowCount()>0) {
							$recsqla2=$rsqla2->fetch();
							$nivel=$recsqla2['niveldousuario'].'/'.$recsqla2['ativo'];
						}
					}		
					$sqlax=$sqla3.$pessoaid;

					//$t=ftrace('fpesquisapessoa_fi sqla3: ',$sqlax);

					$rsqla3=$conpes->query($sqlax);
					if($rsqla3) {
						if($rsqla3->rowCount()>0) {
							$recsqla3=$rsqla3->fetch();
							$ident=$recsqla3['identificacao'];
							$ativo=$recsqla3['ativo'];
						}
					}
/*					$sqlax=$sqla4.$pessoaid." order by dataconsulta desc";
					$rsqla4=$conefi->query($sqlax);
					if($rsqla4) {
						if($rsqla4->rowCount()>0) {
							$recsqla4=$rsqla4->fetch();
							$confirmado=$recsqla4['confirmado'];
							$realizado=$recsqla4['realizado'];
							$status='Cons Marcada/'.formataDataToBr($recsqla4['dataconsulta']);
							if($confirmado=='S')
								$status='Cons Confirmada/'.formataDataToBr($recsqla4['dataconsulta']);
							if($realizado=='S')
								$status='Cons Realizada/'.formataDataToBr($recsqla4['dataconsulta']);
							
						}
					}
*/					
					$sqli="insert into efisio.pes001 values (
						$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$cartaosus','$email','$nivel','$ident','$status','$ativo')";
					$sql=$sqli;
					$i=$conefi->query($sqli);
				}	
			}	
		}
		$sqlt="select * from efisio.pes001 order by ord";
		$rsqlt=$conefi->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoa_fi) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}

function fpesquisapessoa($tex, $conpes, $banco){
	if($tex=='usuarios'){
		$sqla="select p.id, p.cnpjcpf as cpf, 
		p.denominacaocomum as apelido, p.nome, p.fone, p.email, pf.sexo, pf.datanascimento
		from pessoal.pessoa as p inner join pessoal.pessoafisica as pf on p.id=pf.id
		inner join ".$banco.".usuario as eu on eu.pessoa_id=p.id 
		where p.situacao_id<3 
		and p.id<>1
		order by nome";
	}else{
	$sqla="select pessoa.id, cnpjcpf as cpf, 
		denominacaocomum as apelido, nome, fone, email, sexo, datanascimento
		from pessoal.pessoa inner join pessoal.pessoafisica on pessoa.id=pessoafisica.id
		where pessoa.situacao_id<3 and nome like '%$tex%'
		and pessoa.id<>1
		order by nome";
	}	
	$sqla2="select u.ativo, n.descricao as niveldousuario, g.grupo, g.descricao as nomegrupo
		from ".$banco.".usuario as u
		inner join ".$banco.".niveldousuario as n on u.niveldousuario_id=n.id 
		inner join ".$banco.".grupo as g on u.grupo_id=g.id
		where u.pessoa_id=";
	// pessoal	
	$sqla3="select u.identificacao, u.ativo
		from pessoal.usuario as u
		where u.pessoa_id=";
	$cont=0;	
	$sqltruncate="truncate table ".$banco.".pes001";
	try {
		$t=$conpes->query($sqltruncate);
		$sql=$sqla;
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
					$cartaosus="";
					$status='Cadastrado';
					$cor='';
					$sqlax=$sqla.$pessoaid;

					$rsqla2=$conpes->query($sqlax);
					if($rsqla2) {
						if($rsqla2->rowCount()>0) {
							$recsqla2=$rsqla2->fetch();
							$nivel=$recsqla2['niveldousuario'].'/'.$recsqla2['ativo'];
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
					$sqli="insert into ".$banco.".pes001 values (
						$ord,$pessoaid,'$natureza','$cpf','$nome','$sexo','$dtn','$fone','$cartaosus','$email','$nivel','$ident','$status','$ativo')";
					$sql=$sqli;
					$i=$conpes->query($sqli);
				}	
			}	
		}
		$sqlt="select * from ".$banco.".pes001 order by ord";
		$rsqlt=$conpes->query($sqlt);
		if($rsqlt) {
			return $rsqlt;
		}
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoa) ' . $e->getMessage(). ' '. $sql;
		//return false;
	}	
}

function leusuariosis($pid,$sis,$con){
	//$t=ftrace('leusuariosis',$psis);
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo
		from ".$sis.".usuario as u 
		inner join ".$sis.".grupo as g on u.grupo_id=g.id
		where u.pessoa_id=".$pid;
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (leusuario'.$sis.') Ao ler registro de usuario -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuario'.$sis.') ' . $e->getMessage(). ' '. $ssql;
	return false;
}	
}	

function leusuarioefi($pid,$con){
try {
	$ssql="select u.*, g.grupo, g.descricao as descricaogrupo
		from efisio.usuario as u 
		inner join efisio.grupo as g on u.grupo_id=g.id
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
		$_SESSION['msg']='ERRO: (leusuarioefi) Ao ler registro de usuario -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO pdoexception: (leusuarioefi) ' . $e->getMessage(). ' '. $ssql;
	return false;
}	}	

function fpesquisacodigo_cd($txt,$con){
	$txt=trim($txt);
    if($txt=='') {
        $sqle = "update codigos set selecionado='S'";
        $atzc = $con->query($sqle);     
    }else{
        $sqle = "update codigos set selecionado='N'";
        $atzc = $con->query($sqle);    
    }
    $sql="select codigos.*
        	FROM codigos
		    ORDER BY id desc";
	try {
		$regs= $con->query($sql);
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisacodigo_cd) - ' .
        $e->getMessage(). ':'. $sql;
        return (false); 
    }    
	if($txt!=''){
        foreach($regs->fetchAll() as $reg){
            $id=$reg['id'];
            $texto=DKripto_v2(utf8_decode($reg['texto']), $con);
    //        $codigo=DKripto_v2(utf8_decode($reg['codigo']), $con);
            $p1 = strpos(strtoupper($texto), strtoupper($txt));
    //        $p2 = strpos(strtolower($codigo), strtolower($txt));
    //        if ($p1 > -1 or $p2 > -1){
            if ($p1 > -1){
                $sqld="update codigos set selecionado='S' 
                        where id=$id";
                try {
		            $regs= $con->query($sqld);
	            } catch(PDOException $e) {
		            $_SESSION['msg']='ERRO: (fpesquisacodigo_cd) - ' .
                    $e->getMessage(). ':'. $sqld;
                    return (false); 
                }            
            }            
        }
    }
    $sql="select codigos.*
        	FROM codigos where selecionado='S'
		    ORDER BY id desc";
	try {
		$regs= $con->query($sql);
        return($regs);
	} catch(PDOException $e) {
		$_SESSION['msg']='ERRO: (fpesquisacodigo_cd) - ' .
         $e->getMessage(). ':'. $sql;
        return (false); 
    }    
}

function fconcluiravaliacaofisica($agid, $spid, $con){
$sql1="update agenda set statusagenda_id=2 where statusagenda_id<3 and id=$agid";
$sql2="update servicopessoa set statusservico_id=3 where statusservico_id<3 and id=$spid";
$con->beginTransaction();
try {
	$rs1 = $con -> query($sql1);
	$rs2 = $con -> query($sql2);
	if($rs1 and $rs2) {
		$con->commit();
		return true;
	}else{
		return false;
	}
} catch(PDOException $e) {
	$con->rollBack();
    $_SESSION['msg']='ERRO: (fconcluiravaliacaofisica) ' . $e->getMessage(). ' '. $sql1. ' '. $sql2;
	return false;
}	

}

function leagenda_fi($agid, $con){
$sql1 = "select a.*, s.descricao as servico,
		pp.denominacaocomum as estagiario
		from efisio.agenda as a
		inner join efisio.servicopessoa as ss on a.servicopessoa_id=ss.id
		inner join efisio.servico as s on ss.servico_id=s.id
		inner join efisio.estagiario as ee on a.estagiario_id=ee.id
		inner join pessoal.pessoa as pp on ee.pessoa_id=pp.id
		where a.id=$agid";
//$t=ftrace('a', $sql1);
try {
	$rs1 = $con -> query($sql1);
	if($rs1) {
		$rec=$rs1->fetch();
		return $rec;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (leagenda_fi) ' . $e->getMessage(). ' '. $sql1;
	return false;
}	

}

function letratamento_fi($tid, $con){
$sql1 = "select t.*, p.nome
		from efisio.tratamento as t
		inner join pessoal.usuario as u on t.assinatura_usuario_id=u.id
		inner join pessoal.pessoa as p on u.pessoa_id=p.id
		where t.id=$tid";
//$t=ftrace('a', $sql1);
try {
	$rs1 = $con -> query($sql1);
	if($rs1) {
		$rec=$rs1->fetch();
		return $rec;
	}else{
		return false;
	}
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO: (letratamento_fi) ' . $e->getMessage(). ' '. $sql1;
	return false;
}	

}

//fim sa02
?>