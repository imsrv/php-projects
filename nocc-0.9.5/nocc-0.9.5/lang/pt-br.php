<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/pt-br.php,v 1.4 2001/11/18 21:08:06 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the portuguese Brazilian language
 * Translation by Giovani Zamboni <zambaxtz@terra.com.br>
 */

$charset = 'ISO-8859-1';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'pt_BR';

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
$default_time_format = '%H:%M';


// Here is the configuration for the HTML

$err_user_empty = 'O campo <b>Usu&aacute;rio</b> esta vazio';
$err_passwd_empty = 'O campo <b>Senha</b> esta vazio';

// html message

$alt_delete = 'Excluir as mensagens selecionadas';
$alt_delete_one = 'Excluir a mensagem';
$alt_new_msg = 'Nova mensagens';
$alt_reply = 'Responder ao autor';
$alt_reply_all = 'Responder � todos';
$alt_forward = 'Encaminhar';
$alt_next = 'Pr�xima mensagem';
$alt_prev = 'Mensagem anterior';
$html_on = 'on';
$html_theme = 'Tema';


// index.php

$html_lang = 'Linguagem';
$html_welcome = 'Bem vindo ao ';
$html_login = 'Usu�rio';
$html_passwd = 'Senha';
$html_submit = 'Enviar';
$html_help = 'Ajuda';
$html_server = 'Servidor';
$html_wrong = 'O usu�rio ou a senha est�o incorretos';
$html_retry = 'Repetir';

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

$html_view_header = 'Ver cabe�alho';
$html_remove_header = 'Esconder cabe�alho';
$html_inbox = 'Caixa de Entrada';
$html_new_msg = 'Novo e-mail';
$html_reply = 'Responder';
$html_reply_short = 'Res';
$html_reply_all = 'Responder � todos';
$html_forward = 'Encaminhar';
$html_forward_short = 'Enc';
$html_delete = 'Excluir';
$html_new = 'Novo';
$html_mark = 'Excluir';
$html_att = 'Anexo';
$html_atts = 'Anexos';
$html_att_unknown = '[Desconhecido]';
$html_attach = 'Anexar arquivo';
$html_attach_forget = 'Voc� precisa anexar seus arquivos antes de enviar esta mensagem !';
$html_attach_delete = 'Remover anexos selecionados';
$html_sort_by = 'Sort by';
$html_from = 'De';
$html_subject = 'Assunto';
$html_date = 'Data';
$html_sent = 'Enviar';
$html_wrote = 'wrote';
$html_size = 'Tamanho';
$html_totalsize = 'Tamanho Total';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = 'Nome do Arquivo';
$html_to = 'Para';
$html_cc = 'Cc';
$html_bcc = 'Cco';
$html_nosubject = 'Sem assunto';
$html_send = 'Enviar';
$html_cancel = 'Cancelar';
$html_no_mail = 'Sem mensagens.';
$html_logout = 'Sair';
$html_msg = 'Mensagem';
$html_msgs = 'Mensagens';
$html_configuration = 'Este servidor ainda n�o esta bem configurado !';
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

$original_msg = '-- Mensagem Original --';
$to_empty = 'Campo \'Para\' n�o pode estar vazio !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>