<?
include "stl.php";
include "config.php";
?>
<html>

<title><? echo $tituloshz; ?></title>

<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">
<?
include "stl.php";
?>



<center><big><b>SHZ-Notícias v0.9b</b></big><br>
<img src='img/shz.gif'>
</center>
<hr>
<font color=<? echo $colortex; ?> size=<? echo $sizetex; ?>>Olá...<br>
Se você acabou de extrair o SHZ-Notícias do ZIP siga as instruções:<BR><BR>
<center>########################################-=Instalação=-#######################################<BR><BR></center>

Para instalar o SHZ-Notícias é necessário ter instalado:
<BR><BR>
Um servidor de Web com suporte a PHP 4<BR>
PHP 4<BR>
MySQL Server<BR><BR>

Abra um navegador de sua preferência e digite:<BR><BR>

http://endedreço_do_seu_site/pasta_onde_está_o_SHZ-Notícias/instalar/index.php
<BR><BR>
E siga as instruções.<BR>
Feito isso abra o arquivo config.php e configure seu usuario e senha
e também pode configurar o design do SHZ-Notícias para se adaptar ao seu site.
<BR><BR><BR>

<center>########################################-=Utilização=-#######################################</center>
<BR><BR>
Depois de instalado o sistema digite:<BR><BR>

http://endedreço_do_seu_site/pasta_onde_está_o_SHZ-Notícias/admin.php
<BR>
Nesse arquivo você poderá cadastrar alterar e incluir suas notícias.
<BR><BR><BR>
<center>########################################-=Publicação=-#######################################</center>
<BR><BR>
O arquivo que exibe as noticias cadastradas é "noticias.php".
<BR><BR>

Para publicar as notícias em seu site basta inserir o arquivo noticias.php, fazer um link
ou abrir o arquivo que está no seguinte endereço:
<BR><BR>
http://endereço_do_seu_site/pasta_onde_está_o_SHZ-Notícias/noticias.php
<BR><BR>
Uma boa idéia é fazer um include do noticias.php no seu site:<BR>
include "noticias.php";<BR>
Se o arquivo "noticias.php" não for ficar no diretório mesmo diretotio dos outros arquivos edite
a linha que contem:<BR>
include("config.php");<BR>
e acrescente o caminho para o diretório<BR>
Exemplo:<BR><BR>
include("teste/shznoticias/config.php");<BR>
obs. troque o caminho "teste/shznoticias/config.php" para o caminho que leva ao config.php.
<BR><BR>
<big><b>Depois de ter instalado o SHZ-Notícias, apague a pasta instalar.</b></big><BR><BR>
<center>############################################-=FIM=-###########################################</center>
<BR><BR>
Esse programa foi criado para ser um pequeno sistema de notícias para meu site.<br>
Como achei o desenvolvimento muito cansativo resolvi distribuir o que já tinha feito para
poupar tempo de outras pessoas, pois no meu ver é perca de vida criar algo já criado, o ideal
é utilizar recursos já disponíveis e gastar vida melhorando ou adaptando os recursos existentes.<BR>
Então eu me empolguei e lancei a versão 0.2 que era uma atualização relacionada a segurança.
Recebi muitos e-mails e graças aos meus votos, o SHZ-Notícias ficou entre os mais recomendados
na PHP Brasil www.phpbrasil.com.
O sistema é simples e sujeito a todo tipo de falha. Por isso me coloco a disposição para
qualquer problema ou duvida.
O desenvolvimento do SHZ Notícias é continuo porem lento já que estou sozinho no projeto e
tenho que trabalhar.<BR><BR>
David Fante
</font>
<br><br><br>
<center><img src='img/shz2.gif'><br>
<font size='1'>SHZ Solu&ccedil;&otilde;es e Tecnologias</font></center>
</body>
</html>
