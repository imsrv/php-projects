<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: gettext.php3,v 1.4 2001/05/30 21:17:04 fluffy Exp $

if (!isSet($GETTEXT_INCLUDED))
{
	$GETTEXT_INCLUDED = 1;

	// Since gettext doesn't seem to like translating strings with
	// variables, I'm making a little thing that takes a string and
	// an array of variables to substitute for %s1, %s2, etc
	function _wv($string, $array)
	{
		// First translate the string
		$output = _($string);

		// Then the "with variables" part.
		// We start at the high end of the array, so
		// "%s10" doesn't get replaced by "%s1"
		for ($i = count($array); $i > 0; $i--)
		{
			$output = ereg_replace("%s$i", $array[$i-1] . "",
				$output);
		}
		return $output;
	}
}
?>
