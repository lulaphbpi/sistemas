<?php
function conexao($banco) {
$a=false;
$local=$a;	
if($local){	
$con_host='localhost';
$con_usuario='root';
$con_senha='trb';  //home
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

function fproximoid($tabela,$con) {
try {
	$q="select max(id) as maxid from ".$tabela;
	$leu=$con->query($q);
	$rec=$leu->fetch();
	if($rec['maxid']=='') {
		return 1;
	}else{	
		return $rec['maxid']+1;
	}	
} catch(PDOException $e) {
    $_SESSION['erro']='ERROR: (conecta) ' . $e->getMessage(). ' '. $dsn;
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

function fleocupacao ($i,$j) {
	return "Livre";
}

function fleoperadores($con){
$sql="SELECT u.identificacao, p.id, p.nome, n.descricao AS nivel, u.ativo
	FROM rededesi_pessoal.pessoa AS p
	INNER JOIN rededesi_pessoal.usuario as u ON u.pessoa_id=p.id
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
	INNER JOIN rededesi_pessoal.pessoa AS p ON p.id=t.pacientepessoa_id
	INNER JOIN rededesi_pessoal.pessoa AS p2 ON p2.id=t.operadorpessoa_id
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


function fidentificapessoa($cpf, $pid, $con, $conacl){
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

function fleexamerequerido($id,$con){
try {
	$sql = "select er.*, e.sigla, e.descricao as exame, 
			r.guia, m.nome as medico, m.crm,
			c.id as convenio_id, c.descricao as convenio
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
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
			c.descricao as convenio
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			inner join componentedeexame as ce on ce.exame_id=e.id
			where er.requisicao_id=$rq and e.id=$id
			order by ce.id desc";
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

function leitemrequisicaoporcomponente($cid, $cod,$con){
try {
	$sql = "select ir.*
			from itemderequisicao as ir
			where ir.codigo='$cod' and ir.componentedeexame_id=$cid
			order by ir.id desc";
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
    $_SESSION['msg']='ERRO: (leitemrequisicaoporcomponente) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}

function leitemrequisicaoporcodigo($cod,$con){
try {
	$sql = "select er.*, e.sigla, 
			e.descricao as exame, 
			r.guia, m.nome as medico, m.crm,
			c.descricao as convenio,
			ce.id as componentedeexame_id,
			ir.valor, ir.laudo, ir.observacoes
			from examerequerido as er
			inner join exame as e on er.exame_id=e.id
			inner join requisicao as r on r.id=er.requisicao_id
			inner join medico as m on r.medico_id=m.id
			inner join convenio as c on er.convenio_id=c.id
			inner join componentedeexame as ce on ce.exame_id=er.exame_id
			inner join itemderequisicao as ir on ir.codigo=er.codigo
			where er.codigo='$cod'
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

function flerequisicaoporpessoa($pid, $con){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, p.fone, p.email,  f.datanascimento, 	
			f.sexo, f.rg, m.id as medico_id, m.nome as mediconome, m.crm, 
			e.id as especialidade_id, e.descricao as especialidade
			from rededesi_aclinica.requisicao as r
			inner join rededesi_pessoal.pessoa as p on r.pessoa_id=p.id
			inner join rededesi_pessoal.pessoafisica as f
			  on p.id=f.id
			inner join rededesi_aclinica.medico as m on r.medico_id=m.id
			inner join rededesi_aclinica.especialidade as e on e.id=m.especialidade_id
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

function lerequisicao($id, $con){
try {
	$sql = "select r.*, p.nome as pessoanome,
			p.cnpjcpf as cpf, p.denominacaocomum as apelido, p.fone, p.email,  f.datanascimento, 	
			f.sexo, f.rg, m.id as medico_id, m.nome as mediconome, m.crm, 
			e.id as especialidade_id, e.descricao as especialidade
			from rededesi_aclinica.requisicao as r
			inner join rededesi_pessoal.pessoa as p on r.pessoa_id=p.id
			inner join rededesi_pessoal.pessoafisica as f
			  on p.id=f.id
			inner join rededesi_aclinica.medico as m on r.medico_id=m.id
			inner join rededesi_aclinica.especialidade as e on e.id=m.especialidade_id
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

function leestadoacl($id,$con){
try {
	$sql = "select e.*
			from estado as e 
			where e.pessoa_id=$id
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
    $_SESSION['msg']='ERRO: (leestadoacl) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}
function fpesquisaexame($tex,$con){
$tex=trim($tex);
if($tex=='')
$sql="SELECT exame.* from exame order by id";
else	
$sql="SELECT exame.* from exame
		where descricao like '%$tex%' order by id";
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

/************************** FPESQUISA  INICIO */

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
		$_SESSION['msg']='ERRO: (fpesquisadescricao) ' . $e->getMessage(). ' '. $sql;
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

function fpesquisapessoa($tex,$conpes,$conacl ){
	$sqla="select id, cnpjcpf as cpf, 
		nome, fone, email
		from pessoa
		where nome like '%$tex%'
		and id<>1
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
						$sqli="insert into pes001 values (
							$ord,$pessoaid,'$natureza','$cpf','$nome','$fone','$email','$nivel','$ident','$ativo')";
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
		$_SESSION['msg']='ERRO Exception: (fpesquisapessoa) ' . $e->getMessage(). ' '. $sql;
		//return false;
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
		INNER JOIN rededesi_pessoal.pessoa AS p ON p.id=r.pessoa_id
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
		INNER JOIN rededesi_pessoal.pessoa AS p ON p.id=r.pessoa_id
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

function fpesquisarequisicao ($nom,$dati,$datf,$con){
	if($nom==''){
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		m.nome as medico
		from rededesi_aclinica.requisicao as r 
		inner join rededesi_aclinica.medico as m
		on r.medico_id = m.id
		inner join rededesi_pessoal.pessoa as p on p.id=r.pessoa_id
		where r.data between '$dati' and '$datf' order by id desc";
	}else{	
	$sql="SELECT r.*, p.nome as pessoanome, p.fone,
		m.nome as medico
		from rededesi_aclinica.requisicao as r 
		inner join rededesi_aclinica.medico as m
		on r.medico_id = m.id
		inner join rededesi_pessoal.pessoa as p on p.id=r.pessoa_id
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
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Não leu usuario -> ' . $sql;
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
	$rs= $con->query($sql);
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Não leu usuario -> ' . $sql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (leusuarioporid) ' . $e->getMessage(). ' '. $sql;
	return false;
}	
}	

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
		$_SESSION['msg']='ERRO: (lepessoaaclporpessoaid) Ao ler registro de usuario -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO PDOException: (lepessoaaclporpessoaid) ' . $e->getMessage(). ' '. $ssql;
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
	//die($ssql);	
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: Ao ler registro de pessoal -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler tabela de Requisicoes -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (flepessoafisicaporcpf) ' . $e->getMessage(). ' '. $ssql;
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
	//die($ssql);	
	$rs= $con->query($ssql); 
	if($rs) {
		if($rs->rowCount()>0) {
			$reg=$rs->fetch(); 
			return $reg;
		}else{
			$_SESSION['msg']='ERRO: Ao ler registro de pessoal -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: Ao ler tabela de Requisicoes -> ' . $ssql;
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
	$dataalteracao=date("y-m-d h:m:s");
	$idd=fproximoid("usuario",$con);
	$query = "insert into usuario values ('$idd','$identificacao','$senha','$pessoafisica_id','$tipousuario_id','$ativo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	if($senha<>""){
		$query="UPDATE usuario set senha='$senha',tipousuario_id='$tipousuario_id',ativo='$ativo' where id=$id";
	}else{
		$query="UPDATE usuario set tipousuario_id='$tipousuario_id',ativo='$ativo' where id=$id";
	}	

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$tab=strtolower($tab);	
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "delete from $tab where id=$id";
	//die($query);
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	                      
function flePessoaAclinica($con){
try {	
	$ssql = "select p.*, f.datanascimento, f.sexo, f.rg, f.expedidorrg_id,
			f.formacaoprofissional_id, nnp.descricao as naturezadapessoa
			from rededesi_aclinica.pessoa as pp
			inner join rededesi_aclinica.naturezadapessoa as nnp on pp.naturezadapessoa_id=nnp.id
			inner join rededesi_pessoal.pessoa as p on pp.pessoa_id=p.id
			inner join rededesi_pessoal.pessoafisica as f on p.id=f.id
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
				$_SESSION['msg']='ERRO: Ao ler bloco -> ' . $ssql;
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
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE msg_status set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("msg_status",$con);
	$query = "insert into msg_status values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE situacao set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("situacao",$con);
	$query = "insert into situacao values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE expedidor_rg set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("expedidor_rg",$con);
	$query = "insert into expedidor_rg values ($id,'$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("unidade_federativa",$con);
	$query = "insert into unidade_federativa values ('$id','$descricao','$sigla')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE unidade_federativa set descricao='$descricao',sigla='$sigla' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
			$_SESSION['msg']='Alerta: (fleenderecopessoa) Id não encontrado $pid -> ' . $ssql;
			return false;
		}
	}else{
		$_SESSION['msg']='ERRO: (fleenderecopessoa) Ao ler registro de Pessoal -> ' . $ssql;
		return false;
	}	
} catch(PDOException $e) {
    $_SESSION['msg']='ERRO Exception: (fleenderecopessoa) ' . $e->getMessage(). ' '. $ssql;
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
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

function fleusuarios($con){
	$ssql="select *, pessoa.nome as pessoa_nome from usuario
			left join pessoa on pessoafisica_id=pessoa.id
			order by pessoa.nome";
	$leit=mysql_query($ssql,$con);
	return $leit;
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
	  $rData="";	
	  if (!empty($data)){
                   $data = explode("-", $data);
                   $rData= $data[2].'/'.$data[1].'/'.$data[0];
      }
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

function timeStamp($date){
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $timestamp = mktime ( 0, 0, 0, $thismonth, $thisday, $thisyear );
	 return $timestamp;
}

function adicionaDias($date,$dias) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday + $dias, $thisyear );
	 return $nextdate;
}
 
function subtraiDias($date,$dias) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday - $dias, $thisyear );
	 return $nextdate;
}

function diadasemana($data,$tipo){
	//echo(" - ".$data." - ");
	$semana=array(array(1, "sun", "dom", "domingo"),array(2, "mon", "seg", "segunda"),
			      array(3, "tue", "ter", "terça"),array(4, "wed", "qua", "quarta"),
			      array(5, "thu", "qui", "quinta"),array(6, "fri", "sex", "sexta"),
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
			die($identificacao);
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

function datainicialdasemana($d) {
	$ts=strtotime($d);
	$numerododia=diadasemana($d,"d"); //echo('<br>Numerododia:'.$numerododia);
	$dt=date("Ymd",$ts); //echo('<br>'.$dt);
	$nextdate = subtraiDias($dt, $numerododia-1); //echo('<br>Proximo:'.$nextdate);    
    return $nextdate;	
}

function idade($datnasc){
$data = new DateTime($datnasc ); 
$interval = $data->diff( new DateTime( date('Y-m-d') ) ); 
return $interval->format( '%Y');
}
?>