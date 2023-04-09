<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: permissions.php3,v 1.5 2001/05/27 23:26:46 fluffy Exp $  

if (!$PERMISSIONS_INCLUDED)
{
	$PERMISSIONS_INCLUDED = 1;

	$pNone = $pReadOnly = -1;
	$pDefault = $pSubmit = 0;

	$pApproveOwn = 1;
	$pApproveOther = 2 * $pApproveOwn;
	$pApproveAll = $pApproveOwn + $pApproveOther;

	$pDeleteOwn = 4;
	$pDeleteOther = 2 * $pDeleteOwn;
	$pDeleteAll = $pDeleteOwn + $pDeleteOther;

	$pModifyOwn = 16;
	$pModifyOther = 2 * $pModifyOwn;
	$pModifyAll = $pModifyOwn + $pModifyOther;

// Configure items lets someone edit items in the lists of locations,
//  categories, audiences, etc
	$pConfigureItems = 64;
// Configure calendar lets someone edit pretty much everything else,
//  including users' permissions.
	$pConfigureCalendar = 2 * $pConfigureItems;
	$pConfigureAll = $pConfigureItems + $pConfigureCalendar;

	$pGod = $pApproveAll + $pDeleteAll + $pChangeAll + $pConfigureAll;
}
?>
