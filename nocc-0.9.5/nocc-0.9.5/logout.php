<?php
/*
 * $Header: /cvsroot/nocc/nocc/webmail/logout.php,v 1.20 2001/11/04 21:34:19 rossigee Exp $
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * See the enclosed file COPYING for license information (GPL).  If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 */

require_once ('./conf.php');

session_start();
$old_theme = $theme;
if (isset($attach_array) && is_array($attach_array))
	while ($tmp = array_shift($attach_array))
		@unlink($tmpdir.'/'.$tmp->tmp_file);
session_destroy();
Header("Location: ".$base_url."index.php?lang=$lang&theme=$old_theme");
?>