<?php
require_once(getenv('DOCUMENT_ROOT')."/class/class.calendar.php");

$nd=strtotime(eregi_replace("[^0123456789-]","",$_GET['date']));

$day=date("d",$nd);
$month=date("m",$nd);
$year=date("Y",$nd);

class ext_calendar extends class_calendar {
	var $step_date;
	var $eda=array();

    function getCalendarLink($month, $year) {
		$out="/news/".$year."-".$month."-1/";
		return $out;
    }

	function getDateLink($day, $month, $year) {
		$today = getdate(); 
		$cd=mktime($today['month'], $today['mday'], $today['year']);
		$pd=mktime(0,0,0,$month, $day, $year);

	if (in_array($day,$this->eda)) {$link ="/news/".$year."-".$month."-".$day.'/';}
	else {$link=FALSE;}

        return $link;
    }
}

//--------------------------------
//  Creating calendar
//--------------------------------
$_months = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
$_days = array ("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");

$d = getdate(time());

if ( $month == '') { $month = $d["mon"];}
if ( $year == '') { $year = $d["year"]; }

$cal = new ext_calendar;
$cal->setMonthNames($_months);
$cal->setDayNames($_days);
$cal->step_date=intval($day);

$SQL="select from_unixtime(_time,\"%d\") as m
	from ai_news 
		where 
			_enabled='y' and _time < unix_timestamp() 
			and from_unixtime(".$nd.",\"%Y%m\") = from_unixtime(_time,\"%Y%m\")
	group by _time";
$rs=mysql_query($SQL);
$a=array();
while($row=mysql_fetch_array($rs)) { $a[]=intval($row['m']);}
$cal->eda=&$a;

print $cal->getMonthView($month, $year);
?>