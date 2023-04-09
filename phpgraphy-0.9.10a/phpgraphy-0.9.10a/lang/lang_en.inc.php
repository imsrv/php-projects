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
*  $Id: lang_en.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

/* phpGraphy language file
*
* Please DO NOT MODIFY this file directly
* You can use it as reference to create a file in another language,
* or to start building your own custom language file,
* For details, see Documentation.
*
*/

$language_file_info = array(
    'language_name_english' => 'English',
    'language_name_native'  => 'English',
    'country_code'          => 'en',
    'charset'               => 'iso-8859-1',
    'for_version'           => '0.9.10',
    'translator_name'       => 'phpGraphy Dev Team',
    'translator_email'      => 'phpgraphy [dash] devteam [at] lists [dot] sourceforge [dot] net'
    );

// Title of your website
$txt_site_title="my phpGraphy site";

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="root";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files='file(s)';
$txt_dirs='dir(s)';
$txt_last_commented="last commented pictures";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="rating :";
$txt_pic_rating="<br />Average rating : ";
$txt_option_rating="Rate this pic";

$txt_back_dir='^Up^';
$txt_previous_image='&lt;- Previous';
$txt_next_image='Next -&gt;';
$txt_hires_image=' +High res+ ';
$txt_lores_image=' -Low res- ';

$txt_previous_page='&lt;- Previous page -| ';
$txt_next_page=' |- Next page -&gt; ';

$txt_x_comments="comment(s)";

$txt_comments="Comments :";
$txt_add_comment="Add comment";
$txt_comment_from="From: ";
$txt_comment_on=" on ";

// Last commented pictures page
$txt_last_commented_title="Last ".$nb_last_commented." commented pictures :";
$txt_comment_by="by";

// Top rated pictures page
$txt_top_rated_title="Top ".$nb_top_rating." rated pictures :";

$txt_go_back="Go back";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="login";
$txt_logout="logout";
$txt_random_pic="random pic";


// Login page
$txt_login_form_login="login:";
$txt_login_form_pass="pass:";


// Add comment page
$txt_comment_form_name="Your name:";
$txt_remember_me="(Remember me)";
$txt_comment_form_comment="Your comment:";


// metadata section (EXIF/IPTC)

/* $txt_[exif|iptc]_custom: You can customize the way informations are displayed,
* all keywords are between '%' for a reference of all supported keywords,
* See Documentation for the complete list of available keywords
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br />%Exif.ExposureTime%s f/%Exif.FNumber% at %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso %Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// If EXIF requested field is not found, display this instead
$txt_exif_flash="with flash"; // Test to display if flash was fired

$txt_iptc_custom="%Iptc.City% by %Iptc.ByLine%";
$txt_iptc_missing_value="";	// If IPTC requested field not found, display that instead

$txt_show_me_more="Show me more";

/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="create dir";
$txt_upload="upload";
$txt_gen_all_pics="gen all pics";


// Picture/Thumbs viewing/naviguation
$txt_description="Description:";
$txt_sec_lev="Security level: ";
$txt_dir_sec_lev="Directory security level: ";
$txt_inh_lev=" Inherited: ";
$txt_change="Change";
$txt_delete_photo="Delete photo";
$txt_delete_photo_thumb="Regen thumb";
$txt_delete_directory_icon="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[Delete]\" border=0>";
$txt_delete_directory_text="Delete directory";
$txt_edit_welcome="<button>Edit .welcome</button>";
$txt_del_comment="Delete";

// Confirmation box
$txt_ask_confirm="Are you sure ?";
$txt_delete_confirm="Are you sure to delete ?";

// Image rotation (if available with your config)
$txt_rotate_90="<img src=\"".$icons_dir."rotate90.gif\" alt=\"Rotate 90°\" border=0>";
$txt_rotate_180="<img src=\"".$icons_dir."rotate180.gif\" alt=\"Rotate 180°\" border=0>";
$txt_rotate_270="<img src=\"".$icons_dir."rotate270.gif\" alt=\"Rotate 270°\" border=0>";


// Editing the .welcome page
$txt_editing="Editing";
$txt_in_directory="in directory";
$txt_save="Save";
$txt_cancel="Cancel";
$txt_clear_all="Clear all";


// Directory creation page
$txt_dir_to_create="Directory to create:";


// File upload page
$txt_current_dir="Current directory :";
$txt_file_to_upload="File(s) to Upload:";
$txt_upload_file_from_user="Upload file(s) from your computer";
$txt_upload_file_from_url="Upload a file from an URL";
$txt_upload_change = "Changing the numbers of upload fields will require you to re-select all the files that you have previously choosen. It is recommend to Cancel, upload the actual files and choose a bigger number next time. Do you still want to continue ?";

// User management
$txt_user_management = 'manage users';
$txt_add_user = 'Add user';
$txt_back_user_list = 'Back to the user\' list';
$txt_confirm_del_user = 'Are you sure to delete this user  ?';
$txt_user_info = 'User information';
$txt_login_rule = 'Specify a login up to 20 characters';
$txt_pass_rule = 'Specify a password up to 32 characters';
$txt_sec_lvl_rule = 'Specify a security level between 1 and 999';

$txt_um_login = 'Login';
$txt_um_pass = 'Password';
$txt_um_sec_lvl = 'Security level';
$txt_um_edit = 'Edit';
$txt_um_del = 'Delete';

// Error msg array

$txt_error=array(
        // 8xx is related to user management
        "00800" => "ERROR:",
        "00801" => "Uid is not set",
        "00802" => "Uid is non numeric",
        "00803" => "Login should contain from 1 to 20 of this character 0-9 a-z @ - _",
        "00804" => "Login is not set",
        "00805" => "Password should contain from 1 to 32 of this character 0-9 a-z @ - _ , . : ; ( ) ^ ? ! / + * & #",
        "00806" => "Password is not set",
        "00807" => "Security level should be a number between 1 and 999",
        "00808" => "Security level not set"
        );

?>
