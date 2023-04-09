<?php
/*	eCorrei 1.2.5 - Language file
	A webbased E-mail solution
	Page: http://ecorrei.sourceforge.net/

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
	or see http://www.fsf.org/copyleft/gpl.html

	Date: 23 December 2001
	Author: Peter Arnmark <peter@arnmark.f2s.com>
	Language: French
	Language code: fr
*/
 
	// General codes
	$lang->to = "À";
	$lang->cc = "CC";
	$lang->bcc = "BCC";
	$lang->from = "De";
	$lang->subject = "Sujet";
	$lang->date = "Date";
	$lang->filename = "Nom de Fichier";
	$lang->size = "Taille";
	$lang->total = "Total";
	$lang->attachment = "Fichier joint";
	$lang->attachments = "Fichiers joints";
	$lang->high_priority = "Haute priorité";
	$lang->none = "(rien)";
	$lang->unknown = "(inconnu)";
	$lang->btn_add = "Ajouter";
	$lang->btn_change = "Modifier";
	$lang->btn_reset = "Effacer";

	// General error codes
	$lang->error = "Erreur";
	$lang->err_allfields = "Veuillez remplir tous les champs.";
	$lang->err_no_msg_specified = "Aucun message spécifié.";
	$lang->err_select_msg = "Veuillez sélectionner un message.";
	$lang->err_create_group_first = "Créez d'abord un groupe.";
	$lang->err_email_exists = "Le e-mail existe déjà dans la liste.";
	$lang->err_group_exists = "Le groupe existe déjà.";
	$lang->err_select_group_contact = "Veuillez sélectionner un groupe ou un contact.";
	$lang->err_group_not_found = "Groupe non trouvé.";
	$lang->err_select_contact = "Sélectionnez un contact au lieu d'un groupe.";
	$lang->err_invalid_email_group = "Groupe ou e-mail invalide.";
	$lang->err_invalid_name = "Les guillemets et les apostrophes ne sont pas autorisés.";
	$lang->err_invalid_group = "Les apostrophes ne sont pas autorisées.";
	$lang->err_invalid_email = "Format d'email incorrect.";
	$lang->err_mail_failed = "L'envoi du email a échoué.";
	$lang->err_datafile_not_found = "Fichier non trouvé.";
	$lang->err_attach_first = "Joignez d'abord le fichier.";
	$lang->err_mail_size_exceeded = "Vous abusez. La taille du email est trop importante.";
	$lang->err_already_included = "Le fichier est déjà joint.";
	$lang->err_file_too_big = "Vous abusez. La taille du fichier est trop importante.";
 
	// Codes for login page
	$lang->login = "Identification";
	$lang->login_please_login = "Veuillez vous identifier.";
	$lang->login_username = "Identifiant";
	$lang->login_password = "Mot de passe";
	$lang->login_domain = "Site";
	$lang->login_language = "Langue";
	$lang->login_msg_been_logged_out = "Vous venez de vous déconnecter.";
	$lang->login_msg_invalid_login = "Votre identifiant n'est plus valide.";
	$lang->login_msg_wrongpass = "Soit votre identifiant ou votre mot de passe est invalide, ou alors votre serveur est niqué.";

	// Codes for Inbox
	$lang->inbox = "Boîte de réception";
	$lang->inbox_infostring1 = "Vous avez";
	$lang->inbox_infostring2 = "messages";
	$lang->inbox_infostring3 = "message";
	$lang->inbox_infostring4 = "nouveau";
	$lang->inbox_infostring5 = "total";
	$lang->inbox_sort_low_to_high = "Tri par ordre croissant";
	$lang->inbox_sort_high_to_low = "Tri par ordre décroissant";
	$lang->inbox_no_messages = "Pas de nouvelles, bonne nouvelle.";
	$lang->inbox_invert_selection = "Inverter la selection";
	$lang->inbox_confirm_delete = "Voulez-vous effacer les messages selectionnés?";

	// Codes for Create message
	$lang->create = "Nouveau message";
	$lang->create_attach = "Joindre";
	$lang->create_original_msg = "Message original";
	$lang->create_add_sig = "Signature";

	// Codes for Message script
	$lang->message = "Message";
	$lang->message_add_to_contacts = "Ajouter à mes contacts";
	$lang->message_import_in_contacts = "Importer à mes contacts";
	$lang->message_view_header = "Voir l'entete";
	$lang->message_hide_header = "Cacher l'entete";
	$lang->message_confirm_delete = "Voulez-vous effacer le message?";
 
	// Codes for Options
	$lang->options = "Options";
	$lang->options_name = "Nom";
	$lang->options_timezone = "Zone de temps";
	$lang->options_email = "Adresse e-mail";
	$lang->options_signature = "Signature";

	// Codes for Contacts
	$lang->contacts = "Contacts";
	$lang->contacts_infostring1 = "Vous avez";
	$lang->contacts_infostring2 = "groupe";
	$lang->contacts_infostring3 = "groupes";
	$lang->contacts_infostring4 = "et";
	$lang->contacts_infostring5 = "adresse";
	$lang->contacts_infostring6 = "addresses";
	$lang->contacts_infostring7 = "dans vos contacts";
	$lang->contacts_send_mail = "Envoyer un email";
	$lang->contacts_no_contacts = "Pas de contacts dans ce groupe.";
	$lang->contacts_no_groups = "Pas de groupes definis.";
	$lang->contacts_name = "Nom";
	$lang->contacts_email = "Adresse email";
	$lang->contacts_group = "Groupe";
	$lang->contacts_new_group = "Nouveau groupe";
	$lang->contacts_add = "Ajouter";
	$lang->contacts_add_to = "Ajouter à";
	$lang->contacts_confirm_delete = "Voulez-vous effacer les groupes/contacts selectionnéz?";

	// Code for Refresh button
	$lang->refresh = "Rafraîchir";

	// Code for Reply button
	$lang->reply = "Répondre";

	// Code for Forward button
	$lang->forward = "Transmettre";

	// Code for Delete button
	$lang->delete = "Effacer";

	// Code for Send button
	$lang->send = "Envoyer";

	// Code for Help button
	$lang->help = "Aide";

	// Code for Logout button
	$lang->logout = "Déconnexion";
 
	// Array for months
	$lang->months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

	// Array for days
	$lang->days = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "d-m-Y";
 
	// Character set of language
	$lang->charset = "ISO-8859-1";
?>
