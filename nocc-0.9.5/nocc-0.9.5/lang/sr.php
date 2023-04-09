<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/sr.php,v 1.3 2001/11/18 19:02:19 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Srpski jezik
 * Translation by Igor Smitran http://www.poen.net/
 */

$charset = 'ISO-8859-2';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'sr';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%d-%m-%Y %H:%M'; 

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%d-%m-%Y %H:%M';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = 'Danas u %H:%M';


// Here is the configuration for the HTML

$err_user_empty = 'Polje korisnickog imena je prazno';
$err_passwd_empty = 'Polje sifre je prazno';


// html message

$alt_delete = 'Obrisi odabrane poruke';
$alt_delete_one = 'Obrisi poruku';
$alt_new_msg = 'Nova poruka';
$alt_reply = 'Odgovori posiljaocu';
$alt_reply_all = 'Odgovori svima';
$alt_forward = 'Proslijedi';
$alt_next = 'Sledeca poruka';
$alt_prev = 'Prethodna poruka';
$html_on = 'ukljucen';
$html_theme = 'Tema';

// index.php

$html_lang = 'Jezik';
$html_welcome = 'Dobrodo&#353;li';
$html_login = 'Korisni&#269;ko ime';
$html_passwd = '&#352;ifra';
$html_submit = 'Prijava';
$html_help = 'Pomo&#263;';
$html_server = 'Server';
$html_wrong = 'Korisni&#269;ko ime ili &#353;ifra su neispravni';
$html_retry = 'Poku&#353;aj ponovo';

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

$html_view_header = 'Vidi zaglavlje';
$html_remove_header = 'Sakrij zaglavlje';
$html_inbox = 'Pristigla po&#353;ta';
$html_new_msg = 'Nova poruka';
$html_reply = 'Odgovori';
$html_reply_short = 'Re';
$html_reply_all = 'Odgovori svima';
$html_forward = 'Proslijedi';
$html_forward_short = 'Fw';
$html_delete = 'Obri&#353;i';
$html_new = 'Nova';
$html_mark = 'Obri&#353;i';
$html_att = 'Prilo&#382;ena datoteka';
$html_atts = 'Prilo&#382;ene datoteke';
$html_att_unknown = '[nepoznat]';
$html_attach = 'Prilo&#382;i';
$html_attach_forget = 'Morate prilo&#382;iti datoteku prije slanja poruke !';
$html_attach_delete = 'Ukloni odabrane datoteke';
$html_sort_by = 'Sort by';
$html_from = 'Od';
$html_subject = 'Naslov';
$html_date = 'Datum';
$html_sent = 'Poslano';
$html_size = 'Veli&#269;ina';
$html_totalsize = 'Ukupna veli&#269;ina';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'Ime datoteke';
$html_to = 'Za';
$html_cc = 'Kopija';
$html_bcc = 'Nevidljiva kopija';
$html_nosubject = 'Bez naslova';
$html_send = 'Po&#353;alji';
$html_cancel = 'Odustani';
$html_no_mail = 'Nema novih poruka.';
$html_logout = 'Izlaz';
$html_msg = 'poruka';
$html_msgs = 'poruka';
$html_configuration = 'Ovaj server nije dobro podesen !';
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

$original_msg = '-- Originalna poruka --';
$to_empty = 'Polje \'Za\' ne moze biti prazno!';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>
