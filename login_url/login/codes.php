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
 include("config.php");
 
 /* Conecta ao MYSQL */
 
 function conect($host,$user,$pass){
 global $db;
 $con = mysql_connect($host,$user,$pass) or die(mysql_error());
 $db = mysql_select_db($db) or die(mysql_error());
 }
 
 