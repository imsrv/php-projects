<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/kr.php,v 1.4 2001/11/18 18:17:34 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Korean language
 * Translation by Roh,Kyoung-Min <rohbin@dreamwiz.com>
 */

$charset = 'euc-kr';

// Configuration for the days and months


// see '/usr/share/locale/' for more information
$lang_locale = 'ko';

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

$err_user_empty = '아이디를 입력해주십시요';
$err_passwd_empty = '비밀번호를 입력해주십시요';


// html message

$alt_delete = '지울글선택';
$alt_delete_one = '편지지우기';
$alt_new_msg = '편지쓰기';
$alt_reply = '답장';
$alt_reply_all = '전체답장';
$alt_forward = '전달';
$alt_next = '다음 글';
$alt_prev = '이전 글';
$html_on = '선택';
$html_theme = '테마';

// index.php

$html_lang = '언어';
$html_welcome = '어서오세요! ';
$html_login = '접속아이디';
$html_passwd = '비밀번호';
$html_submit = '로그인';
$html_help = '도움말';
$html_server = '서버';
$html_wrong = '아이디가 없거나 비밀번호가 일치하지 않습니다';
$html_retry = '다시입력';

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

$html_view_header = 'View header';
$html_remove_header = 'Hide header';
$html_inbox = '받은편지함';
$html_new_msg = '새글';
$html_reply = '답장';
$html_reply_short = 'Re';
$html_reply_all = '전체답장';
$html_forward = '전달';
$html_forward_short = 'Fw';
$html_delete = '삭제';
$html_new = '안읽은편지';
$html_mark = '삭제';
$html_att = '첨부';
$html_atts = '첨부';
$html_att_unknown = '[unknown]';
$html_attach = '첨부하기';
$html_attach_forget = '파일을 첨부하셔야 편지를 보낼수 있습니다.';
$html_attach_delete = '삭제';
$html_sort_by = 'Sort by';
$html_from = '보낸이';
$html_subject = '제목';
$html_date = '날짜';
$html_sent = 'Send';
$html_size = '크기';
$html_totalsize = 'Total Size';
$html_kb = 'Kb';
$html_bytes = 'bytes';
$html_filename = '파일명';
$html_to = '받는사람';
$html_cc = '참조';
$html_bcc = '비밀참조';
$html_nosubject = '제목없음';
$html_send = '보내기';
$html_cancel = '취소';
$html_no_mail = '편지합이 비어있습니다';
$html_logout = '로그아웃';
$html_msg = ' 통의 편지가 있습니다';
$html_msgs = ' 통의 편지가 있습니다';
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

$original_msg = '-- 원본 내용 --';
$to_empty = '이메일(email) 주소를 입력하셔야 합니다.';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Unable to open connection";
$html_smtp_error_unexpected = "Unexpected response:";
?>
