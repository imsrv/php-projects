<?php
	class Calendar
	{
		var $day;
		var $month;
		var $year;
		var $link;

		function Calendar($link, $day = "", $month = "", $year = "")
		{
			if($day == 0 && $month == 0 && $year == 0)
			{
				$this->day = date("d");
				$this->month = date("n");
				$this->year = date("Y");
			}
			else
			{
				$this->day = $day;
				$this->month = $month;
				$this->year = $year;
			}
			$this->link = $link;
		}

		function isLeapYear($year)
		{
			if($year % 4 != 0)
				return false;	//{use 28 for days in February}
            else if($year % 400 == 0)
				return true;	//{use 29 for days in February}
            else if($year % 100 == 0)
				return false;   //{use 28 for days in February}
            else
                return true;	//{use 29 for days in February}
		}

		function buildCalendar($height, $width)
		{
			$pmonth = $this->month == 1 ? 12 : $this->month - 1;
			$nmonth = $this->month == 12 ? 1 : $this->month + 1;
			$pyear = $pmonth == 12 ? $this->year - 1 : $this->year;
			$nyear = $nmonth == 1 ? $this->year + 1 : $this->year;
			if($this->day == 31)
			{
				switch($nmonth)
				{
					case 4:
					case 6:
					case 9:
					case 11: $nday = 30; break;
					case 2: $nday = $this->isLeapYear($nyear) ? 29 : 28; break;
					default: $nday = 31; break;
				}
				switch($pmonth)
				{
					case 4:
					case 6:
					case 9:
					case 11: $pday = 30; break;
					case 2: $pday = $this->isLeapYear($pyear) ? 29 : 28; break;
					default: $pday = 31; break;
				}
			}
			else if($this->day == 30)
			{
				switch($nmonth)
				{
					case 2: $nday = $this->isLeapYear($nyear) ? 29 : 28; break;
					default: $nday = 30; break;
				}
				switch($pmonth)
				{
					case 2: $pday = $this->isLeapYear($pyear) ? 29 : 28; break;
					default: $pday = 30; break;
				}
			}
			else if($this->day == 29)
			{
				switch($nmonth)
				{
					case 2: $nday = $this->isLeapYear($nyear) ? 29 : 28; break;
					default: $nday = 29; break;
				}
				switch($pmonth)
				{
					case 2: $pday = $this->isLeapYear($pyear) ? 29 : 28; break;
					default: $pday = 29; break;
				}
			}
			else
			{
				$pday = $this->day;
				$nday = $this->day;
			}

			switch($this->month)
			{
				case 4:
				case 6:
				case 9:
				case 11: $totalDaysInThisMonth = 30; break;
				case 2: $totalDaysInThisMonth = $this->isLeapYear($pyear) ? 29 : 28; break;
				default: $totalDaysInThisMonth = 31; break;
			}

			$currenttime = mktime(0,0,0,$this->month, $this->day, $this->year);
			$output = "<table border='0' cellpadding='2' cellspacing='0' width='$width' height='$height'>";
			$output .= "<tr height='20' valign='center'><td align='center'><a href='".$this->link."?d=$pday&m=$pmonth&y=$pyear' class='navi'><img src='./_pic/left_arrow.gif' border='0'></a></td><td align='center' valign='middle' class='title'>".date("M Y",$currenttime)."</td><td align='center' class='navi'><a href='".$this->link."?d=$nday&m=$nmonth&y=$nyear'><img src='./_pic/right_arrow.gif' border='0'></a></td></tr><tr><td colspan='3'  bgcolor='#eeeeee'><table border='0' cellpadding='2' cellspacing='2' width='100%' bgcolor='#eeeeee' height='100%'>";
			
			$output .= "<tr bgcolor='#0080ff'><td align='center' valign='middle' width='14%' class='day'>S</td><td align='center' valign='middle' width='14%' class='day'>M</td><td align='center' valign='middle' width='14%' class='day'>T</td><td align='center' valign='middle' width='14%' class='day'>W</td><td align='center' valign='middle' width='14%' class='day'>T</td><td align='center' valign='middle' width='14%' class='day'>F</td><td align='center' valign='middle' width='14%' class='day'>S</td></tr>";
			
			$output .= "<tr>";
			if(date("w",mktime(0,0,0,$this->month, 1, $this->year)))
			{
				for($i=0;$i<date("w",mktime(0,0,0,$this->month, 1, $this->year));$i++)
					$output .= "<td>&nbsp;</td>";
			}
			for($i=1;$i<=$totalDaysInThisMonth;$i++)
			{
				if($this->day == $i)
					$output .= "<td align='center' bgcolor='orange'>";
				else
					$output .= "<td align='center' bgcolor='white'>";
				
				$output .= "<a href='".$this->link."?d=$i&m=".$this->month."&y=".$this->year."#$i'>$i</a></td>";
				
				
				if((date("w",mktime(0,0,0,$this->month, $i, $this->year)) % 6 == 0) && (date("w",mktime(0,0,0,$this->month, $i, $this->year)) != 0) && $i != $totalDaysInThisMonth)
				{
					$output .= "</tr><tr>";
				}
			}

			if(date("w",mktime(0,0,0,$this->month, $totalDaysInThisMonth, $this->year)) != 0)
			{
				for($i=0;$i<6 - date("w",mktime(0,0,0,$this->month, $totalDaysInThisMonth, $this->year));$i++)
					$output .= "<td>&nbsp;</td>";
			}
			$output .= "</tr></table></td></tr><tr><td colspan='3' align='center' class='day'>Today : <a href='".$this->link."?d=".date("d")."&m=".date("n")."&y=".date("Y")."'>".date("d M Y")."</a></td></tr></table>";

			print $output;
		}
	}
?>
