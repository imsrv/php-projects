<?
$ip	= getenv ("REMOTE_ADDR");//IP do usuario
$ip = str_replace(".", "", $ip);

if($arquivo == "none")
{
	print "Arquivo não enviado, possíveis problemas:<br>";
    print "1. O arquivo tem tamanho nulo. <br>2. O arquivo pode estar grande demais (10 MB são suportados).";
    print "3. Você não informou o arquivo na tela anterior. Caso afirmativo volte e selecione o arquivo!<br>";
	print "<a href=\"#\" onClick=\"history.go(-1)\" class=link>voltar</a>";
}

else
{
	copy("$arquivo", "../caretas/$ip.gif");
	unlink($arquivo);
}
?>
<script>history.go(-1);</script>