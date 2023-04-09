<?
	session_start();
	include("config.php");
	$att_path = "./uploads";
	$paypal_item = $sitename." Service Monthly Subscription";
	$paypal_item_number = $sitename;
	$mainipn = $siteurl."/ipn.php";
	$paypal_ipn = $siteurl."/site_ipn.php";
	$paypal_cancel_return = $siteurl."/cancel.php";
	$paypal_return = $siteurl."/thanks.php";
	$this->min_pass_length=8;
	$this->max_pass_length=12;
	$this->chars='abcdefghijklmnopqrstuvwxyz0123456789';
	$logfile = "logfile.txt";
	$postmode = 1;
	$invalidcode = "<table bgcolor=#ffffff cellpadding=4 width=170><tr><td align=center><font size=2><b>Invalid Button Code!</b><p>Run Your Own PayPal Donation Campaigns at <a href=$siteurl/join.php>$sitename</a></font></table>";
	$table1 = "<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR='#C0C0C0' STYLE='border-collapse: collapse'>";
	$table2 = "<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR='#C0C0C0' STYLE='border-collapse: collapse'>";
	$table3 = "<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR='#C0C0C0' STYLE='border-collapse: collapse'>";

	@mysql_connect($dbServer, $dbUser, $dbPass) or die("Couldn't connect to database server: " . mysql_error());
	@mysql_select_db($dbName) or die("Couldn't connect to database: " . mysql_error());
	
	function errform($msg, $var = ''){ 
		global $posterr, $_POST; 
		$posterr = 1; 
		echo "<div style='color: #FF0000;'>$msg</div>";
		if ($var) $_POST[$var] = '';
	}
	
	function addreport($user,$site,$status){
		mysql_query("INSERT INTO report SET user='$user',site='$site',status='$status',date='".time()."'");
	}

	function quickcheck($host,$port){
		$running = @fsockopen($host, $port, $errno, $errstr, 30);  
		if (!$running){
			return 0;
		}else  {  
			fclose($running);  
			return 1;
		} 
	}

	function fullstatus($host){
		$services = array(  
			"http"=>"80",  
			"ssh"=>"22",  
			"ftp"=>"21",  
			"smtp"=>"25",  
			"pop3"=>"110",  
			"mysql"=>"3306");  

		$date = date("l, M d, Y - h:i:s A");  
?>  
		<p><font face="Arial" size="2"><b>System Status: <?= $host ?></b></font><br>Time: <?= $date ?></p> 
		<font face="Arial" size="2"> 
		<p><table> 
		<tr bgcolor="#5590CC"><td>Status</td><td>Service</td><td>Host</td></tr> 
<?  
		foreach ($services as $name=>$port){  
			$running = @fsockopen($host, $port, $errno, $errstr, 30);  
			if (!$running){
				$status_color = "red";  
				$status_sign = "X";
			}else  {  
				fclose($running);  
				$status_color = "green";  
				$status_sign = "&nbsp;";
			}  
			echo "<tr><td align=center><div align=\"center\" style=\"font-size: 20pt; border: 2px solid $status_color; color:$status_color;\" width=\"15\" height=\"15\">$status_sign</div></td><td>$name</td><td>$host</td></tr>";  
		}  
?>  
		</table></p> 
<?
	}
	function writecombo($array_name, $name, $selected = "", $start = 0, $add_text = "", $add_text2 = "") {
		$length = count ($array_name);
		if (($array_name == "") || ($length == 0)){
			echo "<select name=\"$name\"></select>\n";
		}else{
			echo "<select name=\"$name\" $add_text $add_text2>\n";
			while (list($key, $val) = @each($array_name)) {
				if( !is_array($val) ){
					$select_name = $val;
					$i = $key;
					echo "  <option value=\"$i\"";
					if ($i == $selected){
						echo " selected";
					}
					echo ">$select_name</option>\n";
				}
			}
			echo "</select>\n";
		}
	}

	function myround($amt,$dec="3"){
		ob_start();
		if($dec == 2){
			printf("%6.2f",$amt);
		}else{
			printf("%6.3f",$amt);
		}
		$amount = ob_get_contents();
		ob_end_clean(); 
		$amount = str_replace(" ","",$amount);
		return $amount;
	}

	class fptime{
		function fptime(){
			return 1;
		}

		function mytime($stamp="",$format="m/d/Y"){
			return date( $format,($stamp ? $stamp : time()) );
		}

		function stamp($mm,$dd,$yy,$hh=0,$min=0,$sec=0){
			return mktime($hh,$min,$sec,$mm,$dd,$yy);
		}

		function subhours($interval,$mm,$dd,$yy,$hh,$m,$s){
			return $this->stamp( $mm,$dd,$yy,($hh-$interval),$m,$s );
		}

		function addhours($interval,$mm,$dd,$yy,$hh,$m,$s){
			return $this->stamp( $mm,$dd,$yy,($hh+$interval),$m,$s );
		}

		function subdays($interval,$mm,$dd,$yy){
			return $this->stamp($mm,($dd-$interval),$yy);
		}

		function adddays($interval,$mm,$dd,$yy,$hh=0,$min=0,$sec=0){
			return $this->stamp($mm,($dd+$interval),$yy,$hh,$min,$sec);
		}

		function submonths($interval,$mm,$dd,$yy){
			return $this->stamp( ($mm-$interval),$dd,$yy );
		}

		function addmonths($interval,$mm,$dd,$yy){
			return $this->stamp( ($mm+$interval),$dd,$yy );
		}

		function subyears($interval,$mm,$dd,$yy){
			return $this->stamp( $mm,$dd,($yy-$interval) );
		}

		function addyears($interval,$mm,$dd,$yy){
			return $this->stamp( $mm,$dd,($yy+$interval) );
		}

		function DateDiff ($interval, $date1,$date2) {
			// get the number of seconds between the two dates
			$timedifference =  $date2 - $date1;
			switch ($interval) {
				case "w":
					$retval = $timedifference/604800;
					$retval = floor($retval);
					break;
				case "d":
					$retval = $timedifference/86400;
					$retval = floor($retval);
					break;
				case "h":
					$retval = $timedifference/3600;
					$retval = floor($retval);
					break;
				case "n":
					$retval = $timedifference/60;
					$retval = floor($retval);
					break;
				case "s":
					$retval  = floor($timedifference);
					break;
			}
			return $retval;
		}

		function dateNow($format="%Y%m%d"){
			return(strftime($format,time()));
		}

		function dateToday(){
			$ndate = time();
			return( $ndate );
		}

		function daysInMonth($month="",$year=""){
			if(empty($year)) {
				$year = $this->dateNow("%Y");
			}
			if(empty($month)) {
				$month = $this->dateNow("%m");
			}
			if($month == 2) {
				if($this->isLeapYear($year)) {
					return 29;
				} else {
					return 28;
				}
			} elseif($month == 4 or $month == 6 or $month == 9 or $month == 11) {
				return 30;
			} else {
				return 31;
			}
		}

		function isLeapYear($year=""){
			if(empty($year)) {
				$year = $this->dateNow("%Y");
			}
			if(strlen($year) != 4) {
				return false;
			}
			if(preg_match("/\D/",$year)) {
				return false;
			}
			return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0);
		}
	}
	$month_values= array(
		"0"=>"--",
		"1"=>"Jan",
		"2"=>"Feb",
		"3"=>"Mar",
		"4"=>"Apr",
		"5"=>"May",
		"6"=>"Jun",
		"7"=>"Jul",
		"8"=>"Aug",
		"9"=>"Sep",
		"10"=>"Oct",
		"11"=>"Nov",
		"12"=>"Dec",
	);
	$day_values= array(
		"0"=>"--",
		"1"=>"1",
		"2"=>"2",
		"3"=>"3",
		"4"=>"4",
		"5"=>"5",
		"6"=>"6",
		"7"=>"7",
		"8"=>"8",
		"9"=>"9",
		"10"=>"10",
		"11"=>"11",
		"12"=>"12",
		"13"=>"13",
		"14"=>"14",
		"15"=>"15",
		"16"=>"16",
		"17"=>"17",
		"18"=>"18",
		"19"=>"19",
		"20"=>"20",
		"21"=>"21",
		"22"=>"22",
		"23"=>"23",
		"24"=>"24",
		"25"=>"25",
		"26"=>"26",
		"27"=>"27",
		"28"=>"28",
		"29"=>"29",
		"30"=>"30",
		"31"=>"31",
	);
?>