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
 *   Este programa é livre; você pode redistribuir ou modificar
 *   esses são os termos do GNU General Public License que é uma publicação da
 *   Fundação Livre de Software
 *
 ***************************************************************************/
 include("../codes.php");

 conect($host,$user,$pass);
 
 $user_db = $HTTP_POST_VARS["user_form"];
 
 $select = mysql_query("SELECT * FROM as_login_db WHERE user='$user_db' ");
 

 print("<center><font face=Helvetica, Arial size=2>");
 print("<b>Configurações atuais:</b><br><br><br>");
 print("<form name=form method=POST action=alter_user_ok.php>");
 
 while($row = mysql_fetch_row($select) ){
 		print("Usuário:<br><input type=text name=\"user_mysql\" value=$row[0]><br><br>");
 		print("Senha:<br><input type=text name=\"pass_mysql\" value=$row[1]><br><br>");
 		print("Url:<br><input type=text name=\"url_mysql\" value=$row[2]><br><br>");
}
print("<input type=submit value=Modificar Usuário>");
print("</font>");
print("</form>");

