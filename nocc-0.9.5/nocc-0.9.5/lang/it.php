<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/it.php,v 1.17 2001/11/18 18:17:34 wolruf Exp $
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Italian language
 * Translation by Guido Venturini <guido@technojuice.com>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use (Here, italian IT--> it_IT)
// see '/usr/share/locale/' for more information
$lang_locale = 'it_IT';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%A %d %B %Y';

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%d-%m-%Y';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = '%H:%M';


// Here is the configuration for the HTML

$err_user_empty = 'Campo di login vuoto';
$err_passwd_empty = 'Non hai digitato la password';


// html message

$alt_delete = 'Elimina il messaggio selezionato';
$alt_delete_one = 'Elimina il messaggio';
$alt_new_msg = 'Nuovo messaggio';
$alt_reply = 'Rispondi al Mittente';
$alt_reply_all = 'Rispondi a tutti';
$alt_forward = 'Inoltra';
$alt_next = 'Prossimo';
$alt_prev = 'Precedente';


// index.php

$html_lang = 'Lingua';
$html_welcome = 'Benvenuto a';
$html_login = 'Login';
$html_passwd = 'Password';
$html_submit = 'Ok';
$html_help = 'Aiuto';
$html_server = 'Server';
$html_wrong = 'Login o password non corretti';
$html_retry = 'Riprova';
$html_on = 'sicuro';
$html_theme = 'Tema';

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

$html_view_header = 'Mostra intestazione';
$html_remove_header = 'Nascondi intestazione';
$html_inbox = 'Inbox';
$html_new_msg = 'Scrivi';
$html_reply = 'Rispondi';
$html_reply_short = 'Re';
$html_reply_all = 'Rispondi a tutti';
$html_forward = 'Inoltra';
$html_forward_short = 'Fw';
$html_delete = 'Elimina';
$html_new = 'Nuovo';
$html_mark = 'Elimina';
$html_att = 'Allegato';
$html_atts = 'Allegati';
$html_att_unknown = '[sconosciuto]';
$html_attach = 'Allegato';
$html_attach_forget = 'Devi allegare il file prima di inviare il messaggio !';
$html_attach_delete = 'Elimina i files selezionati';
$html_sort_by = 'Sort by';
$html_from = 'da';
$html_subject = 'Oggetto';
$html_date = 'Data';
$html_sent = 'Invia';
$html_size = 'Dimensione';
$html_totalsize = 'Dimensione Totale';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'File';
$html_to = 'A';
$html_cc = 'Cc';
$html_bcc = 'Bcc';
$html_nosubject = 'Senza Oggetto';
$html_send = 'Invia';
$html_cancel = 'Annulla';
$html_no_mail = 'Non vi sono nuovi messaggi.';
$html_logout = 'Esci';
$html_msg = 'Messaggio';
$html_msgs = 'Messaggi';
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

$original_msg = '-- Messaggio Originale --';
$to_empty = 'Il campo \'A\' non può essere vuoto !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>