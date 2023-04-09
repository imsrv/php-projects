<?php

$templates='notes,noterow,notes_menu,';
$settings='note_limit,notepageoldestfirst,notesatonce,noteboxsize,notepagerefreshtime,';
$wordbits='oldestnotemessage,newestnotemessage,';
$suppressnotes=1;

include('./lib/config.php');

$totalnotes=$dbr->result("SELECT COUNT(noteid) FROM arc_note");
$notesperpage=getSetting('notesatonce');
$limit=$notesperpage;
$offset=getoffset();
$temp='';
$submitnote=getwordbit('submitnote');
$nbs=getSetting('noteboxsize');
$ntt=$notes;
$thisnoterow=$noterow;
$header=str_replace('<pagemenu>', getTemplate('notes_menu'), $header);
$toolbar="<form name=\"notefrm\" action=\"post.php?action=postnote\" method=\"post\">
			<input type=\"hidden\" name=\"saction\" value=\"$REQUEST_URI\" />
			<input type=\"text\" name=\"notemsg\" value=\"\" size=\"$nbs\" maxlength=\"150\" />
			<input type=\"submit\" value=\"$submitnote\" name=\"postnote\" /></form>";
if (getsetting('notepageoldestfirst')==1) {
	$sort='ASC';
	$status=getwordbit('oldestnotemessage');
} else {
	$sort='DESC';
	$status=getwordbit('newestnotemessage');
}

if ($action=='archive') {

	if ($totalnotes>0) {
		$notesquery=$dbr->query("SELECT arc_note.*,arc_user.displayname FROM arc_note,arc_user WHERE arc_user.userid=arc_note.noteuserid ORDER BY noteid $sort LIMIT $offset, $limit");

		while ($notes=$dbr->getarray($notesquery)) {
			$row=$thisnoterow;
			$thisusername="<a href=\"$webroot/user.php?action=profile&id=$notes[noteuserid]\">". dehtml($notes['displayname']). "</a>";

			$row=str_replace('<username>', $thisusername, $row);
			$row=str_replace('<noteid>', $notes['noteid'], $row);
			$row=str_replace('<timestamp>', formdate($notes['ntimestamp'], getSetting('note_timestamp')), $row);
			$row=str_replace('<content>', bbcode_replace(parseurl(htmlspecialchars(stripslashes($notes['notemessage'])))), $row);

			$temp.=$row;
		}

		if ($loggedin==0) $toolbar=$smallfont.getwordbit('cantpostnote').$cs;

		$ntt=str_replace('<submitbutton>', $toolbar, $ntt);
		$ntt=str_replace('<pagelinks>', pagelinks($limit,$totalnotes,$offset, 'note'), $ntt);
		$ntt=str_replace('<totalnotes>', number_format($totalnotes), $ntt);
		$ntt=str_replace('<offset>', number_format($offset), $ntt);
		$ntt=str_replace('<offsetplus>', number_format($offset+$limit), $ntt);
		$ntt=str_replace('<limit>', number_format($limit), $ntt);
		$ntt=str_replace('<noterow>', $temp, $ntt);
		$ntt=str_replace('<status>', $status, $ntt);
		if ($offset!=0)
			$ntt=str_replace('<prevpage>', "<a href=\"note.php?action=archive&offset=".($offset-$limit)."\">&laquo; Last Page</a>", $ntt);
		if (($offset+$limit)<$totalnotes)
			$ntt=str_replace('<nextpage>', "<a href=\"note.php?action=archive&offset=".($offset+$limit)."\">Next Page &raquo;</a>", $ntt);


		doHeader("$sitename: Notes");
		echo $ntt;
		footer();

	} elseif ($totalnotes==0) {
		doHeader("$sitename: There are no notes yet");
		showmsg('nonotesyet');
		footer();
	}
} elseif ($action=='news') {

	doHeader("$sitename: Notes Sector");
	echo "<iframe src=\"note.php?action=text\" width=\"100%\" height=\"300\"></iframe><center>$toolbar</center>";
	footer();

} elseif ($action=='text') {

	$refreshtime=getSetting('notepagerefreshtime');

	$ntt=str_replace('<status>', $status, $ntt);
	$ntt=str_replace('<notesperpage>', $notesperpage, $ntt);
	$ntt=str_replace('<totalnotes>', number_format($totalnotes), $ntt);
	$ntt=str_replace('<offset>', number_format($offset), $ntt);
	$ntt=str_replace('<offsetplus>', number_format($offset+$limit), $ntt);
	$ntt=str_replace('<limit>', number_format($limit), $ntt);

	if ($totalnotes>0) {
		$notesquery=$dbr->query("SELECT arc_note.*,arc_user.displayname FROM arc_note,arc_user WHERE arc_user.userid=arc_note.noteuserid ORDER BY noteid DESC LIMIT 0, $limit");

		while ($notes=$dbr->getarray($notesquery)) {
			$row=$thisnoterow;
			$thisusername="<a href=\"$webroot/user.php?action=profile&id=$notes[noteuserid]\" target=\"_parent\">". dehtml($notes['displayname']). "</a>";

			$row=str_replace('<username>', $thisusername, $row);
			$row=str_replace('<noteid>', $notes['noteid'], $row);
			$row=str_replace('<timestamp>', formdate($notes['ntimestamp'], getSetting('note_timestamp')), $row);
			$row=str_replace('<content>', bbcode_replace(parseurl(htmlspecialchars(stripslashes($notes['notemessage'])))), $row);

			$temp.=$row;
		}

		if ($loggedin==0) $toolbar=$smallfont.getwordbit('cantpostnote').$cs;

		$ntt=str_replace('<noterow>', $temp, $ntt);
		echo "<html>
<head>
<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$refreshtime;URL=note.php?action=text\">
<style type=\"text/css\">
BODY { $bodycss cursor: $cursor;margin: 0px; }
A:LINK { color:$linkcolor;font-weight: $linkweight;text-decoration:$linkdecoration;cursor:$linkcursor; }
A:VISITED { color:$vlinkcolor;font-weight:$linkweight;text-decoration:$linkdecoration;cursor:$linkcursor; }
A:ACTIVE { color:$alinkcolor;font-weight:$linkweight;text-decoration:$linkdecoration;cursor:$linkcursor; }
A:HOVER { color:$hovercolor;font-weight:$hoverweight;font-style:$hoverstyle;cursor:$linkcursor; }
</style>
</head>
<body bgcolor=\"$bgcolor\" text=\"$fontcolor\">".$ntt.'</body></html>';
	}
}


?>