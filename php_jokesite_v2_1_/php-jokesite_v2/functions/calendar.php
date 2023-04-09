<?
/*************************************************************************
//PUT THIS ON THE FILE 

include (DIR_FUNCTIONS."calendar.php");
if ($HTTP_GET_VARS['y'])
	$tyear = $HTTP_GET_VARS['y'];
else
	$tyear = date('Y');

if ($HTTP_GET_VARS['m'])
	$tmonth = $HTTP_GET_VARS['m'];
else
	$tmonth = date('m');

if ($HTTP_GET_VARS['d'])
	$tdate = $HTTP_GET_VARS['d'];
else
	$tdate = date('d');

if ($to == "breakdown" )
	$tdate = "01";

$curr_date = date('Y-m-d', mktime(0,0,0,$tmonth, $tdate, $tyear));

echo generate_calendar($tyear, $tmonth, $tdate, $this_file="clients.php");

*************************************************************************/

function generate_calendar($year, $month, $tday, $this_file, $vars)
{
	$day_heading_length = 2;
	$first_of_month = mktime (0,0,0, $month, 1, $year);
    
	static $day_headings = array(	"Sunday",
									"Monday",
									"Tuesday",
									"Wednesday",
									"Thursday",
									"Friday",
									"Saturday");
    
	$month_words = array(	"01"=>"January",
							"02"=>"February",
							"03"=>"March",
							"04"=>"April",
							"05"=>"May",
							"06"=>"June",
							"07"=>"July",
							"08"=>"August",
							"09"=>"September",
							"10"=>"October",
							"11"=>"November",
							"12"=>"December",);
    
	$maxdays   = date('t', $first_of_month); #number of days in the month
    
	$date_info = getdate($first_of_month);   #get info about the first day of the month

	$calendar  = "<form method=\"post\" action=\"$this_file\"><table bgcolor=\"#000000\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\"><tr><td><table bgcolor=\"#C0C0C0\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">\n";
	$calendar .= "<tr><th colspan=\"7\" class=\"cal\"><select class=\"call\" name=\"month\" onChange=\"document.location = '$this_file?$vars&y=".$year."&m='+this.options[this.selectedIndex].value+'&d=".$tday."';\">";
    
	while (list($month_no, $month_name) = each($month_words)) 
	{
		$calendar .= "<option value=\"".$month_no."\"";
		
		if ($month_no == $month) 
            $calendar .= " selected";

		$calendar .= ">".$month_name."</option>";
	}
    
	$calendar .= "</select><select name=\"year\" onChange=\"document.location = '$this_file?$vars&y='+this.options[this.selectedIndex].value+'&m=".$month."&d=".$tday."';\">";

	for ($i=($year-10);$i<($year+10);$i++ ) 
	{
        $calendar .= "<option value=\"".$i."\"";
    
		if ($i == $year) 
            $calendar .= " selected";
        
		$calendar .= ">".$i."</option>";
    }
    
	$calendar .= "</select></th></tr>\n";    

	$date_today = getdate(); 
	$date_month = $date_today['mon']; 
	$date_mday = $date_today['mday']; 
	$date_year = $date_today['year']; 
//	echo "$month $mday, $year";

    $calendar .= "<tr><th colspan=\"7\" class=\"cal\"><a href=\"$this_file?$vars&y=$date_year&m=$date_month&d=$date_mday\"><font size=\"1\">Today</font></a>&nbsp;&nbsp;&nbsp; <a href=\"$this_file?$vars&to=breakdown&y=".$year."&m=".$month."&d=".$tday."\" style=\"text-decoration:none;color:blue\">" . $date_info["month"] . ", " . $date_info["year"] . "</a></th></tr>\n";

    
	if($day_heading_length > 0 and $day_heading_length <= 4)
	{
        $calendar .= "<tr bgcolor=\"#666699\">";
        foreach($day_headings as $day_heading)
		{
			$calendar .= "<th class=\"smalltext\"><font color=\"#FFFFFF\">" . 
                ($day_heading_length != 4 ? substr($day_heading, 0, $day_heading_length) : $day_heading) .
            "</font></th>";
        }
        $calendar .= "</tr>\n";
    }
    $calendar .= "<tr>";

    $weekday = $date_info["wday"]; #weekday (zero based) of the first day of the month
    
	$day = 1; #starting day of the month
    #take care of the first "empty" days of the month
    
	if($weekday > 0)
		$calendar .= "<td colspan=\"$weekday\">&nbsp;</td>";

    #print the days of the month
    while ($day <= $maxdays)
	{
        #if a linking function is provided
        if ($day == $tday) 
            $bgcolor = "#FFCC99";
        else 
            $bgcolor = "#F5F5F5";
        
		$calendar .= "<td bgcolor=\"".$bgcolor."\" align=\"center\"><a href=\"$this_file?$vars&y=".$year."&m=".$month."&d=".$day."\" style=\"text-decoration:none;color:blue\">$day</a></td>";
        
        $day++;
        $weekday++;

        if($day > $maxdays and $weekday != 7)	#pad the end of the html table
			$calendar .= "<td colspan=\"" . (7 - $weekday) . "\">&nbsp;</td>";
		elseif($weekday == 7)				 #start a new week
		{
			$calendar .= "</tr>\n<tr>";
            $weekday = 0;
        }
    }

    return $calendar . "</tr>\n</table></td></tr></table></form>\n";
}
?>