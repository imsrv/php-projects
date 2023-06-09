<?php

###############################################################################
# 
# This is the czech language page for GeekLog!
#
# Copyright (C) 2002 hermes_trismegistos
# hermes_trismegistos@post.cz
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
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

$LANG_CHARSET = "iso-8859-2";

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
	1 => "Publikoval :",
	2 => "<b>��st cel�</b>",
	3 => "koment���",
	4 => "Editovat",
	5 => "Anketa",
	6 => "V�sledky",
	7 => "V�sledky ankety",
	8 => "hlas�",
	9 => "Administr�torsk� funkce:",
	10 => "P��sp�vky",
	11 => "�l�nky",
	12 => "Bloky",
	13 => "Sekce",
	14 => "Odkazy",
	15 => "Ud�losti",
	16 => "Ankety",
	17 => "U�ivatel�",
	18 => "SQL dotaz",
	19 => "<b>Odhl�sit</b>",
	20 => "Informace o u�ivateli:",
	21 => "U�ivatel",
	22 => "U�ivatel�v ID",
	23 => "�rove� pr�v",
	24 => "Anonymn� host",
	25 => "Odpov��",
	26 => " N�sleduj�c� koment��e jsou n�zorem jejich vkladatele. <br>Weblog neru�� za to co je zde naps�no.",
	27 => "Naposledy p�id�no",
	28 => "Smazat",
	29 => "Nejsou ��dn� koment��e.",
	30 => "Star�� �l�nky",
	31 => "HTML tagy povoleny:",
	32 => "Chyba, neplatn� u�ivatelsk� jm�no",
	33 => "Chyba, nepovolen� z�pis do log fajlu",
	34 => "Chyba",
	35 => "Odhl�sit",
	36 => " - ",
	37 => "Bez �l�nk�",
	38 => "",
	39 => "Obnovit",
	40 => "",
	41 => "Host�",
	42 => "Publikov�no:",
	43 => "Odpov�d�t na toto",
	44 => "Nad�azen�",
	45 => "MySQL Error Number",
	46 => "MySQL Error Message",
	47 => "U�ivatelsk� menu",
	48 => "Informace o ��tu",
	49 => "Vlastn� nastaven�",
	50 => "Error with SQL statement",
	51 => "help",
	52 => "Nov�",
	53 => "Administrace",
	54 => "Nelze otev��t soubor.",
	55 => "Nastala chyba - ",
	56 => "Hlasovat",
	57 => "Heslo",
	58 => "P�ihl�sit",
	59 => "Nem�te zat�m ��et?  P�ihla�te se jako <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>Nov�&nbsp;u�ivatel</b></a>",
	60 => "Okomentovat",
	61 => "Nov� u�ivatel",
	62 => "slov",
	63 => "Nastaven� koment���",
	64 => "Poslat emailem",
	65 => "Verze pro tisk�rnu",
	66 => "Osobn� kalend��",
	67 => "V�tejte na ",
	68 => "home",
	69 => "kontakt",
	70 => "hledat",
	71 => "p��sp�vky",
	72 => "odkazy",
	73 => "ankety",
	74 => "kalend��",
	75 => "roz���en� hled�n�",
	76 => "statistika",
	77 => "Pluginy",
	78 => "Bl���c� se ud�losti",
	79 => "Co je nov�ho",
	80 => "�l�nk� za posledn�ch",
	81 => "�l�nek za posledn�ch",
	82 => "hodin",
	83 => "KOMENT��E",
	84 => "ODKAZY",
	85 => "za posledn�ch 48 hodin",
	86 => "Nejsou nov� koment��e",
	87 => "za posledn� 2 t�dny",
	88 => "Nejsou nov� odkazy",
	89 => "Nejsou ��dn� bl���c� se ud�losti",
	90 => "Homepage",
	91 => "Str�nka vytvo�ena za",
	92 => "sekund&nbsp;",
	93 => "Copyright",
	94 => "V�echna pr�va a ochrann� zn�mky na t�chto str�nk�ch pat�� jejich vlastn�k�m.",
	95 => "Pou��v�me",
	96 => "Skupiny",
    97 => "Word List",
	98 => "Pluginy",
	99 => "�L�NKY",
    100 => "Nejsou nov� �l�nky",
    101 => 'Osobn� ud�losti',
    102 => 'Ud�losti weblogu',
    103 => 'DB z�lohy',
    104 => '-',
    105 => 'Emailov� d�mon',
    106 => 'Zhl�dnuto',
    107 => 'Test Verze GL',
    108 => 'Smazat cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Kalend��",
	2 => "Nejsou ��dn� ud�losti k zobrazen�.",
	3 => "Kdy",
	4 => "Kde",
	5 => "Popis",
	6 => "P�idat ud�lost",
	7 => "Bl���c� se ud�losti",
	8 => 'Kdy� toto p�id�te do Osobn�ho kalend��e, uvid�te je jen Vy ve sv�m Osobn�m kalend��i v U�ivatelsk�ch funkc�ch.',
	9 => "P�idat do osobn�ho kalend��e",
	10 => "Odebrat z osobn�ho kalend��e",
	11 => "P�id�n� ud�losti do kalend��e {$_USER['username']}'",
	12 => "Ud�lost",
	13 => "Za��n�",
	14 => "Kon��",
  15 => "Zp�t na kalend��"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Vlo�it koment��",
	2 => "Typ koment��e",
	3 => "Odhl�sit",
	4 => "Vytvo�it ��et",
	5 => "U�ivatel",
	6 => "Tato str�nka vy�aduje p�ihl�en� pro vlo�en� koment��e, pros�m p�ihla�te se.  Pokud nem�te ��et - m��ete si ho vytvo�it.",
	7 => "V� posledn� koment�� vlo�en p�ed ",
	8 => " sekundami.  Tato str�nka vy�aduje prodlevu {$_CONF["commentspeedlimit"]} sekund mezi koment��i.",
	9 => "Koment��",
	10 => '',
	11 => "Vlo�it koment��",
	12 => "Pros�m vypl�te Titulek a Koment��, jinak nelze vlo�it.",
	13 => "Va�e info",
	14 => "N�hled",
	15 => "",
	16 => "Titulek",
	17 => "Chyba",
	18 => 'D�le�it�',
	19 => 'Pros�m vkl�dejte koment��e do spr�vn� sekce.',
	20 => 'Koment��e vkl�dejte pokud mo�no ve spr�vn�m po�ad�.',
	21 => 'P�e�t�te si pros�m nejd��ve koment��e ostatn�ch u�ivatel�, aby nedoch�zelo k duplicit�.',
	22 => 'Pou�ijte titulek, kter� vlo�il syst�m.',
	23 => 'V� email nebude publikov�n!',
	24 => 'Anonymn� host'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "U�ivatelsk� profil:",
	2 => "P�ihla�ovac� jm�no",
	3 => "Jm�no",
	4 => "Heslo",
	5 => "Email",
	6 => "Homepage",
	7 => "O v�s",
	8 => "PGP kl��",
	9 => "Ulo�it zm�ny",
	10 => "Posledn�ch 10 coment��� u�ivatele",
	11 => "Bez koment��� u�ivatele",
	12 => "U�ivatelsk� nastaven�:",
	13 => "Pos�lat na konci ka�d�ho dne v�tah z weblogu emailem",
	14 => "Toto heslo bylo n�hodn� vygenerov�no syst�mem. Doporu�uje se zm�nit co nejd��ve. Pro zm�nu hesla se p�ihla�te a zm�nte si ho pot� v menu Informace o ��tu v U�ivatelsk�m rozhran�.",
	15 => "V� {$_CONF["site_name"]} ��et byl vytvo�en. M��ete se p�ihl�sit, n��e jsou Va�e p�ihla�ovac� data. Pros�m uschovejt si tento email pro budouc� reference.",
	16 => "Informace o ��tu",
	17 => "��et neexistuje",
	18 => "Email se zd� b�t v nespr�vn�m form�tu",
	19 => "U�ivatel nebo email ji� existuje",
	20 => "Email se zd� b�t v nespr�vn�m form�tu",
	21 => "Chyba",
	22 => "Registrace na {$_CONF['site_name']}!",
	23 => "Anonymn� u�ivatel� - Host� nemohou nap��klad komentovat �i p�id�vat �l�nky.<br>Vytvo�en� ��tu V�m umo�n� vyu��vat v�ech funkc� na {$_CONF['site_name']}. <br>Va�e emailov� adresa nebude <b><i>nikdy a nikde</i></b> zve�ejn�na na t�chto str�nk�ch.",
	24 => "Va�e heslo bude posl�no na v�mi zadanou emailovou adresu.",
	25 => "Zapomenut� heslo?",
	26 => "Vlo�te Va�e p�ihla�ovac� jm�no a klepn�te na Poslat-heslo a nov� heslo V�m bude zasl�no na V�mi zadanou emailovou adresu.",
	27 => "Registrovat nyn�!",
	28 => "Poslat-heslo",
	29 => "odhl�en od",
	30 => "p�ihl�en od",
	31 => "Tato funkce vy�aduje p�ihl�en�",
	32 => "Podpis",
	33 => "Nezobraz� se ve�ejn�",
	34 => "Toto je va�e prav� jm�no",
	35 => "Jen pro zm�nu hesla",
	36 => "Na za��tku s http://",
	37 => "Bude pou�it v koment���ch",
	38 => "Toto je o V�s! Kdokoli si to m��e p�e��st",
	39 => "V� ve�ejn� PGP kl��",
	40 => "Bez ikon Sekc�",
	41 => "Chci b�t Moder�torem sekce",
	42 => "Form�t data",
	43 => "Maxim�ln� po�et �l�nk�",
	44 => "Bez blok�",
	45 => "Vlastn� nastaven� pro",
	46 => "Bez t�chto polo�ek pro",
	47 => "Nastaven� blok� pro",
	48 => "Sekce",
	49 => "Nezobrazovat ikony",
	50 => "Od�krtn�te pokud v�s nezaj�m�",
	51 => "Jen novinky",
	52 => "Syst�mov� nastaven� - ",
	53 => "Dost�vat �l�nky na konci dne emailem",
	54 => "Za�krtn�te to co nechcete zobrazovat.",
	55 => "Pokud nech�te od�krtl�, bude pou�ito p�vodn� nastaven� - to co je tu�n� bude zobrazov�no.  Pro vlastn� nastaven� za�krtn�te jen to co chcete zobrazovat.",
	56 => "Auto�i",
	57 => "Nastaven� zobrazov�n� polo�ek pro",
	58 => "�azen�",
	59 => "Maxim�ln� po�et koment���",
	60 => "Jak chcete zobrazovat koment��e?",
	61 => "Nejnov�j�� nebo nejstar�� nejd��ve?",
	62 => "Syst�mov� nastaven� - 100",
	63 => "Va�e heslo bude posl�no na v�mi zadanou emailovou adresu. Postupujte podle zaslan�ch instrukc� pro p�ihl�en� do " . $_CONF["site_name"],
	64 => "Nastaven� koment��� pro",
	65 => "Zkuste se p�ihl�sit znovu",
	66 => "Spletl jste se v zad�n�.  Pros�m zkuste to znovu. Nebo jste  <a href=\"{$_CONF['site_url']}/users.php?mode=new\"><b>nov� u�ivatel</b></a>?",
	67 => "U�ivatelem od",
	68 => "Pamatovat si mne",
	69 => "Jak dlouho si V�s syst�m bude pamatovat.",
	70 => "P�izp�soben� vzhledu a obsahu {$_CONF['site_name']}",
	71 => "P�izp�soben� vzhledu na {$_CONF['site_name']} v�m umo�n� nastavit si vlastn� vzhled a �azen� polo�ek nez�visle na nastaven� pro hosty.  Pro tato nastaven� se mus�te <a href=\"{$_CONF['site_url']}/users.php?mode=new\">p�ihl�sit</a> na {$_CONF['site_name']}. <br> Jste u�ivatelem?  Pak pou�ijte p�ihla�ovac� formul�� vlevo!",
    72 => "Grafick� t�ma",
    73 => "Jazyk",
    74 => "Vyberte jak m� weblog vypadat",
    75 => "Zas�l�n� sekc�",
    76 => "Tyto sekce v�m budou zas�l�na emailem koncem ka�d�ho dne. Pros�m vyb�rejte jen sekce, kter� v�s zaj�maj�!",
    77 => "Foto",
    78 => "P�id� Va�e foto (do velikosti 96x96px)!",
    79 => "Za�krtnout pro smaz�n� fota",
    80 => "P�ihl�sit",
    81 => "Zaslat email",
    82 => 'Posledn�ch 10 �l�nk� u�ivatele',
    83 => 'Publika�n� statistika u�ivatele',
    84 => 'Celkov� publikac�:',
    85 => 'Celkov� koment���:',
    86 => 'Naj�t v�e od'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nic nov�ho k zobrazen�",
	2 => "��dn� nov� �l�nky k zobrazen�.  Mo�n� nejsou ��dn� novinky, nebo jste zadali �patn� podm�nky filtrov�n�",
	3 => " pro sekci $topic",
	4 => "Nejnov�j�� �l�nek",
	5 => "Dal��",
	6 => "P�ede�l�"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Webov� obsah",
	2 => "Nic nenalezeno.",
	3 => "P�idat odkaz"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Hlas ulo�en",
	2 => "V� hlas v anket� byl ulo�en",
	3 => "Hlas",
	4 => "Ankety v syst�mu",
	5 => "Hlasy"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Nastala chyba p�i odes�l�n� emailu, zkuste to pros�m znovu.",
	2 => "Zpr�va �sp�n� odesl�na.",
	3 => "Zkontrolujte si pros�m spr�vnost emailov� adresy.",
	4 => "Pros�m vypl�te v�echna pole formul��e.",
	5 => "Chyba: neexistuj�c� u�ivatel.",
	6 => "Vznikla chyba.",
	7 => "U�ivatelsk� profil ",
	8 => "Jm�no",
	9 => "URL str�nek u�ivatele",
	10 => "Poslat email u�ivateli ",
	11 => "Va�e jm�no:",
	12 => "Poslat na:",
	13 => "Hlavi�ka:",
	14 => "Zpr�va:",
	15 => "Pou�it� HTML tagy nebudou zm�n�ny.<br>",
	16 => "Poslat zpr�vu",
	17 => "Poslat �l�nek mailem",
	18 => "Komu",
	19 => "Kam",
	20 => "Od koho",
	21 => "Email odesilatele",
	22 => "Pros�m vypl�te v�echna pole formul��e.",
	23 => "Tento email V�m byl posl�n $from z $fromemail proto�e si tento u�ivatel mysl�, �e by V�s mohl zaujmut.  Bylo publikov�no na {$_CONF["site_url"]}.   Toto NEN� SPAM a Va�e emailov� adresa nebyla nikde ulo�ena a nebude tud�� pou�ita k jak�mkoli ��el�m.",
	24 => "Koment�� k �l�nku na",
	25 => "Mus�te b�t p�ihl�en jako u�ivatel pro pou�it� t�to funkce weblogu.<br>  Touto restrikc� se p�edch�z� zneu�it� syst�mu k spammingu!",
	26 => "Tento formul�� umo��uje zaslat email vybran�mu u�ivateli.  Vypl�te pros�m v�echna pole.",
	27 => "Kr�tk� zpr�va",
	28 => "$from naps�no: $shortmsg",
  29 => "Toto jsou denn� novinky z {$_CONF['site_name']} pro ",
  30 => " Denn� novinky pro ",
  31 => "Titulek",
  32 => "Datum",
  33 => "Cel� �l�nek si m��ete p�e��st na ",
  34 => "Konec zpr�vy"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "roz���en� hled�n�",
	2 => "Kl��ov� slova",
	3 => "Sekce",
	4 => "V�e",
	5 => "Typ",
	6 => "�l�nky",
	7 => "Koment��e",
	8 => "Auto�i",
	9 => "V�e",
	10 => "Hled�n�",
	11 => "V�sledky hled�n�",
	12 => "odpov�daj�c� filtru",
	13 => "V�sledky hled�n�: nic neodpov�d� zadan�mu filtru",
	14 => "��dn� v�sledky neodpov�daj� zadan�mu filtru",
	15 => "Pros�m zkuste znovu.",
	16 => "Titulek",
	17 => "Datum",
	18 => "Autor",
	19 => "Prohledat celou datab�zi nov�ch i archivn�ch polo�ek na {$_CONF["site_name"]}",
	20 => "Datum",
	21 => "do",
	22 => "(Form�t data RRRR-MM-DD)",
	23 => "Zhl�dnuto",
	24 => "Nalezeno",
	25 => "filtru odpov�daj�c�ch z celkem ",
	26 => "polo�ek b�hem",
	27 => "sekund",
    28 => '��dn� �l�nek nebo koment�� neodpov�d� zadan�mu filtru',
    29 => 'V�sledky vyhled�v�n� �l�nk� a koment���',
    30 => '��dn� v�sledky neodpov�daj� zadan�mu filtru',
    31 => 'This plug-in returned no matches',
    32 => 'Ud�lost',
    33 => 'URL',
    34 => 'Um�st�n�',
    35 => 'Cel� den',
    36 => '��dn� ud�losti neodpov�daj� zadan�mu filtru',
    37 => 'V�sledky hled�n�',
    38 => 'V�sledky hled�n� odkaz�',
    39 => 'Odkazy',
    40 => 'Ud�losti',
    41 => 'Alespo� 3 znaky v poli vyhled�v�n�.',
    42 => 'Pros�m zad�vejte datum v tomto form�tu: RRRR-MM-DD (rok-m�s�c-den).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Celkov� statistika str�nek",
	2 => "Souhrn po�adavk� na syst�m",
	3 => "�l�nky(koment��e) v syst�mu",
	4 => "Anket(odpov�d�) v syst�mu",
	5 => "Odkazy(jejich n�sledov�n�) v syst�mu",
	6 => "Ud�losti v syst�mu",
	7 => "Top Ten �l�nky",
	8 => "Titulek �l�nku",
	9 => "Zhl�dnuto",
	10 => "��dn� �l�nky zde nejsou.",
	11 => "Top Ten komentovan�ch �l�nk�",
	12 => "Koment��e",
	13 => "��dn� komentovan� �l�nky zde nejsou.",
	14 => "Top Ten anket",
	15 => "Anketn� ot�zka",
	16 => "Hlas�",
	17 => "��dn� ankety zde nejsou.",
	18 => "Top Ten okaz�",
	19 => "Odkazy",
	20 => "Zhl�dnuto",
	21 => "��dn� odkazy na kter� se klickalo zde nejsou.",
	22 => "Top Ten emailem zaslan�ch �l�nk�",
	23 => "Zasl�no emailem",
	24 => "��dn� emailem poslan� �l�nky zde nejsou."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Souvisej�c�",
	2 => "Poslat mailem",
	3 => "Verze pro tisk�rnu",
	4 => "Volby �l�nku"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Pro tento $type mus�te b�t p�ihl�en jako u�ivatel.",
	2 => "P�ihl�sit",
	3 => "Nov� u�ivatel",
	4 => "P�id�n�",
	5 => "P�idat odkaz",
	6 => "Publikovat �l�nek",
	7 => "Vy�adov�no p�ihl�en�",
	8 => "Publikov�n�",
	9 => "Pro publikov�n� na t�chto str�nk�ch n�sledujte pros�m tato prost� doporu�en�: <ul><li>Vypl�te v�echna povinn� pole<li>Zad�vejte kompletn� a p�esn� informace<li>Dvakr�t si zkontrolujte URL</ul>",
	10 => "Titulek",
	11 => "Odkaz",
	12 => "Datum za��tku",
	13 => "Datum konce&nbsp;&nbsp;&nbsp;",
	14 => "Um�st�n�",
	15 => "Popis",
	16 => "Pokud je Jin�, specifikujte pros�m",
	17 => "Kategorie",
	18 => "Jin�",
	19 => "P�e�t�te si",
	20 => "Chyba: Chyb� Kategorie",
	21 => "Pokud vybr�no \"Jin�\" vyberte pros�m i kategorii",
	22 => "Chyba: nevypln�n� pole",
	23 => "Pros�m vypl�te v�echna pole. V�e je povinn�.",
	24 => "Publikace provedena",
	25 => "Va�e $type publikace byla provedena.",
	26 => "Omezen� rychlosti publikov�n�",
	27 => "U�ivatel",
	28 => "Sekce",
	29 => "�l�nek",
	30 => "Posledn� publikace byla p�ed ",
	31 => " sekundami.  Tato str�nka vy�aduje {$_CONF["speedlimit"]} sekund mezi publikacemi",
	32 => "N�hled",
	33 => "N�hled �l�nku",
	34 => "Odhl�sit",
	35 => "HTML tagy nejsou podporov�ny",
	36 => "Typ publikace",
	37 => "P�id�n� ud�losti - {$_CONF["site_name"]} p�id� tuto do Ve�ejn�ho kalend��e pokud si nevyberete jen p�id�n� do Osobn�ho kaend��e.<br><br>Pokud p�id�te ud�lost do Ve�ejn�ho kalend��e bude tato po kontrole administr�torem za�azena do Ve�ejn�ho kalend��e.",
    38 => "P�idat ud�lost do",
    39 => "Ve�ejn� kalend��",
    40 => "Osobn� kalend��",
    41 => "�as konce&nbsp;&nbsp;&nbsp;",
    42 => "�as za��tku",
    43 => "Ka�dodenn�",
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'M�sto',
    47 => 'Zem�',
    48 => 'Sm�rov� ��slo',
    49 => 'Typ ud�losti',
    50 => 'Ediovat typ ud�losti',
    51 => 'Um�st�n�',
    52 => 'Smazat',
    53 => 'Vytvo�it ��et'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentikace vy�adov�na",
	2 => "P��stup odep�en! Nespr�vn� p�ihla�ovac� �daje",
	3 => "Neplatn� heslo pro u�ivatele",
	4 => "U�ivatel:",
	5 => "Heslo:",
	6 => "Ka�d� p��stup do administr�torsk� ��sti str�nek je zapisov�n do log_file a je tam tak� kontrolov�n.<br>Tato str�nka je jen pro autorizovan� u�ivatele s administr�torsk�mi pr�vy.",
	7 => "P�ihl�sit"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Nedostate�n� administr�torsk� pr�va",
	2 => "Nem�te povolen p��stup k t�to ��sti administrace.",
	3 => "Editor blok�",
	4 => "",
	5 => "Titulek bloku",
	6 => "Sekce",
	7 => "V�e",
	8 => "�rove� pr�v bloku",
	9 => "Po�ad� bloku",
	10 => "Typ bloku",
	11 => "Blok Port�lu",
	12 => "Norm�ln� blok",
	13 => "Volby Bloku Port�lu",
	14 => "RDF URL",
	15 => "Last RDF Update",
	16 => "Volby bloku",
	17 => "Obsah bloku",
	18 => "Pros�m vypl�te Titulek bloku, �rove� pr�v a Obsah",
	19 => "Mana�er blok�",
	20 => "Titulek bloku",
	21 => "�rove� pr�v bloku",
	22 => "Typ bloku",
	23 => "Po�ad� bloku",
	24 => "Sekce bloku",
	25 => "Pro smaz�n� a editaci bloku, klepn�te na blok n��e.  Pro vytvo�en� nov�ho bloku klepn�te na Nov� blok v��e.",
	26 => "Vzhled bloku",
	27 => "PHP Blok",
    28 => "Volby PHP Bloku",
    29 => "Funkce bloku",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => 'Chyba v PHP Bloku.  Funkce, $function, neexistuje.',
    32 => "Chyba - neexistuj�c� pole",
    33 => "You must enter the URL to the .rdf file for portal blocks",
    34 => "You must enter the title and the function for PHP blocks",
    35 => "You must enter the title and the content for normal blocks",
    36 => "You must enter the content for layout blocks",
    37 => "�patn� jm�no funkce PHP bloku",
    38 => "Functions for PHP Bloky must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
	39 => "Strana",
	40 => "Vlevo",
	41 => "Vpravo",
	42 => "You must enter the blockorder and security level for Geeklog default blocks",
	43 => "Jen na Homepage",
	44 => "P��stup odep�en",
	45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/block.php\">go back to the block administration screen</a>.",
	46 => 'Nov� blok',
	47 => 'Administrace',
    48 => 'Jm�no bloku',
    49 => ' (bez mezer, mus� b�t unik�tn�)',
    50 => ' URL Help souboru',
    51 => 'v�etn� http://',
    52 => 'Pokud nech�te pr�zdn� - ikona helpu se nebude zobrazovat.',
    53 => 'Povolit',
    54 => 'ulo�it',
    55 => 'zru�it akci',
    56 => 'smazat'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor ud�lost�",
	2 => "",
	3 => "Titulek ud�losti",
	4 => "URL ud�losti",
	5 => "Datum za��tku",
	6 => "Datum konce&nbsp;&nbsp;&nbsp;",
	7 => "Um�st�n� ud�losti",
	8 => "Popis ud�losti",
	9 => "(v�etn� http://)",
	10 => "Mus�te zadat datum/�as, popis a um�st�n� ud�losti!",
	11 => "Mana�er ud�lost�",
	12 => "Pro zm�nu a smaz�n� ud�losti, klepn�te na tuto n��e.  Pro vytvo�en� nov� ud�losti klepn�te na Nov� ud�lost v��e.",
	13 => "Titulek ud�losti",
	14 => "Datum za��tku",
	15 => "Datum konce&nbsp;&nbsp;&nbsp;",
	16 => "P��stup odep�en",
	17 => "Pokou��te se editovat ud�lost na n�� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n. Pros�m <a href=\"{$_CONF["site_admin_url"]}/event.php\">vra�te se na administraci ud�lost�</a>.",
	18 => 'Nov� ud�lost',
	19 => 'Administrace',
    20 => 'ulo�it',
    21 => 'zru�it akci',
    22 => 'smazat'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor odkaz�",
	2 => "",
	3 => "Titulek odkazu",
	4 => "URL odkazu",
	5 => "Kategorie",
	6 => "(v�etn� http://)",
	7 => "Jin�",
	8 => "Klicknuto",
	9 => "Popis odkazu",
	10 => "Je pot�eba zadat Titulek, URL a Popis odkazu.",
	11 => "Mana�er odkaz�",
	12 => "Pro �pravu odkazu, klepn�te na po�adovan� odkaz n��e.  Pro vytvo�en� nov�ho odkazu klepn�te na Nov� odkaz v��e.",
	13 => "Titulek odkazu",
	14 => "Kategorie",
	15 => "URL odkazu",
	16 => "P��stup odep�en",
	17 => "Pokou��te se editovat odkaz na n�j� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n. Pros�m <a href=\"{$_CONF["site_admin_url"]}/link.php\">vra�te se na administraci odkaz�</a>.",
	18 => 'Nov� odkaz',
	19 => 'Administrace',
	20 => 'Pokud je jin�',
    21 => 'ulo�it',
    22 => 'zru�it akci',
    23 => 'smazat'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "P�ede�l� �l�nky",
	2 => "Dal�� �l�nky",
	3 => "Re�im",
	4 => "Publika�n� re�im",
	5 => "Editor �l�nk�",
	6 => "Nejsou zde �l�nky",
	7 => "Autor",
	8 => "ulo�it",
	9 => "n�hled",
	10 => "zru�it akci",
	11 => "smazat",
	12 => "",
	13 => "Titulek",
	14 => "Sekce",
	15 => "Datum publikace",
	16 => "Intro Text",
	17 => "Text",
	18 => "Zhl�dnuto",
	19 => "Koment��e",
	20 => "",
	21 => "",
	22 => "Seznam �l�nk�",
	23 => "Pro editaci nebo smaz�n� �l�nku klepn�te na jeho ��slo n��e. Pro zobrazen�,klepn�te na titulek �l�nku, kter� chcete vid�t. Pro vytvo�en� nov�ho �l�nku klepn�te na Nov� �l�nek v��e.",
	24 => "",
	25 => "",
	26 => "N�hled",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Pros�m vypln�e Autor, Titulek a Intro Text",
	32 => "Zv�raznit",
	33 => "V syt�mu m��e b�t jen jeden zv�razn�n� �l�nek (ten se bude zobrazovat v�dy jako prvn�)",
	34 => "Verze pro tisk�rnu",
	35 => "Ano",
	36 => "Ne",
	37 => "V�ce od",
	38 => "V�ce z",
	39 => "Posl�no emailem",
	40 => "P��stup odep�en",
	41 => "Pokou��te se editovat odkaz na n�j� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n.  M��ete si jen prohl�dnout �l�nky n��e. Pros�m <a href=\"{$_CONF["site_admin_url"]}/story.php\">vra�te se na administraci �l�nk�</a> kdy� skon��te.",
	42 => "Pokou��te se editovat odkaz na n�j� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n.  Pros�m <a href=\"{$_CONF["site_admin_url"]}/story.php\">vra�te se na administraci �l�nk�</a>.",
	43 => 'Nov� �l�nek',
	44 => 'Administrace',
	45 => 'P��stup',
    46 => '<b>PAMATUJTE:</b> pokud zad�te datum v budoucnosti, tento �l�nek nebude publikov�n do tohoto data.  To znamen�, �e �l�nek nebude vid�t ani nebude zahrnut do vyhled�v�n� a do statistiky str�nek p�ed t�mto datem.',
    47 => 'Upload obr�zk�',
    48 => 'obr�zek',
    49 => 'vpravo',
    50 => 'vlevo',
    51 => 'k p�id�n� obr�zk� (max. velikost 200x200px) do �l�nku mus�te vlo�it speci�ln� form�tovan� text.<br>Tento text vypad� takto: [obr�zekX](syst�m um�st� s�m), [obr�zekX_vpravo](syst�m um�st� vpravo od textu) nebo [obr�zekX_vlevo](syst�m um�st� vlevo od textu) - kde X je ��slo obr�zku je� je p�id�v�n.<br>PAMATUJTE: mus�te pou��t obr�zky je� jsou p�id�v�ny.  V opa�n�m p��pad� nebude mo�no publikovat �l�nek.<BR><P><B>N�HLED</B>: Pro n�hled �l�nku s obr�zky je nejl�pe pou��t n�hled Verze pro tisk�rnu.  Tla��tko <i>n�hled</i> pros�m pou��vejte jen pro prohl��en� �l�nk� bez obr�zk�.',
    52 => 'Smazat',
    53 => ' nepou�ito.  P�ed ulo�en�m zm�n mus�te vlo�it obr�zek do Intro textu nebo textu.',
    54 => 'P�idan� obr�zek nepou�it',
    55 => 'N�sleduj�c� chyby se vyskytly p�i publikaci va�eho �l�nku.  Pros�m opravte tyto chyby p�ed kone�nou publikac�.',
    56 => 'Ikona Sekce.'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Re�im",
	2 => "",
	3 => "Anketa vytvo�ena",
	4 => "Anketa $qid ulo�ena",
	5 => "Editovat anketu",
	6 => "ID ankety",
	7 => "(bez mezer)",
	8 => "Zobrazit na Homepage",
	9 => "Ot�zka",
	10 => "Odpov�d� / Hlasuj�c�ch",
	11 => "There was an Chyba getting poll answer data about the poll $qid",
	12 => "There was an Chyba getting poll question data about the poll $qid",
	13 => "Vytvo�it anketu",
	14 => "ulo�it",
	15 => "zru�it akci",
	16 => "smazat",
	17 => "",
	18 => "Ankety",
	19 => "Pro editaci nebo smaz�n� ankety, klepn�te na anketu n��e.  Pro vytvo�en� nov� ankety klepn�te na Nov� anketa v��e.",
	20 => "Hlasuj�c�ch",
	21 => "P��stup odep�en",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/poll.php\">go back to the poll administration screen</a>.",
	23 => 'Nov� anketa',
	24 => 'Administrace',
	25 => 'Ano',
	26 => 'Ne'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor sekc�",
	2 => "ID sekce",
	3 => "Jm�no sekce",
	4 => "Ikona sekce",
	5 => "(bez mezer)",
	6 => "Smaz�n� sekce zp�sob� smaz�n� �l�nk� a koment��� k nim i jej� ikony!",
	7 => "Pros�m vypl�te ID sekce a Jm�no sekce",
	8 => "Mana�er sekc�",
	9 => "Pro �pravu a smaz�n� sekce klepn�te na jej� jm�no n��e.  Pro vytvo�en� nov� sekce klepn�te na Nov� sekce v��e.",
	10=> "po�ad�",
	11 => "�l�nk�/str�nku",
	12 => "P��stup odep�en",
	13 => "Pokou��te se editovat sekci na n�� nem�te dostate�n� pr�va.  Tento pokus byl zaznamen�n. Pros�m <a href=\"{$_CONF["site_admin_url"]}/topic.php\">vra�te se na administraci sekc�</a>.",
	14 => "typ �azen�",
	15 => "abecedn�",
	16 => "nastaveno",
	17 => "Nov� sekce",
	18 => "Administrace",
    19 => 'ulo�it',
    20 => 'zru�it akci',
    21 => 'smazat'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor u�ivatel�",
	2 => "ID u�ivatele",
	3 => "U�ivatel",
	4 => "Jm�no u�ivatele",
	5 => "Heslo",
	6 => "�rove� pr�v",
	7 => "Emailov� adresa",
	8 => "Homepage",
	9 => "(bez mezer)",
	10 => "Please fill in the U�ivatel, Full name, Security Level and Email Address fields",
	11 => "Mana�er u�ivatel�",
	12 => "To modify or smazat a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a U�ivatel,email address or fullname (e.g.*son* or *.edu) in the form below.",
	13 => "�rove� pr�v",
	14 => "Datum registrace",
	15 => 'Nov� u�ivatel',
	16 => 'Administrace',
	17 => 'zm�na hesla',
	18 => 'zru�it akci',
	19 => 'smazat',
	20 => 'ulo�it',
	18 => 'zru�it akci',
	19 => 'smazat',
	20 => 'ulo�it',
    21 => 'U�ivatel ji� existuje.',
    22 => 'Chyba',
    23 => 'Hromadn� p�id�n�',
    24 => 'Hromadn� p�id�n� u�ivatel�',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, U�ivatel, email address.  Each user you import will be emailed with a random Heslo.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Hledat',
    27 => 'Omezit na',
    28 => 'Za�krtnout pro smaz�n� obr�zku',
    29 => 'Cesta',
    30 => 'Import',
    31 => 'Nov� u�ivatel�',
    32 => 'HOTOVO. Importov�no $successes a vyskytlo se $failures chyb.',
    33 => 'Potvrdit',
    34 => 'Chyba: Specifikujte soubor.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Potvrdit",
    2 => "Smazat",
    3 => "Editovat",
    4 => 'Profil',
    10 => "Titulek",
    11 => "Datum za��tku",
    12 => "URL",
    13 => "Kategorie",
    14 => "Datum",
    15 => "Sekce",
    16 => 'Jm�no u�ivatele',
    17 => 'Cel� jm�no u�ivatele',
    18 => 'Email',
    34 => "Administrace weblogu",
    35 => "P�id�n� �l�nku",
    36 => "P�id�n� odkazu",
    37 => "P�id�n� ud�losti",
    38 => "P�idat",
    39 => "Nyn� zde nen� nic k moderov�n�",
    40 => "Publikace u�ivatele"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "ned�le",
	2 => "pond�l�",
	3 => "�ter�",
	4 => "st�eda",
	5 => "�tvrtek",
	6 => "p�tek",
	7 => "sobota",
	8 => "P�idat ud�lost",
	9 => "Ud�losti weblogu",
	10 => "Ud�losti u�ivatele",
	11 => "Ve�ejn� kalend��",
	12 => "Osobn� kalend��",
	13 => "leden",
	14 => "�nor",
	15 => "b�ezen",
	16 => "duben",
	17 => "kv�ten",
	18 => "�erven",
	19 => "�ervenec",
	20 => "srpen",
	21 => "z���",
	22 => "��jen",
	23 => "listopad",
	24 => "prosinec",
	25 => "Zp�t na ",
    26 => "Ka�d� den",
    27 => "T�den",
    28 => "Osobn� kalend�� pro",
    29 => "Ve�ejn� kalend��",
    30 => "smazat ud�lost",
    31 => "P�idat ud�lost",
    32 => "Ud�lost",
    33 => "Datum",
    34 => "�as",
    35 => "Rychl� p�id�n�",
    36 => "Potvrdit",
    37 => "Promi�te, Osobn� kalend�� nen� na t�chto str�nk�ch podporov�n",
    38 => "Editor osobn�ch ud�lost�",
    39 => 'Den',
    40 => 'T�den',
    41 => 'M�s�c'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " - zas�l�n� email�",
 	2 => "Od",
 	3 => "Zp�tn�  adresa",
 	4 => "Hlavi�ka",
 	5 => "Zpr�va",
 	6 => "Poslat:",
 	7 => "V�em u�ivatel�m",
 	8 => "Admin",
	9 => "Mo�nosti",
	10 => "HTML",
 	11 => "Urgentn� zpr�va!",
 	12 => "Poslat",
 	13 => "Smazat",
 	14 => "Ignorovat u�iv. nastaven�",
 	15 => "Chyba p�i zas�l�n�: ",
	16 => "Zasl�no: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Poslat dal�� zpr�vu</a>",
    18 => "Pro",
    19 => "POZOR: chcete-li zaslat zpr�vu v�em u�ivatel�m, vyberte Logged-in Users skupinu z roletov� nab�dky.",
    20 => "Odesl�no <successcount> zpr�v a nezasl�no <failcount> zpr�v.  Detaily jsou n��e u ka�d�ho pokusu o zasl�n� zvlṻ.  M��ete se pokusit znovu <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">zaslat zpr�vu</a> nebo <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">se vr�tit na str�nku administrace</a>.",
    21 => 'Chyby',
    22 => '�sp�n�',
    23 => 'Bez chyb',
    24 => 'Ne�sp�n�',
    25 => '- Vybrat skupinu -',
    26 => "Pros�m vypl�te v�echna pole ve formul��i a vyberte skupinu u�ivatel� z roletov� nab�dky."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Va�e p�ihla�ovac� heslo V�m bylo zasl�no na zadanou adresu. Pros�m n�sledujte prost� instrukce v po�t�. D�kujeme V�m za ��ast na " . $_CONF["site_name"],
	2 => "D�kujeme za p�id�n� �l�nku na {$_CONF["site_name"]}..",
	3 => "D�kujeme za p�id�n� odkazu na {$_CONF["site_name"]}..",
	4 => "D�kujeme za p�id�n� ud�losti na  {$_CONF["site_name"]}..",
	5 => "Va�e informace o ��tu byly ulo�eny.",
	6 => "Va�e vlastn� nastaven� bylo ulo�eno.",
	7 => "Va�e nastaven� koment��� bylo ulo�eno.",
	8 => "Byl jste �sp�n� odhl�en.",
	9 => "�l�nek byl ulo�en.",
	10 => "�l�nek byl vymaz�n.",
	11 => "Bloky byly ulo�eny.",
	12 => "Blok byl odstran�n.",
	13 => "Sekce byla ulo�ena.",
	14 => "Sekce a �l�nky s koment��i v n� byla smaz�na.",
	15 => "Odkaz byl ulo�en.",
	16 => "Odkaz byl odstran�n.",
	17 => "Ud�lost byla ulo�ena.",
	18 => "Ud�lost byla odstran�na.",
	19 => "Anketa byla ulo�ena.",
	20 => "Anketa byla odstran�na.",
	21 => "U�ivatel byl p�id�n/zm�n�n.",
	22 => "U�ivatel byl odstran�n.",
	23 => "Chyba v p�id�v�n� ud�losti do Osobn�ho kalend��e. Neexistuj�ci ID ud�losti.",
	24 => "Ud�lost bylo vlo�ena do va�eho kalend��e",
	25 => "Pro otev�en� osobn�ho kalend��e mus�te b�t p�ihl�en",
	26 => "Ud�lost byla vymaz�na z va�eho kalend��e",
	27 => "Vzkaz posl�n.",
	28 => "The plug-in has been successfully saved",
	29 => "Promi�te, Osobn� kalend�� nen� na t�chto str�nk�ch podporov�n",
	30 => "P��stup odep�en",
	31 => "Nem�te pr�va p��stupu k administraci �l�nk�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	32 => "Nem�te pr�va p��stupu k administraci sekc�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	33 => "Nem�te pr�va p��stupu k administraci blok�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	34 => "Nem�te pr�va p��stupu k administraci odkaz�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	35 => "Nem�te pr�va p��stupu k administraci ud�lost�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	36 => "Nem�te pr�va p��stupu k administraci anket.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	37 => "Nem�te pr�va p��stupu k administraci u�ivatel�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	38 => "Nem�te pr�va p��stupu k administraci plugin�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	39 => "Nem�te pr�va p��stupu k administraci enailov�ch u�ivatel�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
	40 => "Syst�mov� zpr�vy",
    41 => "Nem�te pr�va p��stupu k administraci slov.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
    42 => "Va�e slovo bylo ulo�eno.",
	43 => "Slovo bylo smaz�no.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => "Nem�te pr�va p��stupu k database backup utilit�.  V�echny neopr�vn�n� po�adavky a p��stupy jsou zaznamen�v�ny",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.",
    48 => 'D�kujeme za registraci na ' . $_CONF['site_name'] . '.  Va�e heslo pro p��stup do syst�mu V�m bylo zasl�no na email, kter� jste zadali.',
    49 => "Skupina byla �sp�n� ulo�ena.",
    50 => "Skupina byla �sp�n� smaz�na."
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=\"http://www.geeklog.net\">Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in please consult it's documentation.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Plugin Editor',
	14 => 'New Plug-in',
	15 => 'Administrace',
	16 => 'Plug-in Name',
	17 => 'Plug-in Version',
	18 => 'Geeklog Version',
	19 => 'Enabled',
	20 => 'Yes',
	21 => 'No',
	22 => 'Install',
  23 => 'ulo�it',
  24 => 'zru�it akci',
  25 => 'smazat',
  26 => 'Plug-in Name',
  27 => 'Plug-in Homepage',
  28 => 'Plug-in Version',
  29 => 'Geeklog Version',
  30 => 'smazat Plug-in?',
  31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
);

$LANG_ACCESS = array(
	access => "Pr�va",
    ownerroot => "Vlastn�k-Root",
    group => "Skupina",
    readonly => "Jen pro �ten�",
	accessrights => "P��stupov� pr�va",
	owner => "Vlastn�k",
	grantgrouplabel => "Zaru�uje pr�va vy��� ne� pr�va skupiny pro editaci",
	permmsg => "PAMATUJTE: <i>u�ivatel�</i> jsou p�ihl�en� u�ivatel� weblogu a <i>host�</i> jsou v�ichni, kdo si prohl��ej� weblog bez p�ihl�en�.",
	securitygroups => "Skupiny/�rove� pr�v",
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
	securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
	groupeditor => "Editor skupin u�ivatel�",
	description => "Popis",
	name => "Jm�no",
 	rights => "Pr�va",
	missingfields => "Chyb�j�c� pole",
	missingfieldsmsg => "You must supply the name and a description for a group",
	groupmanager => "Mana�er skupin u�ivatel�",
	newgroupmsg => "To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used v syst�mu.",
	groupname => "Jm�no skupiny u�ivatel�",
	coregroup => "Hlavn� skupina",
	yes => "Ano",
	no => "Ne",
	corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
	groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
	coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
	rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
	lock => "Uzam�eno",
	members => "U�ivatel�",
	anonymous => "Host�",
	permissions => "P�id�len� opr�vn�n�",
	permissionskey => "R = �ten�, E = editace, edita�n� pr�va v sob� zahrnuj� i pr�vo ��st!",
	edit => "Editace",
	none => "Nen�",
	accessdenied => "P��stup odep�en",
	storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
	grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
	newgroup => 'Nov� skupina u�ivatel�',
	adminhome => 'Administrace',
	save => 'ulo�it',
	cancel => 'zru�it akci',
	delete => 'smazat',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is Chyba'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word.  To create a new word replacement click the new word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Last 10 Back-ups',
    do_backup => 'Do Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'Nejsou ��dn� z�lohy syst�mu',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below',
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "Chyba: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Homepage",
    2 => "Kontakt",
    3 => "Publikovat",
    4 => "Odkazy",
    5 => "Ankety",
    6 => "Kalend��",
    7 => "Statistika",
    8 => "Vlastn� nastaven�",
    9 => "Hled�n�",
    10 => "roz���en� hled�n�"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>%s</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Je nutn� se p�ihl�sit',
    2 => 'Promi�te, pro p��stup je nutn� b�t p�ihl�en jako u�ivatel.',
    3 => 'P�ihl�sit',
    4 => 'Nov� u�ivatel'
);

?>
