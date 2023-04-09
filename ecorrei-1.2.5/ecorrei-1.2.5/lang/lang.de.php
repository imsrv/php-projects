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

	Date: 01 February 2002
	Author: Jeroen Vreuls <jvreuls@f2s.com>
	Translator: Christoph Langguth <gummientchen@users.sourceforge.net>
	Language: German
	Language code: de
*/

	// General codes
	$lang->to = "An";
	$lang->cc = "CC";
	$lang->bcc = "BCC";
	$lang->from = "Von";
	$lang->subject = "Betreff";
	$lang->date = "Datum";
	$lang->filename = "Datei";
	$lang->size = "Größe";
	$lang->total = "ingesamt";
	$lang->attachment = "Anhang";
	$lang->attachments = "Anhänge";
	$lang->high_priority = "Hohe Priorität";
	$lang->none = "(kein)";
	$lang->unknown = "(unbekannt)";
	$lang->btn_add = "Hinzufügen";
	$lang->btn_change = "Ändern";
	$lang->btn_reset = "Zurücksetzen";

	// General error codes
	$lang->error = "Fehler";
	$lang->err_allfields = "Bitte füllen Sie alle Felder aus.";
	$lang->err_no_msg_specified = "Keine Nachricht ausgewählt.";
	$lang->err_select_msg = "Bitte wählen Sie eine Nachricht.";
	$lang->err_create_group_first = "Erstellen Sie erst eine Gruppe.";
	$lang->err_email_exists = "E-Mail-Adresse ist schon in der Liste vorhanden.";
	$lang->err_group_exists = "Gruppe existiert schon.";
	$lang->err_select_group_contact = "Bitte wählen Sie eine Gruppe oder eine Person.";
	$lang->err_group_not_found = "Gruppe nicht gefunden.";
	$lang->err_select_contact = "Bitte wählen Sie eine Person anstelle einer Gruppe.";
	$lang->err_invalid_email_group = "Ungültige Gruppe oder E-Mail.";
	$lang->err_invalid_name = "Der Name enthält ungültige Zeichen.";
	$lang->err_invalid_group = "Der Gruppenname enthält ungültige Zeichen.";
	$lang->err_invalid_email = "Falsches Format der E-Mail-Adresse.";
	$lang->err_mail_failed = "Senden der E-Mail fehlgeschlagen.";
	$lang->err_datafile_not_found = "Einstellungs-Datei nicht gefunden.";
	$lang->err_attach_first = "Bitte hängen Sie erst eine Datei an.";
	$lang->err_mail_size_exceeded = "Die maximale Größe für Anhänge wurde überschritten.";
	$lang->err_already_included = "Datei ist schon vorhanden.";
	$lang->err_file_too_big = "Die Datei ist zu groß.";

	// Codes for login page
	$lang->login = "Login";
	$lang->login_please_login = "Bitte einloggen.";
	$lang->login_username = "Username";
	$lang->login_password = "Passwort";
	$lang->login_domain = "Domain";
	$lang->login_language = "Sprache";
	$lang->login_msg_been_logged_out = "Sie sind ausgeloggt.";
	$lang->login_msg_invalid_login = "Ihr Login ist nicht mehr gültig.";
	$lang->login_msg_wrongpass = "Ihre Benutzername-Passwort-Kombination ist ungültig, oder der Mailserver ist nicht verfügbar.";

	// Codes for Inbox
	$lang->inbox = "Posteingang";
	$lang->inbox_infostring1 = "Sie haben";
	$lang->inbox_infostring2 = "Nachrichten";
	$lang->inbox_infostring3 = "Nachricht";
	$lang->inbox_infostring4 = "neue";
	$lang->inbox_infostring5 = "insgesamt";
	$lang->inbox_sort_low_to_high = "Aufsteigend sortieren";
	$lang->inbox_sort_high_to_low = "Absteigend sortieren";
	$lang->inbox_no_messages = "Keine Nachrichten vorhanden";
	$lang->inbox_invert_selection = "Auswahl umkehren";
	$lang->inbox_confirm_delete = "Wollen Sie die ausgewählten Nachrichten löschen?";

	// Codes for Create message
	$lang->create = "Nachricht erstellen";
	$lang->create_attach = "Anhängen";
	$lang->create_original_msg = "Original-Nachricht";
	$lang->create_add_sig = "Signatur hinzufügen";

	// Codes for Message script
	$lang->message = "Nachricht";
	$lang->message_add_to_contacts = "Zum Adreßbuch hinzufügen";
	$lang->message_import_in_contacts = "Ins Adreßbuch importieren";
	$lang->message_view_header = "Header anzeigen";
	$lang->message_hide_header = "Header ausblenden";
	$lang->message_confirm_delete = "Wollen Sie die Nachricht löschen?";

	// Codes for Options
	$lang->options = "Optionen";
	$lang->options_name = "Name";
	$lang->options_timezone = "Zeitzone";
	$lang->options_email = "E-Mail-Adresse";
	$lang->options_signature = "Signatur";
	
	// Codes for Contacts
	$lang->contacts = "Adreßbuch";
	$lang->contacts_infostring1 = "Sie haben";
	$lang->contacts_infostring2 = "Gruppe";
	$lang->contacts_infostring3 = "Gruppen";
	$lang->contacts_infostring4 = "und";
	$lang->contacts_infostring5 = "Adresse";
	$lang->contacts_infostring6 = "Adressen";
	$lang->contacts_infostring7 = "im Adreßbuch";
	$lang->contacts_send_mail = "Mail senden";
	$lang->contacts_no_contacts = "Keine Personen in der Gruppe.";
	$lang->contacts_no_groups = "Keine Gruppen definiert.";
	$lang->contacts_name = "Name";
	$lang->contacts_email = "E-Mail-Addresse";
	$lang->contacts_group = "Gruppe";
	$lang->contacts_new_group = "Neue Gruppe";
	$lang->contacts_add = "Hinzufügen";
	$lang->contacts_add_to = "Hinzufügen zu";
	$lang->contacts_confirm_delete = "Wollen Sie die ausgewählten Gruppen/Kontakte löschen?";

	// Code for Refresh button
	$lang->refresh = "Aktualisieren";

	// Code for Reply button
	$lang->reply = "Antworten";
	
	// Code for Forward button
	$lang->forward = "Weiterleiten";

	// Code for Delete button
	$lang->delete = "Löschen";

	// Code for Send button
	$lang->send = "Senden";

	// Code for Help button
	$lang->help = "Hilfe";

	// Code for Logout button
	$lang->logout = "Ausloggen";

	// Array for months
	$lang->months = array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");

	// Array for days
	$lang->days = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "d-m-Y";

	// Character set of language
	$lang->charset = "ISO-8859-1";
?>

