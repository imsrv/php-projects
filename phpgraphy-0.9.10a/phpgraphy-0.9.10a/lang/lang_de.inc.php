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
*  $Id: lang_de.inc.php 130 2005-07-03 13:00:46Z jim $
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
    'language_name_english' => 'German',
    'language_name_native'  => 'Deutsch',
    'country_code'          => 'de',
    'charset'               => 'iso-8859-1',
    'for_version'           => '0.9.9',
    'translator_name'       => 'Heiko Behrens',
    'translator_email'      => 'heiko [dot] behrens [at] web [dot] de'
    );

// Title of your website
$txt_site_title="mein phpGraphy site";

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="Startordner";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files='Datei(en)';
$txt_dirs='Ordner';
$txt_last_commented="zuletzt kommentierte Bilder";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="Bewertung:";
$txt_pic_rating="<br />Durchschnittsbewertung: ";
$txt_option_rating="dieses Bild bewerten";

$txt_back_dir='^nach oben^';
$txt_previous_image='<- vorheriges';
$txt_next_image='n&auml;chstes ->';
$txt_hires_image=' +hohe Aufl&ouml;sung+ ';
$txt_lores_image=' -niedrige Aufl&ouml;sung- ';

$txt_previous_page='<- vorherige Seite -| ';
$txt_next_page=' |- n&auml;chste Seite -> ';

$txt_x_comments="Kommentar(e)";

$txt_comments="Kommentar:";
$txt_add_comment="Kommentar hinzuf&uuml;gen";
$txt_comment_from="Von: ";
$txt_comment_on=" &uuml;ber ";

// Last commented pictures page
$txt_last_commented_title="Die ".$nb_last_commented." zuletzt kommentierten Bilder:";
$txt_comment_by="von";

// Top rated pictures page
$txt_top_rated_title="Die ".$nb_top_rating." am besten bewerteten Bilder:";

$txt_go_back="zur&uuml;ck";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="Anmelden";
$txt_logout="Abmelden";
$txt_random_pic="Zufallsbild";


// Login page
$txt_login_form_login="Benutzer:";
$txt_login_form_pass="Passwort:";


// Add comment page
$txt_comment_form_name="Ihr Name:";
$txt_remember_me="(Namen speichern)";
$txt_comment_form_comment="Ihr Kommentar:";


// metadata section (EXIF/IPTC)

/* $txt_[exif|iptc]_custom: You can customize the way informations are displayed,
* all keywords are between '%' for a reference of all supported keywords,
* See Documentation for the complete list of available keywords
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br />%Exif.ExposureTime%s f/%Exif.FNumber% bei %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso %Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// If EXIF requested field is not found, display this instead
$txt_exif_flash="mit Blitz"; // Test to display if flash was fired

$txt_iptc_custom="%Iptc.City% bei %Iptc.ByLine%";
$txt_iptc_missing_value="";	// If IPTC requested field not found, display that instead

$txt_show_me_more="mehr Infos";

/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="Ordner erstellen";
$txt_upload="hochladen";
$txt_gen_all_pics="Vorschaubilder generieren";


// Picture/Thumbs viewing/naviguation
$txt_description="Beschreibung: ";
$txt_sec_lev="Sicherheitslevel: ";
$txt_dir_sec_lev="Ordner-Sicherheitslevel: ";
$txt_inh_lev=" Vererbt: ";
$txt_change="&Auml;ndern";
$txt_delete_photo="Bild l&ouml;schen";
$txt_delete_photo_thumb="Vorschaubild neu erstellen";
$txt_delete_directory="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[l&ouml;schen]\" border=0>";
$txt_edit_welcome="<button>Bearbeite .welcome</button>";


// Editing the .welcome page
$txt_editing="Bearbeiten";
$txt_in_directory="im Ordner";
$txt_save="Speichern";
$txt_cancel="Abbrechen";
$txt_clear_all="alles l&ouml;schen";


// Directory creation page
$txt_dir_to_create="zu erstellender Ordner:";


// File upload page
$txt_current_dir="aktueller Ordner:";
$txt_file_to_upload="hochzuladende Datei:";
$txt_upload_file_from_user="hochladen vom eigenen Rechner";
$txt_upload_file_from_url="hochladen von einer URL";

?>
