<?php
	class CalendarDetail
	{
		var $day;
		var $month;
		var $year;

		function CalendarDetail($day = "", $month = "", $year = "" )
		{
			if($month == "")
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
		}

		function buildCalendarDetail($width, $isPublic)
		{
			$month_name = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
			
			switch($this->month)
			{
				case 4:
				case 6:
				case 9:
				case 11: $totalDaysInThisMonth = 30; break;
				case 2: $totalDaysInThisMonth = $this->isLeapYear($this->year) ? 29 : 28; break;
				default: $totalDaysInThisMonth = 31; break;
			}

			$result = mysql_query("SELECT DAYOFMONTH(event_date) as event_day, DATE_FORMAT(event_date, '%r') as event_time, subject, event_id FROM calendar_event WHERE MONTH(event_date) = ".$this->month." AND (YEAR(event_date) = ".$this->year." OR event_recur = 1) AND queue_flag = 0 ORDER BY event_date");

			$output .= "<table width='$width' cellpadding='2' cellspacing='2' bgcolor='#eeeeee'><tr><td class='title' align='center' height='10'>Event Details For ".$month_name[$this->month]." ".$this->year."</td></tr>";
			
			$j = 1;
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
				$loop = true;
				while($loop)
				{
					while($row["event_day"] > $j)
					{
						$bgcolor = ($j == $this->day) ? "orange" : "white" ;
						$output .= "<tr valign='top'><td bgcolor='$bgcolor'><table width='100%' border='0'><tr valign='top'><td width='98%'><a name='$j'></a><b>$j</b></td>";

						if($isPublic)
						{
							$output .= "<td class='add'>[<a href='#' onClick='javascript: window.open(\"addEvent.php?d=".$j."&m=".$this->month."&y=".$this->year."\",\"\",\"scrollbars=yes, resizable=yes, width=380, height=380\");return false;'>Add</a>]</td>";
						}
						$output .= "</tr></table></td></tr>";
						$j++;
					}
					$bgcolor = ($j == $this->day) ? "orange" : "white" ;
					$output .= "<tr valign='top'><td bgcolor='$bgcolor'><table width='100%' border='0'><tr valign='top'><td width='8%'><a name='$j'></a><b>$j</b></td><td width='90%'>";
					while($row["event_day"] == $j && $loop)
					{
						$output .= $row["event_time"]." - <a href='#' onClick='javascript: window.open(\"viewEvent.php?e=".$row["event_id"]."\",\"\",\"scrollbars=yes, resizable=yes, width=380, height=380\");return false;'>".htmlentities($row["subject"])."</a><br>";

						if($row = mysql_fetch_array($result))
							$loop = true;
						else
							$loop = false;
					}
					if($isPublic)
					{
						$output .= "</td><td class='add'>[<a href='#' onClick='javascript: window.open(\"addEvent.php?d=".$j."&m=".$this->month."&y=".$this->year."\",\"\",\"scrollbars=yes, resizable=yes, width=380, height=380\");return false;'>Add</a>]</td>";
					}
					$output .= "</tr></table></td></tr>";
					$j++;
				}
			}
			
			for($i=$j;$i<=$totalDaysInThisMonth;$i++)
			{
				$bgcolor = ($i == $this->day) ? "orange" : "white" ;
				$output .= "<tr valign='top'><td bgcolor='$bgcolor'><table width='100%' border='0'><tr><td width='98%'><a name='$i'></a><b>$i</b></td>";

				if($isPublic)
				{
					$output .= "<td class='add'>[<a href='#' onClick='javascript: window.open(\"addEvent.php?d=".$i."&m=".$this->month."&y=".$this->year."\",\"\",\"scrollbars=yes, resizable=yes, width=380, height=380\");return false;'>Add</a>]</td>";
				}

				$output .= "</tr></table></td></tr>";
					
			}
			
			$output .= "</table>";
			print $output;
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
	}
?>