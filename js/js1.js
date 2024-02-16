
window.onload = function() {
	
    var minutesToLogout = 5 * 60 * 1000; // Configure o tempo que achar melhor
    var logoutUrl = 'index.php'; // Configure a URL de logout

    var lastModified = Date.now();
    var html = document.getElementsByTagName('html')[0];
    var setLastModified = function(){lastModified = Date.now();}

    html.onmousemove = setLastModified;
    html.onkeypress = setLastModified;

// timeout inativo, descomente para ativar
/*    var logoutFunction = function(){
        var timeDiff = Date.now() - lastModified;
        if(timeDiff > minutesToLogout)
            document.location = logoutUrl;
        else
            setTimeout(logoutFunction, minutesToLogout - timeDiff);
    }
    setTimeout(logoutFunction, minutesToLogout); 
*/
	//alert("Inicio 1");
	
	var vbuttonsubmit = document.getElementById("buttonSubmit");
	if(vbuttonsubmit){ 
	//	alert("Vai esconder");
		escondeId("buttonSubmit");
	}
	
	var vlabelsubmit = document.getElementById("labelSubmit");
	if(vlabelsubmit){ 
		vlabelsubmit.onclick = function (){
			//alert("Vai mostrar button");
			mostraId("buttonSubmit");
			//alert("Vai esconder label");
			escondeId("labelSubmit");
		}
	} 
	
	var vbuttonsubmit = document.getElementById("buttonSubmit");
	if(vbuttonsubmit){ 
	//	alert("Vai esconder");
		vbuttonsubmit.onclick = function (){
			//alert("Vai mostrar");
			mostraId("labelSubmit");
			escondeId("buttonSubmit");
		}
	}

	var lblerro = document.getElementById("lblerro");
	if(lblerro) {
		if(lblerro.innerHTML == '' || lblerro.innerHTML == null || lblerro.innerHTML == undefined){
		//	alert("lblerro nulo");
			escondeId("lblerro");
		}else{
		//	alert("lblerro:");
			mostraId("lblerro");
		}
		if(flagdemensagem(lblerro.innerHTML)=='0'){
		//	alert("lblerro backgroundColor fff");
			lblerro.style.backgroundColor = '#fff';
		}
	}

	
/*	var respostaphp='';
	var vphp = document.getElementById("hrefsn");
	if(vphp){
		vphp.onclick = function () {
			respostaphp=prompt ("Tecle S para confirmar excluir este registro");
		)
	}
*/	
	var bt0 = document.getElementById("ibotao");  // formulário sem campo input
	if(bt0){ 
		bt0.onclick = function (){
			var form = document.getElementById("iformulario");
			form.submit();
		}
	} 
	
	var bt0 = document.getElementById("ibotaologin");
	if(bt0){ 
		bt0.onclick = function (){
			var formlog = document.getElementById("formulariologin");
			formlog.submit();
		}
		var sen = document.getElementById("senha");
		if(sen) {
			sen.onkeyup=function(e){
				if(e.which == 13){
					var formlog = document.getElementById("formulariologin");
					formlog.submit();
				}

			}
		}
		sen.onblur = function (){
			var formlog = document.getElementById("formulariologin");
			formlog.submit();
		}
	} 
	
	var bt0 = document.getElementById("ibformulario");
	if(bt0){
		bt0.onclick = function () {
			var form = document.getElementById("iformulario");
			form.submit();
		}
	}

	var bt0 = document.getElementById("ibformulariop1");
	if(bt0){
		//alert('aqui');
		bt0.onclick = function () { 
			var form = document.getElementById("iformulario");
			if(form){
				var resp=validarCadastro(form);
				if (resp=="") {
					form.submit();
				}else{
					var lblerro1 = document.getElementById("lblerro");
					if(lblerro1) {
						//alert('Invalidou');
						lblerro1.innerHTML="Erro: "+resp;
						mostraId("lblerro");
					}	
				}
			}
		}	
	}

	var bt0 = document.getElementById("ibformulariop2");
	if(bt0){
		//alert('aqui');
		bt0.onclick = function () { 
			var form = document.getElementById("iformulario");
			if(form){
				var resp=validarCadastro2(form);
				if (resp=="") {
					form.submit();
				}else{
					var lblerro1 = document.getElementById("lblerro");
					if(lblerro1) {
						//alert('Invalidou');
						lblerro1.innerHTML="Erro: "+resp;
						mostraId("lblerro");
					}	
				}
			}
		}	
	}


}

		function piscar(){
			var f=document.getElementById("piscante");
			setInterval(function(){
				f.style.visibility=(f.style.visibility=='hidden'?'':'hidden');
			}, 1000);
			return "";
		}	


function validarCadastro2(f){
	//alert('inicio validarcadastro2');
	if (f.nomemae.value.length < 5) {
	  	f.nomemae.focus();
	  	return "Preencha o campo Nome da Mãe com um mínimo de caracteres!";
	}
	//alert('validarcadastro2 2');
	if (f.cor_id.value==0) {
	  	f.cor_id.focus();
	  	return "Selecione a Cor adequada!";
	}
	if (!validarCNS(f.cartaosus.value)) {
		if(f.cartaosus.value==''){ return '';}
	  	f.cartaosus.focus();
	  	return "Informe corretamente o Número do seu Cartão Nacional de Saúde";
	}	
	//alert('validarcadastro2 3');
//	if (f.altura.value<0.4 || f.altura.value>2.5) {
//	  	f.altura.focus();
//	  	return "Valor fora dos limites aceitáveis!";
//	}
	//alert('validarcadastro2 4');
//	if (f.peso.value<4 || f.peso.value>350) {
//	  	f.peso.focus();
//	  	return "Valor fora dos limites aceitáveis!";
//	}
	//alert('fim validarcadastro2');
	return "";
}
	
function validarCadastro(f){
	if(!trim(f.cpf.value)==''){
		if (!validarCPF(f.cpf.value)) {
			f.cpf.focus();
			return "CPF inválido!";
		}	
	}
	if (f.formacaoprofissional_id==0) {
	  	f.formacaoprofissional_id.focus();
	  	return "Selecione a Categoria Profissional adequada!";
	}
	if (f.tipodevinculo_id==0) {
	  	f.tipodevinculo_id.focus();
	  	return "Selecione o Tipo de Vínculo adequado!";
	}
	if (f.matricula.value.length == 0) {
	}
	if (f.apelido.value.length < 2) {
	  //	f.apelido.focus();
	  //	return "Apelido (alcunha) deve ter pelo menos 2 caracteres!";
	}
	if (f.nome.value.length < 10) {
	  	f.nome.focus();
	  	return "Preencha o campo Nome Completo com um mínimo de caracteres!";
	}
	if (!validaData(f.datanascimento.value)) {
	  	f.datanascimento.focus();
	  	return "Informe corretamente a Data de Nascimento no formato dd/mm/aaaa!";
	}
	if (f.fone.value.length < 8) {
	  	f.fone.focus();
	  	return "Preencha o campo Fone com um mínimo de caracteres!";
	}
	if (!validarEmail(f.email.value)) {
	  	// f.email.focus();
	  	// return "O campo Email está com um formato inválido!";
	}
	if (!validaData(f.datanascimento.value)) {
	  	f.datanascimento.focus();
	  	return "Informe corretamente a Data de Nascimento no formato dd/mm/aaaa!";
	}
	if (!(f.sexo[0].checked || f.sexo[1].checked)) {
	  	f.sexo[0].focus();
	  	return "Selecione o Sexo!";
	}
	if (f.rg.value.length < 3) {
	  	//f.rg.focus();
	  	//return "Preencha o campo RG com um mínimo de caracteres!";
	}
	if (f.expedidorrg_id.value < 1) {
	  	//f.expedidorrg_id.focus();
	  	//return "Selecione o Orgão Expedidor RG!";
	}
	return "";
}
	

function stringParaData(str) {
	//alert(str);
	parts = str.split('/');
	//alert(parts[2]);
    year = parseInt(parts[2], 10);
    month = parseInt(parts[1], 10)-1;
    day = parseInt(parts[0], 10);
	alert("ano mes dia "+year+" "+month+" "+day);
    data = new Date(year, month, day);
	alert("data... ");
	alert (data);
	return data;
}
	
function escondeId(id) {
    var x = document.getElementById(id);
    x.style.display = "none";
}

function mostraId(id) {
    var x = document.getElementById(id);
    x.style.display = "block";
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
//alert(cpf);
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

function validaData(valor) {
	var date=valor;
	var ardt=new Array;
	var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
	ardt=date.split("/");
	erro=false;
	if(valor.length < 1) {
		return false;
	}
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
/*
function IsEmail(email){  // não deu certo
    var exclude=/[^@-.w]|^[_@.-]|[._-]{2}|[@.]{2}|(@)[^@]*1/;
    var check=/@[w-]+./;
    var checkend=/.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    else {return true;}
}
*/
function validarEmail(email){
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if(filter.test(email))
      return true;
    else{
      return false;
    }
}

function flagdemensagem(msg){
	var flag='';
	if(msg.length>0){
		flag=Left(msg,1);
	}
	return flag;
}

function mensagemdeflag(msg){
	var smsg='';
	if(msg.length>0){
		smsg=Right(msg,msg.length-1);
	}
	return smsg;
}

function Left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}
function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

function formataDataAtual() {
	var data = new Date();
    var dia = data.getDate();
    if (dia.toString().length == 1)
      dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
      mes = "0"+mes;
    var ano = data.getFullYear();  
    return ano+'-'+mes+"-"+dia;
}

function fMostraUsuario(pnom){
	alert (pnom);
}

//trim completo
function trim(str) {
return str.replace(/^\s+|\s+$/g,"");
}
 
//left trim
function ltrim(str) {
return str.replace(/^\s+/,"");
}
 
//right trim
function rtrim(str) {
return str.replace(/\s+$/,"");
}

function validarCNS(cns) {
  var numero = cns;
  return validaCNS_PROV(numero);
}

function validaCNS_PERM(vlrCNS) {
  // FormulÃ¡rio que contem o campo CNS
  var soma = new Number;
  var resto = new Number;
  var dv = new Number;
  var pis = new String;
  var resultado = new String;

  pis = vlrCNS.substring(0, 11);
  soma = (((Number(pis.substring(0, 1))) * 15) +
  ((Number(pis.substring(1, 2))) * 14) +
  ((Number(pis.substring(2, 3))) * 13) +
  ((Number(pis.substring(3, 4))) * 12) +
  ((Number(pis.substring(4, 5))) * 11) +
  ((Number(pis.substring(5, 6))) * 10) +
  ((Number(pis.substring(6, 7))) * 9) +
  ((Number(pis.substring(7, 8))) * 8) +
  ((Number(pis.substring(8, 9))) * 7) +
  ((Number(pis.substring(9, 10))) * 6) +
  ((Number(pis.substring(10, 11))) * 5));
  resto = soma % 11;
  dv = 11 - resto;
  if (dv == 11) {
  dv = 0;
  }
  if (dv == 10) {
  soma = (((Number(pis.substring(0, 1))) * 15) +
  ((Number(pis.substring(1, 2))) * 14) +
  ((Number(pis.substring(2, 3))) * 13) +
  ((Number(pis.substring(3, 4))) * 12) +
  ((Number(pis.substring(4, 5))) * 11) +
  ((Number(pis.substring(5, 6))) * 10) +
  ((Number(pis.substring(6, 7))) * 9) +
  ((Number(pis.substring(7, 8))) * 8) +
  ((Number(pis.substring(8, 9))) * 7) +
  ((Number(pis.substring(9, 10))) * 6) +
  ((Number(pis.substring(10, 11))) * 5) + 2);
  resto = soma % 11;
  dv = 11 - resto;
  resultado = pis + "001" + String(dv);
  } else {
  resultado = pis + "000" + String(dv);
  }
  if (vlrCNS != resultado) {
  //ValidaCNS_PROV(vlrCNS);
	return false;
  } else {
	return true;
  }
}


function validaCNS_PROV(Obj) {

  var tamCNS = Obj.length;

  if ((tamCNS) == 0) {
  return false;
  }

  if ((tamCNS) != 15) {
  //alert("N\u00famero de CNS Inv\u00e1lido");
  //alert("N\u00famero de CNS Incorreto");
  return false;
  }


  var pis;
  var resto;
  var dv;
  var soma;
  var resultado;
  var result;
  result = 0;

  pis = Obj.substring(0, 15);

  if (pis == "") {
  return false;
  }

  if ((Obj.substring(0, 1) != "7") && (Obj.substring(0, 1) != "8") && (Obj.substring(0, 1) != "9")) {
  ////alert("N\u00famero Provis\u00f3rio Inv\u00e1lido!");
  //alert("N\u00famero de CNS Provis\u00f3rio Inv\u00e1lido");
  return validaCNS_PERM(Obj);
  }

  soma = ((parseInt(pis.substring(0, 1), 10)) * 15)
  + ((parseInt(pis.substring(1, 2), 10)) * 14)
  + ((parseInt(pis.substring(2, 3), 10)) * 13)
  + ((parseInt(pis.substring(3, 4), 10)) * 12)
  + ((parseInt(pis.substring(4, 5), 10)) * 11)
  + ((parseInt(pis.substring(5, 6), 10)) * 10)
  + ((parseInt(pis.substring(6, 7), 10)) * 9)
  + ((parseInt(pis.substring(7, 8), 10)) * 8)
  + ((parseInt(pis.substring(8, 9), 10)) * 7)
  + ((parseInt(pis.substring(9, 10), 10)) * 6)
  + ((parseInt(pis.substring(10, 11), 10)) * 5)
  + ((parseInt(pis.substring(11, 12), 10)) * 4)
  + ((parseInt(pis.substring(12, 13), 10)) * 3)
  + ((parseInt(pis.substring(13, 14), 10)) * 2)
  + ((parseInt(pis.substring(14, 15), 10)) * 1);

  resto = soma % 11;

  if (resto == 0) {
	return true;
  }
  else {
  ////alert("N\u00famero Provis\u00f3rio Inv\u00e1lido!");
  //alert("N\u00famero de CNS Provis\u00f3rio Inv\u00e1lido");
	return (validaCNS_PERM(Obj));
  }
}
