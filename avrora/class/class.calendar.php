<?php

class class_calendar {

    function Calendar(){
    }

    function getDayNames() {
        return $this->dayNames;
    }

    function setDayNames($names) {
        $this->dayNames = $names;
    }

    function getMonthNames() {
        return $this->monthNames;
    }

    function setMonthNames($names) {
        $this->monthNames = $names;
    }

      function getStartDay() {
        return $this->startDay;
    }

    function setStartDay($day) {
        $this->startDay = $day;
    }

    function getStartMonth() {
        return $this->startMonth;
    }

    function setStartMonth($month) {
        $this->startMonth = $month;
    }

    function getCalendarLink($month, $year) {
        return "";
    }

    function getDateLink($day, $month, $year) {
        return "";
    }

    function getCurrentMonthView() {
        $d = getdate(time());
        return $this->getMonthView($d["mon"], $d["year"]);
    }

    function getCurrentYearView() {
        $d = getdate(time());
        return $this->getYearView($d["year"]);
    }

    function getMonthView($month, $year) {
        return $this->getMonthHTML($month, $year);
    }

    function getDaysInMonth($month, $year) {
        if ($month < 1 || $month > 12) {
            return 0;
        }

        $d = $this->daysInMonth[$month - 1];

        if ($month == 2)
        {
            // Check for leap year
            // Forget the 4000 rule, I doubt I'll be around then...
        
            if ($year%4 == 0)
            {
                if ($year%100 == 0)
                {
                    if ($year%400 == 0)
                    {
                        $d = 29;
                    }
                }
                else
                {
                    $d = 29;
                }
            }
        }
    
        return $d;
    }

    function getMonthHTML($m, $y, $showYear = 1)
    {
        $s = "";
        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];        
        
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	$date = getdate(mktime(12, 0, 0, $month, 1, $year));
    	
    	$first = $date["wday"];
    	$monthName = $this->monthNames[$month - 1];
    	
    	$prev = $this->adjustDate($month - 1, $year);
    	$next = $this->adjustDate($month + 1, $year);

		$today = getdate(); 
		$cd=mktime($today['month'], 0, $today['year']);
		$pd=mktime(0,0,0,$month+1, 0, $year);
		$res=$cd-$pd;

		if ($res > 0) {$nextMonth = $this->getCalendarLink($next[0], $next[1]);}
		else {@$nextMonth;}
		$prevMonth = $this->getCalendarLink($prev[0], $prev[1]);

    	$header = $monthName . (($showYear > 0) ? " " . $year : "");

    	$s .= "<table class='calTblMain'>\n";
    	$s .= "<tr>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'>" . (($prevMonth == "") ? "&nbsp;" : "<a href='".$prevMonth."' class='calTitle'>&lt;&lt;</a>")  . "</td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle' colspan='5'><font class='calTitle'>".$header."</font></td>\n"; 
    	$s .= "<td align='center' valign='top' class='calTblTitle'>" . ((@$nextMonth == "") ? "&nbsp;" : "<a href='".$nextMonth."' class='calTitle'>&gt;&gt;</a>")  . "</td>\n";
    	$s .= "</tr>\n";
    	
    	$s .= "<tr>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+1)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+2)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+3)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+4)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+5)%7] . "</font></td>\n";
    	$s .= "<td align='center' valign='top' class='calTblTitle'><font class='calTitle'>" . $this->dayNames[($this->startDay+6)%7] . "</font></td>\n";
    	$s .= "</tr>\n";
    	
    	// We need to work out what date to start at so that the first appears in the correct column
    	$d = $this->startDay + 1 - $first;
    	while ($d > 1) {
    	    $d -= 7;
    	}

        // Make sure we know when today is, so that we can use a different CSS style
        $today = getdate(time());
    	while ($d <= $daysInMonth)
    	{
    	    $s .= "<tr>\n";       
    	    for ($i = 0; $i < 7; $i++) {
				if ($d == $this->step_date  && $d != 0) {
					$class="calToday";
					$tbl_class='calTblToday';
					$checked=TRUE;
				}elseif ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"] && !isset($checked)) {
					$class="calToday";
					$tbl_class='calTblToday';
				}else {
					$class="calTomorrow";
					$tbl_class='calTblDayNull';
				}

				$_s='';
    	        if ($d > 0 && $d <= $daysInMonth) {
    	            $link = $this->getDateLink($d, $month, $year);
					if ($class != 'calToday' && $link) {
						$class = "calYesterday";
						$tbl_class='calTblYesterday';
					}
					if ($link == "") {
						$_s .= $d;
						$tbl_class='calTblDay';
					}
					else {
						$_s .= "<a href=\"".$link."\" class=\"".$class."\">".$d."</a>";
					}
    	        }
    	        else
    	        {
    	            $_s .= "&nbsp;";
    	        }

      	        $s .= "<td align=\"right\" valign=\"top\" class='".$tbl_class."'><font class='".$class."'>";
				$s .= $_s;
				$s .= "</font></td>\n";       
        	    $d++;
    	    }
    	    $s .= "</tr>\n";    
    	}
    	
    	$s .= "</table>\n";
    	
    	return $s;  	
    }

    function adjustDate($month, $year)
    {
        $a = array();  
        $a[0] = $month;
        $a[1] = $year;
        
        while ($a[0] > 12)
        {
            $a[0] -= 12;
            $a[1]++;
        }
        
        while ($a[0] <= 0)
        {
            $a[0] += 12;
            $a[1]--;
        }
        
        return $a;
    }

    var $startDay = 0;
    var $startMonth = 1;
    var $dayNames = array("S", "M", "T", "W", "T", "F", "S");
    var $monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    var $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

}

?>

