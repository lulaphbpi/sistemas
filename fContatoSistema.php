<?php
?>
<div class="areatrabalho">
    <div class="formularioEntrada">		<div class="heading-contact marginbot-50">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-md-offset-1">
						<div class="section-heading">
							<br><br><br>
							<h2>Contato</h2>
							<p><strong>Informe seu nome, e-mail, selecione o assunto e envie sua mensagem, utilizando o formulário abaixo</strong></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-offset-1">
					<div class="boxed-grey">
						<form id="contact-form" method="post" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">
										Nome</label>
										<input type="text" class="form-control" name="nome" id="name" placeholder="Nome" required="required" />
									</div>
									<div class="form-group">
										<label for="email">
										E-mail</label>
										<div class="input-group">
											<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
											</span>
											<input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required="required" />
										</div>
									</div>
									<div class="form-group">
										<label for="subject">
										Assunto</label>
										<select id="subject" name="subject" class="form-control" required="required">
											<option value="na" selected="">Clique e Selecione:</option>
											<option value="Duvida">Dúvida</option>
											<option value="Reclamacao">Reclamação</option>		
											<option value="Sugestao">Sugestão</option>
											<option value="Outro Assunto">Outro Assunto</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">
										Mensagem</label>
										<textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
										placeholder="Digite aqui sua Mensagem"></textarea>
									</div>
								</div>
								<div class="col-md-12">	
									<button type="submit" class="btn btn-skin pull-right" id="btnContactUs">
									Envia Mensagem</button>
								</div>
							</div>
						</form>
					</div>
					<div class="widget-contact row">
						<div class="col-lg-6">
							<address>
								<h5><strong>Universidade Federal do Delta do Parnaíba</strong></h5>
								<h6>CNPJ - 06.517.387/0001-34 </h6>
								<h7><strong>Núcleo de Tecnologia da Informação – NTI</strong></h7><br><br>
								AV SÃO SEBASTIÃO, Nº 2819 – Bairro Reis Velloso <br>	
								Parnaíba - PI, 64.202-020<br>
								<abbr title="Fone">P:</abbr> (86)....-.... - Fax (86)....-....
								<p style="font-size:10px; line-height:150%; margin:10px 0; padding:0;">
							</address>
						</div>
						<div class="col-lg-6">
							<address>
								<strong>Email</strong><br>
								<a href="mailto:#">rede@rededesistemas.com.br</a><br />
							</address>	
						</div>
					</div>	
				</div>
			</div>	
		</div>
	</section>
	<!-- /Section: contact -->

	<div id="rodp">
		<div id="r1" class="col-md-12 col-lg-12">
		</div>
	</div>

	</div>
</div>
