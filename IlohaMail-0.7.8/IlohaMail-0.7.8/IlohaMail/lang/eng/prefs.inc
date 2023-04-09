<?
/********************************************************
	lang/eng/prefs.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$prefHeaderStrings = array(
											0=> "Preferences",
											1=>"General",
											2=>"Colors"
											);
											
$prefsStrings = array(
									"0.0" => "Identity",
									"0.1" => "Name: ",
									"0.2" => "Email: ",
									"1.0" => "International",
									"1.1" => "Interface: ",
									"1.2" => "Character Set: ",
									"1.3" => "Time Zone: ",
									"2.0" => "List View Options",
									"2.1" => "Show up to ",
									"2.2" => " items",
									"2.3" => "Show size",
									"2.4" => "Sort by: ",
									"2.5" => "",
									"2.6" => "Sort order: ",
									"2.7" => "",
									"2.8" => "Show folder list",
									"3.0" => "Auto-Save Options",
									"3.1" => "Save sent items.",
									"3.2"=> "Save sent messages in folder: ",
									"3.3" => "",
									"3.4" => "Automatically delete trash",
									"3.5" => "Move deleted items to folder: ",
									"3.6" => "",
									"3.7" => "Root Directory: ",
									"3.8" => "Other",
									"4.0" => "Message View Options",
									"4.1" => "View in frame",
									"4.2" => "Colorize quotes",
									"4.3" => "Turning on this option may slow down the system.",
                                    "4.4" => "Convert URLs to links",
									"4.5" => "Show HTML messages",
									"4.6" => "Show images inline",
									"5.0" => "Signature",
									"5.1" => "Show signature by default",
									"5.2" => ""
									);

$sort_fields=array("DATE"=>"Date", "SUBJECT"=>"Subject", "SIZE"=>"Size");
$sort_orders=array("ASC"=>"Ascending", "DESC"=>"Descending");

$prefsButtonStrings = array( 0=> "Update", 1=>"Apply", 2=> "Cancel", 3=> "Defaults");

$prefs_new_user = "You seem to be logging in for the first time...welcome!<br>";
$prefs_new_user .= "Please go through the following settings, then press \"Apply\"";
?>