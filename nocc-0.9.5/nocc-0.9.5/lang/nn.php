<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/nn.php,v 1.2 2001/11/18 18:17:34 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Norwegian language
 * Translation by Ove Ruben R Olsen <ruben@noia.no>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'no_NO';

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

$err_user_empty = 'Felt for Brukarnamn må fyllast ut';
$err_passwd_empty = 'Felt for Tilgangskode må fyllast ut';


// html message

$alt_delete = 'Fjern avmerka meldingar';
$alt_delete_one = 'Fjern meldinga';
$alt_new_msg = 'Nye meldingar';
$alt_reply = 'Svar på melding';
$alt_reply_all = 'Svar til alle';
$alt_forward = 'Videresend';
$alt_next = 'Neste';
$alt_prev = 'Forrige';


// index.php

$html_lang = 'Målføre';
$html_welcome = 'Velkommen til';
$html_login = 'Brukarnamn';
$html_passwd = 'Kjenneord';
$html_submit = 'Log på';
$html_help = 'Hjelp';
$html_server = 'Server';
$html_wrong = 'Feil brukernamn eller kjenneord';
$html_retry = 'Prøv på ny';
$html_on = 'til';
$html_theme = 'Bunad';

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

$html_view_header = 'Vis meldinghovud';
$html_remove_header = 'Skjul meldinghovud';
$html_inbox = 'Inbox';
$html_new_msg = 'Lag ny melding';
$html_reply = 'Svar';
$html_reply_short = 'Re';
$html_reply_all = 'Svar til alle';
$html_forward = 'Videresend';
$html_forward_short = 'Fw';
$html_delete = 'Ta bort';
$html_new = 'Ny';
$html_mark = 'Ta bort';
$html_att = 'Vedlegg';
$html_atts = 'Vedlagte filar';
$html_att_unknown = '[ukjent vedlegg]';
$html_attach = 'Vedlegg';
$html_attach_forget = 'Det er naudsynt å vedlegga fila, før du sendar meldinga!';
$html_attach_delete = 'Fjern markerete vedlegg';
$html_sort_by = 'Sort by';
$html_from = 'Frå';
$html_subject = 'Emne';
$html_date = 'Dato';
$html_sent = 'Sendt';
$html_size = 'Størrelse';
$html_totalsize = 'Total størrelse';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'Filnamn';
$html_to = 'Mottakar';
$html_cc = 'Cc';
$html_bcc = 'Bcc';
$html_nosubject = 'Ikkje noko emne';
$html_send = 'Send';
$html_cancel = 'Blank ut';
$html_no_mail = 'Ingen meldingar';
$html_logout = 'Avslutt';
$html_msg = 'Melding';
$html_msgs = 'Meldingar';
$html_configuration = 'Serveren er ikkje korrekt satt opp!';
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

$original_msg = '-- Opphaveleg melding --';
$to_empty = 'Feltet \'Mottakar\' må væra fyllt ut!' ;

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>