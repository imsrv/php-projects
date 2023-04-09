<?php

$cpfont="<font size=\"-2\" face=\"verdana\" color=\"#000000\">";

function doinputs()
{
	GLOBAL $inputs;
	foreach ($inputs as $value) echo $value;
}

function eol_out($text)
{
	$text=ereg_replace("\r", "0150", $text);
	$text=addslashes($text);
	return ereg_replace("\n", "0120", $text);
}

function eol_in($text)
{
	$text=ereg_replace("0150", "\r", $text);
	$text=stripslashes($text);
	return ereg_replace("0120", "\n", $text);
}

function fileencode($text)
{
	$text=strtolower($text);
	$text=str_replace('!', '', $text);
	$text=str_replace("'", '', $text);
	$text=str_replace('"', '', $text);
	return str_replace(' ', '_', $text);
}

function getcprows($name)
{
	GLOBAL $id,$dbr;
	$thequery=$dbr->query("SELECT * FROM arc_$name WHERE {$name}id='$id'");
	return $dbr->getarray($thequery);
}

function cplinkheader($text)
{
	echo "
  <tr>
    <td bgcolor=\"#000000\" align=\"center\" height=\"25\">
        <font face=\"verdana\" size=\"-2\" color=\"#ffffff\"><b><u>$text</u></b> </font>
    </td>
  </tr>\n";
}

function cplink($url,$link)
{
	GLOBAL $cpfont;
	echo "
  <tr>
    <td bgcolor=\"#d0d0d0\">
        $cpfont<a href=\"$url\" target=\"main\">$link</a> </font>
    </td>
  </tr>\n";
}

function cptabletop()
{
	echo "\n<table style=\"border: 1px solid #000000; margin-bottom: 5px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#ffffff\">
  <tr><td><table width=\"130\" cellspacing=\"1\" border=\"0\" cellpadding=\"0\">\n";
}

function cptablebottom()
{
	echo "\n</table></td></tr></table>\n";
}

function getaddbitaction($buildvar='', $path='admin.php?action=build')
{
	GLOBAL $tablebordercolor;
	echo "\n<div align=\"center\">
<table bgcolor=\"$tablebordercolor\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td>
<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" width=\"100%\">
<form action=\"$path$buildvar\" method=\"post\">\n";
}

function getaddbitsubmit($submitvar='')
{
	echo "\n</table></td></tr></table>
<br />
<div align=\"center\">
  <input type=\"submit\" name=\"add$submitvar\" value=\"Create New $submitvar\" />
  <input type=\"reset\" value=\"Clear Fields\" />
</div>\n";
}

function geteditbitaction($savevarname='')
{
	GLOBAL $tablebordercolor;
	echo "\n<div align=\"center\">
<table bgcolor=\"$tablebordercolor\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td>
<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" width=\"100%\">
<form action=\"admin.php?action=modify\" method=\"post\">\n";
}

function geteditbitsubmit($submitvarname='')
{
	echo "\n</table></td></tr></table>
<br />
<div align=\"center\">
  <input type=\"submit\" name=\"submit$submitvarname\" value=\"Save Changes\" />
  <input type=\"reset\" value=\"Undo Changes\" />
</div>\n";
}

function inputform($type, $description, $name='', $value='', $size=50, $maxlength=80)
{
	GLOBAL $tdbgcolor,$tdheadbgcolor,$webroot,$normalfont,$cn,$isadmin,$userid,$layout,$dbr,$formwidth,$textarea_rows,$race,$level;
	if ($size==50)
		$size=$formwidth;

	$commonhtml="\n  <tr>
    <td bgcolor=\"$tdbgcolor\" width=\"40%\">
        $normalfont" .stripslashes($description). "<br />$cn
    </td>
    <td bgcolor=\"$tdbgcolor\" align=\"top\">\n";
	switch ($type) {

		case 'text':
			$html="\n$commonhtml
        <input type=\"text\" name=\"$name\" size=\"$size\" maxlength=\"$maxlength\" value=\"".htmlspecialchars($value)."\"></input>
    </td>
  </tr>\n";
			break;

		case 'polltext':
			$html="\n<tr>
    <td bgcolor=\"$tdbgcolor\" colspan=\"2\">
        <input type=\"text\" name=\"$name\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" />
    </td>
  </tr>\n";
			break;

		case 'avatar':
			$html="\n
  <tr>
    <td bgcolor=\"$tdbgcolor\"><img src=\"$webroot/lib/images/avatars/$value\" alt=\"$name\" border=\"0\" />";
			break;
		case 'checkbox':
			$html="\n<tr><td bgcolor=\"$tdbgcolor\"><input type=\"checkbox\" name=\"$name\" value=\"$value\" />$normalfont-$description-<br />$cn</td></tr>";
			break;

		case 'float':
			$html="\n<table width=\"$name\" border=\"0\"><tr>
    <td bgcolor=\"$tdbgcolor\">
        $normalfont" .stripslashes($description). "$cn
    </td>
  </tr></table>\n";
			break;

		case 'display':
			$html="\n$commonhtml
        $normalfont<b>" .stripslashes($value). "</b>$cn
    </td>
  </tr>\n";
			break;

		case 'header':
			$html="
  <tr>
    <td bgcolor=\"$tdheadbgcolor\" colspan=\"2\">$normalfont" .stripslashes($description). "$cn
    </td>
  </tr>\n";
			break;

		case 'password':
			$html="\n$commonhtml
        <input type=\"password\" name=\"$name\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" />
    </td>
  </tr>\n";
			break;

		case 'file':
			$html="$commonhtml
        <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$maxlength\">
        <input type=\"file\" name=\"$name\" size=\"$size\" />
    </td>
  </tr>\n";
			break;

		case 'textarea':
			$maxlength=$textarea_rows;
			$html="\n$commonhtml
        <textarea name=\"$name\" rows=\"$maxlength\" cols=\"$size\" wrap>$value</textarea>
    </td>
  </tr>\n";
			break;

		case 'radio':
			$html="\n<tr><td bgcolor=\"$tdbgcolor\" colspan=\"2\">
        <input type=\"radio\" name=\"$name\" value=\"$value\" />$normalfont-$description-<br />$cn
    </td>
  </tr>\n";
			break;

		case 'avatars':
			$avatarlistsize=getSetting('avatarlistsize');
			$num=$dbr->result("SELECT COUNT(avatarid) AS numavs FROM arc_avatar");
			$html="$commonhtml<table width=\"100%\"><tr><td width=\"50%\">
			      <select size=\"$avatarlistsize\" name=\"$name\" onchange=\"document.images.avatardisplay.src = this[this.selectedIndex].value;\">
				  <option value=\"$value\" selected>Previous</option>";
			$aquery=$dbr->query("SELECT avatar FROM arc_avatar ORDER BY avatar");
			while ($avs=$dbr->getarray($aquery)) {
				$html .= "\n<option value=\"lib/images/avatars/$avs[avatar]\">" .avatardecode($avs['avatar']). '</option>';
			}
			$html.="</select><td align=\"center\" width=\"50%\" valign=\"middle\">
			<img src=\"$value\" name=\"avatardisplay\" border=\"0\" /><br />{$normalfont}Total Avatars: <b>$num</b>$cn</td></tr></table></td></tr>";
			break;

		case 'styles':
			$html="$commonhtml<select name=\"$name\">";
			if ($value!="" && $value!=0) {
				$shrimprgood=$dbr->result("SELECT stylesetname FROM arc_styleset WHERE stylesetid=$value");
				$html.="<option value=\"$value\" selected>$shrimprgood</option>";
			} else {
				$html.="<option value=\"0\" selected>None</option>";
			}
			$squery=$dbr->query("SELECT stylesetid,stylesetname FROM arc_styleset ORDER BY stylesetid");
			while ($fish=$dbr->getarray($squery)) {
				$numusers=number_format($dbr->result("SELECT COUNT(userid) FROM arc_user WHERE colorset=$fish[stylesetid]"));
				$html .= "<option value=\"$fish[stylesetid]\">$fish[stylesetname] [$numusers]</option>\n";
			}
			$html.='</select>';
			break;

		case 'templates':
			$html="$commonhtml<select name=\"$name\">\n<option value=\"$value\" selected>$value</option>";
			$squery=$dbr->query("SELECT DISTINCT templategroup FROM arc_template ORDER BY templateid");
			while ($fish=$dbr->getarray($squery)) {
				$numusers=number_format($dbr->result("SELECT COUNT(userid) FROM arc_user WHERE layout='$fish[templategroup]'"));
				$html .= "\n<option value=\"$fish[templategroup]\">$fish[templategroup] [$numusers]</option>";
			}
			$html.="\n</select>";
			break;

		case 'shrines':
			$html="$commonhtml<select size=\"1\" name=\"$name\">";
			if ($value!='')
				$html .= "<option value=\"$value\" selected>Previous: $value</option>";
			$html .='<option value="">None</option>';
			$squery=$dbr->query("SELECT shrinekey FROM arc_shrine WHERE suserid=$userid ORDER BY shrinekey");
			while ($a=$dbr->getarray($squery)) {
				$html .= "<option value=\"$a[shrinekey]\">$a[shrinekey]</option>\n";
			}

			$html.='</select>';
			break;

		case 'users':
			if ($value!=0) {
				$modusername=stripslashes($dbr->result("SELECT displayname FROM arc_user WHERE userid=$value"));
			} else {
				$modusername='';
			}
			$html="$commonhtml<select name=\"$name\" size=\"1\">
				  <option value=\"$value\" selected>$modusername</option>";
			$uquery=$dbr->query("SELECT userid,displayname FROM arc_user ORDER BY displayname");
			while ($bread=$dbr->getarray($uquery)) {
				$html .= "<option value=\"$bread[userid]\">" .stripslashes($bread['displayname']). "</option>\n";
			}
			$html.="</select>";
			break;

		case 'threadicons':
			$html="$commonhtml<select name=\"$name\" onchange=\"document.images.icondisplay.src = this[this.selectedIndex].value;\">";
			$iconquery=$dbr->query("SELECT iconpath,icontitle,iconid  FROM arc_threadicons ORDER BY iconid");
			while ($icon=$dbr->getarray($iconquery)) {
				$html .= "\n<option value=\"$icon[iconpath]\">" .stripslashes($icon['icontitle']). '</option>';
			}
			$html.="</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"lib/images/default.gif\" name=\"icondisplay\" border=\"0\" /></td></tr>";
			break;

		case 'months':
			$html="$commonhtml<select name=\"$name\" size=\"1\">";
			$months=array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			if ($value!="") $html.="<option value=\"$value\">$months[$value]</option>";
			$html.="<option value=\"1\">$months[1]</option><option value=\"2\">$months[2]</option>
<option value=\"3\">$months[3]</option><option value=\"4\">$months[4]</option>
<option value=\"5\">$months[5]</option><option value=\"6\">$months[6]</option>
<option value=\"7\">$months[7]</option><option value=\"8\">$months[8]</option>
<option value=\"9\">$months[9]</option><option value=\"10\">$months[10]</option>
<option value=\"11\">$months[11]</option><option value=\"12\">$months[12]</option></select>";
			break;

		case 'days':
			$html="$commonhtml<select name=\"$name\" size=\"1\">";
			if ($value!="") $html.="<option value=\"$value\">$value</option>";
			for ($d=1;$d<=31;$d++) {
				$html.="<option value=\"$d\">$d</option>";
			}
			$html.='</select>';
			break;

		case 'hidden':
			$html="\n<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
			break;

		case 'submit':
			$html="\n  <tr>
    <td bgcolor=\"$tdbgcolor\" colspan=\"2\">
        <input type=\"submit\" name=\"$name\" value=\"$value\">
    </td>
  </tr>\n";
			break;

		case 'reset':
			$html="\n  <tr>
    <td bgcolor=\"$tdbgcolor\" colspan=\"2\">
        <input type=\"reset\" value=\"$value\">
    </td>
  </tr>\n";
			break;

		case 'submitreset':
			$html="\n  <tr>
    <td bgcolor=\"$tdbgcolor\" colspan=\"2\" align=\"center\">
        <input type=\"submit\" value=\"$description\" name=\"$value\">
        <input type=\"reset\" value=\"$name\">
    </td>
  </tr>\n";
			break;

		case 'custom':
			$html="\n$commonhtml
        $description
    </td>
  </tr>\n";
			break;

		case 'yesno':
		if ($value==1) {
			$yessel=' selected="selected"';
			$nosel='';
		} else {
			$yessel='';
			$nosel=' selected="selected"';
		}
			$html="$commonhtml
        <select size=\"1\" name=\"$name\">
        <option$yessel value=\"1\">Yes</option>
        <option$nosel value=\"0\">No</option>
        </select>
    </td>
  </tr>\n";
			break;

		case 'searchtables':
			$html="$commonhtml<select name=\"$name\">
								<option value=\"2\">Pagebits</option>
								<option value=\"1\">Posts</option>";
			$html.="\n</select>";
			break;

		// MISC CASES
		case 'rompaths':
			$html="$commonhtml<select name=\"$name\">";
			if ($value!='') $html .= "<option value=\"$value\" selected>Previous: " .stripslashes($dbr->result("SELECT filepath FROM arc_rompath WHERE rompathid=$value")). '</option>';
			$query=$dbr->query("SELECT rompathid,filepath FROM arc_rompath ORDER BY filepath");
			while ($r=$dbr->getarray($query)) {
				$html .= "\n<option value=\"$r[rompathid]\">" .stripslashes($r['filepath']). '</option>';
			}
			$html.="\n</select>";
			break;

		// RPG CASES
		case 'classes':
			$html="$commonhtml<select name=\"$name\">";

			if ($value==0)
				$previous='None';
			else
				$previous=stripslashes($dbr->result("SELECT name FROM arc_class WHERE classid=$value"));

			if ($value!='')
				$html .= "<option value=\"$value\" selected>Previous: $previous</option>";

			if ($isadmin==1)
				$query=$dbr->query("SELECT classid,name,reqlevel FROM arc_class ORDER BY name");
			else
				$query=$dbr->query("SELECT classid,name,reqlevel FROM arc_class WHERE selectable=1 AND reqlevel<=$level ORDER BY name");

			while ($c=$dbr->getarray($query))
				$html .= "\n<option value=\"$c[classid]\">" .stripslashes($c['name']). '</option>';

			$html.="\n</select>";
			break;

		case 'races':
			$html="$commonhtml<select name=\"$name\">";

			if ($value==0)
				$previous='None';
			else
				$previous=stripslashes($dbr->result("SELECT name FROM arc_race WHERE raceid=$value"));

			if ($value!='') $html .= "<option value=\"$value\" selected>Previous: $previous</option>";
			$query=$dbr->query("SELECT raceid,name FROM arc_race ORDER BY name");
			while ($c=$dbr->getarray($query)) {
				$html .= "\n<option value=\"$c[raceid]\">" .stripslashes($c['name']). '</option>';
			}
			$html.="\n</select>";
			break;

		case 'monsters':
			$html="$commonhtml<select name=\"$name\">
							  <option value=\"0\">None</option>";
			$num=getSetting('monster_level_difference');
			$query=$dbr->query("SELECT monsterid,name,level FROM arc_monster WHERE level<=".($level+$num)." ORDER BY level DESC");
			while ($m=$dbr->getarray($query)) {
				$html .= "\n<option value=\"$m[monsterid]\">" .stripslashes($m['name']). " - $m[level]</option>";
			}
			$html.="\n</select>";
			break;

		case 'backgrounds':
			$html="$commonhtml<select name=\"$name\">\n<option value=\"random\" selected=\"selected\">Random</option>";
			$fromdir=array();
			$dh=opendir('../lib/images/backgrounds/');
			while ($file=readdir($dh)) {
				if (!preg_match("/\.\.?$/", $file)) $fromdir[]=$file;
			}
			closedir($dh);
			foreach ($fromdir as $val) {
				$html.="<option value=\"../lib/images/backgrounds/$val\">$val</option>";
			}
			$html.="\n</select>";
			break;

		case 'faqgroups':
			$html="$commonhtml<select size=\"1\" name=\"$name\">";
			if ($value!='')
				$html .= "<option value=\"$value\" selected>Previous: $value</option>";

			$squery=$dbr->query("SELECT faqgroupid,faqgroupname FROM arc_faqgroup ORDER BY faqgrouporder");
			while ($a=$dbr->getarray($squery)) {
				$html .= "<option value=\"$a[faqgroupid]\">$a[faqgroupid]: " .stripslashes($a['faqgroupname']). "</option>\n";
			}

			$html.='</select>';
			break;

		case 'classabilities':
			$commonhtml='
			<script type="text/javascript">
			function move()
			{
			option=document.thisform.ab_list.options[document.thisform.ab_list.selectedIndex].text;
			txt=document.thisform.'.$name.'.value;
			txt=txt + \'|\' + option;
			document.thisform.'.$name.'.value=txt;
			}
			</script>' . $commonhtml;

			$html="$commonhtml<select name=\"ab_list\">";
			$html.='
					<option>str2attack</option>
					<option>weapon2attack</option>
					<option>end2defense</option>
					<option>armor2defense</option>
					<option>nolosehp</option>
					<option>nolosemp</option>
					<option>halfmp</option>
				   ';

			$html.='</select><input type="button" onclick="move()" value="Add Ability"> <input type="text" name="'.$name.'" value="'.$value.'" size="'.$size.'" maxlength="80">';
			break;

	}
	return $html;
}

function formtop($submiturl, $formextra='')
{
	GLOBAL $tablebordercolor;
	$html="<table bgcolor=\"$tablebordercolor\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" ><tr><td>
<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" width=\"100%\">
<form $formextra action=\"$submiturl\" method=\"post\" enctype=\"multipart/form-data\" name=\"thisform\">\n";
	return $html;
}

function formbottom()
{
	echo "\n</table>\n</td>\n</tr>\n</table>\n</form><br>\n";
}

function getgenericlist($query, $itemname, $printids=0, $textareas=0, $allowmod=0, $submitpage='')
{
	GLOBAL $smallfont,$cs,$tablebordercolor,$tdbgcolor,$action,$dbr;
	GLOBAL $normalfont,$cn,$settingtype,$wordbitgroup,$isadmin,$HTTP_GET_VARS;

	$page_limittype=strtolower($itemname). '_limit';
	$editname=strtolower($itemname);
	$deletename="delete" .strtolower($itemname);
	$idname=strtolower($itemname). 'id';
	$limit=getSetting($page_limittype, 25);

	if (isset($HTTP_GET_VARS['offset'])) {
		$offset=$HTTP_GET_VARS['offset'];
	} else {
		$offset=0;
	}

	$numresults=$dbr->query($query);
	$numrows=$dbr->numrows($numresults);
	$result=$dbr->query("$query LIMIT $offset,$limit");

	if ($submitpage=='')
		$submitpage='admin.php?action=modify';
	if ($isadmin==1 || $allowmod==1)
		echo "\n<form action=\"$submitpage\" method=\"post\">\n";

	echo "
		<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
		<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\">
		 ";
	while ($row=$dbr->getarray($result, MYSQL_BOTH)) {
		if ($isadmin==1 || $allowmod==1) {
			$deleter="\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"$tablebordercolor\">
						<tr><td><table border=\"0\" cellpadding=\"0\" cellspacing=\"1\"><tr><td bgcolor=\"$tdbgcolor\">
  						{$smallfont}[Edit] $cs<input type=\"radio\" name=\"id\" value=\"$row[$idname]\" /><input type=\"hidden\" name=\"edit\" value=\"$editname\" />
  						&nbsp;&nbsp;
  						{$smallfont}[Delete] $cs<input type=\"checkbox\" name=\"{$deletename}[]\" value=\"$row[$idname]\" />
  						</td></tr></table></td></tr></table>\n";
		} else {
			$deleter='';
		}
		if ($printids==1) {
			$ids="<b>$row[0]</b>: ";
		} else {
			$ids='';
		}

		$row[1] = stripslashes($row[1]);

		echo "\n  <tr>
    				<td bgcolor=\"$tdbgcolor\">
				        <table border=\"0\" width=\"100%\"><tr><td align=\"left\">$smallfont$ids$row[1]<br />$cs</td>
				            <td align=\"right\" width=\"170\">$smallfont$deleter$cs</td></tr></table>
			        </td>
				  </tr>\n";
	}
	echo "\n</table></td></tr><table>\n<br />$normalfont";
	echo pagelinks($limit,$numrows,$offset,$itemname, 1);
	if ($isadmin==1 || $allowmod==1)
		echo "\n<center>\n<input type=\"submit\" value=\"Submit\" />\n<input type=\"reset\" value=\"Clear All Checks\" /></center>\n</form>";
}


?>