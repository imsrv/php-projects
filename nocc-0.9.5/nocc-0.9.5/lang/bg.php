<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/lang/bg.php,v 1.5 2001/11/18 21:08:06 wolruf Exp $ 
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * Configuration file for the Bulgarian language
 * Translation by Evgeni Gechev <etg@setcom.bg>
 */

$charset = "windows-1251";

// Configuration for the days and months

// What language to use
// see '/usr/share/locale/' for more information
$lang_locale = "bg_BG";

// Text Alignment
// Can be right-to-left (rtl) which is needed for proper Arabic, Hebrew
// Or left-to-right (ltr) which is default for most languages
$lang_dir = 'ltr';

// What format string should we pass to strftime() for messages sent on
// days other than today?
$default_date_format = "%d-%m-%Y"; 

// If the local is not implemented on the host, how we display the date
$no_locale_date_format = "%d-%m-%Y"; 

// What format string should we pass to strftime() for messages sent
// today?
$default_time_format = "%H:%M";


// Here is the configuration for the HTML

$err_user_empty = "Не е въведено име";
$err_passwd_empty = "Не е въведена парола";


// html message

$alt_delete = "Изтрий маркираните писма";
$alt_delete_one = "Изтрий писмото";
$alt_new_msg = "Нови писма";
$alt_reply = "Отговори на автора";
$alt_reply_all = "Отговори на всички";
$alt_forward = "Препрати";
$alt_next = "Следващо писмо";
$alt_prev = "Предишно писмо";
$html_on = 'on';
$html_theme = 'Дизайн';

// index.php

$html_lang = "Език";
$html_welcome = "Добре дошли!<br/>";
$html_login = "Име";
$html_passwd = "Парола";
$html_submit = "Потвърждение";
$html_help = "Помощ";
$html_server = "Сървър";
$html_wrong = "Името или паролата са грешни";
$html_retry = "Опитай отново";

// prefs.php

$html_preferences = 'Настройки';
$html_full_name = 'Име, Презиме, Фамилия';
$html_email_address = 'E-mail адрес';
$html_ccself = 'Копие към мен';
$html_hide_addresses = 'Скрий адресите';
$html_outlook_quoting = 'Outlook формат';
$html_reply_to = 'Отговори на';
$html_use_signature = 'Ползвай сигнатура';
$html_signature = 'Сигнатура';
$html_prefs_updated = 'Настройките са обновени';

// Other pages

$html_view_header = "Покажи служ. информация";
$html_remove_header = "Скрий служ. информация";
$html_inbox = "Получени писма";
$html_new_msg = "Изпрати писмо";
$html_reply = "Отговори";
$html_reply_short = "Отг.";
$html_reply_all = "Отговори на всички";
$html_forward = "Препрати";
$html_forward_short = "Препр.";
$html_delete = "Изтрий";
$html_new = 'Ново';
$html_mark = 'Маркирай';
$html_att = 'Прикачен файл';
$html_atts = 'Прикачени файлове';
$html_att_unknown = '[unknown]';
$html_attach = 'Прикачи';
$html_attach_forget = 'Прикачи файла преди да изпратиш съобщението!';
$html_attach_delete = 'Изтрий прикачения файл';
$html_sort_by = 'Сортирай по';
$html_from = 'От';
$html_subject = 'Тема';
$html_date = 'Дата';
$html_sent = 'Изпратено';
$html_wrote = 'написа';
$html_size = 'Големина';
$html_totalsize = 'Общо';
$html_kb = 'КБ';
$html_bytes = 'байта';
$html_filename = 'име на файл';
$html_to = 'За';
$html_cc = 'Копие';
$html_bcc = 'Невидимо копие';
$html_nosubject = 'Без тема';
$html_send = 'Изпрати';
$html_cancel = 'Отказ';
$html_no_mail = 'Няма писма';
$html_logout = 'Изход';
$html_msg = 'Писмо';
$html_msgs = 'Писма';
$html_configuration = 'Сървърът не е конфигуриран!';
$html_priority = 'Приоритет';
$html_low = 'Нисък';
$html_normal = 'Нормален';
$html_high = 'Висок';
$html_select = 'Маркирай';
$html_select_all = 'Маркирай всички';
$html_loading_image = 'Зареждане на картинка';
$html_send_confirmed = 'Писмото е прието';
$html_no_sendaction = 'Не е посочено действие. Опитай да разрешиш Javascript в браузера.';
$html_error_occurred = 'An error occurred';
$html_prefs_file_error = 'Unable to open preferences file for writing.';
$html_sig_file_error = 'Unable to open signature file for writing.';

$original_msg = '-- Оригинално писмо --';
$to_empty = 'Полето \'За\' не трябва да е празно !';

// SMTP problems (class_smtp.php)
$html_smtp_error_no_conn = "Грешка! Не може да бъда осъществена връзка със сървъра ";
$html_smtp_error_unexpected = "Грешка! Непознат отговор от сървъра:";
?>