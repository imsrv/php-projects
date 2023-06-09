<?php
/* --------------------------------------------------------------
   $Id: german.php,v 1.2 2003/09/07 15:11:41 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (german.php,v 1.8 2003/08/13); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
// Global
define('TEXT_FOOTER','Copyright  &copy; 2002 - 2003 <a href="http://www.xt-commerce.com">XT-Commerce</a><br>Powered by XT-Commerce'); 
   
// Box names
define('BOX_LANGUAGE','Sprache');
define('BOX_DB_CONNECTION','DB Verbindung') ;
define('BOX_WEBSERVER_SETTINGS','Webserver Einstellungen');
define('BOX_DB_IMPORT','DB Import');
define('BOX_WRITE_CONFIG','Schreiben der Konfigurationsdatei');
define('BOX_ADMIN_CONFIG','Administrator Konfiguration');
define('BOX_USERS_CONFIG','User Konfiguration');

define('PULL_DOWN_DEFAULT','Bitte W�hlen Sie ein Land');


// Error messages
 	// index.php
	define('SELECT_LANGUAGE_ERROR','Bitte w�hlen Sie eine Sprache!');
	// install_step2,5.php
	define('TEXT_CONNECTION_ERROR','Eine Testverbindung zur Datenbank war nicht erfolgreich.');
	define('TEXT_CONNECTION_SUCCESS','Eine Testverbindung zur Datenbank war erfolgreich.');
	define('TEXT_DB_ERROR','Folgender Fehler wurde zur�ckgegeben:');
	define('TEXT_DB_ERROR_1','Bitte klicken Sie auf <i>Back</i> um Ihre Datenbankeinstellungen zu �berpr�fen.');
	define('TEXT_DB_ERROR_2','Wenn Sie Hilfe zu Ihrer Datenbank ben�tigen, wenden Sie sich bitte an Ihren Provider.');
	// install_step6.php
	define('ENTRY_FIRST_NAME_ERROR','Vorname ist zu kurz');
	define('ENTRY_LAST_NAME_ERROR','Nachname ist zu kurz');
	define('ENTRY_EMAIL_ADDRESS_ERROR','E-Mail Adresse ist zu kurz');
	define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Bitte �berpr�fen Sie Ihre E-Mail Adresse');
	define('ENTRY_STREET_ADDRESS_ERROR','Stra�e ist zu kurz');
	define('ENTRY_POST_CODE_ERROR','Postleitzahl ist zu kurz');
	define('ENTRY_CITY_ERROR','Stadt ist zu kurz');
	define('ENTRY_COUNTRY_ERROR','Bitte �berpr�fen Sie das Bundesland');
	define('ENTRY_STATE_ERROR','Bitte �berpr�fen Sie das Land');
	define('ENTRY_TELEPHONE_NUMBER_ERROR','Telefonnummer ist zu kurz');
	define('ENTRY_PASSWORD_ERROR','Bitte �berpr�fen Sie das Passwort');
	define('ENTRY_STORE_NAME_ERROR','Shop-Name ist zu kurz');
	define('ENTRY_COMPANY_NAME_ERROR','Firmenname ist zu kurz');
	define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','E-Mail-From ist zu kurz');
	define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','Bitte �berpr�fen Sie den E-Mail-From');
	define('SELECT_ZONE_SETUP_ERROR','W�hlen Sie Zone-Setup');
	// install_step7.php
	define('ENTRY_DISCOUNT_ERROR','Product discount -Guest');
	define('ENTRY_OT_DISCOUNT_ERROR','Discount on ot -Guest');
	define('SELECT_OT_DISCOUNT_ERROR','Discount on ot -Guest');
	define('SELECT_GRADUATED_ERROR','Graduated Prices -Guest');
	define('SELECT_PRICE_ERROR','Show Price -Guest');
	define('SELECT_TAX_ERROR','Show Tax -Guest');
	define('ENTRY_DISCOUNT_ERROR2','Product discount -Default');
	define('ENTRY_OT_DISCOUNT_ERROR2','Discount on ot -Default');
	define('SELECT_OT_DISCOUNT_ERROR2','Discount on ot -Default');
	define('SELECT_GRADUATED_ERROR2','Graduated Prices -Default');
	define('SELECT_PRICE_ERROR2','Show Price -Default');
	define('SELECT_TAX_ERROR2','Show Tax -Default');
	
	


	
	
// index.php
define('TITLE_SELECT_LANGUAGE','W�hlen Sie eine Sprache!');

define('TEXT_WELCOME_INDEX','<b>Willkommen zu XT-Commerce</b><br><br>XT-Commerce ist eine Open-Source e-commerce L�sung, die st�ndig vom XT-Commerce Team und einer grossen Gemeinschaft weiterentwickelt wird.<br> Seine out-of-the-box Installation erlaubt es dem Shop-Besitzer seinen Online-Shop mit einem Minimum an Aufwand und Kosten zu installieren, zu betreiben und zu verwalten.<br><br>XT-Commerce ist auf jedem System lauff�hig, welches eine PHP Umgebung (ab PHP 4.1) und mySQL zur Verf�gung stellt, wie zum Beispiel Linux, Solaris, BSD, und Microsoft Windows.');
define('TEXT_WELCOME_STEP1','<b>Datenbank- und Webservereinstellungen</b><br><br>Der Installer ben�tigt hier einige Informationen bez�glich Ihrer Datenbank und Ihrer Verzeichnisstruktur.');
define('TEXT_WELCOME_STEP2','<b>Datenbank Installation</b><br><br>Der XT-Commerce Installer installiert automatisch die XT-Commerce-Datenbank.');
define('TEXT_WELCOME_STEP3','<b>Datenbank Import.</b><br><br>Die Daten der XT-Commerce Datenbank werden automatisch in die Datenbank importiert.');
define('TEXT_WELCOME_STEP4','<b>Konfiguration der XT-Commerce Konfig-Dateien</b><br><br><b>Wenn bereits configure Dateien aus einer fr�heren Installation vorhanden sind, wird XT-Commerce diese L�schen.</b><br><br>Der Installer schreibt die automatisch die Konfigurationsdateien f�r die Dateistruktur und die Datenbankanbindung.<br><br>Sie k�nnen zwischen verschiedenen Session-Handling_systemen w�hlen.');
define('TEXT_WELCOME_STEP5','<b>Webserver Konfiguration</b><br><br>');
define('TEXT_WELCOME_STEP6','<b>Grunds�tzliche Shopkonfiguration</b><br><br>Der Installer richtet den Admin-Account ein und schreibt noch diverse Daten in die Datenbank.<br>Die angegebenen Daten f�r <b>Country</b> und <b>Post Code</b> werden f�r die Versand und Steuerberechnungen genutzt.<br><br>Wenn Sie w�nschen, kann xtcommerce automatisch die Zonen, Steuers�tze und Steuerklassen f�r Versand und Verkauf innerhalb der EU einrichten.<br>Markieren Sie nur <b>setup zones for EU</b> - <b>YES</b>.');
define('TEXT_WELCOME_STEP7','<b>Setup f�r G�ste und Standardkunden</b><br><br>Das XT-Commerce Gruppen und Preissystem bietet Ihnen unbegrenzte M�glichkeiten der Preisgebung.<br><br>
<b>% Rabatt auf ein einzelnes Produkt</b><br>
%max kann f�r jedes einzelne Produkt und f�r jede einzelne Kundengruppe gesetzt werden.<br>
wenn %max f�r Produkt = 10.00% jedoch %max f�r Gruppe = 5% -> 5% Rabatt auf das Produkt<br>
wenn %max f�r Produkt = 10.00% jedoch %max f�r Gruppe = 15% -> 10% Rabatt auf das Produkt<br><br>
<b>% Rabatt auf die Gesamte Bestellung</b><br>
% Rabatt des Bestellwertes (nach Steuer und W�hrungsberechnung)<br><br>
<b>Staffelpreise</b><br>
Sie k�nnen ebenfalls beliebig viele Staffelpreise f�r einzelne Produkte und einzelne Kundengruppen einrichten.<br>
Sie k�nnen auch jedes dieser Systeme beliebig kombinieren, wie zum Beispiel:<br>
Kundengruppe 1 -> Staffelpreise auf das Produkt Y<br>
Kundengruppe 2 -> 10% Rabatt auf Produkt Y<br>
Kundengruppe 3 -> ein spezielle Gruppenpreis f�r Produkt Y<br>
Kundengruppe 4 -> Nettopreis f�r Produkt Y<br>
');
define('TEXT_WELCOME_FINISHED','<b>XT-Commerce Installation erfolgreich!</b><br><br>Der Installer hat nun die Grundfunktionen Ihres Shops eingerichtet. Melden Sie sich im Catalog mit Ihrem Admin-Account an und wechseln in den Admin_bereich, um die komplette Konfiguration Ihres Shops vorzunehmen.');

// install_step1.php

define('TITLE_CUSTOM_SETTINGS','Installations Optionen');
define('TEXT_IMPORT_DB','Importiere die XT-Commerce Datenbank');
define('TEXT_IMPORT_DB_LONG','Importiere die XT-Commerce Datenbankstruktur, welche die Tabellen und Beispieldaten enth�lt.');
define('TEXT_AUTOMATIC','Automatische Konfiguration');
define('TEXT_AUTOMATIC_LONG','Ihre Informationen bez�glich Webserver und Datenbank werden automatisch in die ben�tigten Catalog und Admin Konfigurations-Dateien geschrieben..');
define('TITLE_DATABASE_SETTINGS','Datenbank Informationen');
define('TEXT_DATABASE_SERVER','Datenbankserver');
define('TEXT_DATABASE_SERVER_LONG','Der Datenbankserver kann entweder in Form eines Hostnamens, wie zum Beispiel <i>db1.myserver.com</i> oder <i>localhost</i>, oder als IP-Adresse, wie <i>192.168.0.1</i> angegeben werden.');
define('TEXT_USERNAME','Benutzername');
define('TEXT_USERNAME_LONG','Der Benutzername, der zum konnektieren der Datenbank ben�tigt wird, wie zum Beispiel <i>mysql_10</i>.<br><br>Bemerkung: Wenn die XT-Commerce Datenbank Importiert werden soll (wenn oben ausgew�hlt), muss der Benutzer CREATE und DROP Rechte f�r die Datenbank haben. Sollten hier Probleme auftreten, kann Ihnen Ihr Provider weiterhelfen.');
define('TEXT_PASSWORD','Passwort');
define('TEXT_PASSWORD_LONG','Das Passwort wird zusammen mit dem Benutzernamen zum Verbindungsaufbau zur Datenbank benutzt.');
define('TEXT_DATABASE','Datenbank');
define('TEXT_DATABASE_LONG','Der Name der Datenbank, in die die Tabellen eingef�gt werden sollen.');
define('TITLE_WEBSERVER_SETTINGS','Webserver Informationen');
define('TEXT_WS_ROOT','Webserver Root Verzeichnis');
define('TEXT_WS_ROOT_LONG','Das Verzeichnis, in das die Webseiten gespeichert werden, zum Beispiel <i>/home/myname/public_html</i>.');
define('TEXT_WS_XTC','Webserver "XT-Commerce" Verzeichnis');
define('TEXT_WS_XTC_LONG','Das Verzeichnis, in welches die Shopdateien des Catalogs geladen wurden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/xtcommerce/</b></i>.');
define('TEXT_WS_ADMIN','Webserver Admin Verzeichnis');
define('TEXT_WS_ADMIN_LONG','Das Verzeichnis, in welchem sich die Admin-Werkzeuge Ihres Shops befinden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/xtcommerce/admin/</b></i>.');
define('TEXT_WS_CATALOG','WWW Catalog Verzeichnis');
define('TEXT_WS_CATALOG_LONG','Das virtuelle Verzeichnis, in dem sich die XT-Commerce Catalog-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/xtcommerce/</b></i>.');
define('TEXT_WS_ADMINTOOL','WWW Admin Verzeichnis');
define('TEXT_WS_ADMINTOOL_LONG','Das virtuelle Verzeichnis, in dem sich die XT-Commerce Admin-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/xtcommerce/admin/</b></i>');

// install_step2.php

define('TEXT_PROCESS_1','Bitte setzten Sie die Installation nun fort, um die Datenbank zu Importieren.');
define('TEXT_PROCESS_2','Dieser Vorgang nimmt einige Zeit in Anspruch. Es ist wichtig, dass Sie den Vorgang nun nicht unterbrechen, weil sonst die Datenbank m�glicherweise nicht korrekt installiert wird.');
define('TEXT_PROCESS_3','Die zu importierende Datei muss sich an folgendem Ort befinden. Diese befindet sich bei einem Standard-Upload dort.');


// install_step3.php

define('TEXT_TITLE_ERROR','Der folgende Fehler ist aufgetreten:');
define('TEXT_TITLE_SUCCESS','Der Datenbank-Import war erfolgreich.');

// install_step4.php
define('TITLE_WEBSERVER_CONFIGURATION','Webserver Informationen:');
define('TITLE_STEP4_ERROR','Der folgenden Fehler ist aufgetreten:');
define('TEXT_STEP4_ERROR','<b>Die Konfigurationsdateien existieren nicht, oder deren Rechte sind nicht richtig gesetzt.</b><br><br>Bitte F�hren Sie folgende Aktionen durch: ');
define('TEXT_STEP4_ERROR_1','Wenn <i>chmod 706</i> nicht funktioniert, versuchen Sie <i>chmod 777</i>.');
define('TEXT_STEP4_ERROR_2','Wenn Sie diese Installationsroutine in einer Windows Umgebung ausf�hren, versuchen Sie das Umbenennen der entsprechenden Dateien.');
define('TEXT_VALUES','Die folgenden Kofiguarations-Werte werden nun in die Dateien geschrieben:');
define('TITLE_CHECK_CONFIGURATION','Bitte pr�fen Sie Ihre Webserver Informationen');
define('TEXT_HTTP','HTTP Server');
define('TEXT_HTTP_LONG','Der Webserver kann als Hostnamen, wie zum Beispiel <i>http://www.myserver.com</i>, oder als IP-Adresse <i>http://192.168.0.1</i> angegeben werden.');
define('TEXT_HTTPS','HTTPS Server');
define('TEXT_HTTPS_LONG','Der gesicherte Webserver kann als Hostnamen, wie zum Beispiel <i>https://www.myserver.com</i>, oder als IP-Adresse <i>https://192.168.0.1</i> angegeben werden.');
define('TEXT_SSL','Benutze SSL-Verbindung');
define('TEXT_SSL_LONG','Erm�glicht die Nutzung einer gesicherten Verbindung mittels SSL (HTTPS)');
define('TITLE_CHECK_DATABASE','Bitte �berpr�fen Sie Ihre Datenbank Informationen');
define('TEXT_PERSIST','Benutze Persistente Verbindung');
define('TEXT_PERSIST_LONG','H�lt eine Verbindung zur Datenbank f�r l�ngere Zeit aufrecht. Auf den meisten geteilten Servern ist diese Funktion nicht m�glich.');
define('TEXT_SESS_FILE','Speichere Sessions in Dateien.');
define('TEXT_SESS_DB','Speichere Sessions in der Datenbank');
define('TEXT_SESS_LONG','Das Verzeichnis, in welches PHP die Session-Dateien speichert.');

// install_step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','<strong>XT-Commerce</strong> Webserver Konfiguration war erfolgreich');

// install_step6.php

define('TITLE_ADMIN_CONFIG','Administrator Konfiguration');
define('TEXT_REQU_INFORMATION','* erforderliche Information');
define('TEXT_FIRSTNAME','Vorname:');
define('TEXT_LASTNAME','Nachname:');
define('TEXT_EMAIL','E-Mail Adresse:');
define('TEXT_EMAIL_LONG','E-Mail Adresse, an die eine separate Mail bei Bestellungen gesendet werden soll.');				
define('TEXT_STREET','Stra�e:');
define('TEXT_POSTCODE','PLZ:');
define('TEXT_CITY','Stadt:');
define('TEXT_STATE','Bundesland/Province:');
define('TEXT_COUNTRY','Land:');
define('TEXT_COUNTRY_LONG','Wird benutzt f�r Versand und Steuern.');
define('TEXT_TEL','Telefonnummer:');
define('TEXT_PASSWORD','Passwort:');
define('TEXT_PASSWORD_CONF','Passwort Best�tigung:');
define('TITLE_SHOP_CONFIG','Shop Konfiguration');
define('TEXT_STORE','Shop Name:');
define('TEXT_STORE_LONG','Der Name des Shops.');
define('TEXT_EMAIL_FROM','E-Mail From');
define('TEXT_EMAIL_FROM_LONG','Die E-Mail Adresse, die in den Bestellungen als From benutzt wird.');
define('TITLE_ZONE_CONFIG','Zonen Konfiguration');
define('TEXT_ZONE','Aufsetzen der EU-Zonen?');
define('TITLE_ZONE_CONFIG_NOTE','*Note; xtcommerce kann die Zonen automatisch aufsetzten, sofern Sich Ihr Shop in der EU befindet.');
define('TITLE_SHOP_CONFIG_NOTE','*Note; Information for basic Shop configuration');
define('TITLE_ADMIN_CONFIG_NOTE','*Note; Informationen f�r Admin/Superuser');
define('TEXT_ZONE_NO','Nein');
define('TEXT_ZONE_YES','Ja');
define('TEXT_COMPANY','Firmenname');



// install_step7
define('TITLE_GUEST_CONFIG','Gast Konfiguration');
define('TITLE_GUEST_CONFIG_NOTE','*Note; Gast-User Einstellungen (nicht-registrierter Benutzer)');
define('TITLE_CUSTOMERS_CONFIG','Standard-Kunde Konfiguration');
define('TITLE_CUSTOMERS_CONFIG_NOTE','*Note; Standard-Kunde Einstellungen (registrierter Kunde)');
define('TEXT_STATUS_DISCOUNT','Rabatt auf Produkte');
define('TEXT_STATUS_DISCOUNT_LONG','Rabatt auf Produkte <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','Rabatt auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG',' Erlaubt den Rabatt auf den kompletten Bestellwert');
define('TEXT_STATUS_OT_DISCOUNT','Rabatth�he auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_LONG','H�he des Rabattes auf den Bestellwert <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','Staffelpreise');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','Erlaubt es dem entsprechenden User die Staffelpreise zu sehen.');
define('TEXT_STATUS_SHOW_PRICE','Preise');
define('TEXT_STATUS_SHOW_PRICE_LONG','Erlaubt es dem User, normale Preise zu sehen.');
define('TEXT_STATUS_SHOW_TAX','incl. Steuer');
define('TEXT_STATUS_SHOW_TAX_LONG','Zeigt die angegebenen Preise mit (Ja) oder ohne (Nein) Steuer.');
define('TEXT_STATUS_COD_PERMISSION','Per Nachnahme');
define('TEXT_STATUS_COD_PERMISSION_LONG','Erlaubt dem Kunden per Nachnahme zu bestellen.');
define('TEXT_STATUS_CC_PERMISSION','Kreditkarten.');
define('TEXT_STATUS_CC_PERMISSION_LONG','Erlaubt dem Kunden �ber ihre Kreditkartenzahlsysteme zu bestellen.');
define('TEXT_STATUS_BT_PERMISSION','Bankeinzug');
define('TEXT_STATUS_BT_PERMISSION_LONG','Erlaubt dem Kunden per Bankeinzug zu bestellen.');
// install_fnished.php

define('TEXT_SHOP_CONFIG_SUCCESS','<strong>XT-Commerce</strong> Shop Konfiguration war erfolgreich');
define('TEXT_TEAM','Vielen Dank, dass Sie sich f�r XT-Commerce entschieden haben. Besuchen Sie uns auf der XT-Commerce Supportseite <a href="http://www.xt-commerce.com">http://www.xt-commerce.com</a><br>Alles Gute und viel Erfolg w�nscht Ihnen das gesamte XT-Commerce Team.');
   
 ?>
