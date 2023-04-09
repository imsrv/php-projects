<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/sl.php,v 1.8 2001/11/18 18:43:12 wolruf Exp $ 
 *
 * Copyright 2000 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2000 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the slovenian language
 * Tanslation by Borut Mrak <borut.mrak@ijs.si>
 */

$charset = 'ISO-8859-2';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'sl_SI';

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

$err_user_empty = 'Uporabni¹ko ime ni bilo vne¹eno';
$err_passwd_empty = 'Geslo ni bilo vne¹eno';


// html message

$alt_delete = 'Izbri¹i izbrana sporoèila';
$alt_delete_one = 'Izbri¹i sporoèilo';
$alt_new_msg = 'Nova sporoèila';
$alt_reply = 'Odgovori';
$alt_reply_all = 'Odgovri vsem';
$alt_forward = 'Naprej';
$alt_next = 'Naslednji';
$alt_prev = 'Prej¹nji';


// index.php

$html_lang = 'Jezik';
$html_welcome = 'Dobrodo¹li v';
$html_login = 'Uporabni¹ko ime';
$html_passwd = 'Geslo';
$html_submit = 'Prijava';
$html_help = 'Pomoè';
$html_server = 'Stre¾nik';
$html_wrong = 'Uporabni¹ko ime ali geslo napaèno';
$html_retry = 'Ponovi';
$html_on = 'on';
$html_theme = 'Theme';

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

$html_view_header = 'Poka¾i glavo';
$html_remove_header = 'Skrij glavo';
$html_inbox = 'Prejeto';
$html_new_msg = 'Pi¹i';
$html_reply = 'Odgovori';
$html_reply_short = 'Re';
$html_reply_all = 'Odgovori vsem';
$html_forward = 'Posreduj';
$html_forward_short = 'Fw';
$html_delete = 'Bri¹i';
$html_new = 'Novo';
$html_mark = 'Izbri¹i';
$html_att = 'Priponka';
$html_atts = 'Priponke';
$html_att_unknown = '[neznan]';
$html_attach = 'Pripni';
$html_attach_forget = 'Datoteko morate pripeti pred poi¹iljanjem sporoèila!';
$html_attach_delete = 'Odstrani izbrane';
$html_sort_by = 'Sort by';
$html_from = 'Od';
$html_subject = 'Zadeva';
$html_date = 'Datum';
$html_sent = 'Poslano';
$html_size = 'Velikost';
$html_totalsize = 'Skupna velikost';
$html_kb = 'Kb';
$html_bytes = 'bajtov';
$html_filename = 'Ime datoteke';
$html_to = 'Za';
$html_cc = 'Kp';
$html_bcc = 'Skp';
$html_nosubject = 'Brez zadeve';
$html_send = 'Po¹lji';
$html_cancel = 'Preklièi';
$html_no_mail = 'Ni sporoèil.';
$html_logout = 'Odjava';
$html_msg = 'Sporoèil';
$html_msgs = 'Sporoèil';
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

$original_msg = '-- Izvorno sporoèilo --';
$to_empty = 'Polje \'Za:\' ne sme biti prazno!';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>