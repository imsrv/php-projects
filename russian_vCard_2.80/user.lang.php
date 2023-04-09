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
$htmldir ='ltr'; // ltr = ����� - ������� , rtl = ������ - ������ (��� ��� ������)
				/* text direction attribute is used to declare the direction 
		    that the text should run, either left to right (default) or right to left */

// ��������, ������������ � ��� �������
$MsgImage ='�����������';
$MsgYourTitle ='��������� ��������';
$MsgMessage ='���������';
$MsgMessageHere ='- ���� ��������� �������� ����� -'; // Sample message that will apper if postcard use a template
$MsgFont ='�����';
$MsgNoFontFace ='�� ���������';
$MsgFontSizeSmall ='���������';
$MsgFontSizeMedium ='�������';
$MsgFontSizeLarge ='�������';
$MsgFontSizeXLarge ='����� �������';
$MsgFontColorBlack ='������';
$MsgFontColorWhite ='�����';
$MsgSignature ='�������';
$MsgRecpName ='��� ����������';
$MsgRecpEmail ='�-mail ����������';
$MsgAddRecp ='�������� �����������';
$MsgTotalRecp ='����� �����������';
$MsgPlay ='����������';
$MsgYourName ='���� ���';
$MsgYourEmail ='��� email';
$MsgChoosePoem ='����� �������������';
$MsgView ='��������';
$MsgChooseLayout ='����� ������� ��������';
$MsgChooseDate ='������� ���� ��������?';
$MsgChooseDateImmediate ='����������';
$MsgDateFormat ='������� ���� � ������� DD/MM/YYYY, ����� �������� ������ ���� ����������.';
$MsgChooseStamp ='����� �����';
$MsgPostColor ='���� ���� ��������';
$MsgPageBackground ='�������';
$MsgNone ='�������';
$MsgMusic ='������';
$MsgPreviewButton ='���������� ����� ���������';
$MsgNotify ='��������� �� email, ����� ���������� ��������� ��� ��������.';
$MsgYes  ='��';
$MsgNo  ='���';
$MsgNoFlash ='��� ��������� Flash ����� ��� ��������� Flash ������ ��������.';
$MsgClickHereToGet ='������� �����, ����� �������� ���!';
$MsgHelp ='�������!';
$MsgCloseWindow ='������� ����';
$MsgPrintable ='������ ��� ������';

$MsgCreateCard ='������� ��������';


$MsgDateFormatDMY ='���� - ����� - ���';
$MsgDateFormatMDY ='����� - ���� - ���';

// Error Messages
$MsgActiveJS ='���������� ����������� javascript!';
$MsgErrorMessage ='�� ������ �������� ��������� ��� ����� ��������.';
$MsgErrorRecpName ='�� ������ ������� ��� ����������.';
$MsgErrorRecpEmail ='�� ������ ������� e-mail ����� ����������.';
$MsgErrorRecpEmail2 ='<B>�-mail �����</B> ���������� ���������.';
$MsgErrorSenderName ='�� ������ ������� ���� ���.';
$MsgErrorSenderEmail ='�� ������ ������� ��� e-mail �����.';
$MsgErrorSenderEmail2 ='��� <B>e-mail �����</B> ���������.';
$MsgErrorNotFoundTxt ='��������, ��� ��������, ������� ��������������� �� ���������� ������. �� ����� ���������, ������ ID �������� ��� ���� �������� ����� ���� ������� ����� ���������� � ��� ������� �� �������.';
$MsgErrorNoCardsEvents ='��������, ��� �������� ��� ����� ������� � ���� ������.';
$MsgErrorInvalidePageNumber ='�� ������� �������� ����� ��������.';
$MsgErrorNoCardsinDB ='��������, ��� �������� � ���� ������.';

$MsgInvalidePageNumber ='�� ������� �������� ����� ��������';

$MsgBackEditButton ='��������� � ��������������';
$MsgSendButton ='��������� ��������!';

$MsgSendTo ='��������� �������� ��� ';
$MsgClickHere ='������� �����';
$MsgAvoidDuplicat ='������� ���� ���, ����� �������� ������������!';

// Info Windows
$MsgWinvCode ='vCode';
$MsgWinTextCode ='Text Code';
$MsgSomeText ='some text';
$MsgWinEmoticons ='��������';
$MsgWinEmoticonsNote ='��� ����� uppercased(?) (O � P)!';
$MsgWinEmoticonsNoteFotter ='<B>If</B> you do NOT want the graphic to appear, but still want to use the original emoticons you will have to exclude the nose.';
$MsgWinBackground ='������� �����������';
$MsgWinStamp ='����������� �����';
$MsgWinColors ='�����';
$MsgWinMusic ='������';
$MsgWinMusicNote ='����� ��������.';
$MsgWinMusicNote2 ='���������� ��������� ������, ����� ��������� ���� �� ��� ���������';
$MsgWinPoem ='�������������';
$MsgWinPoemNote ='����� �������������.';
$MsgWinNotify ='������ �� �������� ����������� �� email, ����� ����, ��� �������� ����� ����������� �����������?';
$MsgWinNotifyTitle ='����������� �� e-mail';
$MsgWinFonts ='������';
$MsgWinFontsNote ='���� �� ������ ������������ ��� ��������, <FONT COLOR=red>���������� �������</FONT>, ��� �� � ���� ����� ����� ���� ����������� ��� ������ �� ����������. ���� ���� ������� ���, �� ���������� ������ �������� �� �������, ������� ���������� � ��� � �������, ������ ��� Times, Arial ��� Helvetica.'; 
$MsgWinName ='���';
$MsgWinSample ='������';
$MsgWinSampleString ='abcdefghijklmnopqrstuvwxyz';

// Message in confirmation page
$MsgSendAnotherCard ='��������� ������ ��������';

// Top X gallery
$MsgTop ='������';

// Category Browser Pages
$MsgNext ='���������';
$MsgPrevious ='����������';
$MsgBackCatMain ='��������� �� ������� �������� ���������';
$MsgPageOf ='��'; // page xx OF yy
$MsgPage ='��������'; // PAGE xx of yy

$MsgCategories ='���������';
$MsgCategory ='���������';
$MsgPostcards ='��������';
$MsgCards ='��������';

// Back Link Messages
$MsgBack ='�����';
$MsgBackButton ='�� ���������� ��������';
$MsgBacktoSection ='� ���������� ������';

// Links
$MsgHome ='������� ��������';
$MsgGoTo ='�������';

// File Upload
$MsgUploadYourOwnFileTitle ='������������ ���� �����������';
$MsgUploadYourOwnFileInfo ='������� ��������, ��������� ���� �����������';
$MsgErrorFileExtension ='�������� ���������� �����. ���������� ����� ���� .gif, .jpeg, .jpg ��� .swf!';
$MsgFileBiggerThan ='������ ����� ������, ���'; // File size is bigger than XX Kilobytes
$MsgFileMaxSizeAllowed ='������������ ������ �����'; // The max size of file is XX Kilobytes
$MsgFileAllowed ='�� ������ ��������� ���� ����������� (.gif, .jpg) ��� flash-�������� (.swf) ��� �������� ��������. �������� ���� � ������� �� ������.';
$MsgFileUploadNotAllowed ='������� �������� ������ ��������� �� ���� �������! ��������';
$MsgFileSend ='��������� ����!';
$MsgFileSelect ='������� ��� ����';
$MsgFileUseFile ='������� ��������';

$MsgCalendarMonth ='�����';
$MsgCalendarDayBegin ='������ ����';
$MsgCalendarDayEnd ='��������� ����';
$MsgCalendarEventName ='�������� �������';
$MsgCalendar ='���������';
$MsgMonthNames = array('������', '�������', '����', '������', '���', '����', '����', '������', '��������', '�������', '������', '�������');

/* ######################## added version 1.2 ######################## */
$MsgOptionsHelp ='��������� � �������!!';
$MsgTopCardInCat ='������ �������� � ���������';
$MsgCopyWant ='�� ������ �������� ����� ��������?';
$MsgHome ='�������';

$MsgSearch_noresults ='��� ����� �� ��� �����������. ���������� ������������ ������ �������� �����.';
$MsgSearch_returned ='�� ������ ������� �������'; // Your search returned XX results
$MsgSearch_results ='���������(��)'; // Your search returned XX results
$MsgSearch_relevance ='������� � ������� �������������';
$MsgSearch_button ='����� ��������';

// address book
$MsgABook_tit_generaltitle ='��� �������� �����';
$MsgABook_tit_login ='��� �������� �����: �����������';
$MsgABook_tit_editprofile ='������������� ������ ������';
$MsgABook_tit_forgotpword ='������ ������?';
$MsgABook_tit_createabook ='������� �������� �����';
$MsgABook_tit_addrecord ='�������� E-mail �����';
$MsgABook_tit_editrecord ='������������� E-mail �����';
$MsgABook_tit_deleterecord ='������� E-mail �����?';
$MsgABook_tit_updaterecord ='�������� E-mail �����';
$MsgABook_tit_help ='��� �������� �����: �������';
$MsgABook_tit_error ='������!';
$MsgABook_tit_cleancookie ='Cookies �������!';
$MsgABook_email ='E-mail �����';
$MsgABook_realname ='�������� ���';
$MsgABook_name ='���';
$MsgABook_password ='������';
$MsgABook_username ='��� ������������';

$MsgABook_error ='���� ��� ����� �������� ����� ������.<BR><BR> ���������� ��������� ����� � ��������� ����������� ������� ����� ����� ������������.';
$MsgABook_error_username ='��� ��� ������������ ��� ������������.<br><br>���������� ��������� ����� � ������� ������ ��� ������������.';
$MsgABook_error_invalidlogin ='��������� ��� ������������ ��� ������.';
$MsgABook_error_emailformate ='��������� ������ e-mail ������.<br><br>���������� ��������� ����� � �������� e-mail �����.';
$MsgABook_error_invalidloginnote='�� ��������� ������. ��������� �����, ����� �������� �� � ���������� �����. ������� <b>New User</b> ��� �������� ����� �������� �����.';
$MsgABook_helppassword ='�������! ��������������� �������� ������!';
$MsgABook_cleancookie ='������� ������ �� ����� ������������/������ � ����� ����������!';
$MsgABook_cleancookie_note ='������ �� ����� ������������ � ������ ������� � ������ ����������!';
$MsgABook_pwdremeber ='��������� ��� ��� ������������ � ������';
$MsgABook_forgotpword_note ='������� ���� ��� ������������ � ������� ������ <b>���������</>, ����� �������� ������ �� e-mail �����, ������� �� ������� � ����� ������.  ������� <b>������</b> ��� �������� �� �������� ����� ����� ������������ � ������.';
$MsgABook_forgotpword_note2 ='������� ��� ������������ � ������ ��� ����� � ���� �������� �����. ���� �� ����� ������������ � �� ������ �������� �����, ������� <b>New User</b> ��� �������� ����� �������� ����� �� ����� �������.';
$MsgABook_create_note ='Privacy Policy: The information you enter below is stored on our web server and only will be used for your private use to insert the infos into postcards you send from our site.';
$MsgABook_profile_note ='��������� ����� ���������, ����� ������� <B>���������</B> ��� ���������� ���������� � ����� ������.';
$MsgABook_topnote ='��� ������ ���������� ������� ����������� ������� \'Ctrl\' ��� �����';
$MsgABook_bottonnote ='����������: �������, ��� ����� �� �������� �����, ����� ���������� ������, ��������� ��� ������ ����� ������������ ����������.';
$MsgABook_note1 ='���� �������� ����� �������. �� ������ �������� ���������� � �������� ����� ������ ���� ��� �������. ���� �������� ����� ������ �������.';

$MsgABook_help_add ='���������� ������ e-mail ������: ���� �� ������ �������� ����� email ����� � ���� �������� �����, ������� �����.';
$MsgABook_help_edit ='�������������� e-mail ������: �������� ������ ���� ������ �� �������� �������� � ������� ������ <b>��������</b>.';
$MsgABook_help_delete ='�������� e-mail ������: �������� ������, ������� ������ ������� � ������� <b>�������</b>.';
$MsgABook_help_help ='�������� ������: �� ��� ����� :)';
$MsgABook_help_logout ='����� �� �������� ����� ��������� ��������� ������� ����������� � ����� ������������ ����������.';
$MsgABook_help_close ='������� ���� ����� �������� �����.';
$MsgABook_help_insert ='�������� ��������� e-mail ������ �� �������� �����.';
$MsgABook_help_profile ='���������� ����� ������ ��� �������� �����.';

$MsgReferFriend ='������������� ���� ���� �����';
$MsgReferFriend_friendname ='��� �����';
$MsgReferFriend_friendemail ='�-mail �����';
$MsgReferFriend_thanks ='������� ���';
$MsgReferFriend_end ='�������, ��� ��������������� ���� ����';
$MsgReferFriend_custommessage ='�������� ����� ���������';
$MsgReferFriend_error ='���� ��� ����� ����� ����� ���� ��������� �������.<BR><BR> ���������� ������� ��� ����������� ����������.';
$MsgReferFriend_error_emailformate ='��������� ������ e-mail ������.<br><br>���������� ��������� ����� � ��������� e-mail �����.';

$MsgNewsletter_join ='������ ��� ����� � ������ ������� ������ ����������� ��������';

$Msg_error_emptyfield ='���� ������';

$Msg_label_username ='��� ������������';
$Msg_label_password ='������';
$Msg_label_realname ='�������� ���';
$Msg_label_email ='E-mail �����';
$Msg_label_addressbook ='�������� �����';

$Msg_label_add ='��������';
$Msg_label_close ='�������';
$Msg_label_delete ='�������';
$Msg_label_done ='������';
$Msg_label_edit ='�������������';
$Msg_label_finish ='���������';
$Msg_label_help ='�������';
$Msg_label_login ='�����';
$Msg_label_logout ='�����';
$Msg_label_open ='�������';
$Msg_label_update ='��������';
$Msg_label_samplee ='������';
$Msg_label_image ='�����������';
$Msg_label_view ='���';

/* ######################## added version 1.3 ######################## */
$MsgSubcategory ='������������';
$MsgRandomCards ='��������� ��������';

/* ######################## added version 1.6 ######################## */
// updated!!!!
$MsgABook_bottonnote2 ='<font color=red><b>��������:</b> ����� ������� ��������� ����������� ��������, ����������� ������� SHIFT/CTRL</font>.';

/* ######################## added version 2.0 ######################## */
$Msg_rate ='������� ��������';
$Msg_button_rate ='������������!';

/* ######################## added version 2.2 ######################## */
$MsgABook_password2 ='������������� ������';
$MsgABook_error2 ='������ �� �����������. ��������� ����� ��� ����������� ������.';

/* ######################## added version 2.3 ######################## */
$MsgABook_helppage ='<p><b>��� ����� - ��� �������� �����? </b></p><p>��� �������� ����� - ��� ��������, ������� �������������, ����� ������� ����� ��� ��� ������� �������� � �������� ��������. � ��� �� ������ ��������� �����, e-mail ������ ����� ������ � ��������. �� ������ ������ ��������� ������ ��� ����� ��������. �������� ����� ������ � ������������� � �������� �������� � ���� ����� �������� ������������� �� ���������� �������� �������� ��������. </p><p><b>��� ��� �������� ����� � e-mail ������ � ��������, ��������� ��� �������� �����? </b></p><p>First select the number of recipients you want use and then go to your List, simply select on the name and then click \'Insert emails into card\'. The name and email address of your recipient will be added to your card. If you want select multiple contacts, jsut holding down \'Ctrl\' while clicking the names. These names will be added to your card if there is the correct number recipients fields. </p>';


?>