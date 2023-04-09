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

	Date: 3 January 2001
	Author: Heine Lahn Petersen <hlp@email.dk>
	Language: Danish
	Language code: da
*/

	// General codes
	$lang->to = "Til";
	$lang->cc = "Kopi";
	$lang->bcc = "Skjult kopi";
	$lang->from = "Fra";
	$lang->subject = "Emne";
	$lang->date = "Dato";
	$lang->filename = "Filnavn";
	$lang->size = "Størelse";
	$lang->total = "Total";
	$lang->attachment = "Vedhæftning";
	$lang->attachments = "Vedhæftede filer";
	$lang->high_priority = "Høj prioritet";
	$lang->none = "(ingen)";
	$lang->unknown = "(ukendt)";
	$lang->btn_add = "Tilføj";
	$lang->btn_change = "Gem ændringer";
	$lang->btn_reset = "Nulstil";

	// General error codes
	$lang->error = "Fejl";
	$lang->err_allfields = "Udfyld venligst alle felter.";
	$lang->err_no_msg_specified = "Der er ikke specificeret en meddelelse.";
	$lang->err_select_msg = "Vælg en meddelelse.";
	$lang->err_create_group_first = "Opret en ny gruppe først.";
	$lang->err_email_exists = "E-mailadresen findes allerede i listen.";
	$lang->err_group_exists = "Gruppen eksisterer allerede.";
	$lang->err_select_group_contact = "Vælg en gruppe eller kontaktperson.";
	$lang->err_group_not_found = "Gruppen blev ikke fundet.";
	$lang->err_select_contact = "Vælg en kontaktperson, i stedet for en gruppe.";
	$lang->err_invalid_email_group = "Forkert gruppe eller email.";
	$lang->err_invalid_name = "Anførselstegn og streger er ikke tilladt i navnet.";
	$lang->err_invalid_group = "Streger er ikke tilladt i gruppenavne.";
	$lang->err_invalid_email = "Forkert email adresse format.";
	$lang->err_mail_failed = "Sending af email fejlede.";
	$lang->err_datafile_not_found = "Data filen blev ikke fundet.";
	$lang->err_attach_first = "Vedhæft filen først.";
	$lang->err_mail_size_exceeded = "Den maximale størelse af vedhæftningerne er overskredet.";
	$lang->err_already_included = "Filen er allerede inkluderet.";
	$lang->err_file_too_big = "Filen er for stor.";

	// Codes for login page
	$lang->login = "Log ind";
	$lang->login_please_login = "Udfyld og log ind.";
	$lang->login_username = "Brugernavn";
	$lang->login_password = "Adgangskode";
	$lang->login_domain = "Domæne";
	$lang->login_language = "Sprog";
	$lang->login_msg_been_logged_out = "Du er blevet logget ud.";
	$lang->login_msg_invalid_login = "Dit login er ikke gyldigt længere.";
	$lang->login_msg_wrongpass = "Dit brugernavn eller adgangskode er forkert, eller mailserveren er nede.";

	// Codes for Inbox
	$lang->inbox = "Indbakke";
	$lang->inbox_infostring1 = "Du har";
	$lang->inbox_infostring2 = "meddelelser";
	$lang->inbox_infostring3 = "meddelelse";
	$lang->inbox_infostring4 = "nye";
	$lang->inbox_infostring5 = "total";
	$lang->inbox_sort_low_to_high = "Sorter fra mindste til største";
	$lang->inbox_sort_high_to_low = "Sorter fra største til mindste";
	$lang->inbox_no_messages = "Ingen meddelelser i indbakken";
	$lang->inbox_invert_selection = "Inverter markerede";
	$lang->inbox_confirm_delete = "Vi du slette de markerede meddelelser?";

	// Codes for Create message
	$lang->create = "Ny meddelelse";
	$lang->create_attach = "Vedhæft";
	$lang->create_original_msg = "Opbrindelig meddelelse";
	$lang->create_add_sig = "Tilføj signatur";

	// Codes for Message script
	$lang->message = "Meddelelse";
	$lang->message_add_to_contacts = "Tilføj til kontaktpersoner";
	$lang->message_import_in_contacts = "Importer til kontaktpersoner";
	$lang->message_view_header = "Vis emne";
	$lang->message_hide_header = "Gem emne";
	$lang->message_confirm_delete = "Vil du slette meddelelsen?";

	// Codes for Options
	$lang->options = "Indstillinger";
	$lang->options_name = "Navn";
	$lang->options_timezone = "Tidszone";
	$lang->options_email = "E-mail adresse";
	$lang->options_signature = "Signatur";
	
	// Codes for Contacts
	$lang->contacts = "Kontaktpersoner";
	$lang->contacts_infostring1 = "Du har";
	$lang->contacts_infostring2 = "gruppe";
	$lang->contacts_infostring3 = "grupper";
	$lang->contacts_infostring4 = "og";
	$lang->contacts_infostring5 = "adresse";
	$lang->contacts_infostring6 = "adresser";
	$lang->contacts_infostring7 = "i kontaktpersoner";
	$lang->contacts_send_mail = "Send mail";
	$lang->contacts_no_contacts = "Ingen kontaktpersoner i gruppen.";
	$lang->contacts_no_groups = "Ingen grupper defineret.";
	$lang->contacts_name = "Navn";
	$lang->contacts_email = "E-mailadresse";
	$lang->contacts_group = "Gruppe";
	$lang->contacts_new_group = "Ny gruppe";
	$lang->contacts_add = "Tilføj";
	$lang->contacts_add_to = "Tilføj til";
	$lang->contacts_confirm_delete = "Vil du slette de markerede grupper/kontaktpersoner?";

	// Code for Refresh button
	$lang->refresh = "Opdater";

	// Code for Reply button
	$lang->reply = "Svar";
	
	// Code for Forward button
	$lang->forward = "Vidresend";

	// Code for Delete button
	$lang->delete = "Slet";

	// Code for Send button
	$lang->send = "Send";

	// Code for Help button
	$lang->help = "Hjælp";

	// Code for Logout button
	$lang->logout = "Log ud";

	// Array for months
	$lang->months = array("Januar", "Februar", "Marts", "April", "Maj", "Juni", "Juli", "August", "September", "Oktober", "November", "December");

	// Array for days
	$lang->days = array("Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "d-m-Y";

	// Character set of language
	$lang->charset = "ISO-8859-1";
?>
