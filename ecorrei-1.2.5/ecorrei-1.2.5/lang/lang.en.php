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

	Date: 1 February 2001
	Author: Jeroen Vreuls <jvreuls@users.sourceforge.net>
	Language: English
	Language code: en
*/

	// General codes
	$lang->to = "To";
	$lang->cc = "CC";
	$lang->bcc = "BCC";
	$lang->from = "From";
	$lang->subject = "Subject";
	$lang->date = "Date";
	$lang->filename = "Filename";
	$lang->size = "Size";
	$lang->total = "Total";
	$lang->attachment = "Attachment";
	$lang->attachments = "Attachments";
	$lang->high_priority = "High priority";
	$lang->none = "(none)";
	$lang->unknown = "(unknown)";
	$lang->btn_add = "Add";
	$lang->btn_change = "Change";
	$lang->btn_reset = "Reset";

	// General error codes
	$lang->error = "Error";
	$lang->err_allfields = "Please fill in all the fields.";
	$lang->err_no_msg_specified = "No message specified.";
	$lang->err_select_msg = "Please select a message.";
	$lang->err_create_group_first = "Create a group first.";
	$lang->err_email_exists = "E-mailaddress already in the list.";
	$lang->err_group_exists = "Group already exists.";
	$lang->err_select_group_contact = "Please select a group or contact.";
	$lang->err_group_not_found = "Group not found.";
	$lang->err_select_contact = "Please select a contact, instead of a group.";
	$lang->err_invalid_email_group = "Invalid group or email.";
	$lang->err_invalid_name = "The name contains invalid characters.";
	$lang->err_invalid_group = "The group name contains invalid characters.";
	$lang->err_invalid_email = "Wrong E-mailaddress format.";
	$lang->err_mail_failed = "Sending the E-mail failed.";
	$lang->err_datafile_not_found = "Data file not found.";
	$lang->err_attach_first = "Please attach file first.";
	$lang->err_mail_size_exceeded = "Your maximum attachments size is exceeded.";
	$lang->err_already_included = "File is already included.";
	$lang->err_file_too_big = "Your file is too big.";

	// Codes for login page
	$lang->login = "Login";
	$lang->login_please_login = "Please login.";
	$lang->login_username = "Username";
	$lang->login_password = "Password";
	$lang->login_domain = "Domain";
	$lang->login_language = "Language";
	$lang->login_msg_been_logged_out = "You've been logged out.";
	$lang->login_msg_invalid_login = "Your login isn't valid anymore.";
	$lang->login_msg_wrongpass = "Either your password or username is invalid, or the mailserver is down.";

	// Codes for Inbox
	$lang->inbox = "Inbox";
	$lang->inbox_infostring1 = "You have";
	$lang->inbox_infostring2 = "messages";
	$lang->inbox_infostring3 = "message";
	$lang->inbox_infostring4 = "new";
	$lang->inbox_infostring5 = "total";
	$lang->inbox_sort_low_to_high = "Sort from low to high";
	$lang->inbox_sort_high_to_low = "Sort from high to low";
	$lang->inbox_no_messages = "No messages in Inbox";
	$lang->inbox_invert_selection = "Invert selection";
	$lang->inbox_confirm_delete = "Do you want to delete the selected messages?";

	// Codes for Create message
	$lang->create = "Create message";
	$lang->create_attach = "Attach";
	$lang->create_original_msg = "Original message";
	$lang->create_add_sig = "Add signature";

	// Codes for Message script
	$lang->message = "Message";
	$lang->message_add_to_contacts = "Add to Contacts";
	$lang->message_import_in_contacts = "Import in Contacts";
	$lang->message_view_header = "View header";
	$lang->message_hide_header = "Hide header";
	$lang->message_confirm_delete = "Do you want to delete the message?";

	// Codes for Options
	$lang->options = "Options";
	$lang->options_name = "Name";
	$lang->options_timezone = "Timezone";
	$lang->options_email = "E-mailaddress";
	$lang->options_signature = "Signature";
	
	// Codes for Contacts
	$lang->contacts = "Contacts";
	$lang->contacts_infostring1 = "You have";
	$lang->contacts_infostring2 = "group";
	$lang->contacts_infostring3 = "groups";
	$lang->contacts_infostring4 = "and";
	$lang->contacts_infostring5 = "address";
	$lang->contacts_infostring6 = "adresses";
	$lang->contacts_infostring7 = "in Contacts";
	$lang->contacts_send_mail = "Send mail";
	$lang->contacts_no_contacts = "No contacts in group.";
	$lang->contacts_no_groups = "No groups defined.";
	$lang->contacts_name = "Name";
	$lang->contacts_email = "E-mailaddress";
	$lang->contacts_group = "Group";
	$lang->contacts_new_group = "New group";
	$lang->contacts_add = "Add";
	$lang->contacts_add_to = "Add to";
	$lang->contacts_confirm_delete = "Do you want to delete the selected groups/contacts?";

	// Code for Refresh button
	$lang->refresh = "Refresh";

	// Code for Reply button
	$lang->reply = "Reply";
	
	// Code for Forward button
	$lang->forward = "Forward";

	// Code for Delete button
	$lang->delete = "Delete";

	// Code for Send button
	$lang->send = "Send";

	// Code for Help button
	$lang->help = "Help";

	// Code for Logout button
	$lang->logout = "Logout";

	// Array for months
	$lang->months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	// Array for days
	$lang->days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

	// Date format for Inbox
	// MM-DD-YYYY: "m-d-Y"
	// DD-MM-YYYY: "d-m-Y"
	// For other formats see PHP manual, function date()
	$lang->date_fmt = "m-d-Y";

	// Character set of language
	$lang->charset = "ISO-8859-1";
?>
