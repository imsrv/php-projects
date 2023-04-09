<?

	class DB {
		var $currentID;

		function open($hostname,$login,$password,$DBname) {
			mysql_pconnect($hostname,$login,$password);
			mysql_select_db($DBname);
		}

		function addHitToUsers($login) {
			$query = "SELECT id,visitors FROM users WHERE login='$login'";
			$result = mysql_query($query);
			if (list($userID,$visitors) = mysql_fetch_row($result)) {
				$query = "UPDATE users SET visitors=".++$visitors." WHERE id='$userID'";
				mysql_query($query);
			}
			return $userID;
		}

		function addHitToWeek($userID) {
			$dayofweek = date("D");
			$query = "SELECT $dayofweek FROM week WHERE id=$userID";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($visitors) = mysql_fetch_row($result);
			}
			else {
				$query = "INSERT week SET id=$userID, Mon=0, Tue=0, Wed=0, Thu=0, Fri=0, Sat=0, Sun=0";
				mysql_query($query);
			}
			$query = "UPDATE week SET $dayofweek=".++$visitors." WHERE id=$userID";
			mysql_query($query);
		}

		function addHitToMonth($userID) {
			$month = "m".date("m");
			$query = "SELECT $month FROM month WHERE id=$userID";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($visitors) = mysql_fetch_row($result);
			}
			else {
				$query = "INSERT month SET id=$userID, m01=0, m02=0, m03=0, m04=0, m05=0, m06=0, m07=0, m08=0, m09=0, m10=0, m11=0, m12=0";
				mysql_query($query);
			}
			$query = "UPDATE month SET $month=".++$visitors." WHERE id=$userID";
			mysql_query($query);
		}

		function addHitToTable($userID,$name,$value) {
			$query = "SELECT count  FROM $name WHERE (id=$userID AND $name='$value')";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($count) = mysql_fetch_row($result);
				$query = "UPDATE $name SET count=".++$count."  WHERE (id=$userID AND $name='$value')";
			}
			else {
				$query = "INSERT $name SET id=$userID, $name='$value', count=1";
			}
			mysql_query($query);
		}

		function addHitToVisitor($userID) {
			$today = date("m:d:Y");
			$query ="SELECT count FROM visitor WHERE (id=$userID AND date='$today')";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($count) = mysql_fetch_row($result);
				$query = "UPDATE visitor SET count=".++$count."  WHERE (id=$userID AND date='$today')";
			}
			else {
				$query = "INSERT visitor SET id=$userID, date='$today', count=1";
			}
			mysql_query($query);
		}

		function addHitToIP($IP,$userID) {
			$today = date("m:d:Y");
			$query = "SELECT date from ip LIMIT 1";
			$result = mysql_query($query);
			list($date) = mysql_fetch_row($result);
			if ($date != $today) {
				mysql_query("DELETE FROM ip");
			}
			$query = "SELECT ip,date FROM ip WHERE (ip='$IP' AND date='$today' AND id='$userID')";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				return 1;
			} else {
				$query = "INSERT ip SET ip='$IP', date='$today',id = $userID";
				mysql_query($query);
				return 0;
			}
		}

		function onHit($login,$IP) {
			$userID = $this -> addHitToUsers($login);
			$this -> currentID = $userID;
			$visited = $this -> addHitToIP($IP,$userID);
			if (!($visited)) {
				$this -> addHitToWeek($userID);
				$this -> addHitToMonth($userID);
				$this -> addHitToVisitor($userID);
			}
			return $visited;
		}

		function onLogin($login='admin') {
			$query = "SELECT id,acctype,access_level FROM users WHERE login='$login'";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($userID,$acctype,$accesslevel) = mysql_fetch_row($result);
				$this -> currentID = $userID;
				return array($userID,$acctype,$accesslevel);
			}
			else {
				return 0;
			}
		}

/*
		function onQueryVisitor($userID) {
			$query = "SELECT count,date FROM visitor WHERE id=$userID";
			$result = mysql_query($query);
			list($visitors) = mysql_fetch_row($result);
			return $visitors;
		}
*/

		function onTotalVisitorsQuery($userID) {
			$query = "SELECT SUM(count),COUNT(date) FROM visitor WHERE id='$userID'";
			$result = mysql_query($query);
			return mysql_fetch_row($result);
		}

		function onHitsQuery($userID) {
			$query = "SELECT visitors FROM users WHERE id='$userID'";
			$result = mysql_query($query);
			list($visitors) = mysql_fetch_row($result);
			return $visitors;
		}

		function onQueryVisitor($userID,$month,$year) {
			$fromdate = "$month:00";
			$todate = "$month:32";
			if ($month == '13') {
				$fromdate = "00:00";
				$todate = "13:32";
			}
			$query = "SELECT count,date FROM visitor WHERE id=$userID";
			$result = mysql_query($query);
			$data = array();
			while(list($count,$date) = mysql_fetch_row($result)) {
				if (($date > $fromdate) && ($date < $todate) && (substr($date,6,4) == $year)) {
					$$date = $count;
					array_push($data,$date);
				}
			}
			return compact($data);
		}

		function onQueryWeekly($userID) {
			$query = "SELECT * FROM week WHERE id=$userID";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($userID,$Mon,$Tue,$Wed,$Thu,$Fri,$Sat,$Sun) = mysql_fetch_row($result);
				return array("Mon" => $Mon, "Tue" => $Tue, "Wed" => $Wed,
							 "Thu" => $Thu, "Fri" => $Fri,
							 "Sat" => $Sat, "Sun" => $Sun);
			}
		}

		function onQueryMonthly($userID) {
			$query = "SELECT * FROM month WHERE id=$userID";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				list($userID,$Jan,$Feb,$Mar,$Apr,$May,$Jun,$Jul,$Aug,$Sep,$Oct,$Nov,$Dec) = mysql_fetch_row($result);
				return array("Jan" => $Jan, "Feb" => $Feb, "Mar" => $Mar,
							 "Apr" => $Apr, "May" => $May, "Jun" => $Jun,
							 "Jul" => $Jul, "Aug" => $Aug, "Sep" => $Sep,
							 "Oct" => $Oct, "Nov" => $Nov, "Dec" => $Dec);
			}
		}

		function onQuery($userID,$name) {
			$query = "SELECT $name,count FROM $name WHERE id=$userID";
			$result = mysql_query($query);
			if (mysql_num_rows($result)) {
				while (list($value,$count) = mysql_fetch_row($result)) {
					$data[$value] = $count;
				}
			}
			return $data;
		}

		function onQueryReferrer($userID) {
			return $this -> onQuery($userID,"referrer");
		}

		function onQueryEngine($userID) {
			return $this -> onQuery($userID,"engine");
		}

		function onQueryQuery($userID) {
			return $this -> onQuery($userID,"query");
		}

		function onQueryJava($userID) {
			return $this -> onQuery($userID,"java");
		}

		function onQueryJavaScript($userID) {
			return $this -> onQuery($userID,"javascript");
		}

		function onQueryResolution($userID) {
			return $this -> onQuery($userID,"resolution");
		}

		function onQueryColor($userID) {
			return $this -> onQuery($userID,"color");
		}

		function onQueryOS($userID) {
			return $this -> onQuery($userID,"os");
		}

		function onQueryBrowser($userID) {
			return $this -> onQuery($userID,"browser");
		}

		function onQueryCountry($userID) {
			return $this -> onQuery($userID,"country");
		}

		function onQueryLanguage($userID) {
			return $this -> onQuery($userID,"language");
		}

	}

?>