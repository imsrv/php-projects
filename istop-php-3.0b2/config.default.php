<?
/////////////////// Configurações Básicas
define('ADMIN_USER','istop'); //Login da Administração
define('ADMIN_SENHA','senha');//Senha da Administração

define('HTTP_URL','http://www.top.com/'); //URL do topsites, utilize barra no final

define('DB_HOST','localhost') //servidor do mysql;
define('DB_USER','root'); // username do mysql
define('DB_PASS',''); // senha do mysql
define('DB_NAME','istop'); // nome do bando de dados

define('SITE_MAIL','top@top.com'); // e-mail

define('HTTP_SELOS','http://www.top.com/top/html/imagens/selos/'); //url da pasta de selos
/////////////////// Configurações Opcionais
define('PAGINA_RESULTADOS',10); // número de resultados por página

define('IMG_SELO','selo.gif'); //Utilize apenas o nome do arquivo

define('DIR_HTML','html/');
define('DIR_LOG','log/');
define('DIR_IMG','imagens'); // Esta pasta deve estar obrigatoriamente no diretório html. Somente para a configuração desta pasta, não termine com / o caminho. Mais informações consulte o "Alteração do Layout" no readme
define('DIR_SELOS','html/imagens/selos/');

define('HTTP_VOTAR',HTTP_URL.'votar.php');
define('HTTP_SUACONTA',HTTP_URL.'suaconta.php');
define('HTTP_INDEX',HTTP_URL.'index.php');
define('HTTP_CONTA',HTTP_URL.'conta.php');

define('HTML_LAYOUT',DIR_HTML.'index.htm');
define('HTML_RANK',DIR_HTML.'rank.htm');
define('HTML_RANKCATEGORIA',DIR_HTML.'rankcat.htm');
define('HTML_CADASTRO',DIR_HTML.'cadastro.htm');
define('HTML_CADASTRO_FINAL',DIR_HTML.'cadastrofinal.htm');
define('HTML_SUACONTA',DIR_HTML.'suaconta.htm');
define('HTML_CONTA',DIR_HTML.'conta.htm');
define('HTML_VOTAR',DIR_HTML.'votar.htm');
define('HTML_VOTARERRO',DIR_HTML.'votarerro.htm');
define('HTML_VOTARFINAL',DIR_HTML.'votarfinal.htm');
define('HTML_DADOSWEBSITE',DIR_HTML.'dadoswebsite.htm');
define('HTML_DADOSWEBSITE_FINAL',DIR_HTML.'dadoswebsitefinal.htm');
define('HTML_ALTSENHA',DIR_HTML.'altsenha.htm');
define('HTML_ALTSENHAFIM',DIR_HTML.'altsenhafim.htm');
define('HTML_RECUPERE',DIR_HTML.'recupere.htm');
define('HTML_RECUPEREMAIL',DIR_HTML.'recuperemail.htm');
define('HTML_RECUPEREFINAL',DIR_HTML.'recuperefinal.htm');
define('HTML_BUSCA',DIR_HTML.'busca.htm');
define('HTML_VENCEDORES',DIR_HTML.'vencedores.htm');
define('HTML_VENCEDORESMODELO',DIR_HTML.'vencedoresmodelo.htm');
define('HTML_SELOS',DIR_HTML.'selos.htm');
define('HTML_CODE',DIR_HTML.'code.htm');

require_once('funcoes.php');
?>