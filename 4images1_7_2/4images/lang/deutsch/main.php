<?php
/**************************************************************************
 *                                                                        *
 *    4images - A Web Based Image Gallery Management System               *
 *    ----------------------------------------------------------------    *
 *                                                                        *
 *             File: main.php                                             *
 *        Copyright: (C) 2002 Jan Sorgalla                                *
 *            Email: jan@4homepages.de                                    *
 *              Web: http://www.4homepages.de                             *
 *    Scriptversion: 1.7.2                                                *
 *                                                                        *
 *    Never released without support from: Nicky (http://www.nicky.net)   *
 *                                                                        *
 **************************************************************************
 *                                                                        *
 *    Dieses Script ist KEINE Freeware. Bitte lesen Sie die Lizenz-       *
 *    bedingungen (Lizenz.txt) f�r weitere Informationen.                 *
 *    ---------------------------------------------------------------     *
 *    This script is NOT freeware! Please read the Copyright Notice       *
 *    (Licence.txt) for further information.                              *
 *                                                                        *
 *************************************************************************/

$lang['no_settings'] = "FEHLER: Die Konfigurations-Einstellungen konnten nicht geladen werden!";

//-----------------------------------------------------
//--- Templates ---------------------------------------
//-----------------------------------------------------
$lang['charset'] = "iso-8859-1";
$lang['direction'] = "ltr";

//-----------------------------------------------------
//--- Userlevel ---------------------------------------
//-----------------------------------------------------
$lang['userlevel_admin'] = "Administrator";
$lang['userlevel_user'] = "Member";
$lang['userlevel_guest'] = "Gast";

//-----------------------------------------------------
//--- Categories --------------------------------------
//-----------------------------------------------------
$lang['no_categories'] = "Es wurden noch keine Kategorien eingerichtet.";
$lang['no_images'] = "In dieser Kategorie sind keine Bilder vorhanden.";
$lang['select_category'] = "Kategorie w�hlen";

//-----------------------------------------------------
//--- Comments ----------------------------------------
//-----------------------------------------------------
$lang['name_required'] = "Das Feld Name muss ausgef�llt werden!";
$lang['headline_required'] = "Das Feld �berschrift muss ausgef�llt werden!";
$lang['comment_required'] = "Das Feld Kommentar muss ausgef�llt werden!";
$lang['spamming'] = "Sie k�nnen nicht so kurz nach Ihrem letzten Beitrag erneut posten. Bitte versuchen Sie es sp�ter wieder.";
$lang['comments'] = "Kommentare:";
$lang['no_comments'] = "Es wurden noch keine Kommentare abgegeben.";
$lang['comments_deactivated'] = "Kommentarfunktion deaktiviert!";
$lang['post_comment'] = "Kommentar posten";

//-----------------------------------------------------
//--- BBCode ------------------------------------------
//-----------------------------------------------------
$lang['bbcode'] = "BBCode";
$lang['tag_prompt'] = "Zu formatierenden Text eingeben:";
$lang['link_text_prompt'] = "Beschreibungstext f�r den Link eingeben (optional)";
$lang['link_url_prompt'] = "Komplette URL f�r den Link eingeben";
$lang['link_email_prompt'] = "Email-Adresse f�r den Link eingeben";
$lang['list_type_prompt'] = "Welcher Art soll die Liste sein? '1' f�r eine numerierte Liste, 'a' f�r eine alphabetische Liste oder leer lassen, f�r eine ungeordnete Liste.";
$lang['list_item_prompt'] = "Einen Listen Eintrag eingeben. Feld leer lassen oder 'Cancel' dr�cken, um die Listenerstellung zu beenden.";

//-----------------------------------------------------
//--- Image Details -----------------------------------
//-----------------------------------------------------
$lang['download_error'] = "Fehler beim Download der Bild-Datei!";
$lang['register_download'] = "Um Bilder downloaden zu k�nnen, m�ssen Sie registrierter Benutzer sein.<br />&raquo; <a href=\"{url_register}\">Jetzt registrieren</a>";
$lang['voting_success'] = "Ihre Bewertung wurde gespeichert";
$lang['voting_error'] = "Bewertung ung�ltig!";
$lang['already_voted'] = "Sie haben dieses Bild bereits bewertet!";
$lang['prev_image'] = "Vorheriges Bild:";
$lang['next_image'] = "N�chstes Bild:";
$lang['category'] = "Kategorie:";
$lang['description'] = "Beschreibung:";
$lang['keywords'] = "Schl�sselw&ouml;rter:";
$lang['date'] = "Datum:";
$lang['hits'] = "Hits:";
$lang['downloads'] = "Downloads:";
$lang['rating'] = "Bewertung:";
$lang['votes'] = "Stimme(n)";
$lang['file_size'] = "Dateigr&ouml;&szlig;e:";
$lang['author'] = "Autor:";
$lang['name'] = "Name:";
$lang['headline'] = "�berschrift:";
$lang['comment'] = "Kommentar:";
$lang['added_by'] = "Hinzugef�gt von:";
$lang['allow_comments'] = "Kommentare erlauben:";

// IPTC Tags
$lang['iptc_caption'] = "Caption:"; 
$lang['iptc_caption_writer'] = "Caption writer:";
$lang['iptc_headline'] = "Headline:";
$lang['iptc_special_instructions'] = "Special instructions:";
$lang['iptc_byline'] = "Byline:";
$lang['iptc_byline_title'] = "Byline title:";
$lang['iptc_credit'] = "Credit:";
$lang['iptc_source'] = "Source:";
$lang['iptc_object_name'] = "Object name:";
$lang['iptc_date_created'] = "Date created:";
$lang['iptc_city'] = "City:";
$lang['iptc_state'] = "State:";
$lang['iptc_country'] = "Country:";
$lang['iptc_original_transmission_reference'] = "Original transmission reference:";
$lang['iptc_category'] = "Category:";
$lang['iptc_supplemental_category'] = "Supplemental category:";
$lang['iptc_keyword'] = "Keywords:";
$lang['iptc_copyright_notice'] = "Copyright Notice:";

//-----------------------------------------------------
//--- Postcards ---------------------------------------
//-----------------------------------------------------
$lang['send_postcard'] = "eCard versenden";
$lang['edit_postcard'] = "eCard bearbeiten";
$lang['preview_postcard'] = "eCard Vorschau";
$lang['bg_color'] = "Hintergrundfarbe:";
$lang['border_color'] = "Randfarbe:";
$lang['font_color'] = "Schriftfarbe:";
$lang['font_face'] = "Schriftart:";
$lang['recipient'] = "Empf�nger";
$lang['sender'] = "Absender";
$lang['send_postcard_emailsubject'] = "Eine Postkarte f�r Sie!";
$lang['send_postcard_success'] = "Viele Dank! Ihre eCard wurde erfolgreich versendet.";
$lang['back_to_gallery'] = "Zur�ck zur Galerie";
$lang['invalid_postcard_id'] = "Es existiert keine Postkarte mit dieser ID.";

//-----------------------------------------------------
//--- Top Images --------------------------------------
//-----------------------------------------------------
$lang['top_image_hits'] = "Die 10 Bilder mit den meisten Hits";
$lang['top_image_downloads'] = "10 Bilder mit den meisten Downloads";
$lang['top_image_rating'] = "10 Bilder mit der h�chsten Bewertung";
$lang['top_image_votes'] = "10 Bilder mit den meisten Bewertungen";

//-----------------------------------------------------
//--- Users -------------------------------------------
//-----------------------------------------------------
$lang['send_password_emailsubject'] = "Passwortanforderung bei {site_name}";  // Subject f�r Email bei Passwortanforderung
$lang['update_email_emailsubject'] = "Email�nderung bei {site_name}";         // Subject f�r Email mit Aktivierungs-Link bei ge�nderter Email Adresse
$lang['register_success_emailsubject'] = "Registrierung bei {site_name}";     // Subject f�r Email mit Aktivierungs-Link
$lang['admin_activation_emailsubject'] = "Account Aktivierung";               // Subject f�r Email mit Aktivierungs-Link f�r den Admin
$lang['activation_success_emailsubject'] = "Ihr Account wurde aktiviert";     // Subject f�r Email nach Account Aktivierung durch den Admin (Registrierung und Emailwechsel)

$lang['no_permission'] = "Sie sind nicht angemeldet oder haben nicht die erforderlichen Rechte f�r diese Seite!";
$lang['already_registered'] = "Es wurde festgestellt, dass Sie bereits registrierter Benutzer sind. Wenn Sie Ihr Passwort vergessen haben klicken Sie bitte <a href=\"{url_lost_password}\">hier</a>.";
$lang['username_exists'] = "Es existiert bereits ein User mit diesem Usernamen.";
$lang['email_exists'] = "Es existiert bereits ein User mit dieser Email Adresse.";
$lang['invalid_email_format'] = "Bitte geben Sie eine g�ltige Email Adresse an.";
$lang['register_success'] = "Ihre Registrierung war erfolgreich. Sie erhalten nun eine Email mit Ihrem Aktivierungs-Link.";
$lang['register_success_admin'] = "Ihre Registrierung war erfolgreich. Ihr Account muss erst durch den Administrator aktiviert werden. Sie erhalten eine Email sobald dies geschehen ist.";
$lang['register_success_none'] = "Ihre Registrierung war erfolgreich. Sie k�nnen sich nun einloggen.";
$lang['missing_activationkey'] = "Es wurde kein Aktivierungs-Key �bergeben.";
$lang['invalid_activationkey'] = "Diese Account ist nicht mehr aktiv. Bitte registrieren Sie sich erneut.</>";
$lang['activation_success'] = "Vielen Dank! Ihr Account wurde erfolgreich aktiviert. Sie k�nnen Sie nun einloggen.";
$lang['general_error'] = "Es ist ein Fehler aufgetreten. Bitte gehen Sie <a href=javascript:history.go(-1)>zur�ck</a> und versuchen es erneut. Sollte das Problem l�ngerfristig auftreten, wenden Sie sich bitte an den Administrator.";
$lang['invalid_login'] = "Es existiert kein Benutzer mit diesem Benutzernamen und Passwort";
$lang['update_email_error'] = "Bitte tragen Sie Ihre Email Adresse zweimal ein!";
$lang['update_email_confirm_error'] = "Ihre beiden Email Adressen stimmen nicht �berein!";
$lang['update_profile_success'] = "Ihr Profil wurde erfolgreich aktualisiert!";
$lang['update_email_instruction'] = "Da Sie Ihre Emailadresse ge�ndert haben, muss Ihr Account neu aktiviert werden. Der Aktivierungskey wurde an die neue Emailadresse gendet!";
$lang['update_email_instruction_admin'] = "Da Sie Ihre Emailadresse ge�ndert haben, muss Ihr Account durch den Administrator neu aktiviert werden. Sie erhalten eine Email sobald dies geschehen ist.";
$lang['invalid_email'] = "Es ist kein Benutzer mit dieser Email Adresse vorhanden.";
$lang['send_password_success'] = "Ihr Passwort wurde Ihnen zugesendet.";
$lang['update_password_error'] = "Sie haben Ihr aktuelles Passwort falsch eingegeben.";
$lang['update_password_confirm_error'] = "Ihre beiden neuen Passworte stimmen nicht �berein!";
$lang['update_password_success'] = "Ihr Passwort wurde erfolgreich ge�ndert.";
$lang['invalid_user_id'] = "Kein Benutzer gefunden!";
$lang['emailuser_success'] = "Die Email wurde erfolgreich versendet";
$lang['send_email_to'] = "Email versenden an:";
$lang['subject'] = "Betreff:";
$lang['message'] = "Nachricht:";
$lang['profile_of'] = "Profil von:";
$lang['edit_profile_msg'] = "Hier k�nnen Sie Ihr pers�nliches Profil und Ihre Passwort �ndern.";
$lang['edit_profile_email_msg'] = "<br />Beachten Sie bitte: Bei �nderung der Email Adresse muss Ihr Account neu aktiviert werden. Der Aktivierungskey wird an die neue Email Adresse gesendet.";
$lang['edit_profile_email_msg_admin'] = "<br />Beachten Sie bitte: Bei �nderung der Email Adresse muss Ihr Account durch den Administrator neu aktiviert werden.";
$lang['join_date'] = "Registriert seit:";
$lang['last_action'] = "Zuletzt aktiv:";
$lang['email'] = "Email:";
$lang['email_confirm'] = "Email wiederholen:";
$lang['homepage'] = "Homepage:";
$lang['icq'] = "ICQ:";
$lang['show_email'] = "Emailadresse anzeigen:";
$lang['allow_emails'] = "Emails von Administratoren erhalten:";
$lang['invisible'] = "Online-Status verstecken:";
$lang['optional_infos'] = "Freiwillige Angaben";
$lang['change_password'] = "Passwort �ndern";
$lang['old_password'] = "Altes Passwort:";
$lang['new_password'] = "Neues Passwort:";
$lang['new_password_confirm'] = "Neues Passwort wiederholen:";
$lang['lost_password'] = "Passwort vergessen";
$lang['lost_password_msg'] = "Sollten Sie Ihr Passwort vergessen haben, k�nnen Sie hier ein neues anfordern. Geben Sie einfach in das Textfeld Ihre Email Adresse ein mit der Sie sich registriert haben.";
$lang['user_name'] = "Benutzername:";
$lang['password'] = "Passwort:";

$lang['register_msg'] = "Bitte f�llen Sie alle Felder komplett aus. Sie ben�tigen eine g�ltige Email Adresse da dorthin der Aktivierungslink f�r Ihren Account gesendet wird.";
$lang['agreement'] = "Nutzungsbedingungen:";
$lang['agreement_terms'] = "
            Dieses Archiv nutzt ein Kommentarsystem mit dem die Besucher Kommentare 
            zu den Eintr&auml;gen abgeben k&ouml;nnen. Obwohl die Administratoren 
            dieser Seite versuchen, alle unerw&uuml;nschten Beitr&auml;ge von 
            diesem System fernzuhalten, ist es f&uuml;r uns unm&ouml;glich, alle 
            Beitr&auml;ge zu &uuml;berpr&uuml;fen. Alle Beitr&auml;ge dr&uuml;cken 
            die Ansichten des Autors aus und die Eigent&uuml;mer dieser Website 
            k&ouml;nnen nicht f&uuml;r den Inhalt jedes Beitrags verantwortlich 
            gemacht werden.
            <br /><br />
            Sie verpflichten Sich, keine beleidigenden, obsz&ouml;nen, vulg&auml;ren, 
            verleumdenden, gewaltverherrlichenden oder aus anderen Gr&uuml;nden 
            strafbaren Inhalte zu ver&ouml;ffentlichen. Sie r&auml;umen den Betreibern 
            und Administratoren dieser Website das Recht ein, Beitr&auml;ge nach 
            eigenem Ermessen zu entfernen oder zu bearbeiten. Sie stimmen ausserdem 
            zu, dass die im Rahmen der Registrierung erhobenen Daten in einer 
            Datenbank gespeichert werden.
            <br /><br />
            Dieses System verwendet Cookies, um Informationen auf Ihrem Computer 
            zu speichern. Diese Cookies enthalten keine pers�nlichen Informationen, 
            sondern dienen ausschlie&szlig;lich Ihrem Komfort.
            <br /><br />
            Durch das Abschlie&szlig;en der Registrierung stimmen Sie diesen Nutzungsbedingungen zu.";

$lang['agree'] = "Akzeptieren";
$lang['agree_not'] = "Ablehnen";
$lang['show_user_images'] = "Alle Bilder von {user_name} anzeigen";

//-----------------------------------------------------
//--- Edit Images -------------------------------------
//-----------------------------------------------------
$lang['image_edit'] = "Bild bearbeiten";
$lang['image_edit_success'] = "Bild erfolgreich bearbeitet";
$lang['image_edit_error'] = "Fehler beim Bearbeiten des Bildes";
$lang['image_delete'] = "Bild l�schen";
$lang['image_delete_success'] = "Bild erfolgreich gel�scht";
$lang['image_delete_error'] = "Fehler beim L�schen des Bildes";
$lang['image_delete_confirm'] = "Wollen Sie diesen Bild-Eintrag wirklich l�schen?";

//-----------------------------------------------------
//--- Edit Comments -----------------------------------
//-----------------------------------------------------
$lang['comment_edit'] = "Kommentar bearbeiten";
$lang['comment_edit_success'] = "Kommentar erfolgreich bearbeitet";
$lang['comment_edit_error'] = "Fehler beim Bearbeiten der Kommentar";
$lang['comment_delete'] = "Kommentar l�schen";
$lang['comment_delete_success'] = "Kommentar erfolgreich gel�scht";
$lang['comment_delete_error'] = "Fehler beim L�schen der Kommentar";
$lang['comment_delete_confirm'] = "Wollen Sie diesen Kommentar wirklich l�schen?";

//-----------------------------------------------------
//--- Image Upload ------------------------------------
//-----------------------------------------------------
$lang['field_required'] = "Das Feld {field_name} muss ausgef�llt werden!";
$lang['kb'] = "kb";
$lang['px'] = "px";
$lang['file_upload_error'] = "Fehler beim Upload der Bild-Datei";
$lang['thumb_upload_error'] = "Fehler beim Upload der Thumbnail-Bilddatei";
$lang['invalid_file_type'] = "Die Datei hat ein ung�ltiges Format";
$lang['invalid_image_width'] = "Die Bildbreite ist unzul�ssig";
$lang['invalid_image_height'] = "Die Bildh�he ist unzul�ssig";
$lang['invalid_file_size'] = "Die Dateigr��e ist unzul�ssig";
$lang['image_add_success'] = "Bild erfolgreich hinzugef�gt";
$lang['allowed_mediatypes_desc'] = "Erlaubte Dateitypen: ";
$lang['keywords_ext'] = "Schl�sselw&ouml;rter:<br /><span class=\"smalltext\">Schl�sselw&ouml;rter durch Leerzeichen getrennt eingeben.</span>";
$lang['user_upload'] = "Bild Upload";
$lang['image_name'] = "Bildname:";
$lang['media_file'] = "Bilddatei:";
$lang['thumb_file'] = "Thumbnaildatei:";
$lang['max_filesize'] = "Max. Dateigr��e: ";
$lang['max_imagewidth'] = "Max. Bildbreite: ";
$lang['max_imageheight'] = "Max. Bildh�he: ";
$lang['image_file_required'] = "Bitte w�hlen Sie eine Bilddatei!";
$lang['new_upload_emailsubject'] = "Neuer Upload auf {site_name}";
$lang['new_upload_validate_desc'] = "Nach �berpr�fung durch einen Administrator wird Ihr Bild freigeschaltet.";

//-----------------------------------------------------
//--- Lightbox ----------------------------------------
//-----------------------------------------------------
$lang['lightbox_no_images'] = "Sie haben keine Bilder auf Ihrem Leuchtkasten.";
$lang['lightbox_add_success'] = "Bild erfolgreich hinzugef�gt.";
$lang['lightbox_add_error'] = "Fehler beim Hinzuf�gen!";
$lang['lightbox_remove_success'] = "Bild erfolgreich vom Leuchtkasten entfernt.";
$lang['lightbox_remove_error'] = "Fehler beim L�schen!";
$lang['lightbox_register'] = "Um den Leuchtkasten nutzen zu k�nnen, m�ssen sie registrierter Benutzer sein.<br />&raquo; <a href=\"{url_register}\">Jetzt registrieren</a>";
$lang['lightbox_delete_success'] = "Leuchkasten erfolgreich gel�scht.";
$lang['lightbox_delete_error'] = "Fehler beim L�schen des Leuchtkastens!";
$lang['delete_lightbox'] = "Leuchtkasten l&ouml;schen";
$lang['lighbox_lastaction'] = "Leuchtkasten zuletzt aktualisiert:";
$lang['delete_lightbox_confirm'] = "Wollen Sie Ihren Leuchkasten wirklich loeschen?";

//-----------------------------------------------------
//--- Misc --------------------------------------------
//-----------------------------------------------------
$lang['new'] = "neu"; // Markiert Kategorien und Bilder als "NEU"
$lang['home'] = "Home";
$lang['categories'] = "Kategorien";
$lang['sub_categories'] = "Unterkategorien";
$lang['lightbox'] = "Leuchtkasten";
$lang['error'] = "Fehler";
$lang['register'] = "Registrierung";
$lang['control_panel'] = "Kontrollzentrum";
$lang['profile'] = "Benutzerprofil";
$lang['search'] = "Suchen";
$lang['advanced_search'] = "Erweiterte Suche";
$lang['new_images'] = "Neue Bilder";
$lang['top_images'] = "Top Bilder";
$lang['registered_user'] = "Registrierte Benutzer";
$lang['logout'] = "Abmelden";
$lang['login'] = "Anmelden";
$lang['lang_auto_login'] = "Beim n�chsten Besuch automatisch anmelden?";
$lang['lost_password'] = "Password vergessen";
$lang['random_image'] = "Zufallsbild";
$lang['site_stats'] = "<b>{total_images}</b> Bilder in <b>{total_categories}</b> Kategorien.";
$lang['lang_loggedin_msg'] = "Eingeloggt als: <b>{loggedin_user_name}</b>";
$lang['go'] = "Go";
$lang['submit'] = "Abschicken";
$lang['reset'] = "Zur�cksetzen";
$lang['save'] = "Speichern";
$lang['yes'] = "Ja";
$lang['no'] = "Nein";
$lang['images_per_page'] = "Bilder pro Seite:";
$lang['user_online'] = "Zur Zeit aktive Benutzer: {num_total_online}";
$lang['user_online_detail'] = "Es sind gerade <b>{num_registered_online}</b> registrierte(r) Benutzer ({num_invisible_online} davon unsichtbar) und <b>{num_guests_online}</b> Besucher online.";
$lang['lostfield_error'] = "Bitte f�llen Sie alle Felder komplett aus!";
$lang['rate'] = "Bewerten";

//-----------------------------------------------------
//--- Paging ------------------------------------------
//-----------------------------------------------------
$lang['paging_stats'] = "Gefunden: {total_cat_images} Bild(er) auf {total_pages} Seite(n). Angezeigt: Bild {first_page} bis {last_page}.";
$lang['paging_next'] = "&raquo;";
$lang['paging_previous'] = "&laquo;";
$lang['paging_lastpage'] = "Letzte Seite &raquo;";
$lang['paging_firstpage'] = "&laquo; Erste Seite";

//-----------------------------------------------------
//--- Search ------------------------------------------
//-----------------------------------------------------
$lang['search_no_results'] = "Die Suche ergab leider keine Treffer.";
$lang['search_by_keyword'] = "Suche nach Schl�sselwort:<br /><span class=\"smalltext\">Sie k�nnen AND benutzen, um W�rter zu definieren, die vorkommen m�ssen, OR f�r W�rter, die im Resultat sein k�nnen und NOT verbietet das nachfolgende Wort im Resultat. Benutzen Sie * als Platzhalter.</span>";
$lang['search_by_username'] = "Suche nach Username:<br /><span class=\"smalltext\">Benutzen Sie * als Platzhalter.</span>";
$lang['search_terms'] = "Verkn�pfung:";
$lang['search_fields'] = "Suche in Feldern:";
$lang['new_images_only'] = "Nur neue Bilder anzeigen";
$lang['all_fields'] = "Alle Felder";
$lang['name_only'] = "Nur Bildname";
$lang['description_only'] = "Nur Beschreibung";
$lang['keywords_only'] = "Nur Schl�sselw�rter";
$lang['and'] = "UND";
$lang['or'] = "ODER";

//-----------------------------------------------------
//--- New Images --------------------------------------
//-----------------------------------------------------
$lang['no_new_images'] = "Momentan sind keine neuen Bilder vorhanden.";

//-----------------------------------------------------
//--- Admin Links -------------------------------------
//-----------------------------------------------------
$lang['edit'] = "[Bearbeiten]";
$lang['delete'] = "[L�schen]";
?>