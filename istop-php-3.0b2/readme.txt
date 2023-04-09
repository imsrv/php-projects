##############################################################
##############################################################
##############################################################
#######                                                #######
#######             Iron Scripts Top Sites             #######
#######	             Vers�o PHP (3.0 Beta)             #######
#######                                                #######
##############################################################
##############################################################
##############################################################

- Pr� Requisitos
  1: Servidor rodando PHP 4.2+
  2: Biblioteca GD instalada no PHP
  3: Bando de Dados MySQL Vers�o 4.0+

- Procedimentos de Instala��o usando o Instalador (install.php):
  1: Transfira os arquivos para o servidor e d� chmod 777 nas pastas log e html
  2: Execute o instalador e siga todos os passos. Fique atento na execu��o do Passo 2, onde
     haver� uma tentativa de cria��o do banco de dados. Caso haja uma falha, retornar� no 
     passo 3 uma mensagem de erro. Se esta mensagem for retornada, certifique-se de que o
     banco de dados com o nome dado no passo 2 exista. Caso n�o exista, tente cri�-lo na
     administra��o de seu servidor e repita os passos de instala��o.
  
  Em caso de erro no processo de instala��o, desfa�a as altera��es e execute a instala��o manual

- Procedimentos de Instala��o Manual:
  1: Configure o arquivo "config.php" seguindo as intru��es neste arquivo
  2: Transfira os arquivos para o servidor
  3: D� chmod 777 nas pastas "log" e "html"
  4: Crie um novo banco de dados ou use um previamente criado no seu servidor mysql
  5: Execute o arquivo istop.sql no phpmyadmin de seu
     servidor ou no programa equivalente

- Altera��o do Layout:
  Todas as parte do script podem ter seu layout alterado. Os arquivos .htm est�o na pasta
  html. No entanto, alguns cuidados devem ser tomados:
  1: A maioria dos arquivos possui tags de identifica��o do php, que podem estar tanto vis�veis
     como n�o. Partes nestes arquivos como (banner), e <replace id="b"></replace> entre outras
     devem permanecer no mesmo lugar.
  2: Para que voc� n�o encontre nenhum problema com as imagens, crie uma pasta somente para estes
     arquivos dentro da pasta html. A pasta em que estas imagens forem colocadas deve ser corre-
     tamente configurada no arquivo config.php

- Selos
  Diferentemente das outras vers�es, os selos agora podem ser adicionardos pela administra��o. 
  Eles ficar�o armazenados na pasta html/imagens/selos. Para tanto, fa�a as configura��es neces-
  s�rias no config.php

Em Casos de D�vida:
Site: http://www.ironscripts.tk
E-Mail: suporte@ironscripts.tk

N�o remova nossa linha de copyright no final do Layout

Neste script utilizei alguns pacotes presentes no PEAR, como DB, HTML_QuickForm e HTML_Table.
Recomendo uso para todos os desenvolvedores PHP.

Site: http://pear.php.net

Agradecimentos Especiais:
WMClube: http://www.wmclube.net
Host Clube: http://www.hostclube.net
Web Ajuda: http://www.webajuda.com.br