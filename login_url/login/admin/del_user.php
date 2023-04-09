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
 *   Este programa é livre; você pode redistribuir ou modificar
 *   esses são os termos do GNU General Public License que é uma publicação da
 *   Fundação Livre de Software
 *
 ***************************************************************************/

 include("../codes.php");

 conect($host,$user,$pass);
 
 /* Pega a variavel do formulario */
 $user_db = $HTTP_POST_VARS["user_form"];
 $pass_db = $HTTP_POST_VARS["pass_form"];
 
 /* Seleciona a tabela */
 $select = mysql_query("SELECT * FROM as_login_db WHERE user='$user_db' AND pass='$pass_db' ");
 
 if( $row = mysql_fetch_array($select) ){
 
 /* Deleta os campos de login,senha e url */
 mysql_query("DELETE FROM as_login_db WHERE user='$user_db' AND pass='$pass_db' ");
 print("<br><br><center>Usuário deletado com sucesso</center>");
 }
 else {
 print("<br><br><center>Este usuário não existe</center>");
 }
 
 exit;
 
 