<?php
    $hello = 'ola,';
    $a = "texto1";
    $b = "texto2";
    $c = "texto3";
    
    $texto1 = "o prefixo $$, para quem conhece clipper ou advpl, ";
    $texto2 = "eh equivalente ao recurso de macro substituicao &(), ";
    
    $texto3 = "que interpreta o conteudo da string como uma variavel de memoria";
    
    echo $$a;
    echo "<p>";
    
    echo $$b;
    echo "<p>";

    echo $$c;
    echo "<p>";
	$v1=null;
	$v2=3;
?>
<div>
	<input type="checkbox" id="campo1" name="campo1" value="1" checked>
	<label for="campo1">Opção 1</label>	
	<input type="checkbox" id="campo2" name="campo2" value="2" >
	<label for="campo2">Opção 2</label>	
	<input type="checkbox" id="campo3" name="campo3" value="3" checked>
	<label for="campo3">Opção 3</label>	
</div>