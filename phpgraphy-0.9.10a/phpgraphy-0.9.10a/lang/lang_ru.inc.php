<?php

/*
*  Copyright (C) 2004-2005 JiM / aEGIS (jim@aegis-corp.org)
*  Copyright (C) 2000-2001 Christophe Thibault
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
*  $Id: lang_ru.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

/* phpGraphy language file
* 
* Please DO NOT MODIFY this file directly
* You can use it as reference to create a file in another language,
* or to start building your own custom language file,
* for details, see Documentation.
*
*/

$language_file_info = array(
    'language_name_english' => 'Russian',
    'language_name_native'  => '',
    'country_code'          => 'ru',
    'charset'               => 'windows-1251',
    'for_version'           => '0.9.9',
    'translator_name'       => 'Max',
    'translator_email'      => 'maxutin [at] gmail [dot] com'
    );

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="�������";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files = '������';
$txt_dirs = decldir(array("dir", "dirs", "dirssss"));
$txt_last_commented="��������� ����������� � ������������";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="������� :";
$txt_pic_rating="<br>������� ������ : ";
$txt_option_rating="������� ��� ��������";

$txt_back_dir='|  ^����^  ||';
$txt_previous_image='<- ���������� -|';
$txt_next_image='|- ��������� ->';
$txt_hires_image='||  +��������+  |';
$txt_lores_image='||  -���������-  |';

$txt_previous_page='<- ���������� �������� -| ';
$txt_next_page=' |- ��������� �������� -> ';

$txt_x_comments="�����������";

$txt_comments="����������� :";
$txt_add_comment="�������� ����������:";
$txt_comment_from="��: ";
$txt_comment_on=" on ";

// Last commented pictures page
$txt_last_commented_title="��������� ".$nb_last_commented." ����������� � ������������:";
$txt_comment_by="��";

// Top rated pictures page
$txt_top_rated_title=" ".$nb_top_rating." �������� ������ ����������� ����������� :";

$txt_go_back="�����";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="����";
$txt_logout="�����";
$txt_random_pic="����� ����";


// Login page
$txt_login_form_login="���:";
$txt_login_form_pass="������:";


// Add comment page
$txt_comment_form_name="���� ���:";
$txt_remember_me="(��������� ����)";
$txt_comment_form_comment="��� �����������:";


// metadata section (EXIF/IPTC)

/* $txt_[exif|iptc]_custom: You can customize the way informations are displayed,
* all keywords are between '%' for a reference of all supported keywords,
* See Documentation for the complete list of available keywords
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br>%Exif.ExposureTime%s f/%Exif.FNumber% at %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso %Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// If EXIF requested field is not found, display this instead
$txt_exif_flash="with flash"; // Test to display if flash was fired

$txt_iptc_custom="%Iptc.City% by %Iptc.ByLine%";
$txt_iptc_missing_value="";	// If IPTC requested field not found, display that instead

$txt_show_me_more="������ ����������";

/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="������� �����";
$txt_upload="��������";
$txt_gen_all_pics="���������� ��� ����";


// Picture/Thumbs viewing/naviguation
$txt_description="��������:";
$txt_sec_lev="������� ������������: ";
$txt_dir_sec_lev="������� ������������ �����: ";
$txt_inh_lev=" ����������� �������: ";
$txt_change="��������";
$txt_delete_photo="������� ����";
$txt_delete_photo_thumb="�������� ";
$txt_delete_directory="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[�������]\" border=0>";
$txt_edit_welcome="<button>������� .welcome</button>";


// Editing the .welcome page
$txt_editing="�� ������� ����";
$txt_in_directory="� �����";
$txt_save="���������";
$txt_cancel="��������";
$txt_clear_all="�������� ��";


// Directory creation page
$txt_dir_to_create="��� ����� �����:";


// File upload page
$txt_current_dir="������� ���������� :";
$txt_file_to_upload="���� ��� �������� :";
$txt_upload_file_from_user="�������� ����� � ������ ����������";
$txt_upload_file_from_url="�������� ����� �� ���������";


//Corect declension of dirs quantity on russian
function decldir($expressions)
{ 
    settype($int, "integer"); 
    $nb_dirs = $int % 100; 
    if ($nb_dirs >= 5 && $nb_dirs <= 20) { 
        $result = $int." ".$expressions['2']; 
    } else { 
        $nb_dirs = $nb_dirs % 10; 
        if ($nb_dirs == 1) { 
            $result = $int." ".$expressions['0']; 
        } elseif ($nb_dirs >= 2 && $nb_dirs <= 4) { 
            $result = $int." ".$expressions['1']; 
        } else { 
            $result = $int." ".$expressions['2']; 
        } 
    } 
    return $result; 
}

?>
