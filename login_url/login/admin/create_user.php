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
 
 include("../codes.php");

/* Conecta ao MYSQL */
conect($host,$user,$pass);
 
 $user_db = $HTTP_POST_VARS["add_user"];
 $pass_db = $HTTP_POST_VARS["add_pass"];
 $url_db = $HTTP_POST_VARS["add_url"];
   
 $select = mysql_query("SELECT * FROM as_login_adm WHERE user='$user_db' AND pass='$pass_db'");
 
 if( $row = @mysql_fetch_array($select) ){
 $user_txt = $row['user'];
 print("O usu�rio <b>$user_txt</b> j� existe, tente cadastrar com outro nome");
 exit;
 }
 else{
 $insere = mysql_query("INSERT INTO as_login_db (user, pass, url) VALUES ('$user_db', '$pass_db', '$url_db') ") or die(mysql_error());
  
 print("<center><h2>Usu�rio cadastrado com sucesso!</h2></center>");
 exit;
 
 }

 
 ?>