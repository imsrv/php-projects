<?php
/***************************************************************************
 *                      Olate Download v2 - Download Manager
 *
 *                           http://www.olate.com
 *                            -------------------
 *   author                : David Mytton
 *   copyright             : (C) Olate 2003 
 *
 *   Support for Olate scripts is provided at the Olate website. Licensing
 *   information is available in the license.htm file included in this
 *   distribution and on the Olate website.                  
 *   
 *   
 *   
 *   Fully translated by GTT                  
 ***************************************************************************/

// Define admin texts - see config.php for author information
$language = array();
$language['button_activate']						= 'Активировать';
$language['button_add']								= 'Добавить';
$language['button_update']							= 'Обновить';
$language['credits_poweredby']						= 'Используется скрипт Olate Download ';
$language['credits_translatedby']						= 'Перевод от GTT';
$language['description_accessdenied']				= 'Доступ закрыт';
$language['description_allfields']					= 'Вы должны заполнить все необходимые поля. <a href="JavaScript:history.go(-1);">Вернуться</a>.';
$language['description_categories_add']				= 'Чтобы добавить новую категорию в базу данных, введите её имя и нажмите на кнопку Добавить';
$language['description_categories_added']			= 'Категория была добавлена в базу данных.';
$language['description_categories_delete']			= 'Чтобы удалить категорию, выберите нужную из списка:';
$language['description_categories_deleted']			= 'Категория была успешно удалена.';
$language['description_categories_edit']			= 'Чтобы отредактировать категорию, выберите нужную из списка:';
$language['description_categories_edit_view']		= 'Чтобы отредактировать категорию, измените её название и нажмите на кнопку Обновить:';
$language['description_categories_edited']			= 'Категория была обновлена.';
$language['description_categories_name']			= 'Название:';
$language['description_config_colours']				= 'Цвета и шрифты вы сможете настроить в файле /css/style.css.';
$language['description_config_general']				= 'Настройки. Измените по вашему желанию, а потом нажмите на кнопку Обновить.';
$language['description_config_general_noslash']		= '(не ставьте обратный слэш "/")';
$language['description_config_general_upd']			= 'База данных была обновлена.';
$language['description_config_language']			= 'На этой странице вы можете увидеть какие языки вы можете использовать. Так же вы увидете дату создания языка и автора.';
$language['description_config_language_activated']	= 'Новый язык был активирован.';
$language['description_config_language_created']	= 'Перевел скрипт ';
$language['description_config_language_current']	= 'Язык, который вы используете сейчас:';
$language['description_config_language_designed']	= '.<br>Перевод для скрипта Olate Download версии ';
$language['description_config_language_new']		= 'Новые языки вы сможете скачать на сайте - разработчике скрипта <a href="http://www.olate.com" target="_blank">Olate website</a>. Инструкции по установке нового языка вы найдете в инструкциях к скрипту. ';
$language['description_config_language_on']			= '<br>Дата создания: ';
$language['description_config_language_select']		= 'Выберите язык из списка доступных языков и нажмите на кнопку Активировать, чтобы принять изменения.';
$language['description_config_languagesel']			= '---Доступные языки---';
$language['description_downloads_add']				= 'Чтобы добавить новый файл в базу данных, заполните ниже форму и нажмите на кнопку Добавить. Если вы не хотите использовать поля по выбору, оставьте их пустыми.';
$language['description_downloads_added']			= 'Новый файл был добавлен в базу данных.';
$language['description_downloads_categorysel']		= '---Выберите категорию---';
$language['description_downloads_categorycur']		= 'Текущая: ';
$language['description_downloads_delete']			= 'Чтобы удалить файл, выберите нужный вам файл из списка:';
$language['description_downloads_deleted']			= 'Файл был удален из списка.';
$language['description_downloads_edit']				= 'Чтобы отредактировать файл, выберите нужный вам файл из списка:';
$language['description_downloads_edit_view']		= 'Файл, который вы выбрали показан ниже. Внесите необходимые вам изменения и нажмите на кнопку Обновить.';
$language['description_downloads_edited']			= 'Файл был обновлен.';
$language['description_downloads_mb']				= 'мб:';
$language['description_downloads_noimg']			= 'Оставьте поле пустым, если не используете картинку ';
$language['description_loggedinas']					= 'Вы зашли как ';
$language['description_main']						= 'На этой странице вы сможете добавлять файлы и категории, изменять основные настройки и многое другое.<br><a href="'.$config['urlpath'].'/index.php" target="_blank">Нажав здесь, вы попадете на главную страницу вашего файлового архива.</a>';
$language['description_users_add']					= '<p>Чтобы добавить нового пользователя в базу данных, введите Логин и Пароль для пользователя. Все пароли шифруются алгоритмом <b>MD5</b>. Если вы поставите галочку рядом с надписью <b>Неудаляемый</b>, никто и даже Вы не сможете удалить этого пользователя из панели администратора.</p>';
$language['description_users_added']				= 'Пользователь был успешно добавлен.';
$language['description_users_delete']				= 'Чтобы удалить пользователя, выберите любого из списка. Пользователь с пометкой <b>Неудаляемый</b> не будет удален.';
$language['description_users_deleted']				= 'Пользователь был удален из базы данных.';
$language['description_other_changelog']			= 'Вы можете увидеть список изменений с версии скрипта 2.0.0 в списке изменений по <a href="http://www.olate.com/scripts/Olate Download/changelog.php" target="_blank">этому</a> адресу.';
$language['description_other_license']				= 'Отсюда вы сможете загрузить последнюю версия скрипта. Если обновление будет доступно вы увидите.';
$language['description_other_mailinglist']			= 'Вы можете получать информацию о новых версиях скрипта по e-mail, подписавшись на <a href="http://www.olate.com/list/index.php" target="_blank">рассылку</a>.';
$language['description_users_master']				= 'Пользователь, которого вы пытаетесь удалить, помечен как <b>Неудаляемый</b>.';
$language['description_other_support']				= '<p>Этот скрипт распространяется бесплатно. Тех. поддержка доступна только на <a href="http://www.olate.com/forums" target="_blank">форумах </a>. Никакой e-mail поддержки. Поддержка осуществляется только на оригинальную версию скрипта, то есть не модифицированную и скачанную прямо с сайта автора.</p>';
$language['description_other_updates']				= '<p>Сейчас будет проведена проверка на обновления скрипта.</p><p><strong>Ответ сервера:</strong></p>';
$language['link_addcategory']						= 'Добавить новую категорию';
$language['link_adddownload']						= 'Добавить новый файл';
$language['link_adduser']							= 'Добавить нового пользователя';
$language['link_administration']					= 'Администрирование';
$language['link_adminmain']							= 'Вернуться к администрированию';
$language['link_clicktologin']						= 'Вход в систему';
$language['link_deletecategory']					= 'Удаление категорий';
$language['link_deletedownload']					= 'Удаление файлов';
$language['link_deleteuser']						= 'Удаление пользователей';
$language['link_editcategory']						= 'Редактирование категорий';
$language['link_editdownload']						= 'Редактирование файлов';
$language['link_generalsettings']					= 'Основные настройки';
$language['link_languages']							= 'Языки';
$language['link_languages_viewgenconfig']			= 'Посмотреть основные настройки';
$language['link_languages_viewlangconfig']			= 'Посмотреть доступные языки';
$language['link_license']							= 'Лицензия';
$language['link_logout']							= 'Выйти';
$language['link_support']							= 'Тех. поддержка';
$language['link_updates']							= 'Обновления';
$language['link_viewmain']							= 'Зайти на главную страницу';
$language['title_admin']							= 'Администрирование';
$language['title_admin_main']						= 'Администрирование - Главная страница';
$language['title_categories']						= 'Категории:';
$language['title_categories_add']					= ' - Категории - Добавление новой категории';
$language['title_categories_delete']				= ' - Категории - Удаление категории';
$language['title_categories_edit']					= ' - Категории - Редактирование категории';
$language['title_categories_name']					= 'Название:';
$language['title_config_general']					= ' - Конфигурация - Основные настройки';
$language['title_config_language']					= ' - Конфигурация - Языки';
$language['title_config_language_available']		= 'Доступные языки для скрипта';
$language['title_config_general_alldownloads']		= 'Показывать "Все файлы":';
$language['title_config_general_displaytd']			= 'Показывать "Топ скачиваний":';
$language['title_config_general_numbertd']			= 'Количество в топе:';
$language['title_config_general_numberpage']		= 'Количество файлов на странице:';
$language['title_config_general_path']				= 'Путь к скрипту:';
$language['title_config_general_ratings']			= 'Включить рейтинг:';
$language['title_config_general_searchlink']		= 'Показывать "Поиск":';
$language['title_config_general_sorting']			= 'Включить сортировку:';
$language['title_config_general_version']			= 'Версия:';
$language['title_configuration']					= 'Конфигурация';
$language['title_downloads']						= 'Файлы:';
$language['title_downloads_add']					= ' - Файлы - Добавление нового файла';
$language['title_downloads_category']				= 'Категория:';
$language['title_downloads_custom1']				= 'Поле по выбору 1:';
$language['title_downloads_custom2']				= 'Поле по выбору 2:';
$language['title_downloads_custom_label']			= 'Метка:';
$language['title_downloads_custom_value']			= 'Значение:';
$language['title_downloads_date']					= 'Дата:';
$language['title_downloads_delete']					= ' - Файлы - Удаление файла';
$language['title_downloads_description_b']			= 'Краткое описание:';
$language['title_downloads_description_f']			= 'Полное описание:';
$language['title_downloads_edit']					= ' - Файлы - Редактирование файла';
$language['title_downloads_image']					= 'Адрес картинки:';
$language['title_downloads_location']				= 'Адрес файла:';
$language['title_downloads_name']					= 'Название:';
$language['title_downloads_size']					= 'Размер файла:';
$language['title_master']							= 'Неудаляемый:';
$language['title_other']							= 'Разное:';
$language['title_users_add']						= ' - Пользователи - Добавление нового пользователя';
$language['title_users_delete']						= ' - Пользватели - Удаление пользователя';
$language['title_other_changelog']					= 'Список изменений:';
$language['title_other_license']					= ' - Разное - Лицензия';
$language['title_other_mailinglist']				= 'Рассылка:';
$language['title_other_support']					= ' - Разное - Тех. поддержка';
$language['title_other_updates']					= ' - Разное - Обновления';
$language['title_password']							= 'Пароль:';
$language['title_script']							= 'Скрипт настройки';
$language['title_users']							= 'Пользователи:';
$language['title_username']							= 'Логин:';
?>