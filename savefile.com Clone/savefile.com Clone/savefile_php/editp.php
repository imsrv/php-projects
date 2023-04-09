<?
	include("include/common.php");

	if(!$loggedin){
		ob_start();
		header("Location: login.php");
	}
	include("include/header.php");
	include("include/accmenu.php");

	if($submit){
		mysql_query("update users25 set
			password='$spassword',
			first_name='$sfirst_name',
			last_name='$slast_name',
			street='$sstreet',
			city='$scity',
			state='$sstate',
			zip='$szip',
			country='$scountry',
			email='$semail',
			telephone='$stelephone'
			where uid='$myuid'");
?>
		<h3>Edit your Account Details</h3>
		<form action=account.php method=post>
		<?=$table2?>
		<tr align=center>
			<td colspan=2>Your account details have been saved.</td>
		</tr>
<?
		if ($cpassword != $spassword) {
			echo "<tr align=center><td colspan=2>You will now need to logout <a href=logout.php>here</a> and then login again. Make sure you do not have multiple browser windows open with this site in them.</td></tr>"; 
		}
		echo "</table>";
	}else{
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
?>
		<h3>Edit your Account Details</h3>
		<form method=post>
		<?=$table2?>
		<tr align=center>
			<td colspan=2>Edit your account details and then click the submit button below.<p></td>
		</tr>
		<input type=hidden name=a value=ea2>
		<tr>
			<td align=right>Username:</td><td><?=$cusername?></td></tr>
		<tr>
			<td align=right>Password:</td><td><input type=text name=spassword size=35 maxlength=15 value='<?=$cpassword?>'></td></tr>
		<tr>
			<td align=right>First Name:</td><td><input type=text name=sfirst_name size=35 maxlength=20 value='<?=$cfirst_name?>'></td></tr>
		<tr>
			<td align=right>Last Name:</td><td><input type=text name=slast_name size=35 maxlength=30 value='<?=$clast_name?>'></td></tr>
		<tr>
			<td align=right>Street:</td><td><input type=text name=sstreet size=35 maxlength=50 value='<?=$cstreet?>'></td></tr>
		<tr>
			<td align=right>City:</td><td><input type=text name=scity size=35 maxlength=30 value='<?=$ccity?>'></td></tr>
		<tr>
			<td align=right>State/Province:</td><td><input type=text name=sstate size=35 maxlength=30 value='<?=$cstate?>'></td></tr>
		<tr>
			<td align=right>Zip/Postal Code:</td><td><input type=text name=szip size=35 maxlength=10 value='<?=$czip?>'></td></tr>
		<tr>
			<td align=right>Country:</td><td><input type=text name=scountry size=35 maxlength=30 value='<?=$ccountry?>'></td></tr>
		<tr>
			<td align=right>Your Email:</td><td><input type=text name=semail size=35 maxlength=75 value='<?=$cemail?>'></td></tr>
		<tr>
			<td align=right>Telephone:</td><td><input type=text name=stelephone size=35 maxlength=12 value='<?=$ctelephone?>'></td></tr>
		<tr>
			<td> </td><td><input type=submit name=submit value='Submit Changes'></td></tr>
		</table>
		</form>
<?
	}
	include("include/footer.php");
?>