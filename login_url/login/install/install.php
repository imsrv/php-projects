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

 /* Variaveis do formul�rio */
 $form_host = $HTTP_POST_VARS["form_host"];
 $form_user = $HTTP_POST_VARS["form_user"];
 $form_pass = $HTTP_POST_VARS["form_pass"];
 $form_db = $HTTP_POST_VARS["form_db"];
 

 
 /* Gera o arquivo de configura��o */
 $open = fopen("../config.php","w+") or die("Verifique se o arquivo .config existe");
$grava = fputs($open,"<?\n \t\t /* Configura��o do Login AS */ \n\n
\$host = \"$form_host\"; \n
\$user = \"$form_user\"; \n
\$pass = \"$form_pass\"; \n
\$db = \"$form_db\"; \n
?>") or die("Verifique se o arquivo .config tem permi��o 777");
fclose($open);
 
 ?>
<center> <h3> Parte 1 da instala��o feita com sucesso! </h3></center><br>
<p> Volte a tela anterior, para configurar o login e senha da administra��o... <p>

 
 
 