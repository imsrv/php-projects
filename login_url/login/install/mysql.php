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
 include("../config.php");
 
  /* Login e senha da administração */
 $form_user_adm = $HTTP_POST_VARS["form_user_adm"];
 $form_pass_adm = $HTTP_POST_VARS["form_pass_adm"];
 
 /* Conecta ao MYSQL e seleciona o banco de dados */
 global $db;
 $con = mysql_connect($host,$user,$pass) or die(mysql_error());
 $db = mysql_select_db($db) or die(mysql_error());
 
 /* Cria a tabela MYSQL */
 $cria[0] = mysql_query("CREATE TABLE as_login_db(
 user varchar(20) NOT NULL,
 pass varchar(20) NOT NULL,
 url varchar(60) NOT NULL,
 PRIMARY KEY(user,pass,url))") or die(mysql_error());
 
 $cria[1] = mysql_query("CREATE TABLE as_login_adm(
 user varchar(20) NOT NULL,
 pass varchar(20) NOT NULL,
 PRIMARY KEY(user,pass) )") or die(mysql_error());
 
 $insere = mysql_query("INSERT INTO as_login_adm (user, pass) VALUES ('$form_user_adm', '$form_pass_adm') ") or die(mysql_error());
 
 mysql_close($con);
 
 print("<br><br><center><h3>Tabelas instaladas com sucesso</h3></center>");
 ?>
 <br><br><br>
 <p align="center"> Para que você tenha uma melhor segurança é recomendavel deletar a pasta <b>install</b></p>