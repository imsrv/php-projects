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
*  $Id: lang_fr.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

/* phpGraphy language file
*  Si vous souhaitez apporter des modifications, merci de le faire en suivant
*  les recommendations du manuel. (En créeant un fichier lang_cust.inc.php)
*/ 

$language_file_info = array(
    'language_name_english' => 'French',
    'language_name_native'  => 'Français',
    'country_code'          => 'fr',
    'charset'               => 'iso-8859-1',
    'for_version'           => '0.9.10',
    'translator_name'       => 'phpGraphy Dev Team',
    'translator_email'      => 'phpgraphy [dash] devteam [at] lists [dot] sourceforge [dot] net'
    );

// Title of your website
$txt_site_title="mon site phpGraphy";

// txt_root_dir: text that specify the root of your gallery
$txt_root_dir="Index";

// the following variables defines the text used for navigating the gallery
// you can change them to fit your needs and also use images (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Picture/Thumbs viewing/naviguation
$txt_files='fichier(s)';
$txt_dirs='rep(s)';
$txt_last_commented="dernières images commentées";

// Rating (if activated)
$txt_no_rating="";
$txt_thumb_rating="note :";
$txt_pic_rating="<br />Note moyenne : ";
$txt_option_rating="Noter cette image";

$txt_back_dir='^Haut^';
$txt_previous_page='<- Page précédente -| ';
$txt_next_page=' |- Page suivante -> ';
$txt_hires_image=' +Haute résolution+ ';
$txt_lores_image=' -Basse résolution- ';

$txt_previous_image='<- Précédente';
$txt_next_image='Suivante ->';

$txt_x_comments="commentaire(s)";

$txt_comments="Commentaires :";
$txt_add_comment="Ajouter un commentaire";
$txt_comment_from="De: ";
$txt_comment_on=" le ";

// Last commented pictures page
$txt_last_commented_title="Les dernières images commentées";
$txt_comment_by="par";

// Top rated pictures page
$txt_top_rated_title="Les ".$nb_top_rating." images les mieux notées :";

$txt_go_back="Page précédente";


// Top Right Menu (stuff displayed when in admin mode are under the admin section)
$txt_login="s'authentifier";
$txt_logout="se déconnecter";
$txt_random_pic="image aléatoire";


// Login page
$txt_login_form_login="Utilisateur:";
$txt_login_form_pass="Mot de passe:";


// Add comment page
$txt_comment_form_name="Votre nom:";
$txt_remember_me="(Mémoriser mon nom)";
$txt_comment_form_comment="Votre commentaire:";

/* $txt_[exif|iptc]_custom: You can customize the way informations are displayed,
* all keywords are between '%' for a reference of all supported keywords,
* open the functions_metadata.inc.php and read get_exif_ref()/get_iptc_ref()
* TODO: Include a reference in docs/ and on the website
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br />%Exif.ExposureTime%s f/%Exif.FNumber% at %Exif.FocalLength%mm (équivalent 35mm: %Exif.FocalLengthIn35mmFilm%mm) iso%Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// If EXIF requested field is not found, display this instead
$txt_exif_flash="avec flash"; // Test to display if flash was fired

$txt_iptc_custom="%Iptc.City% par %Iptc.ByLine%";
$txt_iptc_missing_value="";	// If IPTC requested field not found, display that instead

$txt_show_me_more="Plus d'infos";


/********************************************************************************
* ADMIN Section
* Text only displayed once you're loggued in as an admin
* So if you, the admin, speak english, you probably won't need to translate this
*********************************************************************************/

// Top right menu (admin text)
$txt_create_dir="créer un répertoire";
$txt_upload="envoyer un fichier";
$txt_gen_all_pics="générer les vignettes";

// Picture/Thumbs viewing/naviguation
$txt_description="Description:";
$txt_sec_lev="Niveau de securité: ";
$txt_dir_sec_lev="Niveau de securit&eacute; du r&eacute;pertoire: ";
$txt_inh_lev=" H&eacute;rit&eacute;: ";
$txt_change="Changer";
$txt_delete_photo="Supprimer la photo";
$txt_delete_photo_thumb="Reg&eacute;n&eacute;rer les vignettes";
$txt_delete_directory_icon="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[Supprimer]\" border=0>";
$txt_delete_directory_text="Supprimer le r&eacute;pertoire";
$txt_edit_welcome="<button>Editer le .welcome</button>";
$txt_del_comment="Supprimer";

// Confirmation box
$txt_ask_confirm="Confirmer ?";
$txt_delete_confirm="Confirmer la suppression ?";


// Editing the .welcome page
$txt_editing="Edition de";
$txt_in_directory="dans le répertoire";
$txt_save="Sauvegarder";
$txt_cancel="Annuler";
$txt_clear_all="Effacer tout";
// Directory creation page
$txt_dir_to_create="R&eacute;pertoire à cr&eacute;er:";


// Image rotation (if available with your config)
$txt_rotate_90="<img src=\"".$icons_dir."rotate90.gif\" alt=\"Rotatation 90°\" border=0>";
$txt_rotate_180="<img src=\"".$icons_dir."rotate180.gif\" alt=\"Rotatation 180°\" border=0>";
$txt_rotate_270="<img src=\"".$icons_dir."rotate270.gif\" alt=\"Rotatation 270°\" border=0>";


// File upload page
$txt_current_dir="Répertoire courant:";
$txt_file_to_upload="Fichier à envoyer:";
$txt_upload_file_from_user="Envoyer un fichier depuis votre ordinateur";
$txt_upload_file_from_url="Copier un fichier depuis une URL";
$txt_upload_change = "En changeant le nombre de fichiers a uploader simultanement, vous allez perdre tous les fichiers deja selectionnes. Il est recommande d'annuler, envoyer les fichiers actuellements selectionnes et changer le nombre la fois d'apres. Etes vous sur de vouloir continuer ?";

// User management
$txt_user_management = 'gestion utilisateurs';
$txt_add_user = 'Ajouter un utilisateur';
$txt_back_user_list = 'Retour &agrave; la liste';
$txt_confirm_del_user = 'Voulez vous vraiment effacer cet utilisateur  ?';
$txt_user_info = 'Information utilisateur';
$txt_login_rule = 'Saisir un login';
$txt_pass_rule = 'Saisir un mot de passe';
$txt_sec_lvl_rule = 'Pr&eacute;ciser un niveau de s&eacute;curit&eacute; entre 1 et 999';

$txt_um_login = 'Identifiant';
$txt_um_pass = 'Mot de passe';
$txt_um_sec_lvl = 'Niveau de s&eacute;curit&eacute;';
$txt_um_edit = 'Editer';
$txt_um_del = 'Effacer';

$txt_error=array(
    // 8xx is related to user management
        "00800" => "ERROR:",
        "00801" => "Uid inexistant",
        "00802" => "Uid non num&eacute;rique",
        "00803" => "L\'identifiant doit contenir entre 1 et 20 de ces caract&egrave;res  0-9 a-z @ - _",
        "00804" => "Identifiant inexistant",
        "00805" => "Le mot de passe doit contenir entre  1 et 32 de ces caract&egrave;res 0-9 a-z @ - _ , . : ; ( ) ^ ? ! / + * & #",
        "00806" => "Mot de passe inexistant",
        "00807" => "Pr&eacute;ciser un niveau de s&eacute;curit&eacute; entre 1 et 999",
        "00808" => "Niveau de s&eacute;curit&eacute; inexistant"
        );

?>
