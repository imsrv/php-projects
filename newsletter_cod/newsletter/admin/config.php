<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */

# Em Caso de DUVIDAS consulte o arquivo LEIA-ME.html
# Seus dados
$site = 'http://www.seusite.com.br'; // coloque ao lado seu site


# Configuracoes de banco de dados
$host ="localhost"; // Host valor padrao é localhost
$usuariodb="Seu_usuario_DB"; //Usuario de Conexao com  o MySQL
$senhadb="Sua_senha_DB"; // Senha de Conexao com o MySQL
$db="nome_do_seu_DB"; //Banco de Dados MySQL


# Tableas NAO ALTERE
$tb1="usuarios";
$tb2="controle";
$tb3="emails";



# Configurações do Remetente e e-mail admin
$autor_email = "Nome do seu site"; // Nome do site
$email_admin = "Seuemail@provedor.com.br"; // E-mail de contato




# Nao alterar nada abaixo
$conexao=mysql_connect ("$host", "$usuariodb", "$senhadb") or die ('Não foi possivel conectar com o usuario: ' . mysql_error());
mysql_select_db ("$db") or die("não foi possivel");
?> 
