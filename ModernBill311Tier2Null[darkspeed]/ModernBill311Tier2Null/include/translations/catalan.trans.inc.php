<?
/*
** ModernBill [TM] (Copyright::2001)
** Questions? webmaster@modernbill.com
**
** THIS IS THE CATALAN TRANSLATION FILE
**
** To translate into a new language:
**    1) copy this file to your_language.trans.inc.php
**    2) add your_language to the $language_types array
**       in include/misc/sb_select_menus.inc.php
**
** TRADU�T PER "PROYECTO eXParTaKus" - Rosa Giner Galva� (webmaster@expartakus.com)
**
*/
define(CHARSET,           "ISO-8859-1");
define(TEXTDIRECTION,     "LTR"); //dir = LTR | RTL
define(TABLE_ALIGN,       "left");

## VERSION 3.0 ADDITIONS

# v3 - Misc Dates
define(SUN,               "Diumenge");
define(MON,               "Dilluns");
define(TUE,               "Dimarts");
define(WED,               "Dimecres");
define(THR,               "Dijous");
define(FRI,               "Divendres");
define(SAT,               "Dissabte");

# v3 - Misc Domain Terms
define(THREEYEARS,        "3 Anys");
define(FOURYEARS,         "4 Anys");
define(FIVEYEARS,         "5 Anys");
define(SIXYEARS,          "6 Anys");
define(SEVENYEARS,        "7 Anys");
define(EIGHTYEARS,        "8 Anys");
define(NINEYEARS,         "9 Anys");
define(TENYEARS,          "10 Anys");

# v3 - A
define(ACCOUNTREGISTER,    "Registrar compte");
define(ADDFEATURE,         "Afegir Caracter�stiques");
define(ADDONS,             "Suplements");
define(ADDTOORDER,         "Afegir a la seva comanda!");
define(ADDTOMYACCOUNT,     "Continu� (Afegir al meu compte)");
define(ADDITIONALINFO,     "Afegir Informaci�");
define(AFFILIATES,         "Afiliats");
define(AFFILIATECONFIG,    "Configuraci� d'afiliats");
define(AFFCODE,            "Codi");
define(AFFHITS,            "Hits");
define(AFFCOUNT,           "Compte");
define(AFFPAYTYPE,         "Tipus");
define(AFFPAYSUM,          "Sum");
define(ALLOWAUTOSEARCH,    "Permetre recerques");
define(ALLHOSTS,           "Recerca en subdominis");
define(AMERICANEXPRESS,    "American Express");
define(ANSWER,             "Resposta");
define(APPLYCOUPON,        "Validar");
define(AVERAGE,            "Mitjana");
define(APPLYTAX,           "Aplicar impostos");
define(ARINWHOIS,          "ARIN Whois: Registre americ� de n�meros d'Internet");
define(ASSIGNTOME,         "Obrir i assignar-me");
define(AUTOSIGNUPFORM,     "Formulari d'auto-inscripci�");

# v3 - B
define(BANNED,             "Banned");
define(BANNEDCONFIG,       "Banned Setup");
define(BANNEDIP,           "Banned IP Addresses");
define(BANNEDEMAIL,        "Banned Email Addresses");
define(BANKNAME,           "Nom del banc");
define(BADLOGIN,           "Error. El seu email o la seva contrasenya �s incorrecta. Si us plau, intenti de nou.");
define(BANKABACODE,        "Codi de compte bancari ABA");
define(BANKACCOUNTNUM,     "N�mero de compte bancari");
define(BUILDPACKAGE,       "Faci el seu paquet");

# v3 - C
define(CACHE,              "Cache");
define(CATEGORY,           "Categoria");
define(COPYTHEMEDIR,       "Copi� el directori theme per defecte i reanomeni'l.<br><br>EX: include/config/theme/NEWDIR");
define(CANCELED,           "Cancel�lat");
define(CCEXPIRED,          "CC Exp Data");
define(CCEXPEMAILS,        "Missatges de targeta de cr�dit caducades");
define(CHECKTOSEND,        "Marcar per a enviar un e-mail de recepci�.");
define(CHILDREN,           "Fills");
define(CHILDINSTRUCTIONS,  "[+] = Afegir un fill al paquet, [-] = Llevar un fill del paquet");
define(CLIENTINFO,         "Informaci� del client");
define(CLIENTREGISTER,     "Registre de clients");
define(CLIENTPACKS2,       "Ingressos mensuals estimats per nous paquets!");
define(CLOSED,             "Tancat");
define(CLEARBATCH,         "Netejar s�rie");
define(CLOSETHISWIN,       "Tancar finestra");
define(CLOSECALL,          "Tancar Ticket(s)");
define(CLOSETHISWIN,       "Tancar aquesta finestra");
define(COUNT,              "Hits");
define(CREATENEWTHEME,     "Afegir un nou Theme.");
define(COST,               "Cost");
define(COUPONS,            "Bons");
define(COUPONCODE,         "Codi del bo");
define(COUPONCODES,        "Codis dels bons");
define(COUPONCONFIG,       "Configuraci� de bons");
define(COUPONSTATS,        "Estad�stiques de bons");
define(COUPONSEARCH,       "Recerca de bons");
define(COUPONCOUNT,        "Compte");
define(COPYVORTECHDIR,     "Copi� el directori Vortech \"signup\" per defecte i reanomeni'l.");
define(CPU,                "CPU");
define(CREATENEWVORTECH,   "Afegir un nou formulari d'inscripci� Vortech.");
define(CREATEYOUROWN,      "Ajudant d'exportaci� de la base de dades");
define(CURRENTPHPVERSION,  "Versi� actual de PHP");
define(CUTERROR,           "Retallar i Apegar<br>Error Rebut");
define(CREATECALL,         "Crear una crida");
define(COUPON,             "Bo");
define(CARDCODE,           "Codi de seguretat");
define(CHECKAVAIL,         "Comprovar disponibilitat");
define(COMPLETESECTIONA,   "Completar Secci� A");
define(COMPLETESECTIONB,   "Completar Secci� B");
define(CORRECTMYDATA,      "Corregir la meva informaci�");
define(CREDITCARDINFO,     "Informaci� de la targeta de cr�dit");
define(CVV2IS,             "<b>CVV2</b> �s un nou projecte de verificaci� establit per les companyies de targetes de cr�dit per unir esfor�os amb l'objectiu de reduir el frau a les transaccions mitjan�ant Internet. Consistix a sol�licitar al client el n�mero CVV2 en cada una de les transaccions per verificar que posse�x la targeta.");
define(CVV2VISA,           "Aquest n�mero est� impr�s en les targetes MasterCard i Visa en l'�rea de la firma, en la part posterior de la targeta. (S�n els 3 �ltims d�gits DESPR�S del n�mero de la targeta en l'�rea de la firma).");
define(CVV2AMEX,           "Les targetes American Express tenen el cvv2 impr�s a la dreta i dalt del n�mero de la targeta al front.");
# v3 - D
define(DRIVERSLICENSE,     "N�mero del perm�s de conduir");
define(DRIVERSESTATE,      "Lloc d'expidici� del perm�s de conduir");
define(DRIVERSDOB,         "Data de naixement");
define(DOMAINERROR,        "Si us plau, entri un nom de domini v�lid.");
define(DOMSEARCHRESULTS,   "Resultats de la recerca de dominis");
define(DUPLICATEUSER,      "Error. Aquesta direcci� d'email ja est� al nostre sistema.Si us plau, intenti de nou.");
define(DATE,               "Data");
define(DAYSBEFORE,         "Dies per a la renovaci�");
define(DEBIT,              "Deute");
define(DEBUG,              "Eixida de comprovaci�");
define(DEBITS,             "Deutes");
define(DBTABLE,            "Taula de base de dades");
define(DBEXPORT,           "Exportaci� de base de dades");
define(DEFAULTCURRENCY,    "Moneda per defecte");
define(DEFAULTTRANSLATION, "Idioma per defecte");
define(DEFAULTEMAILSTYPE,  "Tipus d'email per defecte");
define(DOLLARDISCOUNT,     "Descomptes");
define(DOMREPORTS,         "Dominis i informes");

# v3 - E
define(ECHECKINFO,         "eCheck Information");
define(EMAILERROR,         "El seu email no �s correcte. Si us plau, intenti de nou.");
define(EXISTINGCUSTOMERS,  "CLIENTS EXISTENTS");
define(EXISTCUSTTEXT,      "Entri al seu compte per afegir aquesta comanda.");
define(EDITTHEMECONFIGFILE,"Editi l'arxiu theme.config.inc.php i defineixi la variable \$config_type amb el NOU valor \"theme_??\".");
define(EDITNEWVORTECHVARIABLES,"Editi el <b>Vortech: \"vortech_type??\"</b> que ha creat dalt.");
define(EDITNEWTHEMEVARIABLES,"Editi el <b>Theme: \"theme_??\"</b> que ha creat dalt.");
define(EDITVORTECHCONFIGFILE,"Editi l'arxiu config.php al nou directori Vortech i defineixi la variable \$config_type amb el NOU valor \"vortech_type??\".");
define(EMAILTEMPLATES,     "Plantilles d'email");
define(EMERGENCY,          "Emerg�ncia");
define(ENCRYPTIONKEYREASON,"�s necessari per desencriptar n�meros de targetes de cr�dit.");
define(ENDDATE,            "Data de caducitat");
define(ENTERTRANSACTION,   "Realitzar transacci�");
define(EXTENSION,          "Extensi�");
define(EXPIREDTEXT,        "Text de caducitat");
define(EXPIRED,            "Caducat");
define(ERRORPLEASETRYAGAIN,"<b>ATENCI�:</b> El seu email no s'ha trobat i el seu acc�s des de <b>$REMOTE_ADDR</b> ha quedat registrat.");

# v3 - F
define(FAQCONFIG,          "Configuraci� de les FAQ");
define(FAQSEARCH,          "Recerca de les FAQ");
define(FAQSTATS,           "Estad�stiques de les FAQ");
define(FAQQUESTIONS,       "Preguntes de les FAQ");
define(FAQCATEGORIES,      "Categories de les FAQ");
define(FORGOTYOURPASSWORD, "Ha oblidat la seva contrasenya?");
define(FORMAT,             "Format");
define(FRAUD,              "Frau");

# v3 - G
define(GENERALEMAILS,      "Emails generals");
define(GENINVOICE,         "Factura produ�da");

# v3 - H
define(HOST,               "Host");
define(HOST2IP,            "Nom de Host a IP");
define(HAVEACOUPON,        "T� un bo? Entri aqu�!");

# v3 - I
define(IAMANEWCUSTOMER,    "Continu� (S�c un nou client)");
define(ISAVAILABLE,        "ESt� disponible! Demani Ara");
define(INVOICEEMAILS,      "Emails relacionats amb la factura");
define(INSERTVORTECHDEFAULTCONFIG,"Afegeixi una taula de configuraci� per defecte a la base de dades usant el nom Vortech del pas 2. El format ha de ser vortech_typeX on X �s el n�mero seg�ent en la sequ�ncia.");
define(INSERTTHEMEDEFAULTCONFIG,"Afegeixi una taula de configuraci� per defecte a la base de dades usant el nom theme del pas 2. El format ha de ser theme_NEWNAME.");
define(IP2HOST,            "IP a Nom de Host");
define(INVOICECAPS,        "F A C T U R A");
define(INVOICESPARTIAL,    "Factures parcials");

# v3 - J

# v3 - K
define(KERNAL,             "Kernal");

# v3 - L
define(LAUNCHTOOLS,        "Llan�ar Ferramentes");
define(LOGIN,              "Entrar");

# v3 - M
define(MAINPACKAGE,       "Paquet Principal");
define(MAXREDEMPTIONS,    "Max Redm.");
define(MANUALPAYMENT,     "Pagament Manual");
define(MARGIN,            "Marge");
define(MBSUPPORT,         "Suport ModernBill");
define(MBMANUAL,          "ModernBill Manual i FAQ");
define(MBFORUMS,          "F�rums de suport ModernBill");
define(MBINFO,            "Informaci� ModernBill");
define(MBDOWNLOADS,       "Desc�rregues ModernBill");
define(MBNEWS,            "Not�cies i anuncis ModernBill");
define(MBRESELLERS,       "Revenedors ModernBill");
define(MBVERSION,         "�ltima versi�");
define(MENU,              "Men�");
define(MGHZ,              "Processador(s) MHz");
define(MXRECORDS,         "Registres MX");
define(MYSUPPORT,           "El meu Suport");
define(MONTH,             "Seleccionar Mes");
define(M_JANUARY,         "Gener");
define(M_FEBRUARY,        "Febrer");
define(M_MARCH,           "Mar�");
define(M_APRIL,           "Abril");
define(M_MAY,             "Maig");
define(M_JUNE,            "Juny");
define(M_JULY,            "Juliol");
define(M_AUGUST,          "Agost");
define(M_SEPTEMBER,       "Setembre");
define(M_OCTOBER,         "Octubre");
define(M_NOVEMBER,        "Novembre");
define(M_DECEMBER,        "Decembre");
define(MYSQL,             "MySQL");
define(MSSQL,             "MsSQL");

# v3 - N
define(NETWORKINGTOOLS,   "Ferramentes de treball a la red");
define(NUMBER,            "Compte");
define(NEWPACKAGES,       "Nous Paquets");
define(NETTOOLSTEXT,      "<b>NOTA:</b> Algunes consultes usen la funci� \"system\" i pot _NO_ funcionar si la seva instalaci� de php t� habilitat el safe_mode O si vost� est� en un servidor WINDOWS.");
define(NEWCLIENTSONLY,    "Nom�s nous clients");
define(NEWTHISWEEK,       "Nous registres d'aquesta setmana");
define(NEWCALL,           "Nova crida");
define(NEWCUSTOMERS,      "NOUS CLIENTS");
define(NEWCUSTTEXT,       "Si us plau, entri el seu email<br>per a crear un nou compte.");
define(NOSPACEALLOWED,    "No es permeten espais al camp Host!");
define(NSLOOKUP,          "Comprovaci� del servidor de noms");

# v3 - O
define(OPEN,              "Obrir");
define(OPTIMIZEGOOD,      "Taules Optimitzades = <b>OK</b>");
define(OPTIMIZEBAD,       "Taula Optimitzada = <b>NO OK</b>");
define(OS,                "OS");
define(OTHERINFO,         "Altra Informaci�");
define(ORSELECTB,         "O seleccioni B");
define(ORSELECTC,         "O seleccioni C");
define(ORDERCRESULTS,     "Resultats de les comandes");

# v3 - P
define(PACKAGEADDONS,     "Millori el seu paquet");
define(PLEASEVERIFY,      "Si us plau, verifiqui la seva comanda i envi�'l per a processar-la.");
define(PRORATE,           "Haver");
define(PROGRESS,          "Estat de la comanda");
define(PRIMARYEMAIL,      "Email Primari");
define(PARENT,            "Pare");
define(PASSWORDREMINDER,  "Recordatori de contrasenya");
define(PACKAGERELATIONSHIPS,"Relacions de paquets");
define(PRECENTDISCOUNT,   "% de descompte");
define(PRINTSCREEN,       "Imprimir Pantalla");
define(PRICEOVERRIDE,     "Price Override");
define(PLEASESELECTCAT,   "Si us plau, seleccioni una categoria.");
define(PHPINFORMATION,    "Informaci� PHP");
define(PHPSETTINGS,       "Definicions PHP");
define(PING,              "Ping");
define(PORT,              "Port");
define(POSTGRES,          "PostGres");
define(PROFIT,            "Benefici");
define(PROCESSING,        "Processant");

# v3 - Q
define(QUESTION,          "Pregunta");
define(QUICKPAYMENTS,     "Pagaments r�pids");

# v3 - R
define(RAWPASSWORD,       "Contrasenya sense processar");
define(RESPONSE,          "Resposta");
define(RENEWPACKAGES,     "Paquets renovats");
define(REMINDME,          "Recordatori");
define(REGISTERBALANCE,   "Balan� de registre");
define(REGISTEREDON,      "Registrat");
define(REQUIREDFILEDS,    "Si us plau, ompli� tots els camps obligatoris <font color=\"red\">*</font>.");
define(REGISTERED,        "Registrat");

# v3 - S
define(SALESTAX,          "Impostos de venda");
define(SEARCHTRANSACTIONS,"Recerca de transaccions");
define(SECURELOGIN,       "Servidor segur");
define(SECONDARYCONTACT,  "Segon Contact");
define(SECONDARYEMAIL,    "Segon Email");
define(SERVERINFO,        "Informaci� del Servidor");
define(SERVERSTATS,       "Estad�stiques del Servidor");
define(SETUPRELATION,     "Configuraci� de fills");
define(SETTINGS,          "Definicions");
define(SELECTEMAIL,       "Seleccioni plantilla d'email");
define(SELECTPACKAGE,     "Seleccioni Paquet");
define(SELECTINVOICE,     "Seleccioni Factura");
define(SETACTIVE,         "Activar");
define(SUPPORT,           "Suport");
define(SUPPORTDESK,       "Suport");
define(SUPPORTSEARCH,     "Buscar suport");
define(SYSTEMTIME,        "Hora del sistema");
define(SYSTEMUTILITIES,   "Utilitats del sistema");
define(SYSTEMSETUP,       "Configuraci� del sistema");
define(SUPPORTLOGS,       "Logs de Suport");
define(SEARCHAGAIN,       "Buscar de nou");
define(SECONDARYCONTACTNAME,"Segon Contact");
define(SECTIONA,          "Secci� A");
define(SECTIONB,          "Secci� B");
define(SELECT2,           "Seleccionar");
define(SELECTA,           "Seleccionar A");
define(SELECTPACKAGE,     "Seleccionar el seu paquet");
define(SIGNUPINVOICE,     "Registrar factura");
define(SIGNUPPAYMENT,     "Registrar pagament");
define(SIGNINTOADDTOYOURACCOUNT,"Entri per afegir aquesta comanda al seu compte.");
define(SKIPDOMAIN,        "No cal un domini");
define(STARTOVER,         "Comen�ar de nou");

# v3 - T
define(THISORDERADDED,    "<br>Aquesta comanda s'ha afegit al seu compte.<br><br> Vost� pot entrar per veure o perpagar la seva factura online.<br>");
define(TRANSFERMYDOMAIN,  "Transferir el meu domini");
define(TECH,              "Tech");
define(TLDCONFIG,         "Configuraci� TLD");
define(TLDSTATS,          "Estad�stiques TLD");
define(TRACEROUTE,        "TraceRoute");
define(TOTALAFFILIATEHITS,"Total de hits dels afiliats actius.");
define(TOTALCOUPONHITS,   "Total de hits de bons actius.");

# v3 - U
define(UPGRADETEXT,       "Vost� hauria de considerar actualitzar la seva versi�!");
define(UPGRADENOTNEEDED,  "Vost� t� l'�ltima versi�!");
define(UPTIME,            "Uptime");
define(UTILITIES,         "Utilitats");
define(UPDATE,            "Actualitzar");
define(USER,              "Usuari");

# v3 - V
define(VAT,               "V.A.T.");
define(VIEWGRAPH,         "Veure Gr�fic");
define(VIEWFEATURES,      "Veure Caracter�stiques");
define(VORTECHPACKAGESETUP,"Donar d'alta el paquet Setup & Stats");
define(VALIDATEEMAIL,     "Validar Email");
define(VERIFYPASSWORD,    "Verificar Contrasenya");
define(VERIFYMYORDER,     "Verificar la meva comanda");
define(VISAMASTERCARD,    "Visa &amp; MasterCard");

# v3 - W
define(WELCOMEEMAIL,      "Email de benvinguda");
define(WHOISMATCH,        "S�rie Whois");
define(WHOISSERVER,       "Servidor Whois");
define(WHATISCVV2,        "Qu� �s el n�mero CVV2?");

# v3 - Y
define(YOURVERSION,       "La seva Versi�");
define(YOURLOGININFORMATION,"La seva informaci� d'entrada");
define(YOURLOGININFOEMAILED,"La seva informaci� d'entrada <br>se li ha enviat per email.");
define(YOURCUSTOMORDER,   "Resumen de la seva comanda");

##
##
##
##
##

## VERSION 2.02 ADDITIONS (NOT COMPLETE)
define(UPDATESTATUS,      "Actualitzar");
define(DELETEALL,         "Suprimir tots");
define(TOTALDECLINED,     "Total de c�rrecs no aprovats");
define(TOTALERROR,        "Total d'errors als c�rrecs");
define(NORENEWAL,         "NO RENOVAR");

## VERSION 2.0 ADDITIONS (NOT COMPLETE)
define(ACCOUNTDBS,        "BDs del compte");
define(ACCOUNTPOPS,       "POPs del compte");
define(ADMINCONFIG,       "Configuraci� d'Administraci�");
define(APPLYPAYMENTSOR,   "Aplicar pagaments o reenviar factures!");
define(BYCLIENT,          "Per nom del client");
define(BYDOMAIN,          "Per nom de domini");
define(BYEMAIL,           "Per compte de correu");
define(CLIENTPACKS,       "Paquets del client ... Gan�ncia estimada mensual!");
define(CONFIG,            "Configuraci�");
define(CONFIRMEMAIL,      "Confirmi el seu email");
define(CURRENTEMAIL,      "El seu email actual");
define(DBT,               "Tipus de BD");
define(DOMAINEXT,         "Extensi�");
define(DOMAINSTATSSEE,    "Estad�stiqes del domini ... Vore detalls!");
define(MAINCONFIG,        "Configuraci� Principal");
define(NEWCLIENTS,        "Nous clients ... Activacions i Canviar estat!");
define(NEWTODOITEMS,      "Noves entrades ... Si us plau vegi!");
define(PAYMENTSCONFIG,    "Configuraci� de pagaments");
define(PAYWITHWORLDPAY,   "Pagar amb WorldPay");
define(QUICKSTATS,        "Estad�stiques r�pides");
define(QUICKFIND,         "Buscar r�pid");
define(SELECT,            "--- Seleccionar ---");
define(SEEDETAILS,        "Vore detalls");
define(SETTLE,            "Settle");
define(SUBTOTAL,          "Sub-Total");
define(SYSTEMCONFIG,      "Configuraci� del sistema");
define(SYSTEMDISPLAY,     "Desplegament del sistema");
define(TAXDUE,            "Impostos que es deuen");
define(THEMEBLUECONFIG,   "Tema: Blue Config");
define(THEMEGREENCONFIG,  "Tema: Green Config");
define(THEMEDEFAULTCONFIG,"Tema: Default Config");
define(TOTALPACKAGES,     "Total de paquets");
define(VORTECHCONFIG,     "Vortech Signup Config Type1");
define(VORTECHCONFIG2,    "Vortech Signup Config Type2");
define(VORTECHSF,         "Vortech Signup Form");
define(WHATSTHIS,         "�Qu� �s aix�?");
define(WHOISSTATS,        "Estad�stiques del Whois");
define(WORLDPAY,          "WorldPay");

## A-Z Listing of ENGLISH Defines
# <-- Added For Vortech Signoff Form --> #
define(ACCOUNTINFO,       "Informaci� del seu compte");
define(ACCOUNTSETUPASAP,  "El seu compte ser� activat en breu.");
define(ADDFRONTPAGE,      "Afegir extensions de FrontPage");
define(ANINVOICESENT,     "Se li ha enviat un rebut/confirmaci�.");
define(CALCPRICE,         "Calcular preu");
define(CARDTYPE,          "Tipus de targeta");
define(CCCODE,            "CVV2/CVC2");
define(CHANGEPACKAGE,     "Canviar paquet o temps de contractaci�");
define(CHECK,             "Xec");
define(CHECKINVOICE,      "Xec/Factura");
define(CHOOSEAPACKAGE,    "Tri� un paquet de hosting");
define(CLEAR,             "Suprimir");
define(CONFIGERROR,       "Les configuracions no coincidixen. Si us plau, corrigeixi aquest error en les configuracions.");
define(CONTRACTTERM,      "Temps de contractaci�");
define(CONTACTINFO,       "Informaci� de contacte");
define(CREDITCARD,        "Targeta de cr�dit");
define(DATATRASNFER,      "Transfer�ncia de dades");
define(DOMAINNAMESEARCH,  "Buscador de dominis");
define(DOMAINSTATUS,      "Informaci� sobre el domini");
define(DOMAINSTATUSREG,   "Informaci�: No disponible - No es pot registrar.");
define(DOMAINVERIFICATION,"Verificaci� del domini");
define(DONOTREGISTER,     "NO pot registrar-ho en aquest moment.");
define(ERRORS,            "Error(s)");
define(FEADDRESS,         "Si us plau escrigui el seu nom complet!");
define(FECCINFO,          "Si us plau completi tots els camps referents a la targeta de cr�dit!");
define(FECCINVALID,       "El seu n�mero de targeta de cr�dit �s inv�lid!");
define(FEDOMAIN,          "El nom de domini est� incorrecte o falta!");
define(FEEMAIL,           "El seu compte de correu est� incorrecte!");
define(FEEXPDATE,         "La data de caducitat de la seva targeta �s incorrecta!");
define(FENAME,            "Si us plau escrigui el seu nom!");
define(FEUSERNAME,        "Tri� un nom d'usuari!");
define(FEPASSWORD,        "Les contrasenyes no coincidixen!");
define(FEPAYMENT,         "Hi ha un error amb el m�tode de pagament!");
define(FEPHONE,           "Si us plau escrigui el seu n�mero de tel�fon!");
define(FETERMS,           "No ha acceptat els \"Termes i condicions d'�s\"!");
define(FREE,              "GRATIS");
define(FRONTPAGE,         "FrontPage");
define(FOR1YEAR,          "per 1 any");
define(FOR2YEARS,         "per 2 anys");
define(FRAUDCHECK1,       "Per a la prevenci� de fraus, hem");
define(FRAUDCHECK2,       "gravat la seva adre�a IP");
define(FRAUDCHECK3,       "gravat l'hora del seu enviament");
define(IHAVEREAD,         "He llegit i acceptat els termes i condicions d'�s");
define(MYSQLDB,           "Base de dades MySQL");
define(NOIAMNOTTHEOWNER,  "No, no s�c l'amo de");
define(NOMATCH,           "No Match");
define(OTS,               "Activaci� una sola vegada");
define(ONEYEAR,           "1 any");
define(PAYMENTMETHOD,     "M�tode de pagament");
define(PAYWITHPAYPAL,     "Ja pot pagar amb PayPal al fer click en el seg�ent enlla�:");
define(PAYPAL,            "PayPal");
define(PPT,               "Preu per temps");
define(PRA,               "Havers d'aquest mes");
define(PLEASEGOBACK,      "Si us plau torni per a");
define(PLEASETRYAGAIN,    "Provi de nou.");
define(PLEASEPRINT,       "Si us plau imprimeixi aquesta p�gina com a rebut i/o comprovaci�.");
define(PLEASEPICKADOMAIN, "Tri� el domini que vullgui utilitzar per usar-lo amb algun paquet de
hosting.");
define(PROCESSMYORDER,    "Processar la meva comanda");
define(PURCHASES,         "Compra(es)");
define(PURCHASEINFO,      "Informaci� de la seva compra");
define(REFERREDBY,        "Referit per");
define(REGFEE,            "Quota de registre");
define(REGISTER,          "Registrar");
define(REGISTERDOMAIN,    "Registrar domini");
define(REGISTERFORME,     "Registrar aquest domini per a vost� per");
define(RESULTSFOR,        "Resultats per");
define(RESULTS,           "Resultats");
define(SENDPAYMENTTO,     "Enviar pagaments a");
define(SENDQUESTIONS,     "Enviar preguntes a");
define(SERVICESIGNUP,     "Serveis");
define(SIGNUPCOMPLETED,   "Proc�s completat!");
define(SIGNUPEMAILSUBJECT,"Rebut/Factura per");
define(SUBMITINFO,        "Enviar informaci�");
define(SUBMITCHECK1,      "Abans d'enviar estigui segur del seg�ent");
define(SUBMITCHECK2,      "tota la informaci� necess�ria ha estat completada");
define(SUBMITCHECK3,      "tota la informaci� no cont� errors");
define(SUBMITCHECK4,      "tota la informaci� est� assegurada i est� lliure de frau");
define(SKIPERROR1,        "Est� tractant de saltar-se passos per");
define(SKIPERROR2,        "Serveis.");
define(STEP4,             "Pas 4");
define(STEP5,             "Pas 5");
define(THANKYOUFOR,       "Gr�cies per registrar-se en");
define(THEREARENOPACKS,   "No hi ha paquets de hosting disponibles");
define(THISDOMAININVALID, "Aquest domini �s incorrecte.");
define(TRANSFER,          "Transferir");
define(TWOYEARS,          "2 anys");
define(VIEWSITE,          "Veure lloc");
define(VIEWWHOIS,         "Veure resultats del WHOIS");
define(WEBSPACE,          "Webspace");
define(YESIAMTHEOWNER,    "S�, s�c l'amo");
define(YEARREG,           "Registre per un any");
define(ZIPPOSTAL,         "Codi postal");

# <-- Added in Version 1.9.3 --> #
define(BILLINGINFO,       "Informaci� de pagament");
define(CARDINFORMATION,   "Informaci� de targeta de cr�dit");
define(CARDHOLDER,        "Nom que apareix en la seva targeta");
define(CARDBANK,          "Banc emissor");
define(CCNUMBER,          "N�mero de la targeta");
define(CLICKONLYONCE,     "FACI CLICK UNA SOLA VEGADA PER PROCESSAR LA SEVA COMANDA.");
define(CONTINUE_t,        "Continuar");
define(CUSTOMSIGNUPEMAIL, "Activar email");
define(DISPLAY,           "Desplegar");
define(EXPDATELONG,       "Data de caducitat");
define(PACKINFOSELECT,    "Informaci� de paquet(s)");
define(PLEASEVERIFY,      "Verifiqui les seves dades abans de processar la seva comanda.");
define(PLEASEFILLINALL,   "Si us plau, completi tots els camps obligatoris $is_required .");
define(SIGNUPDISPLAY,     "Activar forma de registre");
define(TELEPHONE,         "Tel�fon");
define(VIEWCC,            "Veure CC desencriptada");
define(YOUWILLVERIFY,     "�ltima oportunitat per verificar les seves dades abans de processar.");

# <-- Added in Version 1.9.2 --> #
define(NOMATCHESFOUND,    "No es van trobar entrades que corresponguen a la seva recerca.");
define(PACKAGESUMMARY,    "Resum de paquets");
define(DOMAINSUMMARY,     "Resum de dominis");
define(INVOICESUMMARY,    "Resum de facturaci�");
define(NEXTRENEWAL,       "Seg�ent renovaci�");
define(PRORATED,          "Havers");
define(PAYPERIOD,         "Per�ode de pagament");
define(SUBTOTAL,          "Sub Total");
define(CREDIT,            "Cr�dit");

# A
define(ACCESSDENIED,      "Acc�s denegat");
define(ACCOUNT,           "Compte");
define(ACCOUNTDETAILS,    "Detalls de compte");
define(ACTION,            "acci�");
define(ACTIVE,            "Actiu");
define(ADD,               "afegir");
define(ADDRESS,           "Direcci�");
define(ADDITIONALSQL,     "Formats d'ajuda addicionals per SQL");
define(ADMIN,             "Administraci�");
define(ALL,               "TOTS");
define(ALLINVOICE,        "Tots els comptes de correu en facturaci�.");
define(ALLGENERAL,        "Tots els comptes de correu generals.");
define(ALREADYCLICKED,    "Ja ha fet click en el bot� una vegada. Si us plau, esperi...");
define(AMEX,              "American Express");
define(AMOUNT,            "Quantitat");
define(AMOUNTPAID,        "Quantitat pagada");
define(ANNUALLY,          "Anualment");
define(AUTHCODE,          "Codi d'Autoritzaci�");
define(AUTHNETBATCH,      "C�rrecs autom�tics amb Authorize.net");
define(AUTHRET,           "AuthRet");
define(AUTOUPDATED,       "Actualitzaci� autom�tica");
define(APPLYPAYMENT,      "Aplicar pagaments");
define(ASPERCENTAGE,      "com percentatge");
define(AVS,               "AVS");
define(AVSCODE,           "Codi AVS");
# B
define(BATCH,             "C�rrecs autom�tics");
define(BATCHDATE,         "Data de c�rrecs autom�tics");
define(BATCHDATEINVLAID,  "Data de c�rrecs autom�tics incorrecta");
define(BATCHDETAILS,      "Detalls de c�rrecs autom�tics");
define(BATCHID,           "IDc�rrec");
define(BATCHINFO,         "Informaci� de c�rrecs autom�tics");
define(BATCHREPORTS,      "Informes de c�rrecs autom�tics");
define(BATCHSETUP,        "Preparaci� de c�rrecs autom�tics");
define(BILLINGCYCLE,      "Cicle de pagaments");
define(BILLINGMETHOD,     "M�tode de pagament");
define(BILLINGREPORTS,    "Informes de pagaments");
define(BODY,              "Contingut del missatge");
define(BYMONTH,           "Per mes (YYYY/MM)");

# C
define(CANNOTSAY,         "No es pot dir");
define(CC,                "TC");
define(CCA,               "Afegir cr�dit al client");
define(CCBATCH,           "C�rrecs autom�tics amb TC");
define(CCEXAMPLETRANSLATE,"Tipus de TC i els �ltims 4 d�gits de la targeta en arxiu: Ex. MasterCard - 0005");
define(CCNUM,             "N�mero de TC");
define(CCNUMINVALID,      "Targeta de cr�dit incorrecta");
define(CCSINGLE,          "TC nom�s");
define(CHANGECLIENTPW,    "Canviar contrasenya del client");
define(CHANGEMYPASSWORD,  "Canviar la meva contrasenya");
define(CHARGEIT,          "Fer c�rrec");
define(CHECK,             "Xec o enviament de diners");
define(CHECKFORPRINT,     "<i>Versi� per imprimir</i>.");
define(CLASSICBLUE,       "Blau cl�ssic");
define(CLIENT,            "Client");
define(CLIENTNOTES,       "Notes del client");
define(CLIENTPWNOMATCH,   "Les contrasenyes del client no coincidixen");
define(CLIENTPWTOOSHORT,  "La contrasenya del client �s molt curta");
define(CLIENTREPORTS,     "Informes del client");
define(CLIENTID,          "IDclient");
define(CLIENTS,           "Clients");
define(CLIENTSEARCH,      "Buscar clients");
define(CLIENTSTATUS,      "Estatus del client");
define(CLIENTSTATS,       "Estad�stiques del client");
define(CLIENTADMIN,       "Administraci� de Clients");
define(CONTACTUS,         "Contacta'ns");
define(CONTINUETOCOMPOSE, "Continu� per redactar el seu email");
define(CITY,              "Ciutat");
define(COMINGSOON,        "Prompte en l�nia");
define(COMMENTS,          "Comentaris");
define(COMPANY,           "Empresa");
define(COMPORDOM,         "Empresa o nom de domini");
define(COMPLETED,         "Completat");
define(COMPOSE,           "Compondre");
define(CONTACTINFO,       "Informaci� de contacte");
define(COUNTRY,           "Pa�s");
define(COUNTRYEXAMPLE,    "EX: \"MX\"");
define(CREATEDON,         "Creat el");
define(CREATEDINVALID,    "Data de creaci� incorrecta");
define(CREDITS,           "Cr�dits");
define(CURRENT_BATCH,     "C�rrecs autom�tics actuals");
define(CURRENTPW,         "Contrasenya actual");

# D
define(DATECREATED,       "Data de creaci�");
define(DATEFORMAT,        "MM/YYYY");
define(DATEFORMAT2,       "YYYY/MM/DD");
define(DATEFORMAT3,       "YYYY/MM/01");
define(DATEPAID,          "Data de pagament");
define(DBN,               "Nom de la BD");
define(DBU,               "Usuari de la BD");
define(DBP,               "Contrasenya de la DB");
define(DEFAULTMB,         "Default");
define(DESCRIPTION,       "Descripci�");
define(DETAILS,           "Detalls");
define(DINERSCLUB,        "Diners Club/Carte Blanche");
define(DISCOVER,          "Discover Card");
define(DISCOUNT,          "Descompte");
define(DOADD,             "Afegir nou");
define(DOEDIT,            "Editar");
define(DOMAIN,            "Domini");
define(DOMAINS,           "Dominis");
define(DOMAINMENU,        "Men� de dominis");
define(DOMAINNAME,        "Nom del domini");
define(DOMAINSTATS,       "Estad�stiques dels dominis");
define(DOMAINREPORTS,     "Informes dels dominis");
define(DOMUSER,           "Usuari Domini");
define(DOMPASS,           "Contrasenya Domini");
define(DOWNLOADNOW,       "Descarregar ara");
define(DETAILS,           "Detalls");
define(DUE,               "Pendents de pagament");
define(DUEDATE,           "Data de pendents de pagament");
define(DUEINVALID,        "Data de pendents de pagament incorrecta");

# E
define(EB,                "Exportar c�rrecs autom�tics");
define(ECHECK,            "Xec electr�nic");
define(EINTAPM,           "Escrigui el n�mero de factura per \"Aplicar despeses\" manualment");
define(EMAIL,             "Email");
define(EMAILCONFIG,       "Configuraci� d'email");
define(EMAILMSG,          "Missatge de l'email");
define(EMAILERRORMSG,     "Hi va haver un error amb el servidor d'email.<br>Intenti de nou en 1
hora.<br>Gr�cies.");
define(EMAILINVALID,      "Email incorrecte");
define(EMAILSHORTCUTS,    "Formats d'ajuda per a enviament de correus");
define(EMAILSUCCESS1,     "El seu email va ser enviat amb �xit a ");
define(EMAILSUCCESS2,     "Permeti de 12-24 hores per una contestaci�.<br>Gr�cies.");
define(EMAILSTATUS,       "Estatus de l'enviament de correu");
define(EMAILSTATS,        "Estad�stiques d'enviaments de correus");
define(EMAILSEARCH,       "Buscar email");
define(EMAILID,           "IDemail");
define(EMAILADMIN,        "Administraci� d'Emails");
define(EXIT_t,            "Eixir");
define(EMPTY_t,           "buida");
define(ENCRYPTCC,         "Encriptar TC");
define(ENCRYPTIONKEY,     "Clau d'encriptaci�");
define(ENGLISH,           "English");
define(ENROUTE,           "enRoute");
define(ERROR,             "error");
define(ERRORPLEASELOGIN,  "Un error ha ocorregut. Connecte's de nou.");
define(EXP,               "Venc.");
define(EXPIRATIONDATE,    "Data de caducitat");
define(EXPIRATIONDATE2,   "Data de caducitat");
define(EXPIRESINVALID,    "Data de caducitat incorrecta");
define(EXPIRES,           "Caduqui");
define(EXPIRING,          "caducitat");
define(EXPIRINGDOM,       "Dominis caducats");
define(EXPORT,            "Exportar");
define(EXPORTBATCH,       "Exportar c�rrecs autom�tics");
define(EXPTHISMONTH,      "Caduquen aquest mes");
define(EXPNEXTMONTH,      "Caduquen al mes seg�ent");

# F
define(FAX,               "Fax");
define(FAXINVALID,        "Tel�fon (Fax) �s incorrecte");
define(FEATURE,           "Caracter�stica");
define(FEATURES,          "Caracter�stiques");
define(FILTER,            "Seleccionar");
define(FIRST,             "Primer");
define(FIRSTNAME,         "Nom");
define(FR,                "Primeres renovacions");
define(FOOTER,            "Peu de p�gina");
define(FOREMAILONLY,      "PER EMAIL_ID \"1\"NOM�S");
define(FORM,              "Forma");
define(FROM,              "De");

# G
define(GI,                "Generar factures");
define(GO,                "Anar");
define(GB,                "Generar c�rrecs autom�tics");
define(GOBACK,            "Anar arrere");

# H
define(HEADING,           "Encap�alament");
define(HELPDOCS,          "Documents d'Ajuda");
define(HELLO,             "Hola");
define(HOME,              "entrada");
define(HIGH,              "Alta");
define(HINT,              "PISTA");
define(HOWDOESITWORK,     "�Com funciona?");
define(HOWDOESITWORKSTEPS,"\"Pas 1\" pot ser aplicat durant qualsevol dia del mes. Actualitzar�
els paquets dels clients autom�ticament!<br><br>\"Pas 2\" prepara els c�rrecs autom�tics.<br><br>\"Pas 3\" fa el proc�s de c�rrecs autom�tics a trav�s d'Authorize.net,
actualitza cada factura, i neta el sistema pel seg�ent mes.<br><br>NOTA: Si exporti els
c�rrecs autom�tics, necessitar� actualitzar manualment les factures i netejar el sistema.");
define(HTMLOUTPUT,        "Aquest �s el format HTML d'eixida de la taula de facturaci�.");

# I
define(ID,                "ID");
define(IDORNUM,           "ID o n�mero de xec");
define(IATB,              "Factures afegides als c�rrecs autom�tics");
define(IFCC,              "Si TC");
define(INACTIVE,          "Inactiu");
define(INVALIDPASSWORD,   "Contrasenya incorrecta");
define(INVNUM,            "N�mero de factura");
define(INVTYPE,           "Tipus de factura");
define(INVANDBILLING,     "Pagaments i Facturaci�");
define(INVNOWDUE,         "Factures pendents de pagament");
define(INVOVERDUE,        "Factures amb deutes");
define(INVOICE,           "Factura");
define(INVOICESTATS,      "Estad�stiques de facturaci�");
define(INVOICESEARCH,     "Buscar factures");
define(INVOICENUM,        "N�mero de factura");
define(INVOICES,          "Factures");
define(INVOICESPAID,      "Factures pagades");
define(INVOICESDUE,       "Factures pendents de pagament");
define(IP,                "IP");
define(IPFORMAT,          "Direcci� IP o domini aparcat");
define(IWRITEOWN,         "Escriure el meu.");

# J
define(JOKER,             "Joker");
define(JCB,               "JCB");

# K
define(KEYWORDS,          "Paraules clau");

# L
define(LANGUAGE,          "Llenguatge");
define(LAST,              "�ltim");
define(LASTNAME,          "Cognom");
define(LEVEL,             "Nivell");
define(LOGINAS,           "Connectar-se com");
define(LOW,               "Baixa");

# M
define(MAKEPAYMENTS,      "Fer pagaments");
define(MASTERCARD,        "MasterCard");
define(MATCHESFOR,        "resultats per");
define(MATCHESFOUND,      "resultats trobats per");
define(MESSAGE,           "Missatge");
define(MEDIUM,            "Medi");
define(MEMBERSINCE,       "Usuari des de");
define(METHOD,            "M�tode");
define(MISC,              "Miscel�l�nies");
define(MISCREPORTS,       "Informes miscel�lanis");
define(MISSINGORINVALID,  "No existix o n�mero de factura incorrecte.");
define(MONITOR,           "Monitorear");
define(MONTHLY,           "Mensual");
define(MORE,              "m�s");
define(MYDOMAINS,         "Els meus dominis");
define(MYINVOICES,        "El meu estat de compte");
define(MYINFORMATION,     "La meva Informaci�");
define(MYMENU,            "El meu men�");
define(MYPACKAGES,        "Els meus paquets");
define(MYSEARCHHELP,      "Pot fer els seus pagaments segurs en l�nia al veure una factura que est� pendent de pagament.<br>Faci click en \"C�rrecs Autom�tics\" per aplicar el pagament d'aquesta factura en l�nia (recorda que les factures s'envien per missatgeria).<br><br><a
href=$page?op=view&tile=$tile&id=due>Veure totes les factures pendents de pagament</a>.");

define(MYSTATS,           "Les meves estad�stiques");
define(MYSTATUS,          "El meu estatus actual");

# N
define(NA,                "n/a");
define(NAME,              "Nom");
define(NAMEREG,           "Nom de registre");
define(NETSOLUTIONS,      "Network Solutions");
define(NEW_t,             "Nou");
define(NEWCC,             "TC nou");
define(NEWPW,             "Nova contrasenya");
define(NEWEXPDATE,        "Nova data de caducitat");
define(NEWPWMATCH,        "Les noves contrasenyes no concorden");
define(NEWPWSHORT,        "La nova contrasenya �s molt curta");
define(NEXT,              "seg�ent");
define(NEXTMONTH,         "Pr�xim mes");
define(NO,                "No");
define(NOIVOICENUM1,      "No hi ha aquest n�mero de factura");
define(NOIVOICENUM2,      "Al seu compte.");
define(NONE,              "cap");
define(NOPACKSEARCH,      "No hi ha paquets relacionats amb el seu criteri de recerca per");
define(NOPACKFOUND,       "No hi ha paquets relacionats amb el seu criteri de recerca.");
define(NOINVSEARCH,       "No hi ha factures relacionades amb el seu criteri de recerca per");
define(NOINVFOUND,        "No hi ha factures relacionades amb el seu criteri de recerca.");
define(NODOMSEARCH,       "No hi ha dominis relacionats amb el seu criteri de recerca per");
define(NODOMFOUND,        "No hi ha dominis relacionats amb el seu criteri de recerca.");
define(NORECFOUND,        "No es van trobar entrades per");
define(NORMAL,            "Normal");
define(NOTHINGENTERED,    "no va escriure res");
define(NOWDUE,            "N&nbsp;O&nbsp;W<br>D&nbsp;U&nbsp;E");
define(NUMAPPROVED,       "N�mero aprovat");
define(NUMDECLINED,       "N�mero no aprovat");
define(NUMERROR,          "Error del n�mero");
define(NT,                "NT");

# O
define(ONETIME,           "Pagament �nic");
define(OTHER,             "Un altre");
define(OR_t,              "o");
define(OVERDUE,           "D&nbsp;E&nbsp;U&nbsp;U&nbsp;T&nbsp;E");

# P
define(PACKAGE,           "Paquet");
define(PACKAGES,          "Paquets");
define(PACKAGEID,         "IDpaquet");
define(PACKAGEMENU,       "Men� de paquets");
define(PACKAGENAME,       "Nom del paquet");
define(PACKAGESTATS,      "Estad�stiques de paquets");
define(PACKAGESEARCH,     "Buscar paquets");
define(PACKAGEADMIN,      "Administraci� de Paquets");
define(PLEASELOGINTOBEGIN,"Connecti's per entrar.");
define(PAID,              "Pagat");
define(PAID2,             "P&nbsp;A&nbsp;G&nbsp;A&nbsp;T");
define(PAIDINVALID,       "Data de pagament incorrecta");
define(PAGE,              "p�gina");
define(PASSWORD_t,        "Contrasenya");
define(PAYMENTINFO,       "Informaci� de pagaments");
define(PAYMENTMETHOD,     "M�tode de pagament");
define(PAYONLINE,         "Pagar en l�nia");
define(PENDING,           "Pendent");
define(PHONE,             "Tel�fon");
define(PHONEFORMAT,       "000-000-0000");
define(PHONEIVALID,       "El tel�fon �s incorrecte");
define(PLEASEFILLIN,      "Si us plau, completi lels seg�ents camps.");
define(PLEASESELOPTIONS,  "Seleccioni les seves opcions.");
define(PLEASESELMENU,     "Si us plau, seleccioni del men� dalt.");
define(POSTPONED,         "Posposat");
define(PREV,              "previ");
define(PRIORITY,          "Prioritat");
define(PRICE,             "Preu");
define(PRICEFORMAT,       "0.00");
define(PWFORMAT,          "(6 car�cters: Aa-Zz i 0-9 nom�s)");
define(PWREQUIRED,        "Contrasenya obligat�ria per esborrar.");

# Q
define(QUARTERLY,         "Trimestral");
define(QTY,               "Quantitat");
define(QUANTITY,          "Quantitat");

# R
define(REALNAME,          "Nom real");
define(RENEWDATE,         "Data de renovaci�");
define(RENEWDATEINVALID,  "Data de renovaci� incorrecta");
define(RENEWONINVALID,    "Data de renovaci� �s incorrecta");
define(RENEWON,           "Renovat el");
define(REQUIRED,          "Obligatori");
define(REGISTRAR,         "Empresa registradora");
define(REPORTS,           "Informes");
define(RESEND,            "Reenviar factura");
define(RTM,               "Renovacions en aquest mes");
define(RUN,               "Fer");
define(RUNBATCH,          "Fer c�rrec autom�tic");

# S
define(SAD,               "Afegir opcions addicionals als clients");
define(SCP,               "Afegir paquet pel client");
define(SCD,               "Afegir dominis pel client");
define(SEARCH,            "Buscar");
define(SEARCHBATCHDETAILS,"Buscar detalls de c�rrecs autom�tics");
define(SECUREPAYMENTS,    "Modernbill .:. Pagaments segurs");
define(S_E_L_E_C_T,       "S&nbsp;E&nbsp;L&nbsp;E&nbsp;C&nbsp;C&nbsp;I&nbsp;O&nbsp;N&nbsp;I");
define(SELECTREPORT,      "Seleccioni un informe");
define(SEMIANNUALLY,      "Semestral");
define(SEND,              "Enviar");
define(SENDEMAIL,         "Enviar E-Mail");
define(SENDPACKSUM,       "Enviar resum de paquets");
define(SENDDOMSUM,        "Enviar resum de dominis");
define(SENDACTDETAILS,    "Enviar detalls del compte");
define(SENDINVHISTORY,    "Enviar historial de facturaci�");
define(SETUP,             "instalaci�");
define(SEPBYCOMMA,        "Separat per comes");
define(SERVNAME,          "Nom del servidor");
define(SERVTYPE,          "Tipus de servidor");
define(SERVTYPE2,         "Tipus de servidor");
define(SHORTCUT,          "Formats d'ajuda");
define(SHORTCUTHINTS,     "A�� pot ser utilitzat per totes les plantilles d'email!");
define(SIGNATURE,         "Firma");
define(SNC,               "Afegir nou client");
define(SPECIALSHORTCUTS,  "Els formats d'ajuda s�n nom�s per la facturaci�");
define(SPECSHORTCUTHINTS, "SEMPRE UTILITZE L'EMAIL_ID \"1\" PER L'EMAIL PLANTILLA DE \"M�TODES DE PAGAMENT AMB TARGETA DE CR�DIT\" I L'EMAIL_ID \"2\" COM L'EMAIL PLANTILLA DE \"COMPROVAR M�TODES DE PAGAMENT\"!");
define(SQLWARNING,        "Permitir fer SQL Queries pot ser un risc en la seguretat i
pot ser desactivat en l'arxiu de configuraci�!");
define(STARTDATE,         "Data d'activaci�");
define(STARDATEINVALID,   "Data d'activaci� incorrecta");
define(STATE,             "Estat");
define(STATEEXAMPLE,      "EX: \"DF\"");
define(STATEREGION,       "Estat/Regi�");
define(STATS,             "Estad�stiques");
define(STATUS,            "Estatus");
define(STEP1,             "Pas 1");
define(STEP2,             "Pas 2");
define(STEP3,             "Pas 3");
define(STRREPLANCEHINT,   "%%INVOICE_xxx%% podr� ser tradu�t nom�s si un \"Tipus de Factura\" �s seleccionat dalt!");
define(STM,               "Activacions d'aquest mes");
define(SUBMIT,            "Enviar");
define(SUBJECT,           "T�tol");
define(SYSTEM,            "Sistema");

# T
define(TESS,              "Tots els emails van ser enviats amb �xit");
define(TENS,              "No tots els emails van ser enviats [Errors]");
define(THEME,             "Tema");
define(THETABLE1,         "La taula");
define(THETABLE2,         "no es pot editar.");
define(THETABLE3,         "no va ser encontrat en la base de dades");
define(THISMONTH,         "Aquest mes");
define(THISISADMININTER,  "Aquesta �s la <b>\"interfase de l'administrador\"</b>.");
define(THREEDIGIT,        "Visa o MasterCard: Codi de seguretat de 3-D�gits");
define(TIGEN,             "Factures generades totals");
define(TIMESTAMP,         "TimeStamp");
define(TITLE,             "T�tol");
define(TO,                "A");
define(TODO,              "Block de Notes");
define(TODOSTATS,         "Estad�stiques del block de notes");
define(TODOSEARCH,        "Buscar en Block de notes");
define(TODOID,            "IDblock");
define(TODOLIST,          "Block de notes");
define(TOTAL,             "Total");
define(TOTAL,             "Totals");
define(TOTALACTIVE,       "Total actius");
define(TOTALCLIENTS,      "Total clients");
define(TOTALCURRENTBATCH, "Total de c�rrecs autom�tics");
define(TOTALINACTIVE,     "Total inactius");
define(TOTALINVOICES,     "Total factures");
define(TOTALDUE,          "Total de deutes");
define(TOTALNOWDUE,       "Total pendents de pagament");
define(TOTALNEW,          "Total de nous");
define(TOTALPAID,         "Total pagats");
define(TOTALTODO,         "Total de notes");
define(TOTALWIP,          "Total d'avan�os");
define(TOTALPENDING,      "Total de pendents");
define(TOTALCOMPLETED,    "Total de completats");
define(TOTALPOSTPONED,    "Total de posposats");
define(TTLAPPROVED,       "Total aprovats");
define(TTLDECLINED,       "Total no aprovats");
define(TTLDOMS,           "Total dominis");
define(TTLERROR,          "Total d'errors");
define(TTLPACKS,          "Total paquets");
define(TRANSLATESTO,      "Tradu�t a");
define(TRANSID,           "IDtransacci�");
define(TRANSIDORCHECK,    "IDtransacci� o # de xec");
define(TTLEMAILCONFIG,    "Total de configuracions per enviaments de correu");
define(TYPE,              "Tipus");

# U
define(UNIX,              "UNIX");
define(UNKOWN,            "desconegut");
define(UPDATECC,          "Actualitzar TC");
define(UPDATEMYINFO,      "Actualitzar la meva informaci�");
define(UPDATEMYCC,        "Actualitzar el meu TC");
define(UPDATEPW,          "Actualitzar contrasenya");
define(USER,              "Usuari");
define(USERNAME,          "Usuari");

# V
define(VERIFYDEL,         "Verificar per suprimir");
define(VERIFYPW,          "Verificar contrasenya");
define(VIEWALL,           "veure tots");
define(VIEWALLMYDOMAINS,  "Veure tots els meus dominis");
define(VIEWALLPACKAGES,   "Veure paquets actius");
define(VIEWAUTHNETBATCH,  "Veure els c�rrecs autom�tics amb Authorize.net");
define(VIEWBATCHSUMM,     "Veure resumen dels c�rrecs autom�tics");
define(VIEWCLIENTS,       "Veure clients");
define(VIEWCLIENTCREDITS, "Veure cr�dits del client");
define(VIEWCLIENTPACKAGES,"Veure paquets del client");
define(VIEWDOMAINNAMES,   "Veure noms de domini");
define(VIEWEXPDOMAINS,    "Veure dominis ven�uts");
define(VIEWINVOICES,      "Veure factures");
define(VIEWMYINFO,        "Veure la meva informaci�");
define(VIEWMYPACKAGES,    "Veure els meus paquets");
define(VIEWOVERINVOICES,  "Veure factures amb deutes");
define(VISA,              "Visa");

# W
define(WARNING,           "precauci�");
define(WELCOME,           "Benvinguts");
define(WELCOMEUSERFROM,   "Benvingut usuari de");
define(WHOIS,             "Whois");
define(WIP,               "Avan�os del Treball");

# Y
define(YAHOODOM,          "Yahoo");
define(YES,               "S�");
define(YOUCANFILTER,      "Pot seleccionar el seg�ent");
define(YOUCANSELECTANY,   "Pot seleccionar qualsevol combinaci�");
define(YOUCANUSE,         "Pot usar");
define(YOURBILLINGMETHOD, "El seu m�tode de pagament ha de ser canviat abans a \"C�rrecs autom�tics amb TC\"");
define(YOURORDERDECLINED, "La seva comanda no pot ser processada ara. La seva targeta no va ser aprovada. Provi de nou m�s tard.");
define(YOURORDEREERROR,   "Un error ha ocorregut i no es va poder fer la seva comanda. Provi de nou m�s tard.");
define(YOURORDERSUCCESS,  "La seva comanda ha estat processada");
define(YOURPW,            "La seva contrasenya");
define(YOURPWINVALID,     "La seva contrasenya �s incorrecta");
define(YOURSELECTIONS,    "La seva selecci� ha estat inclosa per modificacions");

# Z
define(ZIP,               "Codi Postal");
define(ZIPFORMAT,         "00000-0000");
define(ZIPINVALID,        "El codi postal �s incorrecte");
?>
