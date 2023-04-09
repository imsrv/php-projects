<?php
/*	eCorrei 1.2.5 - Language file
	A webbased E-mail solution
	Page: http://ecorrei.sourceforge.net/

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
	or see http://www.fsf.org/copyleft/gpl.html

	Date: 16 January 2001
	Author: Dmitry Korotkov <dima@festart.com>
	Language: Russian
	Language code: ru
*/

	// General codes
	$lang->to = "Кому";
	$lang->cc = "Копия";
	$lang->bcc = "Скрытая копия";
	$lang->from = "От";
	$lang->subject = "Тема";
	$lang->date = "Дата";
	$lang->filename = "Имя файла";
	$lang->size = "Размер";
	$lang->total = "Всего";
	$lang->attachment = "Вложение";
	$lang->attachments = "Вложения";
	$lang->high_priority = "Высокий приоритет";
	$lang->none = "(нету)";
	$lang->unknown = "(неизвестно)";
	$lang->btn_add = "Добавить";
	$lang->btn_change = "Изменить";
	$lang->btn_reset = "Сбросить";

	// General error codes
	$lang->error = "Ошибка";
	$lang->err_allfields = "Пожалуйста заполните все поля.";
	$lang->err_no_msg_specified = "Сообщение не указано.";
	$lang->err_select_msg = "Пожалуйста выберите сообщение.";
	$lang->err_create_group_first = "Сначала создайте группу.";
	$lang->err_email_exists = "Адрес E-mail уже в списке.";
	$lang->err_group_exists = "Группа уже существует.";
	$lang->err_select_group_contact = "Пожалуйста выберите группу или контакт.";
	$lang->err_group_not_found = "Группа не найдена.";
	$lang->err_select_contact = "Пожалуйста выберите контакт вместо группы.";
	$lang->err_invalid_email_group = "Неправильная группа или e-mail.";
	$lang->err_invalid_name = "Название содержит недопустимые символы.";
	$lang->err_invalid_group = "Название группы содержит недопустимые символы.";
	$lang->err_invalid_email = "Неправильный формат адреса e-mail.";
	$lang->err_mail_failed = "Отправка e-mail не удалась.";
	$lang->err_datafile_not_found = "Файл данных не найден.";
	$lang->err_attach_first = "Пожалуйста сначала вложите файл.";
	$lang->err_mail_size_exceeded = "Максимальный размер Вашего вложения превышен.";
	$lang->err_already_included = "Файл уже добавлен.";
	$lang->err_file_too_big = "Ваш файл очень велик.";

	// Codes for login page
	$lang->login = "Вход";
	$lang->login_please_login = "Пожалуйста идентифицируйте себя.";
	$lang->login_username = "Имя пользователя";
	$lang->login_password = "Пароль";
	$lang->login_domain = "Домен";
	$lang->login_language = "Язык";
	$lang->login_msg_been_logged_out = "Вы вышли из системы.";
	$lang->login_msg_invalid_login = "Ваш бюджет пользователя больше не действителен.";
	$lang->login_msg_wrongpass = "Ваш пароль или имя пользователя не верны или почтовый сервер не доступен.";

	// Codes for Inbox
	$lang->inbox = "Inbox";
	$lang->inbox_infostring1 = "У Вас";
	$lang->inbox_infostring2 = "сообщений";
	$lang->inbox_infostring3 = "сообщение";
	$lang->inbox_infostring4 = "новых";
	$lang->inbox_infostring5 = "всего";
	$lang->inbox_sort_low_to_high = "Упорядочить снизу вверх";
	$lang->inbox_sort_high_to_low = "Упорядочить сверху вниз";
	$lang->inbox_no_messages = "Нету новых сообщений в Inbox";
	$lang->inbox_invert_selection = "Инвертировать выделенное";
	$lang->inbox_confirm_delete = "Желаете ли Вы удалить выделенные сообщения?";

	// Codes for Create message
	$lang->create = "Создать сообщение";
	$lang->create_attach = "Вложить";
	$lang->create_original_msg = "Оригинальное сообщение";
	$lang->create_add_sig = "Добавить подпись";

	// Codes for Message script
	$lang->message = "Сообщение";
	$lang->message_add_to_contacts = "Добавить в Контакты";
	$lang->message_import_in_contacts = "Импортировать в контакты";
	$lang->message_view_header = "Показать заголовок";
	$lang->message_hide_header = "Скрыть заголовок";
	$lang->message_confirm_delete = "Желаете ли Вы удалить это сообщение?";

	// Codes for Options
	$lang->options = "Установки";
	$lang->options_name = "Имя";
	$lang->options_timezone = "Часовой пояс";
	$lang->options_email = "Адрес E-mail";
	$lang->options_signature = "Подпись";
	
	// Codes for Contacts
	$lang->contacts = "Контакты";
	$lang->contacts_infostring1 = "У Вас";
	$lang->contacts_infostring2 = "группа";
	$lang->contacts_infostring3 = "группы";
	$lang->contacts_infostring4 = "и";
	$lang->contacts_infostring5 = "адрес";
	$lang->contacts_infostring6 = "адреса";
	$lang->contacts_infostring7 = "в Контактах";
	$lang->contacts_send_mail = "Отправить почту";
	$lang->contacts_no_contacts = "В группе нет контактов.";
	$lang->contacts_no_groups = "Группы не определены.";
	$lang->contacts_name = "Имя";
	$lang->contacts_email = "Адрес E-Mail";
	$lang->contacts_group = "Группа";
	$lang->contacts_new_group = "Новая группа";
	$lang->contacts_add = "Добавить";
	$lang->contacts_add_to = "Добавить в";
	$lang->contacts_confirm_delete = "Желаете ли Вы удалить выделенные группы/контакты?";

	// Code for Refresh button
	$lang->refresh = "Обновить";

	// Code for Reply button
	$lang->reply = "Ответить";
	
	// Code for Forward button
	$lang->forward = "Переслать";

	// Code for Delete button
	$lang->delete = "Удалить";

	// Code for Send button
	$lang->send = "Отправить";

	// Code for Help button
	$lang->help = "Помощь";

	// Code for Logout button
	$lang->logout = "Выход";

	// Array for months
	$lang->months = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");

	// Array for days
	$lang->days = array("Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "d-m-Y";

	// Character set of language
	$lang->charset = "koi8-r";
?>
