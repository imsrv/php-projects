<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Name');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Shop Name');
define('STORE_NAME_DESC' , 'Der Name dieses Online Shops');
define('STORE_OWNER_TITLE' , 'Inhaber');
define('STORE_OWNER_DESC' , 'Der Name des Shop-Betreibers');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'E-Mail Adresse');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'Die E-mail Adresse des Shop-Betreibers');

define('EMAIL_FROM_TITLE' , 'E-Mail von');
define('EMAIL_FROM_DESC' , 'E-mail Adresse die beim versenden (send mail)benutzt werden soll.');

define('STORE_COUNTRY_TITLE' , 'Land');
define('STORE_COUNTRY_DESC' , 'Das Land aus dem der Versand erfolgt <br><br><b>Hinweis: Bitte nicht vergessen die Region richtig anzupassen.</b>');
define('STORE_ZONE_TITLE' , 'Region');
define('STORE_ZONE_DESC' , 'Die Region des Landes aus dem der Versand erfolgt.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Reihenfolge f�r Produktank�ndigungen');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'Das ist die Reihenfolge wie angek�ndigte Produkte angezeigt werden.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Sortierfeld f�r Produktank�ndigungen');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'Das ist die Spalte die zum Sortieren angek�ndigter Produkte benutzt wird.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Auf die Landesw�hrung automatisch umstellen');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Wenn die Spracheinstellung gewechselt wird automatisch die W�hrung anpassen.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Eine extra Bestell E-mail an:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Wenn zus�tzlich eine Kopie der Bestell Emails versendet werden soll, bitte in dieser Weise die Empfangs-Adressen auflisten: Name 1 &lt;email@adresse1&gt;, Name 2 &lt;email@adresse2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Suchmaschinenfreundliche URLs benutzen?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Die Seiten URLs k�nnen automatisch f�r Suchmaschinen optimiert angezeigt werden.');

define('DISPLAY_CART_TITLE' , 'Soll Warenkorb nach dem einf�gen Angezeigt werden?');
define('DISPLAY_CART_DESC' , 'Nach dem Einf�gen zum Einkaufswagen oder zur�ck zum Produkt leiten?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'G�sten erlauben ihre Bekannten per Mail zu informieren?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'G�sten erlauben ihre Bekannten per Mail �ber Produkte etc zu informieren?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Suchverkn�pfungen');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Der Standard Operator zum Verkn�pfen von Suchw�rtern.');

define('STORE_NAME_ADDRESS_TITLE' , 'Gesch�ftsadresse und Telefonnummer etc');
define('STORE_NAME_ADDRESS_DESC' , 'Tragen Sie hier Ihre Gesch�ftsadresse wie in einem Briefkopf ein.');

define('SHOW_COUNTS_TITLE' , 'Artikel in Warengruppen z�hlen');
define('SHOW_COUNTS_DESC' , 'Z�hlt rekursiv die Anzahl der verschiedenen Artikel pro Warengruppe');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Steuer im Preis anzeigen');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Preise inklusive Steuer anzeigen (true) oder am Ende aufrechnen (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Kundenstatus(Kundengruppe) f�r Administratoren');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'W�hlen Sie den Kundenstatus(Gruppe) f�r Administratoren anhand der jeweiligen ID!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Kundenstatus(Kundengruppe) f�r G�ste');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'W�hlen Sie den Kundenstatus(Gruppe) f�r G�ste anhand der jeweiligen ID!<br>Sie k�nnen im Men� Kundengruppen');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Kundenstatus f�r Neukunden');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'W�hlen Sie den Kundenstatus(Gruppe) f�r G�ste anhand der jeweiligen ID!<br>TIP: Sie k�nnen im Men� Kundengruppen weitere Gruppen einrichten und zb Aktionswochen machen: Diese Woche 10 % Rabatt f�r alle Neukunden?');

define('ALLOW_ADD_TO_CART_TITLE' , 'Erlauben Artikel in den Einkaufswagen zu legen');
define('ALLOW_ADD_TO_CART_DESC' , 'Erlaubt das Einf�gen von Ware in den Warenkorb trotzdem, wenn "Preise anzeigen" in der Kundengruppe auf "Nein" steht');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Discounts auch auf die Produktattribute verwenden?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Erlaubt den eingestellten Discount der Kundengruppe auch auf die Produktattribute anzuwenden(Nur wenn der Artikel nicht als "Sonderangebot" ausgewiesen ist)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Vorname');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum L�nge des Vornamens');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Nachname');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum L�nge des Nachnamens');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Geburtsdatum');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum L�nge des Geburtsdatums');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail Adresse');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L�nge der E-mail Adresse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Stra�e');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L�nge der Stra�enanschrift');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Firma');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimuml�nge des Firmennamens');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Postleitzahl');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum L�nge der Postleitzahl');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Stadt');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum L�nge des St�dtenamens');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Bundesland');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum L�nge des Bundeslandes');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telefon Nummer');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum L�nge der Telefon Nummer');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Passwort');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum L�nge des Passwort');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Kreditkarteninhaber');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum L�nge des Namens des Kreditkarteninhabers');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Kreditkartennummer');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum L�nge von Kreditkartennummern');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Bewertungen');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum L�nge der Texteingabe bei Bewertungen');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Bestseller');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum Anzahl der Bestseller, die angezeigt werden sollen');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft..');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum Anzahl der ebenfalls gekauften Artikel, die bei der Produktansicht angezeigt werden sollen');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Adressbuch Eintr�ge');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum erlaubte Anzahl an Adressbucheintr�gen');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Suchergebnisse');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Anzahl der Artikel die als Suchergebnis angezeigt werden sollen');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Seiten bl�ttern');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Anzahl der Einzelseiten, f�r die ein Link angezeigt werden soll im Seitennavigationsmen�');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Sonderangebote');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum Anzahl an Sonderangeboten, die angezeigt werden sollen');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Neue Produkte Anzeigemodul');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum Anzahl an neuen Artikeln, die bei den Warenkategorien angezeigt werden sollen');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Erwartete Produkte Anzeigemodul');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum Anzahl an erwarteten Produkten die auf der Startseite angezeigt werden sollen');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Hersteller-Liste Schwellenwert');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'In der Hersteller Box; Wenn die Anzahl der Hersteller diese Schwelle �bersteigt wird anstatt der �blichen Liste eine Popup Liste angezeigt');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Hersteller Liste');
define('MAX_MANUFACTURERS_LIST_DESC' , 'In der Hersteller Box; Wenn der Wert auf "1" gesetzt wird, wird die Herstellerbox als Drop Down Liste angezeigt. Andernfalls als Liste.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'L�nge des Herstellernamens');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'In der Hersteller Box; Maximum L�nge von Namen in der Herstellerbox');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Neue Bewertungen');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum Anzahl an neuen Bewertungen die angezeigt werden sollen');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Auswahlpool der Bewertungen');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'Aus wieviel Bewertungen sollen die zuf�llig angezeigten Bewertungen in der Box ausgew�hlt werden?');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Auswahlpool der Neuen Produkte');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'Aus wieviel neuen Produkten sollen die zuf�llig angezeigten neuen Produkte in der Box ausgew�hlt werden?');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Auswahlpool der Sonderangebote');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'Aus wieviel Sonderangeboten sollen die zuf�llig angezeigten Sonderangebote in der Box ausgew�hlt werden?');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Anzahl an Warengruppen');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'Anzahl an Warengruppen die pro Zeile in den �bersichten angezeigt werden sollen.');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Neue Produkte Liste');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum Anzahl neuer Produkte die in der Liste angezeigt werden sollen.');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Bestsellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum Anzahl an Bestsellern die angezeigt werden sollen');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft..');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum Anzahl der ebenfalls gekauften Artikel, die bei der Produktansicht angezeigt werden sollen');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Bestell�bersichts Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum Anzahl an Produkten die in der pers�nlichen Bestell�bersichts Box des Kunden angezeigt werden sollen.');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Bestell�bersicht');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum Anzahl an Bestellungen die in der �bersicht im Kundenbereich des Shop angezeigt werden sollen.');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Breite der Produktbilder');
define('SMALL_IMAGE_WIDTH_DESC' , 'Breite der Produktbilder in Pixel (bei eingabe von 0, werden diese autom. skaliert)');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'H�he der Produktbilder');
define('SMALL_IMAGE_HEIGHT_DESC' , 'H�he der Produktbilder in Pixel (bei eingabe von 0, werden diese autom. skaliert)');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Breite der �berschrift Bilder');
define('HEADING_IMAGE_WIDTH_DESC' , 'Breite der �berschrift Bilder in Pixel');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'H�he der �berschrift Bilder');
define('HEADING_IMAGE_HEIGHT_DESC' , 'H�he der �berschriftbilder in Pixel');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Breite der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'Breite der Subkategorie-(Warengruppen-) Bilder in Pixel');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'H�he der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'H�he der Subkategorie-(Warengruppen-) Bilder in Pixel');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Bildgr��e berechnen');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Sollen die Bildgr��en berechnet werden?');

define('IMAGE_REQUIRED_TITLE' , 'Bilder werden ben�tigt?');
define('IMAGE_REQUIRED_DESC' , 'Wenn Sie hier auf "1" setzen, werden nicht vorhandene Bilder als Rahmen angezeigt. Gut f�r Entwickler.');

define('ACCOUNT_GENDER_TITLE' , 'Geschlecht im Account');
define('ACCOUNT_GENDER_DESC' , 'Die Abfrage f�r das Geschlecht im Account benutzen');
define('ACCOUNT_DOB_TITLE' , 'Geburtsdatum');
define('ACCOUNT_DOB_DESC' , 'Die Abfrage f�r das Geburtsdatum im Account benutzen');
define('ACCOUNT_COMPANY_TITLE' , 'Firma');
define('ACCOUNT_COMPANY_DESC' , 'Die Abfrage f�r die Firma im Account benutzen');
define('ACCOUNT_SUBURB_TITLE' , 'Vorort');
define('ACCOUNT_SUBURB_DESC' , 'Die Abfrage f�r den Vorort im Account benutzen');
define('ACCOUNT_STATE_TITLE' , 'Bundesland');
define('ACCOUNT_STATE_DESC' , 'Die Abfrage f�r das Bundesland im Account benutzen');

define('DEFAULT_CURRENCY_TITLE' , 'Standard W�hrung');
define('DEFAULT_CURRENCY_DESC' , 'W�hrung die standardm��ig benutzt wird');
define('DEFAULT_LANGUAGE_TITLE' , 'Standard Sprache');
define('DEFAULT_LANGUAGE_DESC' , 'Sprache die standardm��ig benutzt wird');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Default Bestellstatus bei neuen Bestellungen');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Wenn eine neue Bestellung eingeht, wird dieser Status als Bestellstatus gesetzt.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Versandland');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'W�hlen Sie das Versandland aus, zur Berechnung korrekter Versandgeb�hren.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postleitzahl des Versandstandortes');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Bitte geben Sie die Postleitzahl des Versandstandortes ein, der zur Berechnung der Versandkosten in Frage kommt.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Maximalgewicht, da� als ein Paket versendet werden kann');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Versandpartner(Post/UPS etc haben ein maximales Paketgewicht. Geben Sie einen Wert daf�r ein.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Paketleergewicht.');
define('SHIPPING_BOX_WEIGHT_DESC' , 'Wie hoch ist das Gewicht eines durchschnittlichen kleinen bis mittleren Leerpaketes?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Bei gr��eren Leerpaketen - Gewichtszuwachs in %.');
define('SHIPPING_BOX_PADDING_DESC' , 'F�r etwa 10% geben Sie 10 ein');

define('PRODUCT_LIST_FILTER_TITLE' , 'Anzeige der Sortierungsfilter in Produktlisten?');
define('PRODUCT_LIST_FILTER_DESC' , 'Anzeige der Sortierungsfilter f�r Warengruppen/Hersteller etc Filter (0=inaktiv; 1=aktiv)');

define('STOCK_CHECK_TITLE' , '�berpr�fen des Warenbestandes');
define('STOCK_CHECK_DESC' , 'Pr�fen ob noch genug Ware zum Ausliefern von Bestellungen verf�gbar ist.');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , '�berpr�fen des Produktattribut Bestandes');
define('ATTRIBUTE_STOCK_CHECK_DESC' , '�berpr�fen des Bestandes an Ware mit bestimmten Produktattributen');

define('STOCK_LIMITED_TITLE' , 'Warenmenge abziehen');
define('STOCK_LIMITED_DESC' , 'Warenmenge im Warenbestand abziehen, wenn die Ware bestellt wurde');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Einkaufen nicht vorr�tiger Ware erlauben');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'M�chten Sie auch dann erlauben zu bestellen, wenn bestimmte Ware laut Warenbestand nicht verf�gbar ist?');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Kennzeichnung vergriffener Produkte');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Dem Kunden kenntlich machen, welche Produkte nicht mehr verf�gbar sind.');
define('STOCK_REORDER_LEVEL_TITLE' , 'Meldung an den Admin dass ein Produkt nachbestellt werden muss');
define('STOCK_REORDER_LEVEL_DESC' , 'Ab welcher St�ckzahl soll diese Meldung erscheinen?');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Speichern der Berechnungszeit der Seite');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Speicher der Zeit die ben�tigt wird, um Skripte bis zum Output der Seite zu berechnen');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Speicherort des Logfile der Berechnungszeit');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Ordner und Filenamen eintragen f�r den Logfile f�r Berechnung der Parsing Dauer');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Datum Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'Das Datumsformat f�r Logging');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Berechnungszeiten der Seiten anzeigen');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Wenn das Speichern der Berechnungszeiten f�r Seiten eingeschaltet ist, k�nnen diese im Footer angezeigt werden.');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Speichern der Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Speichern der einzelnen Datenbank Queries im Logfile f�r Berechnungszeiten (PHP4 only)');

define('USE_CACHE_TITLE' , 'Cache benutzen');
define('USE_CACHE_DESC' , 'Die Cache Features verwenden');

define('DIR_FS_CACHE_TITLE' , 'Cache Ordner');
define('DIR_FS_CACHE_DESC' , 'Der Ordner wo die gecachten Files gespeichert werden sollen');

define('ACCOUNT_OPTIONS_TITLE','Art der Accounterstellung');
define('ACCOUNT_OPTIONS_DESC','Wie m�chten Sie die Anmeldeprozedur in Ihrem Shop gestallten ?<br>Sie haben die Wahl zwischen Kundenkonten und "einmal Bestellungen" ohne erstellung eines Kundenkontos (es wird ein Konto erstellt, aber dies ist f�r den Kunden nicht ersichtlich)');
define('EMAIL_TRANSPORT_TITLE' , 'E-Mail Transport Methode');
define('EMAIL_TRANSPORT_DESC' , 'Definiert ob der Server eine lokale Verbindung zum "Sendmail-Programm" benutzt oder ob er eine SMTP Verbindung �ber TCP/IP ben�tigt. Server die auf Windows oder MacOS laufen sollten SMTP verwenden.');
define('EMAIL_LINEFEED_TITLE' , 'E-Mail Linefeeds');
define('EMAIL_LINEFEED_DESC' , 'Definiert die Zeichen die benutzt werden sollen um die Mail Header zu trennen.');
define('EMAIL_USE_HTML_TITLE' , 'Benutzen von MIME HTML beim Versand von E-mails');
define('EMAIL_USE_HTML_DESC' , 'E-mails im HTML Format versenden');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , '�berpr�fen der E-Mail Adressen �ber DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Die E-mail Adressen k�nnen �ber einen DNS Server gepr�ft werden');
define('SEND_EMAILS_TITLE' , 'Senden von E-Mails');
define('SEND_EMAILS_DESC' , 'E-mails an Kunden versenden (bei Bestellungen etc)');
define('SENDMAIL_PATH_TITLE' , 'Der Pfad zu Sendmail');
define('SENDMAIL_PATH_DESC' , 'Wenn Sie Sendmail benutzen, geben Sie hier den Pfad zum Sendmail Programm an(normalerweise: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adresse des SMTP Servers');
define('SMTP_MAIN_SERVER_DESC' , 'Geben Sie die Adresse Ihres Haupt SMTP Servers ein.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adresse des SMTP Backup Servers');
define('SMTP_BACKUP_SERVER_DESC' , 'Geben Sie die Adresse Ihres Backup SMTP Servers ein.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Bitte geben Sie hier den Usernamen Ihres SMTP Accounts ein.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Passwort');
define('SMTP_PASSWORD_DESC' , 'Bitte geben Sie hier das Passwort Ihres SMTP Accounts ein.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Erfordert der SMTP Server eine sichere Authentifizierung?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Geben sie den SMTP Port Ihres SMTP Servers ein (default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Contact Us - email adress');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f�r das Versenden der mails �ber das "Contact Us" Formular ein.');
define('CONTACT_US_NAME_TITLE' , 'Contact Us - email adress, name');
define('CONTACT_US_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f�r das Versenden der mails �ber das "Contact Us" Formular ein.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Contact Us - Forwarding adresses');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Geben Sie weitere mailadresse ein, wohin die emails des "Contact Us" Formulares noch versendet werden sollen (mit , getrennt)');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Contact Us - reply adress');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine emailadresse ein, an die Ihre Kunden Antworten k�nnen..');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Absender name f�r replay emails.');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Absender name f�r replay emails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Contact Us - email subject');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Please Enter Email Subject for the contact-us messages via shop to your office.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technical Support - email adress');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f�r das Versenden der mails �ber das <b>Support System</b> ein (Accounterstellung,Password�nderung).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technical Support - email adress, name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f�r das Versenden der mails �ber das <b>Support System</b> ein (Accounterstellung,Password�nderung).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technical Support - Forwarding adresses');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Geben Sie weitere mailadresse ein, wohin die emails des <b>Support Systemes</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technical Support - reply adress');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine emailadresse ein, an die Ihre Kunden Antworten k�nnen.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technical Support - reply adress, name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Absender name f�r replay emails.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technical Support - email subject');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Please Enter Email Subject for the <b>Support system</b> messages via shop to your office.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing - email adress');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f�r das Versenden der mails �ber das <b>Billing system</b> ein (Bestellbest�tigung,Status�nderungen,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing - email adress, name');
define('EMAIL_BILLING_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f�r das Versenden der mails �ber das <b>Billing System</b> ein (Bestellbest�tigung,Status�nderungen,..).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing - Forwarding adresses');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Geben Sie weitere mailadresse ein, wohin die emails des <b>Billing Systemes</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing - reply adress');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine emailadresse ein, an die Ihre Kunden Antworten k�nnen.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing - reply adress, name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Absender name f�r replay emails.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing - email subject');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Please Enter Email Subject for the <b>Billing</b> messages via shop to your office.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing - Ordermail subject');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Please enter a subject for ordermails generated from xtc. (like <b>our order {$nr},{$date}</b>) ps: you can use, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Download von Produkten erlauben');
define('DOWNLOAD_ENABLED_DESC' , 'Die Produkt Download Funktionen einschalten (Software etc).');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download durch Redirection');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Browser-Umleitung f�r Produktdownloads benutzen. Auf nicht Linux/Unix Systemen ausschalten.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Verfallsdatum der Download Links(Tage)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Anzahl an Tagen, die ein Download Link f�r den Kunden aktiv bleibt. 0 bedeutet ohne Limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximale Anzahl der Downloads eines gekauften Medienproduktes');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Stellen Sie die maximale Anzahl an Downloads ein, die Sie dem Kunden erlauben, der ein Produkt dieser Art erworben hat. 0 bedeutet kein Download.');

define('GZIP_COMPRESSION_TITLE' , 'GZip Kompression einschalten');
define('GZIP_COMPRESSION_DESC' , 'Schalten Sie HTTP GZip Kompression ein um die Seitenaufbaugeschwindigkeit zu optimieren.');
define('GZIP_LEVEL_TITLE' , 'Kompressions Level');
define('GZIP_LEVEL_DESC' , 'W�hlen Sie einen Kompressionslevel zwischen 0-9 (0 = Minimum, 9 = Maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Speicherort');
define('SESSION_WRITE_DIRECTORY_DESC' , 'Wenn Sessions als Files gespeichert werden sollen, benutzen Sie folgenden Ordner.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Cookie Benutzung bevorzugen');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Session starten falls Cookies vom Browser erlaubt werden.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Checken der SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , '�berpr�fen der SSL_SESSION_ID bei jedem HTTPS Seitenaufruf.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Checken des User Browsers');
define('SESSION_CHECK_USER_AGENT_DESC' , '�berpr�fen des Browsers den der User benutzt, bei jedem Seitenaufruf.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Checken der IP Adresse');
define('SESSION_CHECK_IP_ADDRESS_DESC' , '�berpr�fen der IP Adresse des Users bei jedem Seitenaufruf.');
define('SESSION_BLOCK_SPIDERS_TITLE' , 'Spider Sessions vermeiden');
define('SESSION_BLOCK_SPIDERS_DESC' , 'Bekannte Suchmaschinen Spider ohne Session auf die Seite lassen.');
define('SESSION_RECREATE_TITLE' , 'Session erneuern');
define('SESSION_RECREATE_DESC' , 'Erneuern der Session und Zuweisung einer neuen Session ID sobald ein User einloggt oder sich registriert (PHP >=4.1 needed).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Unterzeichnen der AGB');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Anzeigen und Unterzeichnen der AGB beim Bestellvorgang');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Minimum L�nge Meta-Keywords');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Minimum L�nge der automatisch erzeugten Meta-Keywords (Produktbeschreibung)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Anzahl der Meta-Keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'Anzahl der Meta-Keywords');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="company">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installed Payment Modules');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installed  OT-Modules');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installed Shipping Modules');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)');


define('CACHE_LIFETIME_TITLE','Cache Lifetime');
define('CACHE_LIFETIME_DESC','This is the number of seconds cached content will persist');
define('CACHE_CHECK_TITLE','Check if cache modified');
define('CACHE_CHECK_DESC','If true, then If-Modified-Since headers are respected with cached content, and appropriate HTTP headers are sent. This way repeated hits to a cached page do not send the entire page to the client every time.');
?>