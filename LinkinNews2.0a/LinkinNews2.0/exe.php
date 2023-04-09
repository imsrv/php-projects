<?
###########################################
#       Sistema Criado e Desenvolvido     #
#          Igor Carvalho de Escobar       #
#                LK Design©               #
#  http://igorescobar.webtutoriais.com.br #
#      Suporte em:                        #
#      http://forum.webtutoriais.com.br   #
#      Por favor, Mantenham os Créditos   #
###########################################
?>
<?
echo "<img src=images/top_logo.gif width=200 height=50> <br><font face=verdana size=2>";
include "includes/config.php";
include "LKn_funcs.php";
conexao($host_db,$usuario_db,$senha_db,$BancoDeDados);
// instalando
// Tabela Admin
$sql = mysql_query("CREATE TABLE lkn_admin (id INT (10) DEFAULT '0' AUTO_INCREMENT, usuario VARCHAR (8) DEFAULT '0' NOT NULL, senha VARCHAR (8) DEFAULT '0' NOT NULL, PRIMARY KEY(id,usuario))  TYPE = MyISAM");
$sql = mysql_query("CREATE TABLE lkn_coments (id INT (255) UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT, noticia_id INT (255), nome VARCHAR (50) NOT NULL, comentario TEXT NOT NULL, data VARCHAR (25) NOT NULL, hora VARCHAR (25) NOT NULL, PRIMARY KEY(id))  TYPE = MyISAM");
$sql = mysql_query("CREATE TABLE lkn_configs (template TEXT NOT NULL)  TYPE = MyISAM");
$sql = mysql_query("ALTER TABLE lkn_configs ADD desej_coment INT(1)  DEFAULT '0' NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_configs ADD noti_por_pagina INT(5) DEFAULT \"8\" NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_configs ADD type_paginacao INT DEFAULT '1' NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_configs ADD url_admin VARCHAR(255)  NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_configs DROP window_xy");
$sql = mysql_query("ALTER TABLE lkn_configs DROP type_paginacao");
$sql = mysql_query("ALTER TABLE lkn_configs DROP noti_por_pagina");
$sql = mysql_query("ALTER TABLE lkn_configs DROP desej_coment");
$sql = mysql_query("ALTER TABLE lkn_configs DROP type_paginacao");
$sql = mysql_query("ALTER TABLE lkn_configs DROP template");
$sql = mysql_query("CREATE TABLE lkn_noticias (id INT (255) UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT, noticia TEXT NOT NULL, data VARCHAR (25) NOT NULL, hora VARCHAR (25) NOT NULL, autor VARCHAR (8) NOT NULL, views INT (255) UNSIGNED DEFAULT '0', PRIMARY KEY(id))  TYPE = MyISAM");
$sql = mysql_query("ALTER TABLE lkn_noticias ADD titulo VARCHAR(255)  NOT NULL AFTER id");
$sql = mysql_query("ALTER TABLE lkn_noticias ADD data_op VARCHAR(50)  NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_noticias ADD hora_op VARCHAR(50)  NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_noticias ADD hora_marcada INT(0)  NOT NULL");
$sql = mysql_query("ALTER TABLE lkn_noticias ADD area VARCHAR(255)  NOT NULL");
$sql = mysql_query("CREATE TABLE lkn_templates (id INT (255) DEFAULT '0' NOT NULL AUTO_INCREMENT, template TEXT, area VARCHAR (255), desej_coment INT (1) UNSIGNED DEFAULT '0', noticias_por_pagina INT (10) NOT NULL, UNIQUE(id))");
$sql = mysql_query("ALTER TABLE lkn_templates CHANGE area Template_name VARCHAR(255)");
$sql = mysql_query("ALTER TABLE lkn_templates DROP noticias_por_pagina");
$sql = mysql_query("ALTER TABLE lkn_templates DROP desej_coment");
$sql = mysql_query("CREATE TABLE lkn_zonas (id INT (3) DEFAULT '0' NOT NULL AUTO_INCREMENT, area VARCHAR (255) DEFAULT '0', UNIQUE(id))");
$sql = mysql_query("ALTER TABLE lkn_coments ADD ip VARCHAR(255)  NOT NULL");
$sql = mysql_query("ALTER TABLE `lkn_configs` ADD `preview` TEXT NOT NULL");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$url_admin = $_POST['url_admin'];
$sql = mysql_query("INSERT INTO lkn_admin (usuario,senha) VALUES ('$usuario','$senha')") or die (mysql_error());
$sql = mysql_query("INSERT INTO lkn_configs (url_admin) VALUES ('$url_admin')") or die (mysql_error());

if($sql){
echo "Instalação Concluida.<BR>Todas as tabelas foram criadas corretamente<BR><b>Atenção:</b>
Antes de Adicionar QUALQUER NOTICIA 1º crie uma template e depois Crie uma area. <a href=login.php>Clique aqui para logar</a>";
echo "<script>
window.open('".$url_admin."http://igorescobar.webtutoriais.com.br/contador.php?url=$url_admin','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=200');
</script>";
}
?>
