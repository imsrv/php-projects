<?
/***************************************************************************
 *                                
 *   nome do script       : Login AS                
 *   por                  : Arthur Silva
 *   email                : arthursilva@planetstar.com.br
 * 
 *   site					  : http://www.as.planetstar.com.br
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   Este programa щ livre; vocъ pode redistribuir ou modificar
 *   esses sуo os termos do GNU General Public License que щ uma publicaчуo da
 *   Fundaчуo Livre de Software
 *
 ***************************************************************************/
 include("../codes.php");

 conect($host,$user,$pass);
 
 $user_mysql = $HTTP_POST_VARS["user_mysql"];
 $pass_mysql = $HTTP_POST_VARS["pass_mysql"];
 $url_mysql = $HTTP_POST_VARS["url_mysql"];
 
 $select = mysql_query("SELECT * FROM as_login_db WHERE  user='$user_mysql'");
 
 if($row = mysql_fetch_array($select) ){
 $alter = mysql_query("UPDATE as_login_db SET user='$user_mysql', pass='$pass_mysql', url='$url_mysql' WHERE user='$user_mysql' ") or die("Este usuсrio nуo existe");
 print("Usuсrio alterado com sucesso!");
 }
 else{
 print("Desculpe, mas este usuсrio nуo existe");
 }
 
 ?>