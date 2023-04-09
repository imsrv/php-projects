<?
	include("include/common.php");
	include("include/header.php");
?>
<?
#	if(!$submit1)$submit1=1;
	if($submit1 == "1") {
		if($requirepaid) {
?>
			<h3>Signup for a New Account Step 1</h3><form method=post>
			<?=$table2?>
			<tr align=center>
				<td colspan=3>Select a Username. A password will be generated and emailed to you at the end of the signup process.<p></td>
			</tr>
<?			include("include/paidsignupform.php");	?>
			</table>
			</form> 
<?
		}
		if(!$requirepaid) {
?>
			<h3>Signup for a New Account Step 1</h3><form method=post>
			<?=$table2?>
			<tr align=center>
				<td colspan=2>Fill out the form below. A password will be generated and emailed to you.<p></td>
			</tr>
<?			include("include/nopaidsignupform.php");	?>
			</table></form>
<?
		}
	}else if($submit1 == "2") {
?>
		<h3>Signup for a New Account</h3>
		<?=$table2?>
		<tr align=center>
			<td colspan=2>Press your browser's 'Back' key and click 'I Agree' to our terms and conditions to continue the signup process.<p></td>
		</tr> 
<?
	}else if($submit2) {
		if(!ereg("^[A-Za-z0-9_]{1,16}$",$susername)) {
			$serror="Invalid username! Use no more than 15 characters and only letters, numbers, and underscores.<br>"; 
		}
		$this->c=@mysql_query("select username from users25 where username='$susername'");
		$this->d=mysql_fetch_object($this->c);
		if(is_object($this->d)) { $serror="Username is already in use<br>"; }
		$this->c=@mysql_query("select username from pending25 where username='$susername'");
		$this->d=mysql_fetch_object($this->c);
		if(is_object($this->d)) { $serror="Username is already in use<br>"; }
		echo "<h3>Signup for a New Account Step 3</h3>";
		if (!$serror) {
			$nowtime = time();
			mysql_query("insert into pending25 (username,since) values ('$susername','$nowtime')"); 
?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<?="$table2";?>
			<tr>
				<td align=center>
					Click the button below to signup for our <?=$paypal_sub?> subscription through PayPal. 
					The first 7 days are free, and you can cancel anytime before the 7 days are up 
					and be charged nothing.<p>
					<input type="hidden" name="cmd" value="_xclick-subscriptions">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="p3" value="1">
					<input type="hidden" name="t3" value="<?=$paypal_subcode?>">
					<input type="hidden" name="a1" value="0.00">
					<input type="hidden" name="src" value="1">
					<input type="hidden" name="sra" value="1">
					<input type="hidden" name="business" value="<?="$paypal_email";?>">
					<input type="hidden" name="item_name" value="<?="$paypal_item";?>">
					<input type="hidden" name="item_number" value="<?="$paypal_item_number";?>">
					<input type="hidden" name="a3" value="<?="$paypal_price";?>">
					<input type="hidden" name="notify_url" value="<?="$paypal_ipn";?>">
					<input type="hidden" name="cancel_return" value="<?="$paypal_cancel_return";?>">
					<input type="hidden" name="return" value="<?="$paypal_return";?>">
					<input type="hidden" name="os0" value="<?="$susername";?>">
					<input type="hidden" name="on0" value="Username">
					<input type="submit" value="Subscribe now">
				</td>
			</tr>
			</table></form>
<? 
		}
		if ($serror) {
?>
			<form method=post>
			<?=$table2?>
			<tr align=center>
				<td colspan=3><font color=red>$serror</font><p></td>
			</tr>
<?			include("include/paidsignupform.php");	?>
			</table></form>
<?
		}
	}else if($submit3) {
		if(!ereg("^[A-Za-z0-9_]{1,16}$",$susername)) {
			$serror="Invalid username! Use no more than 15 characters and only letters, numbers, and underscores.<br>"; 
		}
		$this->c=@mysql_query("select username from users25 where username='$susername'");
		$this->d=mysql_fetch_object($this->c);
		if(is_object($this->d)) { $serror="Username is already in use<br>"; }
		$this->c=@mysql_query("select username from pending25 where username='$susername'");
		$this->d=mysql_fetch_object($this->c);
		if(is_object($this->d)) { $serror="Username is already in use<br>"; }
		if (!$serror) {
			mt_srand((double)microtime()*1000000^getmypid());
			$pass_length = mt_rand($this->min_pass_length,$this->max_pass_length);
			while(strlen($spassword)<$pass_length) {
				$spassword.=substr($this->chars,(mt_rand()%strlen($this->chars)),1); 
			}
			include("include/emails.php");
			$signupmessage=str_replace("<username>","$susername",$signupmessage);
			$signupmessage=str_replace("<password>","$spassword",$signupmessage);
			$signupmessage=str_replace("<first_name>","$sfirst_name",$signupmessage);
			$signupmessage=str_replace("<last_name>","$slast_name",$signupmessage);
			$signupmessage=str_replace("<login_url>","$login_url",$signupmessage);
			$subject = "$signupsubject";
			$message = "$signupmessage";
			mail($semail,$subject,$message,"From: $admin25email");
			$admin25signupmessage = str_replace("<username>","$susername",$admin25signupmessage);
			$admin25signupmessage = str_replace("<password>","$spassword",$admin25signupmessage);
			$admin25signupmessage = str_replace("<first_name>","$sfirst_name",$admin25signupmessage);
			$admin25signupmessage = str_replace("<last_name>","$slast_name",$admin25signupmessage);
			$admin25signupmessage = str_replace("<member_email>","$semail",$admin25signupmessage);
			$subject = "$admin25signupsubject";
			$message = "$admin25signupmessage";
			mail($admin25email,$subject,$message,"From: $admin25email"); 
			$nowdate = date("M d, Y");
			mysql_query("insert into users25 (uid, username, password, first_name, last_name, street, city, state, zip, country, email, telephone, last_paid, signup_date) values ('','$susername', '$spassword', '$sfirst_name', '$slast_name', '$sstreet', '$scity', '$sstate', '$szip', '$scountry', '$semail', '$stelephone', 'free', '$nowdate')");
			echo "<h3>Signup for a New Account Complete</h3>$table2
				<tr><td align=center>Thank you for signing up $susername. We have sent you a welcome email to <b>$semail</b> with your password.</table>"; 
		}
		if ($serror) {
?>
			<h3>Signup for a New Account Step 3</h3>
			<form method=post>
			<?=$table2?>
			<tr align=center>
				<td colspan=3><font color=red>$serror</font><p></td>
			</tr>
<?			include("include/nopaidsignupform.php");	?>
			</table></form>
<?
		}
	}else {
?>
		<h3>Signup for a New Account Step 1</h3>
		<?=$table2?>
		<tr>
			<td align=center>
				Please read through our terms and conditions below and click 'I Agree' to continue with the signup process.<p>
				<font size=3><b>Terms and Conditions</b></font><p>
				<form method=post><textarea name=textfield cols=60 rows=15 wrap=virtual>
<?		include "include/terms.php";	?>
				</textarea><p><input type=radio name=submit1 value=1> I Agree<br><input type=radio name=submit1 value=2> I Disagree<p><input type=submit value='Next Step -->'></form>
			</td>
		</tr>
		</table>
<?
	}
	include("include/footer.php");
?>