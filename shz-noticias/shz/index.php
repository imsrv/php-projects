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



<center><big><b>SHZ-Not�cias v0.9b</b></big><br>
<img src='img/shz.gif'>
</center>
<hr>
<font color=<? echo $colortex; ?> size=<? echo $sizetex; ?>>Ol�...<br>
Se voc� acabou de extrair o SHZ-Not�cias do ZIP siga as instru��es:<BR><BR>
<center>########################################-=Instala��o=-#######################################<BR><BR></center>

Para instalar o SHZ-Not�cias � necess�rio ter instalado:
<BR><BR>
Um servidor de Web com suporte a PHP 4<BR>
PHP 4<BR>
MySQL Server<BR><BR>

Abra um navegador de sua prefer�ncia e digite:<BR><BR>

http://endedre�o_do_seu_site/pasta_onde_est�_o_SHZ-Not�cias/instalar/index.php
<BR><BR>
E siga as instru��es.<BR>
Feito isso abra o arquivo config.php e configure seu usuario e senha
e tamb�m pode configurar o design do SHZ-Not�cias para se adaptar ao seu site.
<BR><BR><BR>

<center>########################################-=Utiliza��o=-#######################################</center>
<BR><BR>
Depois de instalado o sistema digite:<BR><BR>

http://endedre�o_do_seu_site/pasta_onde_est�_o_SHZ-Not�cias/admin.php
<BR>
Nesse arquivo voc� poder� cadastrar alterar e incluir suas not�cias.
<BR><BR><BR>
<center>########################################-=Publica��o=-#######################################</center>
<BR><BR>
O arquivo que exibe as noticias cadastradas � "noticias.php".
<BR><BR>

Para publicar as not�cias em seu site basta inserir o arquivo noticias.php, fazer um link
ou abrir o arquivo que est� no seguinte endere�o:
<BR><BR>
http://endere�o_do_seu_site/pasta_onde_est�_o_SHZ-Not�cias/noticias.php
<BR><BR>
Uma boa id�ia � fazer um include do noticias.php no seu site:<BR>
include "noticias.php";<BR>
Se o arquivo "noticias.php" n�o for ficar no diret�rio mesmo diretotio dos outros arquivos edite
a linha que contem:<BR>
include("config.php");<BR>
e acrescente o caminho para o diret�rio<BR>
Exemplo:<BR><BR>
include("teste/shznoticias/config.php");<BR>
obs. troque o caminho "teste/shznoticias/config.php" para o caminho que leva ao config.php.
<BR><BR>
<big><b>Depois de ter instalado o SHZ-Not�cias, apague a pasta instalar.</b></big><BR><BR>
<center>############################################-=FIM=-###########################################</center>
<BR><BR>
Esse programa foi criado para ser um pequeno sistema de not�cias para meu site.<br>
Como achei o desenvolvimento muito cansativo resolvi distribuir o que j� tinha feito para
poupar tempo de outras pessoas, pois no meu ver � perca de vida criar algo j� criado, o ideal
� utilizar recursos j� dispon�veis e gastar vida melhorando ou adaptando os recursos existentes.<BR>
Ent�o eu me empolguei e lancei a vers�o 0.2 que era uma atualiza��o relacionada a seguran�a.
Recebi muitos e-mails e gra�as aos meus votos, o SHZ-Not�cias ficou entre os mais recomendados
na PHP Brasil www.phpbrasil.com.
O sistema � simples e sujeito a todo tipo de falha. Por isso me coloco a disposi��o para
qualquer problema ou duvida.
O desenvolvimento do SHZ Not�cias � continuo porem lento j� que estou sozinho no projeto e
tenho que trabalhar.<BR><BR>
David Fante
</font>
<br><br><br>
<center><img src='img/shz2.gif'><br>
<font size='1'>SHZ Solu&ccedil;&otilde;es e Tecnologias</font></center>
</body>
</html>
