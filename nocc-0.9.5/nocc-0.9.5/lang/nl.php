<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/nl.php,v 1.15 2001/11/18 18:17:34 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Netherlander language
 * Translation by Sander Schroevers and Pieterjan Goppel
 *  <lp_leeki@euronet.nl>
 *  Some adding by Mathijs Kolenberg <mack@solcon.nl>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use
// see '/usr/share/locale/' for more information
$lang_locale = 'nl_NL';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%d-%m-%Y'; 

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%d-%m-%Y';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = '%I:%M %p';


// Here is the configuration for the HTML

$err_user_empty = 'Het inlog-veld is nog leeg';
$err_passwd_empty = 'Het password-veld is nog leeg';


// html message

$alt_delete = 'Verwijder de geselecteerde berichten';
$alt_delete_one = 'Verwijder dit bericht';
$alt_new_msg = 'Nieuwe berichten';
$alt_reply = 'Antwoord de verzender';
$alt_reply_all = 'Antwoord allemaal';
$alt_forward = 'Doorzenden';
$alt_next = 'Volgende';
$alt_prev = 'Vorige';


// index.php

$html_lang = 'Taal';
$html_welcome = 'Welkom op';
$html_login = 'Login';
$html_passwd = 'Wachtwoord';
$html_submit = 'Login';
$html_help = 'Help';
$html_server = 'Server';
$html_wrong = 'De login-naam of het wachtwoord is onjuist';
$html_retry = 'Probeer opnieuw';
$html_on = 'on';
$html_theme = 'Schema';

// prefs.php

$html_preferences = 'Preferences';
$html_full_name = 'Full name';
$html_email_address = 'E-mail Address';
$html_ccself = 'Cc self';
$html_hide_addresses = 'Hide addresses';
$html_outlook_quoting = 'Outlook-style quoting';
$html_reply_to = 'Reply to';
$html_use_signature = 'Use signature';
$html_signature = 'Signature';
$html_prefs_updated = 'Preferences updated';

// Other pages

$html_view_header = 'Broncode inzien';
$html_remove_header = 'Verberg broncode';
$html_inbox = 'Postvak In';
$html_new_msg = 'Schrijven';
$html_reply = 'Antwoorden';
$html_reply_short = 'Betr.:';
$html_reply_all = 'Antwoord allen';
$html_forward = 'Doorzenden';
$html_forward_short = 'Fw';
$html_delete = 'Verwijder';
$html_new = 'Nieuw';
$html_mark = 'Verwijder';
$html_att = 'Bijlage';
$html_atts = 'Bijlagen';
$html_att_unknown = '[onbekend]';
$html_attach = 'Voeg toe';
$html_attach_forget = 'You must attach your file before sending your message !';
$html_attach_delete = 'Verwijder selectie';
$html_sort_by = 'Sort by';
$html_from = 'Van';
$html_subject = 'Onderwerp';
$html_date = 'Datum';
$html_sent = 'Verzenden';
$html_size = 'Grootte';
$html_totalsize = 'Totale groote';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'Bestandsnaam';
$html_to = 'Aan';
$html_cc = 'CC';
$html_bcc = 'Bcc';
$html_nosubject = 'Geen onderwerp';
$html_send = 'Verzenden';
$html_cancel = 'Annuleren';
$html_no_mail = 'Geen nieuwe berichten';
$html_logout = 'Uitloggen';
$html_msg = 'Bericht';
$html_msgs = 'Berichten';
$html_configuration = 'This server is not well set up !';
$html_priority = 'Priority';
$html_low = 'Low';
$html_normal = 'Normal';
$html_high = 'High';
$html_select = 'Select';
$html_select_all = 'Select All';
$html_loading_image = 'Loading image';
$html_send_confirmed = 'Your mail was accepted for delivery';
$html_no_sendaction = 'No action specified. Try enabling JavaScript.';
$html_error_occurred = 'An error occurred';
$html_prefs_file_error = 'Unable to open preferences file for writing.';
$html_sig_file_error = 'Unable to open signature file for writing.';

$original_msg = '--Oorspronkelijk Bericht--';
$to_empty = 'Het \'Aan\'-veld kan niet leeg zijn !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>