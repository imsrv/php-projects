<?php

// shouldn't have to modify anything in this file...

include("config.inc");

$FILTER			= $IMAP_SERVER_TYPE == "Cyrus" ? "INBOX" : $PROG_DIR;
$IMAP_STR 		= "{".$IMAP_SERVER.":".$IMAP_PORT."}";

function mailbox_log_in( $folder )
{
	global $PROG_DIR, $IMAP_STR, $user, $pass;
	error_reporting(error_reporting() - 2);

	$folder = $folder == "INBOX" ? "INBOX" : construct_folder_str($folder);
	$mbox = imap_open("$IMAP_STR$folder", $user , $pass);

	error_reporting(error_reporting() + 2);
	return $mbox;
}

function construct_folder_str( $folder )
{
	// Cyrus style: INBOX.Junque
	// UWash style: ./aeromail/Junque

	global $IMAP_SERVER_TYPE, $PROG_DIR;

	$folder_str = $IMAP_SERVER_TYPE == "Cyrus" ? "INBOX." . $folder : $PROG_DIR . $folder;
	return $folder_str;
}

function deconstruct_folder_str( $folder )
{
	// Cyrus style: INBOX.Junque
	// UWash style: ./aeromail/Junque

	global $IMAP_SERVER_TYPE, $PROG_DIR;

	$srch_str = $IMAP_SERVER_TYPE == "Cyrus" ? "INBOX." : $PROG_DIR;

	$folder_str = substr($folder, strlen($srch_str), strlen($folder));

	return $folder_str;
}

function removecrlf($string)
{
	return strtr($string, "\015\012", "  ");
}

function decode_header_string($hed_str)
{
	$output = "Empty String";

	if($hed_str)
	{
		if(substr($hed_str, 0, 2) == "=?")
		{
			$start_pos = strpos($hed_str, "?", 2);
			$type = substr($hed_str, $start_pos + 1, 1);
			$newstr = substr($hed_str, $start_pos + 3, strlen($hed_str) - ($start_pos + 5));

			if (strtoupper($type) == "Q")
			{
				$output = str_replace("_", " " , quoted_printable_decode($newstr));
			}
			if (strtoupper($type) == "B")
			{
				$output = base64_decode($newstr);
			}
		}
		else
		{
			$output = $hed_str;
		}
	}
	return $output;
}

function list_folders( $mailbox )
{
	global $FILTER, $IMAP_STR;

	$mailboxes = imap_listmailbox($mailbox, $IMAP_STR, "$FILTER*");
	if($mailboxes)
	{
		sort($mailboxes);
		$num_boxes = count($mailboxes);
		if ($FILTER != "INBOX") { echo "<option>INBOX"; }
		for ($index = 0; $index < $num_boxes; $index++)
		{
			$nm = substr($mailboxes[$index], strrpos($mailboxes[$index], "}") + 1, strlen($mailboxes[$index]));
			echo "<option>";
			if ($nm != "INBOX")
			{
				echo deconstruct_folder_str($nm);
			}
			else
			{
				echo "INBOX";
			}
			echo "\n";
		}
	}
	else
	{
		echo "<option>INBOX";
	}
}

function get_mime_type($de_part)
{
	switch ($de_part->type)
	{
		case TYPETEXT:		$mime_type = "text"; break;
		case TYPEMESSAGE:	$mime_type = "message"; break;
		case TYPEAPPLICATION:	$mime_type = "application"; break;
		case TYPEAUDIO:		$mime_type = "audio"; break;
		case TYPEIMAGE:		$mime_type = "image"; break;
		case TYPEVIDEO:		$mime_type = "video"; break;
		case TYPEMODEL:		$mime_type = "model"; break;
		default:		$mime_type = "unknown";
	}
	return $mime_type;
}

function get_mime_encoding($de_part)
{
	switch ($de_part->encoding)
	{
		case ENCBASE64:			$mime_encoding = "base64"; break;
		case ENCQUOTEDPRINTABLE:	$mime_encoding = "qprint"; break;
		case ENCOTHER:			$mime_encoding = "other"; break;
		default:			$mime_encoding = "other";
	}
	return $mime_encoding;
}

function get_att_name($de_part)
{
	$att_name = "Unknown";
	for ($i = 0; $i < count($de_part->parameters); $i++)
	{
		$param = $de_part->parameters[$i];
		if ($param->attribute == "NAME")
		{
			$att_name = $param->value;
		}
	}
	return $att_name;
}

function attach_display($de_part, $part_no)
{
	global $mailbox, $folder, $msgnum;
	$mime_type = get_mime_type($de_part);
	$mime_encoding = get_mime_encoding($de_part);

	$att_name = "unknown";

	for ($i = 0; $i < count($de_part->parameters); $i++)
	{
		$param = $de_part->parameters[$i];
		if ($param->attribute == "NAME")
		{
			$att_name = $param->value;
			$url_att_name = urlencode($att_name);
		}
	}

	$jnk = "<a href=\"get_attach.php?folder=$folder&msgnum=$msgnum&part_no=$part_no";
	$jnk .= "&type=$mime_type&subtype=$de_part->subtype&name=$url_att_name&encoding=$mime_encoding";
	$jnk .= "\">$att_name</a>";
	return $jnk;
}

function inline_display($de_part, $part_no)
{
	global $mailbox, $folder, $msgnum, $L_MIME_SECTION;
	$mime_type = get_mime_type($de_part);
	$mime_encoding = get_mime_encoding($de_part);

	$dsp = imap_fetchbody($mailbox, $msgnum, $part_no);

	$tag = "pre";
	$jnk = $de_part->ifdisposition ? $de_part->disposition : "unknown";

	//echo "<!-- MIME disp: $jnk -->\n";
	//echo "<!-- MIME type: $mime_type -->\n";
	//echo "<!-- MIME subtype: $de_part->subtype -->\n";
	//echo "<!-- MIME encoding: $mime_encoding -->\n";
	//echo "<!-- MIME filename: $att_name -->\n";

	if ($mime_encoding == "qprint") {
		$dsp = imap_qprint($dsp);
		$tag = "tt";
	}

	if (strtoupper($de_part->subtype) == "PLAIN")
	{
		$dsp = htmlentities($dsp);

		if ($mime_encoding == "qprint") {
			$dsp = nl2br($dsp);
		}

		$dsp = make_clickable($dsp);
		echo "<$tag>$dsp</$tag>\n";
	}
	else if (strtoupper($de_part->subtype) == "HTML")
	{
		output_bound("$L_MIME_SECTION:" , "$mime_type/$de_part->subtype");
		echo $dsp;
	}
	else
	{
		output_bound("$L_MIME_SECTION:" , "$mime_type/$de_part->subtype");
		echo "<$tag>$dsp</$tag>\n";
	}
}

function output_bound($title, $str)
{
	global $COLOR_TITLE, $COLOR_HEAD, $COLOR_ROW_ON, $FONT;

	echo "</td></tr></table>\n";
	echo "<table border=0 cellpadding=0 cellspacing=0 width=700><tr><td bgcolor=$COLOR_HEAD>\n";
	echo "<table border=0 cellpadding=5 cellspacing=1 width=700>\n<tr>";
	echo "<td bgcolor=$COLOR_TITLE valign=top><font size=2 face=$FONT><b>$title</b></td>\n";
	echo "<td bgcolor=$COLOR_ROW_ON width=570><font size=2 face=$FONT>";
	echo "$str</td></tr></table></td></tr></table>\n<p>\n";
	echo "<table border=0 cellpadding=2 cellspacing=0 width=100%><tr><td>";
}

function image_display($folder, $msgnum, $de_part, $part_no, $att_name)
{
	global $L_IMAGE;

	output_bound("$L_IMAGE:" , $att_name);
	echo "\n<img src=\""; 
	echo "view_image.php?folder=" . urlencode($folder) . "&msgnum=$msgnum&part_no=$part_no";
	echo "&type=$de_part->subtype&name=$att_name\">\n<p>\n";
}

// function make_clickable ripped off from PHPWizard.net
// http://www.phpwizard.net/phpMisc/
// modified to make mailto: addresses compose in AeroMail

function make_clickable($text)
{
	global $folder;
	$ret = eregi_replace( "([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])",
		"<a href=\"\\1://\\2\\3\" target=\"_new\">\\1://\\2\\3</a>", $text);
	$ret = eregi_replace( "(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))",
		"<a href=\"compose.php?folder=" . urlencode($folder) . "&to=\\1\">\\1</a>", $ret);
	return($ret);
}

function login_prompt()
{
	global $PROG_NAME, $SERVER_REDIR;

	Header("WWW-Authenticate: Basic realm=\"$PROG_NAME\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=$SERVER_REDIR\">";
	exit;
}

if ((!$PHP_AUTH_USER) or (!$PHP_AUTH_PW) or ($time > time()))
{
	login_prompt();
} 
else
{ 
	if($PHP_AUTH_USER && $PHP_AUTH_PW)
	{
		$user = $PHP_AUTH_USER;
		$pass = $PHP_AUTH_PW;
		$folder = !$folder ? "INBOX" : $folder;
		$mailbox = mailbox_log_in($folder);

		if(!$mailbox)
		{
			login_prompt();
		}
	}
} 

?>
