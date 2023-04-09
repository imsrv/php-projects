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
$language['button_activate']						= '������������';
$language['button_add']								= '��������';
$language['button_update']							= '��������';
$language['credits_poweredby']						= '������������ ������ Olate Download ';
$language['credits_translatedby']						= '������� �� GTT';
$language['description_accessdenied']				= '������ ������';
$language['description_allfields']					= '�� ������ ��������� ��� ����������� ����. <a href="JavaScript:history.go(-1);">���������</a>.';
$language['description_categories_add']				= '����� �������� ����� ��������� � ���� ������, ������� � ��� � ������� �� ������ ��������';
$language['description_categories_added']			= '��������� ���� ��������� � ���� ������.';
$language['description_categories_delete']			= '����� ������� ���������, �������� ������ �� ������:';
$language['description_categories_deleted']			= '��������� ���� ������� �������.';
$language['description_categories_edit']			= '����� ��������������� ���������, �������� ������ �� ������:';
$language['description_categories_edit_view']		= '����� ��������������� ���������, �������� � �������� � ������� �� ������ ��������:';
$language['description_categories_edited']			= '��������� ���� ���������.';
$language['description_categories_name']			= '��������:';
$language['description_config_colours']				= '����� � ������ �� ������� ��������� � ����� /css/style.css.';
$language['description_config_general']				= '���������. �������� �� ������ �������, � ����� ������� �� ������ ��������.';
$language['description_config_general_noslash']		= '(�� ������� �������� ���� "/")';
$language['description_config_general_upd']			= '���� ������ ���� ���������.';
$language['description_config_language']			= '�� ���� �������� �� ������ ������� ����� ����� �� ������ ������������. ��� �� �� ������� ���� �������� ����� � ������.';
$language['description_config_language_activated']	= '����� ���� ��� �����������.';
$language['description_config_language_created']	= '������� ������ ';
$language['description_config_language_current']	= '����, ������� �� ����������� ������:';
$language['description_config_language_designed']	= '.<br>������� ��� ������� Olate Download ������ ';
$language['description_config_language_new']		= '����� ����� �� ������� ������� �� ����� - ������������ ������� <a href="http://www.olate.com" target="_blank">Olate website</a>. ���������� �� ��������� ������ ����� �� ������� � ����������� � �������. ';
$language['description_config_language_on']			= '<br>���� ��������: ';
$language['description_config_language_select']		= '�������� ���� �� ������ ��������� ������ � ������� �� ������ ������������, ����� ������� ���������.';
$language['description_config_languagesel']			= '---��������� �����---';
$language['description_downloads_add']				= '����� �������� ����� ���� � ���� ������, ��������� ���� ����� � ������� �� ������ ��������. ���� �� �� ������ ������������ ���� �� ������, �������� �� �������.';
$language['description_downloads_added']			= '����� ���� ��� �������� � ���� ������.';
$language['description_downloads_categorysel']		= '---�������� ���������---';
$language['description_downloads_categorycur']		= '�������: ';
$language['description_downloads_delete']			= '����� ������� ����, �������� ������ ��� ���� �� ������:';
$language['description_downloads_deleted']			= '���� ��� ������ �� ������.';
$language['description_downloads_edit']				= '����� ��������������� ����, �������� ������ ��� ���� �� ������:';
$language['description_downloads_edit_view']		= '����, ������� �� ������� ������� ����. ������� ����������� ��� ��������� � ������� �� ������ ��������.';
$language['description_downloads_edited']			= '���� ��� ��������.';
$language['description_downloads_mb']				= '��:';
$language['description_downloads_noimg']			= '�������� ���� ������, ���� �� ����������� �������� ';
$language['description_loggedinas']					= '�� ����� ��� ';
$language['description_main']						= '�� ���� �������� �� ������� ��������� ����� � ���������, �������� �������� ��������� � ������ ������.<br><a href="'.$config['urlpath'].'/index.php" target="_blank">����� �����, �� �������� �� ������� �������� ������ ��������� ������.</a>';
$language['description_users_add']					= '<p>����� �������� ������ ������������ � ���� ������, ������� ����� � ������ ��� ������������. ��� ������ ��������� ���������� <b>MD5</b>. ���� �� ��������� ������� ����� � �������� <b>�����������</b>, ����� � ���� �� �� ������� ������� ����� ������������ �� ������ ��������������.</p>';
$language['description_users_added']				= '������������ ��� ������� ��������.';
$language['description_users_delete']				= '����� ������� ������������, �������� ������ �� ������. ������������ � �������� <b>�����������</b> �� ����� ������.';
$language['description_users_deleted']				= '������������ ��� ������ �� ���� ������.';
$language['description_other_changelog']			= '�� ������ ������� ������ ��������� � ������ ������� 2.0.0 � ������ ��������� �� <a href="http://www.olate.com/scripts/Olate Download/changelog.php" target="_blank">�����</a> ������.';
$language['description_other_license']				= '������ �� ������� ��������� ��������� ������ �������. ���� ���������� ����� �������� �� �������.';
$language['description_other_mailinglist']			= '�� ������ �������� ���������� � ����� ������� ������� �� e-mail, ������������ �� <a href="http://www.olate.com/list/index.php" target="_blank">��������</a>.';
$language['description_users_master']				= '������������, �������� �� ��������� �������, ������� ��� <b>�����������</b>.';
$language['description_other_support']				= '<p>���� ������ ���������������� ���������. ���. ��������� �������� ������ �� <a href="http://www.olate.com/forums" target="_blank">������� </a>. ������� e-mail ���������. ��������� �������������� ������ �� ������������ ������ �������, �� ���� �� ���������������� � ��������� ����� � ����� ������.</p>';
$language['description_other_updates']				= '<p>������ ����� ��������� �������� �� ���������� �������.</p><p><strong>����� �������:</strong></p>';
$language['link_addcategory']						= '�������� ����� ���������';
$language['link_adddownload']						= '�������� ����� ����';
$language['link_adduser']							= '�������� ������ ������������';
$language['link_administration']					= '�����������������';
$language['link_adminmain']							= '��������� � �����������������';
$language['link_clicktologin']						= '���� � �������';
$language['link_deletecategory']					= '�������� ���������';
$language['link_deletedownload']					= '�������� ������';
$language['link_deleteuser']						= '�������� �������������';
$language['link_editcategory']						= '�������������� ���������';
$language['link_editdownload']						= '�������������� ������';
$language['link_generalsettings']					= '�������� ���������';
$language['link_languages']							= '�����';
$language['link_languages_viewgenconfig']			= '���������� �������� ���������';
$language['link_languages_viewlangconfig']			= '���������� ��������� �����';
$language['link_license']							= '��������';
$language['link_logout']							= '�����';
$language['link_support']							= '���. ���������';
$language['link_updates']							= '����������';
$language['link_viewmain']							= '����� �� ������� ��������';
$language['title_admin']							= '�����������������';
$language['title_admin_main']						= '����������������� - ������� ��������';
$language['title_categories']						= '���������:';
$language['title_categories_add']					= ' - ��������� - ���������� ����� ���������';
$language['title_categories_delete']				= ' - ��������� - �������� ���������';
$language['title_categories_edit']					= ' - ��������� - �������������� ���������';
$language['title_categories_name']					= '��������:';
$language['title_config_general']					= ' - ������������ - �������� ���������';
$language['title_config_language']					= ' - ������������ - �����';
$language['title_config_language_available']		= '��������� ����� ��� �������';
$language['title_config_general_alldownloads']		= '���������� "��� �����":';
$language['title_config_general_displaytd']			= '���������� "��� ����������":';
$language['title_config_general_numbertd']			= '���������� � ����:';
$language['title_config_general_numberpage']		= '���������� ������ �� ��������:';
$language['title_config_general_path']				= '���� � �������:';
$language['title_config_general_ratings']			= '�������� �������:';
$language['title_config_general_searchlink']		= '���������� "�����":';
$language['title_config_general_sorting']			= '�������� ����������:';
$language['title_config_general_version']			= '������:';
$language['title_configuration']					= '������������';
$language['title_downloads']						= '�����:';
$language['title_downloads_add']					= ' - ����� - ���������� ������ �����';
$language['title_downloads_category']				= '���������:';
$language['title_downloads_custom1']				= '���� �� ������ 1:';
$language['title_downloads_custom2']				= '���� �� ������ 2:';
$language['title_downloads_custom_label']			= '�����:';
$language['title_downloads_custom_value']			= '��������:';
$language['title_downloads_date']					= '����:';
$language['title_downloads_delete']					= ' - ����� - �������� �����';
$language['title_downloads_description_b']			= '������� ��������:';
$language['title_downloads_description_f']			= '������ ��������:';
$language['title_downloads_edit']					= ' - ����� - �������������� �����';
$language['title_downloads_image']					= '����� ��������:';
$language['title_downloads_location']				= '����� �����:';
$language['title_downloads_name']					= '��������:';
$language['title_downloads_size']					= '������ �����:';
$language['title_master']							= '�����������:';
$language['title_other']							= '������:';
$language['title_users_add']						= ' - ������������ - ���������� ������ ������������';
$language['title_users_delete']						= ' - ����������� - �������� ������������';
$language['title_other_changelog']					= '������ ���������:';
$language['title_other_license']					= ' - ������ - ��������';
$language['title_other_mailinglist']				= '��������:';
$language['title_other_support']					= ' - ������ - ���. ���������';
$language['title_other_updates']					= ' - ������ - ����������';
$language['title_password']							= '������:';
$language['title_script']							= '������ ���������';
$language['title_users']							= '������������:';
$language['title_username']							= '�����:';
?>