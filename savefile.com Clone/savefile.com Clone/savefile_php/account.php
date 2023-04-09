<?
	include("include/common.php");

	if(!$loggedin){
		ob_start();
		header("Location: login.php");
	}

	$query = "SELECT * FROM users25 WHERE uid='$myuid'";
	$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
	if ( ($result) && (mysql_num_rows($result) > 0) ){
		$row = mysql_fetch_object($result);
	}
	include("include/header.php");
	include("include/accmenu.php");

	$this->c=mysql_query("select * from users25 where uid='$myuid'");
	$this->d=mysql_fetch_object($this->c);
	if(is_object($this->d)) {
		$cusername = $this->d->username;
		$cpassword = $this->d->password;
		$cfirst_name = $this->d->first_name;
		$clast_name = $this->d->last_name;
		$cstreet = $this->d->street;
		$ccity = $this->d->city;
		$czip = $this->d->zip;
		$cstate = $this->d->state;
		$ccountry = $this->d->country;
		$cemail = $this->d->email;
		$ctelephone = $this->d->telephone;
		$clast_paid = $this->d->last_paid;
		$csignup_date = $this->d->signup_date; 
	}

	$a = $HTTP_POST_VARS[a];
	if (!$a) { $a = $HTTP_GET_VARS[a]; }
	$in = $HTTP_POST_VARS[in];
	if (!$in) { $in = $HTTP_GET_VARS[in]; }

	$citem_name=stripslashes($citem_name);
	$citem_price=stripslashes($citem_price);
	$citem_goal=stripslashes($citem_goal);
	$citem_currency=stripslashes($citem_currency);
	$cemail_subject=stripslashes($cemail_subject);
	$cemail_message=stripslashes($cemail_message);
	$csuccess=stripslashes($csuccess);
	$ccancelled=stripslashes($ccancelled);
	$cbusiness=stripslashes($cbusiness);

	switch($a){
		case "vp":
			include("include/g_vp.inc");
			break;
		case "cp":
			include("include/g_cp.inc");
			break;
		case "cp2":
			include("include/g_cp2.inc");
			break;
		case "gdc":
			include("include/g_gdc.inc");
			break;
		case "dm":
			include("include/g_dm.inc");
			break;
		case "sl":
			include("include/g_sl.inc");
			break;
		default:
			echo "<h3>Welcome $cusername</h3>";
			echo $table2."<tr align=center><td colspan=2>Please choose an option from the menu above.<p></td></tr></table>";
			break;
	}
#	echo "</table>";
	include("include/footer.php");
?>