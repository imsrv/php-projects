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
 *   Este programa щ livre; vocъ pode redistribuir ou modificar
 *   esses sуo os termos do GNU General Public License que щ uma publicaчуo da
 *   Fundaчуo Livre de Software
 *
 ***************************************************************************/
 include("../config.php");

 global $db;
 $con = mysql_connect($host,$user,$pass) or die(mysql_error());
 $db = mysql_select_db($db) or die(mysql_error());
 
 $user_db = $HTTP_POST_VARS["user_form"];
 $pass_db = $HTTP_POST_VARS["pass_form"];
 
 $select = mysql_query("SELECT * FROM as_login_adm WHERE user='$user_db' AND pass='$pass_db' ");
 
 if( $linha = mysql_fetch_array($select) ){
 header("Location: menu.php");
 }
 else{
 print("Vocъ nуo tem permiчуo para acessar estс pсgina");
 exit;
 }
 ?>