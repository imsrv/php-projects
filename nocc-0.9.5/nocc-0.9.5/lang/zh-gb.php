<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/zh-gb.php,v 1.4 2001/11/18 21:08:06 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Chinese Simplified language
 * Translation by Liu Hong <loyaliu@21cn.com>
 */

$charset = 'gb2312';

// Configuration for the days and months

// What language to use
// see '/usr/share/locale/' for more information
$lang_locale = 'zh_CN.GB2312';

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

$err_user_empty = '用户名为空';
$err_passwd_empty = '密码为空';


// html message

$alt_delete = '删除选择的邮件';
$alt_delete_one = '删除邮件';
$alt_new_msg = '新建邮件';
$alt_reply = '回复作者';
$alt_reply_all = '回复所有';
$alt_forward = '转发';
$alt_next = '下一个邮件';
$alt_prev = '上一个邮件';
$html_on = '打开';
$html_theme = '主题';

// index.php

$html_lang = '语言';
$html_welcome = '欢迎';
$html_login = '登录';
$html_passwd = '密码';
$html_submit = '用户名';
$html_help = '帮助';
$html_server = '服务器';
$html_wrong = '用户名或则密码不正确';
$html_retry = '重试';

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

$html_view_header = '浏览邮件头';
$html_remove_header = '隐藏邮件头';
$html_inbox = '收件箱';
$html_new_msg = '写邮件';
$html_reply = '回复';
$html_reply_short = 'Re：';
$html_reply_all = '回复所有';
$html_forward = '转发';
$html_forward_short = 'Fw';
$html_delete = '删除';
$html_new = '新';
$html_mark = '置标';
$html_att = '附件';
$html_atts = '附件';
$html_att_unknown = '[unknown]';
$html_attach = '附件';
$html_attach_forget = '在发送邮件之前，你必须选一个文件!';
$html_attach_delete = '删除选择';
$html_sort_by = 'Sort by';
$html_from = '发件人';
$html_subject = '主题';
$html_date = '日期';
$html_sent = '发送';
$html_wrote = 'wrote';
$html_size = '大小';
$html_totalsize = '总大小';
$html_kb = 'Kb';
$html_bytes = '字节';
$html_filename = '文件名';
$html_to = 'To';
$html_cc = 'Cc';
$html_bcc = 'Bcc';
$html_nosubject = '没有主题';
$html_send = '发送';
$html_cancel = '取消';
$html_no_mail = '没有邮件.';
$html_logout = '退出';
$html_msg = '邮件';
$html_msgs = '邮件';
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

$original_msg = '-- Original Message --';
$to_empty = ' \'To\' 域不能为空 !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>