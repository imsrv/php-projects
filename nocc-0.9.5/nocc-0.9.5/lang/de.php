<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/de.php,v 1.19.2.1 2001/11/25 10:04:05 wolruf Exp $ 
 *
 * Copyright 2000 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2000 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the german language
 * Translation by David Ferch <dferch@tk-online.net>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'de_DE';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%d.%m.%Y'; 

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%d.%m.%Y';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = '%I:%M %p';


// Here is the configuration for the HTML

$err_user_empty = 'Kein Nutzername eingegeben';
$err_passwd_empty = 'Kein Passwort eingegeben';


// html message

$alt_delete = 'Markierte Nachrichten l&ouml;schen';
$alt_delete_one = 'Nachricht l&ouml;schen';
$alt_new_msg = 'Neue Nachrichten';
$alt_reply = 'Antwort an Absender';
$alt_reply_all = 'Antwort an alle';
$alt_forward = 'Weiterleitung';
$alt_next = 'N&auml;chste';
$alt_prev = 'Vorige';
$html_on = 'an';
$html_theme = 'Theme';

// index.php

$html_lang = 'Sprache';
$html_welcome = 'Willkommen bei';
$html_login = 'Login';
$html_passwd = 'Passwort';
$html_submit = 'Ok';
$html_help = 'Hilfe';
$html_server = 'Server';
$html_wrong = 'Der Nutzername oder das Passwort sind falsch';
$html_retry = 'Nochmal';

// prefs.php

$html_preferences = 'Einstellungen';
$html_full_name = 'Voller Name';
$html_email_address = 'E-mail Addresse';
$html_ccself = 'Cc self';
$html_hide_addresses = 'Adressen verstecken';
$html_outlook_quoting = 'Quoting im Outlook-Stil';
$html_reply_to = 'Antwort an';
$html_use_signature = 'Signatur benutzen';
$html_signature = 'Signatur';
$html_prefs_updated = 'Einstellungen gespeichert';

// Other pages

$html_view_header = 'Header anzeigen';
$html_remove_header = 'Header verbergen';
$html_inbox = 'Inbox';
$html_new_msg = 'Schreiben';
$html_reply = 'Antworten';
$html_reply_short = 'Re';
$html_reply_all = 'Antwort an alle';
$html_forward = 'Weiterleitung';
$html_forward_short = 'Fwd';
$html_delete = 'L&ouml;schen';
$html_new = 'Neu';
$html_mark = 'L&ouml;schen';
$html_att = 'Anhang';
$html_atts = 'Anh&auml;nge';
$html_att_unknown = '[unbekannt]';
$html_attach = 'Anh&auml;ngen';
$html_attach_forget = 'Sie m&uuml;ssen die Datei vor dem Senden der Nachricht anh&auml;ngen !';
$html_attach_delete = 'Ausgew&auml;hlte entfernen';
$html_sort_by = 'Sortieren nach';
$html_from = 'Von';
$html_subject = 'Betreff';
$html_wrote = 'schrieb';
$html_date = 'Datum';
$html_sent = 'Senden';
$html_size = 'Gr&ouml;sse';
$html_totalsize = 'Gesamtgr&ouml;sse';
$html_kb = 'KB';
$html_bytes = 'Byte';
$html_filename = 'Datei';
$html_to = 'An';
$html_cc = 'Kopie';
$html_bcc = 'Blindekopie';
$html_nosubject = 'Kein Betreff';
$html_send = 'Senden';
$html_cancel = 'Abbrechen';
$html_no_mail = 'Keine neue Nachrichten.';
$html_logout = 'Abmelden';
$html_msg = 'Nachricht';
$html_msgs = 'Nachrichten';
$html_configuration = 'This server is not well set up !';
$html_priority = 'Priorit&auml;t';
$html_low = 'Niedrig';
$html_normal = 'Normal';
$html_high = 'Hoch';
$html_select = 'Auswahl';
$html_select_all = 'Alle';
$html_loading_image = 'Lade Bild';
$html_send_confirmed = 'Ihre Mail wurde verschickt.';
$html_no_sendaction = 'Keine Aktion angegeben. Versuchen Sie es mit eingeschaltetem JavaScript.';
$html_error_occurred = 'Ein Fehler ist aufgetreten';
$html_prefs_file_error = 'Kann Ihre Einstellungen-Datei nicht zum Schreiben &ouml;ffnen.';
$html_sig_file_error = 'Kann Ihre Signatur-Datei nicht zum Schreiben &ouml;ffnen.';

$original_msg = '-- Original Nachricht--';
$to_empty = 'Das \'An\' Feld darf nicht leer sein !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = 'Konnte Verbindung nicht &ouml;ffnen';
$html_smtp_error_unexpected = 'Unerwartete Antwort:';
?>