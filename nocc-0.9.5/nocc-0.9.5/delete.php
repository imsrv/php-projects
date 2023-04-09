<?php 
/*
 * $Header: /cvsroot/nocc/nocc/webmail/delete.php,v 1.23 2001/11/16 18:50:28 nicocha Exp $
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * this file just delete the selected message(s)
 */

session_register ('user', 'passwd');
require_once ('./conf.php');
require_once ('./functions.php');

$pop = @imap_open('{' . $servr . '}INBOX', $HTTP_SESSION_VARS['user'], safestrip($HTTP_SESSION_VARS['passwd']));
$num_messages = imap_num_msg($pop);

if (isset($only_one) && ($only_one == 1))
	imap_delete($pop, $mail, 0);
else
{
	for ($i = 1; $i <= $num_messages; $i++)
	{
		$delete_this_one = $HTTP_POST_VARS['msg-' . $i];
		if ($delete_this_one == 'Y')
			imap_delete($pop, $i, 0);
	}
}
imap_close($pop, CL_EXPUNGE);

header('Location: ' . $base_url . "action.php?sort=$sort&sortdir=$sortdir&lang=$lang&$php_session=" . $$php_session);
?>