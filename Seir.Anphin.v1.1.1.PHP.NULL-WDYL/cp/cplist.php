<?php

$settings='setting_limit,user_limit,pagebit_limit,current_template_set,template_limit,forum_limit,styleset_limit,shrine_limit,rank_limit,';
$settings.='quote_limit,faq_limit,poll_limit,polla_limit,faqgroup_limit,avatar_limit,wordbit_limit,post_limit,topic_limit,dlcat_limit,';
$settings.='download_limit,note_limit,';

$dir = '../';
require($dir.'lib/config.php');

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body text="#000000" bgcolor="#ffffff" alink="#c05030" vlink="#000000" link="#000000">
<?php

require($dir.'adminfunctions.php');

if (empty($where)) {
	$where='';
} else {
	$where=stripslashes($where);
}

switch ($action) {
	case 'viewsettings':
		if (isset($HTTP_GET_VARS['settingtype']))
			$settingtype=$HTTP_GET_VARS['settingtype'];
		if (empty($settingtype))
			$settingtype=$HTTP_GET_VARS['type'];
		getgenericlist("SELECT settingid,settingname FROM arc_setting WHERE settinggroup='$settingtype' ORDER BY settingid", "Setting");
		break;

	case 'wordbitlist':
		if (isset($HTTP_GET_VARS['wordbitgroup']))
			$wordbitgroup=$HTTP_GET_VARS['wordbitgroup'];
		if (empty($wordbitgroup))
			$wordbitgroup=$HTTP_GET_VARS['type'];
		getgenericlist("SELECT wordbitid,wordbitname FROM arc_wordbit WHERE wordbitgroup='$wordbitgroup' ORDER BY wordbitid", "Wordbit");
		break;

	case 'avatarlist':
		getgenericlist("SELECT avatarid,avatar FROM arc_avatar$where ORDER BY avatar", 'Avatar');
		break;

	case 'dlcatlist':
		getgenericlist("SELECT dlcatid,name FROM arc_dlcat$where ORDER BY dlcatid", 'DLCat');
		break;

	case 'downloadlist':
		getgenericlist("SELECT downloadid,name FROM arc_download$where ORDER BY downloadid", 'Download');
		break;

	case 'faqlist':
		getgenericlist("SELECT faqid,faqq FROM arc_faq$where ORDER BY faqid", 'FAQ');
		break;

	case 'faqgrouplist':
		getgenericlist("SELECT faqgroupid,faqgroupname FROM arc_faqgroup$where ORDER BY faqgroupid", 'FAQGroup', 1);
		break;

	case 'forumlist':
		getgenericlist("SELECT forumid,forumname FROM arc_forum$where ORDER BY forumid", 'Forum', 1);
		break;

	case 'guestbooklist':
		getgenericlist("SELECT guestid,guestname FROM arc_guestbook$where ORDER BY guestid", 'Guest', 1);
		break;

	case 'notelist':
		getgenericlist("SELECT noteid,notemessage FROM arc_note$where ORDER BY noteid DESC", 'Note', 1);
		break;

	case 'pagelist':
		getgenericlist("SELECT pagebitid,ptitle FROM arc_pagebit$where ORDER BY pagebitid", 'Pagebit', 1);
		break;

	case 'polllist':
		getgenericlist("SELECT pollid,question FROM arc_poll$where ORDER BY pollid", 'Poll', 1);
		break;

	case 'pollanswerlist':
		getgenericlist("SELECT pollaid,answer FROM arc_polla$where ORDER BY pollaid", 'Polla');
		break;

	case 'postlist':
		getgenericlist("SELECT postid,posttitle FROM arc_post$where ORDER BY postid", 'Post', 1);
		break;

	case 'quotelist':
		getgenericlist("SELECT quoteid,quote FROM arc_quote $where ORDER BY quoteid", 'Quote', 1);
		break;

	case 'ranklist':
		getgenericlist("SELECT rankid,rank FROM arc_rank$where ORDER BY minlvl,rankid", 'Rank');
		break;

	case 'topiclist':
		getgenericlist("SELECT topicid,ttitle FROM arc_topic$where ORDER BY topicid", 'Topic', 1);
		break;

	case 'templatelist':
		echo "$cpfont Current active template set: <b>" .getSetting('current_template_set'). '</b><br />';
		getgenericlist("SELECT templateid,templatename FROM arc_template WHERE templategroup='" .stripslashes(getSetting('current_template_set')). "' ORDER BY templatename", "Template");
		break;

	case 'shrinelist':
		getgenericlist("SELECT shrineid,shrinekey FROM arc_shrine$where ORDER BY shrinekey", 'Shrine');
		break;

	case 'stylesetlist':
		getgenericlist("SELECT stylesetid,stylesetname FROM arc_styleset$where ORDER BY stylesetid", 'Styleset', 1);
		break;

	case 'userlist':
		getgenericlist("SELECT userid,username FROM arc_user $where ORDER BY userid", 'User', 1);
		break;

	case 'seeavatars':
		$fromdb=array();
		$query=$dbr->query("SELECT * FROM arc_avatar");

		while ($avatars=$dbr->getarray($query)) {
			$fromdb[]=$avatars['avatar'];
		}
		$fromdir=array();
		$dh=opendir("./lib/images/avatars/");

		while ($file=readdir($dh)) {
			if (!preg_match("/\.\.?$/", $file)) $fromdir[]=$file;
		}

		closedir($dh);
//		echo '<br />FROM DATABASE<br /><pre>';
//		print_r($fromdb);
//		echo '</pre><br />FROM DIRECTORY<br /><pre>';
//		print_r($fromdir);
//		echo '</pre>';

		$numrows=mysql_num_rows($query);
		$avsleft=array_diff($fromdir, $fromdb);
		$inputs['1']=formtop('admin.php?action=addavatars');
		$x=2;

		foreach($avsleft as $key => $file) {
			$inputs[$x]=inputform('avatar', '', '', $file);
			$x=$x+1;
			if ($isadmin==1) {
				$inputs[$x]=inputform('checkbox', avatardecode($file), "addme[$file]", 1);
				$x=$x+1;
			}
			flush();
		}
		$x=$x+1;

		$inputs[$x]=inputform('submitreset', 'Add Selected Avatars', "No.. wait.. don't do it", 'selectall()');
		foreach ($inputs as $value)
			echo "$value\n";

		formbottom();
		break;

	case 'templatesetlist':
		echo "$cpfont Current active template set: <b>" .getSetting('current_template_set'). '</b><br />';
		$t=$dbr->query("SELECT DISTINCT templategroup FROM arc_template ORDER BY templatename");
		$inputs[]=formtop('admin.php');
		while ($a=$dbr->getarray($t)) {
			$inputs[]=inputform('radio', $a['templategroup'], 'templategroup', $a['templategroup']);
		}
		$inputs[]=inputform('submit', '', 'action', 'Activate selected template set');
		$inputs[]=inputform('submit', '', 'action', 'Delete selected template set');
		foreach ($inputs as $v) echo $v;
		formbottom();
		break;
}


?>
</body>
</html>
<?php

if (getSetting('gzcompress')==1)
	ob_end_flush();

?>