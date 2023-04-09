<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: error.php3,v 1.6 2001/05/27 23:27:02 fluffy Exp $

if (!$ERROR_INCLUDED)
{
	$ERROR_INCLUDED = 1;

	// just outputs an error message.  maybe ought to add an option <HTML> output thing
	function reportError($error_string, $during_string="")
	{
		echo("An error occured $during_string. ");
		?>
If you continue to receive this error, please e-mail
<? echo "<A HREF=\"mailto:" . $GLOBALS["CONFIG"]["errormailto"] . "\">" . $GLOBALS["CONFIG"]["errormailto"]. "</A>"; ?>
 with a description of what you were doing when the error occured,
along with the following message:<BR>
		<?
		echo("<I>" . $error_string . "</I><BR>");
	}
}
?>
