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
	Language: Swedish
	Language code: se
*/

	// General codes
	$lang->to = "Mottagare";
	$lang->cc = "Kopia";
	$lang->bcc = "G�md kopia";
	$lang->from = "Avs�ndare";
	$lang->subject = "�rende";
	$lang->date = "Datum";
	$lang->filename = "Filnamn";
	$lang->size = "Storlek";
	$lang->total = "Totalt";
	$lang->attachment = "Bilaga";
	$lang->attachments = "Bilagor";
	$lang->high_priority = "H�g prioriteit";
	$lang->none = "(inget)";
	$lang->unknown = "(ok�nd)";
	$lang->btn_add = "L�gg till";
	$lang->btn_change = "�ndra";
	$lang->btn_reset = "Radera";

	// General error codes
	$lang->error = "Fel";
	$lang->err_allfields = "V�nligen fyll i alla f�lt.";
	$lang->err_no_msg_specified = "Inget meddelande specificerat.";
	$lang->err_select_msg = "V�lj ett meddelande.";
	$lang->err_create_group_first = "G�r f�rst en ny grupp.";
	$lang->err_email_exists = "Denna E-mail-adress finns redan i listan.";
	$lang->err_group_exists = "Denna grupp finns redan.";
	$lang->err_select_group_contact = "V�nligen v�lj grupp eller adress.";
	$lang->err_group_not_found = "Gruppen inte funnen.";
	$lang->err_select_contact = "V�lj en adress ist�llet f�r en grupp.";
	$lang->err_invalid_email_group = "Felaktig grupp eller E-Mail.";
	$lang->err_invalid_name = "Anv�nd bara till�tna tecken i namn.";
	$lang->err_invalid_group = "Anv�nd bara till�tna tecken i gruppnamn.";
	$lang->err_invalid_email = "E-mailadress felaktig.";
	$lang->err_mail_failed = "Misslyckades s�nda E-Mail.";
	$lang->err_datafile_not_found = "Datafil kunde inte hittas.";
	$lang->err_attach_first = "Vidh�fta bilagan f�rst.";
	$lang->err_mail_size_exceeded = "Maximal storlek p� bilagan �r �verskriden.";
	$lang->err_already_included = "Filen �r redan vidh�ftad";
	$lang->err_file_too_big = "Filen �r f�r stor.";

	// Codes for login page
	$lang->login = "Logga in";
	$lang->login_please_login = "Var v�nlig logga in";
	$lang->login_username = "Anv�ndarnamn";
	$lang->login_password = "L�senord";
	$lang->login_domain = "Dom�n";
	$lang->login_language = "Spr�k";
	$lang->login_msg_been_logged_out = "Du �r utloggad.";
	$lang->login_msg_invalid_login = "Din inloggning �r inte l�ngre giltig.";
	$lang->login_msg_wrongpass = "Antingen �r anv�ndarnamnet eller l�senord felaktiga, eller s� �r servern nere.";

	// Codes for Inbox
	$lang->inbox = "Brevl�da";
	$lang->inbox_infostring1 = "Du har";
	$lang->inbox_infostring2 = "meddelanden";
	$lang->inbox_infostring3 = "meddelande";
	$lang->inbox_infostring4 = "ny";
	$lang->inbox_infostring5 = "totalt";
	$lang->inbox_sort_low_to_high = "Sortera fr�n l�g till h�g";
	$lang->inbox_sort_high_to_low = "Sortera fr�n h�g till l�g";
	$lang->inbox_no_messages = "Inga meddelande i brevl�dan";
	$lang->inbox_invert_selection = "Invertera val";
	$lang->inbox_confirm_delete = "Vill du ta bort de valda meddelandena?";
 
	// Codes for Create message
	$lang->create = "Skriv meddelande";
	$lang->create_attach = "Vidh�fta";
	$lang->create_original_msg = "Originalmeddelaned";
	$lang->create_add_sig = "Bifoga signatur";

	// Codes for Message script
	$lang->message = "Meddelande";
	$lang->message_add_to_contacts = "L�gg till i Adressboken";
	$lang->message_import_in_contacts = "Importera till Addressboken";
	$lang->message_view_header = "Visa header";
	$lang->message_hide_header = "G�m header";
	$lang->message_confirm_delete = "Vill du ta bort meddelandet?";

	// Codes for Options
	$lang->options = "Tillval";
	$lang->options_name = "Namn";
	$lang->options_timezone = "Tidszon";
	$lang->options_email = "Emailadress";
	$lang->options_signature = "Signatur";
	
	// Codes for Contacts
	$lang->contacts = "Adressbok";
	$lang->contacts_infostring1 = "Du har";
	$lang->contacts_infostring2 = "grupp";
	$lang->contacts_infostring3 = "grupper";
	$lang->contacts_infostring4 = "och";
	$lang->contacts_infostring5 = "adress";
	$lang->contacts_infostring6 = "adresser";
	$lang->contacts_infostring7 = "i Addressbok";
	$lang->contacts_send_mail = "Skicka E-mail";
	$lang->contacts_no_contacts = "Inga addresser i grupp.";
	$lang->contacts_no_groups = "Ingen grupp �r skapad.";
	$lang->contacts_name = "Namn";
	$lang->contacts_email = "E-mailadress";
	$lang->contacts_group = "Grupp";
	$lang->contacts_new_group = "Ny grupp";
	$lang->contacts_add = "L�gg till";
	$lang->contacts_add_to = "Infoga i";
	$lang->contacts_confirm_delete = "Vill du ta bort den valda grupperna/kontakterna?";

	// Code for Refresh button
	$lang->refresh = "F�rnya";

	// Code for Reply button
	$lang->reply = "Svara";
	
	// Code for Forward button
	$lang->forward = "Vidarebefordra";

	// Code for Delete button
	$lang->delete = "Ta bort";

	// Code for Send button
	$lang->send = "Skicka";
 
	// Code for Help button
	$lang->help = "Hj�lp";

	// Code for Logout button
	$lang->logout = "Logga ut";

	// Array for months
	$lang->months = array("januari", "februari", "mars", "april", "maj", "juni", "juli", "augusti", "september", "oktober", "november", "december");

	// Array for days
	$lang->days = array("S�ndag", "M�ndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "L�rdag");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "d-m-Y";

	// Character set of language
	$lang->charset = "ISO-8859-1";
?>
