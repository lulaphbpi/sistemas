
window.onload = function() {
	
	//alert("1");
	
	var bt0 = document.getElementById("ibotaologin");
	if(bt0){ 
		bt0.onclick = function (){
			var formlog = document.getElementById("formulariologin");
			formlog.submit();
		}
	} 
	
	var bt0 = document.getElementById("ibformulario");
	if(bt0){
		bt0.onclick = function () {
			var form = document.getElementById("iformulario");
			if(validaformulario(form)) {
				form.submit();
			}
		}
	}

	var bt1 = document.getElementById("ibformulariobloco");
	if(bt1){
		bt1.onclick = function () {
			window.location.assign("chameFormulario.php?op=ultimos&obj=Bloco&menu=principal");
		}
	}	
	var bt1 = document.getElementById("ibformulariolinha");
	if(bt1){
		bt1.onclick = function () {
			window.location.assign("chameFormulario.php?op=ultimos&obj=Linha&menu=principal");
		}
	}	



}
	
function validaformulario(f){
//	if (!ehNumero(f.pagmanprs.value)) {
//		alert("Valor inválido para Preparo Solo Manual!");
//		f.pagmanprs.focus();
//		return false;
//	}	
	return true;
}
	
function ehNumero(n) {
	var nn = new RegExp("[0-9]");
	var eh=0;
	lg=n.length;
	//alert(n+" tamanho:"+lg);
	for(var i=0;i<lg;i++){
		//alert("digito "+n[i]);
		var r = nn.exec(n[i]);
		if(!r) {
			eh=1;
		}
	}
	if(eh==1){
		return false;
	}else{
		return true;
	}
}	

function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}

function validarCPF(cpf) {  
    cpf = cpf.replace(/[^\d]+/g,'');    
    if(cpf == '') return false; 
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999")
            return false;       
    // Valida 1o digito 
    add = 0;    
    for (i=0; i < 9; i ++)       
        add += parseInt(cpf.charAt(i)) * (10 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11)     
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9)))     
            return false;       
    // Valida 2o digito 
    add = 0;    
    for (i = 0; i < 10; i ++)        
        add += parseInt(cpf.charAt(i)) * (11 - i);  
    rev = 11 - (add % 11);  
    if (rev == 10 || rev == 11) 
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10)))
        return false;       
    return true;   
}

function validaData(campo,valor) {
	var date=valor;
	var ardt=new Array;
	var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
	ardt=date.split("/");
	erro=false;
	//alert("validaData:"+campo+" "+valor);
	if ( date.search(ExpReg)==-1){
		erro = true;
	}
	else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30))
		erro = true;
	else if ( ardt[1]==2) {
		if ((ardt[0]>28)&&((ardt[2]%4)!=0))
			erro = true;
		if ((ardt[0]>29)&&((ardt[2]%4)==0))
			erro = true;
	}
	return (erro);
}

function validaformulariodrpg11(f){
	//alert("validaformulariodrpg11");
	if (f.aspambdesnas.value.length<1) {
		alert("Valor inválido para Resposta Sim/Não!");
		f.aspambdesnas.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg10(f){
	//alert("validaformulariodrpg10");
	if (!ehNumero(f.qrexpro.value)) {
		alert("Valor inválido para Nº de Proprietários!");
		f.qrexpro.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg9(f){
	//alert("validaformulariodrpg9");
	if (!ehNumero(f.qorgema.value)) {
		alert("Valor inválido para Nº Órgão de Apoio - Emater!");
		f.qorgema.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg8(f){
	//alert("validaformulariodrpg8");
	if (!ehNumero(f.pagmanprs.value)) {
		alert("Valor inválido para Preparo Solo Manual!");
		f.pagmanprs.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg7(f){
	//alert("validaformulariodrpg7");
	if (!ehNumero(f.apgcomind.value)) {
		alert("Valor inválido para Gêneros Alimentícios - Aquisição Individual na Comunidade!");
		f.apgcomind.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg6(f){
	//alert("validaformulariodrpg6");
	if (f.nprod1.value.length < 2) {
		//alert("Nome Inválido para o Produto!");
		//f.nprod1.focus();
		//return false;
	}	
	return true;
}
	
function validaformulariodrpg5(f){
	//alert("validaformulariodrpg5");
	if (!ehNumero(f.qtraagr.value)) {
		alert("Valor inválido para N.Tratores!");
		f.qtraagr.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg4(f){
	//alert("validaformulariodrpg4");
	if (false) {
		alert("Valor inválido para Doença!");
		f.temdiarreia.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg3(f){
	//alert("validaformulariodrpg3");
	if (!ehNumero(f.qensfun.value)) {
		alert("Valor inválido para Número de Poços Tubulares!");
		f.qpoctub.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg2(f){
	//alert("validaformulariodrpg2");
	if (!ehNumero(f.qpoctub.value)) {
		alert("Valor inválido para Número de Poços Tubulares!");
		f.qpoctub.focus();
		return false;
	}	
	return true;
}
	
function validaformulariodrpg1(f){
	if (!ehNumero(f.kmasfaltado.value)) {
		alert("Valor inválido para KmAsfaltado!");
		f.kmasfaltado.focus();
		return false;
	}	
	return true;
}
	
function validaformularioprestador_servico_pf(f){
	//alert("aqui v");
	if (f.numero_registro_conselho.value.length < 2) {
	  	alert("Preencha o Número do Registro Conselho com um mínimo de caracteres!");
	  	f.numero_registro_conselho.focus();
	  	return false;
	}
/*	berro=validaData(f.ultimo_ano_pago_conselho,f.ultimo_ano_pago_conselho.value);
	if(berro) {
		alert(f.ultimo_ano_pago_conselho.value + " não é uma data válida!!!");
		f.ultimo_ano_pago_conselho.focus();
		return false;
	}else{
		return true;
	}	
*/	
	if (f.fornecedor[0].checked==false && f.fornecedor[1].checked==false) {
	  	alert("Selecione se é ou não fornecedor!");
	  	return false;
	}
	return true;
}

function validaformularioprestador_servico_pj(f){
	//alert("aqui v");
/*	berro=validaData(f.ultimo_ano_pago_conselho,f.ultimo_ano_pago_conselho.value);
	if(berro) {
		alert(f.ultimo_ano_pago_conselho.value + " não é uma data válida!!!");
		f.ultimo_ano_pago_conselho.focus();
		return false;
	}else{
		return true;
	}	
*/	
	if (f.fornecedor[0].checked==false && f.fornecedor[1].checked==false) {
	  	alert("Selecione se é ou não fornecedor!");
	  	return false;
	}
	return true;
}

function validaformulariopessoa_fisica(f){
	if(!validarCPF(f.cpf.value)) {
	  	alert("CPF Inválido!");
	  	f.cpf.focus();
	  	return false;
	}	
	if (f.rg.value.length < 2) {
	  	alert("Preencha o RG com um mínimo de caracteres!");
	  	f.rg.focus();
	  	return false;
	}
	return true;
}

function validaformulariopessoa_juridica(f){
	if(!validarCNPJ(f.cnpj.value)) {
	  	alert("CNPJ Inválido!");
	  	f.cnpj.focus();
	  	return false;
	}	
	if (f.nome_razao_social.value.length < 10) {
	  	alert("Preencha Razão Social com um mínimo de caracteres!");
	  	f.nome_razao_social.focus();
	  	return false;
	}
	return true;
}

function validaformulariomunicipio(f) {
	var nnumero = /[0-9]/;

	if (f.descricao.value.length < 2) {
	  	alert("Preencha a Descrição (nome do município) com um mínimo de caracteres!");
	  	f.descricao.focus();
	  	return false;
	}
	if (f.e_sede[0].checked==false && f.e_sede[1].checked==false) {
	  	alert("Selecione se é ou não sede!");
	  	return false;
	}
	if (f.populacao.value=="") {
		f.populacao.value=0;
	}	
	if (f.populacao_rural.value=="") {
		f.populacao.value=0;
	}	
	if (f.populacao_urbana.value=="") {
		f.populacao.value=0;
	}	
	if (!ehNumero(f.populacao.value)) {
		alert("Valor inválido para população!");
		f.populacao.focus();
		return false;
	}
	if (!ehNumero(f.populacao_rural.value)) {
		alert("Valor inválido para população rural!");
		f.populacao_rural.focus();
		return false;
	}	
	if (!ehNumero(f.populacao_urbana.value)) {
		alert("Valor inválido para população urbana!");
		f.populacao_urbana.focus();
		return false;
	}	
	if (!ehNumero(f.num_familias.value)) {
		alert("Valor inválido para número de famílias!");
		f.num_familias.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicilios.value)) {
		alert("Valor inválido para número de domicílioas!");
		f.num_domicilios.focus();
		return false;
	}	
	if (!ehNumero(f.area.value)) {
		alert("Valor inválido para área!");
		f.area.focus();
		return false;
	}	
	if (!ehNumero(f.idh.value)) {
		alert("Valor inválido para IDH!");
		f.idh.focus();
		return false;
	}	
	if (!ehNumero(f.pib.value)) {
		alert("Valor inválido para PIB!");
		f.pib.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_rede_geral.value)) {
		alert("Valor inválido para número de domicílios rede geral!");
		f.num_domicio_rede_geral.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_poco.value)) {
		alert("Valor inválido para número domicílios poço!");
		f.num_domicio_poco.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_outro.value)) {
		alert("Valor inválido para número domicílios outro!");
		f.num_domicio_outro.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_possui_rede_eletrica.value)) {
		alert("Valor inválido para número domicílios rede elétrica!");
		f.num_domicio_possui_rede_eletrica.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_n_possui_rede_eletrica.value)) {
		alert("Valor inválido para número domicílios não possui rede elétrica!");
		f.num_domicio_n_possui_rede_eletrica.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_possui_banheiro.value)) {
		alert("Valor inválido para número domicílios banheiro!");
		f.num_domicio_possui_banheiro.focus();
		return false;
	}	
	if (!ehNumero(f.num_domicio_n_possui_banheiro.value)) {
		alert("Valor inválido para número domicílios não possui banheiro!");
		f.num_domicio_n_possui_banheiro.focus();
		return false;
	}	
	if (!ehNumero(f.cnpj.value)) {
		alert("Valor inválido para CNPJ!");
		f.cnpj.focus();
		return false;
	}	
	if (!ehNumero(f.codigo_siafi.value)) {
		alert("Valor inválido para SIAFI!");
		f.codigo_siafi.focus();
		return false;
	}	
	return true;
}

function validaformulariocomunidade(f) {

	if (f.descricao.value.length < 2) {
	  	alert("Preencha a Descrição (nome da comunidade) com um mínimo de caracteres!");
	var nnumero = /[0-9]/;
	  	f.descricao.focus();
	  	return false;
	}
	if (f.numero_homens.value=="") {
		f.numero_homens.value=0;
	}	
	if (f.numero_mulheres.value=="") {
		f.numero_mulheres.value=0;
	}	
	if (f.numero_criancas.value=="") {
		f.numero_criancas.value=0;
	}	
	if (!ehNumero(f.numero_homens.value)) {
		alert("Valor inválido para numero de homens!");
		f.numero_homens.focus();
		return false;
	}
	if (!ehNumero(f.numero_mulheres.value)) {
		alert("Valor inválido para numero de mulheres!");
		f.numero_mulheres.focus();
		return false;
	}	
	if (!ehNumero(f.numero_criancas.value)) {
		alert("Valor inválido para numero de crianças!");
		f.numero_criancas.focus();
		return false;
	}	
	if (!ehNumero(f.casas_concentradas.value)) {
		alert("Valor inválido para número de casas concentradas!");
		f.casas_concentradas.focus();
		return false;
	}	
	if (!ehNumero(f.casas_dispersas.value)) {
		alert("Valor inválido para número de casas dispersas");
		f.casas_dispersas.focus();
		return false;
	}	
	if (!ehNumero(f.distanciaKMSede.value)) {
		alert("Valor inválido para distancia em KM à Sede!");
		f.distanciaKMSede.focus();
		return false;
	}	
	return true;
}

function validaformularioassociacao(f) {
	var nnumero = /[0-9]/;
	//alert(f.cnpj.value);
	if(!validarCNPJ(f.cnpj.value)) {
	  	alert("CNPJ Inválido!");
	 // 	f.cnpj.focus();
	 // 	return false;
	}	
	return true;
}	

function validaformulariocarta_consulta(f) {
	var nnumero = /[0-9]/;
	//alert(f.cnpj.value);
	if(!validarCNPJ(f.cnpj.value)) {
	  	alert("CNPJ Inválido!");
	 // 	f.cnpj.focus();
	 // 	return false;
	}	
	return true;
}	

function validaformularioplano_de_negocio(f) {
	var nnumero = /[0-9]/;
	//alert(f.cnpj.value);
	//if(!validarCPF(f.cpf.value)) {
	//  	alert("CPF Inválido!");
	//}	
	//if(!validarCNPJ(f.cnpj.value)) {
	//  	alert("CNPJ Inválido!");
	 // 	f.cnpj.focus();
	 // 	return false;
	//}	
	return true;
}	