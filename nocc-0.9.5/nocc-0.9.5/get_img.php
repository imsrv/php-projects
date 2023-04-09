<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/get_img.php,v 1.15 2001/11/16 13:21:42 rossigee Exp $
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 */

session_register ('user', 'passwd');
require_once ('./conf.php');
require_once ('./functions.php');
$passwd = safestrip($passwd);

$pop = @imap_open('{'.$servr.'}INBOX', $user, $passwd);
$img = imap_fetchbody($pop, $mail, $num);
imap_close($pop);
if ($transfer == 'BASE64')
	$img = base64_decode($img);
elseif ($transfer == 'QUOTED-PRINTABLE')
	$img = imap_qprint($img);

header('Content-type: image/'.$mime);
echo $img;
?>