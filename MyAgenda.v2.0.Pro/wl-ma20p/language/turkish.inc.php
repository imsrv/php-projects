<?php
#############################################################################
# myAgenda v2.0																#
# =============																#
# Copyright (C) 2003  Mesut Tunga - mesut@tunga.com							#
# http://php.tunga.com														#
#############################################################################

$LANGUAGE['strHome'] = "Ana Sayfa";
$LANGUAGE['strBack'] = "Geri";
$LANGUAGE['date_format'] = "d-m-Y";
$LANGUAGE['time_format'] = "H:i";
$LANGUAGE['strAdd'] = "Ekle";
$LANGUAGE['strUpdate'] = "G�ncelle";
$LANGUAGE['strDelete'] = "Sil";
$LANGUAGE['strName'] = "Ad";
$LANGUAGE['strSurname'] = "Soyad";
$LANGUAGE['strEmail'] = "Eposta";
$LANGUAGE['strUsername'] = "Kullan�c� Ad�";
$LANGUAGE['strPassword'] = "�ifre";
$LANGUAGE['strSignup'] = "Kay�t";
$LANGUAGE['strLogin'] = "Giri�";
$LANGUAGE['strSubmit'] = "G�nder";
$LANGUAGE['strRegFree'] = "Kay�tl� kullan�c� de�ilseniz, <a href=\"register.php\"><b>buraya</b></a> t�klayarak <b>�cretsiz</b> kay�t olabilirsiniz.";
$LANGUAGE['strJSUsername'] = "Kullan�c� ad�n�z� kontrol ediniz.\\nKullan�c� ad�n�z en az 4 en �ok 10\\nkarakter olamal� ve i�erisinde\\n0123456789abcdefghijklmnopqrstuvwxyz.-_\\nharici karakter i�ermemelidir!";
$LANGUAGE['strJSPassword'] = "�ifrenizi kontrol ediniz.\\n�ifreniz ad�n�z en az 4\\nen �ok 10 karakter olabilir.";
$LANGUAGE['strErrorWronguser'] = "Hatal� kullan�c� ad�/�ifre girdiniz";
$LANGUAGE['strErrorTimeout'] = "Zaman a��m�. Tekrar giri� yap�n�z";
$LANGUAGE['strErrorUnknown'] = "Bir hata olu�tu.!";


# agenda_add.php
$LANGUAGE['strHaveNotes'] = "<b><u>Not:</u></b> <font color=\"#FF0000\">*</font> i�aretli tarihlerde hat�rlatmalar�n�z bulunmaktad�r.";
$LANGUAGE['strAddReminder'] = "Hat�rlatma Ekle";
$LANGUAGE['strEditReminder'] = "Hat�rlatma D�zenle";
$LANGUAGE['str_At'] = "Saat";
$LANGUAGE['str_Oclock'] = "'de(da)";
$LANGUAGE['strWriteNote'] = "Hat�rlatma notunuzu buraya yaz�n";
$LANGUAGE['strMaxNoteChars'] = "En fazla 125 karakter";
$LANGUAGE['strThisReminder'] = " Uyar";
$LANGUAGE['strFromMyDate'] = "ekledi�im tarihden";
$LANGUAGE['strMyThisReminder'] = "Ekledi�im hat�rlatmay�";
$LANGUAGE['strError'] = "Hata";
$LANGUAGE['strErrorWrongDate'] = "Se�ti�iniz tarih hatal� bir tarih!";
$LANGUAGE['strErrorOldDate'] = "Se�ti�iniz tarih ge�mi� bir tarih!";
$LANGUAGE['strErrorLackDate'] = "Eksik tarih girdiniz!";
$LANGUAGE['strJSNoNote'] = "Not k�sm�n� bo� b�rakamazs�n�z";
$LANGUAGE['strJSToomuchChars'] = "125 karakterden fazla not yazamazs�n�z";
$LANGUAGE['strSaveRemindOk'] = "Hat�rlatman�z kay�t edildi!";
$LANGUAGE['strErrorSqlInsert'] = "Bilgileriniz kay�t edilirken bir sorun olu�tu. L�tfen bu sorunu <a href=\"mailto:".$CFG->PROG_EMAIL."\">".$CFG->PROG_EMAIL."</a> adresine iletiniz.";

# register.php
$LANGUAGE['strJSEnterName'] = "Ad�n�z� giriniz";
$LANGUAGE['strJSEnterSurname'] = "Soyad�n�z� giriniz!";
$LANGUAGE['strJSEnterEmail'] = "Eposta adresini uygun formatta giriniz!";
$LANGUAGE['strJSPasswordsNoMatch'] = "Girdi�iniz �ifreler uyu�muyor!";
$LANGUAGE['strRepeate'] = "Tekrar";

$LANGUAGE['strRegisterOk'] = "<b>Tebrikler!</b><p>Kayd�n�z ba�ar� ile ger�ekle�tirildi. Giri� yapmak i�in <a href=\"login.php\">buraya</a> t�klay�n�z.";
$LANGUAGE['strGoLocation'] = "Geldi�iniz yere geri d�nmek i�in l�tfen <a href=\"login.php?location=$location\">t�klay�n�z</a>.";
$LANGUAGE['strExistMail'] = "Girdi�iniz eposta adresi (//email//) sistemimizde ba�kas� ad�na kay�tl�. L�tfen farkl� bir eposta adresi se�iniz.";
$LANGUAGE['strExistUser'] = "Girdi�iniz kullan�c� ad� sistemimizde ba�kas� ad�na kay�tl�. L�tfen farkl� bir kullan�c� ad� se�iniz.";
$LANGUAGE['strWrongMail'] = "Girdi�iniz mail adresi (//email//) hatal�.";
$LANGUAGE['strReminderUpdated'] = "Hat�rlatman�z g�ncellendi!";
$LANGUAGE['strReminderDeleted'] = "Hat�rlatman�z silindi!";

$LANGUAGE['strMonthnames'] = array("Ocak", "�ubat", "Mart", "Nisan", "May�s", "Haziran", "Temmuz", "A�ustos", "Eyl�l", "Ekim", "Kas�m", "Aral�k");
$LANGUAGE['strWeekdays'] = array("Paz", "Pzt", "Sal", "�r�", "Pr�", "Cum", "Cmt", "Paz");

$LANGUAGE['strGo'] = "Git";
$LANGUAGE['strLogout'] = "��k��";
$LANGUAGE['strPrevious'] = "�nceki";
$LANGUAGE['strNext'] = "Sonraki";
$LANGUAGE['strJSConfirm'] = "Bu Kayd(lar)� Silmek �stedi�inizden Eminmisiniz ?";
$LANGUAGE['strSave'] = "Kaydet";
$LANGUAGE['strYes'] = "Evet";
$LANGUAGE['strNo'] = "Hay�r";

$LANGUAGE['strReminderDate'] = "Hat�rlatma Tarihi";
$LANGUAGE['strReminderNote'] = "Hat�rlatma Notunuz";
$LANGUAGE['strMailNextRemindDate'] = "Bir Sonraki Hat�rlatma Tarihiniz";
$LANGUAGE['strMailReminderSent'] = "Hat�rlatmalar Gonderildi";

$LANGUAGE['strRemindTypes'] = array(1 => "Hat�rlatma", "Bulu�ma", "Do�um G�n�", "Y�ld�n�m�", "Yemek", "Aktivite", "�deme", "Di�er");
$LANGUAGE['strRemindRepeates'] = array(1 => "Sadece Bir Kere", "Her G�n", "Her Hafta", "Her Ay", "Her Y�l");
$LANGUAGE['strRemindDays'] = array("Ayn� G�n", "1 G�n �nce", "2 G�n �nce", "3 G�n �nce", "7 G�n �nce");

$LANGUAGE['strForgotLoginInfo'] = "Giri� Bilgilerinizi mi Unuttunuz?";
$LANGUAGE['strSendMyPassword'] = "�ifremi G�nder";
$LANGUAGE['strJSEmail'] = "E-Posta Adresini Kontrol Ediniz";
$LANGUAGE['strForgotPassEmailSubj'] = "�ifreniz";
$LANGUAGE['strForgotPassEmailBody'] = "Merhaba {name}\n\nSifreniz: {password}\n\nGiris yapmak icin asagidaki linki tiklayiniz:\n\n{link}\n\n" . $CFG->PROG_NAME . "\n" . $CFG->PROG_URL;
$LANGUAGE['strForgotPassEmailOk'] = "�ifreniz e-posta adresinize g�nderildi.";
$LANGUAGE['strForgotPassEmailError'] = "Girdi�iniz e-posta adresi veritaban�m�zda bulunamam��t�r.";

# Administrative LANGUAGE

$LANGUAGE['str_AdministrativeArea'] = $CFG->PROG_NAME . " Y�netim Merkezi";
$LANGUAGE['str_ListUsers'] = "Kullan�c� Listesi";
$LANGUAGE['str_ListReminders'] = "Hat�rlatma Listesi";

$LANGUAGE['str_myAgendaUsers'] = $CFG->PROG_NAME . " Users";
$LANGUAGE['str_myAgendaUsersReminders'] = $CFG->PROG_NAME . " Users' Reminders";

$LANGUAGE['str_RegDate'] = "Registered";
$LANGUAGE['str_RegUsers'] = "Kay�tl� toplam <b>{TOTAL}</b> abone mevcut.";
$LANGUAGE['str_RegReminders'] = "Kay�tl� toplam <b>{TOTAL}</b> hat�rlatma mevcut.";

$LANGUAGE['strEdit'] = "D�zenle";
$LANGUAGE['strDelete'] = "Sil";
$LANGUAGE['strAction'] = "��lem";
$LANGUAGE['strOtherPages'] = "Di�er Sayfalar";
$LANGUAGE['strPrevPage'] = "�nceki Sayfa";
$LANGUAGE['strNextPage'] = "Sonraki Sayfa";
$LANGUAGE['strRecordUpdated'] = "Kay�t G�ncellendi";
$LANGUAGE['strRecordDeleted'] = "Kay�t Silindi";
$LANGUAGE['strReminders'] = "Hat�rlatmalar";
$LANGUAGE['strType'] = "Tip";
$LANGUAGE['strDate'] = "Tarih";
$LANGUAGE['strRepeat'] = "Tekrar";
$LANGUAGE['strDuration'] = "S�re";
$LANGUAGE['strAdvance'] = "�ncelik";
$LANGUAGE['str_ReminderNote'] = "Notu";
$LANGUAGE['str_ReminderAdded'] = "Eklenme Tarihi";
$LANGUAGE['str_UsersStats'] = "Kullan�c� �statistikleri";
$LANGUAGE['str_RemindersStats'] = "Hat�rlatma �statistikleri";

$LANGUAGE['strLastAccess'] = "Son Geli�";

$LANGUAGE['strDelSelected'] = "Se�ili ��eleri Sil";
$LANGUAGE['strSelectOne'] = "L�tfen en az bir ��e se�iniz";
$LANGUAGE['strItemsDeleted'] = "{TOTAL} adet ��e silindi";
$LANGUAGE['strsendPassword'] = "�ifresini G�nder";

$LANGUAGE['str_NoReminders'] = "Kay�tl� hat�rlatma yok";
$LANGUAGE['str_NoUsers'] = "Kay�tl� kullan�c� bulunmamaktad�r";

$LANGUAGE['str_ChangeUser'] = "Kulan�c� Ad�/�ifre De�i�tir";
$LANGUAGE['str_OldUsername'] = "Eski Kullan�c� Ad�";
$LANGUAGE['str_OldPass'] = "Eski �ifre";
$LANGUAGE['str_NewUsername'] = "Yeni Kullan�c� Ad�";
$LANGUAGE['str_NewPass'] = "Yeni �ifre";
$LANGUAGE['str_UserChanged'] = "Kullan�c� Ad�/�ifre De�i�ti";

$LANGUAGE['str_JSRequiredFields'] = "Gerekli t�m alanlar� doldurunuz";
$LANGUAGE['str_Config'] = "Konfigurasyon";
$LANGUAGE['str_ConfigUpdated'] = "Konfigurasyon G�ncellendi";
$LANGUAGE['str_ConfigNotUpdated'] = "Yap�lacak biri�lem bulunamad�!";
$LANGUAGE['str_UserPassInfo'] = "Kullan�c� ad/�ifrenizi de�i�tirmek istemiyorsan�z, ilgili alanlar� bo� b�rak�n�z.";

$LANGUAGE['str_confirmRegistration'] = "Te�ekk�rler!<p>Kayd�n�z�n yap�lmas�na bir ad�m kald�. Girdi�iniz //email// adresine bir adet onay mektubu g�nderilmi�tir. L�tfen bu mektupta yaz�lanlar� uygulay�n�z.";
$LANGUAGE['str_confirmEmailSubject'] = "myAgenda Kay�t Onay�";
$LANGUAGE['str_NoEmail'] = "Girdi�iniz ePosta adresine kay�tlar�m�zda rastlan�lmad�.";
$LANGUAGE['str_PasswordSent'] = "�ifreniz eposta adresinize g�nderilmi�tir.";
$LANGUAGE['str_LimitedPasswordRequest'] = "Bu ePosta adresine, ayn� g�n i�inde 3 kezden fazla �ifre istemi yap�lm��t�r. L�tfen sistem y�neticisi ile irtibat kurunuz.";
$LANGUAGE['str_ForgotPwEmailSubject'] = "myAgenda �ifreniz";
$LANGUAGE['str_YourRemindersOnToday'] = "Bug�n�n Hat�rlatmalar�";
$LANGUAGE['str_OK'] = "TAMAM";

$LANGUAGE['strModifyInfo'] = "Bilgi G�ncelleme";
$LANGUAGE['strOldPassword'] = "Eski �ifre";
$LANGUAGE['strJSOldPassword'] = "Eski �ifrenizi kontrol ediniz.";
$LANGUAGE['strOldPasswordWrong'] = "Eski �ifreniz Hatal�.";
$LANGUAGE['strForSecurityPass'] = "Bilgilerinizin g�ncellenebilmesi ve g�venli�iniz i�in l�tfen eski �ifrenizi giriniz.";
$LANGUAGE['strUserInfoModified'] = "Bilgileriniz ba�ar� ile g�ncellendi";
$LANGUAGE['strNothingUpdated'] = "Herhangi bir g�ncelleme yap�lmad�";
?>