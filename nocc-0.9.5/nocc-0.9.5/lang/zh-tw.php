<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/zh-tw.php,v 1.8 2001/11/18 21:08:06 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the chinese (Taiwan) big5 language
 * Translation by Cary Leung <cary@cary.net>
 */

$charset = 'Big5';

// Configuration for the days and months

// What language to use (Here, english US --> en_US)
// see '/usr/share/locale/' for more information
$lang_locale = 'zh_TW.BIG5';

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = '%Y-%m-%d';

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = '%Y-%m-%d';

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = '%I:%M %p';


// Here is the configuration for the HTML

$err_user_empty = '登入名字之位置空白';
$err_passwd_empty = '密碼之位置空白';


// html message

$alt_delete = '�蝪ㄓw選擇之信件';
$alt_delete_one = '�蝪ㄕ鼠H件';
$alt_new_msg = '新信件';
$alt_reply = '回覆信件';
$alt_reply_all = '回覆所有人';
$alt_forward = '轉寄';
$alt_next = '下一封';
$alt_prev = '上一封';
$html_on = '&#22312;';
$html_theme = '&#32972;&#26223;&#20027;&#38988;';

// index.php

$html_lang = '語言';
$html_welcome = '歡迎到';
$html_login = '登入';
$html_passwd = '密碼';
$html_submit = '提交';
$html_help = '幫助';
$html_server = '伺服器';
$html_wrong = '登入名字或密碼不正確';
$html_retry = '再嘗試';

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

$html_view_header = '顯示標題';
$html_remove_header = '不顯示標題';
$html_inbox = '信箱';
$html_new_msg = '寫信件';
$html_reply = '回覆';
$html_reply_short = '回覆';
$html_reply_all = '回覆所有人';
$html_forward = '轉寄';
$html_forward_short = '轉寄';
$html_delete = '�蝪�';
$html_new = '新';
$html_mark = '�蝪�';
$html_att = '附件';
$html_atts = '附件';
$html_att_unknown = '[不明]';
$html_attach = '附件';
$html_attach_forget = '你忘記加入附件 !';
$html_attach_delete = '�蝪ㄓw選擇的';
$html_sort_by = 'Sort by';
$html_from = '由';
$html_subject = '題目';
$html_date = '日期';
$html_sent = '傳送';
$html_wrote = 'wrote';
$html_size = '體積';
$html_totalsize = '總體積';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = '檔名';
$html_to = '收件人';
$html_cc = '複製至';
$html_bcc = 'Bcc';
$html_nosubject = '無題目';
$html_send = '傳送';
$html_cancel = '取消';
$html_no_mail = '無內容.';
$html_logout = '登出';
$html_msg = '信件';
$html_msgs = '信件';
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

$original_msg = '-- 原始內容 --';
$to_empty = '此 \'收件人\' 之位置不能沒有 !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>