<?php

###############################################################################
# portuguese.php
# Esta � a tradu��o em Portugu�s do GeekLog!
#
# Copyright (C) 2003 M�rio Seabra
# mseabra@bairrinfor.com
#
# Este programa � software livre; � permitida a sua distribui��o e /ou
# modifica��o dentro dos termos GNU General Public License
# como publicado pela Free Software Foundation; incluindo a vers�o 2
# da Licen�a, ou (por op��o sua) qualquer vers�o anterior.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

$LANG_CHARSET = "iso-8859-1";

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "Contribui��o de:",
	2 => "mais",
	3 => "coment�rio",
	4 => "Editar",
	5 => "Vota��o",
	6 => "Resultados",
	7 => "Vota��es",
	8 => "votos",
	9 => "Fun��es administrativas:",
	10 => "Submiss�es",
	11 => "Not�cias",
	12 => "Blocos",
	13 => "T�picos",
	14 => "Liga��es",
	15 => "Eventos",
	16 => "Vota��es",
	17 => "Utilizadores",
	18 => "SQL Query",
	19 => "Sair",
	20 => "Informa��o do utilizador:",
	21 => "Utilizador",
	22 => "ID do utilizador",
	23 => "N�vel de seguran�a",
	24 => "An�nimo",
	25 => "Responder",
	26 => "Os seguintes coment�rios s�o da responsabilidade de quem os fez. A p�gina n�o � responsav�l pelo cont�udo dos mesmos.",
	27 => "Coment�rio mais recente",
	28 => "Apagar",
	29 => "Sem coment�rios.",
	30 => "Not�cias anteriores",
	31 => "Tags HTML permitidas:",
	32 => "Erro, nome de utilizador inv�lido",
	33 => "Erro, n�o consegue escrever para o ficheiro de log",
	34 => "Erro",
	35 => "Sair",
	36 => "ligado",
	37 => "Nenhuma not�cia",
	38 => "",
	39 => "Actualizar",
	40 => "",
	41 => "Utilizadores convidados",
	42 => "Enviada por:",
	43 => "Responder",
	44 => "Parent",
	45 => "N�mero de erro MySQL",
	46 => "Mensagem de erro MySQL",
	47 => "Utilizador",
	48 => "Informa��o da conta",
	49 => "Mostrar prefer�ncias",
	50 => "Erro de SQL",
	51 => "ajuda",
	52 => "Novo",
	53 => "Administra��o",
	54 => "Imposs�vel abrir o ficheiro.",
	55 => "Erro em",
	56 => "Votar",
	57 => "Password",
	58 => "Entrar",
	59 => "Ainda n�o tem uma conta?  Inscreva-se como <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Novo Utilizador</a>",
	60 => "Fa�a um coment�rio",
	61 => "Criar uma conta",
	62 => "palavras",
	63 => "Prefer�ncias para os coment�rios",
	64 => "Enviar artigo por Email",
	65 => "Ver vers�o para impress�o",
	66 => "Calend�rio pessoal",
	67 => "Bem-vindo a ",
	68 => "in�cio",
	69 => "contacto",
	70 => "procurar",
	71 => "contribute",
	72 => "recursos",
	73 => "�ltimas vota��es",
	74 => "calend�rio",
	75 => "pesquisa avan�ada",
	76 => "estat�sticas",
	77 => "Plugins",
	78 => "Pr�ximos Eventos",
	79 => "Novidades",
	80 => "not�cias nas �ltimas",
	81 => "not�cia nas �ltimas",
	82 => "horas",
	83 => "COMENT�RIOS",
	84 => "LIGA��ES",
	85 => "�ltimas 48 horas",
	86 => "Nenhum coment�rio novo",
	87 => "�ltimas 2 semanas",
	88 => "Nenhuma liga��o recente",
	89 => "N�o h� eventos brevemente",
	90 => "In�cio",
	91 => "P�gina criada em",
	92 => "segundos",
	93 => "Copyright",
	94 => "Todos os direitos de copyright desta p�gina pertencem aos respectivos propriet�rios.",
	95 => "Suportado por",
	96 => "Grupos",
    97 => "Lista de palavras",
	98 => "Plug-ins",
	99 => "NOT�CIAS",
    100 => "Nenhuma not�cia nova",
    101 => 'Eventos pessoais',
    102 => 'Eventos globais',
    103 => 'DB Backups',
    104 => 'por',
    105 => 'Enviar email',
    106 => 'Visitas',
    107 => 'Teste � vers�o do GL',
    108 => 'Limpar Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calend�rio de Eventos",
	2 => "N�o h� eventos para mostrar.",
	3 => "Quando",
	4 => "Onde",
	5 => "Descri��o",
	6 => "Adicionar um Evento",
	7 => "Pr�ximos Eventos",
	8 => 'Adicionando este evento ao seu calend�rio pode ver rapidamente os eventos do seu interesse clicando em "O meu calend�rio" na �rea de fun��es do utilizador.',
	9 => "Adicionar ao meu calend�rio",
	10 => "Remover do meu calend�rio",
	11 => "A adicionar evento ao calend�rio de {$_USER['username']}",
	12 => "Evento",
	13 => "In�cio",
	14 => "Fim",
        15 => "Voltar ao calend�rio"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Fazer coment�rio",
	2 => "Modo de envio",
	3 => "Sair",
	4 => "Registar utilizador",
	5 => "Nome de utilizador",
	6 => "Este site obriga a que tenha efectuado o login para fazer um coment�rio, Por favor efectue o login.  Se n�o tiver uma conta criada pode utilizar o formul�rio seguinte para se registar.",
	7 => "O seu �ltimo coment�rio foi ",
	8 => " segundos atr�s.  Este site a pelo menos {$_CONF["commentspeedlimit"]} segundos entre coment�rios",
	9 => "Coment�rio",
	10 => '',
	11 => "Enviar coment�rio",
	12 => "Preencha os campos t�tulo e coment�rio. Estes campos s�o necess�rios para o envio de um coment�rio.",
	13 => "A sua informa��o",
	14 => "Previsualizar",
	15 => "",
	16 => "T�tulo",
	17 => "Erro",
	18 => 'A ter em conta',
	19 => 'Tente manter os seus coment�rios relacionados com os t�picos.',
	20 => 'Tente responder aos outros coment�rios em vez de iniciar um assunto novo.',
	21 => 'Leia as mensagens das outras pessoas antes de fazer o seu coment�rio para evitar coment�rios em duplicado.',
	22 => 'Utilize um assunto objectivo que descreva a que se refere o seu coment�rio.',
	23 => 'O seu endere�o de email n�o � tornado p�blico.',
	24 => 'Utilizador an�nimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Perfil de utilizador de",
	2 => "Nome de utilizador",
	3 => "Nome completo",
	4 => "Password",
	5 => "Email",
	6 => "P�gina principal",
	7 => "Bio",
	8 => "PGP Key",
	9 => "Guardar informa��o",
	10 => "�ltimos 10 coment�rios do utilizador",
	11 => "Nenhum coment�rio efectuado",
	12 => "Prefer�ncias do utilizador para",
	13 => "Email Nightly Digest",
	14 => "Esta password foi gerada aleatoriamente. Recomendamos que a altere o mais r�pido poss�vel. Para alterar a password, efectue o login e clique em Informa��o da conta no bloco Utilizador.",
	15 => "A sua conta em {$_CONF["site_name"]} foi criada com sucesso. Para poder utilizar todas as pot�ncialidades deve efectuar o login com a informa��o que lhe foi enviada. Guarde esta email para refer�ncia futura.",
	16 => "Informa��o da sua conta",
	17 => "A conta n�o existe",
	18 => "O endere�o de email introduzido n�o � v�lido",
	19 => "O nome de utilizador ou email introduzido j� existe",
	20 => "O endere�o de email introduzido n�o � v�lido",
	21 => "Erro",
	22 => "Registe-se em {$_CONF['site_name']}!",
	23 => "Registar-se d�-lhe todos os benef�cios de ser um membro da comunidade {$_CONF['site_name']} e permite-lhe fazer coment�rios e enviar informa��o com a identifica��o da sua autoria. Se n�o tiver uma conta, apenas poder� enviar informa��o an�nima. Note que o seu endere�o de email <b><i>nunca</i></b> ser� publicado neste site.",
	24 => "A sua password ser� enviada para o endere�o que indicar.",
	25 => "Esqueceu-se da sua password?",
	26 => "Introduza o seu nome de utilizador e clique em Email Password. Ser� enviada uma nova password para o email com que se registou.",
	27 => "Registe-se agora!",
	28 => "Email Password",
	29 => "saiu a partir de",
	30 => "entrou a partir de",
	31 => "A fun��o pretendida obriga a efectuar o login",
	32 => "Assinatura",
	33 => "N�o � mostrado publicamente",
	34 => "Este � o seu nome real",
	35 => "Introduza a password para alterar",
	36 => "Inicie com http://",
	37 => "Aplicado aos seus coment�rios",
	38 => "Isto � tudo acerca de si! Todos podem ler isto",
	39 => "A sua chave PGP p�blica para partilhar",
	40 => "Sem icones de t�pico",
	41 => "Pretende ser moderador",
	42 => "Formato da data",
	43 => "M�ximo de not�cias",
	44 => "Sem caixas",
	45 => "Mostrar prefer�ncias para",
	46 => "Itens excluidos para",
	47 => "Configura��o da caixa de novidades para",
	48 => "T�picos",
	49 => "Sem icones nas not�cias",
	50 => "Desmarque se n�o est� interessado",
	51 => "Apenas not�cias novas",
	52 => "Por defeito �",
	53 => "Receber as not�cias do dia",
	54 => "Marque as caixas para os t�picos e autores que n�o pretende ver.",
	55 => "Se deixar tudo desmarcado, significa que pretende a selec��o feita por defeito. Se seleccionar alguma das caixas, n�o se esque�a de seleccionar todas as que pretende pois a selec��o feita por defeito � anulada. A selec��o feita por defeito est� a Negrito.",
	56 => "Autores",
	57 => "Modo de visualiza��o",
	58 => "Ordena��o",
	59 => "Limite de coment�rios",
	60 => "Como quer que os seus coment�rios sejam mostrados?",
	61 => "Novas ou antigas primeiro?",
	62 => "Por defeito � 100",
	63 => "A sua password foi enviada por email e deve chegar em breve. Siga as indica��es presentes no email e obrigado por utilizar o site " . $_CONF["site_name"],
	64 => "Prefer�ncias de coment�rios de",
	65 => "Tente efectuar o login novamente",
	66 => "� provavel que se tenha enganado nos seus dados de login.  Tente fazer o login novamente. � um <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novo utilizador</a>?",
	67 => "Membro desde",
	68 => "Lembrar durante",
	69 => "Durante quanto tempo quer ser lembrado depois de efectuar o login?",
	70 => "Personalize a apar�ncia e cont�udo do site {$_CONF['site_name']}",
	71 => "Uma das op��es do site {$_CONF['site_name']} � que pode personalizar o cont�udo que quer ver e a apar�ncia do site.  Para poder usar esta op��o deve-se <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registar</a> em {$_CONF['site_name']}.  J� � um membro registado?  Ent�o utilize o formul�rio de login do lado esquerdo!",
    72 => "Tema",
    73 => "Idioma",
    74 => "Mude a apar�ncia deste site!",
    75 => "T�picos enviadoas para",
    76 => "Se seleccionar um t�pico da lista receber� todas as not�cias colocadas nesse t�pico durante o dia.  Seleccione apenas os t�picos do seu interesse!",
    77 => "Foto",
    78 => "Adicione a sua fotografia!",
    79 => "Marque aqui para apagar esta imagem",
    80 => "Login",
    81 => "Enviar Email",
    82 => '�ltimas 10 not�cias do utilizador',
    83 => 'Estat�stica de artigos do utilizador',
    84 => 'N�mero total de artigos:',
    85 => 'N�mero total de coment�rios:',
    86 => 'Encontrar todos os artigos de'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nenhuma not�cia para mostrar",
	2 => "N�o h� not�cias novas para mostrar.  Pode n�o haver not�cias para este t�pico ou as suas defini��es s�o demasiado restrictivas",
	3 => " para o t�pico $topic",
	4 => "Artigos do dia",
	5 => "Pr�xima",
	6 => "Anterior"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "P�ginas dispon�veis",
	2 => "N�o h� p�ginas para mostrar.",
	3 => "Adicionar uma liga��o"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto Registado",
	2 => "O seu voto foi registado",
	3 => "Voto",
	4 => "Vota��es no sistema",
	5 => "Votos"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Houve um erro ao enviar a sua mensagem. Tente novamente.",
	2 => "Mensagem enviada com sucesso.",
	3 => "Certifique-se que utiliza um endere�o de email v�lido no campo Responder para.",
	4 => "Preencha os campos Nome, Responder Para, Assunto e Mensagem",
	5 => "Erro: Nenhum utilizador.",
	6 => "Existe um erro.",
	7 => "Perfil de utilizador para",
	8 => "Nome",
	9 => "URL do utilizador",
	10 => "Enviar email para",
	11 => "Nome:",
	12 => "Responder para:",
	13 => "Assunto:",
	14 => "Mensagem:",
	15 => "HTML n�o ser� traduzido.",
	16 => "Enviar mensagem",
	17 => "Enviar Not�cia a um amigo",
	18 => "Para",
	19 => "Email",
	20 => "De",
	21 => "Email",
	22 => "S�o necess�rios todos os campos",
	23 => "Este email foi-lhe enviado por $from em $fromemail porque ele(a) acredita que possa estar interessado(a) neste artigo do site {$_CONF["site_url"]}.  Isto n�o � SPAM e os endere�os de email envolvidos nesta opera��o n�o ficam registados para uso posterior.",
	24 => "Coment�rios a esta not�cia em",
	25 => "Deve efectuar o login para poder utilizar esta op��o.  Efectuando o login, ajuda-nos a prevenir a utiliza��o fraudulenta do sistema",
	26 => "Este formul�rio permite-lhe enviar um email para o utilizador seleccionado.  � necess�rio o preenchimento de todos os campos.",
	27 => "Mensagem curta",
	28 => "$from escreveu: $shortmsg",
    29 => "Este � o envio di�rio autom�tico de {$_CONF['site_name']} para ",
    30 => " Novidades di�rias para ",
    31 => "Titulo",
    32 => "Data",
    33 => "Leia o artigo completo em",
    34 => "Fim da mensagem"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Pesquisa avan�ada",
	2 => "Palavras a pesquisar",
	3 => "T�pico",
	4 => "Tudo",
	5 => "Tipo",
	6 => "Not�cias",
	7 => "Coment�rios",
	8 => "Autores",
	9 => "Tudo",
	10 => "Pesquisar",
	11 => "Resultados da pesquisa",
	12 => "resultados",
	13 => "Nenhuma correspond�ncia com o crit�rio",
	14 => "N�o foram encontrados registos na sua pesquisa de",
	15 => "Tente de novo.",
	16 => "T�tulo",
	17 => "Data",
	18 => "Autor",
	19 => "Pesquise na base de dados {$_CONF["site_name"]} em todas as not�cias",
	20 => "Data",
	21 => "at�",
	22 => "(Formato AAAA-MM-DD)",
	23 => "Visitas",
	24 => "Encontrados",
	25 => "resultados para",
	26 => "itens em",
	27 => "segundos",
    28 => 'Nenhuma not�cia ou coment�rio corresponde ao seu crit�rio',
    29 => 'Resultado de Not�cias e Coment�rios',
    30 => 'Nenhuma liga��o corresponde a sua pesquisa',
    31 => 'Este plug-in n�o devolveu resultados',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Localiza��o',
    35 => 'Todo o dia',
    36 => 'Nenhum evento corresponde ao crit�rio',
    37 => 'Resultado de eventos',
    38 => 'Resultado de liga��es',
    39 => 'Liga��es',
    40 => 'Eventos',
    41 => 'A frase a pesquisar deve ter no m�nimo 3 caracteres.',
    42 => 'Utilize uma data com o seguinte formato AAAA-MM-DD (ano-m�s-dia).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Estat�sticas do site",
	2 => "N�mero total de Liga��es ao sitema",
	3 => "Not�cias(Coment�rios) no sistema",
	4 => "Vota��es(Respostas) no sistema",
	5 => "Links(Clicks) no sistema",
	6 => "Evento no sistema",
	7 => "Top Ten de not�cias visitadas",
	8 => "T�tulo da not�cia",
	9 => "Visitas",
	10 => "Parece que n�o h� nenhuma not�cia no site ou nenhuma delas foi ainda visitada.",
	11 => "Top Ten de not�cias comentadas",
	12 => "Coment�rios",
	13 => "Parece que n�o h� nenhuma not�cia no site ou ainda n�o foi feito nenhum coment�rio.",
	14 => "Top Ten de vota��es",
	15 => "Pergunta da vota��o",
	16 => "Votos",
	17 => "Parece que n�o h� nenhuma vota��o no site ou ainda ningu�m votou em nenhuma.",
	18 => "Top Ten Links",
	19 => "Links",
	20 => "Visitas",
	21 => "Parece que n�o existem links no site ou ainda nenhum deles foi visitado.",
	22 => "Top Ten Not�cias enviadas",
	23 => "Emails",
	24 => "Parece que ainda n�o foi enviada nenhuma not�cia deste site"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Artigos relaccionados",
	2 => "Enviar not�cia a um amigo",
	3 => "Vers�o para impress�o",
	4 => "Op��es da not�cia"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Para enviar um $type deve efectuar o login como utilizador.",
	2 => "Login",
	3 => "Novo utilizador",
	4 => "Enviar um evento",
	5 => "Enviar um link",
	6 => "Enviar uma not�cia",
	7 => "� necess�rio Login",
	8 => "Enviar",
	9 => "Ao enviar informa��es para utiliza��o neste site pedimos-lhe que cumpra as seguintes recomenda��es...<ul><li>Preencha todos os campos, eles s�o necess�rios<li>Forne�a informa��o correta e completa<li>Verifique os URLs</ul>",
	10 => "Titulo",
	11 => "Liga��o",
	12 => "Data de in�cio",
	13 => "Data de fim",
	14 => "Localiza��o",
	15 => "Descri��o",
	16 => "Se outra, especifique",
	17 => "Categoria",
	18 => "Outra",
	19 => "Ler primeiro",
	20 => "Erro: Falta a categoria",
	21 => "Ao seleccionar \"Outra\" indique o nome da categoria",
	22 => "Erro: Faltam campos",
	23 => "Preencha todos os campos do formul�rio.  Todos eles s�o necess�rios.",
	24 => "Envio registado",
	25 => "O seu envio $type foi registado com sucesso.",
	26 => "Limite de velocidade",
	27 => "Utilizador",
	28 => "T�pico",
	29 => "Not�cia",
	30 => "O seu �ltimo envio foi � ",
	31 => " segundos.  Este site obriga a pelo menos {$_CONF["speedlimit"]} segundos entre envios",
	32 => "Previsualizar",
	33 => "Previsualiza��o da not�cia",
	34 => "Sair",
	35 => "Tags HTML n�o s�o permitidas",
	36 => "Modo de coloca��o",
	37 => "Enviar um evento para {$_CONF["site_name"]} colocar� este este evento no calend�rio geral onde os utilizadores poderam adicion�-lo ao seu calend�rio pessoal. Esta op��o <b>N�O</b> foi pensada para armazenar os seus eventos pessoais tipo anivers�rios e datas comemorativas.<br><br>Quando publica o seu evento este � enviado aos administradores e se aprovado, o seu evento aparecer� no calend�rio geral.",
    38 => "Adicionar evento para",
    39 => "Calend�rio geral",
    40 => "Calend�rio pessoal",
    41 => "Fim",
    42 => "In�cio",
    43 => "Todo o dia",
    44 => 'Morada',
    45 => '',
    46 => 'Localidade',
    47 => 'Cidade',
    48 => 'C. Postal',
    49 => 'Tipo',
    50 => 'Editar Tipos de Evento',
    51 => 'Localiza��o',
    52 => 'Apagar',
    53 => 'Criar conta'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentica��o necess�ria",
	2 => "N�o autorizado! Informa��o de Login incorrecta",
	3 => "Password inv�lida para o utilizador",
	4 => "Utilizador:",
	5 => "Password:",
	6 => "Todos os acessos administrativos deste site s�o registados e auditados.<br>Est� p�gina � apenas para utiliza��o de pessoal autorizado.",
	7 => "login"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Direitos de administra��o insuficientes",
	2 => "N�o tem permiss�es suficientes para editar este bloco.",
	3 => "Editor de blocos",
	4 => "",
	5 => "T�tulo",
	6 => "T�pico",
	7 => "Todos",
	8 => "N�vel de seguran�a",
	9 => "Ordem",
	10 => "Tipo",
	11 => "Bloco de portal",
	12 => "Bloco normal",
	13 => "Op��es de bloco de portal",
	14 => "RDF URL",
	15 => "�ltima actualiza��o RDF",
	16 => "Op��es para Blocos Normais",
	17 => "Cont�udo dos blocos",
	18 => "Preencha os campos T�tulo, N�vel de seguran�a e Cont�udo",
	19 => "Manuten��o de blocos",
	20 => "T�tulo",
	21 => "N�vel de seguran�a",
	22 => "Tipo",
	23 => "Ordem",
	24 => "T�pico",
	25 => "Para modificar ou apagar um bloco, clique nesse bloco.  Para criar um bloco novo clique em Novo Bloco.",
	26 => "Apar�ncia do bloco",
	27 => "Bloco de PHP",
    28 => "Op��es de bloco PHP",
    29 => "Fun��o",
    30 => "Se pretende que um dos seus blocos utilize c�digo PHP, introduza o nome da fun��o a utilizar. O nome da fun��o deve ter o prefixo \"phpblock_\" (ex. phpblock_getweather). Se n�o tiver este prefixo, a sua fun��o n�o ser� executada. Isto serve para que algu�m que tenha conseguido acesso n�o autorizado ao seu site possa colocar c�digo malicioso no seu sistema. Certifique-se que n�o coloca parentesis vazios \"()\" depois do nome da sua fun��o.  Finalmente, � recomendado que coloque todo o seu c�digo PHP em /camino/para/geeklog/system/lib-custom.php.  Isto permite-lhe que o seu c�digo permane�a mesmo ao efectuar um upgrade � sua vers�o do Geeklog.",
    31 => 'Erro no bloco PHP.  A fun��o $function n�o existe.',
    32 => "Erro: Faltam campos",
    33 => "Deve introduzir o URL para o ficheiro .rdf para os blocos de portal",
    34 => "Deve introduzir o t�tulo e a fun��o para os blocos PHP",
    35 => "Deve introduzir o t�tulo e o cont�udo para os blocos normais",
    36 => "Deve introduzir o cont�udo para os blocos de layout",
    37 => "Nome de fun��o PHP incorrecta",
    38 => "Fun��es para os blocos PHP devem conter o prefixo 'phpblock_' (ex. phpblock_getweather).  O prefixo 'phpblock_' � necess�rio por raz�es de seguran�a.",
	39 => "Lado",
	40 => "Esquerdo",
	41 => "Direito",
	42 => "Deve introduzir a ordem do bloco e o n�vel de seguran�a para os blocos por defeito do Geeklog",
	43 => "Apenas p�gina principal",
	44 => "Acesso n�o permitido",
	45 => "Est� a tentar aceder a um bloco para o qual n�o tem permiss�es. Este procedimento foi registado. Volte � <a href=\"{$_CONF["site_admin_url"]}/block.php\">janela de administra��o</a>.",
	46 => 'Novo Bloco',
	47 => 'Administra��o',
    48 => 'Nome',
    49 => ' (sem espa�os e deve ser �nico)',
    50 => 'URL de ficheiro de ajuda',
    51 => 'inclua http://',
    52 => 'Se deixar em branco n�o aparecer� icon de ajuda para este bloco',
    53 => 'Autorizado',
    54 => 'guardar',
    55 => 'cancelar',
    56 => 'apagar'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor de eventos",
	2 => "",
	3 => "T�tulo",
	4 => "URL",
	5 => "Data de in�cio",
	6 => "Data de fim",
	7 => "Localiza��o",
	8 => "Descri��o",
	9 => "(inclua http://)",
	10 => "Deve inserir datas, horas, descri��o e localiza��o para o evento!",
	11 => "Manuten��o de eventos",
	12 => "Para modificar ou apagar um evento, clique nesse evento a seguir.  Para criar um novo evento clique em Novo evento.",
	13 => "T�tulo",
	14 => "Data de in�cio",
	15 => "Data de fim",
	16 => "Acesso n�o permitido",
	17 => "Est� a tentar aceder a um evento para o qual n�o tem permiss�es.  Esta ac��o ficou registada. Por favor <a href=\"{$_CONF["site_admin_url"]}/event.php\">volte ao �cran de administra��o de eventos</a>.",
	18 => 'Novo evento',
	19 => 'Administra��o',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'apagar'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor de liga��es",
	2 => "",
	3 => "T�tulo",
	4 => "URL",
	5 => "Categoria",
	6 => "(inclua http://)",
	7 => "Outra",
	8 => "Visitas",
	9 => "Descri��o",
	10 => "Deve introduzir um t�tulo, o URL e a descri��o.",
	11 => "Manuten��o de liga��es",
	12 => "Para modificar ou apagar uma liga��o, clique na liga��o a seguir.  Para inserir uma nova liga��o clique em Nova Liga��o.",
	13 => "T�tulo",
	14 => "Categoria",
	15 => "URL",
	16 => "Acesso n�o permitido",
	17 => "Esta a tentar aceder a uma liga��o para a qual n�o tem permiss�es.  Esta ac��o ficou registada. Por favor <a href=\"{$_CONF["site_admin_url"]}/link.php\">volte ao �cran de administra��o de liga��es</a>.",
	18 => 'Nova Liga��o',
	19 => 'Administra��o',
	20 => 'Se outra, especifique',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'apagar'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Not�cia anterior",
	2 => "Not�cia seguinte",
	3 => "Modo",
	4 => "Modo de envio",
	5 => "Editor de not�cias",
	6 => "N�o h� not�cias no sistema",
	7 => "Autor",
	8 => "guardar",
	9 => "previsualizar",
	10 => "cancelar",
	11 => "apagar",
	12 => "",
	13 => "T�tulo",
	14 => "T�pico",
	15 => "Data",
	16 => "Introdu��o",
	17 => "Corpo",
	18 => "Visitas",
	19 => "Coment�rios",
	20 => "",
	21 => "",
	22 => "Lista de not�cias",
	23 => "Para modificar ou apagar uma not�cia, clique no n�mero da not�cia a seguir. Para ver uma not�cia, clique no t�tulo da not�cia que pretende ver. Para introduzir uma not�cia clique em Inserir not�cia a seguir.",
	24 => "",
	25 => "",
	26 => "Previsualiza��o de not�cias",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Por favor preencha os campos Autor, T�tulo e Introdu��o",
	32 => "Featured",
	33 => "S� pode haver uma not�cia featured",
	34 => "Rascunho",
	35 => "Sim",
	36 => "N�o",
	37 => "Mais de",
	38 => "Mais a partir de",
	39 => "Emails",
	40 => "Acesso n�o autorizado",
	41 => "Est� a tentar aceder a uma not�cia para a qual n�o tem permiss�es.  Esta ac��o ficou registada.  Pode ver esta not�cia com permiss�es de leitura a seguir. Por favor <a href=\"{$_CONF["site_admin_url"]}/story.php\">volte ao �cran de administra��o de not�cias</a> quando terminar.",
	42 => "Est� a tentar aceder a uma not�cia para a qual n�o tem permiss�es.  Esta ac��o ficou registada.  Por favor <a href=\"{$_CONF["site_admin_url"]}/story.php\">volte ao �cran de administra��o de not�cias</a>.",
	43 => 'Inserir not�cia',
	44 => 'Administra��o',
	45 => 'Acesso',
    46 => '<b>NOTA:</b> se modificar esta data para uma data futura, esta not�cia n�o ser� publicada antes dessa data.  Isto significa tamb�m que a sua not�cia n�o aparecer� nos cabe�alhos e ser� ignorada pelas pesquisas e p�ginas de estat�sticas.',
    47 => 'Imagens',
    48 => 'imagem',
    49 => 'direita',
    50 => 'esquerda',
    51 => 'Para adicionar uma das imagens que est� a anexar a esta not�cia precisa de introduzir texto com formato especial.  O formato especial do texto � [imagemX], [imagemX_direita] ou [imagemX_esquerda] onde X � o n�mero da imagem que anexou.  NOTA: Deve utilizar as imagens que anexou.  Caso contr�rio n�o poder� guardar a sua not�cia.<BR><P><B>PREVISUALIZAR</B>: Previsualizar uma not�cia que contenha imagens deve ser efectuado guardando a not�cia como rascunho EM VEZ DE seleccionar o bot�o de previsualiza��o.  Utilize o bot�o de previsualiza��o apenas quando n�o tiver imagens anexadas.',
    52 => 'Apagar',
    53 => 'n�o foi utilizada.  Deve incluir esta imagem na introdu��o ou no corpo da not�cia antes de guardar as altera��es',
    54 => 'Imagens associadas e n�o utilizadas',
    55 => 'Ocorreram os seguintes erros ao tentar guardar a sua not�cia.  Por favor, corrija estes erros antes de guardar',
    56 => 'Mostrar imagem de t�pico'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => "",
	3 => "Data de cria��o",
	4 => "Vota��o $qid guardada",
	5 => "Editar vota��o",
	6 => "ID da vota��o",
	7 => "(n�o utilize espa�os)",
	8 => "Aparece na p�gina inicial",
	9 => "Pergunta",
	10 => "Respostas / Votos",
	11 => "Foi encontrado um erro ao carregar uma resposta da vota��o $qid",
	12 => "Foi encontrado um erro ao carregar a quest�o da vota��o $qid",
	13 => "Criar Vota��o",
	14 => "guardar",
	15 => "cancelar",
	16 => "apagar",
	17 => "",
	18 => "Lista de vota��es",
	19 => "Para modificar ou apagar uma vota��o, clique na mesma.  Para criar uma vota��o nova clique em Criar vota��o.",
	20 => "Votantes",
	21 => "Acesso interdito",
	22 => "Est� atentar aceder a uma vota��o � qual n�o tem acesso.  Este evento foi registado. Por favor <a href=\"{$_CONF["site_admin_url"]}/poll.php\">volte ao �cran de administra��o de vota��es</a>.",
	23 => 'Nova vota��o',
	24 => 'Administra��o',
	25 => 'Sim',
	26 => 'N�o'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor de t�picos",
	2 => "ID do t�pico",
	3 => "Nome",
	4 => "Imagem",
	5 => "(n�o utilize espa�os)",
	6 => "Apagar um t�pico remove tamb�m todas as not�cias e blocos associados a ele.",
	7 => "Preencha os campos ID de t�pico e Nome",
	8 => "Manuten��o de t�picos",
	9 => "Para modificar ou apagar um t�pico, clique nesse t�pico.  Para criar um novo t�pico clique no bot�o Novo t�pico � esquerda. Encontra o seu n�vel de acesso para cada t�pico dentro de par�ntesis",
	10=> "Ordem",
	11 => "Not�cias/P�gina",
	12 => "Acesso interdito",
	13 => "Est� a tentar aceder a um t�pico para o qual n�o tem permiss�o.  Esta tentativa foi registado. Por favor <a href=\"{$_CONF["site_admin_url"]}/topic.php\">volte ao �cran de administra��o de t�picos</a>.",
	14 => "M�todo de ordena��o",
	15 => "alfab�tica",
	16 => "normal �",
	17 => "Novo T�pico",
	18 => "Administra��o",
    19 => 'guardar',
    20 => 'cancelar',
    21 => 'apagar'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Detalhes do utilizador",
	2 => "ID do utilizador",
	3 => "Nome do utilizador",
	4 => "Nome completo",
	5 => "password",
	6 => "N�vel de seguran�a",
	7 => "Email",
	8 => "P�gina WEB",
	9 => "(n�o utilize espa�os)",
	10 => "Por favor preencha o Nome do utilizador, Nome completo, N�vel de seguran�a e endere�o de Email",
	11 => "Manuten��o de utilizadores",
	12 => "Para modificar ou apagar um utilizador, clique nesse utilizador abaixo. Para criar um novo utilizador clique no bot�o Novo utilizador � esquerda. Pode efectuar pesquisas simples introduzindo partes do nome de utilizador, endere�o de email ou do nome completo (ex.*Manuel* ou *.pt) no formul�rio abaixo.",
	13 => "N�vel de seguran�a",
	14 => "Data de registo",
	15 => 'Novo utilizador',
	16 => 'Administra��o',
	17 => 'mudar password',
	18 => 'cancelar',
	19 => 'apagar',
	20 => 'guardar',
	18 => 'cancelar',
	19 => 'apagar',
	20 => 'guardar',
    21 => 'O nome de utilizador que tentou guardar j� existe.',
    22 => 'Erro',
    23 => 'Adicionar autom�tico',
    24 => 'Importa��o autom�tica de utilizadores',
    25 => 'Pode importar um ficheiro de utilizadores para o site. O ficheiro de importa��o deve ser delimitado por tabula��es e deve conter os campos na seguinte ordem: nome completo, nome de utilizador, endere�o de email. Cada utilizador importado receber� uma password por email. Deve ter um utilizador em cada linha. Uma falha num destes pontos causar� problemas que ter�o de ser resolvidos manualmente para resolver duplica��o de registos!',
    26 => 'Procurar',
    27 => 'Limite de Resultados',
    28 => 'Seleccione aqui para apagar esta imagem',
    29 => 'Caminho',
    30 => 'Importar',
    31 => 'Novos Utilizadores',
    32 => 'Processo conclu�do. Foram importados $successes e encontrados $failures erros',
    33 => 'enviar',
    34 => 'Erro: Deve especificar um ficheiro para carregar.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Aprovar",
    2 => "Apagar",
    3 => "Editar",
    4 => 'Perfil',
    10 => "T�tulo",
    11 => "Data de in�cio",
    12 => "URL",
    13 => "Categoria",
    14 => "Data",
    15 => "T�pico",
    16 => 'Nome de utilizador',
    17 => 'Nome completo',
    18 => 'Email',
    34 => "Comando e Control",
    35 => "Noticia para aprova��o",
    36 => "Liga��es para aprova��o",
    37 => "Eventos para aprova��o",
    38 => "Submeter",
    39 => "N�o � envios para modera��o neste momento",
    40 => "Envios do utilizador"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Domingo",
	2 => "Segunda",
	3 => "Ter�a",
	4 => "Quarta",
	5 => "Quinta",
	6 => "Sexta",
	7 => "S�bado",
	8 => "Adicionar Evento",
	9 => "Evento Geral",
	10 => "Eventos para",
	11 => "Calend�rio Geral",
	12 => "O Meu Calend�rio",
	13 => "Janeiro",
	14 => "Fevereiro",
	15 => "Mar�o",
	16 => "Abril",
	17 => "Maio",
	18 => "Junho",
	19 => "Julho",
	20 => "Agosto",
	21 => "Setembro",
	22 => "Outubro",
	23 => "Novembro",
	24 => "Dezembro",
	25 => "Voltar a ",
    26 => "Todo o dia",
    27 => "Semana",
    28 => "Calend�rio pessoal de",
    29 => "Calend�rio p�blico",
    30 => "apagar evento",
    31 => "Adicionar",
    32 => "Evento",
    33 => "Data",
    34 => "Hora",
    35 => "Adicionar r�pido",
    36 => "Enviar",
    37 => "Pedimos desculpa, o calend�rio pessoal est� inactivo neste site",
    38 => "Editor de eventos pessoais",
    39 => 'Dia',
    40 => 'Semana',
    41 => 'M�s'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Utilit�riod de email",
 	2 => "De",
 	3 => "Responder a",
 	4 => "Assunto",
 	5 => "Mensagem",
 	6 => "Enviar para:",
 	7 => "Todos os utilizadores",
 	8 => "Admin",
	9 => "Op��es",
	10 => "HTML",
 	11 => "Urgent message!",
 	12 => "Enviar",
 	13 => "Limpar",
 	14 => "Ignorar prefer�ncios do utilizador",
 	15 => "Erro ao enviar para: ",
	16 => "Mensagens enviadas com sucesso para: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Enviar outra mensagem</a>",
    18 => "Para",
    19 => "NOTA: se pretende enviar uma mensagem para todos os utilizadores do site, seleccione o grupo Logged-in Users na lista.",
    20 => "Enviadas <successcount> mensagens com sucesso e <failcount> sem sucesso.  Se precisar, os detalhes para cada mensagem est�o a seguir. Caso contr�rio pode <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Enviar outra mensagem</a> ou voltar � <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">pagina de administra��o</a>.",
    21 => 'Falhas',
    22 => 'Sucessos',
    23 => 'Nenhuma falha',
    24 => 'Nenhum sucesso',
    25 => '-- Selecione o grupo --',
    26 => "Preencha todos os campos no formul�rio e seleccione um grupo na lista."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "A sua password foi enviada para o seu email e deve chegar em breve. Siga as indica��es presentes na mensagem e obrigado por utilizar o site " . $_CONF["site_name"],
	2 => "Obrigado por enviar a sua not�cia para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprova��o. Se for aceite, a sua not�cia estar� dispon�vel para todos os utilizadores do nosso site.",
	3 => "Obrigado por enviar a sua liga��o para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprova��o.  Se for aceite, o seu link estar� dispon�vel na sec��o <a href={$_CONF["site_url"]}/links.php>links.</a>",
	4 => "Obrigado por enviar o seu evento para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprova��o.  Se for aceite, o seu evento estar� vis�vel na sec��o <a href={$_CONF["site_url"]}/calendar.php>calend�rio.</a>",
	5 => "A informa��o da sua conta foi guardada com sucesso.",
	6 => "As suas prefer�ncias do layout do site foram guardadas com sucesso.",
	7 => "As suas prefer�ncias para os coment�rios foram guardadas com sucesso.",
	8 => "Terminou a sua sess�o com sucesso.",
	9 => "A sua not�cia foi registada com sucesso.",
	10 => "A sua not�cia foi apagada com sucesso.",
	11 => "O seu bloco foi guardado com sucesso.",
	12 => "O bloco foi apagado com sucesso.",
	13 => "O seu t�pico foi guardado com sucesso.",
	14 => "O t�pico e todas as not�cias desse t�pico foram apagados com sucesso.",
	15 => "O seu link foi guardado com sucesso.",
	16 => "O link foi apagado com sucesso.",
	17 => "O seu evento foi registado com sucesso.",
	18 => "O evento foi apagado com sucesso.",
	19 => "A sua vota��o foi guardada com sucesso.",
	20 => "A vota��o foi apagada com sucesso.",
	21 => "O novo utilizador foi guardado com sucesso.",
	22 => "O utilizador foi apagado com sucesso",
	23 => "Erro ao tentar adicionar um evento ao seu calend�rio. N�o foi indicado o id do evento.",
	24 => "O evento foi adicionado ao seu calend�rio",
	25 => "N�o pode abrir o seu calend�rio pessoal enquanto n�o efectuar o login",
	26 => "O evento foi retirado do seu calend�rio pessoal com sucesso",
	27 => "Mensagem enviada com sucesso.",
	28 => "O plug-in foi guardado com sucesso",
	29 => "Pedimos desculpa, o calend�rio pessoal n�o est� autorizado neste site",
	30 => "Acesso n�o permitido",
	31 => "N�o tem acesso � manuten��o de not�cias. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	32 => "N�o tem acesso � manuten��o de t�picos. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	33 => "N�o tem acesso � manuten��o de blocos. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	34 => "N�o tem acesso � manuten��o de links. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	35 => "N�o tem acesso � manuten��o de eventos. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	36 => "N�o tem acesso � manuten��o de vota��es. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	37 => "N�o tem acesso � manuten��o de utilizadores. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	38 => "N�o tem acesso � manuten��o de plugin's. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	39 => "N�o tem acesso � manuten��o de email. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
	40 => "Mensagem do sistema",
    41 => "N�o tem acesso � manuten��o de palavras de substitui��o. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
    42 => "A palavra foi guardada com sucesso.",
	43 => "A palavra foi apagada com sucesso.",
    44 => 'O plug-in foi instalado com sucesso!',
    45 => 'O plug-in foi apagado com sucesso.',
    46 => "N�o tem acesso � manuten��o de c�pias da base de dados. Relembramos que todas as tentativas de acesso a fun��es n�o autorizadas s�o registadas",
    47 => "Esta funcionalidade apenas trabalha em ambientes *nix.  Se estiver a trabalhar num ambiente *nix a cache foi limpa com sucesso. Se estiver no Windows, procure os ficheiros com o nome adodb_*.php e remova-os manualmente.",
    48 => 'Obrigado por se aplicar como um membro de ' . $_CONF['site_name'] . '. A nossa equipa ir� rever a sua aplica��o. Se aprovada, a sua password ser� enviada para o email que nos indicou.',
    49 => "O seu grupo foi guardado com sucesso.",
    50 => "O grupo foi apagado com sucesso."
);

// for plugins.php

$LANG32 = array (
	1 => "A instala��o de plugins pode danificar a instala��o do Geeklog e, possivelmente, o sistema. � importante que apenas instale plugins descarregados do <a href=\"http://www.geeklog.net\" target=\"_blank\">Site Geeklog</a> dado que n�s testamos todos os plugins enviados para o nosso site nos mais variados sistemas operativos. � importante que perceba que a instala��o de plugin's requere a execu��o de comandos do sistema que lhe podem trazer problemas de seguran�a se esses plugins n�o vierem de sites fidedignos. Para al�m deste aviso, n�s n�o garantimos o sucesso da instala��o de plugins nem podemos ser responsabilizados pelos danos causados pela instala��o de plugin's. Por outras palavras, instale � sua responsabilidade. Por prudencia, recomenda��es de como instalar um plugin manualmente vem incluidas com cada plugin.",
	2 => "Responsabilidade da Instala��o de Plug-in",
	3 => "Formul�rio de instala��o de Plug-in",
	4 => "Ficheiro do Plug-in",
	5 => "Lista de Plug-in's ",
	6 => "Aviso: o Plug-in j� est� instalado!",
	7 => "O plug-in que est� a tentar instalar j� existe. Tem de apagar antes de reinstalar",
	8 => "Falhou o teste de compatibilidade do Plugin",
	9 => "Este plugin necessita de uma vers�o mais recente do Geeklog. Fa�a a actualiza��o da sua c�pia do <a href=\"http://www.geeklog.net\">Geeklog</a> ou procure outra vers�o do plug-in.",
	10 => "<br><b>N�o h� plugins instalados.</b><br><br>",
	11 => "Para modificar ou apagar um plug-in, clique no n�mero desse plugin. Para saber maia sobre um plug-in, clique no nome do plug-in e ser� redireccionado para o site desse plugin. Para instalar ou actualizar um plug-in consulte a sua documenta��o.",
	12 => 'nenhum nome de plugin enviado � fun��o plugineditor()',
	13 => 'Editor de Plug-in',
	14 => 'Novo Plug-in',
	15 => 'Administra��o',
	16 => 'Nome do Plug-in',
	17 => 'Vers�o do Plug-in',
	18 => 'Vers�o do Geeklog',
	19 => 'Activo',
	20 => 'Sim',
	21 => 'N�o',
	22 => 'Instalar',
    23 => 'Guardar',
    24 => 'Cancelar',
    25 => 'Apagar',
    26 => 'Nome',
    27 => 'P�gina Web',
    28 => 'Vers�o do Plug-in',
    29 => 'Vers�o do GL',
    30 => 'Apagar o Plug-in?',
    31 => 'Tem a certeza que pretende apagar este plug-in?  Ao efectuar isto remove todos os dados e estructuras que este plug-in utiliza. Se tem a certeza, clique em apagar novamente.'
);

$LANG_ACCESS = array(
	access => "Acesso",
    ownerroot => "Editor/Root",
    group => "Grupo",
    readonly => "S� leitura",
	accessrights => "Direitos de acesso",
	owner => "Autor",
	grantgrouplabel => "Dar permiss�o de edi��o a todos os Grupos",
	permmsg => "NOTA: membros s�o todos os utilizadores que efectuaram o login e an�nimos s�o os visitantes da p�gina sem login efectuado.",
	securitygroups => "Grupos de seguran�a",
	editrootmsg => "Mesmo sendo membro do grupo de Administradores, n�o pode editar a informa��o de um utilizador root sem ser primeiro um utilizador root tamb�m.  Pode editar todos os utilizadores excepto os do grupo root. Lembramos que todas as tentativas de edi��o ilegal de utilizadores root s�o registadas.  Volte � p�gina de <a href=\"{$_CONF["site_admin_url"]}/user.php\">Administra��o de utilizadores</a>.",
	securitygroupsmsg => "Seleccione as caixas dos grupos aos quais o utilizador ir� pertencer.",
	groupeditor => "Editor de grupos",
	description => "Descri��o",
	name => "Nome",
 	rights => "Direitos",
	missingfields => "Faltam campos",
	missingfieldsmsg => "Deve introduzir o nome e a descri��o do grupo",
	groupmanager => "Manuten��o de grupos",
	newgroupmsg => "Para modificar ou apagar um grupo, clique nesse grupo. Para criar um grupo novo clique em Novo grupo. Relembramos que os grupos do n�cleo n�o podem ser apagados porque s�o utilizados no sistema.",
	groupname => "Nome",
	coregroup => "Grupo do n�cleo",
	yes => "Sim",
	no => "N�o",
	corerightsdescr => "Este grupo pertence ao n�cleo do site {$_CONF["site_name"]}.  Da� que os direitos deste grupo n�o podem ser editados.  A seguir est� a lista dos direitos de acesso dos membros deste grupo.",
	groupmsg => "Os Grupos de Seguran�a deste site s�o hier�rquicos.  Adicionando este grupo a qualquer um dos grupos a seguir est� a dar a este grupo os mesmos direitos desses grupos. Onde seja poss�vel aconselhamos a utilizar os grupos listados a seguir para dar permiss�es ao grupo. Se necessita que este grupo tenha direitos personalizados seleccione os direitos de acesso �s mais variadas funcionalidades deste site seleccionando 'Direitos'.  Para adicionar este grupo a qualquer um dos seguintes seleccione a caixa correspondente.",
	coregroupmsg => "Este grupo pertence ao n�cleo do site {$_CONF["site_name"]}.  Da� que os direitos deste grupo n�o podem ser editados.  A seguir est� a lista dos direitos de acesso dos membros deste grupo.",
	rightsdescr => "O acesso de um grupo a um determinado direito pode ser dado directamente ao grupo OU a um grupo diferente que contenha esses direitos. Os que v� a seguir sem caixa de selec��o s�o os direitos dados a este grupo porque este pertence a um grupo que tem essas permiss�es. Os direitos com caixas de selec��o s�o direitos que podem ser dados directamente a este grupo.",
	lock => "Bloquear",
	members => "Membros",
	anonymous => "An�nimos",
	permissions => "Permiss�es",
	permissionskey => "L = leitura, E = edi��o, direitos de edi��o assumem direitos de leitura",
	edit => "Editar",
	none => "N/A",
	accessdenied => "Acesso n�o autorizado",
	storydenialmsg => "N�o tem permiss�o para ver esta not�cia.  Isto pode acontecer porque voc� n�o � membro do site {$_CONF["site_name"]}.  <a href=users.php?mode=new> Torne-se membro</a> do site {$_CONF["site_name"]} para ter acesso como utilizador registado!",
	eventdenialmsg => "N�o tem permiss�o para ver este evento.  Isto pode acontecer porque voc� n�o � membro do site {$_CONF["site_name"]}.  <a href=users.php?mode=new> Torne-se membro</a> do site {$_CONF["site_name"]} para ter acesso como utilizador registado!",
	nogroupsforcoregroup => "Este grupo n�o pertence a qualquer um dos outros grupos",
	grouphasnorights => "Este grupo n�o tem qualquer acesso administrativo neste site",
	newgroup => 'Novo grupo',
	adminhome => 'Administra��o',
	save => 'guardar',
	cancel => 'cancelar',
	delete => 'apagar',
	canteditroot => 'Tentou editar o grupo Root mas como n�o est� inclu�do nesse grupo n�o lhe � permitido o acesso. Contacte o administrador do sistema se acha que isto se deve a um erro'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Editor de palavras de substitui��o",
    wordid => "ID da palavra",
    intro => "Para modificar ou apagar uma palavra, clique nessa palavra.  Para criar uma palavra nova de substitui��o clique no bot�o Nova palavra.",
    wordmanager => "Manuten��o de palavras",
    word => "Palavra",
    replacmentword => "Palavra de substitui��o",
    newword => "Nova palavra"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => '�ltimas 10 c�pias de seguran�a',
    do_backup => 'Fazer c�pia',
    backup_successful => 'C�pia efectuada com sucesso.',
    no_backups => 'Nenhuma c�pia de seguran�a efectuada at� ao momento',
    db_explanation => 'Para criar uma c�pia de seguran�a prima o bot�o a seguir',
    not_found => "Caminho incorrecto ou o utilit�rio mysqldump n�o � execut�vel.<br>Verifique a defini��o de <strong>\$_DB_mysqldump_path</strong> em config.php.<br>Variavel actualmente definida como: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Erro na c�pia: O tamanho do ficheiro � 0 bytes',
    path_not_found => "{$_CONF['backup_path']} n�o existe ou n�o � uma directoria",
    no_access => "ERRO: A directoria {$_CONF['backup_path']} n�o est� acess�vel.",
    backup_file => 'Ficheiro da c�pia',
    size => 'Tamanho',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "In�cio",
    2 => "Contacto",
    3 => "Publicar",
    4 => "Liga��es",
    5 => "Vota��es",
    6 => "Calend�rio",
    7 => "Estat�sticas",
    8 => "Personalizar",
    9 => "Pesquisar",
    10 => "pesquisa avan�ada"
);

$LANG_404 = array(
    1 => "Erro 404",
    2 => "Procurei em todo o lado mas n�o encontrei <b>%s</b>.",
    3 => "<p>Pedimos desculpa, mas o ficheiro que pediu n�o existe. Sinta-se � vontade e verifique na <a href=\"{$_CONF['site_url']}\">p�gina principal</a> ou na <a href=\"{$_CONF['site_url']}/search.php\">p�gina de pesquisa</a> para tentar encontrar o que perdeu."
);

$LANG_LOGIN = array (
    1 => 'Login necess�rio',
    2 => 'Queira desculpar, para aceder a esta �rea necessita de efectuar o login como utilizador.',
    3 => 'Login',
    4 => 'Novo utilizador'
);

?>
