<?php
/*	eCorrei 1.2.5 - Delete script
	A webbased E-mail solution
	Page: http://ecorrei.sourceforge.net/
	Date: 2 February 2002
	Author: Jeroen Vreuls
	Copyright (C) 2000-2002 Jeroen Vreuls

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
*/
	$bypasscheck = 0;
	require("main.php");

	if ($msg) {
		$mbox = @imap_open("{" . $connectstring . "}INBOX", $usr_username . $usr_append, $usr_password);
		if (!$mbox) {
			redirect("index.php?action=auth_failed");
		}

		if (is_array($msg)) {
			for ($b=0;$b<sizeof($msg);$b++) {
				@imap_delete($mbox, $msg[$b], FT_UID);
			}
		}
		else {
			@imap_delete($mbox, $msg, FT_UID);
		}
		imap_expunge($mbox);
		imap_close($mbox);
		
		redirect("inbox.php");
	}
	else {
		error($lang->err_select_msg);
	}
?>
