<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/hu.php,v 1.6 2001/11/18 21:08:06 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Hungarian language
 * Translation by Hajdu Zolt�n <wirhock@wirhock.com>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use
// see '/usr/share/locale/' for more information
$lang_locale = 'hu_HU';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%Y-%m-%d'; 

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%Y.%m.%d';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = '%H:%M';


// Here is the configuration for the HTML

$err_user_empty = 'Az azonos&iacute;t&oacute;t meg kell adni';
$err_passwd_empty = 'A jelsz&oacute;t meg kell adni';


// html message

$alt_delete = 'Kijel&ouml;lt &uuml;zenetek t&ouml;rl&eacute;se';
$alt_delete_one = '&Uuml;zenet t&ouml;rl&eacute;se';
$alt_new_msg = '&Uacute;j &uuml;zenetek';
$alt_reply = 'V&aacute;laszol';
$alt_reply_all = 'Mindre v&aacute;laszol';
$alt_forward = 'Tov&aacute;bbk&uuml;ld';
$alt_next = 'K&ouml;vetkez&otilde; &uuml;zenet';
$alt_prev = 'El&otilde;z&otilde; &uuml;zenet';
$html_on = 'on';
$html_theme = 'T&eacute;ma';

// index.php

$html_lang = 'Nyelv';
$html_welcome = '&Uuml;dv&ouml;zli a';
$html_login = 'Azonos&iacute;t&oacute;';
$html_passwd = 'Jelsz&oacute;';
$html_submit = 'Bejelentkez&eacute;s';
$html_help = 'Seg&iacute;ts&eacute;g';
$html_server = 'Szerver';
$html_wrong = 'Az azonos&iacute;t&oacute; vagy jelsz&oacute; nem megfelel&otilde;';
$html_retry = '&Uacute;jra';

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

$html_view_header = 'Fejl&eacute;cet mutat';
$html_remove_header = 'Fejl&eacute;cet takar';
$html_inbox = '&Eacute;rkezett';
$html_new_msg = '&iacute;r';
$html_reply = 'V&aacute;laszol';
$html_reply_short = 'Re';
$html_reply_all = 'Mindre v&aacute;laszol';
$html_forward = 'Tov&aacute;bbk&uuml;ld';
$html_forward_short = 'Fw';
$html_delete = 'T&ouml;r&ouml;l';
$html_new = '&Uacute;j';
$html_mark = 'T&ouml;r&ouml;l';
$html_att = 'Csatolt f&aacute;jl';
$html_atts = 'Csatolt f&aacute;jlok';
$html_att_unknown = '[ismeretlen]';
$html_attach = 'Csatol';
$html_attach_forget = 'Csatolni kell a f&aacute;jlt &uuml;zenetk&uuml;ld&eacute;s el&otilde;tt !';
$html_attach_delete = 'Csatolt f&aacute;jl elv&eacute;tele';
$html_sort_by = 'Sort by';
$html_from = 'Felad&oacute;';
$html_subject = 'C&iacute;m';
$html_date = 'D&aacute;tum';
$html_sent = 'Elk&uuml;ldve';
$html_wrote = 'wrote';
$html_size = 'M&eacute;ret';
$html_totalsize = 'Teljes m&eacute;ret';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'F&aacute;jln&eacute;v';
$html_to = 'C&iacute;mzett';
$html_cc = 'M&aacute;solat';
$html_bcc = 'Vakm&aacute;solat';
$html_nosubject = 'Nincs c&iacute;m';
$html_send = 'Mehet';
$html_cancel = 'M&eacute;gsem';
$html_no_mail = 'Nincs &uuml;zenet.';
$html_logout = 'Kil&eacute;p';
$html_msg = '&Uuml;zenet';
$html_msgs = '&Uuml;zenetek';
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

$original_msg = '-- Eredeti &uuml;zenet --';
$to_empty = 'A \'C&iacute;mzett\' mez&otilde;t ki kell t&ouml;lteni !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>