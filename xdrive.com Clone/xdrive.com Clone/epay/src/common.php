<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
	//
	// DO NOT CHANGE ANYTHING HERE.
	//
	error_reporting( E_ALL ^ E_WARNING ^ E_NOTICE );
	set_magic_quotes_runtime(0);
	if (ini_get('register_globals')){
		while ($_ = each($GLOBALS)){
			if (substr($_[0], 0, 1) != '_' && $_[0] != 'GLOBALS'){
				unset($GLOBALS[$_[0]]);
			}
		}
		reset($GLOBALS);
	}
	if (ini_get('magic_quotes_gpc')){
		while ($_ = each($_GET)) $_GET[$_[0]] = stripslashes($_[1]);{
			reset($_GET);
		}
		while ($_ = each($_POST)) $_POST[$_[0]] = stripslashes($_[1]);{
			reset($_POST);
		}
	}
	ignore_user_abort(true);
	if (!ini_get("zlib.output_compression")){
		ob_start("ob_gzhandler");
	}
	// Include config data
	require('connect.php');
	require('config.php');
	require('config2.php');
	require('src/select_values.php');

	$defaultmail = "From: $replymail\nReturn-Path: $replymail\n";
	$defaultmail2 = "From: $sitename admin <$replymail>\nReturn-Path: $replymail\n";
	$session_mins = 120;

	// Functions
	function errform($msg, $var = ''){ 
		global $posterr, $_POST; 
		$posterr = 1; 
		echo "<div class=error>$msg</div>";
		if ($var) $_POST[$var] = '';
	}

	function prdate($date) { 
		return date("d M Y \\@H:i", strtotime($date)); 
	}

	function prsumm($summ, $design = 0){ 
		global $currency;
		if ($design){
			return "<span class=".($summ > 0 ? "plus>+$currency" : "minus>".($summ ? "-" : "").$currency).number_format(($summ > 0 ? $summ : -$summ), 2)."</span>";
		}else{
			return $currency.number_format($summ, 2, '.', '');
		}
	}

	function pruser($user, $uname = '', $sp = -1){ 
		global $id,$showstate,$showcountry;
		global $bronze,$silver,$gold,$platinum;
		if (!$uname || $sp == -1){
			list($uname,$sp) = mysql_fetch_row(mysql_query("SELECT username,special FROM epay_users WHERE id=$user"));
		}
		list($state,$country) = mysql_fetch_row(mysql_query("SELECT state,country FROM epay_users WHERE username='$uname'"));
		if ($user <= 100){
			return $uname;
		}
		$medal = getuserstatus($user);
		if ( ($country) || ($state) ){
			if (!$showstate){
				$state = "";
			}		
			if (!$showcountry){
				$country = "";
			}		
			$sname = statename($state,$country);
			$country = strtolower($country);
			if (file_exists("img/flags/{$state}.gif") ){
				$flag = "<img src=epay/img/flags/{$state}.gif height=15 width=22 border=0 alt='$sname'> ";
			}else if (file_exists("img/flags/{$country}.gif") ){
				$flag = "<img src=epay/img/flags/{$country}.gif height=15 width=22 border=0 alt='$sname'> ";
			}
		}
		$tr = mysql_query("SELECT * FROM epay_transactions WHERE paidto=$user AND (paidby>10 AND paidby<100) AND pending=0 LIMIT 1");
		if (mysql_num_rows())
			$confirmed = " <img src=epay/img/el_payment.gif alt='Payment confirmed'>";
		$tr = mysql_query("SELECT * FROM epay_transactions WHERE paidto=$user AND (paidby>10 AND paidby<100) AND pending=0 LIMIT 1");
		if (mysql_num_rows())
			$confirmed_cc = " <img src=epay/img/el_cc.gif alt='Credit card confirmed'>";
		return $flag."<a href=index.php?a=uview&user=$user&brand=$brand&$id>$uname</a>".$medal.$confirmed.$confirmed_cc;
	}

	function pruserObj($user){ 
		$user = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE id=$user"));
		return $user;
	}
	function pruserObj2($user){ 
		$user = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE (username='$user' OR email='$user')"));
		return $user;
	}

	function statename($state = '',$country = ''){
		global $state_values,$country_values;
		if ($state){
			return $state_values[$country][$state];
		}else{
			return $country_values[$country];
		}
	}

	function prproject($pid, $name = ''){
		global $id,$brand;
		if (!$name)
			list($name) = mysql_fetch_row(mysql_query("SELECT name FROM epay_projects WHERE id=$pid"));
		return "<a href=index.php?a=project&pid=$pid&brand=$brand&$id>".htmlspecialchars($name)."</a>";
	}

	function prheaders($headers, $sep = ', '){
		global $enum_headers;
		if (!$enum_headers){
			$qr1 = mysql_query("SELECT * FROM epay_area_list");
			while ($a = mysql_fetch_row($qr1)){
				if ($a[1]){
					$enum_headers[$a[0]] = $a[1];
				}
			}
		}
		$i = 0;
		while ($headers){
			if ($headers % 2 && $enum_headers[$i]){
				if ($r){
					$r .= $sep;
				}
				$r .= $enum_headers[$i];
			}
			$headers >>= 1;
			$i++;
		}
		return $r;
	}

	function getheader($id){
		$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE id='$id'");
		$a = mysql_fetch_object($qr1);
		if ($a->title){
			$title = $a->title;
		}
		return $title;
	}

	function prareas($areas, $sep = ', ',$tarea=''){
		global $enum_areas;
		if (!$enum_areas){
			if ($tarea){
				$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE parent='".$tarea."'");
			}else{
				$qr1 = mysql_query("SELECT * FROM epay_area_list");
			}
			while ($a = mysql_fetch_row($qr1)){
				if ($a[1]){
					$enum_areas[$a[0]] = $a[1];
				}
			}
		}
		$i = 0;
		while ($areas){
			if ($areas % 2 && $enum_areas[$i]){
				if ($r){
					$r .= $sep;
				}
				$r .= $enum_areas[$i];
			}
			$areas >>= 1;
			$i++;
		}
		return $r;
	}
	function prareas2($tarea){
		$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE parent='".$tarea."'");
		while ($a = mysql_fetch_row($qr1)){
			if ($a[1]){
				$enum_areas[$a[0]] = $a[1];
			}
		}
		return $enum_areas;
	}
	function prareas3($tarea = 0){
		$qr1 = mysql_query("SELECT id,title FROM epay_area_list WHERE parent='".$tarea."'");
		while ($a = mysql_fetch_row($qr1)){
			if ($a[1]){
				$enum_areas[$a[0]] = $a[1];
			}
		}
		return $enum_areas;
	}
	function aprareas($areas, $sep = ', ',$tarea=''){
		global $aenum_areas;
		if (!$aenum_areas){
			if ($tarea){
				$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE parent='".$tarea."' ORDER By parent ASC");
			}else{
				$qr1 = mysql_query("SELECT * FROM epay_area_list ORDER BY parent ASC");
			}
			while ($a = mysql_fetch_object($qr1)){
				if ($a->title){
					if ( $a->parent ){
						$hdr = getheader($a->parent);
					}
					if ($hdr){
						$txt = $hdr." - ".$a->title;
					}else{
						$txt = $a->title;
					}
					$aenum_areas[$a->id] = $txt;
				}
			}
		}
		$i = 0;
		while ($areas){
			if ($areas % 2 && $aenum_areas[$i]){
				if ($r){
					$r .= $sep;
				}
				$r .= $aenum_areas[$i];
			}
			$areas >>= 1;
			$i++;
		}
		return $r;
	}

	function prexpire($interval){
		$hours = (int)($interval / 3600);
		if ($hours < 0)
			return 'expired'; 

		$days = (int)($hours / 24);
		$hours -= $days * 24;
		if (!$days && !$hours)
			return "less than an hour"; 

		$strleft = "in "; 
		if ($days)
			$strleft .= "$days day".($days != 1 ? 's' : ''); 

		$strleft .= ($days ? ' ' : '')."$hours hour".($hours != 1 ? 's' : '');
		return $strleft;
	}

	function balance($user, $exclude = 0){
		if ($exclude) $optional = " AND pending=0";
		$r1 = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM epay_transactions WHERE paidto=$user".$optional));
		$r2 = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM epay_transactions WHERE paidby=$user".$optional));
		return $r1[0] - $r2[0];
	}

	function userinfo($user){
		global $id;
		$r = mysql_fetch_row(mysql_query("SELECT AVG(mark),COUNT(mark) FROM epay_reviews WHERE user=$user"));

		if ($r[1]){
			$alt = myround($r[0], 1)."/10";
			$out[0] = $out[1] = "<a href=index.php?a=reviews&user=$user&brand=$brand&$id class=small title=$alt>";
			for ($i = 0, $j = (int)myround($r[0]); $i < $j; $i++){
				$out[0] .= "<img src=epay/img/star.gif border=0 width=8>";
			}
			for (; $i < 10; $i++){
				$out[0] .= "<img src=epay/img/star2.gif border=0 width=8>";
			}
			$out[0] .= "</a>\n";
			$out[1] .= "($r[1]&nbsp;review".($r[1] == 1 ? '' : 's').")</a>";
			$out[2] = $r[1];
		}else{
			$out = array('<small>(No&nbsp;Feedback&nbsp;Yet)</small>', '', '0');
		}
		return $out;
	}

	function gettemplate($tid, $url = '', $info = '', $addinfo = ''){
		global $id, $data, $pid, $sitename, $siteurl,$charge_signup,$signup_fee,$currency;
		list($text) = mysql_fetch_row(mysql_query("SELECT title FROM epay_templates WHERE id='$tid'"));
		if( strstr($info,"@@") ){
			$info = explode("@@",$info);
			$email = $info[0];
			$amount = $info[1];
		}
		// links
		$text = str_replace("[account]", "<a href={$data->type}.php?a=account&brand=$brand&$id>account</a>", $text);
		$text = str_replace("[project]", "<a href=index.php?a=project&pid=$pid&brand=$brand&$id>project</a>", $text);
		$text = str_replace("[board]", "<a href=index.php?a=board&pid=$pid&brand=$brand&$id>message&nbsp;board</a>", $text);
		// text
		$text = str_replace("[username]", $data->username, $text);
		$text = str_replace("[sitename]", $sitename, $text);
		$text = str_replace("[siteurl]", $siteurl, $text);
		$text = str_replace("[sitename]", $sitename, $text);
		$text = str_replace("[siteurl]", $siteurl, $text);
		// special
		$text = str_replace("[url]", $url, $text);
		$text = str_replace("[email]", $email, $text);
		$text = str_replace("[amount]", $amount, $text);
		$text = str_replace("[info]", $info, $text);
		$text = str_replace("[addinfo]", $addinfo, $text);
		if($charge_signup){
			$signup_fee = floatval2($signup_fee);
			$text = str_replace("[total]", "$currency $signup_fee", $text);
		}
		return $text;
	}

	function sendbilling($type, $email,$username,$email2,$username2,$reason,$fees='0',$tax='0',$total='0'){
		global $id, $data, $pid, $sitename, $siteurl,$defaultmail,$emailtop,$emailbottom;
		if($type == "i"){
			list($text) = mysql_fetch_row(mysql_query("SELECT title FROM epay_templates WHERE id='invoice'"));
			$title = "invoice";
		}else{
			list($text) = mysql_fetch_row(mysql_query("SELECT title FROM epay_templates WHERE id='receipt'"));
			$title = "receipt";
		}
		// text
		if(!$total)$total=$fees;
		$text = str_replace("[username]", $username, $text);
		$text = str_replace("[username2]", $username2, $text);
		$text = str_replace("[memo]", $reason, $text);
		$text = str_replace("[sitename]", $sitename, $text);
		$text = str_replace("[siteurl]", $siteurl, $text);
		$text = str_replace("[sitename]", $sitename, $text);
		$text = str_replace("[siteurl]", $siteurl, $text);
		$text = str_replace("[url]", $url, $text);
		$text = str_replace("[info]", $info, $text);
		$text = str_replace("[addinfo]", $addinfo, $text);

		$text = str_replace("[fees]", "$currency $fees", $text);
		$text = str_replace("[tax]", "$currency $tax", $text);
		$text = str_replace("[total]", "$currency $total", $text);

		mail($email, $title, $emailtop.$text.$emailbottom, $defaultmail);
	}

	function calctax($amount){
		global $sales_tax;
		if($sales_tax){
			$tax = floatval2( ($amount * $sales_tax) / 100);
			$total = floatval2($tax + $amount);
		}else{
			$total = $amount;
		}
		return $total;
	}

	function calcrate($amount){
		global $ex_rate;
		if($ex_rate){
			$tax = floatval2( ($amount * $ex_rate) / 100);
			$total = floatval2($tax + $amount);
		}else{
			$total = $amount;
		}
		return $total;
	}


	function transact($paidby,$paidto,$fee,$comment,$relatedproject='',$fees='',$pending='',$addinfo='',$orderno='',$taxon=1){
echo "<!--[ working.... ]-->\n";
		global $sales_tax,$send_i,$send_r,$referral_payout,$affil_on;
		$total = $fee;
		if(!$amount)$amount=$fee;
		if(!$total)$total=$fee;
		$afrusr = pruserObj($paidby);
		if($paidby == 99){
			// Affiliate stuff
			$totals = explode("|",$fee);
			$total = $totals[0];
			$amount = $totals[1];
			$afrusr = pruserObj($relatedproject);
	  		$rusr = pruserObj($relatedproject);
	  		$rname = $rusr->username;
	  		$referredby = $rusr->referredby;
	  		$frusr = pruserObj($relatedproject);
		}else if($afrusr->type != 'sys'){
	  		$rusr = pruserObj($paidto);
	  		$rname = $rusr->username;
	  		$referredby = $rusr->referredby;
	  		$frusr = pruserObj($paidby);
	  	}
		$sql = "INSERT INTO epay_transactions SET
										paidby='$paidby',
										paidto='$paidto',
										trdate=NOW(),
										amount='$amount',
										comment='$comment',
										fees='$fees',
										pending='$pending',
										addinfo='$addinfo',
										orderno='$orderno',
										relatedproject='$relatedproject'";
		mysql_query($sql) or die( mysql_error()."<br>$sql" );
		if ($referredby && $affil_on){
	  		$refusr = pruserObj($referredby);
	  		if($refusr->payout)$referral_payout = $refusr->payout;
			$ref = myround($total * $referral_payout / 100, 2);
			if ($ref){
				$comment = "Referral for $rname";
				transact(99,$referredby,$total."|".$ref,$comment,$paidto);
			}
		}
		if($afrusr->type != 'sys'){
			if($send_i){
	  			sendbilling("i", $rusr->email,$rusr->username,$frusr->email,$frusr->username,$comment,$fee,$tax,$total);
	  			if($send_r){
	  				sendbilling("r", $rusr->email,$rusr->username,$frusr->email,$frusr->username,$comment,$fee,$tax,$total);
	  			}
	  		}
	  	}
echo "<!--[ done... ]-->\n";
	}

	function prpage($tid, $url = '', $info = '', $addinfo = ''){
		$text = gettemplate($tid, $url, $info, $addinfo);
		echo "<br><br>",nl2br($text),"<br><br>";
	}

	// Function to write HTML select
	function writecombo($array_name, $name, $selected = "", $start = 0, $add_text = "", $add_text2 = "") {
		$length = count ($array_name);
		if (($array_name == "") || ($length == 0)){
			echo "<select name=\"$name\"></select>\n";
		}else{
			echo "<select name=\"$name\" $add_text $add_text2>\n";
			while (list($key, $val) = @each($array_name)) {
				$select_name = $val;
				$i = $key;
				echo "  <option value=\"$i\"";
				if ($i == $selected){
					echo " selected";
				}
				echo ">$select_name</option>\n";
			}
			echo "</select>\n";
		}
	}

	function writemulticombo($array_name, $name, $selected = array("0"), $size = 3) {
	    $length = count ($array_name);
	    if (($array_name == "") || ($length == 0))
		  echo "<select name=\"$name\"></select>\n";
	    else
	    {
		  echo "<select multiple size=$size name=\"$name\">\n";
		  for ($i = 1; $i < $length; $i++)
		  {
			$select_name = $array_name[$i];
			echo "  <option value=\"$i\"";
			if (in_array($i, $selected))
			   echo " selected";
			echo ">$select_name</option>\n";
		  }
		  echo "</select>\n";
	    }
	}

	function writecheckbox($array_name, $name, $selected = "", $tablesize = 665) {
		$length = count ($array_name);
		if (empty($selected)){
			$selected = split(":", "0:0");
		}
		if (($array_name == "") || ($length == 0)){
			exit;
		}else{
			$j = 0;
			echo "<table width=$tablesize><TR>";
			for ($i = 1; $i < $length; $i++){
				$j++;
				if ($j > 5) {
					echo "</TR><TR>";
					$j = 1;
				}
				$check_name = $array_name[$i];
				echo "<TD><input type=checkbox value=$i name=$name id=$i";
				if (in_array($i, $selected)){
					echo " checked";
				}
				echo ">&nbsp;<label for=$i><font size=1>$check_name</font></label></TD>";
			}
			echo "</table>\n";
		}
	}

	function writenamecombo($array_name, $name, $selected = "", $start = 0, $add_text = "", $add_text2 = "") {
		$length = count ($array_name);
		if (($array_name == "") || ($length == 0)){
			echo "<select name=\"$name\"></select>\n";
		}else{
			echo "<select $add_text $add_text2 name=\"$name\">\n";
			for ($i = $start; $i < $length; $i++){
				$select_name = $array_name[$i];
				echo "  <option value=\"$select_name\"";
				if ($select_name == $selected){
					echo " selected";
				}
				echo ">$select_name</option>\n";
			}
			echo "</select>\n";
		}
	}

	function buddy_smile($message) {
		$message = str_replace(":)", "<IMG SRC=\"epay/img/smilies/icon_smile.gif\">", $message);
		$message = str_replace(":-)", "<IMG SRC=\"epay/img/smilies/icon_smile.gif\">", $message);
		$message = str_replace(":(", "<IMG SRC=\"epay/img/smilies/icon_frown.gif\">", $message);
		$message = str_replace(":-(", "<IMG SRC=\"epay/img/smilies/icon_frown.gif\">", $message);
		$message = str_replace(":-D", "<IMG SRC=\"epay/img/smilies/icon_biggrin.gif\">", $message);
		$message = str_replace(":D", "<IMG SRC=\"epay/img/smilies/icon_biggrin.gif\">", $message);
		$message = str_replace(";)", "<IMG SRC=\"epay/img/smilies/icon_wink.gif\">", $message);
		$message = str_replace(";-)", "<IMG SRC=\"epay/img/smilies/icon_wink.gif\">", $message);
		$message = str_replace(":o", "<IMG SRC=\"epay/img/smilies/icon_eek.gif\">", $message);
		$message = str_replace(":O", "<IMG SRC=\"epay/img/smilies/icon_eek.gif\">", $message);
		$message = str_replace(":-o", "<IMG SRC=\"epay/img/smilies/icon_eek.gif\">", $message);
		$message = str_replace(":-O", "<IMG SRC=\"epay/img/smilies/icon_eek.gif\">", $message);
		$message = str_replace("8)", "<IMG SRC=\"epay/img/smilies/icon_cool.gif\">", $message);
		$message = str_replace("8-)", "<IMG SRC=\"epay/img/smilies/icon_cool.gif\">", $message);
		$message = str_replace(":?", "<IMG SRC=\"epay/img/smilies/icon_confused.gif\">", $message);
		$message = str_replace(":-?", "<IMG SRC=\"epay/img/smilies/icon_confused.gif\">", $message);
		$message = str_replace(":p", "<IMG SRC=\"epay/img/smilies/icon_razz.gif\">", $message);
		$message = str_replace(":P", "<IMG SRC=\"epay/img/smilies/icon_razz.gif\">", $message);
		$message = str_replace(":-p", "<IMG SRC=\"epay/img/smilies/icon_razz.gif\">", $message);
		$message = str_replace(":-P", "<IMG SRC=\"epay/img/smilies/icon_razz.gif\">", $message);
		$message = str_replace(":-|", "<IMG SRC=\"epay/img/smilies/icon_mad.gif\">", $message);
		$message = str_replace(":|", "<IMG SRC=\"epay/img/smilies/icon_mad.gif\">", $message);
		return($message);
	}

	function myheader($user){
		global $cobrand;
		if($user && $cobrand){
			$x = mysql_fetch_object(mysql_query("SELECT header FROM epay_users WHERE username='".addslashes($user)."'"));
			if ($x){
				$myheader = $x->header;
			}
		}
		echo $myheader;
	}
	function myfooter($user){
		global $cobrand;
		if($user && $cobrand){
			$x = mysql_fetch_object(mysql_query("SELECT footer FROM epay_users WHERE username='".addslashes($user)."'") );
			if ($x){
				$myfooter = $x->footer;
			}
		}
		echo $myfooter;
	}

	function getuserstatus($user){
		global $bronze,$silver,$gold,$platinum,$multi_special;
		list($sp) = mysql_fetch_row(mysql_query("SELECT special FROM epay_users WHERE id=$user"));
		$medal = " ";
		if($multi_special){
			if ($sp == 1){
				$medal .= $bronze;
			}else if ($sp == 2){
				$medal .= $silver;
			}else if ($sp == 3){
				$medal .= $gold;
			}else if ($sp == 4){
				$medal .= $platinum;
			}else{
			    $medal .= "";
			}
		}else{
			if($sp){
				$medal = "<img src=epay/img/special.gif border=0>";
			}
		}
		return $medal;
	}

	function floatval2( $strValue ){
		$floatValue = sprintf("%01.2lf", $strValue);
		return $floatValue;
	}

	function myround($amt,$dec=""){
		ob_start();
		printf("%6.2f",$amt);
		$amount = ob_get_contents();
		ob_end_clean(); 
		$amount = str_replace(" ","",$amount);
		return $amount;
	}

	function mycurl($url,$postfield){
		$ach = curl_init();

		curl_setopt ($ach, CURLOPT_URL,$url);
		curl_setopt($ach, CURLOPT_POST, 1);
		curl_setopt($ach, CURLOPT_POSTFIELDS, $postfield);
		$result = curl_exec ($ach);
		curl_close ($ach);
		return $result;
	}

	function email_check($email) { 
		if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](g|l|m|pa|t|u|v)?$", $email, $check)) { 
			if (checkdnsrr(substr(strstr($check[0], '@'), 1), "ANY")) { 
				return 1; 
			} 
		} 
		return 0; 
	} 
?>