<?php

$templates='cp_mainpage,';
$wordbits='prune_by_date,datepruneconfirm,edit_user_loginname,';
$settings='post_timestamp,current_template_set,';

$dir = '../';
require($dir.'lib/config.php');
require($dir.'adminfunctions.php');

if ($isadmin==1) {

if ($action=="news" || empty($action)) $action='stats';
if (empty($id)) $id='0';

if (isset($HTTP_POST_VARS['query'])) {
	$query=stripslashes($HTTP_POST_VARS['query']);
	$dbr->query($query);
	if (mysql_error()!='') {
		showmsg("<br>error on query <b>" .htmlspecialchars($query). "</b>. <br>MySQL says: " .mysql_error(), 1);
	} else {
		echo "{$cpfont}Query <b>$query</b> completed successfully.";
	}
} else {
	$query='';
}

if ($action=='export+templateset') {
	$nostril=$dbr->query("SELECT templatename,
					templatedesc,
					templatevalue,
					templategroup
				FROM arc_template
				WHERE templategroup='$extemplategroup'
				ORDER BY templatename");

	$export_html='';


	while ($flea=$dbr->getarray($nostril)) {
		if ($export_as=='') {
			$exportgroup=$flea['templategroup'];
		} else {
			$exportgroup=$export_as;
		}
		$export_html.="INSERT INTO arc_template SET templatename='" .addslashes($flea['templatename']). "', templatedesc='" .addslashes($flea['templatedesc']). "', templatevalue='" .eol_out(addslashes($flea['templatevalue'])). "', templategroup='" .addslashes($exportgroup). "'\n";
	}

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' .fileencode($exportgroup). '.spiffy"');
	echo $export_html;
	exit;
}
if ($action=='export+styleset') {
	$puck=$dbr->query("SELECT *
				FROM arc_styleset
				WHERE stylesetname='$exstylesetname'");

	$export_html='';
	while ($s=$dbr->getarray($puck)) {
		$export_html.="INSERT INTO arc_styleset SET stylesetname='" .eol_out($s['stylesetname']).
		"', reqtemplateset='" .eol_out($s['reqtemplateset']).
		"', headtaginsert='" .eol_out($s['headtaginsert']).
		"', bodytaginsert='" .eol_out($s['bodytaginsert']).
		"', fontcolor='" .eol_out($s['fontcolor']).
		"', bgcolor='" .eol_out($s['bgcolor']).
		"', linkcolor='" .eol_out($s['linkcolor']).
		"', alinkcolor='" .eol_out($s['alinkcolor']).
		"', vlinkcolor='" .eol_out($s['vlinkcolor']).
		"', linkdecoration='" .eol_out($s['linkdecoration']).
		"', linkweight='" .eol_out($s['linkweight']).
		"', linkcursor='" .eol_out($s['linkcursor']).
		"', hovercolor='" .eol_out($s['hovercolor']).
		"', hoverstyle='" .eol_out($s['hoverstyle']).
		"', hoverweight='" .eol_out($s['hoverweight']).
		"', cursor='" .eol_out($s['cursor']).
		"', tablebordercolor='" .eol_out($s['tablebordercolor']).
		"', tablebgcolor='" .eol_out($s['tablebgcolor']).
		"', alttablebgcolor='". eol_out($s['alttablebgcolor']).
		"', tdbgcolor='" .eol_out($s['tdbgcolor']).
		"', tdheadbgcolor='" .eol_out($s['tdheadbgcolor']).
		"', tdendbgcolor='" .eol_out($s['tdendbgcolor']).
		"', hilightcolor='" .eol_out($s['hilightcolor']).
		"', shadowcolor='" .eol_out($s['shadowcolor']).
		"', smallfont='" .eol_out($s['smallfont']).
		"', normalfont='" .eol_out($s['normalfont']).
		"', largefont='" .eol_out($s['largefont']).
		"', cs='" .eol_out($s['cs']).
		"', cn='" .eol_out($s['cn']).
		"', cl='" .eol_out($s['cl']).
		"', bodycss='" .eol_out($s['bodycss']).
		"', logo='" .eol_out($s['logo']).
		"', newtopicpath='" .eol_out($s['newtopicpath']).
		"', newreplypath='" .eol_out($s['newreplypath']).
		"', formwidth=" .eol_out($s['formwidth']).
		",  textarea_rows=" .eol_out($s['textarea_rows']);
	}

	header('Content-Type: application/octet-stream');
	header("Content-Disposition: attachment; filename=\"" .fileencode($exstylesetname). ".tier\"");
	echo $export_html;
	exit();
}

?>
<html>
<!-- action = <?php echo $action; ?> -->
<head>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body text="#000000" bgcolor="#ffffff" alink="#ffffff" vlink="#000000" link="#000000">
<font size="-1" color="#000000" face="arial">
<?php

switch ($action) {
	case 'import_styleset':
		$inputs[]=formtop('admin.php');
		$inputs[]=inputform('file', 'Style SQL File', 'imported_style', '', 50, 9999999);
		$inputs[]=inputform('submit', '', 'action', 'Import Styleset');
		doinputs();
		formbottom();
		break;

	case 'import+styleset':
		$sfile=$HTTP_POST_FILES['imported_style']['tmp_name'];
		$sname=$HTTP_POST_FILES['imported_style']['name'];
		if (isset($sfile)) {
			$ssql=file($sfile);
			foreach($ssql as $i=>$line) {
				$ssql[$i]=eol_in(rtrim($line));
				$dbr->query($ssql[$i]);
				echo "$cpfont Query:<br>$ssql[$i] executed.<br><br>Styleset <b>$sname</b> has been successfully imported.";
			}

		} else {
			echo "{$cpfont}File could not be uploaded.";
		}
		break;

	case 'import_templateset':
		$inputs[]=formtop('admin.php');
		$inputs[]=inputform('file', 'Template Set SQL File', 'imported_template', '', 50, 9999999);
		$inputs[]=inputform('submit', '', 'action', 'Import Templateset');
		doinputs();
		formbottom();
		break;

	case 'import+templateset':
		$tmp=$HTTP_POST_FILES['imported_template']['tmp_name'];
		$tmpname=$HTTP_POST_FILES['imported_template']['name'];
		if (isset($tmp)) {
			$tsql=file($tmp);
			echo "$cpfont Executing queries...<br>\n";
			foreach($tsql as $templatename=>$line) {
				$tsql[$templatename]=eol_in($line);
				$dbr->query($tsql[$templatename]);
				echo htmlspecialchars(stripslashes($tsql[$templatename])). '<br>';
			}
			echo "<br><br>Template set <b>$tmpname</b> has been successfully imported.";
		} else {
			echo "{$cpfont}File could not be uploaded.";
		}
		break;

	case 'export_templateset':
		$tdata=$dbr->query('SELECT DISTINCT templategroup FROM arc_template');
		$inputs[]=formtop('admin.php');
		while ($tarr=$dbr->getarray($tdata)) {
			$inputs[]=inputform('radio', $tarr['templategroup'], 'extemplategroup', $tarr['templategroup']);
		}
		$inputs[]=inputform('text', 'Export templates as group (leave blank to retain current template group name)', 'export_as', '');
		$inputs[]=inputform('submit', '', 'action', 'Export Templateset');
		doinputs();
		formbottom();
		break;

	case 'export_styleset':
		$sdata=$dbr->query('SELECT stylesetid,stylesetname FROM arc_styleset');
		$inputs[]=formtop('admin.php');
		while ($sarr=$dbr->getarray($sdata)) {
			$inputs[]=inputform('radio', $sarr['stylesetname'], 'exstylesetname', $sarr['stylesetname']);
		}
		$inputs[]=inputform('submit', '', 'action', 'Export Styleset');
		doinputs();
		formbottom();
		break;

	case 'activate+selected+template+set':
		$dbr->query("UPDATE arc_setting SET settingvalue='$templategroup' WHERE settingname='current_template_set'");
		echo "{$cpfont}The current template set has been set to <b>" .stripslashes($templategroup). "</b>.</font>";
		break;

	case 'delete+selected+template+set':

		$othertemplategroup = $dbr->result("SELECT templategroup FROM arc_template WHERE templategroup<>'$templategroup'");

		if ($othertemplategroup!='') {
			$dbr->query("UPDATE arc_user SET layout='$othertemplategroup' WHERE layout='$templategroup'");

			$dbr->query("DELETE FROM arc_template WHERE templategroup='$templategroup'");
			echo "{$cpfont}Template set <b>" .stripslashes($templategroup). "</b> has been deleted.</font>";
		} else {
			echo "{$cpfont}Error: Could not find an alternate template set. You cannot delete all of your template sets.</font>";
		}
		break;

	case 'banip':
		$userip=$dbr->result("SELECT user_ip FROM arc_user WHERE userid=$HTTP_GET_VARS[user]");
		$bannedips=$dbr->result("SELECT banned_ips FROM arc_misc");
		$bannedips.="$userip,";
		$dbr->query("UPDATE arc_misc SET banned_ips='$bannedips'");
		echo "{$cpfont}IP: <b>$userip</b> has been added to the banned list.</font>";
		break;

	case 'banaccount':
		$dbr->query("UPDATE arc_user SET isbanned=1 WHERE userid=$HTTP_GET_VARS[user]");
		echo "{$cpfont}Account <a href=\"user.php?action=profile&id=$HTTP_GET_VARS[user]\">#$HTTP_GET_VARS[user]</a> has been banned.</font>";
		break;

	case 'savemisc':
		$dbr->query("UPDATE arc_misc SET
					 banned_ips='$banned_ips',
					 maxquote='$maxquote',
					 adminname='" .dbPrep($adminname). "',
					 modname='" .dbPrep($modname). "',
					 lastuserid=$lastuserid,
					 numusers=$nnumusers,
					 numtopics=$numtopics,
					 numposts=$numposts,
					 numpolls=$numpolls,
					 lastusername='$lastusername'");
		echo 'Misc fields saved.';
		$dbr->query("UPDATE arc_user SET rank='" .dbPrep($adminname). "' WHERE rank='" .dbPrep($oldadminname). "'");
		$dbr->query("UPDATE arc_user SET rank='" .dbPrep($modname). "' WHERE rank='" .dbPrep($oldmodname). "'");

	case 'editmisc':
		$misc=$dbr->query("SELECT * FROM arc_misc LIMIT 0,1");
		$m=$dbr->getarray($misc);

		getaddbitaction('savemisc', 'admin.php?action=');
		$inputs[]=inputform('text', 'Banned IP Addresses', 'banned_ips', $m['banned_ips']);
		$inputs[]=inputform('text', 'Administrator Rank Name', 'adminname', $m['adminname']);
		$inputs[]=inputform('hidden', '', 'oldadminname', $m['adminname']);
		$inputs[]=inputform('hidden', '', 'oldmodname', $m['modname']);
		$inputs[]=inputform('text', 'Moderator Rank Name', 'modname', $m['modname']);
		$inputs[]=inputform('text', 'Latest Registered UserID', 'lastuserid', $m['lastuserid']);
		$inputs[]=inputform('text', 'Latest Registered Username', 'lastusername', $m['lastusername']);
		$inputs[]=inputform('text', 'Number Registered Users', 'nnumusers', $dbr->result("SELECT COUNT(userid) FROM arc_user"));
		$inputs[]=inputform('text', 'Total number of topics', 'numtopics', $dbr->result("SELECT COUNT(topicid) FROM arc_topic"));
		$inputs[]=inputform('text', 'Total number of posts', 'numposts', $dbr->result("SELECT COUNT(postid) FROM arc_post"));
		$inputs[]=inputform('text', 'Total number of polls', 'numpolls', $dbr->result("SELECT COUNT(pollid) FROM arc_poll"));
		$inputs[]=inputform('text', 'Max quote ID', 'maxquote', $dbr->result("SELECT MAX(quoteid) FROM arc_quote"));
		$inputs[]=inputform('display', 'Installation Date', '', formdate($m['setupdate'], "l, F d g:i A, Y"));
		doinputs($inputs);
		geteditbitsubmit();
		break;

	case 'guestbook':
		viewGuestbook('yes');
		break;

	case 'prunedate':
		if (isset($submitdate)) {
			if ($amount=='') showmsg('no_prune_amount');
			if ($type=='days') $prune=60*60*24;
			if ($type=='weeks') $prune=60*60*24*7;
			if ($type=='months') $prune=60*60*24*7*30;
			$prune=time()-($prune * $amount);
			echo "$top1" .str_replace('<date>', formdate($prune, getSetting('post_timestamp')), getwordbit('datepruneconfirm')). "$top2";
			$ids=$dbr->query("SELECT topicid FROM arc_topic WHERE topicdate < $prune");
			$dbr->query("DELETE FROM arc_topic WHERE topicdate < $prune");
			while ($top=$dbr->getarray($ids)) {
				$dbr->query("DELETE FROM arc_post WHERE parentid=$top[topicid]");
			}
		} else {
			$msg=getwordbit('prune_by_date');
			$msg.='<form name="fawkj00" action="admin.php?action=prunedate" method="post">
Amount: <input type="text" name="amount"></input><br />
Unit: <select name="type">
  <option value="days" selected="selected">Days</option>
  <option value="weeks">Weeks</option>
  <option value="months">Months</option>
</select><br />
<input type="submit" name="submitdate" value="Perform Prune"></input>
<form>';
			showmsg($msg, 1);
		}
		break;

	case 'modify': /////////////////////////////////// ITEM DELETION
		if (isset($deleteavatar)) {
			deleterows('Avatar', $deleteavatar);
			exit();
		}
		if (isset($deletedlcat)) {
			deleterows('Dlcat', $deletedlcat);
			exit();
		}
		if (isset($deletedownload)) {
			deleterows('Download', $deletedownload);
			exit();
		}
		if (isset($deletefaq)) {
			deleterows('FAQ', $deletefaq);
			exit();
		}
		if (isset($deletefaqgroup)) {
			deleterows('FAQgroup', $deletefaqgroup);
			exit();
		}
		if (isset($deleteforum)) {
			deleterows('Forum', $deleteforum);
			exit();
		}
		if (isset($deleteguest)) {
			deleterows('Guest', $deleteguest, 'book');
			exit();
		}
		if (isset($deletemod)) {
			deleterows('Moderator', $deletemod);
			exit();
		}
		if (isset($deletepagebit)) {
			deleterows('Pagebit', $deletepagebit);
			exit();
		}
		if (isset($deletepost)) {
			deleterows('Post', $deletepost);
			exit();
		}
		if (isset($deletepoll)) {
			deleterows('Poll', $deletepoll);
			exit();
		}
		if (isset($deletepolla)) {
			deleterows('Polla', $deletepolla);
			exit();
		}
		if (isset($deletequote)) {
			deleterows('Quote', $deletequote);
			exit();
		}
		if (isset($deleterank)) {
			deleterows('Rank', $deleterank);
			exit();
		}
		if (isset($deleteshrine)) {
			deleterows('Shrine', $deleteshrine);
			exit();
		}
		if (isset($deletesetting)) {
			deleterows('Setting', $deletesetting);
			exit();
		}
		if (isset($deletestyleset)) {
			deleterows('Styleset', $deletestyleset);
			exit();
		}
		if (isset($deletetemplate))	{
			deleterows('Template', $deletetemplate);
//			$dbr->query("UPDATE arc_user SET templateset='default' WHERE
			exit();
		}
		if (isset($deletetopic)) {
			$x='0';
			while ($b=each($deletetopic)) {
				$dbr->query("DELETE FROM arc_topic WHERE topicid='$deletetopic[$x]'");
				echo "{$cpfont}Topic number <b>$deletetopic[$x]</b> has been deleted.</font><br />";
				$x=$x+1;
				$dbr->query("DELETE FROM arc_post WHERE parentid='$deletetopic[$x]'");
				echo "{$normalfont}Deleting any child posts automatically.</font><br />";
			}
			exit();
		}
		if (isset($deleteuser)) {
			deleterows('User', $deleteuser);
			exit();
		}
		if (isset($deletewordbit)) {
			deleterows('Wordbit', $deletewordbit);
			exit();
		}
		if (isset($HTTP_POST_VARS['submitavatar'])) { /////////////////////////////////// SAVE CHANGES ITEM QUERIES
			$dbr->query("UPDATE arc_avatar SET avatar='$avatarname' WHERE avatarid=$avatarid");
			echo "{$cpfont}Avatar <b>" .avatardecode($avatarname). "</b> has been updated.</font><br />";
			$edit='avatar'; $id=$avatarid;
		}
		if (isset($HTTP_POST_VARS['submitdlcat'])) {

			$numfiles = $dbr->result("SELECT COUNT(downloadid) FROM arc_download WHERE catid=$dlcatid");

			$dbr->query("UPDATE arc_dlcat SET
					name='" .dbPrep($name). "',
					description='" .dbPrep($description). "',
					parentid='" .dbPrep($parentid). "',
					files=" .dbPrep($numfiles). " WHERE dlcatid=$dlcatid");
			echo "{$cpfont}Category <b>" .stripslashes($name). "</b> has been updated.</font><br />";
			$edit='dlcat'; $id=$dlcatid;
		}
		if (isset($HTTP_POST_VARS['submitdownload'])) {

			// update num files in old category if is changed
			$oldcatid = $dbr->result("SELECT catid FROM arc_download WHERE downloadid=$downloadid");
			if ($oldcatid!=$catid) {
				$oldnumfiles = $dbr->result("SELECT files FROM arc_dlcat WHERE dlcatid=$oldcatid")-1;
				$dbr->query("UPDATE arc_dlcat SET files=$oldnumfiles WHERE dlcatid=$oldcatid");
			}

			$numfiles = $dbr->result("SELECT COUNT(downloadid) FROM arc_download WHERE catid=$catid");
			$dbr->query("UPDATE arc_dlcat SET files=$numfiles WHERE dlcatid=$catid");

			$dbr->query("UPDATE arc_download SET
					name='" .dbPrep($name). "',
					filepath='" .dbPrep($filepath). "',
					filesize='" .dbPrep($filesize). "',
					description='" .dbPrep($description). "',
					catid='" .dbPrep($catid). "',
					downloads=" .dbPrep($downloads). " WHERE downloadid=$downloadid");
			echo "{$cpfont}File <b>" .stripslashes($name). "</b> has been updated.</font><br />";
			$edit='download'; $id=$downloadid;
		}
		if (isset($HTTP_POST_VARS['submitfaq'])) {
			$dbr->query("UPDATE arc_faq SET
					faqq='" .dbPrep($faqq). "',
					faqa='" .dbPrep($faqa). "',
					faqgroup=" .dbPrep($faqgroup). " WHERE faqid=$faqid");
			echo "{$cpfont}FAQ Question <b>" .stripslashes($faqq). "</b> and answer <b>" .stripslashes($faqa). "</b> in group <b>" .stripslashes($dbr->result("SELECT faqgroupname FROM arc_faqgroup WHERE faqgroupid=$faqgroup LIMIT 0,1")). "</b> has been updated.</font><br />";
			$edit='faq'; $id=$faqid;
		}
		if (isset($HTTP_POST_VARS['submitfaqgroup'])) {
			$dbr->query("UPDATE arc_faqgroup SET
					faqgroupname='" .dbPrep($faqgroupname). "',
					faqgrouporder=$faqgrouporder
					WHERE faqgroupid=$faqgroupid");
			echo "{$cpfont}FAQ Group <b>" .stripslashes($faqgroupname). "</b> has been updated.</font><br />";
			$edit='faqgroup'; $id=$faqgroupid;
		}
		if (isset($HTTP_POST_VARS['submitforum'])) {
			if ($moduserid!=0) {
				$modusername=$dbr->result("SELECT displayname FROM arc_user WHERE userid='$moduserid'");
			} else {
				$moduserid=0;
				$modusername="";
			}
			$dbr->query("UPDATE arc_forum SET
					forumname='" .dbPrep($forumname). "',
					description='" .dbPrep($description). "',
					parentid=$parentid,
					open=$open,
					private=$private,
					modid=$moduserid,
					modusername='$modusername',
					lastposterid='$lastposter',
					lasttopicid='$lasttopic',
					showextras=$showextras,
					isforum=$isforum,
					forumtype=$forumtype,
					accesslvl=$accesslvl,
					topiccount=$topiccount,
					linkurl='$linkurl',
					fpassword='$fpassword',
					postcount=$postcount,
					forder=$forder WHERE forumid=$forumid");
			echo "{$cpfont}Forum <b>" .stripslashes($forumname). "</b> under parent <b>$parentid</b> has been updated.</font><br />";
			$edit='forum'; $id=$forumid;
		}
		if (isset($HTTP_POST_VARS['submitnote'])) {
			$dbr->query("UPDATE arc_note SET
					noteuserid='" .dbPrep($noteuserid). "',
					notemessage='" .dbPrep($notemessage). "'
					WHERE noteid=$noteid");
			echo "{$cpfont}Note ID <b>$noteid</b> has been updated.</font><br>";
			$edit='note'; $id=$noteid;
		}
		if (isset($HTTP_POST_VARS['submitpagebit'])) {
			$dbr->query("UPDATE arc_pagebit SET
					ptitle='" .dbPrep($ptitle). "',
					pcontent='" .dbPrep($pcontent). "',
					page='" .dbPrep(strtolower(urlencode($action_page))). "',
					porder=$porder,
					convertnewline=$convertnewline,
					puserid=$puserid,
					shrinekey='$shrinekey'
					WHERE pagebitid=$pagebitid");
			echo "{$cpfont}Pagebit <b>" .stripslashes($ptitle). "</b> on page <b>$action_page</b> has been updated.</font><br>";
			updatesearchindex($pcontent, $pagebitid, 'arc_pagebit', 1);
			$edit='pagebit'; $id=$pagebitid;
		}
		if (isset($HTTP_POST_VARS['submitpost'])) {
			$dbr->query("UPDATE arc_post SET
					postusername='" .dbPrep($postusername). "',
					posttitle='" .dbPrep($posttitle). "',
					postdate='" .time(). "',
					editusername='" .dbPrep($editusername). "',
					postcontent='" .dbPrep($postcontent). "' WHERE postid='$postid'");
			echo "{$cpfont}Post <b>" .stripslashes($posttitle). "</b> by user <b>$postusername</b> has been updated.</font><br>";
			updatesearchindex($postcontent, $postid, 'arc_post', 1);
			$edit='post'; $id=$postid;
		}
		if (isset($HTTP_POST_VARS['submitpoll'])) {
			$dbr->query("UPDATE arc_poll SET
					question='" .dbPrep($question). "',
					pvotes='" .dbPrep($pvotes). "'
					WHERE pollid='$pollid'");
			echo "{$cpfont}Poll <b>" .stripslashes($question). "</b> has been updated.</font><br>";
			$edit='poll'; $id=$pollid;
		}
		if (isset($HTTP_POST_VARS['submitpolla'])) {
			$dbr->query("UPDATE arc_polla SET
					answer='" .dbPrep($answer). "',
					votes='" .dbPrep($votes). "',
					pollid='" .dbPrep($pollid). "',
					users='" .dbPrep($users). "'
					WHERE pollaid='$pollaid'");
			echo "{$cpfont}Poll answer <b>" .stripslashes($answer). "</b> has been updated.</font><br>";
			$edit='polla'; $id=$pollaid;
		}
		if (isset($HTTP_POST_VARS['submitquote'])) {
			$dbr->query("UPDATE arc_quote SET
					quoteid=$newquoteid,
					quote='" .dbPrep($quote). "' WHERE quoteid=$quoteid");
			echo "{$cpfont}Quote <b>" .stripslashes($quote). "</b> has been updated.</font><br />";
			$edit='quote'; $id=$quoteid;
		}
		if (isset($HTTP_POST_VARS['submitrank'])) {
			$dbr->query("UPDATE arc_rank SET
					rank='" .dbPrep($newrank). "',
					minlvl=$minlvl WHERE rankid=$rankid");
			echo "{$cpfont}Rank <b>" .stripslashes($newrank). "</b> has been updated.</font><br />";
			$edit='rank'; $id=$rankid;
		}
		if (isset($HTTP_POST_VARS['submitsetting'])) {
			$dbr->query("UPDATE arc_setting SET
					settingname='" .dbPrep($settingname). "',
					settinggroup='" .dbPrep($settinggroup). "',
					settingdesc='" .dbPrep($settingdesc). "',
					settingvalue='" .dbPrep($settingvalue). "' WHERE settingid='$settingid'");
			echo "{$cpfont}Setting <b>" .stripslashes($settingname). "</b> in group <b>" .stripslashes($settinggroup). "</b> has been updated.</font><br />";
			$edit='setting'; $id=$settingid;
		}
		if (isset($HTTP_POST_VARS['submitshrine'])) {
			$susername=$dbr->result("SELECT username FROM arc_user WHERE userid=$suserid");
			$suserlvl=$dbr->result("SELECT level FROM arc_user WHERE userid=$suserid");
			if ($saccesslvl>$suserlvl) {
				echo "access level set too high";
				exit();
			}
			$dbr->query("UPDATE arc_shrine SET
					shrinekey='" .dbPrep($shrinekey). "',
					suserid='" .dbPrep($suserid). "',
					susername='" .dbPrep($susername). "',
					summary='" .dbPrep($summary). "',
					stitle='" .dbPrep($stitle). "',
					saccesslvl='" .dbPrep($saccesslvl). "'
					WHERE shrineid=$shrineid");
			echo "{$cpfont}Shrine <b>" .stripslashes($shrinekey). "</b> for user <b>" .stripslashes($susername). "</b> has been updated.</font><br />";
			$edit='shrine'; $id=$shrineid;
		}
		if (isset($HTTP_POST_VARS['submitstyleset'])) {
			$dbr->query("UPDATE arc_styleset SET
				    reqtemplateset='".dbPrep($sreqtemplateset)."',
					stylesetname='" .dbPrep($sstylesetname). "',
					headtaginsert='" .dbPrep($sheadtaginsert). "',
					bodytaginsert='" .dbPrep($sbodytaginsert). "',
					fontcolor='" .dbPrep($sfontcolor). "',
					bgcolor='" .dbPrep($sbgcolor). "',
					tablebgcolor='" .dbPrep($stablebgcolor). "',
					alttablebgcolor='" .dbPrep($salttablebgcolor). "',
					tdbgcolor='" .dbPrep($stdbgcolor). "',
					tdheadbgcolor='" .dbPrep($stdheadbgcolor). "',
					tdendbgcolor='" .dbPrep($stdendbgcolor). "',
					tablebordercolor='" .dbPrep($stablebordercolor). "',
					cursor='" .dbPrep($scursor). "',
					hilightcolor='" .dbPrep($shilightcolor). "',
					shadowcolor='" .dbPrep($sshadowcolor). "',
					linkcolor='" .dbPrep($slinkcolor). "',
					alinkcolor='" .dbPrep($salinkcolor). "',
					vlinkcolor='" .dbPrep($svlinkcolor). "',
					linkdecoration='" .dbPrep($slinkdecoration). "',
					linkweight='" .dbPrep($slinkweight). "',
					linkcursor='" .dbPrep($slinkcursor). "',
					hovercolor='" .dbPrep($shovercolor). "',
					hoverstyle='" .dbPrep($shoverstyle). "',
					hoverweight='" .dbPrep($shoverweight). "',
					smallfont='" .dbPrep($ssmallfont). "',
					normalfont='" .dbPrep($snormalfont). "',
					largefont='" .dbPrep($slargefont). "',
					cs='" .dbPrep($scs). "',
					cn='" .dbPrep($scn). "',
					cl='" .dbPrep($scl). "',
					logo='" .dbPrep($slogo). "',
					newtopicpath='" .dbPrep($snewtopicpath). "',
					newreplypath='" .dbPrep($snewreplypath). "',
					formwidth='" .dbPrep($sformwidth). "',
					textarea_rows='" .dbPrep($stextarea_rows). "',
					bodycss='" .dbPrep($sbodycss). "' WHERE stylesetid='$sstylesetid'");
			echo "{$cpfont}Styleset <b>" .stripslashes($sstylesetname) ."</b> has been updated.</font><br />";
			$edit='styleset'; $id=$sstylesetid;
		}
		if (isset($HTTP_POST_VARS['submittemplate'])) {
			if ($savetoall==1) {
				$dbr->query("UPDATE arc_template SET
						templatedesc='" .addslashes($templatedesc). "',
						templatevalue='" .addslashes($templatevalue). "'
						WHERE templatename='$templatename'");
				echo "{$cpfont}Template <b>" .stripslashes($templatename). "</b> in all groups has been updated.</font><br />";
			} else {
				$dbr->query("UPDATE arc_template SET
						templatedesc='" .addslashes($templatedesc). "',
						templatevalue='" .addslashes($templatevalue). "',
						templatename='" .addslashes($templatename). "',
						templategroup='" .addslashes($templategroup). "' WHERE templateid='$templateid'");
				echo "{$cpfont}Template <b>" .stripslashes($templatename). "</b> in group <b>" .stripslashes($templategroup). "</b> has been updated.</font><br />";
			}
			$edit='template'; $id=$templateid;
		}
		if (isset($HTTP_POST_VARS['submittopic'])) {
			$dbr->query("UPDATE arc_topic SET
					ttitle='" .dbPrep($ttitle). "',
					tdescription='" .dbPrep($tdescription). "',
					tusername='" .dbPrep($tusername). "',
					tuserid='" .dbPrep($tuserid). "',
					tforumid='" .dbPrep($tforumid). "',
					tlastposterid=$tlastposterid,
					tlastposter='$tlastposter',
					topicopen=$topicopen,
					topicdate='" .time(). "' WHERE topicid='$topicid'");
			echo "{$cpfont}Topic <b>" .stripslashes($ttitle). "</b> under forum number <b>$tforumid</b> has been updated.</font><br />";
			$edit='topic'; $id=$topicid;
		}
		if (isset($HTTP_POST_VARS['submituser'])) {
			if ($u_password!='') {
				$pinsert="password='" .md5($u_password). "',";
			} else {
				$pinsert='';
			}
			if (getSetting('rpg_flag')==1) {
				$dbr->query("UPDATE arc_user SET
					username='" .addslashes($u_username). "',
					displayname='" .addslashes($u_displayname). "',
					$pinsert
					rank='" .addslashes($u_rank). "',
					usertext='" .addslashes($u_usertext). "',
					avatar='" .addslashes($u_avatar). "',
					exp='$u_exp',
					level='$u_level',
					hp='$u_hp',
					mp='$u_mp',
					curhp='$u_curhp',
					curmp='$u_curmp',
					strength='$u_strength',
					endurance='$u_endurance',
					intelligence='$u_intelligence',
					will='$u_will',
					dexterity='$u_dexterity',
					sp='$u_sp',
					gold='$u_gold',
					race='$u_race',
					class='$u_class',
					email='$u_email',
					canbattle='$u_canbattle',
					useritems='$u_useritems',
					skills='$u_skills',
					lhand='$u_lhand',
					rhand='$u_rhand',
					head='$u_head',
					body='$u_body',
					legs='$u_legs',
					accessory='$u_accessory',
					homepage='" .addslashes($u_homepage). "',
					occupation='" .addslashes($u_occupation). "',
					location='" .addslashes($u_location). "',
					biography='" .addslashes($u_biography). "',
					post_header='" .addslashes($u_post_header). "',
					post_footer='" .addslashes($u_post_footer). "',
					profilehits='$u_profilehits',
					post_count='$u_post_count',
					note_count='$u_note_count',
					topics='$u_topics',
					caneditprofile='$u_caneditprofile',
					isbanned='$u_isbanned',
					notepad='$u_notepad',
					access=$u_access,
					team='$u_team',
					battleid='$u_battleid',
					attacked='$u_attacked',
					kills='$u_kills',
					deaths='$u_deaths',
					battles='$u_battles',
					user_ip='$u_user_ip'
					WHERE userid='$u_userid'");
			} else {
				$dbr->query("UPDATE arc_user SET
					username='" .addslashes($u_username). "',
					displayname='" .addslashes($u_displayname). "',
					$pinsert
					rank='" .addslashes($u_rank). "',
					usertext='" .addslashes($u_usertext). "',
					avatar='" .addslashes($u_avatar). "',
					email='$u_email',
					homepage='" .addslashes($u_homepage). "',
					occupation='" .addslashes($u_occupation). "',
					location='" .addslashes($u_location). "',
					biography='" .addslashes($u_biography). "',
					post_header='" .addslashes($u_post_header). "',
					post_footer='" .addslashes($u_post_footer). "',
					profilehits='$u_profilehits',
					post_count='$u_post_count',
					note_count='$u_note_count',
					topics='$u_topics',
					caneditprofile='$u_caneditprofile',
					isbanned='$u_isbanned',
					notepad='$u_notepad',
					access=$u_access,
					user_ip='$u_user_ip'
					WHERE userid='$u_userid'");
			}
			echo "{$cpfont}User file for <b>" .stripslashes($u_displayname). "</b> has been updated.</font><br />";
			$edit='user'; $id=$u_userid;
		}
		if (isset($HTTP_POST_VARS['submitwordbit'])) {
			$dbr->query("UPDATE arc_wordbit SET
					wordbitname='" .dbPrep($wordbitname). "',
					wordbitvalue='" .dbPrep($wordbitvalue). "',
					wordbitgroup='" .dbPrep($wordbitgroup). "' WHERE wordbitid='$wordbitid'");
			echo "{$cpfont}Wordbit <b>" .stripslashes($wordbitname). "</b> in group <b>" .stripslashes($wordbitgroup). "</b> has been updated.</font><br />";
			$edit='wordbit'; $id=$wordbitid;
		}
		if (isset($edit)) { /////////////////////////////////// EDIT ITEM FORMS
			geteditbitaction($edit);
			${$edit}=getcprows($edit);
			switch ($edit) {
				case 'avatar':
					$inputs[]=inputform('text', "Avatar Name (change this if you changed the filename)", "avatarname", ${$edit}['avatar']);
					break;

				case 'dlcat':
					$inputs[]=inputform('text', 'Category Name', 'name', stripslashes(${$edit}['name']));
					$inputs[]=inputform('textarea', 'Description', 'description', stripslashes(${$edit}['description']));
					$inputs[]=inputform('text', 'Parent ID', 'parentid', ${$edit}['parentid']);
					$inputs[]=inputform('text', 'Files', 'files', ${$edit}['files']);
					break;

				case 'download':
					$inputs[]=inputform('text', 'File Name', 'name', stripslashes(${$edit}['name']));
					$inputs[]=inputform('text', 'File Path', 'filepath', ${$edit}['filepath']);
					$inputs[]=inputform('text', 'File Size', 'filesize', ${$edit}['filesize'], $formwidth, 50);
					$inputs[]=inputform('textarea', 'Description', 'description', stripslashes(${$edit}['description']));
					$inputs[]=inputform('text', 'Category ID', 'catid', ${$edit}['catid']);
					$inputs[]=inputform('text', 'Download Hits', 'downloads', ${$edit}['downloads']);
					break;

				case 'faq':
					$inputs[]=inputform('text', 'Question', 'faqq', stripslashes(${$edit}['faqq']));
					$inputs[]=inputform('textarea', 'Answer', 'faqa', stripslashes(${$edit}['faqa']));
					$inputs[]=inputform('faqgroups', 'FAQ Group', 'faqgroup', ${$edit}['faqgroup'], 5);
					break;

				case 'faqgroup':
					$inputs[]=inputform('text', 'FAQ Group Name', 'faqgroupname', stripslashes(${$edit}['faqgroupname']));
					$inputs[]=inputform('text', 'FAQ Group Order', 'faqgrouporder', ${$edit}['faqgrouporder'], 7, 4);
					break;

				case 'forum':
					$inputs[]=inputform('text', 'Forum Name', 'forumname', stripslashes(${$edit}['forumname']));
					$inputs[]=inputform('textarea', 'Forum Description', 'description', stripslashes(${$edit}['description']), 70, 3);
					$inputs[]=inputform('text', 'Parent ID (0=top level)', 'parentid', ${$edit}['parentid'], 4, 4);
					$inputs[]=inputform('yesno', 'Unlocked', 'open', ${$edit}['open']);
					$inputs[]=inputform('yesno', 'Is Private', 'private', ${$edit}['private']);
					$inputs[]=inputform('text', 'Forum Display Order (0=do not display)', 'forder', ${$edit}['forder'], 4, 4);
					$inputs[]=inputform('users', 'Moderator UserID', 'moduserid', ${$edit}['modid'], 10, "Select a user");
					$inputs[]=inputform('text', 'Last TopicID', 'lasttopic', ${$edit}['lasttopicid'], 10, 20);
					$inputs[]=inputform('text', 'Last PosterID', 'lastposter', ${$edit}['lastposterid'], 10, 20);
					$inputs[]=inputform('yesno', 'Display post header/footers', 'showextras', ${$edit}['showextras']);
					$inputs[]=inputform('yesno', 'Forum Flag (yes=forum no=category)', 'isforum', ${$edit}['isforum']);
					$inputs[]=inputform('text', 'Forum type', 'forumtype', ${$edit}['forumtype'], 10, 20);
					$inputs[]=inputform('text', 'Access Level Required', 'accesslvl', ${$edit}['accesslvl'], 10, 5);
					$inputs[]=inputform('text', 'Topic Count', 'topiccount', ${$edit}['topiccount'], 10, 20);
					$inputs[]=inputform('text', 'Post Count', 'postcount', ${$edit}['postcount'], 10, 20);
					$inputs[]=inputform('text', 'Forum Password (leave blank for access to all)', 'fpassword', ${$edit}['fpassword'], 25, 20);
					$inputs[]=inputform('text', 'Link URL (leave blank to have the forum behave normally)', 'linkurl', ${$edit}['linkurl'], $formwidth, 255);
					break;

				case 'note':
					$inputs[]=inputform('text', 'Note User ID', "noteuserid", ${$edit}['noteuserid']);
					$inputs[]=inputform('text', 'Note Text', 'notemessage', stripslashes(htmlspecialchars(${$edit}['notemessage'])));
					break;

				case 'pagebit':
					$inputs[]=inputform('text', "Page Title", "ptitle", stripslashes(${$edit}['ptitle']));
					$inputs[]=inputform('textarea', "Page Content (html enabled)", "pcontent", stripslashes(${$edit}['pcontent']));
					$inputs[]=inputform('text', 'Page Name', 'action_page', ${$edit}['page']);
					$inputs[]=inputform('text', "Pagebit Order ('0'=do not display)", "porder", ${$edit}['porder'], 4, 4);
					$inputs[]=inputform('yesno', 'Convert new lines to line breaks', 'convertnewline', ${$edit}['convertnewline']);
					$inputs[]=inputform('users', 'Pagebit Author', 'puserid', ${$edit}['puserid'], 1);
					$inputs[]=inputform('shrines', 'Shrine Key', 'shrinekey', ${$edit}['shrinekey'], 1);
					break;

				case 'post':
					$inputs[]=inputform('text', 'Post Author', 'postusername', stripslashes(${$edit}['postusername']));
					$inputs[]=inputform('text', 'Post Title', 'posttitle', htmlspecialchars(${$edit}['posttitle']));
					$inputs[]=inputform('textarea', 'Post Content', 'postcontent', htmlspecialchars(${$edit}['postcontent']), 70, 5);
					$inputs[]=inputform('text', "'Edited By' Username", 'editusername', htmlspecialchars(${$edit}['editusername']));
					break;

				case 'poll':
					$inputs[]=inputform('text', 'Poll Question', 'question', stripslashes(${$edit}['question']));
					$inputs[]=inputform('text', 'Poll Votes', 'pvotes', ${$edit}['pvotes']);
					break;

				case 'polla':
					$inputs[]=inputform('text', 'Poll Answer', 'answer', stripslashes(${$edit}['answer']));
					$inputs[]=inputform('text', 'Users who voted', 'users', ${$edit}['users']);
					$inputs[]=inputform('text', 'Number votes', 'votes', ${$edit}['votes']);
					$inputs[]=inputform('text', 'Poll ID', 'pollid', ${$edit}['pollid']);
					break;

				case 'quote':
					$inputs[]=inputform('text', 'Quote Id', 'newquoteid', ${$edit}['quoteid']);
					$inputs[]=inputform('textarea', 'Quote', "quote", ${$edit}['quote'], $formwidth);
					$inputs[]=inputform('hidden', '', 'oldquoteid', $id);
					break;

				case 'rank':
					$inputs[]=inputform('text', 'Rank', 'newrank', ${$edit}['rank']);
					$inputs[]=inputform('text', 'Obtained on level', 'minlvl', ${$edit}['minlvl'], 10, 10);
					break;

				case 'shrine':
					$inputs[]=inputform('text', 'Shrine Key', 'shrinekey', ${$edit}['shrinekey'], 5, 3);
					$inputs[]=inputform('users', 'Owner', 'suserid', ${$edit}['suserid'], 10);
					$inputs[]=inputform('text', 'Title', 'stitle', ${$edit}['stitle']);
					$inputs[]=inputform('textarea', 'Summary', 'summary', ${$edit}['summary'], 70, 3);
					$inputs[]=inputform('text', 'Level required', 'saccesslvl', ${$edit}['saccesslvl'], 15, 10);
					break;

				case 'setting':
					$inputs[]=inputform('text', 'Setting Name', 'settingname', stripslashes(${$edit}['settingname']));
					$inputs[]=inputform('text', 'Setting Group', 'settinggroup', stripslashes(${$edit}['settinggroup']));
					$inputs[]=inputform('textarea', 'Setting Description', 'settingdesc', stripslashes(${$edit}['settingdesc']), 70, 3);
					$inputs[]=inputform('text', 'Setting Value', 'settingvalue', stripslashes(${$edit}['settingvalue']));
					break;

				case 'styleset':
					$inputs[]=inputform('text', 'Styleset Name', 'sstylesetname', ${$edit}['stylesetname'], 30, 20);
					$inputs[]=inputform('text', 'Template Set Used (leave blank to use any template set)', 'sreqtemplateset', ${$edit}['reqtemplateset'], $formwidth, 80);
					$inputs[]=inputform('textarea', "Head Tag Insert", "sheadtaginsert", ${$edit}['headtaginsert'], 50, 3);
					$inputs[]=inputform('text', "Insert inside the &lt;body   &gt;", "sbodytaginsert", ${$edit}['bodytaginsert']);
					$inputs[]=inputform('text', "Text Color", "sfontcolor", ${$edit}['fontcolor'], 15, 80);
					$inputs[]=inputform('text', "Background Color ", "sbgcolor", ${$edit}['bgcolor'], 15, 80);
					$inputs[]=inputform('text', "Table Background Color", "stablebgcolor", ${$edit}['tablebgcolor'], 15, 80);
					$inputs[]=inputform('text', "Mouseover Table BG Color", "salttablebgcolor", ${$edit}['alttablebgcolor'], 15, 80);
					$inputs[]=inputform('text', "Table Border Color", "stablebordercolor", ${$edit}['tablebordercolor'], 15, 80);
					$inputs[]=inputform('text', "Table Cell BG Color", "stdbgcolor", ${$edit}['tdbgcolor'], 15, 80);
					$inputs[]=inputform('text', "Table Header BG Color", "stdheadbgcolor", ${$edit}['tdheadbgcolor'], 15, 80);
					$inputs[]=inputform('text', "End table BG Color", "stdendbgcolor", ${$edit}['tdendbgcolor'], 15, 80);
					$inputs[]=inputform('text', "Cursor Type", "scursor", ${$edit}['cursor'], 15, 15);
					$inputs[]=inputform('text', "Table cell highlight color", "shilightcolor", ${$edit}['hilightcolor'], 15, 80);
					$inputs[]=inputform('text', "Table cell shadow color", "sshadowcolor", ${$edit}['shadowcolor'], 15, 80);
					$inputs[]=inputform('text', "Link Color", "slinkcolor", ${$edit}['linkcolor'], 15, 80);
					$inputs[]=inputform('text', "Visited Link Color", "svlinkcolor", ${$edit}['vlinkcolor'], 15, 80);
					$inputs[]=inputform('text', "Active Link Color", "salinkcolor", ${$edit}['alinkcolor'], 15, 80);
					$inputs[]=inputform('text', "Link Mouseover Font Color", "shovercolor", ${$edit}['hovercolor'], 15, 80);
					$inputs[]=inputform('text', "Link Decoration", "slinkdecoration", ${$edit}['linkdecoration'], 15, 15);
					$inputs[]=inputform('text', "Link Weight", "slinkweight", ${$edit}['linkweight'], 15, 80);
					$inputs[]=inputform('text', "Link Cursor", "slinkcursor", ${$edit}['linkcursor'], 15, 80);
					$inputs[]=inputform('text', "Link Mouseover Font Style", "shoverstyle", ${$edit}['hoverstyle'], 15, 80);
					$inputs[]=inputform('text', "Link Mouseover Font Weight", "shoverweight", ${$edit}['hoverweight'], 15, 80);
					$inputs[]=inputform('text', "Global smallfont", "ssmallfont", stripslashes(${$edit}['smallfont']), $formwidth, 9999);
					$inputs[]=inputform('text', "Global normalfont", "snormalfont", stripslashes(${$edit}['normalfont']), $formwidth, 9999);
					$inputs[]=inputform('text', "Global largefont", "slargefont", stripslashes(${$edit}['largefont']), $formwidth, 9999);
					$inputs[]=inputform('text', "Global smallfont closing tag", "scs", ${$edit}['cs']);
					$inputs[]=inputform('text', "Global normalfont closing tag", "scn", ${$edit}['cn']);
					$inputs[]=inputform('text', "Global largefont closing tag", "scl", ${$edit}['cl']);
					$inputs[]=inputform('text', "Path to Logo", "slogo", ${$edit}['logo']);
					$inputs[]=inputform('text', "Path to New Topic Graphic", "snewtopicpath", ${$edit}['newtopicpath']);
					$inputs[]=inputform('text', "Path to New Reply Graphic", "snewreplypath", ${$edit}['newreplypath']);
					$inputs[]=inputform('textarea', "BODY CSS", "sbodycss", ${$edit}['bodycss'], 50, 5);
					$inputs[]=inputform('text', "Input and textarea width", "sformwidth", ${$edit}['formwidth'], 6, 3);
					$inputs[]=inputform('text', "Textarea Rows", "stextarea_rows", ${$edit}['textarea_rows'], 6, 3);
					$inputs[]=inputform('hidden', "", "sstylesetid", $id);
					break;

				case 'template':
					$inputs[]=inputform('text', "Template Name (don't change)", 'templatename', stripslashes(${$edit}['templatename']));
					$inputs[]=inputform('text', 'Template Description', 'templatedesc', stripslashes(${$edit}['templatedesc']));
					$inputs[]=inputform('textarea', 'Template Value', 'templatevalue', stripslashes(${$edit}['templatevalue']), 70, 20);
					$inputs[]=inputform('text', 'Template Group', 'templategroup', stripslashes(${$edit}['templategroup']));
					$inputs[]=inputform('yesno', 'Save this template in all groups', 'savetoall', 0);
					break;

				case 'topic':
					$inputs[]=inputform('text', "Topic Title", "ttitle", htmlspecialchars(${$edit}['ttitle']));
					$inputs[]=inputform('text', "Topic Description", "tdescription", htmlspecialchars(${$edit}['tdescription']));
					$inputs[]=inputform('text', "Topic Username", "tusername", stripslashes(${$edit}['tusername']));
					$inputs[]=inputform('text', "Topic User Id", "tuserid", ${$edit}['tuserid'], 10, 10);
					$inputs[]=inputform('text', "Topic Forum Id", "tforumid", ${$edit}['tforumid'], 10, 10);
					$inputs[]=inputform('text', "Last Poster's Id", "tlastposterid", ${$edit}['tlastposterid'], 10, 10);
					$inputs[]=inputform('text', "Last Posters Username", "tlastposter", ${$edit}['tlastposter']);
					$inputs[]=inputform('yesno', "Topic Is Open", "topicopen", ${$edit}['topicopen']);
					break;

				case 'user':
					$inputs[]=inputform('display', 'Profile Information');
					$inputs[]=inputform('text', getwordbit('edit_user_loginname'), 'u_username', ${$edit}['username']);
					$inputs[]=inputform('text', 'Display Name', 'u_displayname', stripslashes(${$edit}['displayname']));
					$inputs[]=inputform('password', 'Password (make sure the user is logged out first)', 'u_password', '');
					$inputs[]=inputform('text', 'Rank', 'u_rank', stripslashes(${$edit}['rank']));
					$inputs[]=inputform('text', 'Usertext', 'u_usertext', stripslashes(${$edit}['usertext']));
					$inputs[]=inputform('text', 'Avatar', 'u_avatar', ${$edit}['avatar']);
					$inputs[]=inputform('text', 'Email', 'u_email', ${$edit}['email']);
					$inputs[]=inputform('text', 'Homepage', 'u_homepage', ${$edit}['homepage']);
					$inputs[]=inputform('text', 'Occupation', 'u_occupation', stripslashes(${$edit}['occupation']));
					$inputs[]=inputform('text', 'Location', 'u_location', stripslashes(${$edit}['location']));
					$inputs[]=inputform('textarea', 'Biography', 'u_biography', stripslashes(${$edit}['biography']), $formwidth, 5);
					$inputs[]=inputform('textarea', 'Post header', 'u_post_header', stripslashes(${$edit}['post_header']), 70, 5);
					$inputs[]=inputform('textarea', 'Post Footer', 'u_post_footer', stripslashes(${$edit}['post_footer']), 70, 5);

					$inputs[]=inputform('display', 'Miscellaneous User Data');
					$inputs[]=inputform('text', 'Access Level (1=user, 2=moderator, 3=administrator)', 'u_access', ${$edit}['access'], 3, 1);
					$inputs[]=inputform('text', 'Profilehits', 'u_profilehits', ${$edit}['profilehits'], 10, 10);
					$inputs[]=inputform('text', 'Post Count', 'u_post_count', ${$edit}['post_count'], 10, 10);
					$inputs[]=inputform('text', 'Note Count', 'u_note_count', ${$edit}['note_count'], 10, 10);
					$inputs[]=inputform('text', 'Topic Count', 'u_topics', ${$edit}['topics'], 10, 10);
					$inputs[]=inputform('yesno', 'Can Edit Profile', 'u_caneditprofile', ${$edit}['caneditprofile']);
					$inputs[]=inputform('yesno', 'Is Banned', 'u_isbanned', ${$edit}['isbanned']);
					$inputs[]=inputform('textarea', 'Notepad', 'u_notepad', ${$edit}['notepad'], $formwidth, 5);
					$inputs[]=inputform('text', "User IP <a href=\"admin.php?action=banip&user=" .${$edit}['userid']. "\">Ban this IP</a>", 'u_user_ip', ${$edit}['user_ip']);
					if (getSetting('rpg_flag')==1) {
						$inputs[]=inputform('display', 'Character Information');
						$inputs[]=inputform('text', 'Level', 'u_level', ${$edit}['level'], 7, 5);
						$inputs[]=inputform('text', 'Experience Points', 'u_exp', ${$edit}['exp'], 40, 30);
						$inputs[]=inputform('text', 'Max HP', 'u_hp', ${$edit}['hp'], 10, 10);
						$inputs[]=inputform('text', 'Max MP', 'u_mp', ${$edit}['mp'], 10, 10);
						$inputs[]=inputform('text', 'Current HP', 'u_curhp', ${$edit}['curhp'], 10, 10);
						$inputs[]=inputform('text', 'Current MP', 'u_curmp', ${$edit}['curmp'], 10, 10);
						$inputs[]=inputform('text', 'Strength', 'u_strength', ${$edit}['strength'], 5, 5);
						$inputs[]=inputform('text', 'Endurance', 'u_endurance', ${$edit}['endurance'], 5, 5);
						$inputs[]=inputform('text', 'Intelligence', 'u_intelligence', ${$edit}['intelligence'], 5, 5);
						$inputs[]=inputform('text', 'Will', 'u_will', ${$edit}['will'], 5, 5);
						$inputs[]=inputform('text', 'Dexterity', 'u_dexterity', ${$edit}['dexterity'], 5, 5);
						$inputs[]=inputform('text', 'Right Hand Equip ID', 'u_rhand', ${$edit}['rhand'], 5, 5);
						$inputs[]=inputform('text', 'Left Hand Equip ID', 'u_lhand', ${$edit}['lhand'], 5, 5);
						$inputs[]=inputform('text', 'Head Equip ID', 'u_head', ${$edit}['head'], 5, 5);
						$inputs[]=inputform('text', 'Body Equip ID', 'u_body', ${$edit}['body'], 5, 5);
						$inputs[]=inputform('text', 'Legs Equip ID', 'u_legs', ${$edit}['legs'], 5, 5);
						$inputs[]=inputform('text', 'Accessory Equip ID', 'u_accessory', ${$edit}['accessory'], 5, 5);
						$inputs[]=inputform('text', 'Gold', 'u_gold', ${$edit}['gold'], 10, 10);
						$inputs[]=inputform('text', 'Skill Points', 'u_sp', ${$edit}['sp'], 10, 10);
						$inputs[]=inputform('races', 'Race', 'u_race', ${$edit}['race']);
						$inputs[]=inputform('classes', 'Class', 'u_class', ${$edit}['class'], ${$edit}['race']);

						$inputs[]=inputform('display', 'Battle Information');
						$inputs[]=inputform('yesno', 'Has attacked in current battle round', 'u_attacked', ${$edit}['attacked'], 3, 1);
						$inputs[]=inputform('yesno', 'Is Allowed to Battle', 'u_canbattle', ${$edit}['canbattle']);
						$inputs[]=inputform('text', 'Kills', 'u_kills', ${$edit}['kills'], 10, 10);
						$inputs[]=inputform('text', 'Deaths', 'u_deaths', ${$edit}['deaths'], 10, 10);
						$inputs[]=inputform('text', 'Battles', 'u_battles', ${$edit}['battles'], 10, 10);
						$inputs[]=inputform('text', 'Current Battle Team', 'u_team', ${$edit}['team'], 3, 1);
						$inputs[]=inputform('text', 'Current Battle ID (0=not in battle)', 'u_battleid', ${$edit}['battleid'], 10, 10);
						$inputs[]=inputform('textarea', 'User Items', 'u_useritems', ${$edit}['useritems'], $formwidth, 5);
						$inputs[]=inputform('textarea', 'Skills', 'u_skills', ${$edit}['skills'], $formwidth, 5);
					}
					$inputs[]=inputform('hidden', '', 'u_userid', ${$edit}['userid']);
					break;

				case 'wordbit':
					$inputs[]=inputform('text', 'Wordbit Name(all lower case, no spaces)', 'wordbitname', ${$edit}['wordbitname']);
					$inputs[]=inputform('textarea', 'Wordbit Value', 'wordbitvalue', ${$edit}['wordbitvalue'], 70, 5);
					$inputs[]=inputform('text', 'Wordbit Display Category', 'wordbitgroup', ${$edit}['wordbitgroup']);
					break;
			}
			$inputs[]=inputform('hidden', '', 'edit', $edit);
			$inputs[]=inputform('hidden', '', "{$edit}id", $id);

			doinputs($inputs);

			geteditbitsubmit($edit);
		}
		break;

	case 'newavatar': /////////////////////////////////// NEW ITEM FORMS
		getaddbitaction('avatar');
		$inputs[]=inputform('text', 'Avatar Filename (must be in root->lib->images->avatars)', 'avatarname', '');
		doinputs($inputs);
		getaddbitsubmit('avatar');
		break;

	case 'newdlcat':
		getaddbitaction('dlcat');
		$inputs[]=inputform('text', 'Category Name', 'name');
		$inputs[]=inputform('textarea', 'Description', 'description');
		$inputs[]=inputform('text', 'Parent ID', 'parentid', 0);
		$inputs[]=inputform('text', 'Number Files', 'files', 0);
		doinputs();
		getaddbitsubmit('dlcat');
		break;

	case 'newfile':
		getaddbitaction('download');
		$inputs[]=inputform('text', 'File Name', 'name');
		$inputs[]=inputform('text', 'File Path', 'filepath');
		$inputs[]=inputform('text', 'File Size', 'filesize', '', $formwidth, 50);
		$inputs[]=inputform('textarea', 'Description', 'description');
		$inputs[]=inputform('text', 'Category ID', 'catid', 0);
		$inputs[]=inputform('text', 'Download Hits', 'downloads', 0);
		doinputs();
		getaddbitsubmit('download');
		break;

	case 'newfaq':
		getaddbitaction('faq');
		$inputs[]=inputform('text', 'Question', 'faqq');
		$inputs[]=inputform('textarea', 'Answer', 'faqa');
		$inputs[]=inputform('faqgroups', 'FAQ Group', 'faqgroup', '', 5);
		doinputs();
		getaddbitsubmit('faq');
		break;

	case 'newfaqgroup':
		getaddbitaction('faqgroup');
		$inputs[]=inputform('text', 'FAQ Group Name', 'faqgroupname');
		$inputs[]=inputform('text', 'FAQ Group Order', 'faqgrouporder', '', 7, 4);
		doinputs();
		getaddbitsubmit('faqgroup');
		break;

	case 'newforum':
		getaddbitaction('forum');
		$inputs[]=inputform('text', 'Forum Name', 'forumname');
		$inputs[]=inputform('textarea', 'Forum Description', 'fdescription');
		$inputs[]=inputform('text', 'Parent ID (0=top level)', 'fcatid', 0, 4, 4);
		$inputs[]=inputform('yesno', 'Unlocked', 'open', '1');
		$inputs[]=inputform('yesno', 'Is Private', 'private', 0);
		$inputs[]=inputform('text', 'Forum Display Order (0=do not display)', 'forder', 0, 4, 4);
		$inputs[]=inputform('users', 'Moderator UserID (tip: type the first letter of the username)', 'moduserid', '', 15, 'Select the Moderator');
		$inputs[]=inputform('yesno', 'Display post header/footers', 'showextras', 1);
		$inputs[]=inputform('yesno', 'Forum Flag (yes=forum no=category)', 'isforum', 1);
		$inputs[]=inputform('text', 'Forum type', 'forumtype', 1, 10, 5);
		$inputs[]=inputform('text', 'Access Level Required (0=no access)', 'accesslvl', 1, 10, 5);
		$inputs[]=inputform('text', 'Forum Password (leave blank for no password)', 'fpassword', '', 25, 20);
		$inputs[]=inputform('text', 'Link URL (leave blank to have the forum behave normally)', 'linkurl', '', $formwidth, 255);
		doinputs();
		getaddbitsubmit('forum');
		break;

	case 'newpagebit':
		getaddbitaction('pagebit');
		$inputs[]=inputform('text', 'Pagebit Title', 'ptitle', '', 50, 80);
		$inputs[]=inputform('textarea', 'Pagebit Content', 'pcontent', '', 70, 10);
		$inputs[]=inputform('text', 'Page name', 'action_page', 'news', 25, 20);
		$inputs[]=inputform('text', 'Pagebit Display Order (0=do not display)', 'porder', '1', 4, 4);
		$inputs[]=inputform('yesno', 'Convert new lines to line breaks', 'convertnewline', 1);
		$inputs[]=inputform('users', 'Pagebit Author', 'puserid', $userid, 1);
		$inputs[]=inputform('shrines', 'Shrine Key', 'nshrinekey', '', 1);
		doinputs($inputs);
		getaddbitsubmit('pagebit');
		break;

	case 'newquote':
		getaddbitaction('quote');
		$inputs[]=inputform('textarea', 'Quote', 'quote', '', 70, 3);
		doinputs($inputs);
		getaddbitsubmit('quote');
		break;

	case 'newrank':
		getaddbitaction('rank');
		$inputs[]=inputform('text', "New Rank", "newrank");
		$inputs[]=inputform('text', "Level Required", "minlvl", '0', 15, 10);
		doinputs($inputs);
		getaddbitsubmit('rank');
		break;

	case 'newsetting':
		getaddbitaction('setting');
		$inputs[]=inputform('text', "Setting Name", "settingname", '', 50, 80);
		$inputs[]=inputform('text', "Setting Group", "settinggroup", '', 25, 20);
		$inputs[]=inputform('textarea', "Setting Description", "settingdesc", '', 70, 3);
		$inputs[]=inputform('textarea', "Setting Value", "settingvalue", '', 70, 3);
		doinputs($inputs);
		getaddbitsubmit('setting');
		break;

	case 'newshrine':
		getaddbitaction('shrine');
		$inputs[]=inputform('text', "Shrine Key", "shrinekey", '', 5, 3);
		$inputs[]=inputform('users', "Owner", "suserid", ' ', 10, 1);
		$inputs[]=inputform('text', "Title", "stitle", '');
		$inputs[]=inputform('textarea', "Summary", "summary", '', 70, 3);
		$inputs[]=inputform('text', "Access level (restrict access to users level is below this, cannot be any higher then owners level)", "saccesslvl", '', 15, 10);
		doinputs($inputs);
		getaddbitsubmit('shrine');
		break;

	case 'newstyleset':
		getaddbitaction('styleset');
		$inputs[]=inputform('text', "Styleset Name", "nstylesetname", '');
		doinputs($inputs);
		getaddbitsubmit('styleset');
		break;

	case 'newtemplate':
		getaddbitaction('template');
		$inputs[]=inputform('text', "Template Name", "templatename", '', 25, 20);
		$inputs[]=inputform('textarea', "Template Description", "templatedesc", '', 70, 3);
		$inputs[]=inputform('textarea', "Template Content", "templatevalue", '', 70, 10);
		$inputs[]=inputform('yesno', "Create Template in all groups (will only be created in active template set if no)", "createall", 0);
		doinputs($inputs);
		getaddbitsubmit('template');
		break;

	case 'newtemplateset':
		getaddbitaction('templateset');
		$inputs[]=inputform('text', 'Template Set Name', 'templatesetname', '', 25, 20);
		doinputs($inputs);
		getaddbitsubmit('templateset');
		break;

	case 'newtopic':
		getaddbitaction('topic');
		$inputs[]=inputform('text', "Topic Title", "ttitle", '', 70, 80);
		$inputs[]=inputform('text', "Topic Description", "tdescription", '', 70, 80);
		$inputs[]=inputform('text', "Topic Author", "tusername", '', 70, 80);
		$inputs[]=inputform('text', "Topic Author Id", "tuserid", '', 10, 10);
		$inputs[]=inputform('text', "Topic Forum Id", "tforumid", '', 10, 10);
		doinputs($inputs);
		getaddbitsubmit('topic');
		break;

	case 'newwordbit':
		getaddbitaction('wordbit');
		$inputs[]=inputform('text', "Wordbit Name", "wordbitname", '', 25, 30);
		$inputs[]=inputform('text', "Wordbit Value", "wordbitvalue", '', 70, 9999);
		$inputs[]=inputform('text', "Wordbit Group", "wordbitgroup", '', 25, 20);
		doinputs($inputs);
		getaddbitsubmit('wordbit');
		break;

	case 'addavatars':
		if (is_array($addme)) {
		    $added=0;
		    while(list($key,$val)=each($addme)) {
		      $query=$dbr->query("INSERT INTO arc_avatar SET avatar='$key'");
			    echo "{$cpfont}Adding <b>" .avatardecode($key). "</b>...<br />\n";
		      $added++;
		      flush();
		    }
		    echo "$cpfont<b>$added</b> avatars have been added.";
		} else {
			echo "{$cpfont}No avatars were selected.";
		}
		break;

	case 'buildavatar': /////////////////////////////////// NEW ITEM QUERIES
		if (isset($addavatar)) {
			$dbr->query("INSERT INTO arc_avatar SET avatar='$avatarname'");
			echo "{$cpfont}Avatar <b>" .avatardecode($avatarname). "</b> has been added.</font>";
		}
		break;

	case 'builddlcat':
		if (isset($adddlcat)) {
			$dbr->query("INSERT INTO arc_dlcat SET
					name='" .dbPrep($name). "',
					description='" .dbPrep($description). "',
					parentid='" .dbPrep($parentid). "',
					files=" .dbPrep($files));
			echo "{$cpfont}Download category <b>" .stripslashes($name). "</b> has been added.</font>";
		}
		break;

	case 'builddownload':
		if (isset($adddownload)) {
			$numfiles = $dbr->result("SELECT COUNT(downloadid) FROM arc_download WHERE catid=$catid")+1;
			$dbr->query("UPDATE arc_dlcat SET files=$numfiles WHERE dlcatid=$catid");

			$dbr->query("INSERT INTO arc_download SET
					name='" .dbPrep($name). "',
					filepath='" .dbPrep($filepath). "',
					filesize='" .dbPrep($filesize). "',
					description='" .dbPrep($description). "',
					catid='" .dbPrep($catid). "',
					date_added='" .time(). "',
					downloads=" .dbPrep($downloads));
			echo "{$cpfont}Download <b>" .stripslashes($name). "</b> has been added.</font>";
		}
		break;

	case 'buildfaq':
		if (isset($addfaq)) {
			$dbr->query("INSERT INTO arc_faq SET
					faqq='" .dbPrep($faqq). "',
					faqa='" .dbPrep($faqa). "',
					faqgroup=" .dbPrep($faqgroup));
			echo "{$cpfont}FAQ Question <b>" .stripslashes($faqq). "</b> and answer <b>" .stripslashes($faqa). "</b> in group <b>" .stripslashes($dbr->result("SELECT faqgroupname FROM arc_faqgroup WHERE faqgroupid=$faqgroup LIMIT 0,1")). "</b> have been added.</font>";
		}
		break;

	case 'buildfaqgroup':
		if (isset($addfaqgroup)) {
			$dbr->query("INSERT INTO arc_faqgroup SET
					faqgroupname='" .dbPrep($faqgroupname). "',
					faqgrouporder=" .dbPrep($faqgrouporder));
			echo "{$cpfont}FAQ Group <b>" .stripslashes($faqgroupname). "</b> have been added.</font>";
		}
		break;

	case 'buildforum':
		if (isset($addforum)) {
			if ($moduserid!="" && $moduserid!=0) {
				$modusername=$dbr->result("SELECT username FROM arc_user WHERE userid='$moduserid'");
			} else {
				$moduserid=0;
				$modusername="";
			}
			$dbr->query("INSERT INTO arc_forum SET
					forumname='" .dbPrep($forumname). "',
					description='" .dbPrep($fdescription). "',
					parentid=$fcatid,
					open=$open,
					private=$private,
					modid=$moduserid,
					modusername='$modusername',
					lastposterid=0,
					lasttopicid=0,
					topiccount=0,
					postcount=0,
					showextras=$showextras,
					isforum=$isforum,
					forumtype=$forumtype,
					accesslvl=$accesslvl,
					linkurl='$linkurl',
					fpassword='$fpassword',
					forder=$forder");
			showmsg("Forum <b>" .stripslashes($forumname). "</b> has been added.", 1);
		}
		break;

	case 'buildpagebit':
		if (isset($addpagebit)) {
			$dbr->query("INSERT INTO arc_pagebit SET
					ptitle='" .dbPrep($ptitle). "',
					pcontent='" .dbPrep($pcontent). "',
					page='" .dbPrep(strtolower($action_page)). "',
					porder=$porder,
					convertnewline=$convertnewline,
					puserid=$userid,
					shrinekey='$nshrinekey',
					pdate='" .time(). "'");
			showmsg("Pagebit <b>" .stripslashes($ptitle). "</b> has been added to page <b>$action_page</b>.", 1);
			updatesearchindex($pcontent, mysql_insert_id(), 'arc_pagebit');
		}
		break;

	case 'buildquote':
		if (isset($addquote)) {
			$maxquote = $dbr->result("SELECT MAX(quoteid) FROM arc_quote");
			$dbr->query("UPDATE arc_misc SET maxquote=$maxquote");
			$dbr->query("INSERT INTO arc_quote SET quote='$quote'");
			echo "{$cpfont}Quote <b>" .stripslashes($quote). "</b> has been added.</font>";
		}
		break;

	case 'buildrank':
		if (isset($addrank)) {
			$dbr->query("INSERT INTO arc_rank SET
					rank='" .dbPrep($newrank). "',
					minlvl=$minlvl");
			echo "{$cpfont}Rank <b>" .stripslashes($newrank). "</b> has been added with a requirement of level <b>$minlvl</b>.</font>";
		}
		break;

	case 'buildshrine':
		if (isset($addshrine)) {
			$susername=$dbr->result("SELECT username FROM arc_user WHERE userid=$suserid");
			$suserlvl=$dbr->result("SELECT level FROM arc_user WHERE userid=$suserid");
			if ($saccesslvl>$suserlvl) {
				exit();
			}
			$dbr->query("INSERT INTO arc_shrine SET
					shrinekey='" .dbPrep($shrinekey). "',
					suserid=$suserid,
					susername='" .dbPrep($susername). "',
					stitle='" .dbPrep($stitle). "',
					summary='" .dbPrep($summary). "',
					lastmodified='" .time(). "',
					saccesslvl='" .dbPrep($saccesslvl). "'");
			echo "{$cpfont}Shrine <b>" .stripslashes($shrinekey). "</b> has been added for user <b>" .stripslashes($susername). "</b>.</font>";
		}
		break;

	case 'buildsetting':
		if (isset($addsetting)) {
			$dbr->query("INSERT INTO arc_setting SET
					settingname='" .dbPrep($settingname). "',
					settinggroup='$settinggroup',
					settingdesc='" .dbPrep($settingdesc). "',
					settingvalue='" .dbPrep($settingvalue). "'");
			echo "{$cpfont}Setting <b>" .stripslashes($settingname). "</b> has been added under category <b>" .stripslashes($settinggroup). "</b>.</font>";
		}
		break;

	case 'buildstyleset':
		if (isset($addstyleset)) {
			$dbr->query("INSERT INTO arc_styleset SET
					stylesetname='" .dbPrep($nstylesetname). "'");
			echo "{$cpfont}Styleset <b>" .stripslashes($nstylesetname). "</b> has been added.</font>";
		}
		break;

	case 'buildtemplate':
		if (isset($addtemplate)) {
			if ($createall==1) {
				$groups=$dbr->query("SELECT DISTINCT(templategroup) FROM arc_template");
				while ($g=$dbr->getarray($groups)) {
					$dbr->query("INSERT INTO arc_template SET
							templatename='" .dbPrep($templatename). "',
							templategroup='" .dbPrep($g['templategroup']). "',
							templatedesc='" .htmlspecialchars(dbPrep($templatedesc)). "',
							templatevalue='" .dbPrep($templatevalue). "'");
					echo "{$cpfont}Template <b>" .stripslashes($templatename). "</b> in group <b>" .stripslashes($g['templategroup']). "</b> has been added.</font><br />";
				}
			} else {
				$templategroup=getSetting('current_template_set');
				$dbr->query("INSERT INTO arc_template SET
						templatename='" .dbPrep($templatename). "',
						templategroup='" .dbPrep($templategroup). "',
						templatedesc='" .htmlspecialchars(dbPrep($templatedesc)). "',
						templatevalue='" .dbPrep($templatevalue). "'");
				echo "{$cpfont}Template <b>" .stripslashes($templatename). "</b> in group <b>" .stripslashes($templategroup). "</b> has been added.</font><br />";
			}
		}
		break;

	case 'buildtemplateset':
		if (isset($addtemplateset)) {
			$tq=$dbr->query("SELECT * FROM arc_template WHERE templategroup='default' ORDER BY templatename");
			while ($ta=$dbr->getarray($tq)) {
				$result=$dbr->query("INSERT INTO arc_template SET
							templatename='$ta[templatename]',
							templatevalue='" .addslashes($ta['templatevalue']). "',
							templategroup='$templatesetname',
							templatedesc='" .addslashes($ta['templatedesc']). "'");
				if (!$result) {
					echo "Template <b>" .stripslashes($ta['templatename']). "</b> could not be created.<br /><br />MySQL says " .mysql_error(). "<br />";
				} else {
					echo "Template <b>" .stripslashes($ta['templatename']). "</b> has been created.<br />";
				}
			}
		}
		break;

	case 'buildtopic':
		if (isset($addtopic)) {
			$dbr->query("INSERT INTO arc_topic SET
					ttitle='" .dbPrep($ttitle). "',
					tdescription='" .dbPrep($tdescription). "',
					tusername='" .dbPrep($tusername). "',
					tuserid='$tuserid',
					tforumid='$tforumid',
					topicdate='" .time(). "'");
			echo "{$cpfont}Topic  <b>" .stripslashes($ttitle). "</b> has been added in forum number <b>$tforumid</b>.</font>";
		}
		break;

	case 'buildwordbit':
		if (isset($addwordbit)) {
			$dbr->query("INSERT INTO arc_wordbit SET
					wordbitname='" .dbPrep($wordbitname). "',
					wordbitvalue='" .dbPrep($wordbitvalue). "',
					wordbitgroup='" .dbPrep($wordbitgroup). "'");
			echo "{$cpfont}Wordbit <b>" .stripslashes($wordbitname). "</b> in group <b>" .stripslashes($wordbitgroup). "</b> has been added.</font>";
		}
		break;
}

} elseif (isset($password) && $passhash!=$password) {
	$action='stats';
} else {
	$action='stats';
}

if ($action=='stats') {
	$number_avatars=$dbr->result("SELECT COUNT(avatarid) FROM arc_avatar");
	$number_dlcats=$dbr->result("SELECT COUNT(dlcatid) FROM arc_dlcat");
	$number_downloads=$dbr->result("SELECT COUNT(downloadid) FROM arc_download");
	$number_faqgroups=$dbr->result("SELECT COUNT(faqgroupid) FROM arc_faqgroup");
	$number_faqs=$dbr->result("SELECT COUNT(faqid) FROM arc_faq");
	$number_forum_categories=$dbr->result("SELECT COUNT(forumid) FROM arc_forum WHERE isforum=0");
	$number_forums=$dbr->result("SELECT COUNT(forumid) FROM arc_forum WHERE isforum=1");
	$number_notes=$dbr->result("SELECT COUNT(noteid) FROM arc_note");
	$number_pages=$dbr->result("SELECT COUNT(pagebitid) FROM arc_pagebit");
	$number_pms=$dbr->result("SELECT COUNT(privatemsgid) FROM arc_privatemsg");
	$number_polls=$dbr->result("SELECT COUNT(pollid) FROM arc_poll");
	$number_posts=$dbr->result("SELECT COUNT(postid) FROM arc_post");
	$number_quotes=$dbr->result("SELECT COUNT(quoteid) FROM arc_quote");
	$number_settings=$dbr->result("SELECT COUNT(settingid) FROM arc_setting");
	$number_shrines=$dbr->result("SELECT COUNT(shrineid) FROM arc_shrine");
	$number_styles=$dbr->result("SELECT COUNT(stylesetid) FROM arc_styleset");
	$number_templates=$dbr->result("SELECT COUNT(templateid) FROM arc_template");
	$number_topics=$dbr->result("SELECT COUNT(topicid) FROM arc_topic");
	$number_visitors=$dbr->result("SELECT COUNT(visitorid) FROM arc_visitor");
	$number_users=$dbr->result("SELECT COUNT(userid) FROM arc_user");
	$number_wordbits=$dbr->result("SELECT COUNT(wordbitid) FROM arc_wordbit");

	$htm=getTemplate('cp_mainpage');

	$numbers=array('forum_categories','forums','topics','posts','dlcats','downloads','users','notes','templates',
				   'styles','settings','wordbits','faqs','pms','quotes','avatars','visitors','shrines','faqgroups','polls');

	foreach ($numbers as $val) {
		$varname='number_'.$val;
		$htm=str_replace("<$val>", number_format($$varname), $htm);
	}
	echo $htm;
}

if ($action=='stats' && $isadmin==1)
	echo "<center>{$cpfont}MySQL query:<form action=\"admin.php\" method=\"post\">
		  <textarea name=\"query\" rows=\"10\" cols=\"50\">$query</textarea><br />
	      <input type=\"submit\" value=\"Perform Query\"></input></form></center>";


?>

</font>
</body>
</html>
<?php

if (getSetting('gzcompress')==1)
	ob_end_flush();

?>