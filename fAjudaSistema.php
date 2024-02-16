<?php
if(!isset($_SESSION)){session_start();}

$mensagem="TESte teSte testE teste TESTE TESTe" ;
if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	if($msg<>"") {
		$mensagem="Mensagem: ".$msg;
	}
}
?>

<div class="areatrabalho">
    <div class="formularioEntrada">

<div id="formularioerro" style="font-size:8px">
	<table>
		<tr>
			<td width="35%" valign="top" margin-top="0">
					<h5><strong>AJUDA</strong></h5>
					<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">Sistema de Gerenciamento de Projetos
</p>					
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">Este é um sistema concebido para facilitar o gerenciamento de projetos, especificamente do "Mais Viver Semiárido".
</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
As operações desse sistema se resumem em ingressar dados, alterar dados, exibir e imprimir informações geradas a partir dos dados ingressados.
</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
Cada tipo de dados ingressado representa um objeto real ou um objeto abstrato. Definiremos um objeto real aquele que representa uma entidade física do mundo real como, por exemplo, uma pessoa física. Um objeto abstrato, por outro lado, representa um elemento lógico que deverá sempre estar associado a um objeto real como, por exemplo, um endereço.
</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
A organização lógica deste sistema agrupa suas operações em módulos denominados menus e submenus. A interface padrão (primeira página exibível) desse sistema possui dois menus, sendo um denominado Menu Padrão e o outro denominado Menu Principal. </p>
					<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">O Menu Padrão é um menu horizontal que qualquer visitante poderá operar, de modo que dele obterá informações básicas de como operar o sistema e suas formas de contato.

O Menu Principal é o menu de operação do sistema que poderá ser disponibilizado apenas por usuários autorizados através de login, informando identificação e senha. Após o correto login, este menu é disponibilizado verticalmente à esquerda da página principal de acesso.

Qualquer que seja o menu, acioná-lo, significa, no modo mais simples, apontar o mouse nele e clicar com o botão direito do mesmo.
</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
Quando um menu é acionado poderá ocorrer o surgimento de um submenu, correspondente ao item clicado, ou surgirá uma nova interface (ou página) de operação.
Cada interface contém elementos para ingresso (digitação) de dados, para seleção de dados, e botões de operação para o processamento correto dos dados ingressados, e/ou links para chamadas de outras interfaces. 
</p>
			</td>
			<td width="5%">&nbsp;
			</td>
			<td width="25%" valign="top" margin-top="0">
					<h5><strong>Copie o conteúdo desta página para seu editor preferido para que possa ler confortavelmente</strong></h5><br>
					<h6><strong></strong></h6>
					<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
A primeira página de um módulo geralmente contém um botão Novo, para inclusão de um novo registro, e um campo de edição para pesquisar registros pertinentes no banco de dados. Se não for 
digitado nada serão exibidos (se existirem) os primeiros 25 registros.</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;"> A pesquisa deve ser feita através da inserção dos controles %%; exemplificando, no menu cadastro, módulo pessoa física, digite no campo Localize o texto %carlos% e clique no 
botão Consultar. Surgirá uma lista de pessoas contendo o nome CARLOS. Clicando num dos números à esquerda na coluna Id, será 
aberto o diálogo para edição da pessoa física correspondente. Se você consultar por %alberto carlos%, imediatamente o registro da 
pessoa física correspondente será aberto, pois apenas 1 registro com esse nome existe, não sendo necessário listar.
</p>
<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
Muitos nomes aparecerão com caracteres estranhos. Isto pelo fato de terem sido importados de um banco de dados com uma formatação 
de acentuação diferente. Os ingressos nesse sistema deverão corrigir essa acentuação, a medida que os operadores forem 
incluindo e/ou alterando dados. O identificador padrão de uma pessoa física é seu CPF e o de uma pessoa jurídica é o CNPJ. Qualquer pessoa deverá ter esse número 
disponível para inclusão, consulta e/ou alteração.</p>

			</td>
			<td width="5%">&nbsp;
			</td>
			<td width="30%" valign="top">
<h5><strong>Universidade Federal do Delta do Parnaíba</strong></h5>
					<h6>CNPJ - 06.517.387/0001-34 </h6>
					<h7><strong>Núcleo de Tecnologia da Informação – NTI</strong></h7><br><br>
					AV SÃO SEBASTIÃO, Nº 2819 – Bairro Reis Velloso <br>	
					Parnaíba - PI, 64.202-020<br>
					<abbr title="Fone">P:</abbr> (86)....-.... - Fax (86)....-....
					<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
Será implementado um módulo de Mensagens para:

1. Usuários cadastrados comunicarem entre si
2. Sugestões, registros de falhas, etc possam ser encaminhadas 

para este desenvolvedor
3. Mensagens quaisquer

Para efeito de iniciação às operações de teste, cada usuário 

utilizará o sistema se logando sem necessidade de identificação e 

senha, e caso julgue necessário, favor enviar mensagem para o 

Destinatário Luiz Carlos Moraes de Brito.

Para entrar no sistema basta clicar no botão Entrar posicionado 

na barra superior da tela, lado direito.

Navegue amplamente pelo sistema e informe suas considerações.

Vários módulos estão disabilitados por não estarem concluídos, 

mas a medida que forem terminados, serão disponibilizados.</p>
	                <div class="thumbnail">
						<img src="../include/img/logoufdpar.png" alt="">
					</div>
            </td>
		</tr>
	</table>
</div>
</div>
    </div>
