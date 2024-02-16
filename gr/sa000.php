<?php

/*
function conecta($server,$database,$usuario,$senha){
 $msg=$usuario;
 //echo($msg);
 $con=mysql_connect ($server,$usuario,$senha);
 if(!$con){echo ('Não foi possível estabelecer conexão com o servidor. '.$msg); exit;}
 mysql_select_db ($database,$con) or die ('Não foi possível conectar ao banco '.$database.' MySQL. '.$msg);
 return $con;
}
*/
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

function fproxnumero($tab,$campo,$ano,$con){
	$ssql = "SELECT SUBSTRING(".$campo.",7,4) AS ano,SUBSTRING(".$campo.",1,5) AS num FROM ".$tab.
			" where SUBSTRING(".$campo.",7,4)=".$ano.
			" ORDER BY SUBSTRING(".$campo.",7,4),SUBSTRING(".$campo.",1,5)";
			//die($ssql);
	$leu = $con->query($ssql);
	if($leu->rowCount()>0){
		$reg=$leu->fetch();
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

function fletipobloco($id,$con) {
	$sql = "select bloco.*,tipobloco.descricao from bloco ".
		   " join tipobloco on tipobloco.id=bloco.tipobloco_id ".
		   " where bloco.id=".$id;
	$leu = $con->query($sql);
	if($reg=$leu->fetch()){
		return ($rec['descricao']);
	}else{
		return ('Tipo de Bloco Inválido');
	}
}

function fpesquisaultimoslinha($tex,$obj,$id,$con){
	$obj=strtolower($obj);
	
	$ssql="SELECT ".$obj.".*".
		" FROM ".$obj.
		" WHERE bloco_id=$id
		ORDER BY id desc
		limit 5";
	
	$rs=$con->query($ssql);
	return $rs;
	die("saiu?");
	exit();
}

function fpesquisaultimosbloco($tex,$obj,$id,$con){
	$obj=strtolower($obj);
	
	$ssql="SELECT ".$obj.".*".
		" FROM ".$obj.
		" WHERE relatorio_id=$id
		ORDER BY id desc
		limit 10";
	
	$rs=$con->query($ssql);
	return $rs;
	die("saiu?");
	exit();
}

function fpesquisaultimos($tex,$obj,$con){
	$obj=strtolower($obj);
	
	$ssql="SELECT ".$obj.".*".
		" FROM ".$obj.
		" WHERE id>0
		ORDER BY id desc
		limit 5";
	//die($ssql);
	$rs=$con->query($ssql);

	return $rs;
	die("saiu?");
	exit();
}

function fpesquisa($tex,$obj,$con){
	$obj=strtolower($obj);
	
	if($obj=='relatorio'){
	if($tex==''){
		$ssql="SELECT relatorio.*
		FROM relatorio
		WHERE id>0
		ORDER BY id
		limit 30";
	}else{
		if(is_numeric($tex)) {
			$ssql="SELECT relatorio.*
			FROM relatorio
			WHERE id=$tex
			ORDER BY id
			limit 30";
		}else{
			$ssql="SELECT relatorio.*
			FROM relatorio
			WHERE titulo like '%$tex%' or descricao like '%$tex%'
			ORDER BY titulo
			limit 30";
		}	
	}
	$rs=$con->query($ssql);
	return $rs;
	die("saiu?");
	exit();
	}
	if($obj=='bloco'){
	if($tex==''){
		$ssql="SELECT bloco.*
		FROM bloco
		WHERE id>0
		ORDER BY id
		limit 30";
	}else{
		if(is_numeric($tex)) {
			$ssql="SELECT bloco.*
			FROM bloco
			WHERE id=$tex
			ORDER BY id
			limit 30";
		}else{
			$ssql="SELECT bloco.*
			FROM bloco
			WHERE id>0
			ORDER BY id
			limit 30";
		}	
	}
	$rs=$con->query($ssql);
	return $rs;
	die("saiu?");
	exit();
	}

	if($tex==''){
		$ssql="select * from $obj order by id limit 35";
	}else{
		//die("to aqui");
		$ssql="select * from $obj where descricao like '$tex' order by id limit 35";
		//die($ssql);
	}	
	//die($ssql);
	$rs=$con->query($ssql);
	return $rs;
}

function fproximoid($tabela,$con) {
	$q="select max(id) as maxid from ".$tabela;
	
	$leu=$con->query($q);
	if($rec=$leu->fetch()) {
		if($rec['maxid']=='') {
			return 1;
		}else{	
			return $rec['maxid']+1;
		}	
	}else{
		return 1;
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

function fincluiusuario($id,$identificacao,$senha,$pessoa_fisica_id,$departamento_id,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("usuario",$con);
	$query = "insert into usuario values ('$id','$identificacao','$senha','$pessoa_fisica_id','$departamento_id','$ativo')";

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

function falterausuario($id,$identificacao,$senha,$pessoa_fisica_id,$departamento_id,$ativo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	if($senha<>""){
		$query="UPDATE usuario set senha='$senha',departamento_id='$departamento_id',ativo='$ativo' where id=$id";
	}else{
		$query="UPDATE usuario set departamento_id='$departamento_id',ativo='$ativo' where id=$id";
	}	

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'usuario','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratipobloco($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipobloco set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipobloco','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluitipobloco($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipobloco",$con);
	$query = "insert into tipobloco values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipobloco','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterabloco($id,$relatorio_id,$tipobloco_id,$estilo_id,$conteudo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE bloco set tipobloco_id='$tipobloco_id',estilo_id='$estilo_id',conteudo='$conteudo' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'bloco','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function flebloco($rid,$tipo,$con){
	$ssql="select * from bloco where relatorio_id=$id and tipobloco_id=$tipo";
	$leu=$con->query($ssql);
	if($leu->rowCount()>0){
		$reg=$leu->fetch();
	}else{
		$reg=false;
	}
	return ($reg);
}
	                      
function fincluibloco($id,$relatorio_id,$tipobloco_id,$estilo_id,$conteudo, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("bloco",$con);
	$query = "insert into bloco values ('$id',$relatorio_id,'$tipobloco_id','$estilo_id','$conteudo')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'bloco','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else {die($query);
	}
	return $inclui;
}

function falterarelatorio($id,$identificador,$titulo,$descricao,$origem,$funcao,$estilo_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE relatorio set identificador='$identificador',titulo='$titulo',descricao='$descricao',origem='$origem',funcao='$funcao',estilo_id='$estilo_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'relatorio','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
function fincluirelatorio($id,$identificador,$titulo,$descricao,$origem,$funcao,$estilo_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s"); 
	$id=fproximoid("relatorio",$con);
	$query = "insert into relatorio values ('$id','$identificador','$titulo','$descricao','$origem','$funcao','$estilo_id')";
    //die ($query);

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'relatorio','$q','$dataalteracao')";
	$insert = $con->query($q1);
	if($insert){
		$inclui = $con->query($query);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fleidtabela($id,$tab,$con){
	$tab=strtolower($tab);
 	if($tab=='visita_previa'){
		$ssql="SELECT visita_previa.*,pessoa.nome AS pessoa_nome,associacao.id AS associacao_id,
				comunidade.descricao as comunidade_nome,
				comunidade.municipio_id,municipio.descricao AS municipio_nome
				FROM visita_previa
				INNER JOIN carta_consulta ON visita_previa.carta_consulta_numero=carta_consulta.numero
				INNER JOIN pessoa_fisica ON visita_previa.pessoa_fisica_cpf=pessoa_fisica.cpf
				INNER JOIN pessoa ON pessoa_fisica.id=pessoa.id
				INNER JOIN associacao ON carta_consulta.associacao_id=associacao.id
				INNER JOIN comunidade ON associacao.comunidade_id=comunidade.id
				INNER JOIN municipio ON comunidade.municipio_id=municipio.id
				where visita_previa.id=$id";
	}else{
	
 	if($tab=='pessoa_fisica'){
		$ssql="select pessoa_fisica.*,pessoa.nome as pessoa_nome
		from pessoa_fisica,pessoa where pessoa_fisica.id=pessoa.id and pessoa_fisica.id = $id";
	}else{
 	if($tab=='pessoa_juridica'){
		$ssql="select pessoa_juridica.*,pessoa.nome as pessoa_nome
		from pessoa_juridica,pessoa where pessoa_juridica.id=pessoa.id and pessoa_juridica.id = $id";
	}else{
 	if($tab=='associacao'){
		$ssql="select associacao.*,pessoa_juridica.cnpj,pessoa.nome as pessoa_nome,
		comunidade.descricao as comunidade_descricao,municipio.id as municipio_id, 
		municipio.descricao as municipio_descricao
		from associacao,comunidade,municipio,pessoa_juridica,pessoa 
		where associacao.pessoa_juridica_id=pessoa_juridica.id 
		and associacao.comunidade_id=comunidade.id 
		and comunidade.municipio_id=municipio.id
		and pessoa_juridica.id=pessoa.id and associacao.id = $id";
	}else{
 	if($tab=='usuario'){
		$ssql="select usuario.*, pessoa_fisica.cpf,pessoa.nome as pessoa_nome,
		departamento.descricao as departamento_nome
		from usuario
		inner join pessoa_fisica on usuario.pessoa_fisica_id=pessoa_fisica.id
		inner join pessoa on pessoa.id=pessoa_fisica.id
		left join departamento on usuario.departamento_id=departamento.id
		where usuario.id=$id";
	}else{
		$ssql='select * from '.$tab.' where id='.$id;	}
	}}}
	}
	
	//die($ssql);
	//$leit=mysql_query($ssql,$con);	
	//$reg=mysql_fetch_array($leit);
	$leit=$con->query($ssql);
	$reg=$leit->fetch();
	return $reg;
}

function fledescricaotabela($id,$tabela,$con){
	$reg=fleidtabela($id,$tabela,$con);
	return $reg['descricao'];
}	

function fleusuarios($con){
	$ssql="select *, pessoa.nome as pessoa_nome from usuario
			left join pessoa on pessoa_fisica_id=pessoa.id
			order by pessoa.nome";
	$leit=$con->query($ssql);
	return $leit;
}	
	
function fletabela($tabela,$con){
	$ssql="select * from ".$tabela." order by id";
	$leit=$con->query($ssql);
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

function fletiposusuarios($con) {
		$sql="SELECT * FROM tipousuario order by id";
		$regs=$con->query($sql);
		return $regs;
}

function fleusuario($usu,$con) {
		$sql="SELECT * FROM tipousuario where id=$usu";
		$regs=$con->query($sql);
		return $regs;
}

function flegrupo($usu,$con) {
		$sql="SELECT distinct * FROM usuario,grupo where usuario.grupoprincipal_id=grupo.id and grupo.ativo=0 
		and usuario.id=$usu order by grupo.nome";
		$regs=$con->query($sql);
		return $regs;
}

//($id,$tipo,$nome,$sexo,$datanascimento,$email,$identificacao,$senha,$ciente,$conexao);
function ftempermissao($id,$acao,$con) {
	$q1="select * from usuario where id=$id";
	$leu1=$con->query($q1);
	$q2="select * from configuracao";
	$leu2=$con->query($q2);
	$r2=$leu2->fetch();
	if($r2['tudodesativado']=='S'){
		return false;
	}
	$r1=$leu1->fetch();
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
?>
