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

 /* Variaveis do formulário */
 $form_host = $HTTP_POST_VARS["form_host"];
 $form_user = $HTTP_POST_VARS["form_user"];
 $form_pass = $HTTP_POST_VARS["form_pass"];
 $form_db = $HTTP_POST_VARS["form_db"];
 

 
 /* Gera o arquivo de configuração */
 $open = fopen("../config.php","w+") or die("Verifique se o arquivo .config existe");
$grava = fputs($open,"<?\n \t\t /* Configuração do Login AS */ \n\n
\$host = \"$form_host\"; \n
\$user = \"$form_user\"; \n
\$pass = \"$form_pass\"; \n
\$db = \"$form_db\"; \n
?>") or die("Verifique se o arquivo .config tem permição 777");
fclose($open);
 
 ?>
<center> <h3> Parte 1 da instalação feita com sucesso! </h3></center><br>
<p> Volte a tela anterior, para configurar o login e senha da administração... <p>

 
 
 