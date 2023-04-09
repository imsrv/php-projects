<?php
/* Nullified by WDYL-WTN */

function getHeaders($mbox, $min, $max)
{	
	$overview = imap_fetch_overview($mbox, "$min:$max", 0);
 	
	if(is_array($overview)) 
	{
        reset($overview);
	        
        $count = 1;
	        
        while(list($key, $val) = each($overview))
        {
			/* parse time */
			$time =	strtotime($val->date);

	        if ($TIME_ONLY_OPTION)
			{
				$now  = date($DEFAULT_TIME_FORMAT_SHORT, time());
				$then = date($DEFAULT_TIME_FORMAT_SHORT, $time);

				if ($now == $then)
					$time = date($DEFAULT_TIME_FORMAT_TIMEONLY, $time);
				else
					$time = date($DEFAULT_TIME_FORMAT, $time);
			}
			else
				$time = date($DEFAULT_TIME_FORMAT, $time);

			$header[$count][0] = $time;
			$header[$count][1] = $val->from;
			$header[$count][2] = $val->subject;
			$header[$count][4] = $val->seen;
			$header[$count][5] = $val->size;
			$header[$count++][6] = $val->uid;
		}
	}

	return $header;
}

?>