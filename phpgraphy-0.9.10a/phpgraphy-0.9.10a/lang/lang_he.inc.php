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
*  $Id: lang_he.inc.php 39 2005-03-12 00:50:15Z jim $
*
*/

/* phpGraphy language file - Hebrew
*
* Please DO NOT MODIFY this file directly
* You can use it as reference to create a file in another language,
* or to start building your own custom language file,
* For details, see Documentation.
*
*/
$language_file_info = array(
    'language_name_english' => 'Hebrew',
    'language_name_native'  => 'עברית',
    'country_code'          => 'he',
    'charset'               => 'Windows-1255',
    'direction'             => 'rtl',
    'for_version'           => '0.9.10',
    'translator_name'       => 'Tom Sella',
    'translator_email'      => 'tsella [at] gmail [dot] com'
    );

// Title of your website
$txt_site_title="האתר שלי - phpGraphy";

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="כניסה";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files='קבצים';
$txt_dirs='ספריות';
$txt_last_commented=" תגובות שנוספו לאחרונה ";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="דרוג :";
$txt_pic_rating="<br />דרוג ממוצע : ";
$txt_option_rating="דרג תמונה זו";

$txt_back_dir='^ספריית אב^';
$txt_previous_image='&lt;- תמונה קודמת';
$txt_next_image='תמונה הבאה -&gt;';
$txt_hires_image=' +רזולוציה גבוהה+ ';
$txt_lores_image=' -רזולוזיה נמוכה- ';

$txt_previous_page='&lt;- דף תמונות קודם -| ';
$txt_next_page=' |- דף תמונות הבא -&gt; ';

$txt_x_comments="תגובות";

$txt_comments="תגובות :";
$txt_add_comment="הוסף תגובה";
$txt_comment_from="מאת: ";
$txt_comment_on=" בתאריך ";

// Last commented pictures page
$txt_last_commented_title=$nb_last_commented." התגובות האחרונות :";
$txt_comment_by="על ידי";

// Top rated pictures page
$txt_top_rated_title=$nb_top_rating." הציונים הגבוהים ביותר :";

$txt_go_back="חזור אחורה";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="התחבר";
$txt_logout="התנתק";
$txt_random_pic="תמונה אקראית";


// Login page
$txt_login_form_login="שם משתמש:";
$txt_login_form_pass="סיסמא:";


// Add comment page
$txt_comment_form_name="שם מלא:";
$txt_remember_me="זכור אותי";
$txt_comment_form_comment="תגובתך:";


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

$txt_show_me_more="הצג מידע נוסף";

/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="צור ספריה";
$txt_upload="העלאת תמונות";
$txt_gen_all_pics="צור כל הדוגמיות";


// Picture/Thumbs viewing/naviguation
$txt_description="תאור:";
$txt_sec_lev="רמת הרשאה: ";
$txt_dir_sec_lev="רמת הרשאת ספריה: ";
$txt_inh_lev=" מורשת: ";
$txt_change="שנה";
$txt_delete_photo="מחק תמונה";
$txt_delete_photo_thumb="צור דוגמית מחדש";
$txt_delete_directory="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[מחק]\" border=0>";
$txt_delete_directory_text="מחק ספריה";
$txt_edit_welcome="<button>ערוך קובץ .welcome</button>";
$txt_del_comment="מחק";

// Confirmation box
$txt_ask_confirm="האם אתה בטוח ?";
$txt_delete_confirm="האם למחוק ?";

// Image rotation (if available with your config)
$txt_rotate_90="<img src=\"".$icons_dir."rotate90.gif\" alt=\"סובב 90°\" border=0>";
$txt_rotate_180="<img src=\"".$icons_dir."rotate180.gif\" alt=\"סובב 180°\" border=0>";
$txt_rotate_270="<img src=\"".$icons_dir."rotate270.gif\" alt=\"סובב 270°\" border=0>";


// Editing the .welcome page
$txt_editing="עריכה";
$txt_in_directory="בספריה";
$txt_save="שמור";
$txt_cancel="בטל";
$txt_clear_all="נקה הכל";


// Directory creation page
$txt_dir_to_create="שם ספריה ליצירה:";


// File upload page
$txt_current_dir="ספריה נוכחית :";
$txt_file_to_upload="קובץ להעלאה:";
$txt_upload_file_from_user="העלה קובץ ממחשבך";
$txt_upload_file_from_url="העלה קובץ מאתר";
$txt_upload_change = "Changing the numbers of upload fields will require you to re-select all the files that you have previously choosen. It is recommend to Cancel, upload the actual files and choose a bigger number next time. Do you still want to continue ?";

// User management
$txt_user_management = 'נהול משתמשים';
$txt_add_user = 'הוסף משתמש';
$txt_back_user_list = 'חזור לרשימת משתמשים';
$txt_confirm_del_user = 'האם אתה בטוח ברצונך למחוק משתמש זה  ?';
$txt_user_info = 'פרטי משתמש';
$txt_login_rule = 'ציין שם משתמש באורך של עד 20 תוים';
$txt_pass_rule = 'ציין סיסמת משתמש באורך של עד 32 תוים';
$txt_sec_lvl_rule = 'ציין רמת הרשאת משתמש בין 1 ל-999';

$txt_um_login = 'שם משתמש';
$txt_um_pass = 'סיסמא';
$txt_um_sec_lvl = 'רמת הרשאה';
$txt_um_edit = 'ערוך';
$txt_um_del = 'מחק';

// Error msg array

$txt_error=array(
        // 8xx is related to user management
        "00800" => "שגיאה:",
        "00801" => "מזהה משתמש אינו מוגדר",
        "00802" => "מזהה משתמש אינו מספרי",
        "00803" => "על שם המשתמש להכיל 1 עד 20 תוים, מבין 0-9 a-z @ - _",
        "00804" => "שם משתמש אינו קיים",
        "00805" => "על סיסמת המשתמש להכיל 1 עד 32 תוים, מבין 0-9 a-z @ - _ , . : ; ( ) ^ ? ! / + * & #",
        "00806" => "סיסמא אינה מוגדרת",
        "00807" => "על רמת ההרשאה להיות מספר בין 1 עד 999",
        "00808" => "רמת הרשאה אינה מוגדרת"
        );

?>
