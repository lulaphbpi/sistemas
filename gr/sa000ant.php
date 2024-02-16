<?php

function conecta($server,$database,$usuario,$senha){
 $msg=$usuario;
 //echo($msg);
 $con=mysql_connect ($server,$usuario,$senha);
 if(!$con){echo ('Não foi possível estabelecer conexão com o servidor. '.$msg); exit;}
 mysql_select_db ($database,$con) or die ('Não foi possível conectar ao banco '.$database.' MySQL. '.$msg);
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

function fproximoid($tabela,$con) {
	$q="select max(id) as maxid from ".$tabela;
	
	$leu=mysql_query($q,$con);
	if($rec=mysql_fetch_array($leu)) {
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
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
	                      
function falterarelatorio($id,$identificador,$titulo,$descricao,$origem,$funcao,$estilo_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE relatorio set identificador='$identificador',titulo='$titulo',descricao='$descricao',origem='$origem',funcao='$funcao',estilo_id='$estilo_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'relatorio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
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
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratipo_orgao($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipo_orgao set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipo_orgao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluibanco($id,$codigo,$descricao,$sigla, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("banco",$con);
	$query = "insert into banco values ('$id','$codigo','$descricao','$sigla')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'banco','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiagencia($id,$banco_id,$codigo,$endereco, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("agencia",$con);
	$query = "insert into agencia values ('$id','$banco_id','$codigo','$endereco')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'agencia','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraagencia($id,$banco_id,$codigo,$endereco, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE agencia set banco_id='$banco_id',codigo='$codigo',endereco='$endereco' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'agencia','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterabanco($id,$codigo,$descricao,$sigla, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE banco set codigo='$codigo',descricao='$descricao',sigla='$sigla' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'banco','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiatividade_despesa($id,$poa_id,$subcomponente_id,
$tipo_despesa_id,$descricao,$categoria_despesa_id,
$usdgov,$usdfida,$t1,$t2,$t3,$t4,$meta,$localizacao,
$mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,
$entidade_responsavel, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("atividade_despesa",$con);
	$query = "insert into atividade_despesa values ('$id','$poa_id','$subcomponente_id',
	'$tipo_despesa_id','$descricao',
	'$categoria_despesa_id','$usdgov','$usdfida','$t1','$t2','$t3','$t4','$meta','$localizacao',
	'$mes01','$mes02','$mes03','$mes04','$mes05','$mes06','$mes07','$mes08','$mes09','$mes10','$mes11','$mes12',
	'$entidade_responsavel')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'atividade_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraatividade_despesa($id,$poa_id,$subcomponente_id,$tipo_despesa_id,$descricao,$categoria_despesa_id,
$usdgov,$usdfida,$t1,$t2,$t3,$t4,$meta,$localizacao,
$mes01,$mes02,$mes03,$mes04,$mes05,$mes06,$mes07,$mes08,$mes09,$mes10,$mes11,$mes12,
$entidade_responsavel, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE atividade_despesa set poa_id='$poa_id',
	subcomponente_id='$subcomponente_id',tipo_despesa_id='$tipo_despesa_id',
	descricao='$descricao',categoria_despesa_id='$categoria_despesa_id',usdgov='$usdgov',usdfida='$usdfida',
	t1='$t1',t2='$t2',t3='$t3',t4='$t4',meta='$meta',localizacao='$localizacao',
	mes01='$mes01',mes02='$mes02',mes03='$mes03',mes04='$mes04',mes05='$mes05',mes06='$mes06',
	mes07='$mes07',mes08='$mes08',mes09='$mes09',mes10='$mes10',mes11='$mes11',mes12='$mes12',
	entidade_responsavel='$entidade_responsavel' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'atividade_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluipoa($id,$programa_id,$ano,$dataini,$datafim,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("poa",$con);
	$query = "insert into poa values ('$id','$programa_id','$ano','$dataini','$datafim','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'poa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterapoa($id,$programa_id,$ano,$dataini,$datafim,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE poa set programa_id='$programa_id',ano='$ano',dataini='$dataini',datafim='$datafim',descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'poa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluicategoria_despesa($id,$codigocategoriadespesa,$descricao,$codigocategoriadespesa_pai,$percentual, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("categoria_despesa",$con);
	$query = "insert into categoria_despesa values ('$id','$codigocategoriadespesa','$descricao','$codigocategoriadespesa_pai','$percentual')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'categoria_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteracategoria_despesa($id,$codigocategoriadespesa,$descricao,$codigocategoriadespesa_pai,$percentual, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE categoria_despesa set codigocategoriadespesa='$codigocategoriadespesa',descricao='$descricao',codigocategoriadespesa_pai='$codigocategoriadespesa_pai',percentual='$percentual' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'categoria_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}


function fincluitipo_despesa($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipo_despesa",$con);
	$query = "insert into tipo_despesa values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipo_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratipo_despesa($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipo_despesa set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipo_despesa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluisubcomponente($id,$componente_id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("subcomponente",$con);
	$query = "insert into subcomponente values ('$id','$componente_id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'subcomponente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterasubcomponente($id,$componente_id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE subcomponente set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'subcomponente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluicomponente($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("componente",$con);
	$query = "insert into componente values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'componente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteracomponente($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE componente set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'componente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiconvenio_parcelamento($id,$convenio_id,$nroparcela,$valor,$data_liberacao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("convenio_parcelamento",$con);
	$query = "insert into convenio_parcelamento values ('$id','$convenio_id','$nroparcela','$valor','$data_liberacao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio_parcelamento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraconvenio_parcelamento($id,$convenio_id,$nroparcela,$valor,$data_liberacao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE convenio_parcelamento set nroparcela='$nroparcela',valor='$valor',data_liberacao='$data_liberacao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio_parcelamento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiconvenio_fontes($id,$convenio_id,$fonte_id,$percentual,$valor, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("convenio_fontes",$con);
	$query = "insert into convenio_fontes values ('$id','$convenio_id','$fonte_id','$percentual','$valor')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio_fontes','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraconvenio_fontes($id,$convenio_id,$fonte_id,$percentual,$valor, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE convenio_fontes set fonte_id='$fonte_id',percentual='$percentual',valor='$valor' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio_fontes','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluifonte_de_recurso($id,$codigo,$descricao,$percentual, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("fonte_de_recurso",$con);
	$query = "insert into fonte_de_recurso values ('$id','$codigo','$descricao','$percentual')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Fonte_de_Recurso','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falterafonte_de_recurso($id,$codigo,$descricao,$percentual, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE fonte_de_recurso set codigo='$codigo',descricao='$descricao',percentual='$percentual' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Fonte_de_Recurso','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraetapa($id,$tramite_id,$sequencia,$descricao,$departamento_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE etapa set tramite_id='$tramite_id',sequencia='$sequencia',descricao='$descricao',departamento_id='$departamento_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Etapa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluietapa($id,$tramite_id,$sequencia,$descricao,$departamento_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("etapa",$con);
	$query = "insert into etapa values ('$id','$tramite_id','$sequencia','$descricao','$departamento_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Etapa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluitramite($id,$tipo,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tramite",$con);
	$query = "insert into tramite values ('$id','$tipo','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tramite','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratramite($id,$tipo,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tramite set tipo='$tipo',descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tramite','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteragerencia_regional($id,$descricao,$unidade_federativa_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE gerencia_regional set descricao='$descricao',unidade_federativa_id='$unidade_federativa_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'gerencia_regional','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluigerencia_regional($id,$descricao,$unidade_federativa_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("gerencia_regional",$con);
	$query = "insert into gerencia_regional values ('$id','$descricao','$unidade_federativa_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'gerencia_regional','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiconvenio($id,$carta_consulta_numero,$numero,$data,$valor_financiado,$nroparcelas,
$cpf_responsavel,$cnpj_empresa,$etapa_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("convenio",$con);
	$query = "insert into convenio values ('$id','$carta_consulta_numero','$numero','$data','$valor_financiado',
	'$nroparcelas','$cpf_responsavel','$cnpj_empresa','$etapa_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraconvenio($id,$carta_consulta_numero,$numero,$data,$valor_financiado,$nroparcelas,
$cpf_responsavel,$cnpj_empresa,$etapa_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE convenio set carta_consulta_numero=carta_consulta_numero,numero='$numero',data='$data',
	valor_financiado='$valor_financiado',nroparcelas='$nroparcelas'
,	cpf_responsavel='$cpf_responsavel',cnpj_empresa='$cnpj_empresa',etapa_id='$etapa_id' 
where id=$id";
//die($query);
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'convenio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraanalise_tecnica($id,$carta_consulta_numero,$cpf_responsavel_analise,
$descricao_completa,$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$ntojovensh,
$nroquilombosm,$nroquilombosh,$nroquilombosjm,$nroquilombosjh,$data_parecer_consgep,
$parecer_consgep,$motivo_parecer_consgep,$data_parecer_fonte,$parecer_fonte,
$motivo_parecer_fonte,$valor_aprovado, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE analise_tecnica set carta_consulta_numero='$carta_consulta_numero',
	cpf_responsavel_analise='$cpf_responsavel_analise',descricao_completa='$descricao_completa',
	nrofamilias='$nrofamilias',nromulheres='$nromulheres',nrohomens='$nrohomens',nrojovensm='$nrojovensm',
	ntojovensh='$ntojovensh',nroquilombosm='$nroquilombosm',nroquilombosh='$nroquilombosh',
	nroquilombosjm='$nroquilombosjm',nroquilombosjh='$nroquilombosjh',
	data_parecer_consgep='$data_parecer_consgep',
	parecer_consgep='$parecer_consgep',motivo_parecer_consgep='$motivo_parecer_consgep',
	data_parecer_fonte='$data_parecer_fonte',parecer_fonte='$parecer_fonte',motivo_parecer_fonte='$motivo_parecer_fonte',
	valor_aprovado='$valor_aprovado'	
	where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'analise_tecnica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluianalise_tecnica(&$id,$carta_consulta_numero,$cpf_responsavel_analise,$descricao_completa,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$ntojovensh,$nroquilombosm,$nroquilombosh,$nroquilombosjm,$nroquilombosjh,
$data_parecer_consgep,$parecer_consgep,$motivo_parecer_consgep,
$data_parecer_fonte,$parecer_fonte,$motivo_parecer_fonte,$valor_aprovado, $usu,$con) {
    $id=0;	
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("analise_tecnica",$con);//echo("id=".$id." = ");
	$query = "insert into analise_tecnica values ('$id','$carta_consulta_numero','$cpf_responsavel_analise',
	'$descricao_completa',
	'$nrofamilias','$nromulheres','$nrohomens','$nrojovensm','$ntojovensh',
	'$nroquilombosm','$nroquilombosh','$nroquilombosjm','$nroquilombosjh',
	'$data_parecer_consgep','$parecer_consgep','$motivo_parecer_consgep',
	'$data_parecer_fonte','$parecer_fonte','$motivo_parecer_fonte','$valor_aprovado')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'analise_tecnica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
		//return ($id);
	}else{
		//return (0);
	}
	return $inclui;
}

function falteraterritorios_desenvolvimento($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE territorios_desenvolvimento set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'territorios_desenvolvimento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiterritorios_desenvolvimento($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("territorios_desenvolvimento",$con);
	$query = "insert into territorios_desenvolvimento values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'territorios_desenvolvimento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
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

function falteramsg_assunto($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE msg_assunto set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'msg_assunto','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluimsg_assunto($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("msg_assunto",$con);
	$query = "insert into msg_assunto values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'msg_assunto','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiVisita_Previa($id,$carta_consulta_numero,$pessoa_fisica_cpf,$data,
$importancia_economica,$condicao_projeto,$observacao_complementar,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,
$parecer_visita_data,$parecer_visita_favoravel,$parecer_visita_motivo,
$parecer_conselho_data,$parecer_conselho_favoravel,$parecer_conselho_motivo,
$qualificacao_beneficiarios,$qualificacao_conhecimento, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("visita_previa",$con);
	$query = "insert into visita_previa values ('$id','$carta_consulta_numero','$pessoa_fisica_cpf','$data','$importancia_economica','$condicao_projeto','$observacao_complementar','$nrofamilias','$nromulheres','$nrohomens','$nrojovensm','$nrojovensh','$nroquilombom','$nroquilomboh','$nroquilombojm','$nroquilombojh','$parecer_visita_data','$parecer_visita_favoravel','$parecer_visita_motivo','$parecer_conselho_data','$parecer_conselho_favoravel','$parecer_conselho_motivo','$qualificacao_beneficiarios','$qualificacao_conhecimento')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Visita_Previa','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraVisita_Previa($id,$carta_consulta_numero,$pessoa_fisica_cpf,$data,
$importancia_economica,$condicao_projeto,$observacao_complementar,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,
$parecer_visita_data,$parecer_visita_favoravel,$parecer_visita_motivo,$parecer_conselho_data,
$parecer_conselho_favoravel,$parecer_conselho_motivo,$qualificacao_beneficiarios,$qualificacao_conhecimento, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE Visita_Previa set carta_consulta_numero='$carta_consulta_numero',pessoa_fisica_cpf='$pessoa_fisica_cpf',data='$data',importancia_economica='$importancia_economica',condicao_projeto='$condicao_projeto',observacao_complementar='$observacao_complementar',nrofamilias='$nrofamilias',nromulheres='$nromulheres',nrohomens='$nrohomens',nrojovensm='$nrojovensm',nrojovensh='$nrojovensh',nroquilombom='$nroquilombom',nroquilomboh='$nroquilomboh',nroquilombojm='$nroquilombojm',nroquilombojh='$nroquilombojh',parecer_visita_data='$parecer_visita_data',parecer_visita_favoravel='$parecer_visita_favoravel',parecer_visita_motivo='$parecer_visita_motivo',parecer_conselho_data='$parecer_conselho_data',parecer_conselho_favoravel='$parecer_conselho_favoravel',parecer_conselho_motivo='$parecer_conselho_motivo',qualificacao_beneficiarios='$qualificacao_beneficiarios',qualificacao_conhecimento='$qualificacao_conhecimento' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Visita_Previa','$q','$dataalteracao')";
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

function falteradepartamento($id,$descricao,$gerencia_regional_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE departamento set descricao='$descricao',gerencia_regional_id='$gerencia_regional_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'departamento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluidepartamento($id,$descricao,$gerencia_regional_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("departamento",$con);
	$query = "insert into departamento values ('$id','$descricao','$gerencia_regional_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'departamento','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluitipo_qualificacao($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipo_qualificacao",$con);
	$query = "insert into tipo_qualificacao values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipo_qualificacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteratipo_qualificacao($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipo_qualificacao set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'tipo_qualificacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraQualificacao($id,$descricao,$tipo_qualificacao_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE qualificacao set descricao='$descricao',tipo_qualificacao_id='$tipo_qualificacao_id' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Qualificacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiQualificacao($id,$descricao,$tipo_qualificacao_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("qualificacao",$con);
	$query = "insert into qualificacao values ('$id','$descricao','$tipo_qualificacao_id')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Qualificacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraTipo_Conselho($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE tipo_conselho set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Tipo_Conselho','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiTipo_Conselho($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("tipo_conselho",$con);
	$query = "insert into tipo_conselho values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Tipo_Conselho','$q','$dataalteracao')";
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

function falteraCargo($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query="UPDATE cargo set descricao='$descricao' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Cargo','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function fincluiCargo($id,$descricao, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("cargo",$con);
	$query = "insert into cargo values ('$id','$descricao')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'Cargo','$q','$dataalteracao')";
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
	
function fincluiDRP(
$id,$associacao,$municipio,$comunidade,$distanciakmasede,$kmasfaltado,$estadoasfaltado,$kmpicarra,$estadopicarra,$kmterra,$estadoterra,$viasacessoobs,$kmenergiamonofasica,$nrosubstacoesmonofasica,$kvamonofasica,$nrousuariosmonofasica,$kmenergiabifasica,$nrosubstacoesbifasica,$kvabifasica,$nrousuariosbifasica,$kmenergiatrifasica,$nrosubstacoestrifasica,$kvatrifasica,$nrousuariostrifasica,$energiaobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("drp",$con);
	$query = "insert into drp (id,associacao_id,municipio_id,comunidade_id,distanciakmasede,kmasfaltado,estadoasfaltado,kmpicarra,estadopicarra,kmterra,estadoterra,viasacessoobs,kmenergiamonofasica,nrosubstacoesmonofasica,kvamonofasica,nrousuariosmonofasica,kmenergiabifasica,nrosubstacoesbifasica,kvabifasica,nrousuariosbifasica,kmenergiatrifasica,nrosubstacoestrifasica,kvatrifasica,nrousuariostrifasica,energiaobs) values ($id,'$associacao','$municipio','$comunidade','$distanciakmasede','$kmasfaltado','$estadoasfaltado','$kmpicarra','$estadopicarra','$kmterra','$estadoterra','$viasacessoobs','$kmenergiamonofasica','$nrosubstacoesmonofasica','$kvamonofasica','$nrousuariosmonofasica','$kmenergiabifasica','$nrosubstacoesbifasica','$kvabifasica','$nrousuariosbifasica','$kmenergiatrifasica','$nrosubstacoestrifasica','$kvatrifasica','$nrousuariostrifasica','$energiaobs')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{die($query);
	}
	return $inclui;
}

function falteraDRP1(
$id,$associacao,$municipio,$comunidade,$distanciakmasede,$kmasfaltado,$estadoasfaltado,$kmpicarra,$estadopicarra,$kmterra,$estadoterra,$viasacessoobs,$kmenergiamonofasica,$nrosubstacoesmonofasica,$kvamonofasica,$nrousuariosmonofasica,$kmenergiabifasica,$nrosubstacoesbifasica,$kvabifasica,$nrousuariosbifasica,$kmenergiatrifasica,$nrosubstacoestrifasica,$kvatrifasica,$nrousuariostrifasica,$energiaobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set associacao_id='$associacao',municipio_id='$municipio',comunidade_id='$comunidade',distanciakmasede='$distanciakmasede',kmasfaltado='$kmasfaltado',estadoasfaltado='$estadoasfaltado',kmpicarra='$kmpicarra',estadopicarra='$estadopicarra',kmterra='$kmterra',estadoterra='$estadoterra',viasacessoobs='$viasacessoobs',kmenergiamonofasica='$kmenergiamonofasica',nrosubstacoesmonofasica='$nrosubstacoesmonofasica',kvamonofasica='$kvamonofasica',nrousuariosmonofasica='$nrousuariosmonofasica',kmenergiabifasica='$kmenergiabifasica',nrosubstacoesbifasica='$nrosubstacoesbifasica',kvabifasica='$kvabifasica',nrousuariosbifasica='$nrousuariosbifasica',kmenergiatrifasica='$kmenergiatrifasica',nrosubstacoestrifasica='$nrosubstacoestrifasica',kvatrifasica='$kvatrifasica',nrousuariostrifasica='$nrousuariostrifasica',energiaobs='$energiaobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP2($id,$associacao,$municipio,$comunidade,$qpoctub,$vpoctub,$lpoctub,$qpoccac,$vpoccac,$cpoccac,$qcister,$ccister,$qacubar,$cacubar,$lacubar,$qrioria,$crioria,$lrioria,$abastdaguaobs,$qfossep,$qfossec,$saneambasicoobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set qpoctub='$qpoctub',vpoctub='$vpoctub',lpoctub='$lpoctub',qpoccac='$qpoccac',vpoccac='$vpoccac',cpoccac='$cpoccac',qcister='$qcister',ccister='$ccister',qacubar='$qacubar',cacubar='$cacubar',lacubar='$lacubar',qrioria='$qrioria',crioria='$crioria',lrioria='$lrioria',abastdaguaobs='$abastdaguaobs',qfossep='$qfossep',qfossec='$qfossec',saneambasicoobs='$saneambasicoobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP3($id,$associacao,$municipio,$comunidade,$qensfun,$sensfun,$bensfun,$rensfun,$pensfun,$ensfunobs,$qens2gr,$sens2gr,$bens2gr,$rens2gr,$pens2gr,$ens2grobs,$qfamagr,$sfamagr,$bfamagr,$rfamagr,$pfamagr,$famagrobs,$qcreche,$screche,$bcreche,$rcreche,$pcreche,$crecheobs,$qpossau,$spossau,$bpossau,$rpossau,$ppossau,$possauobs,$qgabodo,$sgabodo,$bgabodo,$rgabodo,$pgabodo,$gabodoobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set qensfun='$qensfun',sensfun='$sensfun',bensfun='$bensfun',rensfun='$rensfun',pensfun='$pensfun',ensfunobs='$ensfunobs',qens2gr='$qens2gr',sens2gr='$sens2gr',bens2gr='$bens2gr',rens2gr='$rens2gr',pens2gr='$pens2gr',ens2grobs='$ens2grobs',qfamagr='$qfamagr',sfamagr='$sfamagr',bfamagr='$bfamagr',rfamagr='$rfamagr',pfamagr='$pfamagr',famagrobs='$famagrobs',qcreche='$qcreche',screche='$screche',bcreche='$bcreche',rcreche='$rcreche',pcreche='$pcreche',crecheobs='$crecheobs',qpossau='$qpossau',spossau='$spossau',bpossau='$bpossau',rpossau='$rpossau',ppossau='$ppossau',possauobs='$possauobs',qgabodo='$qgabodo',sgabodo='$sgabodo',bgabodo='$bgabodo',rgabodo='$rgabodo',pgabodo='$pgabodo',gabodoobs='$gabodoobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP4($id,$associacao,$municipio,$comunidade,$temdiarreia,$temasma,$temchagas,$temtuberculose,$doencasobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set temdiarreia='$temdiarreia',temasma='$temasma',temchagas='$temchagas',temtuberculose='$temtuberculose',doencasobs='$doencasobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP5($id,$associacao,$municipio,$comunidade,$qtraagr,$ctraagr,$btraagr,$rtraagr,$ptraagr,$traagrobs,$qcasfar,$ccasfar,$bcasfar,$rcasfar,$pcasfar,$casfarobs,$qcasmel,$ccasmel,$bcasmel,$rcasmel,$pcasmel,$casmelobs,$qbenarr,$cbenarr,$bbenarr,$rbenarr,$pbenarr,$benarrobs,$qarmaze,$carmaze,$barmaze,$rarmaze,$parmaze,$armazeobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set qtraagr='$qtraagr',ctraagr='$ctraagr',btraagr='$btraagr',rtraagr='$rtraagr',ptraagr='$ptraagr',traagrobs='$traagrobs',qcasfar='$qcasfar',ccasfar='$ccasfar',bcasfar='$bcasfar',rcasfar='$rcasfar',pcasfar='$pcasfar',casfarobs='$casfarobs',qcasmel='$qcasmel',ccasmel='$ccasmel',bcasmel='$bcasmel',rcasmel='$rcasmel',pcasmel='$pcasmel',casmelobs='$casmelobs',qbenarr='$qbenarr',cbenarr='$cbenarr',bbenarr='$bbenarr',rbenarr='$rbenarr',pbenarr='$pbenarr',benarrobs='$benarrobs',qarmaze='$qarmaze',carmaze='$carmaze',barmaze='$barmaze',rarmaze='$rarmaze',parmaze='$parmaze',armazeobs='$armazeobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP6($id,$associacao,$municipio,$comunidade,$nprod1,$aprod1,$qprod1,$pprod1,$nprod2,$aprod2,$qprod2,$pprod2,$nprod3,$aprod3,$qprod3,$pprod3,$prodobs,$cpacolatr,$cpacolass,$cpacolgov,$cpacolfei,$cppcolatr,$cppcolass,$cppcolgov,$cppcolfei,$cpnentatr,$cpnentass,$cpnentgov,$cpnentfei, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set nprod1='$nprod1',aprod1='$aprod1',qprod1='$qprod1',pprod1='$pprod1',nprod2='$nprod2',aprod2='$aprod2',qprod2='$qprod2',pprod2='$pprod2',nprod3='$nprod3',aprod3='$aprod3',qprod3='$qprod3',pprod3='$pprod3',prodobs='$prodobs',cpacolatr='$cpacolatr',cpacolass='$cpacolass',cpacolgov='$cpacolgov',cpacolfei='$cpacolfei',cppcolatr='$cppcolatr',cppcolass='$cppcolass',cppcolgov='$cppcolgov',cppcolfei='$cppcolfei',cpnentatr='$cpnentatr',cpnentass='$cpnentass',cpnentgov='$cpnentgov',cpnentfei='$cpnentfei' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP7($id,$associacao,$municipio,$comunidade,$apgcomind,$apgcomcol,$apgsedind,$apgsedcol,$apicomind,$apicomcol,$apisedind,$apisedcol,$apobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set apgcomind='$apgcomind',apgcomcol='$apgcomcol',apgsedind='$apgsedind',apgsedcol='$apgsedcol',apicomind='$apicomind',apicomcol='$apicomcol',apisedind='$apisedind',apisedcol='$apisedcol',apobs='$apobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP8($id,$associacao,$municipio,$comunidade,$pagmanprs,$pagmancul,$pagmancol,$pagmanarm,$pagtraprs,$pagtracul,$pagtracol,$pagtraarm,$pagmecprs,$pagmeccul,$pagmeccol,$pagmecarm,$aduorg,$aduqui,$semmel,$racao,$inseti,$salmin, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set pagmanprs='$pagmanprs',pagmancul='$pagmancul',pagmancol='$pagmancol',pagmanarm='$pagmanarm',pagtraprs='$pagtraprs',pagtracul='$pagtracul',pagtracol='$pagtracol',pagtraarm='$pagtraarm',pagmecprs='$pagmecprs',pagmeccul='$pagmeccul',pagmeccol='$pagmeccol',pagmecarm='$pagmecarm',aduorg='$aduorg',aduqui='$aduqui',semmel='$semmel',racao='$racao',inseti='$inseti',salmin='$salmin' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP9($id,$associacao,$municipio,$comunidade,$qorgema,$borgema,$rorgema,$porgema,$qorgcoo,$borgcoo,$rorgcoo,$porgcoo,$qorgsin,$borgsin,$rorgsin,$porgsin,$qorgseb,$borgseb,$rorgseb,$porgseb,$orgobs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set qorgema='$qorgema',borgema='$borgema',rorgema='$rorgema',porgema='$porgema',qorgcoo='$qorgcoo',borgcoo='$borgcoo',rorgcoo='$rorgcoo',porgcoo='$porgcoo',qorgsin='$qorgsin',borgsin='$borgsin',rorgsin='$rorgsin',porgsin='$porgsin',qorgseb='$qorgseb',borgseb='$borgseb',rorgseb='$rorgseb',porgseb='$porgseb',orgobs='$orgobs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP10($id,$associacao,$municipio,$comunidade,$qrexpro,$arexpro,$rexproobs,$qrexarr,$arexarr,$rexarrobs,$qrexpos,$arexpos,$rexposobs,$pophom18a23,$popmul18a23,$pop18a23obs,$pophom23a60,$popmul23a60,$pop23a60obs,$pophomm60,$popmulm60,$popm60obs, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set qrexpro='$qrexpro',arexpro='$arexpro',rexproobs='$rexproobs',qrexarr='$qrexarr',arexarr='$arexarr',rexarrobs='$rexarrobs',qrexpos='$qrexpos',arexpos='$arexpos',rexposobs='$rexposobs',pophom18a23='$pophom18a23',popmul18a23='$popmul18a23',pop18a23obs='$pop18a23obs',pophom23a60='$pophom23a60',popmul23a60='$popmul23a60',pop23a60obs='$pop23a60obs',pophomm60='$pophomm60',popmulm60='$popmulm60',popm60obs='$popm60obs' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function falteraDRP11($id,$associacao,$municipio,$comunidade,$aspambdesnas,$aspambusoina,$aspambsempra,$aspambsemsem,$aspamblixina,$aspambqueima,$nomres,$prores,$nrgres,$endres,$ffxres,$celres,$local,$data, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$query = "UPDATE drp set aspambdesnas='$aspambdesnas',aspambusoina='$aspambusoina',aspambsempra='$aspambsempra',aspambsemsem='$aspambsemsem',aspamblixina='$aspamblixina',aspambqueima='$aspambqueima',nomres='$nomres',prores='$prores',nrgres='$nrgres',endres='$endres',ffxres='$ffxres',celres='$celres',local='$local',data='$data' where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'DRP','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	if($altera){
	}else{
	}
	return $altera;
}

function fleendereco($id,$con){
$ssql="select endereco.*, municipio.descricao as municipio_nome
		from endereco,municipio
		where endereco.municipio_id=municipio.id and endereco.pessoa_id=$id";
$ler=mysql_query($ssql,$con);
return $ler;		
}	

function fincluiPlano_de_Negocio($id,$carta_consulta_numero,$cpf_responsavel,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,
$objetivo,$descricaofaseimplantacao,$descricaofasemanutencao,$organizacaocomunidade,
$cpfresadm,$cpfresfin,$cpfrespro,$cpfrestec,$cpfrescom,$outrasobs, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$id=0;
	$id=fproximoid("plano_de_negocio",$con);
	$query = "insert into plano_de_negocio values ($id,'$carta_consulta_numero','$cpf_responsavel',
	'$nrofamilias','$nromulheres','$nrohomens','$nrojovensm','$nrojovensh',
	'$nroquilombom','$nroquilomboh','$nroquilombojm','$nroquilombojh',
	'$objetivo','$descricaofaseimplantacao','$descricaofasemanutencao','$organizacaocomunidade',
	'$cpfresadm','$cpfresfin','$cpfrespro','$cpfrestec','$cpfrescom','$outrasobs')";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'plano_de_negocio','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
		if($inclui){
		}else{
			$id=0;
		}
	}else{ $id=0;}
	//die($id);
	return ($id);
}	

function falteraPlano_de_Negocio($id,$carta_consulta_numero,$cpf_responsavel,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,
$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,
$objetivo,$descricaofaseimplantacao,$descricaofasemanutencao,$organizacaocomunidade,
$cpfresadm,$cpfresfin,$cpfrespro,$cpfrestec,$cpfrescom,$outrasobs, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "UPDATE plano_de_negocio set carta_consulta_numero='$carta_consulta_numero',cpf_responsavel='$cpf_responsavel',
	nrofamilias='$nrofamilias',nromulheres='$nromulheres',nrohomens='$nrohomens',nrojovensm='$nrojovensm',
	nrojovensh='$nrojovensh',nroquilombom='$nroquilombom',nroquilomboh='$nroquilomboh',
	nroquilombojm='$nroquilombojm',nroquilombojh='$nroquilombojh',
	objetivo='$objetivo',descricaofaseimplantacao='$descricaofaseimplantacao',
	descricaofasemanutencao='$descricaofasemanutencao',organizacaocomunidade='$organizacaocomunidade',
	cpfresadm='$cpfresadm',cpfresfin='$cpfresfin',cpfrespro='$cpfrespro',cpfrestec='$cpfrestec',
	cpfrescom='$cpfrescom',outrasobs='$outrasobs' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'plano_de_negocio','$q','$dataalteracao')";
			//die('usu='.$usu);
			//die($q1);
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	//die($id);
	return ($id);
}	

function fincluiCarta_Consulta($id,$processo,$numero,$associacao_id,$descricao,
$nrofamilias,$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,
$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,$copiaataaprovacaoproposta,$relacaobeneficiarios,
$copiaatareuniaoanalisoucartaconsulta,$drp,$oficiougp,$etapa_id, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$id=fproximoid("carta_consulta",$con);
	$query = "insert into carta_consulta values ($id,'$processo','$numero','$associacao_id','$descricao',
	'$nrofamilias','$nromulheres','$nrohomens','$nrojovensm','$nrojovensh',
	'$nroquilombom','$nroquilomboh','$nroquilombojm','$nroquilombojh','$copiaataaprovacaoproposta',
	'$relacaobeneficiarios','$copiaatareuniaoanalisoucartaconsulta','$drp','$oficiougp','$etapa_id')";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'carta_consulta','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	//die($id);
	return ($id);
}	

function falteraCarta_Consulta($id,$processo,$numero,$descricao,$nrofamilias,
$nromulheres,$nrohomens,$nrojovensm,$nrojovensh,
$nroquilombom,$nroquilomboh,$nroquilombojm,$nroquilombojh,$copiaataaprovacaoproposta,$relacaobeneficiarios,
$copiaatareuniaoanalisoucartaconsulta,$drp,$oficiougp,$etapa_id, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "UPDATE carta_consulta set processo='$processo',numero='$numero',descricao='$descricao',
	nrofamilias='$nrofamilias',nromulheres='$nromulheres',nrohomens='$nrohomens',nrojovensm='$nrojovensm',
	nrojovensh='$nrojovensh',nroquilombom='$nroquilombom',nroquilomboh='$nroquilomboh',
	nroquilombojm='$nroquilombojm',nroquilombojh='$nroquilombojh',
	copiaataaprovacaoproposta='$copiaataaprovacaoproposta',relacaobeneficiarios='$relacaobeneficiarios',
	copiaatareuniaoanalisoucartaconsulta='$copiaatareuniaoanalisoucartaconsulta',drp='$drp',
	oficiougp='$oficiougp',etapa_id='$etapa_id'
	where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'carta_consulta','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	//die($id);
	return ($id);
}	

function fincluiAssociacao($id,$data_fundacao,$area_abrangencia,$numero_socios,$primeiro_tesoureiro,$segundo_tesoureiro,$terceiro_tesoureiro,$primeiro_conselho_fiscal,$segundo_conselho_fiscal,$primeiro_superior_conselho_fiscal,$segundo_superior_conselho_fiscal,$terceiro_superior_conselho_fiscal,$data_inicio_mandato,$data_fim_mandato,$comunidade_id,$pessoa_juridica_id,$nome_pessoa_contato,$telefone_pessoa_contato,$data_cadastro, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	
	$id=fproximoid("associacao",$con);
	$query = "insert into associacao values ($id,'$data_fundacao','$area_abrangencia','$numero_socios','$primeiro_tesoureiro','$segundo_tesoureiro','$terceiro_tesoureiro','$primeiro_conselho_fiscal','$segundo_conselho_fiscal','$primeiro_superior_conselho_fiscal','$segundo_superior_conselho_fiscal','$terceiro_superior_conselho_fiscal','$data_inicio_mandato','$data_fim_mandato','$comunidade_id','$pessoa_juridica_id','$nome_pessoa_contato','$telefone_pessoa_contato','$data_cadastro')";
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

function falteraAssociacao($id,$data_fundacao,$area_abrangencia,$numero_socios,$primeiro_tesoureiro,$segundo_tesoureiro,$terceiro_tesoureiro,$primeiro_conselho_fiscal,$segundo_conselho_fiscal,$primeiro_superior_conselho_fiscal,$segundo_superior_conselho_fiscal,$terceiro_superior_conselho_fiscal,$data_inicio_mandato,$data_fim_mandato,$comunidade_id,$pessoa_juridica_id,$nome_pessoa_contato,$telefone_pessoa_contato,$data_cadastro,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");	
	$query = "UPDATE associacao set data_fundacao='$data_fundacao',area_abrangencia='$area_abrangencia',
	numero_socios='$numero_socios',primeiro_tesoureiro='$primeiro_tesoureiro',
	segundo_tesoureiro='$segundo_tesoureiro',terceiro_tesoureiro='$terceiro_tesoureiro',
	primeiro_conselho_fiscal='$primeiro_conselho_fiscal',segundo_conselho_fiscal='$segundo_conselho_fiscal', primeiro_superior_conselho_fiscal='$primeiro_superior_conselho_fiscal',
	segundo_superior_conselho_fiscal='$segundo_superior_conselho_fiscal', 
	terceiro_superior_conselho_fiscal='$terceiro_superior_conselho_fiscal',
	data_inicio_mandato='$data_inicio_mandato',data_fim_mandato='$data_fim_mandato',
	comunidade_id='$comunidade_id',pessoa_juridica_id='$pessoa_juridica_id',
	nome_pessoa_contato='$nome_pessoa_contato',telefone_pessoa_contato='$telefone_pessoa_contato',
	data_cadastro='$data_cadastro'
		where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'associacao','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
		$endereco=falteraEndereco($pessoa_juridica_id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con);
		$fone=falteraFone($pessoa_juridica_id,$fone,$con);
	}else{
	}
	return $altera;
}

function fincluiconta_corrente($id,$tipopessoa,$pessoa_id,$agencia_id,$contacorrente, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("conta_corrente",$con);
	$query = "insert into conta_corrente values ('$id','$tipopessoa','$pessoa_id','$agencia_id','$contacorrente')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'conta_corrente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}
function falteraConta_Corrente($id,$tipo,$agencia_id,$contacorrente, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");

	$query="UPDATE conta_corrente set tipopessoa='$tipo',agencia_id='$agencia_id',
		contacorrente='$contacorrente' 
		where id=$id";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'conta_corrente','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
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

function falteraEndereco($pessoa_id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$leu=fleendereco($pessoa_id,$con);
	if(mysql_num_rows($leu)>0){
		$query = "UPDATE endereco set logradouro='$logradouro',numero='$numero',complemento='$complemento',bairro='$bairro',cep='$cep',municipio_id='$municipio_id' where pessoa_id=$pessoa_id";
	}else{
		$id=fproximoid("endereco",$con);
		$query="insert into endereco values ('$id', '$logradouro', '$numero', '$complemento', '$bairro', '$cep', '$municipio_id', '$pessoa_id')";
	}	
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

function fincluiPessoa_Fisica($id,$nome,$fone,$cpf,$rg,$data_nascimento,$sexo,$formacao_profissional_id,
$expedidor_rg_id,$numero_registro_conselho,$data_pagamento_conselho,$tipo_conselho_id,$fornecedor,
$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("pessoa",$con);
	
	$q0="insert into pessoa values ($id,'$nome','$fone')";
	
	$query = "insert into pessoa_fisica values ('$id','$cpf','$rg','$data_nascimento','$sexo',
	'$formacao_profissional_id','$expedidor_rg_id','$tipo_conselho_id','$numero_registro_conselho',
	'$data_pagamento_conselho','$fornecedor')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'pessoa_fisica','$q','$dataalteracao')";
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
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con);
		//$conta=falteraConta_Corrente($id,'F',$agencia_id,$contacorrente,$usu,$con);
	}else{
	}
	return $inclui;
}

function falteraPessoa_Fisica($id,$nome,$fone,$cpf,$rg,$data_nascimento,$sexo,$formacao_profissional_id,
$expedidor_rg_id,$numero_registro_conselho,$data_pagamento_conselho,$tipo_conselho_id,$fornecedor,
$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone, $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE pessoa_fisica set cpf='$cpf',rg='$rg',data_nascimento='$data_nascimento',sexo='$sexo',
	formacao_profissional_id='$formacao_profissional_id',expedidor_rg_id='$expedidor_rg_id',
	numero_registro_conselho='$numero_registro_conselho',data_pagamento_conselho='$data_pagamento_conselho',
	tipo_conselho_id='$tipo_conselho_id',fornecedor='$fornecedor' where id=$id";
	
	$q2 = "UPDATE pessoa set nome='$nome',fone='$fone' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'pessoa_fisica','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
		$altera2 = mysql_query($q2,$con);
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con);
		//$conta=falteraConta_Corrente($id,'F',$agencia_id,$contacorrente,$usu,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return ($altera && $altera2);
	
}	

function fincluiPessoa_Juridica($id,$nome,$cnpj,$nome_razao_social,$data_cadastro,$situacao_id,$fornecedor,
                                $logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone,
								$usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	
	$id=fproximoid("pessoa",$con);
	$q0="insert into pessoa values ($id,'$nome','$fone')";
	
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
		}else{ die("Não foi possível incluir pessoa :".$q0);
		}		
	}else{ die ($q1);}
	if($inclui){
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con);
		//$conta=falteraConta_Corrente($id,'J',$agencia_id,$contacorrente,$usu,$con);
	}else{
	}
	return $inclui;
}

function falteraPessoa_Juridica($id,$cnpj,$nome,$fone,$nome_razao_social,$data_cadastro,$situacao_id, 
$fornecedor,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id,$fone,  $usu,$con) {
	
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
		$endereco=falteraEndereco($id,$logradouro,$numero,$complemento,$bairro,$cep,$municipio_id, $usu,$con);
		//$conta=falteraConta_Corrente($id,'J',$agencia_id,$contacorrente,$usu,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return ($altera && $altera2);
	
}	

function fincluiPrestador_Servico_PF($id,$pessoa_fisica_id,$numero_registro_conselho,
		$ultimo_ano_pago_conselho,$tipo_conselho_id,$fornecedor, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("prestador_servico_pf",$con);
	$query = "insert into prestador_servico_pf values ('$id','$pessoa_fisica_id','$numero_registro_conselho','$ultimo_ano_pago_conselho','$tipo_conselho_id','$fornecedor')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'prestador_servico_pf','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraPrestador_Servico_PF($id,$numero_registro_conselho,
		$ultimo_ano_pago_conselho,$tipo_conselho_id,$fornecedor, $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE prestador_servico_pf set numero_registro_conselho='$numero_registro_conselho',ultimo_ano_pago_conselho='$ultimo_ano_pago_conselho',tipo_conselho_id='$tipo_conselho_id',fornecedor='$fornecedor' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'prestador_servico_pf','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return $altera;
	
}	

function fincluiPrestador_Servico_PJ($id,$pessoa_juridica_id,$fornecedor, $usu,$con) {
	$dataalteracao=date("y-m-d h:m:s");
	$id=fproximoid("prestador_servico_pf",$con);
	$query = "insert into prestador_servico_pj values ('$pessoa_juridica_id','$fornecedor')";

	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'prestador_servico_pj','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$inclui = mysql_query($query,$con);
	}else{ die ($q1);}
	if($inclui){
	}else{
	}
	return $inclui;
}

function falteraPrestador_Servico_PJ($id,$fornecedor, $usu,$con) {
	
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE prestador_servico_pj set fornecedor='$fornecedor' where id=$id";
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'prestador_servico_pj','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return $altera;
	
}	

function fverificaPessoa_Fisica($nome,$cpf, $con){
	$ssql = "select * from pessoa,pessoa_fisica where pessoa.id=pessoa_fisica.id 
			and (upper(pessoa.nome) = '$nome' or pessoa_fisica.cpf = '$cpf')";
	$rs=mysql_query($ssql,$con);
	if(mysql_num_rows($rs)>0) {
		return true;
	}
	return false;
}	
	
function fverificaPessoa_Juridica($nome,$cnpj, $con){
	$ssql = "select * from pessoa,pessoa_juridica where pessoa.id=pessoa_juridica.id 
			and (upper(pessoa.nome) = '$nome' or pessoa_juridica.cnpj = '$cnpj')";
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

function fpesquisaconta_corrente_juridica($tex,$obj,$id,$con){
	$obj=strtolower($obj);
	
	if($tex==''){
		$ssql="SELECT conta_corrente.*,agencia.id AS agencia_id,
		agencia.codigo,agencia.endereco,banco.sigla
		FROM conta_corrente
		INNER JOIN agencia ON agencia.id=conta_corrente.agencia_id
		INNER JOIN banco ON banco.id=agencia.banco_id
		WHERE pessoa_id=$id
		ORDER BY sigla,codigo,contacorrente";
	}else{	
		$ssql="SELECT conta_corrente.*,agencia.id AS agencia_id,
		agencia.codigo,agencia.endereco,banco.sigla
		FROM conta_corrente
		INNER JOIN agencia ON agencia.id=conta_corrente.agencia_id
		INNER JOIN banco ON banco.id=agencia.banco_id
		WHERE pessoa_id=$id and (contacorrente like '$tex')
		ORDER BY sigla,codigo,contacorrente
		LIMIT 30";
	}
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fpesquisaconta_corrente_fisica($tex,$obj,$id,$con){
	$obj=strtolower($obj);
	
	if($tex==''){
		$ssql="SELECT conta_corrente.*,agencia.id AS agencia_id,
		agencia.codigo,agencia.endereco,banco.sigla
		FROM conta_corrente
		INNER JOIN agencia ON agencia.id=conta_corrente.agencia_id
		INNER JOIN banco ON banco.id=agencia.banco_id
		WHERE pessoa_id=$id
		ORDER BY sigla,codigo,contacorrente";
	}else{	
		$ssql="SELECT conta_corrente.*,agencia.id AS agencia_id,
		agencia.codigo,agencia.endereco,banco.sigla
		FROM conta_corrente
		INNER JOIN agencia ON agencia.id=conta_corrente.agencia_id
		INNER JOIN banco ON banco.id=agencia.banco_id
		WHERE pessoa_id=$id and (contacorrente like '$tex')
		ORDER BY sigla,codigo,contacorrente
		LIMIT 30";
	}
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fpesquisaconta_orgao($tex,$obj,$orgao,$con){
	$obj=strtolower($obj);
	
	if($tex==''){
		$ssql="SELECT conta_orgao.*,banco.sigla,agencia.codigo 
		FROM conta_orgao
		INNER JOIN agencia on agencia_id=agencia.id 
		INNER JOIN banco on banco_id=banco.id
		WHERE orgao_id=$orgao 
		ORDER BY id
		LIMIT 30";
	}else{	
		$ssql="SELECT conta_orgao.*,banco.sigla,agencia.codigo 
		FROM conta_orgao
		INNER JOIN agencia on agencia_id=agencia.id 
		INNER JOIN banco on banco_id=banco.id
		WHERE orgao_id=$orgao and numero='$tex'
			OR descricao LIKE '$tex'
		ORDER BY id
		LIMIT 30";
	}
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fpesquisaagencia($tex,$obj,$banco,$con){
	$obj=strtolower($obj);
	
	if($tex==''){
		$ssql="SELECT agencia.*
		FROM agencia
		WHERE banco_id=$banco
		ORDER BY id
		LIMIT 30";
	}else{	
		$ssql="SELECT agencia.*
		FROM agencia
		WHERE banco_id=$banco and (codigo like '$tex' or endereco like '$tex')
		ORDER BY id
		LIMIT 30";
	}
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fpesquisaatividade($tex,$obj,$componente,$con){
	$obj=strtolower($obj);
	
	if($tex==''){
	$ssql="SELECT atividade_despesa.*,poa.descricao AS poa_descricao,
	subcomponente.descricao as subcomponente_descricao,
	tipo_despesa.descricao AS tipo_despesa_descricao,
	categoria_despesa.descricao AS categoria_despesa_descricao
 	FROM atividade_despesa
	INNER JOIN poa ON poa.id=atividade_despesa.poa_id
	INNER JOIN subcomponente on subcomponente.id=atividade_despesa.subcomponente_id
	INNER JOIN tipo_despesa ON tipo_despesa.id=atividade_despesa.tipo_despesa_id
	INNER JOIN categoria_despesa ON categoria_despesa.id=atividade_despesa.categoria_despesa_id
	ORDER BY id
	LIMIT 30";
	}else{	
	$ssql="SELECT atividade_despesa.*,poa.descricao AS poa_descricao,
	subcomponente.descricao as subcomponente_descricao,
	tipo_despesa.descricao AS tipo_despesa_descricao,
	categoria_despesa.descricao AS categoria_despesa_descricao
 	FROM atividade_despesa
	INNER JOIN poa ON poa.id=atividade_despesa.poa_id
	INNER JOIN subcomponente on subcomponente.id=atividade_despesa.subcomponente_id
	INNER JOIN tipo_despesa ON tipo_despesa.id=atividade_despesa.tipo_despesa_id
	INNER JOIN categoria_despesa ON categoria_despesa.id=atividade_despesa.categoria_despesa_id
	WHERE atividade_despesa.descricao LIKE '$tex' OR atividade_despesa.id='$tex'
	ORDER BY id
	LIMIT 30";
	}
	//die($ssql);
	$rs=mysql_query($ssql,$con);
	return $rs;
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
	$rs=mysql_query($ssql,$con);
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
	$rs=mysql_query($ssql,$con);
	return $rs;
}

function fleagencias($con) {
	$ssql="SELECT agencia.*,banco.sigla
FROM agencia
INNER JOIN banco ON banco.id=agencia.banco_id
ORDER BY banco.sigla,agencia.codigo
";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		//die($ssql);
		return $leu;
	}else{
		return false;
	}	
}

function fleagenciasbancoid($id,$con) {
	$ssql="SELECT agencia.*,banco.sigla
FROM agencia
INNER JOIN banco ON banco.id=agencia.banco_id
WHERE banco.id=$id
ORDER BY banco.sigla,agencia.codigo
";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function fleagenciaid($id,$con) {
	$ssql="SELECT agencia.*,banco.sigla
FROM agencia
INNER JOIN banco ON banco.id=agencia.banco_id
WHERE agencia.id=$id
ORDER BY banco.sigla,agencia.codigo
";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecontapessoa($tipopessoa,$cpfcnpj) {
	if($tipopessoa=='F'){
		$fcpfcnpj=formatarCNPJCPF ($cpfcnpj, 'cpf');
		$ssql="SELECT conta_corrente.*, pessoa_fisica.cpf
			FROM conta_corrente
			INNER JOIN pessoa_fisica ON conta_corrente.pessoa_id=pessoa_fisica.id
			WHERE pessoa_fisica.cpf='$fcpfcnpj'";
	}else{
		$fcpfcnpj=formatarCNPJCPF ($cpfcnpj, 'cnpj');
		$ssql="SELECT conta_corrente.*, pessoa_juridica.cpf
			FROM conta_corrente
			INNER JOIN pessoa_juridica ON conta_corrente.pessoa_id=pessoa_juridica.id
			WHERE pessoa_juridica.cnpj='$fcpfcnpj'";
	}
	//die($ssql);
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}	
	return $regs['id'];
}

function flecontaorgaoid($id,$con) {
	$ssql="select * from conta_orgao where orgao_id=$id";
	//die($ssql);
	$leu=mysql_query($ssql,$con);
	return $leu;
}

function fleconta_corrente($id,$con) {
	$ssql="SELECT conta_corrente.*,agencia.id AS agencia_id,
		agencia.codigo,agencia.endereco,banco.sigla
		FROM conta_corrente
		INNER JOIN agencia ON agencia.id=conta_corrente.agencia_id
		INNER JOIN banco ON banco.id=agencia.banco_id
		WHERE pessoa_id=$id
		ORDER BY sigla,codigo,contacorrente";
	$leu=mysql_query($ssql,$con);
	return $leu;
}

function flecontacorrente($id,$ag,$con) {
	$ssql="select * from conta_corrente where pessoa_id=$id and agencia_id=$ag";
	$leu=mysql_query($ssql,$con);
	return $leu;
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

function flePlano_de_Negocio_Numero($carta_consulta_numero,$con){
	$ssql="select plano_de_negocio.*
		from plano_de_negocio
		where plano_de_negocio.carta_consulta_numero='$carta_consulta_numero'";  
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}	

function fleCarta_Consulta_Numero($carta_consulta_numero,$con){
	$ssql="select carta_consulta.*
		from carta_consulta
		where carta_consulta.numero='$carta_consulta_numero'";  
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}	

function fleConvenio_Carta_Consulta_Numero($carta_consulta_numero,$con){
	$ssql="select convenio.*
		from convenio
		where carta_consulta_numero='$carta_consulta_numero'";  
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}	

function fleAnalise_Tecnica_Carta_Consulta_Numero($carta_consulta_numero,$con){
	$ssql="select analise_tecnica.*
		from analise_tecnica
		where carta_consulta_numero='$carta_consulta_numero'";  
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}	

function flecpfcnpjPlano_de_Negocio($cpf,$cnpj,$con){
	$ssql="select plano_de_negocio.*
		from plano_de_negocio
		where cpf_responsavel='$cpf'  
		and cnpj_entidade='$cnpj'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}	

function flecnpjAssociacao($cnpj,$con) {
	$ssql="select associacao.*, pessoa_juridica.cnpj, pessoa.nome as pessoa_nome
		from associacao,pessoa_juridica,pessoa 
		where associacao.pessoa_juridica_id=pessoa.id and pessoa_juridica.id=pessoa.id 
		and pessoa_juridica.cnpj='$cnpj'";
		//die($ssql);
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
		//die($regs['pessoa_nome']);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecnpjCarta_Consulta($cnpj,$con) {
	$ssql="select carta_consulta.*, associacao.*, pessoa_juridica.cnpj, pessoa.nome as pessoa_nome
		from carta_consulta,associacao,pessoa_juridica,pessoa 
		where carta_consulta.associacao_id=associacao.id and associacao.pessoa_juridica_id=pessoa.id and pessoa_juridica.id=pessoa.id 
		and pessoa_juridica.cnpj='$cnpj'";
		//die($ssql);
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
		//die($regs['pessoa_nome']);
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

function fleusuarioPessoa_Fisica($id,$con) {
	$ssql="select usuario.*
		from usuario 
		where pessoa_fisica_id=$id";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecpfPessoa_Fisica($cpf,$con) {
	$ssql="select pessoa_fisica.*
		from pessoa_fisica 
		where pessoa_fisica.cpf='$cpf'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		//die($ssql);
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function flecnpjPessoa_Juridica($cnpj,$con) {
	$ssql="select pessoa_juridica.*
		from pessoa_juridica 
		where pessoa_juridica.cnpj='$cnpj'";
	$leu=mysql_query($ssql,$con);
	if(mysql_num_rows($leu)>0){
		$regs=mysql_fetch_array($leu);
	}else{
		$regs=false;
	}	
	return $regs;
}

function fledrp($id,$con){
	$ssql="select * from drp where municipio_id=$id";
	$leu=mysql_query($ssql,$con);
	return $leu;
}

function flecomunidadesmunicipio($municipio_id,$con){
	$ssql="select * from comunidade
		where municipio_id=$municipio_id order by descricao";
	$leit=mysql_query($ssql,$con);	
	return $leit;
}	

function fleassociacoescomunidade($comunidade_id,$con){
	$ssql="select associacao.*,pessoa_juridica.cnpj,pessoa.nome as pessoa_nome,
		comunidade.descricao as comunidade_descricao,municipio.descricao as municipio_descricao
		from associacao,comunidade,municipio,pessoa_juridica,pessoa 
		where associacao.pessoa_juridica_id=pessoa_juridica.id 
		and associacao.comunidade_id=comunidade.id 
		and comunidade.municipio_id=municipio.id
		and pessoa_juridica.id=pessoa.id and associacao.comunidade_id = $comunidade_id";
	$leit=mysql_query($ssql,$con);	
	return $leit;
}	

function fleconvenio_parcelamento($id, $con) {
	$ssql="select convenio_parcelamento.*
			from convenio_parcelamento 
			where convenio_parcelamento.convenio_id=$id
			order by nroparcela";
	$leit=mysql_query($ssql,$con);
//die ($ssql);	
	return $leit;
}

function fleconvenio_fontes($id, $con) {
	$ssql="select convenio_fontes.*,fonte_de_recurso.descricao
			from convenio_fontes 
			inner join fonte_de_recurso on fonte_id=fonte_de_recurso.id 
			where convenio_fontes.convenio_id=$id
			order by descricao";
	$leit=mysql_query($ssql,$con);
//die ($ssql);	
	return $leit;
}

function flemembros($id, $con) {
	$ssql="select membro.*, pessoa.nome as pessoa_nome, cargo.descricao as cargo_nome
			from membro 
			inner join pessoa on membro.pessoa_fisica_id=pessoa.id
			inner join cargo on membro.cargo_id=cargo.id
			where associacao_id=$id
			order by cargo.id";
	//die($ssql);		
	$leit=mysql_query($ssql,$con);
//die ($ssql);	
	return $leit;
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
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	return $reg;
}

function fledescricaotabela($id,$tabela,$con){
	$reg=fleidtabela($id,$tabela,$con);
	return $reg['descricao'];
}	

function fleidConvenio($id,$tab,$con){
	$ssql="SELECT convenio.*,pessoa.nome AS responsavel_nome,
       pessoa_juridica.nome_razao_social AS entidade_nome,
       pessoa_juridica.cnpj as cnpj_entidade,comunidade.id AS comunidade_id, 
       comunidade.descricao AS comunidade_descricao,
       municipio.id AS municipio_id, municipio.descricao AS municipio_descricao
FROM convenio
INNER JOIN carta_consulta ON carta_consulta.numero=convenio.carta_consulta_numero
INNER JOIN associacao ON associacao.id=carta_consulta.associacao_id
INNER JOIN pessoa_juridica ON associacao.pessoa_juridica_id=pessoa_juridica.id
INNER JOIN comunidade ON associacao.comunidade_id=comunidade.id
INNER JOIN municipio ON comunidade.municipio_id=municipio.id
LEFT JOIN pessoa_fisica ON pessoa_fisica.cpf=convenio.cpf_responsavel
LEFT JOIN pessoa ON pessoa_fisica.id=pessoa.id
		WHERE convenio.id=$id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidPlano_de_Negocio($id,$tab,$con){
	$ssql="SELECT plano_de_negocio.*,pessoa.nome AS responsavel_nome,
       pessoa_juridica.nome_razao_social AS entidade_nome,
       pessoa_juridica.cnpj as cnpj_entidade,comunidade.id AS comunidade_id, 
       comunidade.descricao AS comunidade_descricao,
       municipio.id AS municipio_id, municipio.descricao AS municipio_descricao,
       endereco.id AS endereco_id, endereco.logradouro,endereco.numero,
       endereco.complemento, endereco.bairro, endereco.cep, 
       endereco.municipio_id AS endereco_municipio_id
FROM plano_de_negocio
INNER JOIN carta_consulta ON carta_consulta.numero=plano_de_negocio.carta_consulta_numero
INNER JOIN associacao ON associacao.id=carta_consulta.associacao_id
INNER JOIN pessoa_juridica ON associacao.pessoa_juridica_id=pessoa_juridica.id
INNER JOIN comunidade ON associacao.comunidade_id=comunidade.id
INNER JOIN municipio ON comunidade.municipio_id=municipio.id
INNER JOIN pessoa_fisica ON pessoa_fisica.cpf=plano_de_negocio.cpf_responsavel
INNER JOIN pessoa ON pessoa_fisica.id=pessoa.id
LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id
WHERE plano_de_negocio.id=$id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidCarta_Consulta($id,$tab,$con){
	$ssql="select carta_consulta.*,associacao.id as associacao_id,
	    associacao.comunidade_id, pessoa_juridica.cnpj,pessoa.id as pessoa_id,
		pessoa.nome as pessoa_nome,	pessoa.fone as pessoa_fone, 
		comunidade.id as comunidade_id, 
		comunidade.descricao as comunidade_descricao,
		municipio.id as municipio_id, municipio.descricao as municipio_descricao
		from carta_consulta,associacao,comunidade,municipio,pessoa_juridica,pessoa 
		where carta_consulta.associacao_id=associacao.id 
		and associacao.pessoa_juridica_id=pessoa_juridica.id 
		and associacao.comunidade_id=comunidade.id 
		and comunidade.municipio_id=municipio.id
		and pessoa_juridica.id=pessoa.id and carta_consulta.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidAssociacaoEndereco($id,$tab,$con){
	$ssql="select associacao.*,pessoa_juridica.cnpj,pessoa.id as pessoa_id,
		pessoa.nome as pessoa_nome,	pessoa.fone as pessoa_fone, 
		comunidade.id as comunidade_id, 
		comunidade.descricao as comunidade_descricao,
		municipio.id as municipio_id, municipio.descricao as municipio_descricao,
		endereco.id as endereco_id, endereco.logradouro,endereco.numero,
		endereco.complemento, endereco.bairro, endereco.cep, 
		endereco.municipio_id as endereco_municipio_id
		from associacao,comunidade,municipio,pessoa_juridica,pessoa 
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id
		where associacao.pessoa_juridica_id=pessoa_juridica.id 
		and associacao.comunidade_id=comunidade.id 
		and comunidade.municipio_id=municipio.id
		and pessoa_juridica.id=pessoa.id and associacao.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidPessoa_JuridicaEndereco($id,$tab,$con){
	$ssql="select pessoa_juridica.*,pessoa.id as pessoa_id,
		pessoa.nome as pessoa_nome, pessoa.fone as pessoa_fone,
		endereco.id as endereco_id, endereco.logradouro,endereco.numero,
		endereco.complemento, endereco.bairro, endereco.cep, 
		endereco.municipio_id as endereco_municipio_id
		from pessoa_juridica,pessoa 
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id
		where pessoa_juridica.id=pessoa.id and pessoa.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function falteraMembro($id,$data_mandato,$cargo_id, $usu,$con){
	$dataalteracao=date("y-m-d h:m:s");	

	$query = "UPDATE membro set data_mandato='$data_mandato',cargo_id='$cargo_id' where id=$id"; 
			
	$q=addslashes($query);
	$q1 = "INSERT INTO hystory (usuario_id, objeto, ssql, data) VALUES (
			'$usu', 'membro','$q','$dataalteracao')";
	$insert = mysql_query($q1,$con);
	if($insert){
		$altera = mysql_query($query,$con);
	}else{ die ($q1);}
	
	if($altera){
	}else{
	}
	return $altera;	
}

function fleidMembro($id,$tab,$con){
	$ssql="select membro.data_mandato,membro.cargo_id,membro.associacao_id,
	    pessoa_fisica.*,pessoa.id as pessoa_id,
		pessoa_juridica.nome_razao_social as associacao_nome,
		pessoa.nome as pessoa_nome, pessoa.fone as pessoa_fone,
		endereco.id as endereco_id, endereco.logradouro,endereco.numero,
		endereco.complemento, endereco.bairro, endereco.cep, 
		endereco.municipio_id as endereco_municipio_id
		from membro
		    INNER JOIN associacao on associacao.id=membro.associacao_id
			INNER JOIN pessoa_juridica on pessoa_juridica.id=associacao.pessoa_juridica_id
			INNER JOIN pessoa_fisica on pessoa_fisica.id=membro.pessoa_fisica_id
			INNER JOIN pessoa on pessoa.id=pessoa_fisica.id
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id
		where pessoa_fisica.id=pessoa.id and membro.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die($ssql);}
	return $reg;
}	

function fleidPessoa_FisicaEndereco($id,$tab,$con){
	$ssql="SELECT pessoa_fisica.*,pessoa.id AS pessoa_id, pessoa.nome AS pessoa_nome, pessoa.fone AS pessoa_fone, 
			endereco.id AS endereco_id, endereco.logradouro,endereco.numero, endereco.complemento, endereco.bairro, 
			endereco.cep, endereco.municipio_id AS endereco_municipio_id 
		from pessoa_fisica,pessoa 
			LEFT JOIN endereco ON endereco.pessoa_id=pessoa.id and endereco.pessoa_id=$id
		where pessoa_fisica.id=pessoa.id and pessoa.id = $id";
	//die($ssql);
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if(!$reg){die('Retorno não permitido - '.$ssql);}
	return $reg;
}	

function flepessoafisicaporcpf($cpf,$con){
	$ssql="select pessoa_fisica.*,pessoa.nome as pessoa_nome
		from pessoa_fisica,pessoa where pessoa_fisica.cpf= '$cpf'";
	$leit=mysql_query($ssql,$con);	
	if(mysql_num_rows($leit)>0){
		$reg=mysql_fetch_array($leit);
		return $reg;
	}else{
		return false;
	}	
}	

function flenomcpf($cpf,$con){
	$ssql="select pessoa_fisica.*,pessoa.nome as pessoa_nome
		from pessoa_fisica,pessoa where pessoa_fisica.id=pessoa.id 
		and pessoa_fisica.cpf= '$cpf'";
	//die($ssql);	
	$leit=mysql_query($ssql,$con);	
	$reg=mysql_fetch_array($leit);
	if($reg){
		return $reg['pessoa_nome'];
	}else{	
		return 'Não Identificado';
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
			left join pessoa on pessoa_fisica_id=pessoa.id
			order by pessoa.nome";
	$leit=mysql_query($ssql,$con);
	return $leit;
}	
	
function flesubcomponente($componente_id,$con){
	$ssql="select * from subcomponente where componente_id=$componente_id order by id";
	$leit=mysql_query($ssql,$con);
	return $leit;
}	
	
function fletabela($tabela,$con){
	$ssql="select * from ".$tabela." order by id";
	$leit=mysql_query($ssql,$con);
	return $leit;
}	
	
function fleetapa($tabela,$con){
	if($tabela=="cartaproposta") {
		$ssql="select * from etapa where tramite_id=1 order by sequencia";
    }else{
	if($tabela=="convenio") {
		$ssql="select * from etapa where tramite_id=2 order by sequencia";
	}else{	
		$ssql="select * from etapa where tramite_id=3 order by sequencia";
	}}	
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
