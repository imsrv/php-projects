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
 ?>
 <link href="styles.css" rel="stylesheet" type="text/css">
 
 <font size="2" face="Hevetica, Arial">
 <br><br><br><center>
 <b>Adicionar usu�rio:</b><br><br><br>
 <form name="form" method="POST" action="create_user.php"> 
 Usu�rio:<br><input type="text" name="add_user" maxlength="20" value=""><br>
 Senha:<br><input type="text" name="add_pass" maxlength="20" value=""><br>
 Url:<br><input type="text" class="box" size="45" name="add_url" maxlength="60" value="http://"><br>
 <input type="submit" value="Cadastrar">
 </center>
 
 </font>