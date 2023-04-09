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
*  $Id: lang_it.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

/* file di localizzazione di phpgraphy
*
* Perpiacere NON MODIFICARE questo file direttamente
* Puoi usarlo come riferimento per creare un file in un altro linguaggio,
* o per iniziare a creare il file nel tuo linguaggio,
* Per dettagli, guarda la Documentazione.
*
*/

$language_file_info = array(
    'language_name_english' => 'Italian',
    'language_name_native'  => 'Italiano',
    'country_code'          => 'it',
    'charset'               => 'iso-8859-1',
    'for_version'           => '0.9.10',
    'translator_name'       => 'croko',
    'translator_email'      => ''
    );

// Titolo del tuo sito
$txt_site_title="il mio sito phpGraphy";

// txt_root_dir: testo che specifica la cartella principale della tua galleria
$txt_root_dir="root";

// le seguenti variabili definiscono il testo usato per navigare nella galleria
// puoi cambiarle per soddisfare le tue esigenze e anche aggiungere immagini (http://tofz.org/ style)
// e.g: $txt_previous_page='<img src="/gfx/my_previous_image_button.gif">';

// Visione/Navigazione immagini/inteprima
$txt_files='file(s)';
$txt_dirs='cartella(e)';
$txt_last_commented="ultime immagini commentate";

// Votazione (se attivato)
$txt_no_rating="";
$txt_thumb_rating="voto :";
$txt_pic_rating="<br />Media voti : ";
$txt_option_rating="Vota questa immagine";

$txt_back_dir='^Su^';
$txt_previous_image='&lt;- Precedente';
$txt_next_image='Successiva -&gt;';
$txt_hires_image=' +Alta ris+ ';
$txt_lores_image=' -Bassa ris- ';

$txt_previous_page='&lt;- Pagina prec -| ';
$txt_next_page=' |- Pagina succ -&gt; ';

$txt_x_comments="commenti";

$txt_comments="Commenti :";
$txt_add_comment="Lascia un commento";
$txt_comment_from="Da: ";
$txt_comment_on=" per ";

// Pagina ultime immagini commentate
$txt_last_commented_title="Ultime ".$nb_last_commented." immagini commentate :";
$txt_comment_by="da";

// Pagina immagini più votate
$txt_top_rated_title="Immagini ".$nb_top_rating." più votate :";

$txt_go_back="Indietro";


// Menù amministrazione (stuff displayed when in admin mode are under the admin section)
$txt_login="entra";
$txt_logout="esci";
$txt_random_pic="immagini casuali";


// Pagine di inizio attività
$txt_login_form_login="utente:";
$txt_login_form_pass="pass:";


// Pagina per lasciare commenti
$txt_comment_form_name="Tuo nome:";
$txt_remember_me="(Ricordami)";
$txt_comment_form_comment="Tuo commento:";


// Sezione metadata (EXIF/IPTC)

/* $txt_[exif|iptc]_custom: Puoi personalizzare il modo in cui le informazioni sono mostrate,
* tutte le parole chiave sono fra '%' per informazioni su tutte le parole chiave supportate,
* Guarda la Documentazione per la lista completa delle parole chiave disponibili
*/
$txt_exif_custom="%Exif.Make% %Exif.Model%<br />%Exif.ExposureTime%s f/%Exif.FNumber% at %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso %Exif.ISO% %Exif.Flash%";
$txt_exif_missing_value="??";	// Se il campo EXIF richiesto non viene trovato, viene mostrato questo
$txt_exif_flash="con flash"; // Testo per il flash acceso

$txt_iptc_custom="%Iptc.City% by %Iptc.ByLine%";
$txt_iptc_missing_value="";	// Se il campo IPTC richiesto non viene trovato, viene mostrato questo

$txt_show_me_more="Mostrami altro";

/********************************************************************************
* Sezione AMMINISTRATORE
* Testo visualizzato solo quando sei registrato come amministratore
*********************************************************************************/

// Menu di controllo (testo amministratore)
$txt_create_dir="crea cartella";
$txt_upload="invia";
$txt_gen_all_pics="genera tutte le immagini";


// Visaulizzazione/Navigazione immagini/anteprima
$txt_description="Descrizione:";
$txt_sec_lev="Livello di sicurezza: ";
$txt_dir_sec_lev="Livello di sicurezza cartella: ";
$txt_inh_lev=" Precedente: ";
$txt_change="Cambia";
$txt_delete_photo="Cancella foto";
$txt_delete_photo_thumb="Rigenera anteprima";
$txt_delete_directory_icon="<img src=\"".$icons_dir."delete_cross.gif\" alt=\"[Cancella]\" border=0>";
$txt_delete_directory_text="Cancella cartella";
$txt_edit_welcome="<button>Modifica .welcome</button>";
$txt_del_comment="Cancella";

// Confirmation Box
$txt_ask_confirm="Sei sicuro ?";
$txt_delete_confirm="Sei sicuro di eliminarlo ?";


// Rotazione Immagine (se abilitato nella tuo file di configurazione)
$txt_rotate_90="<img src=\"".$icons_dir."rotate90.gif\" alt=\"Ruota di 90°\" border=0>";
$txt_rotate_180="<img src=\"".$icons_dir."rotate180.gif\" alt=\"Ruota di 180°\" border=0>";
$txt_rotate_270="<img src=\"".$icons_dir."rotate270.gif\" alt=\"Ruota di 270°\" border=0>";


// Pagina di modifica file .welcome
$txt_editing="Stai modificando";
$txt_in_directory="nella cartella";
$txt_save="Salva";
$txt_cancel="Cancella";
$txt_clear_all="Pulisci tutto";


// Pagina creazione cartella
$txt_dir_to_create="Cartella da creare:";


// Pagina caricamento file
$txt_current_dir="Cartella corrente :";
$txt_file_to_upload="File da Caricare:";
$txt_upload_file_from_user="Carica file dal tuo computer";
$txt_upload_file_from_url="Carica file da un URL";
$txt_upload_change = "Cambiando il numero dei campi dei file da caricare dovrai riselezionare i file che precedentemente avevi scelto. Si raccomanda di cancellare, caricare i file attuali e di scegliere un numero più alto la prossima volta.Vuoi ancora continuare?";

// Gestione utenti
$txt_user_management = 'gestione utenti';
$txt_add_user = 'Aggiungi utente';
$txt_back_user_list = 'Torna alla lista utenti\'';
$txt_confirm_del_user = 'Sei sicuro di voler eliminare questo utente ?';
$txt_user_info = 'Informazioni utenti';
$txt_login_rule = 'Specifica un nome utente superiore a 20 caratteri';
$txt_pass_rule = 'Specifica una password superiore a 32 caratteri';
$txt_sec_lvl_rule = 'Specifica il livello di sicurezza compreso fra 1 e 999';

$txt_um_login = 'Utente';
$txt_um_pass = 'Password';
$txt_um_sec_lvl = 'Livello di sicurezza';
$txt_um_edit = 'Modifica';
$txt_um_del = 'Cancella';

// Array messaggi d'errore

$txt_error=array(
        // 8xx is related to user management
        "00800" => "ERRORE:",
        "00801" => "Uid non impostato",
        "00802" => "Uid non numerico",
        "00803" => "Il nome utente può contenere da uno a 20 di questi caratteri 0-9 a-z @ - _",
        "00804" => "Nome utente non impostato",
        "00805" => "La password può contenere da 1 a 32 di questi caratteri 0-9 a-z @ - _ , . : ; ( ) ^ ? ! / + * & #",
        "00806" => "Password non impostata",
        "00807" => "Il livello di sicurezza dovrebbe essere un numero fra 1 a 999",
        "00808" => "Livello di sicurezza non impostato"
        );

?>
