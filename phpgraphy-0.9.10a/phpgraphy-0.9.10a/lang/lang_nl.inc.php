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
* Gelieve enkel te wijzigen volgens de richtlijnen van de documentatie.
*
*/

$language_file_info = array(
    'language_name_english' => 'Dutch',
    'language_name_native'  => 'Nederlands',
    'country_code'          => 'nl',
    'charset'               => 'iso-8859-1',
    'for_version'           => '0.9.10',
    'translator_name'       => 'Floris Lambrechts',
    'translator_email'      => 'florisla _on_ gmail [dot] com'
    );

// Title of your website
$txt_site_title="mijn phpGraphy site";

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="start";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files='bestanden';
$txt_dirs='mappen';
$txt_last_commented="meest recente commentaar";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="beoordeling :";
$txt_pic_rating="<br />Gemiddelde beoordeling : ";
$txt_option_rating="Beoordeel deze afbeelding";

$txt_back_dir='^Omhoog^';
$txt_previous_image='&lt;- Vorige';
$txt_next_image='Volgende -&gt;';
$txt_hires_image=' +Hoge resolutie+ ';
$txt_lores_image=' -Lage resolutie- ';

$txt_previous_page='&lt;- Voriga pagina -| ';
$txt_next_page=' |- Volgende pagina -&gt; ';

$txt_x_comments="commentaar";

$txt_comments="Commentaar :";
$txt_add_comment="Voeg commentaar toe";
$txt_comment_from="Van: ";
$txt_comment_on=" op ";

// Last commented pictures page
$txt_last_commented_title="Maaest ".$nb_last_commented." commented pictures :";
$txt_comment_by="by";

// Top rated pictures page
$txt_top_rated_title="Laatste ".$nb_top_rating." beoordeelde afbeeldingen :";

$txt_go_back="Keer terug";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="login";
$txt_logout="logout";
$txt_random_pic="willekeurige afbeelding";


// Login page
$txt_login_form_login="login:";
$txt_login_form_pass="paswoord:";


// Add comment page
$txt_comment_form_name="Uw naam:";
$txt_remember_me="(Onthoud mij)";
$txt_comment_form_comment="Uw commentaar:";


// metadata section (EXIF/IPTC)

/* $txt_[exif|iptc]_custom: You can customize the way informations are displayed,
* all keywords are between '%' for a reference of all supported keywords,
* See Documentation for the complete list of available keywords
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br />%Exif.ExposureTime%s f/%Exif.FNumber% op %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso %Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// If EXIF requested field is not found, display this instead
$txt_exif_flash="met flits"; // Test to display if flash was fired

$txt_iptc_custom="%Iptc.City% door %Iptc.ByLine%";
$txt_iptc_missing_value="";	// If IPTC requested field not found, display that instead

$txt_show_me_more="Toon meer";

/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="maak map";
$txt_upload="upload";
$txt_gen_all_pics="genereer alle afbeeldingen";


// Picture/Thumbs viewing/naviguation
$txt_description="Beschrijving:";
$txt_sec_lev="Beveiligings niveau: ";
$txt_dir_sec_lev="Map beveiligings niveau: ";
$txt_inh_lev=" Overgeërfd: ";
$txt_change="Wijzig";
$txt_delete_photo="Verwijder afbeelding";
$txt_delete_photo_thumb="Vervang thumbnail";
$txt_delete_directory_icon="<img src=\"".$config['icons_dir']."delete_cross.gif\" alt=\"[Verwijder]\" border=0>";
$txt_delete_directory_text="Verwijder map";
$txt_edit_welcome="<button>Bewerk welkomstbericht</button>";
$txt_del_comment="Verwijder";

// Confirmation box
$txt_ask_confirm="Bent u zeker?";
$txt_delete_confirm="Ben u zeker van het verwijderen?";

// Image rotation (if available with your config)
$txt_rotate_90="<img src=\"".$config['icons_dir']."rotate90.gif\" alt=\"Draai 90°\" border=0>";
$txt_rotate_180="<img src=\"".$config['icons_dir']."rotate180.gif\" alt=\"Draai 180°\" border=0>";
$txt_rotate_270="<img src=\"".$config['icons_dir']."rotate270.gif\" alt=\"Draai 270°\" border=0>";


// Editing the .welcome page
$txt_editing="Bewerken";
$txt_in_directory="in map";
$txt_save="Opslaan";
$txt_cancel="Annuleren";
$txt_clear_all="Alles wissen";


// Directory creation page
$txt_dir_to_create="Map om aan te maken:";


// File upload page
$txt_current_dir="Huidige map :";
$txt_file_to_upload="Bestanden op te uploaden:";
$txt_upload_file_from_user="Bestanden uploaden vanaf uw computer";
$txt_upload_file_from_url="Upload een bestand van een URL";
$txt_upload_change = "Na een wijzigen van het aantal, zult u alle reeds geselecteerde bestanden opnieuw moeten selecteren. U wordt aangeraden om te annuleren, door te gaan met het uploaden en volgende keer te beginnen met een groter aantal.  Wilt u nog steeds doorgaan?";

// User management
$txt_user_management = 'beheer gebruikers';
$txt_add_user = 'Gebruiker toevoegen';
$txt_back_user_list = 'Terug naar de gebruikerslijst';
$txt_confirm_del_user = 'Ben u zeker dat u deze gebruiker wilt verwijderen?';
$txt_user_info = 'Gebruikers informatie';
$txt_login_rule = 'Geef een login naam van maximaal 20 tekens';
$txt_pass_rule = 'Geef een paswoord van maximaal 32 tekens';
$txt_sec_lvl_rule = 'Geef een beveiligings niveau tussen 1 en 999';

$txt_um_login = 'Login';
$txt_um_pass = 'Paswoord';
$txt_um_sec_lvl = 'Beveiligings niveau';
$txt_um_edit = 'Bewerk';
$txt_um_del = 'Verwijder';

// Error msg array

$txt_error=array(
        // 8xx is related to user management
        "00800" => "ERROR:",
        "00801" => "Uid is niet gezet",
        "00802" => "Uid is niet numeriek",
        "00803" => "Login moet 1 tot 20 van de volgende tekens bevatten: 0-9 a-z @ - _",
        "00804" => "Login is niet gezet",
        "00805" => "Paswoord moet 1 tot 32 van de volgende tekens bevatten: 0-9 a-z @ - _ , . : ; ( ) ^ ? ! / + * & #",
        "00806" => "Paswoord is niet gezet",
        "00807" => "Beveiligings niveau moet een getal zijn tussen 1 en 999",
        "00808" => "Beveiligings niveau is niet gezet"
        );

?>
