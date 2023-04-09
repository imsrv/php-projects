##############################################################
##############################################################
##############################################################
#######                                                #######
#######             Iron Scripts Top Sites             #######
#######	             Versão PHP (3.0 Beta)             #######
#######                                                #######
##############################################################
##############################################################
##############################################################

- Pré Requisitos
  1: Servidor rodando PHP 4.2+
  2: Biblioteca GD instalada no PHP
  3: Bando de Dados MySQL Versão 4.0+

- Procedimentos de Instalação usando o Instalador (install.php):
  1: Transfira os arquivos para o servidor e dê chmod 777 nas pastas log e html
  2: Execute o instalador e siga todos os passos. Fique atento na execução do Passo 2, onde
     haverá uma tentativa de criação do banco de dados. Caso haja uma falha, retornará no 
     passo 3 uma mensagem de erro. Se esta mensagem for retornada, certifique-se de que o
     banco de dados com o nome dado no passo 2 exista. Caso não exista, tente criá-lo na
     administração de seu servidor e repita os passos de instalação.
  
  Em caso de erro no processo de instalação, desfaça as alterações e execute a instalação manual

- Procedimentos de Instalação Manual:
  1: Configure o arquivo "config.php" seguindo as intruções neste arquivo
  2: Transfira os arquivos para o servidor
  3: Dê chmod 777 nas pastas "log" e "html"
  4: Crie um novo banco de dados ou use um previamente criado no seu servidor mysql
  5: Execute o arquivo istop.sql no phpmyadmin de seu
     servidor ou no programa equivalente

- Alteração do Layout:
  Todas as parte do script podem ter seu layout alterado. Os arquivos .htm estão na pasta
  html. No entanto, alguns cuidados devem ser tomados:
  1: A maioria dos arquivos possui tags de identificação do php, que podem estar tanto visíveis
     como não. Partes nestes arquivos como (banner), e <replace id="b"></replace> entre outras
     devem permanecer no mesmo lugar.
  2: Para que você não encontre nenhum problema com as imagens, crie uma pasta somente para estes
     arquivos dentro da pasta html. A pasta em que estas imagens forem colocadas deve ser corre-
     tamente configurada no arquivo config.php

- Selos
  Diferentemente das outras versões, os selos agora podem ser adicionardos pela administração. 
  Eles ficarão armazenados na pasta html/imagens/selos. Para tanto, faça as configurações neces-
  sárias no config.php

Em Casos de Dúvida:
Site: http://www.ironscripts.tk
E-Mail: suporte@ironscripts.tk

Não remova nossa linha de copyright no final do Layout

Neste script utilizei alguns pacotes presentes no PEAR, como DB, HTML_QuickForm e HTML_Table.
Recomendo uso para todos os desenvolvedores PHP.

Site: http://pear.php.net

Agradecimentos Especiais:
WMClube: http://www.wmclube.net
Host Clube: http://www.hostclube.net
Web Ajuda: http://www.webajuda.com.br