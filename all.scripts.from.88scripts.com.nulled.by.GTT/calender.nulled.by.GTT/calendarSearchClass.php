<?php
	class CalendarSearch
	{
		var $search;
		function CalendarSearch($search)
		{
			$this->search = $search;
		}

		function buildCalendarSearch($width, $isPublic)
		{
			$result = mysql_query("SELECT DATE_FORMAT(event_date, '%D %b %Y %r') as event_time, subject, event_id, DAYOFMONTH(event_date) as `day`, MONTH(event_date) as `month`, YEAR(event_date) as `year`  FROM calendar_event WHERE subject LIKE '%".$this->search."%' OR detail LIKE '%".$this->search."%' AND queue_flag = 0 ORDER BY event_date");

			$output .= "<table width='$width' cellpadding='2' cellspacing='2' bgcolor='#eeeeee'><tr><td class='title' align='center' height='10'>Search Results For <i>".$this->search."</i></td></tr>";
			
			
			if(mysql_num_rows($result) == 0)
			{
				$output .= "<tr><td bgcolor='white' align='center'>-- No event found -- </td></tr>";
			}
			else
			{
				while($row = mysql_fetch_array($result))
				{
					$output .= "<tr valign='top'><td bgcolor='white'><table width='100%' border='0'><tr valign='top'><td width='100%'>";
					
					$output .= $row["event_time"]." - <a href='#' onClick='javascript: window.open(\"viewEvent.php?e=".$row["event_id"]."\",\"\",\"scrollbars=yes, resizable=yes, width=380, height=380\");return false;'>".htmlentities($row["subject"])."</a></td>";

					
					$output .= "</tr></table></td></tr>";
				}
			}
			
			
			
			$output .= "</table>";
			print $output;
		}
	}
?>