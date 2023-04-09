<?php

class dbcontrol
{
	var $name='';
	var $host='';
	var $user='';
	var $pass='';
	var $error_reporting=0;

    function connect()
    {
    	if (!mysql_connect($this->host, $this->user, $this->pass) && $this->error_reporting==1) {
    		echo 'MySQL connect failed. <br><br>MySQL says: ' .mysql_error();
    		exit();
    	}
    }
    function select()
    {
    	if (!mysql_select_db($this->name) && $this->error_reporting==1) {
    		echo "Could not select <b>$this->name</b>. <br><br>MySQL says: " .mysql_error();
    		exit();
    	}
    }
    function close()
    {
    	return mysql_close();
    }
}

class dbresults
{
	var $queries=0;
	var $troubleshooting=0;
	var $error_reporting=0;
	var $querytext='';

	function query($sql)
	{
		$result=mysql_query($sql);
		if (mysql_error()!='') echo "An error has occurred. The query being performed was <b>$sql</b><br><br>MySQL returned the error: " .mysql_error();
		$this->queries++;
		$this->querytext.='<b>'.$this->queries.'</b> '. $sql.'<hr>';
		return $result;
	}

	function result($sql)
	{
		$result=$this->query($sql);
		$r=@mysql_result($result, 0);
		return $r;
	}

	function getarray($data, $type=MYSQL_ASSOC)
	{
		if ($this->error_reporting==1) {
			return mysql_fetch_array($data, $type);
		} else {
			return @mysql_fetch_array($data, $type);
		}
	}

	function numrows($query)
	{
		return mysql_numrows($query);
	}
}

// useful in loops, useful for generating alternating values
function rowswitch($one, $two)
{
	GLOBAL $switch;

	if ($switch==1) {
		$switch=0;
		return $one;
	} else {
		$switch=1;
		return $two;
	}
}

function yesno($int)
{
	if ($int==1) {
		return 'Yes';
	} else {
		return 'No';
	}
}

function setpostvars($array)
{
	GLOBAL $HTTP_POST_VARS;

	foreach ($array as $key=>$val) {
		$$key=$HTTP_POST_VARS[$val];
		GLOBAL $$key;
	}
}

// formats text for database insertion, add security checks here
function insert_text($text)
{
	$text=preg_replace("'<script(.*?)</script>'si", '',$text);
	$text=preg_replace("'<script'si", '<<z>script', $text);
	$text=dehtml($text);
	return addslashes($text);
}

// formats text for display
function format_text($text, $allowhtml=1)
{
	if ($allowhtml==0) $text=htmlspecialchars($text);
	return stripslashes(nl2br(unfilter(bbcode_replace($text))));
}

// inefficient displayname grabber
function getdisplayname($userid)
{
	GLOBAL $dbr;
	return stripslashes($dbr->result("SELECT displayname FROM arc_user WHERE userid=$userid"));
}

// truncates text for words
function truncatewords($text, $maxwords)
{
	$wordarr=explode(' ', trim($text));
	$word_so_far=0;
	$totalwords=0;
	$stfu='';

	foreach ($wordarr as $word) {
		if ($word_so_far<$maxwords) {
			$stfu.="$word ";
			$word_so_far++;
		}
		$totalwords++;
	}
	if ($totalwords>$maxwords)
		$stfu.=getwordbit('text_truncated');

	return $stfu;
}

function validate_number($number)
{
	if (is_numeric($number)) {
		return $number;
	} else {
		echo "<br>Security Check: non-numeric value <b>\"".htmlspecialchars($number). "\"</b> being passed into designated number field.<br>";
		return 0;
	}
}

// takes $HTTP_GET_VARS['offset'] and creates a global variable called $offset
function getoffset()
{
	GLOBAL $HTTP_GET_VARS;

	if (isset($HTTP_GET_VARS['offset'])) {
		return validate_number($HTTP_GET_VARS['offset']);
	} else {
		return 0;
	}
}

function getid()
{
	GLOBAL $HTTP_GET_VARS;
	if (isset($HTTP_GET_VARS['id'])) {
		return validate_number($HTTP_GET_VARS['id']);
	} else {
		return FALSE;
	}
}

// generates accurate render time
function builtin()
{
	GLOBAL $startload;
	$t=gettimeofday();
	$buildtime=floor(($t['sec']+$t['usec']/1000000-$startload)*10000)/10000;
	return $buildtime;
}

// bgcolor-alternator, for use in loops
function altbgcolor($var)
{
	GLOBAL $tdbgcolor, $alttablebgcolor;

	if (getSetting('alternatetdbgcolors')==1) {
		$var=str_replace('<alt_bg>', rowswitch($tdbgcolor, $alttablebgcolor), $var);
	} else {
		$var=str_replace('<alt_bg>', $tdbgcolor, $var);
	}
	return $var;
}

// returns template value when called with a templates name
function getTemplate($template)
{
	GLOBAL $$template,$showcomments;
	if (isset($$template)) {
		$templatevalue=$$template;
	} else {
		$templatevalue="Error: template $template was not cached";
	}
	if (getSetting('showcomments')==1) {
		return "\n<!-- start $template:$layout -->\n$templatevalue\n<!-- end $template:$layout -->";
	} else {
		return $templatevalue;
	}
}

// returns setting value when called with setting name
function getSetting($setting_name)
{
	global $$setting_name;
	if (isset($$setting_name)) {
		return $$setting_name;
	} else {
		return "Error: Setting $setting_name was not cached";
//		return $dbr->result("SELECT settingvalue FROM arc_setting WHERE settingname='$setting_name'");
	}
}

// returns wordbit value when called with wordbit name
function getwordbit($wordbit_name)
{
	GLOBAL $$wordbit_name;
	if (empty($$wordbit_name) && $wordbit_name!="") {
		return "Error: wordbit $wordbit_name was not cached";
//		return $dbr->result("SELECT wordbitvalue FROM arc_wordbit WHERE wordbitname='$wordbit_name'");
	} else {
		return $$wordbit_name;
	}
}

// outputs wordbit value in the common_message template when called with wordbit name
// if second argument is used, it just outputs the first argument, rather then finding
// a wordbit for it
function showmsg($text, $taketext=0)
{
	if ($taketext==1) {
		echo str_replace('<message>', stripslashes($text), getTemplate('common_message'));
	} else {
		echo str_replace('<message>', nl2br(getwordbit($text)), getTemplate('common_message'));
	}
}

// it checks the get_magic_quotes php setting and adds slashes if it is not turned on
// doesn't seem to work, best to just use addslashes()
function dbPrep($string)
{
	if (get_magic_quotes_gpc()==1) {
		return $string;
	} else {
		return addslashes($string);
	}
}

// same as above, also independable
function dbout($string)
{
	if (get_magic_quotes_gpc()==1) {
		return $string;
	} else {
		return stripslashes($string);
	}
}

// deletes rows from the table named $name, takes and array of ids
function deleterows($name, $idarray, $extra='')
{
	GLOBAL $dbr;
	$x='0';
	$table=strtolower($name);
	while ($b=each($idarray)) {
		$dbr->query("DELETE FROM arc_$table$extra WHERE {$name}id='$idarray[$x]'");
		showmsg("$name number <b>" .dbout($idarray[$x]). "</b> has been deleted.", 1);
		$x=$x+1;
		flush();
	}
}

// deletes multiple spaces
function killspace($str)
{
	return str_replace('  ', ' ', $str);
}

function insert_style_vars($str)
{
	GLOBAL $styles;
	if (is_array($styles))
		foreach($styles as $n => $v)
			$str=str_replace("<$n>", $v, $str);
	return $str;
}

// gets rating from rating-string used in clan and rom scripts
function getrating($ratings)
{
	$totalpoints=0;
	$numratings=0;

	$ratearray=explode(',', $ratings);
	foreach($ratearray as $val) {
		$totalpoints=$totalpoints+$val;
		$numratings=$numratings+1;
	}
	$numratings=$numratings-1;
	if ($totalpoints > 0 && $numratings > 0) {
		return round($totalpoints / $numratings, 2);
	} else {
		return 0;
	}
}

function parseurl($text, $parseurls=1)
{
	if ($parseurls==1) {
		$parsed=eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])",
		"<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$text);
		$parsed=eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))",
		"<a href=\"mail.php?addr=\\1\" target=\"_blank\">\\1</a>", $parsed);
		return $parsed;
	} else {
		return $text;
	}
}

function bbcode_replace($str)
{
	$str=str_replace('[b]','<b>',$str);
	$str=str_replace('[/b]','</b>',$str);
	$str=str_replace('[i]','<i>',$str);
	$str=str_replace('[/i]','</i>',$str);
	$str=str_replace('[u]','<u>',$str);
	$str=str_replace('[/u]','</u>',$str);
	$str=str_replace('[s]','<s>',$str);
	$str=str_replace('[/s]','</s>',$str);
	$str=str_replace('[img]','<img src=',$str);
	$str=str_replace('[/img]',' />',$str);
	$str=str_replace('[quote]','<hr size="1" noshade /><font size="-2">',$str);
	$str=str_replace('[/quote]','</font><hr size="1" noshade />',$str);
	return $str;
}

function bbcode_reverse($str)
{
	$str=str_replace('<b>','[b]',$str);
	$str=str_replace('</b>','[/b]',$str);
	$str=str_replace('<i>','[i]',$str);
	$str=str_replace('</i>','[/i]',$str);
	$str=str_replace('<u>','[u]',$str);
	$str=str_replace('</u>','[/u]',$str);
	$str=str_replace('<s>','[s]',$str);
	$str=str_replace('</s>','[/s]',$str);
	$str=str_replace('<hr size="1" noshade /><font size="-2">','[quote]',$str);
	$str=str_replace('</font><hr size="1" noshade />','[/quote]',$str);
	$str=str_replace('<img src=','[img]',$str);
	$str=str_replace('</img>','[/img]',$str);
	return $str;
}

function avatardecode($avname)
{
	$avname=str_replace('+', ' ', $avname);
	$avname=str_replace('_', ' ', $avname);
	$avname=str_replace('.gif', '', $avname);
	$avname=str_replace('.jpg', '', $avname);
	$avname=str_replace('.jpeg', '', $avname);
	$avname=str_replace('.bmp', '', $avname);
	$avname=str_replace('.png', '', $avname);
	$avname=str_replace('%20', ' ', $avname);
	return $avname;
}

function filter($str) // annoying things
{
	$str=eregi_replace(' +', ' ', $str);
	$str=eregi_replace('javascript:', '', $str);
	$str=eregi_replace('java script:', '', $str);
	$str=eregi_replace('<iframe', '', $str); // ' corrective syntax higlighting
	$str=eregi_replace('document.cookie', '', $str);
	return $str;
}

// fixes ugly things caused by htmlspecialchars
function unfilter($str)
{
	$str=str_replace('&amp;', '&', $str);
	$str=str_replace('&quot;', '"', $str);
	return $str;
}

// conditional htmlspecialchars on text, depending on an config setting
function dehtml($string)
{
	GLOBAL $allowhtml;
	if (getSetting('allowhtml')==0) {
		return htmlspecialchars($string);
	} elseif ($allowhtml==1) {
		return filter($string);
	}
}

// adds site offset to date and pointlessly reverses the arguments, what was I smoking?
function formdate($time, $formatstring)
{
	global $timeoffset,$sitetimeoffset;
	$time=$time + (3600 * $timeoffset) + (3600 * $sitetimeoffset);
	return date($formatstring, $time);
}

// counts elements in an delimited string
function countarrstr($delimiter, $str)
{
	return count(explode($delimiter, $str));
}

function forumPermStr($failed, $passed='')
{
	GLOBAL $isadmin,$ismod,$mods_see_private_forums;
	if ($isadmin==1 || $ismod==1) {
		if ($isadmin==1) {
			$cansee=1;
		} elseif (getSetting('mods_see_private_forums')==1) {
			$cansee=1;
		} elseif ($isadmin==0 && getSetting('mods_see_private_forums')==0) {
			$cansee=0;
		}
		if ($cansee==1) {
			return $passed;
		} else {
			return $failed;
		}
	} else {
		return $failed;
	}
}

function pagelinks($limit,$numrows,$offset=0,$name,$incp=0)
{
	GLOBAL $PHP_SELF,$HTTP_GET_VARS;

	$this='';
	$html='';

	foreach($HTTP_GET_VARS as $key=>$value)
		if($key!='offset' && $key!='lastpage')
			$this.="&$key=$value";

	if ($offset>=$limit) {
		$prevoffset=$offset-$limit;
		$html.="<a href=\"$PHP_SELF?$this&offset=$prevoffset\" title=\"Previous $limit {$name}s\">&laquo;</a> \n";
	}
	if ($limit>0) {
		$pages=floor($numrows/$limit);
		$curpage=round($offset/$limit);
		$curpage=$curpage+1;
	} else {
		$curpage=1;
		$pages=1;
	}

	if ($numrows%$limit)
		$pages++;

	for ($i=1;$i<=$pages;$i++) {
		$newoffset=$limit*($i-1);
		if ($pages>1) {
			if ($i==$curpage) {
				$html.="<font size=\"+1\"><a href=\"$PHP_SELF?$this&offset=$newoffset\">[$i]</a></font> \n";
			} else {
				$html.="<a href=\"$PHP_SELF?$this&offset=$newoffset\">$i</a> \n";
			}
		}
	}

	if ((($offset+$limit)<$numrows) && $pages!=1) {
		$newoffset=$offset+$limit;
		$html.="<a href=\"$PHP_SELF?$this&offset=$newoffset\" title=\"Next $limit {$name}s\">&raquo;</a>\n";
	}
	return $html;
}

function doHeader($thetitle, $addrefresh=0, $refreshtime=0, $refreshurl='', $extravar='')
{
	GLOBAL $header,$headercalled;

	if ($headercalled==1)
		return FALSE;

	if ($addrefresh==1) {
		$meta="<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$refreshtime;URL=$refreshurl\">";
	} else {
		$meta='';
	}

	$headercalled=1;

	echo stripslashes("<html>\n<head>$meta\n<title>$thetitle</title>$header$extravar");
}

function footer($exitnow=0)
{
	GLOBAL $footer,$dbr,$stopfooter;

	if (empty($stopfooter)) {
		$buildtime=builtin();
		$footer=str_replace('<buildtime>', $buildtime, $footer);
		$footer=str_replace('<numberqueries>', $dbr->queries, $footer);
		echo $footer;
		if ($dbr->troubleshooting==1) {
			echo $dbr->querytext;
		}
		if (getSetting('gzcompress')==1) ob_end_flush();
		if ($exitnow==1) exit();
	}
}

// I found I was typing this code in a lot of places
function checkloggedin($doheader=0, $dofooter=1)
{
	GLOBAL $loggedin;
	if ($loggedin==0) {
		showmsg('You must be logged in to view this page.', 1);
		footer(1);
	}
}

// variant of the above, useful for having specific  'not logged in' messages
function retloggedin($doheader=0, $dofooter=1)
{
	GLOBAL $loggedin;
	if ($loggedin==1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// creates global variables from a comma delimited string
// with the values of {type}value from the database so if the
// columns are named {type}name and {type}value this will set
// all the variables specified where {type} is setting or wordbit
function setcache($namestring, $type)
{
	GLOBAL $numqueries,$dbr;
	if (empty($namestring))
		$namestring='';

	$array=explode(',',$namestring);
	$setting='';
	$c=count($array);
	$n=0;

	if (empty($$type))
		$$type='';

	foreach ($array as $val) { // form sql query
	    $$type .= " {$type}name='$val'";
	    $n++;
	    if ($n<$c) $$type .= ' OR';
	}

	$call=$dbr->query("SELECT {$type}name,{$type}value FROM arc_{$type} WHERE".$$type);
	$numqueries++;

	while ($row=$dbr->getarray($call)) {
		$typename=$type . 'name';
		$typevalue=$type . 'value';
		GLOBAL $$row[$typename];
		$$row[$typename]=$row[$typevalue];
	}
}

// updates searchwords table with noisewords filtered from $text
function updatesearchindex($text, $id, $table, $clearfirst=0)
{
	GLOBAL $dbr,$path;
	if ($clearfirst==1) $dbr->query("DELETE FROM arc_searchwords WHERE wid=$id AND tablename='$table'");
    $noise_words=file($path.'lib/words.txt');
    $filtered=$text;
    $filtered=ereg_replace("^"," ",$filtered);

    for ($i=0; $i<count($noise_words); $i++) {
        $filterword=trim($noise_words[$i]);
        $filtered=eregi_replace(" $filterword "," ",$filtered);
    }

    $filtered=trim($filtered);
    $filtered=addslashes($filtered);
    $querywords=ereg_replace(",","",$filtered);
    $querywords=ereg_replace(" ",",",$querywords);
    $querywords=ereg_replace("\?","",$querywords);
    $querywords=ereg_replace("\(","",$querywords);
    $querywords=ereg_replace("\)","",$querywords);
    $querywords=ereg_replace("\.","",$querywords);
    $querywords=str_replace(",","','",$querywords);
    $querywords=ereg_replace("^","'",$querywords);
    $querywords=ereg_replace("$","'",$querywords);
    $eachword=explode(",", $querywords);
    $eachword=array_unique($eachword);

	foreach ($eachword as $val) if (trim($val)!="" && $val!=" ") $dbr->query("REPLACE arc_searchwords VALUES($val,$id, '$table')");
}

// returns an associate array whose indexes are the $array arguments values
function set_val_as_key($array)
{
	foreach ($array as $val) {
		$newarray[$val]=$val;
	}
	return $newarray;
}

// rather narrow function to perform floodchecks in post areas
function floodcheck($printheader=0)
{
	GLOBAL $last_post,$normalfont,$cn,$numqueries,$myspiffytrout,$isadmin;
	if ((time() - $last_post) < getSetting('floodtime') && $isadmin==0) {
		if ($printheader==1) doHeader('Floodcheck Encountered');
		$msg=str_replace('<floodtime>', getSetting('floodtime'), getwordbit('floodcheck'));
		$msg=str_replace('<elapsed>', (time() - $last_post), $msg);
		showmsg($msg, 1);
		footer(1);
	}
}

// takes an array of variables and swaps them with fake html tags named by the array indexes
function mass_replace($vars, $returnvar)
{
	GLOBAL $$returnvar;
	foreach ($vars as $val) {
		$returnvar=str_replace("<$val>", $val, $$returnvar);
	}
}

// takes user level and returns experience needed for next level
function getlevxp($level)
{
	if (getSetting('explevelmultiplier')==1) {
		if ($level==1) {
			$sublevel=1;
		} else {
			$sublevel=$level-1;
		}
		$experience=round($sublevel * (getSetting('levelup') + ($level * getSetting('levelup'))));
	} else {
		$experience=$level * getSetting('levelup');
	}
	return $experience;
}

// takes range between min and max experience a user gains and returns a report showing the update
function modexp($loexp, $hiexp, $userid, $givexp=1, $expmod=0, $showreport=1, $string='')
{
	GLOBAL $admin,$mod,$dbr,$level,$exp,$webroot;

	if (getSetting('rpg_flag')==1) {

		$usr['hpgain']=0;$usr['mpgain']=0;$usr['strgain']=0;$usr['endgain']=0;$usr['dexgain']=0;$usr['intgain']=0;$usr['wilgain']=0;
		$usr['hpbonus']=0;$usr['mpbonus']=0;$usr['strbonus']=0;$usr['endbonus']=0;$usr['dexbonus']=0;$usr['intbonus']=0;$usr['wilbonus']=0;

		$usrquery=$dbr->query("SELECT
							arc_user.displayname,
							arc_user.rank,
							arc_user.level,
							arc_user.hp,
							arc_user.mp,
							arc_user.curhp,
							arc_user.curmp,
							arc_user.exp,
							arc_user.race,
							arc_user.class,
							arc_user.strength,
							arc_user.endurance,
							arc_user.intelligence,
							arc_user.will,
							arc_user.dexterity,
							arc_user.fighterimage,
							arc_user.gold,
							arc_user.sp,
							arc_class.hpgain,
							arc_class.mpgain,
							arc_class.strgain,
							arc_class.endgain,
							arc_class.dexgain,
							arc_class.intgain,
							arc_class.wilgain,
							arc_race.hpbonus,
							arc_race.mpbonus,
							arc_race.strbonus,
							arc_race.endbonus,
							arc_race.dexbonus,
							arc_race.intbonus,
							arc_race.wilbonus
						   FROM
						    arc_user,
						    arc_class,
						    arc_race
						   WHERE
						    arc_user.userid=$userid AND
						    arc_class.classid=arc_user.class AND
						    arc_race.raceid=arc_user.race");
	} else {
		$usrquery=$dbr->query("SELECT displayname, rank, level, exp, hp, mp FROM arc_user WHERE arc_user.userid=$userid");
	}
	$usr=$dbr->getarray($usrquery);

	if (getSetting('experience_type')=='characters') {
		$expmod=ceil(strlen($string) * getSetting('character_exp_value'));
		$exp=$usr['exp']+$expmod;
		$change=getwordbit('exp_up');
	} else {
		if ($givexp==1) {
			if ($loexp==$hiexp || $hiexp==0) {
				$expmod=$loexp;
			} else {
				$expmod=mt_rand($loexp, $hiexp);
			}
			$exp=$usr['exp']+$expmod;
			$change=getwordbit('exp_up');
		} else {
			$exp=$usr['exp']-$expmod;
			$change=getwordbit('exp_down');
		}
	}

	if (getSetting('rpg_flag')==1) {
		$goldmod=round($expmod * getSetting('gold_exp_ratio'));
		$gold=$usr['gold']+$goldmod;
		$spmod=round($expmod * getSetting('sp_exp_ratio'));
		$sp=$usr['sp']+$spmod;
	}

	$levxp=getlevxp($usr['level']);

	if ($exp>=$levxp && $showreport==1) { // level up
		list($usec,$sec)=explode(' ',microtime());
		mt_srand($sec * $usec);

		$basehpgain=mt_rand(getSetting('min_hp_gain'), getSetting('max_hp_gain'));
		$basempgain=mt_rand(getSetting('min_mp_gain'), getSetting('max_mp_gain'));

		if (getSetting('rpg_flag')==1) {
			$hpplus=round($basehpgain + $usr['hpgain'] + $usr['hpbonus']);
			$hpplus=ceil($hpplus * getSetting('level_factor'));
			$mpplus=intval($basempgain + $usr['mpgain'] + $usr['mpbonus']);
			$mpplus=ceil($mpplus * getSetting('level_factor'));
			$strplus=$usr['strgain']+$usr['strbonus'];
			$endplus=$usr['endgain']+$usr['endbonus'];
			$intplus=$usr['intgain']+$usr['intbonus'];
			$wilplus=$usr['wilgain']+$usr['wilbonus'];
			$dexplus=$usr['dexgain']+$usr['dexbonus'];
			$newstr=$usr['strength']+$strplus;
			$newend=$usr['endurance']+$endplus;
			$newint=$usr['intelligence']+$intplus;
			$newwil=$usr['will']+$wilplus;
			$newdex=$usr['dexterity']+$dexplus;
			$newcurhp=$usr['curhp'] + $hpplus;
			$newcurmp=$usr['curmp'] + $mpplus;
		} else {
			$hpplus=$basehpgain;
			$mpplus=$basempgain;
		}

		$newhp=$usr['hp'] + $hpplus;
		$newmp=$usr['mp'] + $mpplus;
		$level=$usr['level']+1;

		if ($usr['rank']!=$admin && $usr['rank']!=$mod && $usr['rank']!=$staff) {
			$rank=$dbr->result("SELECT rank FROM arc_rank WHERE minlvl=$level");
			if ($rank=='') {
				$rank=$dbr->result("SELECT MAX(rankid) FROM arc_rank WHERE minlvl=<$level");
				$rank=$dbr->result("SELECT rank FROM arc_rank WHERE rankid=$rank");
			}
			$qinsert=", rank='$rank'";
			if ($rank=='')
				$qinsert='';
		} else {
			$qinsert='';
		}

		if (getSetting('rpg_flag')==1) {

			$dbr->query("UPDATE arc_user SET level=$level, hp=$newhp, mp=$newmp, curhp=$newcurhp, curmp=$newcurmp, exp=$exp, gold=$gold, sp=$sp, strength=$newstr,
						 endurance=$newend, intelligence=$newint, will=$newwil, dexterity=$newdex$qinsert
						 WHERE userid=$userid");

			$report=str_replace('<str>', $usr['strength'], $report);
			$report=str_replace('<end>', $usr['endurance'], $report);
			$report=str_replace('<int>', $usr['intelligence'], $report);
			$report=str_replace('<wil>', $usr['will'], $report);
			$report=str_replace('<dex>', $usr['dexterity'], $report);
			$report=str_replace('<level>', $level, $report);
			$report=str_replace('<newhp>', $newhp, $report);
			$report=str_replace('<newmp>', $newmp, $report);
			$report=str_replace('<newstr>', $newstr, $report);
			$report=str_replace('<newend>', $newend, $report);
			$report=str_replace('<newint>', $newint, $report);
			$report=str_replace('<newwil>', $newwil, $report);
			$report=str_replace('<newdex>', $newdex, $report);
			$report=str_replace('<hpplus>', $hpplus, $report);
			$report=str_replace('<mpplus>', $mpplus, $report);
			$report=str_replace('<strplus>', $strplus, $report);
			$report=str_replace('<endplus>', $endplus, $report);
			$report=str_replace('<intplus>', $intplus, $report);
			$report=str_replace('<wilplus>', $wilplus, $report);
			$report=str_replace('<dexplus>', $dexplus, $report);
		}
		$report=getTemplate('level_up');
		$report=str_replace('<hp>', $usr['hp'], $report);
		$report=str_replace('<mp>', $usr['mp'], $report);
		$report=str_replace('<rank>', $usr['rank'], $report);
	} else {

		if (getSetting('rpg_flag')==1) {
			$dbr->query("UPDATE arc_user SET exp=$exp,gold=$gold,sp=$sp WHERE userid=$userid");
		} else {
			$dbr->query("UPDATE arc_user SET exp=$exp WHERE userid=$userid");
		}

		if ($showreport==1) {
			$report=getTemplate('expchanged');
			$report=str_replace('<change>', $change, $report);
		} else {
			$report='';
		}
	}

	if (getSetting('rpg_flag')==1) {
		$report=str_replace('<gold>', number_format($gold), $report);
		$report=str_replace('<goldmod>', number_format($goldmod), $report);
		$report=str_replace('<sp>', number_format($sp), $report);
		$report=str_replace('<spmod>', number_format($spmod), $report);
	}
	$report=str_replace('<webroot>', $webroot, $report);
	$report=str_replace('<displayname>', stripslashes(htmlspecialchars($usr['displayname'])), $report);
	$report=str_replace('<userid>', $userid, $report);
	$report=str_replace('<exptogo>', number_format($levxp-$exp), $report);
	$report=str_replace('<exp>', number_format($exp), $report);
	$report=str_replace('<expmod>', number_format($expmod), $report);
	$report=str_replace('<levxp>', number_format(getlevxp($level)), $report);
	return $report;
}


?>