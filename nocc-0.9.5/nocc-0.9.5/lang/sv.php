<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/sv.php,v 1.4 2001/11/18 18:43:12 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Swedish language
 * Translation by Robert Niska <r.niska@redbox.d2g.nu>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use
// see '/usr/share/locale/' for more information
$lang_locale = 'sv_SE';

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
$default_time_format = '%I:%M %p';


// Here is the configuration for the HTML

$err_user_empty = 'Login fältet är tomt';
$err_passwd_empty = 'Lösenords fältet är tomt';


// html message

$alt_delete = 'Ta bort valt meddelande';
$alt_delete_one = 'Ta bort meddelandet';
$alt_new_msg = 'Nya Meddelanden';
$alt_reply = 'Svara';
$alt_reply_all = 'Svara alla';
$alt_forward = 'Vidarebefodra';
$alt_next = 'Nästa';
$alt_prev = 'Föregående';


// index.php

$html_lang = 'Språk';
$html_welcome = 'Välkommen till';
$html_login = 'Användarnamn';
$html_passwd = 'Lösenord';
$html_submit = 'Logga in';
$html_help = 'Hjälp';
$html_server = 'Server';
$html_wrong = 'Användarnamnet eller lösenordet är fel';
$html_retry = 'Försök igen';
$html_on = 'På';
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

$html_view_header = 'Visa huvud';
$html_remove_header = 'Dölj huvud';
$html_inbox = 'Inkorg';
$html_new_msg = 'Skriv';
$html_reply = 'Svara';
$html_reply_short = 'Re';
$html_reply_all = 'Svara Alla';
$html_forward = 'Vidarebefodra';
$html_forward_short = 'Fw';
$html_delete = 'Ta bort';
$html_new = 'Nytt';
$html_mark = 'Ta bort';
$html_att = 'Bifogat';
$html_atts = 'Bifogade';
$html_att_unknown = '[okänd]';
$html_attach = 'Bifoga';
$html_attach_forget = 'Du måste bifoga din fil innan du skickar meddelandet !';
$html_attach_delete = 'Ta bort vald';
$html_sort_by = 'Sort by';
$html_from = 'Från';
$html_subject = 'Ämne';
$html_date = 'Datum';
$html_sent = 'Skicka';
$html_size = 'Storlek';
$html_totalsize = 'Total Storlek';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'Filnamn';
$html_to = 'Till';
$html_cc = 'Cc';
$html_bcc = 'Bcc';
$html_nosubject = 'Inget ämne';
$html_send = 'Skicka';
$html_cancel = 'Avbryt';
$html_no_mail = 'Inget meddelande.';
$html_logout = 'Logga ut';
$html_msg = 'Meddelande';
$html_msgs = 'Meddelanden';
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

$original_msg = '-- Original Meddelande --';
$to_empty = 'Mottagar fältet kan inte vara tomt !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>