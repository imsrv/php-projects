<?php

$settings='users_can_post_events,users_can_post_public_events,event_title_maxchars,weekview_short_events,';
$wordbits='postevent_neweventbutton,postevent_title,postevent_day,postevent_month,postevent_year,postevent_private,postevent_submit,';
$wordbits.='postevent_reset,postevent_desc,weekview_short_events,postevent_nopermission,postevent_posted,';
$templates='calendar_event,';
include('./lib/config.php');

if (isset($HTTP_GET_VARS['getdate'])) {
	$mm=substr($HTTP_GET_VARS['getdate'], 0,2);
	$dd=substr($HTTP_GET_VARS['getdate'], 2,2);
	$yy=substr($HTTP_GET_VARS['getdate'], 4,4);
	$timestamp=mktime(0,0,0,$mm,$dd,$yy);
} else {
	$timestamp=time()+($timeoffset*60*60);
}

function zerofill($number)
{
	if ($number<10)
		return '0'.$number;
	else
		return $number;
}

function zeroempty($number)
{
	if ($number<10)
		return str_replace('0', '', $number);
	else
		return $number;
}

function truncate_chars($string, $chars)
{
	if (strlen($string)>$chars)
		return substr($string, 0, $chars). '...';
	else
		return $string;
}

function morethenone($number)
{
	if ($number>1)
		return 's';
	else
		return FALSE;
}

$daysofweek=array('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$today=date("d",$timestamp);
$month=date("m",$timestamp);
$year=date("Y",$timestamp);
$title=date("F Y",$timestamp);
$daysinmonth=date("t",$timestamp);
$firstdayofmonth=date("w",mktime(0,0,0,$month,1,$year));
$firstdayofweek=date("w",mktime(0,0,0,$month,1,$year));
$offset=0-$firstdayofmonth;
$realday=1;
$lastmonth=$month-1;
$nextmonth=$month+1;
$lastmonth=zerofill($lastmonth);
$nextmonth=zerofill($nextmonth);
$last_months_days=date("t",mktime(0,0,0,$month,1,$year));

if ($action=='news') $action='month';

if ($action=='buildevent' && $loggedin==1) {
	setpostvars(array('evtitle', 'evday', 'evmonth', 'evyear', 'description', 'isprivate'));

	if ($evtitle=="" || $evday=="" || $evmonth=="" || $evyear=="") {
		doHeader("$sitename Calendar: Error");
		showmsg('postevent_missingfields');
		footer(1);
	}

	if ($isadmin==1 || getSetting('users_can_post_events')) {

		if (getSetting('users_can_post_public_events')==1 || $isadmin==1) {
			$isprivate=$isprivate;
		} else {
			$isprivate=1;
		}

		$dbr->query("INSERT INTO arc_event SET title='".insert_text($evtitle)."', day='$evday', month='".zeroempty($evmonth)."', year='$evyear', description='".insert_text($description)."',isprivate='$isprivate', userid=$userid");
	}

	doHeader("$sitename Calendar: Building New Event");
	showmsg('postevent_posted');
	footer();

} elseif ($action=='addevent' && $loggedin==1) {

	doHeader("$sitename Calendar: New Event Form");

	if ($isadmin==1 || getSetting('users_can_post_events')) {

		if (isset($HTTP_GET_VARS['month'])) {
			$month=zeroempty($HTTP_GET_VARS['month']);
		} else {
			$month='';
		}
		if (isset($HTTP_GET_VARS['year'])) {
			$year=$HTTP_GET_VARS['year'];
		} else {
			$year='';
		}

		require('./adminfunctions.php');
		$inputs[]=formtop('calendar.php?action=buildevent');
		$inputs[]=inputform('text', getwordbit('postevent_title'), 'evtitle');
		$inputs[]=inputform('days', getwordbit('postevent_day'), 'evday', '', 2, 2);
		$inputs[]=inputform('months', getwordbit('postevent_month'), 'evmonth', $month, 2, 2);
		$inputs[]=inputform('text', getwordbit('postevent_year'), 'evyear', $year, 4, 4);
		$inputs[]=inputform('textarea', getwordbit('postevent_desc'), 'description');
		if (getSetting('users_can_post_public_events')==1 || $isadmin==1) {
			$inputs[]=inputform('yesno', getwordbit('postevent_private'), 'isprivate', 0);
		} else {
			$inputs[]=inputform('display', getwordbit('postevent_private'), 'isprivate', 1);
		}
		$inputs[]=inputform('submitreset', getwordbit('postevent_submit'), getwordbit('postevent_reset'));
		doinputs();
		formbottom();
	} else {
		showmsg('postevent_nopermission');
	}

	footer();

} elseif ($action=='month') { /////////////////////////////////////////// month view

	$lastmonthname=date("F",mktime(0,0,0,$month-1,1,$year));
	$nextmonthname=date("F",mktime(0,0,0,$month+1,1,$year));
	$day=1;

	$bdayquery=$dbr->query("SELECT userid,displayname,bday_day FROM arc_user WHERE bday_month=$month");
	while ($bday=$dbr->getarray($bdayquery)) {
		if (isset($birthdays[$bday['bday_day']])) {
			$birthdays[$bday['bday_day']]++;
		} else {
			$birthdays[$bday['bday_day']]=1;
		}
	}

	$eventsquery=$dbr->query("SELECT eventid,title,day,month,year FROM arc_event WHERE month=$month AND year=$year AND (isprivate=0 OR userid=$userid) ORDER BY eventid");
	while ($events=$dbr->getarray($eventsquery)) {
		if (isset($allevents[$events['day']]['title'])) {
			$allevents[$events['day']]['title'].='<br>-'.format_text(truncate_chars($events['title'], getSetting('event_title_maxchars')));
		} else {
			$allevents[$events['day']]['title']='-'.format_text(truncate_chars($events['title'], getSetting('event_title_maxchars')));
		}
	}
	if (empty($allevents)) $allevents='';

	$output="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">  <tr>
    <td bgcolor=\"$tdheadbgcolor\" align=\"center\" colspan=\"8\">$smallfont
        <a href=\"calendar.php?getdate=$lastmonth$today$year\" title=\"Go back one month\">&laquo; $lastmonthname</a>
      $cs&nbsp;&nbsp;&nbsp;$largefont$title$cl&nbsp;&nbsp;&nbsp;$smallfont
        <a href=\"calendar.php?getdate=$nextmonth$today$year\" title=\"Go forward one month\">$nextmonthname &raquo;</a>
      $cs</td></tr><tr>
    <td width=\"2%\" bgcolor=\"$tdbgcolor\"></td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Sunday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Monday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Tuesday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Wednesday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Thursday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Friday $cs</td>
    <td width=\"14%\" bgcolor=\"$tdbgcolor\" align=\"center\">$smallfont Saturday $cs</td>
  </tr>\n";

	while (($day+$offset)<=$daysinmonth) {
		for ($weekday=1; $weekday<=7; $weekday++) {
			$realday=$day+$offset;
			if ($weekday==1) $output.="<tr><td bgcolor=\"$tdbgcolor\">$smallfont<a href=\"calendar.php?action=week&getdate=$month".zerofill($day)."$year\">[V]</a>$cs";
			if ($realday<=$daysinmonth && $day>=$firstdayofmonth && $realday!=0) {
				if ($realday==$today) {
					$calbgcolor=$alttablebgcolor;
				} else {
					$calbgcolor=$tdbgcolor;
				}
				$output.="<td valign=\"top\" height=\"70\" bgcolor=\"$calbgcolor\">
				            $smallfont<a href=\"calendar.php?action=day&getdate=$month".zerofill($realday)."$year\">$realday</a>
				            <br>";
				if (isset($allevents[$realday]['title'])) $output.=$allevents[$realday]['title'];
				if (isset($birthdays[$realday])) $output.='<br><b>'.$birthdays[$realday].'</b> Birthday'.morethenone($birthdays[$realday]);

				$output.="$cs</td>";
			} else {
				if ($day<10) {
					$otherday=$day-5;
					$otherday=$last_months_days+$otherday;
					$othermonth=$lastmonth;
				} else {
					if (empty($startover)) {
						$startover=1;
						$otherday=1;
					} else {
						$otherday++;
					}
					$othermonth=$nextmonth;
				}
				$output.="<td valign=\"top\" height=\"70\" bgcolor=\"$tdendbgcolor\">
				$smallfont<a href=\"calendar.php?action=day&getdate=$othermonth$otherday$year\">$otherday</a>$cs</td>";

			}
			$day++;

			if ($weekday==7) $output.='</tr>';
		}
	}

	$output.="<tr><td colspan=\"8\" bgcolor=\"$tdbgcolor\" align=\"center\">
      $smallfont
        <a href=\"calendar.php?action=year\">Year View</a> |
        <a href=\"calendar.php?action=week\">Week View</a> |
        <a href=\"calendar.php?action=day\">Day View</a>
      $cs
    </td></tr></table></td></tr></table>";
    if ($loggedin==1 && (getSetting('users_can_post_events')==1 || $isadmin==1)) {
	    $output.="<div align=\"right\">$smallfont".str_replace('<urlextra>', "&month=$month&year=$year", getwordbit('postevent_neweventbutton'))."$cs</div>";
	}

	doHeader("$sitename Calendar: $title");
	echo $output;
	footer();

} elseif($action=='week') { //////////////////////////////////////// week view
	$dayofweek=date("w",$timestamp);
	$firstday=$today-$dayofweek;
	$firstmonth=$month;
	$lastmonth=$month;
	$lastday=$firstday+6;
	$eventdata='';
	$event=getTemplate('calendar_event');
	$shortevents=getSetting('weekview_short_events');
	$last_months_days=date("t",mktime(0,0,0,($month-1),$today,$year));
	$this_months_days=date("t",mktime(0,0,0,$month,$today,$year));

	if ($firstday<1) $firstday=$last_months_days+$firstday-1;
	$day=$firstday;

	$bdayquery=$dbr->query("SELECT userid,displayname,bday_day,bday_month,bday_year FROM arc_user WHERE bday_month=$month OR bday_month=".($month-1)." OR bday_month=".($month+1));
	while ($bday=$dbr->getarray($bdayquery)) {
		if (empty($birthdays[$bday['bday_month']][$bday['bday_day']])) $birthdays[$bday['bday_month']][$bday['bday_day']]='';

		$birthdays[$bday['bday_month']][$bday['bday_day']].="<a href=\"user.php?action=profile&id=$bday[userid]\">".stripslashes($bday['displayname']). '</a> turns '.($year-$bday['bday_year']).'.<br>';
	}

	$eventsquery=$dbr->query("SELECT
							   arc_event.*,
							   arc_user.displayname,
							   arc_user.avatar
							  FROM
							   arc_event,
							   arc_user
							  WHERE
							   arc_user.userid=arc_event.userid AND
							   arc_event.year=$year AND
							   arc_event.day>=$firstday AND
							   arc_event.day<=$lastday AND
							   (arc_event.month=$firstmonth OR
							   arc_event.month=$lastmonth) AND
							   (arc_event.isprivate=0 OR
							   arc_event.userid=$userid)
							  ORDER BY eventid");

	// " stupid, stupid textpad

	while ($events=$dbr->getarray($eventsquery)) {
		$row=$event;
		$row=str_replace('<displayname>', format_text($events['displayname']), $row);
		$row=str_replace('<userid>', $events['userid'], $row);
		$row=str_replace('<event_title>', format_text($events['title']), $row);
		if ($shortevents==0) {
			$row=str_replace('<avatar>', $events['avatar'], $row);
			$row=str_replace('<event_description>', format_text($events['description']), $row);
		} else {
			$row=str_replace('<avatar>', 'lib/images/default.gif', $row);
			$row=str_replace('<event_description>', '', $row);
		}

		if (isset($allevents[$events['day']]['title'])) {
			$allevents[$events['day']].=$row;
		} else {
			$allevents[$events['day']]=$row;
		}
	}

	if ($today-7<1) {
		$prevmonth=zerofill($month-1);
		$prevday=$last_months_days;
	} else {
		$prevmonth=$month;
		$prevday=zerofill($today-7);
	}

	if ($today+7>$this_months_days) {
		$nextmonth=zerofill($month+1);
		$nextday='07';
	} else {
		$nextmonth=$month;
		$nextday=zerofill($today+7);
	}

	$output="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">  <tr>
    <td bgcolor=\"$tdheadbgcolor\" align=\"center\" colspan=\"8\">$smallfont
        <a href=\"calendar.php?action=week&getdate=$prevmonth$prevday$year\" title=\"Go back one week\">&laquo; Previous Week</a>
      $cs&nbsp;&nbsp;&nbsp;$largefont$title$cl&nbsp;&nbsp;&nbsp;$smallfont
        <a href=\"calendar.php?action=week&getdate=$nextmonth$nextday$year\" title=\"Go forward one week\">Next Week &raquo;</a>
      $cs</td></tr>\n";
	for ($weekday=1; $weekday<=7; $weekday++) {
		$thismonth=zeroempty($month);
		if ($day>$last_months_days && $lastday<7) {
			$day=1;
			$thismonth++;
		} elseif ($day>$this_months_days && $lastday>$this_months_days) {
			$day=1;
		}
		$realday=$day;

		$output.="<tr><td bgcolor=\"$tdbgcolor\" valign=\"top\" height=\"50\">
		  $largefont
		    <a href=\"calendar.php?action=day&getdate=$month".zerofill($realday)."$year\">$realday</a>
		  $cl
		  $smallfont".date("l", mktime(0,0,0,$month,$realday,$year))."
		  $cs";

		if (isset($allevents[$realday])) $output.=$allevents[$realday];
		if (isset($birthdays[$thismonth][$realday])) $output.="<br>$normalfont".$birthdays[$thismonth][$realday].$cn;

		$output.="</td></tr>";
		$day++;

	}

	$output.="<tr><td bgcolor=\"$tdbgcolor\" align=\"center\">
      $smallfont
        <a href=\"calendar.php?action=year\">Year View</a> |
        <a href=\"calendar.php?action=month\">Month View</a> |
        <a href=\"calendar.php?action=day\">Day View</a>
      $cs
    </td></tr></table></td></tr></table>";

	doHeader("$sitename Calendar: Week View");
	echo $output;
	footer();

} elseif($action=='day') { ///////////////////////////////////////// day view

	$eventdata='';
	$birthdays='';
	$bdays_so_far=0;
	$event=getTemplate('calendar_event');

	$bdayquery=$dbr->query("SELECT userid,displayname,bday_day,bday_year FROM arc_user WHERE bday_month=$month AND bday_day=$today");
	$totalbdays=mysql_num_rows($bdayquery);
	while ($bday=$dbr->getarray($bdayquery)) {
		$bdays_so_far++;

		$birthdays.="<a href=\"user.php?action=profile&id=$bday[userid]\">".stripslashes($bday['displayname']). '</a> turns '.($year-$bday['bday_year']);

		if ($bdays_so_far<$totalbdays) {
			$birthdays.=', ';
		} else {
			$birthdays.='.';
		}
	}

	$eventsquery=$dbr->query("SELECT arc_event.*,
								arc_user.displayname,
								arc_user.avatar
							  FROM arc_event,
							    arc_user
							  WHERE arc_event.month=".zeroempty($month)." AND
							    arc_event.year=$year AND
							    arc_event.day=".zeroempty($today)." AND
							    arc_user.userid=arc_event.userid AND
							    (arc_event.isprivate=0 OR arc_event.userid=$userid)
							  ORDER BY eventid ASC");

	while ($events=$dbr->getarray($eventsquery)) {
		$row=$event;
		$row=str_replace('<displayname>', format_text($events['displayname']), $row);
		$row=str_replace('<avatar>', $events['avatar'], $row);
		$row=str_replace('<userid>', $events['userid'], $row);
		$row=str_replace('<event_title>', format_text($events['title']), $row);
		$row=str_replace('<event_description>', format_text($events['description']), $row);
		$eventdata.=$row;
	}

	$output="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">  <tr>
    <td bgcolor=\"$tdheadbgcolor\" align=\"center\" colspan=\"8\">
      $normalfont$title$cn</td></tr>
      <tr><td height=\"300\" bgcolor=\"$tdbgcolor\" valign=\"top\">$largefont".zeroempty($today)."$cl
      <br>$eventdata
      <br>$normalfont$birthdays$cn
      </td></tr>
      <tr><td bgcolor=\"$tdbgcolor\" align=\"center\">
      $smallfont
        <a href=\"calendar.php?action=year\">Year View</a> |
        <a href=\"calendar.php?action=month\">Month View</a> |
        <a href=\"calendar.php?action=week\">Week View</a>
      $cs
    </td></tr></table></td></tr></table>";


	doHeader("$sitename Calendar: Day View");
	echo $output;
	footer();

} elseif($action=='year') { ///////////////////////////////////////////// year view

	$title=$year;
	$lastyear=$year-1;
	$nextyear=$year+1;
	$curmonth=$month;

	$output="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">  <tr>
    <td bgcolor=\"$tdheadbgcolor\" align=\"center\" colspan=\"3\">$smallfont
        <a href=\"calendar.php?action=year&getdate=$month$today$lastyear\" title=\"Go back one year\">&laquo; $lastyear</a>
      $cs&nbsp;&nbsp;&nbsp;$largefont$title$cl&nbsp;&nbsp;&nbsp;$smallfont
        <a href=\"calendar.php?action=year&getdate=$month$today$nextyear\" title=\"Go forward one year\">$nextyear &raquo;</a>
      $cs</td></tr>\n";

    for ($m=1; $m<=12; $m++) {

    	$day=1;
    	$timestamp=mktime(0,0,0,$m,1,$year);
    	$monthname=date("F", $timestamp);
		$daysinmonth=date("t",$timestamp);
		$firstdayofmonth=date("w",$timestamp);
		$firstdayofweek=date("w",$timestamp);
		$last_months_days=date("t",$timestamp);
		$offset=0-$firstdayofmonth;

		$month="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\" bgcolor=\"$tablebordercolor\"><tr><td>
		         <table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\"><tr><td align=\"center\" colspan=\"7\" bgcolor=\"$tdheadbgcolor\">
		         $smallfont<a href=\"calendar.php?getdate=".zerofill($m)."01$year\">$monthname</a>$cs</td></tr>";

		while (($day+$offset)<=$daysinmonth) {
			for ($weekday=1; $weekday<=7; $weekday++) {
				$realday=$day+$offset;

				if ($weekday==1) $month.="<tr>";
				if ($realday<=$daysinmonth && $day>=$firstdayofmonth && $realday!=0) {
					if ($realday==$today && $m==$curmonth) {
						$calbgcolor=$alttablebgcolor;
					} else {
						$calbgcolor=$tdbgcolor;
					}
					$month.="<td valign=\"top\" bgcolor=\"$calbgcolor\">
					            $smallfont<a href=\"calendar.php?action=day&getdate=".zerofill($m).zerofill($realday)."$year\">$realday</a>";
					$month.="$cs</td>";

				} else {
					$month.="<td valign=\"top\" bgcolor=\"$tdendbgcolor\">&nbsp;</td>";
				}
				$day++;

				if ($weekday==7) $month.='</tr>';
			}
		}

		$month.="</table></td></tr></table>";


		if ($m==1 || $m==4 || $m==7 || $m==10) {
			$output.="<tr><td bgcolor=\"$tdbgcolor\">$month</td>";
		} elseif ($m==2 || $m==5 || $m==8 || $m==11) {
			$output.="<td bgcolor=\"$tdbgcolor\" valign=\"middle\">$month</td>";
		} else {
			$output.="<td bgcolor=\"$tdbgcolor\" valign=\"middle\">$month</td></tr>";
		}
    }

	$output.="<tr><td colspan=\"3\" bgcolor=\"$tdbgcolor\" align=\"center\">
      $smallfont
        <a href=\"calendar.php\">Month View</a> |
        <a href=\"calendar.php?action=week\">Week View</a> |
        <a href=\"calendar.php?action=day\">Day View</a>
      $cs
    </td></tr></table></td></tr></table>";
    if ($loggedin==1 && (getSetting('users_can_post_events')==1 || $isadmin==1)) {
	    $output.="<div align=\"right\">$smallfont".str_replace('<urlextra>', "&year=$year", getwordbit('postevent_neweventbutton'))."$cs</div>";
	}

	doHeader("$sitename Calendar: Year View");
	echo $output;
	footer();

}

?>