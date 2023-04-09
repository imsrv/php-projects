<?php
//***************************************************************************//
//                                                                           //
//  Program Name    	: vCard PRO                                          //
//  Program Version     : 2.8                                                //
//  Program Author      : Joao Kikuchi,  Belchior Foundry                    //
//  Home Page           : http://www.belchiorfoundry.com                     //
//  Retail Price        : $80.00 United States Dollars                       //
//  WebForum Price      : $00.00 Always 100% Free                            //
//  Supplied by         : South [WTN]                                        //
//  Nullified By        : CyKuH [WTN]                                        //
//  Distribution        : via WebForum, ForumRU and associated file dumps    //
//                                                                           //
//                (C) Copyright 2001-2002 Belchior Foundry                   //
//***************************************************************************//
$CharSet ='windows-1251'; // Language WIN Char Set code for users pages
$htmldir ='ltr'; // ltr = Слева - направо , rtl = Справа - налево (это для арабов)
				/* text direction attribute is used to declare the direction 
		    that the text should run, either left to right (default) or right to left */

// Создание, предпросмотр и вид страниц
$MsgImage ='Изображение';
$MsgYourTitle ='Заголовок открытки';
$MsgMessage ='Сообщение';
$MsgMessageHere ='- Ваше сообщение появится здесь -'; // Sample message that will apper if postcard use a template
$MsgFont ='Шрифт';
$MsgNoFontFace ='Не указывать';
$MsgFontSizeSmall ='Маленький';
$MsgFontSizeMedium ='Средний';
$MsgFontSizeLarge ='Большой';
$MsgFontSizeXLarge ='Очень большой';
$MsgFontColorBlack ='Черный';
$MsgFontColorWhite ='Белый';
$MsgSignature ='Подпись';
$MsgRecpName ='Имя получателя';
$MsgRecpEmail ='Е-mail получателя';
$MsgAddRecp ='Добавить получателей';
$MsgTotalRecp ='Всего получателей';
$MsgPlay ='ПРОСЛУШАТЬ';
$MsgYourName ='Ваше имя';
$MsgYourEmail ='Ваш email';
$MsgChoosePoem ='Выбор стихотворения';
$MsgView ='Просмотр';
$MsgChooseLayout ='Выбор шаблона открытки';
$MsgChooseDate ='Указать дату доставки?';
$MsgChooseDateImmediate ='Немедленно';
$MsgDateFormat ='Укажите дату в формате DD/MM/YYYY, когда открытка должна быть доставлена.';
$MsgChooseStamp ='Выбор марки';
$MsgPostColor ='Цвет фона открытки';
$MsgPageBackground ='Рисунок';
$MsgNone ='Никакой';
$MsgMusic ='Музыка';
$MsgPreviewButton ='Посмотреть перед отправкой';
$MsgNotify ='Уведомить по email, когда получатель прочитает эту открытку.';
$MsgYes  ='Да';
$MsgNo  ='Нет';
$MsgNoFlash ='Вам необходим Flash плеер для просмотра Flash версий открыток.';
$MsgClickHereToGet ='Нажмите здесь, чтобы получить его!';
$MsgHelp ='Справка!';
$MsgCloseWindow ='Закрыть окно';
$MsgPrintable ='Версия для печати';

$MsgCreateCard ='Создать открытку';


$MsgDateFormatDMY ='День - Месяц - Год';
$MsgDateFormatMDY ='Месяц - День - Год';

// Error Messages
$MsgActiveJS ='Пожалуйста активируйте javascript!';
$MsgErrorMessage ='Вы должны написать сообщение для Вашей открытки.';
$MsgErrorRecpName ='Вы должны указать имя получателя.';
$MsgErrorRecpEmail ='вы должны указать e-mail адрес получателя.';
$MsgErrorRecpEmail2 ='<B>Е-mail адрес</B> получателя ошибочный.';
$MsgErrorSenderName ='Вы должны указать Ваше имя.';
$MsgErrorSenderEmail ='вы должны указать Ваш e-mail адрес.';
$MsgErrorSenderEmail2 ='Ваш <B>e-mail адрес</B> ошибочный.';
$MsgErrorNotFoundTxt ='Извините, нет открытки, которая соответствовала бы указанному номеру. Вы могли ошибиться, указав ID открытки или Ваша открытка может быть слишком давно отправлена и уже удалена из системы.';
$MsgErrorNoCardsEvents ='Извините, нет открыток для этого события в базе данных.';
$MsgErrorInvalidePageNumber ='Вы указали неверный номер страницы.';
$MsgErrorNoCardsinDB ='Огорчены, нет открытки в базе данных.';

$MsgInvalidePageNumber ='Вы указали неверный номер страницы';

$MsgBackEditButton ='Вернуться к редактированию';
$MsgSendButton ='Отправить открытку!';

$MsgSendTo ='Отправить открытку для ';
$MsgClickHere ='нажмите здесь';
$MsgAvoidDuplicat ='нажмите один раз, чтобы избежать дублирования!';

// Info Windows
$MsgWinvCode ='vCode';
$MsgWinTextCode ='Text Code';
$MsgSomeText ='some text';
$MsgWinEmoticons ='Смайлики';
$MsgWinEmoticonsNote ='Все знаки uppercased(?) (O и P)!';
$MsgWinEmoticonsNoteFotter ='<B>If</B> you do NOT want the graphic to appear, but still want to use the original emoticons you will have to exclude the nose.';
$MsgWinBackground ='Фоновое изображение';
$MsgWinStamp ='Изображение марки';
$MsgWinColors ='Цвета';
$MsgWinMusic ='Музыка';
$MsgWinMusicNote ='Выбор действия.';
$MsgWinMusicNote2 ='Необходимо несколько секунд, чтобы загрузить звук на Ваш компьютер';
$MsgWinPoem ='Стихотворение';
$MsgWinPoemNote ='выбор стихотворения.';
$MsgWinNotify ='Хотите Вы получить уведомление по email, после того, как открытка будет просмотрена получателем?';
$MsgWinNotifyTitle ='Уведомление по e-mail';
$MsgWinFonts ='Шрифты';
$MsgWinFontsNote ='Если Вы хотите использовать это действие, <FONT COLOR=red>пожалуйста помните</FONT>, что не у всех людей могут быть установлены эти шрифты на компьютере. Если этих шрифтов нет, то получатели увидят открытку со шрифтом, который установлен у них в системе, обычно это Times, Arial или Helvetica.'; 
$MsgWinName ='Имя';
$MsgWinSample ='Пример';
$MsgWinSampleString ='abcdefghijklmnopqrstuvwxyz';

// Message in confirmation page
$MsgSendAnotherCard ='Отправить другую открытку';

// Top X gallery
$MsgTop ='Лучшие';

// Category Browser Pages
$MsgNext ='Следующая';
$MsgPrevious ='Предыдущая';
$MsgBackCatMain ='Вернуться на главную страницу категорий';
$MsgPageOf ='из'; // page xx OF yy
$MsgPage ='Страница'; // PAGE xx of yy

$MsgCategories ='Категории';
$MsgCategory ='Категория';
$MsgPostcards ='Открытки';
$MsgCards ='Открытки';

// Back Link Messages
$MsgBack ='Назад';
$MsgBackButton ='На предыдущую страницу';
$MsgBacktoSection ='К предыдущей секции';

// Links
$MsgHome ='Главная страница';
$MsgGoTo ='Перейти';

// File Upload
$MsgUploadYourOwnFileTitle ='Использовать ваше изображение';
$MsgUploadYourOwnFileInfo ='Создать открытку, используя Ваше изображение';
$MsgErrorFileExtension ='Неверное расширение файла. Расширение может быть .gif, .jpeg, .jpg или .swf!';
$MsgFileBiggerThan ='Размер файла больше, чем'; // File size is bigger than XX Kilobytes
$MsgFileMaxSizeAllowed ='Максимальный размер файла'; // The max size of file is XX Kilobytes
$MsgFileAllowed ='Вы можете загрузить Ваше изображение (.gif, .jpg) или flash-анимацию (.swf) для создания открытки. Выберите файл и нажмите на кнопку.';
$MsgFileUploadNotAllowed ='Система загрузки файлов выключена на этом сервере! Извините';
$MsgFileSend ='Отправить файл!';
$MsgFileSelect ='Выбрать Ваш файл';
$MsgFileUseFile ='Создать открытку';

$MsgCalendarMonth ='Месяц';
$MsgCalendarDayBegin ='Первый день';
$MsgCalendarDayEnd ='Последний день';
$MsgCalendarEventName ='Название события';
$MsgCalendar ='Календарь';
$MsgMonthNames = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');

/* ######################## added version 1.2 ######################## */
$MsgOptionsHelp ='Настройки и справка!!';
$MsgTopCardInCat ='Лучшие открытки в категории';
$MsgCopyWant ='Вы хотите получить копию открытки?';
$MsgHome ='Главная';

$MsgSearch_noresults ='Ваш поиск не дал результатов. Попробуйте использовать другие ключевые слова.';
$MsgSearch_returned ='По вашему запросу найдено'; // Your search returned XX results
$MsgSearch_results ='результат(ов)'; // Your search returned XX results
$MsgSearch_relevance ='Листинг в порядке релевантности';
$MsgSearch_button ='Поиск открытки';

// address book
$MsgABook_tit_generaltitle ='Моя адресная книга';
$MsgABook_tit_login ='Моя адресная книга: Авторизация';
$MsgABook_tit_editprofile ='Редактировать личную анкету';
$MsgABook_tit_forgotpword ='Забыли пароль?';
$MsgABook_tit_createabook ='Создать адресную книгу';
$MsgABook_tit_addrecord ='Добавить E-mail адрес';
$MsgABook_tit_editrecord ='редактировать E-mail адрес';
$MsgABook_tit_deleterecord ='Удалить E-mail адрес?';
$MsgABook_tit_updaterecord ='Обновить E-mail адрес';
$MsgABook_tit_help ='Моя адресная книга: Справка';
$MsgABook_tit_error ='Ошибка!';
$MsgABook_tit_cleancookie ='Cookies удалены!';
$MsgABook_email ='E-mail адрес';
$MsgABook_realname ='Реальное имя';
$MsgABook_name ='Имя';
$MsgABook_password ='Пароль';
$MsgABook_username ='Имя пользователя';

$MsgABook_error ='Одна или более областей формы пустые.<BR><BR> Пожалуйста вернитесь назад и заполните необходимые области формы перед продолжением.';
$MsgABook_error_username ='Это имя пользователя уже используется.<br><br>Пожалуйста вернитесь назад и укажите другое имя пользователя.';
$MsgABook_error_invalidlogin ='Ошибочное имя пользователя или пароль.';
$MsgABook_error_emailformate ='Ошибочный формат e-mail адреса.<br><br>Пожалуйста вернитесь назад и проверте e-mail адрес.';
$MsgABook_error_invalidloginnote='Вы совершили ошибку. Вернитесь назад, чтобы испраить ее и попытаться снова. Нажмите <b>New User</b> для создания новой адресной книги.';
$MsgABook_helppassword ='Справка! Востстановление забытого пароля!';
$MsgABook_cleancookie ='Удалить данные об имени пользователя/пароле с этого компьютера!';
$MsgABook_cleancookie_note ='Данные об имени пользователя и пароле удалены с вашего компьютера!';
$MsgABook_pwdremeber ='Запомнить мои имя пользователя и пароль';
$MsgABook_forgotpword_note ='Введите Ваше имя пользователя и нажмите кнопку <b>Отправить</>, чтобы получить пароль на e-mail адрес, который Вы указали в Вашей анкете.  Нажмите <b>Отмена</b> для возврата на страницу ввода имени пользователя и пароля.';
$MsgABook_forgotpword_note2 ='Введите имя пользователя и пароль для входа в Вашу адресную книгу. Если Вы новый пользователь и не имеете адресной книги, нажмите <b>New User</b> для создания новой адресной книги на нашем сервере.';
$MsgABook_create_note ='Privacy Policy: The information you enter below is stored on our web server and only will be used for your private use to insert the infos into postcards you send from our site.';
$MsgABook_profile_note ='Выполните любые изменения, потом нажмите <B>Сохранить</B> для обновления информации в вашей анкете.';
$MsgABook_topnote ='Для выбора нескольких пунктов удерживайте нажатой \'Ctrl\' при клике';
$MsgABook_bottonnote ='Примечание: Помните, что выход из адресной книги, после завершения работы, необходим для защиты Вашей персональной информации.';
$MsgABook_note1 ='Ваша адресная книга закрыта. Вы можете записать информацию в адресную книгу только если она открыта. Ваша адресная книга сейчас закрыта.';

$MsgABook_help_add ='Добавление нового e-mail адреса: Если Вы хотите добавить новый email адрес в Вашу адресную книгу, нажмите здесь.';
$MsgABook_help_edit ='Редактирование e-mail адреса: Выберите только одну запись на основной странице и нажмите кнопку <b>Изменить</b>.';
$MsgABook_help_delete ='Удаление e-mail адреса: Выберите запись, которую хотите удалить и нажмите <b>Удалить</b>.';
$MsgABook_help_help ='Страница помощи: Вы уже здесь :)';
$MsgABook_help_logout ='Выход из адресной книги блокирует получение доступа посторонних к Вашей персональной информации.';
$MsgABook_help_close ='Закрыть окно Вашей адресной книги.';
$MsgABook_help_insert ='Вставить выбранные e-mail адреса из адресной книги.';
$MsgABook_help_profile ='Обновление Вашей анкеты для адресной книги.';

$MsgReferFriend ='Рекомендовать этот сайт другу';
$MsgReferFriend_friendname ='Имя друга';
$MsgReferFriend_friendemail ='Е-mail друга';
$MsgReferFriend_thanks ='Спасибо Вам';
$MsgReferFriend_end ='Спасибо, что порекомендовали этот сайт';
$MsgReferFriend_custommessage ='Добавить ичное сообщение';
$MsgReferFriend_error ='Одно или более полей формы были оставлены пустыми.<BR><BR> Пожалуйста укажите всю необходимую информацию.';
$MsgReferFriend_error_emailformate ='Ошибочный формат e-mail адреса.<br><br>Пожалуйста вернитесь назад и проверьте e-mail адрес.';

$MsgNewsletter_join ='Внести мой адрес в список адресов службы виртуальных открыток';

$Msg_error_emptyfield ='поле пустое';

$Msg_label_username ='Имя пользователя';
$Msg_label_password ='Пароль';
$Msg_label_realname ='Реальное имя';
$Msg_label_email ='E-mail адрес';
$Msg_label_addressbook ='Адресная книга';

$Msg_label_add ='Добавить';
$Msg_label_close ='Закрыть';
$Msg_label_delete ='Удалить';
$Msg_label_done ='Готово';
$Msg_label_edit ='Редактировать';
$Msg_label_finish ='Завершено';
$Msg_label_help ='Справка';
$Msg_label_login ='Войти';
$Msg_label_logout ='Выйти';
$Msg_label_open ='Открыть';
$Msg_label_update ='Обновить';
$Msg_label_samplee ='Пример';
$Msg_label_image ='Изображение';
$Msg_label_view ='Вид';

/* ######################## added version 1.3 ######################## */
$MsgSubcategory ='Субкатегория';
$MsgRandomCards ='Случайная открытка';

/* ######################## added version 1.6 ######################## */
// updated!!!!
$MsgABook_bottonnote2 ='<font color=red><b>Внимание:</b> Чтобы указать несколько получателей открытки, используйте клавиши SHIFT/CTRL</font>.';

/* ######################## added version 2.0 ######################## */
$Msg_rate ='рейтинг открытки';
$Msg_button_rate ='рейтинговать!';

/* ######################## added version 2.2 ######################## */
$MsgABook_password2 ='Подтверждение пароля';
$MsgABook_error2 ='Пароль не подтвержден. Вернитесь назад для исправления ошибки.';

/* ######################## added version 2.3 ######################## */
$MsgABook_helppage ='<p><b>Что такое - Моя адресная книга? </b></p><p>Моя адресная книга - это средство, которое предназначено, чтобы сделать легче для Вас процесс создания и отправки открыток. В ней Вы можете сохранить имена, e-mail адреса Ваших друзей и знакомых. Вы можете быстро указывать адреса для Ваших открыток. Адресная книга проста в использовании и способна включить в себя много полезных характеристик по облегчению процесса создания открытки. </p><p><b>Как мне добавить имена и e-mail адреса в открытку, используя мою адресную книгу? </b></p><p>First select the number of recipients you want use and then go to your List, simply select on the name and then click \'Insert emails into card\'. The name and email address of your recipient will be added to your card. If you want select multiple contacts, jsut holding down \'Ctrl\' while clicking the names. These names will be added to your card if there is the correct number recipients fields. </p>';


?>