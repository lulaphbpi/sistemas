<?php
if(!isset($_SESSION)){session_start();}

include("include/finc.php");
$conque=conexao('questionario');

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usu=$_SESSION['usuarioid'];

$id=0; 
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$id=$_GET['id'];

//header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$id");
//exit;
    

$pid=fproximoid("questionario", $conque);    
$sql1 = "insert into questionario (select $pid, titulo, sigla, descricao, interessado, nroquestoes, sistema, '' from questionario where id=$id)";
$conque->query($sql1);

$sql2 = "select * from questao where id_questionario = $id order by id";
$recsql2=$conque->query($sql2);
if($recsql2->rowCount() > 0){
    foreach ($recsql2->fetchAll() as $rsql2){
        $idqa = $rsql2['id'];
        $idq=fproximoid("questao", $conque);
        $sql2i="insert into questao values (".$idq.", ".$pid.", ".$rsql2['id_tipoquestao'].", '".
            $rsql2['enunciado']."', ".$rsql2['ordem'].", ".$rsql2['nalternativas'].", ".$rsql2['ordemf'].")";
        $conque->query($sql2i);
        
        $sql3 = "select * from opcao where id_questao = $idqa order by id";
        $recsql3=$conque->query($sql3);
        if($recsql3->rowCount() > 0){
            foreach ($recsql3->fetchAll() as $rsql3){
                $ido=fproximoid("opcao", $conque);
                $sql3i="insert into opcao values (".$ido.", ".$rsql3['ordem'].", ".$idq.", '".$rsql3['descricao']."', ".$rsql3['valor'].")";
                $conque->query($sql3i);
            }
        }        
    }    
}
$_SESSION['msg']='(copiaQuestionario.php). Verifique cópia do questionário $id para o questionário $pid';
header ("Location: chameFormulario.php?op=cadastrar&obj=questionario&cpl=q1&id=$pid");
?>
