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
 include("config.php");
 
 /* Conecta ao MYSQL */
 
 function conect($host,$user,$pass){
 global $db;
 $con = mysql_connect($host,$user,$pass) or die(mysql_error());
 $db = mysql_select_db($db) or die(mysql_error());
 }
 
 