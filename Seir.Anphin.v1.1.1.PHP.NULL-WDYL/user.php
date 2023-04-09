<?php

$templates='userlist,userlistrow,memberlistchoices,profile,profiletoolbar,usercpmenu,';
$wordbits='notepad_default,usercp_submit,usercp_reset,profile_bad_id,postreply,userphptitletext,edit_homepage,edit_location,edit_occupation,';
$wordbits.='edit_loginname,edit_password,edit_usertext,edit_email,edit_bday_day,edit_bday_month,edit_bday_year,edit_biography,edit_layout,';
$wordbits.='edit_avatar,edit_useownavatar,edit_showonline,edit_shownotes,edit_showquotes,edit_postextras,edit_timeoffset,edit_colorset,';
$wordbits.='edit_post_header,edit_post_footer,postsampletext,edit_notepad,displaynameinuse,edit_displayname,logout_confirmed,notloggedin,';
$wordbits.='login_confirmed,alreadyloggedin,wrongpass,reg_username,reg_password,reg_displayname,reg_email,reg_bday_day,reg_bday_month,';
$wordbits.='reg_bday_year,reg_homepage,reg_occupation,reg_biography,reg_post_header,reg_post_footer,reg_usertext,reg_avatar,reg_race,';
$wordbits.='reg_submit,reg_reset,user_status_healthy,login_loginname,login_password,loginsubmit,loginreset,reg_confirmed,reg_name_in_use,';
$wordbits.='reg_blank_fields,profile_bad_id,';
$settings='logouttime,profile_lastread_timestamp,profile_timestamp,max_avatar_width,max_avatar_height,login_min_exp,login_max_exp,';
$settings.='startinggold,startinghp,startingmp,default_sprite,flip_default_sprite,memberlist_limit,post_timestamp,logout_confirmed,caneditnames,';

$userfile=1;

include('./lib/config.php');

if ($action=='news' && $loggedin==1)
	$action='home';
elseif($action=='news' && $loggedin==0)
	$action='register';

if (empty($HTTP_GET_VARS['save'])) $HTTP_GET_VARS['save']='';
if ($HTTP_GET_VARS['save']=='options' && $caneditprofile==1) {
	if (empty($ownavatar)) {
		$avatar=$avatar;
		$avsize[0]=getSetting('max_avatar_width');
		$avsize[1]=getSetting('max_avatar_height');
	} else {
		$avatar=htmlspecialchars($ownavatar);
		$avsize=getimagesize($avatar);
	}

	if (empty($layout))
		$layout='default';

	$styleset_template = $dbr->result("SELECT reqtemplateset FROM arc_styleset WHERE stylesetid=$colorset");

	if ($styleset_template!="") {
		$templatecheck = $dbr->result("SELECT templateid FROM arc_template WHERE templategroup='$styleset_template'");
	} else {
		$templatecheck = 0;
	}

	if (is_numeric($templatecheck) && $templatecheck!=0)
		$layout = $styleset_template;

	if (($avsize[0]>getSetting('max_avatar_width') || $avsize[1]>getSetting('max_avatar_height')) && $isadmin==0) {
		showmsg("The size of the avatar you have chosen exceeds the acceptable parameters of <b>".getSetting('max_avatar_width')."</b> width (Selected avatar width: <b>$avsize[0]</b>) and <b>".getSetting('max_avatar_height')."</b> height (Selected avatar height: <b>$avsize[1]</b>).<br>Please go back and try again.", 1);
	} else {
		$dbr->query("UPDATE arc_user SET
				 avatar='$avatar',
				 showonlineusers=$showonlineusers,
				 shownotes=$shownotes,
				 showquotes=$showquotes,
				 viewposttemps=$viewposttemps,
				 colorset=$colorset,
				 layout='$layout',
				 timeoffset='$timeoffset'
				 WHERE userid=$userid");
		header("Location user.php?action=editoptions");
	}

} elseif ($HTTP_GET_VARS['save']=='templates' && $caneditprofile==1) {
	if (getSetting('allowhtml')==0) {
		$post_header=htmlspecialchars($post_header);
		$post_footer=htmlspecialchars($post_footer);
	}
	$dbr->query("UPDATE arc_user SET
			 post_header='" .addslashes($post_header). "',
			 post_footer='" .addslashes($post_footer). "'
			 WHERE userid=$userid");

	header("Location user.php?action=edittemplates");
} elseif ($HTTP_GET_VARS['save']=='profile' && $caneditprofile==1) {

	if ($spassword=='') {
		$passbit='';
	} elseif ($spassword!='') {
		$password=md5($spassword);
		$passbit="password='$password', ";
		setcookie('arcpass', $password, time()+999999, '/');
	}

	$go=1;
	if (getSetting('caneditnames')==1) {
		$namecheck=$dbr->result("SELECT userid FROM arc_user WHERE displayname='" .addslashes($sdisplayname). "'");
		if (is_numeric($namecheck) && $displayname!=$sdisplayname) {
			if ($userid==$namecheck) {
				$go=1;
			} else {
				$feedback=getwordbit('displaynameinuse');
				$go=0;
			}
		}
	} else {
		$sdisplayname=$displayname;
	}

	if ($go==1) {
		$dbr->query("UPDATE arc_user SET
			 $passbit
			 usertext='" .insert_text($susertext). "',
			 email='" .insert_text($semail). "',
			 bday_day='" .htmlspecialchars(dbPrep($sbday_day)). "',
			 bday_month='" .htmlspecialchars($sbday_month). "',
			 bday_year='" .htmlspecialchars($sbday_year). "',
			 homepage='" .insert_text($shomepage). "',
			 occupation='" .insert_text($soccupation). "',
			 biography='" .insert_text($sbiography). "',
			 location='" .insert_text($slocation). "',
			 displayname='" .insert_text($sdisplayname). "'
			 WHERE userid=$userid");
		header("Location user.php?action=editprofile");
	}
} elseif ($HTTP_GET_VARS['save']=='notepad' && $caneditprofile==1) {
	if (empty($notepad)) $notepad=getwordbit('notepad_default');

	$dbr->query("UPDATE arc_user SET
			 notepad='" .dbPrep($notepad). "'
			 WHERE userid=$userid");
	header("Location user.php?action=home");
} elseif(isset($caneditprofile)) {
	if ($caneditprofile==0)
		$feedback=getwordbit('cannoteditprofile');
}

if ($action=='login_confirm') {
	if ($loggedin==1) {
		$feedback.=getwordbit('alreadyloggedin');
	} elseif(isset($lusername) && isset($lpassword)) {
		$feedback='';

		$tpass=$dbr->result("SELECT password FROM arc_user WHERE username='" .addslashes($lusername). "'");

		if (md5($lpassword)==$tpass) {
			$usernumber=$dbr->result("SELECT userid FROM arc_user WHERE username='". addslashes($lusername). "'");
			setcookie('arcuserid', $usernumber, time()+9999999, '/');
			setcookie('arcpass', md5($lpassword), time()+9999999, '/');

			$dbr->query("UPDATE arc_visitor SET
		             visitorlastpage='$SCRIPT_NAME',
		             visitortimestamp='" .(time()-$logouttime). "'
		             WHERE visitorip='$REMOTE_ADDR'");

			$userquery=$dbr->query("SELECT * FROM arc_user WHERE userid=$usernumber");
			$userinfo=$dbr->getarray($userquery);
			extract($userinfo, EXTR_OVERWRITE);

			$loggedin='1';

			$dbr->query("UPDATE arc_user SET last_page='$REQUEST_URI', last_active='" .time(). "' WHERE username='".addslashes($lusername)."' AND password='$password'");
			if (getSetting('rpg_flag')==1) {
				$feedback=modexp(getSetting('login_min_exp'), getSetting('login_max_exp'), $userid);
			}

			if ($rank===$admin) {
				$isadmin=1;
				$ismod=1;
			} elseif ($rank===$mod) {
				$isadmin=0;
				$ismod=1;
			} else {
				$isadmin=0;
				$ismod=0;
			}

			$feedback.=getwordbit('login_confirmed');
			if (isset($HTTP_REFERER))
				$referurl=$HTTP_REFERER;
			else
				$referurl=$HTTP_POST_VARS['referer'];

			$feedback=str_replace('<referurl>', $referurl, $feedback);
		} elseif (md5($lpassword)!=$tpass) {
			$feedback.=getwordbit('wrongpass');
		}
	}
} elseif ($action=='logout') {
	if ($loggedin!=0) {
		setcookie('arcuserid', $userid, time()-99999999, '/');
		setcookie('arcpass', $password, time()-99999999, '/');
		$dbr->query("UPDATE arc_user SET last_active='" .(time()-(60*getSetting('logouttime'))). "' WHERE username='$username'");
		$feedback.=str_replace('<sitename>', $sitename, getwordbit('logout_confirmed'));
	} else {
		$feedback.=getwordbit('notloggedin');
	}
}

if (empty($id))
	$id=$userid;
if ($action=='register' || $action=='list' || $action=='adduser' || $action=='login' || $action=='logout' || $action=='login_confirm' || $id!=$userid) { } else {
	$usrcpmenu=str_replace('<userid>', $userid, getTemplate('usercpmenu'));
	$header=str_replace('<usercpmenu>', $usrcpmenu, $header);
}

$userphptitletext=str_replace('<action>', $actn, getwordbit('userphptitletext'));
if (isset($HTTP_GET_VARS['clanid'])) {
	doHeader(str_replace('<sitename>', getSetting('sitename'), $userphptitletext),0,0,'',getTemplate('clantoolbar'));
} else {
	doHeader(str_replace('<sitename>', getSetting('sitename'), $userphptitletext));
}

if ($feedback!='')
	showmsg($feedback, 1);

switch ($action) {
	case 'register':
		require("adminfunctions.php");

		$inputs[]=formtop('user.php?action=adduser');
		$inputs[]=inputform('header', 'Login Information (Required)');
		$inputs[]=inputform('text', getwordbit('reg_username'), 'rusername');
		$inputs[]=inputform('password', getwordbit('reg_password'), 'rpassword');
		$inputs[]=inputform('header', 'Profile Information');
		$inputs[]=inputform('text', getwordbit('reg_displayname'), 'rdisplayname');
		$inputs[]=inputform('text', getwordbit('reg_email'), 'remail', 'you@yourdomain.com');
		$inputs[]=inputform('days', getwordbit('reg_bday_day'), 'rbday_day', 1);
		$inputs[]=inputform('months', getwordbit('reg_bday_month'), 'rbday_month', 1);
		$inputs[]=inputform('text', getwordbit('reg_bday_year'), 'rbday_year', '1969');
		$inputs[]=inputform('text', getwordbit('reg_homepage'), 'rhomepage', 'http://');
		$inputs[]=inputform('text', getwordbit('reg_occupation'), 'roccupation');
		$inputs[]=inputform('textarea', getwordbit('reg_biography'), 'rbiography');
		$inputs[]=inputform('textarea', getwordbit('reg_post_header'), 'rpost_header');
		$inputs[]=inputform('textarea', getwordbit('reg_post_footer'), 'rpost_footer');
		$inputs[]=inputform('text', getwordbit('reg_usertext'), 'rusertext');
		$inputs[]=inputform('avatars', getwordbit('reg_avatar'), 'avatars', 'lib/images/avatars/default.gif');
		if (getSetting('rpg_flag')==1) {
			$inputs[]=inputform('header', 'RPG Information');
			$inputs[]=inputform('races', getwordbit('reg_race'), 'rrace');
		} else {
 			$inputs[]=inputform('hidden', '', 'rrace', 1);
		}
		$inputs[]=inputform('submitreset', getwordbit('reg_submit'), getwordbit('reg_reset'));

		doinputs();
		formbottom();
		break;

	case 'adduser':
		if (isset($rusername)) {
			if ($rusername=='' || $rpassword=='' || $rdisplayname=='') {
				showmsg('reg_blank_fields');
				footer(1);
			}

			if (is_numeric($dbr->result("SELECT userid FROM arc_user WHERE username='".addslashes($rusername)."'"))) {
				showmsg('reg_name_in_use');
				footer(1);
			}

			if (is_numeric($dbr->result("SELECT userid FROM arc_user WHERE displayname='" .dbPrep($rdisplayname). "'"))) {
				showmsg('reg_name_in_use');
				footer(1);
			}

			if (getSetting('rpg_flag')==1) {
				$queryextra="exp=0,
			         level=1,
			         hp=$startinghp,
			         mp=$startingmp,
			         curhp=$startinghp,
			         curmp=$startingmp,
			         race='$rrace',
			         canbattle=1,
			         gold='" .getSetting('startinggold'). "',
			         spritepath='".getSetting('default_sprite')."',
			         flipsprite='".getSetting('flip_default_sprite')."',";
			} else {
				$queryextra='';
			}

			$startinghp=getSetting('startinghp');
			$startingmp=getSetting('startingmp');
			$totalusers=$dbr->result("SELECT COUNT(userid) FROM arc_user")+1;
			$rank=$dbr->result("SELECT rank FROM arc_rank WHERE minlvl=1");

			$dbr->query("INSERT INTO arc_user SET
			         displayname='" .insert_text($HTTP_POST_VARS['rdisplayname']). "',
			         username='" .insert_text($HTTP_POST_VARS['rusername']). "',
			         password='" .md5($HTTP_POST_VARS['rpassword']). "',
			         rank='$rank',
			         avatar='$HTTP_POST_VARS[avatars]',
			         $queryextra
			         email='" .insert_text($HTTP_POST_VARS['remail']). "',
			         bday_day='" .insert_text($HTTP_POST_VARS['rbday_day']). "',
			         bday_month='" .insert_text($HTTP_POST_VARS['rbday_month']). "',
			         bday_year='" .insert_text($HTTP_POST_VARS['rbday_year']). "',
			         homepage='" .insert_text($HTTP_POST_VARS['rhomepage']). "',
			         occupation='" .insert_text($HTTP_POST_VARS['roccupation']). "',
			         biography='" .insert_text($HTTP_POST_VARS['rbiography']). "',
			         post_header='" .insert_text($HTTP_POST_VARS['rpost_header']). "',
			         post_footer='" .insert_text($HTTP_POST_VARS['rpost_footer']). "',
			         usertext='" .insert_text($HTTP_POST_VARS['rusertext']). "',
			         reg_date='" .time(). "',
			         post_count='0',
			         colorset='" .getSetting('default_colorset'). "',
			         layout='" .getSetting('default_templateset'). "',
			         last_post='',
			         user_ip='$REMOTE_ADDR',
			         last_active='" .time(). "',
			         last_page='/user.php?action=adduser'");
			$lastuserid=$dbr->result("SELECT MAX(userid) AS muserid FROM arc_user");
			$dbr->query("UPDATE arc_misc SET lastuserid=$lastuserid,lastusername='".addslashes($rdisplayname)."', numusers=$totalusers");
			showmsg('reg_confirmed');
		} else {
			showmsg('reg_blank_fields');
		}
		break;

	case 'list':
		if (empty($HTTP_GET_VARS['orderby'])) {
			$orderby='displayname';
		} else {
			$orderby=urldecode($HTTP_GET_VARS['orderby']);
		}

		if (isset($HTTP_GET_VARS['letter'])) {
			$letter=urldecode($HTTP_GET_VARS['letter']);
			$query="SELECT * FROM arc_user WHERE displayname LIKE '$letter%' ORDER BY $orderby";
		} elseif (isset($HTTP_GET_VARS['clanid'])) {
			$clanid=validate_number($HTTP_GET_VARS['clanid']);
			$query="SELECT * FROM arc_user WHERE clanid=$clanid ORDER BY $orderby";
		} else {
			$query="SELECT * FROM arc_user ORDER BY $orderby";
		}

		$limit=getSetting('memberlist_limit');
		$numresults=$dbr->query($query);
		$numrows=mysql_num_rows($numresults);

		if (isset($HTTP_GET_VARS['offset'])) {
			$offset=$HTTP_GET_VARS['offset'];
		} else {
			$offset=0;
		}
		$result=$dbr->query("$query LIMIT $offset,$limit");

		if (isset($HTTP_GET_VARS['die_evil_users']) && $isadmin==1) {
			require("adminfunctions.php");
			deleterows('User', $deleteuser);
		}
		echo getTemplate('memberlistchoices');

		if ($isadmin==1) echo "<form action=\"./user.php?action=list&die_evil_users=\" method=\"post\">";

		$userslist=str_replace('<orderby>', $orderby, getTemplate('userlist'));
		$utemp='';
		$urow=getTemplate('userlistrow');
		while ($listarr=$dbr->getarray($result)) {
			if ($isadmin==1) {
				$deleter="<input type=\"checkbox\" name=\"deleteuser[]\" value=\"$listarr[userid]\" />";
			} else {
				$deleter='';
			}
			$row=str_replace('<deleter>', $deleter, $urow);
			$row=str_replace('<username>', htmlspecialchars(stripslashes($listarr['displayname'])), $row);
			$row=str_replace('<userid>', $listarr['userid'], $row);
			$row=str_replace('<email>', $listarr['email'], $row);
			$row=str_replace('<homepage>', $listarr['homepage'], $row);
			$row=str_replace('<rank>', $listarr['rank'], $row);
			$row=str_replace('<level>', $listarr['level'], $row);
			$row=str_replace('<exp>', number_format($listarr['exp']), $row);
			$row=str_replace('<hp>', $listarr['hp'], $row);
			$row=str_replace('<mp>', $listarr['mp'], $row);
			$row=str_replace('<topic_count>', $listarr['topics'], $row);
			$row=str_replace('<post_count>', $listarr['post_count'], $row);
			$row=str_replace('<note_count>', $listarr['note_count'], $row);
			$row=str_replace('<occupation>', $listarr['occupation'], $row);
			$row=altbgcolor($row);
			$utemp.=$row;
		}

		$userslist=str_replace('<pagelinks>', pagelinks($limit,$numrows,$offset, 'user'), $userslist);
		echo str_replace('<userlistrow>', $utemp, $userslist);

		if ($isadmin==1)
			echo '<center><input type="submit" value="Delete Selected Users" /></form>';

		break;

	case 'login':
			if ($loggedin==1) {
				showmsg('alreadyloggedin');
			} elseif($loggedin==0) {
				require('adminfunctions.php');

				if (empty($HTTP_REFERER))
					$HTTP_REFERER=$webroot;

				$inputs[]=formtop('user.php?action=login_confirm');
				$inputs[]=inputform('text', getwordbit('login_loginname'), 'lusername');
				$inputs[]=inputform('password', getwordbit('login_password'), 'lpassword');
				$inputs[]=inputform('hidden', '', 'referer', $HTTP_REFERER);
				$inputs[]=inputform('submitreset', getwordbit('loginsubmit'), getwordbit('loginreset'));
				foreach ($inputs as $value)
					echo "$value\n";

				formbottom();
			}
		break;

	case 'profile':
		if (isset($HTTP_GET_VARS['id'])) {
			$profile=getTemplate('profile');
			$id=getid();

			if (getSetting('rpg_flag')==1) {
				$query=$dbr->query("SELECT arc_user.*,arc_race.raceid,arc_race.racebonus,arc_race.name,arc_class.classability FROM arc_user,arc_race,arc_class WHERE arc_user.userid=$HTTP_GET_VARS[id] AND arc_race.raceid=arc_user.race AND arc_class.classid=arc_user.class LIMIT 0,1");
			} else {
				$query=$dbr->query("SELECT arc_user.* FROM arc_user WHERE arc_user.userid=$id");
			}
			$user=$dbr->getarray($query);

			if (!is_numeric($user['userid'])) {
				doHeader("$sitename: Error => Invalid UserID Specified");
				showmsg('profile_bad_id');
				footer(1);
			}

			$ph=$user['profilehits']+1;

			$dbr->query("UPDATE arc_user SET profilehits=$ph WHERE userid=$HTTP_GET_VARS[id]");
			if ($user['lastpostid']!="") {
				$eggs=$dbr->query("SELECT parentid,parentident FROM arc_post WHERE postid=$user[lastpostid]");
				$bacon=$dbr->getarray($eggs);

				if ($bacon['parentident']=='topic') {
					$tname=$dbr->result("SELECT ttitle FROM arc_topic WHERE topicid=$bacon[parentid]");
					$lastpostlink="<a href=\"post.php?action=readcomments&ident=topic&id=$bacon[parentid]#$user[lastpostid]\">" .stripslashes($tname). "</a>";
				} elseif ($bacon['parentident']=='pagebit') {
					$pname=$dbr->result("SELECT ptitle FROM arc_pagebit WHERE pagebitid=$bacon[parentid]");
					$lastpostlink="<a href=\"post.php?action=readcomments&ident=pagebit&id=$bacon[parentid]#$user[lastpostid]\">" .stripslashes($pname). "</a>";
				} else {
					$lastpostlink='';
				}
				$profile=str_replace('<lastpostlink>', $lastpostlink, $profile);
			}

			$noteid=$dbr->result("SELECT MAX(noteid) FROM arc_note WHERE noteuserid=$userid");
			$user['biography']=format_text($user['biography']);
			$user['lastnote']=stripslashes(parseurl($dbr->result("SELECT notemessage FROM arc_note WHERE noteid=$user[lastnoteid]")));

			$loginhours=floor($user['timeonline'] / 3600);
			$loginminutes=floor(($user['timeonline']-(3600*$loginhours)) / 60);
			$loginseconds=$user['timeonline']-(3600*$loginhours)-(60*$loginminutes);
			$user['timeonline']="$loginhours hours, $loginminutes minutes and $loginseconds seconds";
			$user['birthday']=date("F j, Y", mktime(0,0,0,$user['bday_month'],$user['bday_day'],$user['bday_year']));
			$user['last_active']=formdate($user['last_active'], getSetting('profile_lastread_timestamp'));

			if (getSetting('rpg_flag')==1 ) {
				require('./lib/rpgfunctions.php');

				$levelup=getSetting('levelup');

				$levxp=getlevxp($user['level']);

				$levminus=getlevxp($user['level']-1);
				if ($user['level']==1)
					$levminus=0;
				$eexp=$user['exp']-$levminus;
				$fexp=$levxp-$levminus;

				$user['hp_pct']=round(($user['curhp'] / $user['hp']) * 100);
				$user['hp_pct_leftover']=100 - $user['hp_pct'];
				$user['mp_pct']=round(($user['curmp'] / $user['mp']) * 100);
				$user['mp_pct_leftover']=100 - $user['mp_pct'];
				if ($fexp==0)
					$user['xp_pct']=0;
				else
					$user['xp_pct']=round(($eexp / $fexp) * 100);

				$user['xp_pct_leftover']=100 - $user['xp_pct'];

				$user['forlevelup']=number_format($levxp-$user['exp']);
				$user['levxp']=number_format($levxp);
				$user['exp']=number_format($user['exp']);
				$user['gold']=number_format($user['gold']);
				$user['sp']=number_format($user['sp']);

				$attackpower=0;
				$defensepower=0;
				setstatvars();
				setstatbonuses($user['racebonus']);

				// set icon path variables and elemental & stat bonuses
				foreach ($types as $val) {
					$user[$val]=getitemname($user[$val]);
					$profile=str_replace("<{$val}path>", $iconpath, $profile);
					$profile=str_replace("<{$val}id>", $itemid, $profile);
					$profile=str_replace("<{$val}power>", $power, $profile);
					if ($statbonus!='') setstatbonuses($statbonus);
					if ($type>8) {
						$attackpower=$attackpower+$power;
					} else {
						$defensepower=$defensepower+$power;
					}
				}

				$user['resfir']=$firplus;
				$user['rescld']=$cldplus;
				$user['reswat']=$watplus;
				$user['resear']=$earplus;
				$user['reshly']=$hlyplus;
				$user['resdrk']=$drkplus;
				$user['reslit']=$litplus;
				$user['resair']=$airplus;
				$user['strength']=$user['strength']+$strplus;
				$user['endurance']=$user['endurance']+$endplus;
				$user['intelligence']=$user['intelligence']+$intplus;
				$user['will']=$user['will']+$wilplus;
				$user['dexterity']=$user['dexterity']+$dexplus;
				$user['attack']=getattackpower($user['strength'], $attackpower, $user['classability']);
				$user['defense']=getdefense($user['endurance'], $defensepower, $user['classability']);
				$user['magattack']=getattackpower($user['intelligence']);
				$user['magdefense']=getdefense($user['will']);
				$user['evade']=round($user['dexterity']/2);
				$user['race']=stripslashes($user['name']);

				$user['status']='';
				if ($user['ispoison']!=0) {
					$user['status'].='Poisoned';
					if ($user['issleep']!=0 || $user['ispetrify']!=0)
						$user['status'].=', ';
				}
				if ($user['issleep']!=0) {
					$user['status'].='Asleep';
					if ($user['ispetrify']!=0)
						$user['status'].=', ';
				}
				if ($user['ispetrify']!=0) {
					$user['status'].='Petrified';
				}
				if ($user['status']=='')
					$user['status']=getwordbit('user_status_healthy');


				$classquery=$dbr->query("SELECT classid,name FROM arc_class WHERE classid=$user[class] OR classid=$user[subclass]");
				while ($class=$dbr->getarray($classquery)) {
					if ($class['classid']==$user['class'])
						$user['class']=stripslashes($class['name']);
					elseif ($class['classid']==$user['subclass'])
						$user['subclass']=stripslashes($class['name']);
				}

				if ($user['subclass']=='0')
					$user['subclass']='None';

				if (is_numeric($user['class']))
					$user['class']=stripslashes(getclassname($user['class']));

				if (is_numeric($user['subclass']))
					$user['subclass']=stripslashes(getclassname($user['subclass']));

				$user['skills']=countarrstr(' ', killspace(trim($user['skills'])));
				$user['items']=countarrstr(' ', killspace(trim($user['useritems'])));
				$user['sp']=number_format($user['sp']);
			}

			$profile=str_replace('<post_header>', format_text($user['post_header']), $profile);
			$profile=str_replace('<post_footer>', format_text($user['post_footer']), $profile);

			foreach($user as $key => $value)
				$profile=str_replace("<$key>", stripslashes($value), $profile);

			$profile=str_replace('<regdate>', formdate($user['reg_date'], getSetting('profile_timestamp')), $profile);
			if ($isadmin==1) $profile=str_replace('<banlink>', "[<a href=\"admin.php?action=banip&user=$user[userid]\">Ban IP</a>] [<a href=\"admin.php?action=banaccount&user=$user[userid]\">Ban Account</a>]", $profile);
			echo $profile;

			require('./lib/showposts.php');

			if (getSetting('showcommentsinprofile')==1) {
				showposts(getSetting('post_limit'));
			} else {
				$t=$dbr->query("SELECT userid,displayname,profilehits FROM arc_user WHERE userid=$id");
				$parentinfo=$dbr->getarray($t);
				$numposts=$dbr->result("SELECT COUNT(postid) FROM arc_post WHERE parentid=$id AND parentident='profile'");
				if ($numposts=='')
					$numposts=0;

				$toolbar=getTemplate('profiletoolbar');
				$pc=getwordbit('postreply');
				$pc=str_replace('<id>', $id, $pc);
				$pc=str_replace('<ident>', 'profile', $pc);
				$userlink="<a href=\"post.php?action=readcomments&ident=profile&id=$id\">" .stripslashes($parentinfo['displayname']). "</a>";

				$toolbar=str_replace('<displayname>', $userlink, $toolbar);
				$toolbar=str_replace('<newcommentlink>', $pc, $toolbar);
				$toolbar=str_replace('<numposts>', $numposts, $toolbar);
				$toolbar=str_replace('<profilehits>', $parentinfo['profilehits'], $toolbar);
				$toolbar=str_replace('<newreplypath>', $newreplypath, $toolbar);
				$title=stripslashes($parentinfo['displayname']);

				echo $toolbar;

				doHeader("$sitename: Viewing comments on " .stripslashes($parentinfo['displayname']));
			}
		}
		break;

	case 'editprofile':
		if ($loggedin==0) {
			showmsg('notloggedin');
		} elseif($loggedin==1 && $caneditprofile==1) {
			require("adminfunctions.php");

			$inputs[]=formtop('user.php?action=editprofile&save=profile', 'onSubmit="return disablesubmit(this);" ');
			$inputs[]=inputform('display', getwordbit('edit_loginname'), 'username', stripslashes($username));
			if (getSetting('caneditnames')==1) $inputs[]=inputform('text', getwordbit('edit_displayname'), 'sdisplayname', stripslashes($displayname));
			$inputs[]=inputform('password', getwordbit('edit_password'), 'spassword', '');
			$inputs[]=inputform('text', getwordbit('edit_usertext'), 'susertext', stripslashes($usertext), $formwidth, 50);
			$inputs[]=inputform('text', getwordbit('edit_email'), 'semail', $email);
			$inputs[]=inputform('days', getwordbit('edit_bday_day'), 'sbday_day', $bday_day);
			$inputs[]=inputform('months', getwordbit('edit_bday_month'), 'sbday_month', $bday_month);
			$inputs[]=inputform('text', getwordbit('edit_bday_year'), 'sbday_year', $bday_year, 4, 4);
			$inputs[]=inputform('text', getwordbit('edit_homepage'), 'shomepage', $homepage, $formwidth, 100);
			$inputs[]=inputform('text', getwordbit('edit_location'), 'slocation', stripslashes($location));
			$inputs[]=inputform('text', getwordbit('edit_occupation'), 'soccupation', stripslashes($occupation), 30, 20);
			$inputs[]=inputform('textarea', getwordbit('edit_biography'), 'sbiography', stripslashes($biography), $formwidth, 5);
			$inputs[]=inputform('submitreset', getwordbit('usercp_submit'), getwordbit('usercp_reset'));
			foreach ($inputs as $value) echo "$value\n";
			formbottom();
		}
		break;

	case 'editoptions':
		if ($loggedin==0) {
			showmsg('notloggedin');
		} elseif($loggedin==1 && $caneditprofile==1) {
			require("adminfunctions.php");

			$inputs[]=formtop('user.php?action=editoptions&save=options', 'onSubmit="return disablesubmit(this);" ');
			$inputs[]=inputform('avatars', getwordbit('edit_avatar'), 'avatar', $avatar);
			$inputs[]=inputform('text', getwordbit('edit_useownavatar'), 'ownavatar', '', $formwidth, 250);
			$inputs[]=inputform('yesno', getwordbit('edit_showonline'), 'showonlineusers',  $showonlineusers);
			$inputs[]=inputform('yesno', getwordbit('edit_shownotes'), 'shownotes',  $shownotes);
			$inputs[]=inputform('yesno', getwordbit('edit_showquotes'), 'showquotes',  $showquotes);
			$inputs[]=inputform('yesno', getwordbit('edit_postextras'), 'viewposttemps',  $viewposttemps);
			$inputs[]=inputform('text', getwordbit('edit_timeoffset').' '.formdate(time(), getSetting('post_timestamp')), 'timeoffset',  $timeoffset, 5, 3);
			$inputs[]=inputform('styles', getwordbit('edit_colorset'), 'colorset',  $colorset);
			$inputs[]=inputform('templates', getwordbit('edit_layout'), 'layout',  $layout);
			$inputs[]=inputform('submitreset', getwordbit('usercp_submit'), getwordbit('usercp_reset'));
			foreach ($inputs as $value) echo "$value\n";
			formbottom();
		}
		break;

	case 'edittemplates':
		if ($loggedin==0) {
			showmsg('notloggedin');
		} elseif($loggedin==1 && $caneditprofile==1) {
			require("adminfunctions.php");

			$inputs[]=formtop('user.php?action=edittemplates&save=templates', 'onSubmit="return disablesubmit(this);" ');
			$inputs[]=inputform('textarea', getwordbit('edit_post_header'), 'post_header', stripslashes($post_header), $formwidth, 8);
			$inputs[]=inputform('textarea', getwordbit('edit_post_footer'), 'post_footer', stripslashes($post_footer), $formwidth, 8);
			$inputs[]=inputform('submitreset', getwordbit('usercp_submit'), getwordbit('usercp_reset'));
			foreach ($inputs as $value) echo "$value\n";
			formbottom();

			$output = "\n<div align=\"left\">".$normalfont.format_text($post_header).'<br>'.getwordbit('postsampletext').'<br>'.format_text($post_footer).'<br> '.$cn."</div>\n";

			if (getSetting('rpg_flag')==1) {
				$levelup=getSetting('levelup');

				$levxp=getlevxp($level);

				$levminus=getlevxp($level-1);
				if ($level==1)
					$levminus=0;
				$eexp=$exp-$levminus;
				$fexp=$levxp-$levminus;

				$user['hp_pct']=round(($curhp / $hp) * 100);
				$user['hp_pct_leftover']=100 - $user['hp_pct'];
				$user['mp_pct']=round(($curmp / $mp) * 100);
				$user['mp_pct_leftover']=100 - $user['mp_pct'];
				if ($fexp==0)
					$user['xp_pct']=0;
				else
					$user['xp_pct']=round(($eexp / $fexp) * 100);

				$user['xp_pct_leftover']=100 - $user['xp_pct'];

				$user['forlevelup']=number_format($levxp-$exp);
				$user['levxp']=number_format($levxp);
				$user['exp']=number_format($exp);
				$user['gold']=number_format($gold);
				$user['sp']=number_format($sp);
				$stats=array('hp', 'mp', 'curhp', 'curmp', 'level', 'strength', 'endurance', 'intelligence', 'will', 'dexterity');

				foreach ($stats as $v)
					$user[$v]=$$v;

				foreach ($user as $k => $v)
					$output=str_replace("<$k>", $v, $output);
			}

			echo $output;
		}
		break;

	case 'home':
		if ($loggedin==0) {
			showmsg('notloggedin');
		} elseif($loggedin==1 && $caneditprofile==1) {
			require('adminfunctions.php');
			if (empty($notepad)) $notepad=getwordbit('notepad_default');

			$inputs[]=formtop('user.php?action=home&save=notepad', 'onSubmit="return disablesubmit(this);" ');
			$inputs[]=inputform('textarea', getwordbit('edit_notepad'), 'notepad', stripslashes($notepad), 70, 8);
			$inputs[]=inputform('submitreset', getwordbit('usercp_submit'), getwordbit('usercp_reset'));
			foreach ($inputs as $value) echo "$value\n";
			formbottom();
		}
		break;
}

footer();

?>