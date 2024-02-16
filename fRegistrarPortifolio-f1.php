<?php
include("include/finc.php");
$conpes=conexao(BPESSOAL);
$conefi=conexao(BEFISIO);

$rotina='fRegistrarPortifolio-f1.php';
$rotinaanterior=$_SESSION['rotina'];
if($rotina==$rotinaanterior){ //die('repetiu');
}else{
	$_SESSION['inicial']=0;	
	$_SESSION['rotina']=$rotina;
}

$msg="";
$msg=$_SESSION['msg'];
$_SESSION['msg']='';
$usuarioid=$_SESSION['usuarioid'];

//$trace=ftrace('fRegistrarPortifolio-f1.php','Inicio:'.$usuarioid);
$spid=0;
if(isset($_GET['id']) && empty($_GET['id']) == false)
	$spid=$_GET['id'];  // servicopessoaid
if($rotina==$rotinaanterior){
    //die('spid:'.$spid);
}
$descricao="";    
$data=date('Y-m-d');
$rpes=leservicopessoaid_fi($spid,$conefi);
if($rpes){
	$pessoaid=$rpes['pessoa_id'];
    $cpf=$rpes['cpf'];
	$apelido=$rpes['apelido'];
	$nome=$rpes['nome'];
	$datanascimento=$rpes['datanascimento'];
	$idade = idade($rpes['datanascimento']);
	$dtn=formataDataToBr($datanascimento);
	$sexo=$rpes['sexo'];
	$fone=$rpes['fone'];
	$data=$rpes['data'];
	$diagnosticomedico=$rpes['diagnosticomedico'];
	$motivo=$rpes['motivo'];
	$observacoes=$rpes['observacoes'];
	$contato=$rpes['contato'];
	$servicoid=$rpes['servico_id'];
	$statussp=$rpes['statussp'];
}else{
	$_SESSION['msg']='fRegistrarPortifolio-f1.php - ERRO FATAL: Id '.$id.' não encontrado!'; die('Fatal :'.'ERRO FATAL: Id '.$id.' não encontrado!');
	return '';
}
$grupo=$_SESSION['grupo'];
$nomeservico=lenomeservico($servicoid, $conefi);

$rimagem = fLeImagensPaciente($pessoaid, $conefi);
//$act = "chameFormulario.php?op=registrar&obj=portfolio&cpl=f1&id=$spid";
$act = "registrarPortifolio.php?id=$spid"; //$act="?id=$spid";

?>
<script>
</script>
<div class="areatrabalho">
    <div class="formularioEntrada">
        <form action="<?php echo($act);?>" method="POST" id="iformulario" enctype="multipart/form-data" class="formulario">
			<div id="lblerro"><?php echo($msg); ?></div><br>
			<p><b><u>Paciente - Portifólio (Pessoa <?php echo($pessoaid);?>)</u></b></p>
			<div class="row">
				<div class="form-group col-md-2">
					<label>CPF: </label>
					<p><?php echo($cpf);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Nome Social: </label>
					<p><?php echo($apelido);?></p>
				</div>
				<div class="form-group col-md-3">
					<label>Nome: </label>
					<p><?php echo($nome);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Data Nasc: </label>
					<p><?php echo($dtn.' ('.$idade.' anos)');?></p>
				</div>
				<div class="form-group col-md-1">
					<label>Gênero: </label>
					<p><?php echo($sexo);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Fone: </label>
					<p><?php echo($fone);?></p>
				</div>
			</div>	
            <hr>
<!--			<div class="row">
				<div class="form-group col-md-2">
					<label>Data:</label>
					<p><?php echo($data);?></p>
				</div>
				<div class="form-group col-md-6">
					<label>Nome/ Contato Emergência:</label><br>
					<p><?php echo($contato);?></p>
				</div>
				<div class="form-group col-md-2">
					<label>Status:</label><br>
					<p><?php echo($statussp);?></p>
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-md-4">
					<label>Diagnóstico Médico:</label><br>
					<p><?php echo($diagnosticomedico);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Motivo/Queixas:</label>
					<p><?php echo($motivo);?></p>
				</div>
				<div class="form-group col-md-4">
					<label>Observações:</label><br>
					<p><?php echo($observacoes);?></p>
				</div>
			</div>	
-->
            <div class="row">
				<div class="form-group col-md-6">
                    <label>Envio de arquivo(s) - Descrição:</label><br>
			        <textarea name="descricao" id="arqdescricao" rows="3" cols="100"><?php echo($descricao);?></textarea>
                    <label for="inputSubmit" id="labelSubmit" > Selecione arquivo(s) para Enviar</label>
        	        <input multiple name="arquivos[]" id="inputSubmit" type="file">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	                <button name="upload" id="buttonSubmit" type="submit" > Enviar arquivo(s)</button>
                </div>   
            </div>   

        </form>
        <div class="row">
        <div class="form-group col-md-11">
        <h3> Lista de arquivos</h3>
        <table class="tableportfolio tabela1">
	        <thead  style="background-color: #8FBC8F">
                <th width="3%">Ord</th>
		        <th width="5%">Preview</th>
		        <th width="20%">Arquivo</th>
		        <th width="35%">Descrição</th>
		        <th width="15%">Data de Envio</th>
                <th width="17%">Operador</th>
		        <th width="5%"></th>
	        </tread>	
	        <tbody>
	        <?php
	            $count_l=1;
                $ord=0;
		        foreach($rimagem->fetchAll() as $reg){
                    $ord++;
	        ?>		
	        <?php
	            if($count_l==1){
		            $count_l=0;
	        ?>
		        <tr>
	        <?php
		    }else{
		        $count_l=1;	
	        ?>		
		        <tr">
	        <?php
		    }
	        ?>		
			        <td><?php echo($ord);?></td>
			        <td><img src="<?php echo $reg['link']; ?>" class="imgportfolio"></img></td>
			        <td><a href="<?php echo($reg['link']);?>" target="_blank" alt="Visualizar imagem"><?php echo($reg['nome']);?></a></td>
			        <td><?php echo($reg['descricao']);?></td>
			        <td><?php echo(date("d/m/Y H:i", strtotime($reg['data_upload'])));?></td>
			        <td><?php echo($reg['pid'].' '.$reg['nomeusuario']);?></td>
			        <td><a  href="registrarPortifolio.php?id=<?php echo($spid);?>&del=<?php echo $reg['id']; ?>">Excluir</a></td>
		        </tr>
	        <?php			
		    }
	        ?>
	        </tbody>
        </table>
        </div>
        </div>    
        <p><a href='chameFormulario.php?op=consultar&obj=paciente&cpl=f1'>Retornar</a>	</p>		

    </div>    
</div>	