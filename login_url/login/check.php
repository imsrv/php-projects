<?
/***************************************************************************
 *                                
 *   nome do script       : Login AS                
 *   por                  : Arthur Silva
 *   email                : arthursilva@planetstar.com.br
 *   copyright            : (C) 2003 Planet Star
 *   site					  : http://www.as.planetstar.com.br
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Este programa � livre; voc� pode redistribuir ou modificar
 *   esses s�o os termos do GNU General Public License que � uma publica��o da
 *   Funda��o Livre de Software
 *
 ***************************************************************************/
include("codes.php");

/* Conecta ao MYSQL */
conect($host,$user,$pass);

$user_db = $HTTP_POST_VARS["userlogin"];
$user_db = $HTTP_POST_VARS["userpass"];

$url_cmd = mysql_query("SELECT * FROM as_login_db WHERE user='$userlogin' and pass='$userpass' ");

if( $row = mysql_fetch_array($url_cmd)) {
  $url_db = $row['url'];
  header("Location: $url_db");
}
else {
  print("<script language='javascript'>window.alert('Login ou Senha inv�lido, tente novamente!')</script>");
  print("<br><br><br><center><h3>Volte e tente efetuar o login novamente</h3></center>");
} 