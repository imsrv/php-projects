<?
include "config.php";
include "header.php";

if (!isset($submit) and !isset($a)) {
	?>
	<form action=edit.php method=post>
	<Table Align="center" Border="1" Width="400" CellPadding="3" CellSpacing="0">
	<tr>
		<td>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Edit Site:</font>
		</td>
	</tr>
	<tr>
		<td>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site ID:</font>	<BR>
		<input type=text name=sid><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Password:</font>	<BR>
		<input type=password name=passw><BR>
		<input type=submit name=submit><BR>
		<input type=hidden name=a value=pre>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><a href=forgot.php>Forgot Your Password ?</a></font>	<BR>
		</td>
	</tr>
	</table>
	</form>
	<?
}

if (isset($submit) and $a == "pre") {

	$query = mysql_db_query ($dbname,"Select * from top_user Where sid=$sid AND password='$passw'",$db) or die (mysql_error());
	$num_rows = mysql_num_rows($query);
	
	if ($num_rows<1) {
		echo "<center><font color=\"red\" face=\"$font_face\" size=\"$font_size\">Wrong Site ID or Password</font></center>";
		?>
		<form action=edit.php method=post>
		<Table Align="center" Border="1" Width="400" CellPadding="3" CellSpacing="0">
		<tr>
			<td>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Edit Site:</font>
			</td>
		</tr>
		<tr>
			<td>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site ID:</font>	<BR>
			<input type=text name=sid><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Password:</font>	<BR>
			<input type=password name=passw><BR>
			<input type=submit name=submit><BR>
			<input type=hidden name=a value=pre>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><a href=forgot.php>Forgot Your Password ?</a></font>	<BR>
			</td>
		</tr>
		</table>
		</form>
		<?
		}
	if ($num_rows > 0) {$auth = 1;}
}
if (isset($submit) and $a=="pre" and $auth == 1) {
	$query = mysql_db_query ($dbname,"Select * from top_user Where sid=$sid AND password='$passw'",$db) or die (mysql_error());
	$rows = mysql_fetch_array($query);
	?>
	<Table Align="center" Border="1" Width="400" CellPadding="3" CellSpacing="0">
	<tr>
		<td>
			<form action="edit.php" method="post">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Your Name:</font><BR>
			<input type="text" name="name" value="<? echo $rows[name]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Password:</font><BR>
			<input type="password" name="passw" value="<? echo $rows[password]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Email Address:</font><BR>
			<input type="text" name="email" value="<? echo $rows[email]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Title:</font><BR>
			<input size=50 type="text" name="title" value="<? echo $rows[title]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site URL:</font><BR>
			<input size=50 type="text" name="url" value="<? echo $rows[url]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Link back URL:</font><BR>
			<input size=50 type="text" name="linkback" value="<? echo $rows[linkback]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner URL:</font><BR>
			<input size=50 type="text" name="banner_url" value="<? echo $rows[banner]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Current Width for any Banner is <? echo $max_banner_width;?></font><BR>
			<input ReadOnly size="4" type="text" name="banner_w" value="<? echo $max_banner_width;?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Current Height for any Banner is <? echo $max_banner_height;?></font><BR>
			<input ReadOnly size="4" type="text" name="banner_h" value="<? echo $max_banner_height;?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Description:</font><BR>
			<input size="50" type="text" name="description" value="<? echo $rows[description]?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Category:</font><BR>
			<select name=category>
			<?
			$query = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());
			while ($rowss = mysql_fetch_array($query))
			{
				echo "<option value=$rowss[cid]";
				if ($rows[category] == $rowss[cid]) {echo " selected";}
				echo ">$rowss[catname]</option><BR>";
			}
			?>
			</select>
			</font>
			<BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Country:</font><BR>
			<select name=country>
			<?
			$handle=opendir("images/flags");
			while (false!==($file = readdir($handle))) { 
			    if ($file != "." && $file != "..") { 
				$country = substr($file,0,strpos($file,'.'));
				echo "<option value=\"".$file."\" ";
				if ($rows[country] == $file) echo "selected";
				echo ">".$country."</option>\n";
			    } 
			}
			closedir($handle); 
			?>
			</select>
			</font>
			<center>
			<BR>
			<input type="submit" name="submit">
			<input type=hidden name=sid value="<? echo $rows[sid]?>">
			<input type=hidden name=a value="update">
			<input type=hidden name=passwd value="<? echo $rows[password]?>">
			</center>
			</form>
		</td>
	</tr>
	</Table>

	<?
}

if (isset($submit) and $a=="update") {

	$get_rows = mysql_db_query ($dbname,"Select * from top_user Where sid=$sid and password='$passwd'",$db) or die (mysql_error());
	$num_rows = mysql_num_rows($get_rows);
	
	if ($num_rows<1) {
	$err.= "Wrong Site ID or Password.<BR>";
	}

	if (!$name) { $err.= "Please enter your name.<BR>"; }
	if (!$passw) { $err.= "Please enter password.<BR>"; }
	if (!$email) { $err.= "Please enter your email address.<BR>"; }
	if (!$title) { $err.= "Please enter site title.<BR>"; }
	if (!$url) { $err.= "Please enter site url.<BR>"; }
	if (!$banner_w) { $err.= "Please enter banner width.<BR>"; }
	if (!$banner_h) { $err.= "Please enter banner height.<BR>"; }
	if (!$description) { $err.= "Please enter site description.<BR>"; }
	if (!$category) { $err.= "Please enter site category.<BR>"; }
	if (check_email_addr($email) == 0) { $err.= "Please enter valid email address.<BR>"; }

	if ($err) {
	?>
	<font color="red" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $err;?></font>
	<?
	}
		
	if (!$err) {
		if (strlen($banner_url) <= 7) $banner_url="";

		if ($auto_validation == "yes") { 
			mysql_db_query ($dbname,"Update top_user set name='$name',password='$passw',email='$email',title='$title',url='$url',banner='$banner_url',bannerw=$banner_w,bannerh=$banner_h,description='$description',category=$category,status='Y',country='$country',linkback='$linkback' Where sid=$sid AND password='$passwd'",$db) or die (mysql_error());
			$msg = "Welcome $name to the $top_name.\n Your Site has been accepted from $top_name.\n Site ID: $sid\n Password: $passw\n HTML: \n <A HREF=\"$url_to_folder/in.php?site=$sid\"><IMG ALT=\"$top_name\" SRC=\"$vote_image_url\" BORDER=0></A>";
			mail($email,"Site Accepted.",$msg,"From: $admin_email\nReply-To: $admin_email");
		?>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Your account has been updated.</font>
		<?
		}
		else {
			mysql_db_query ($dbname,"Update top_user set name='$name',password='$passw',email='$email',title='$title',url='$url',banner='$banner_url',bannerw=$banner_w,bannerh=$banner_h,description='$description',category=$category,status='N',country='$country',linkback='$linkback' Where sid=$sid AND password='$passwd'",$db) or die (mysql_error());
		// --- Email TO Admin AND TO User
			$msg = "Thank you for re-submission of your site to $top_name. Your site will be re-reviewed shortly.";
			mail($email,"Welcome $name to the $top_name",$msg,"From: $admin_email\nReply-To: $admin_email");

			if ($new_member == "yes") {
				$msg = "Site ID : $sid\n GO TO $url_to_folder/admin";
				mail($admin_email,"Site Required RE-Validation",$msg,"From: $admin_email\nReply-To: $admin_email");	
			}
		?>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Your account has been updated and waiting for re-validation.</font>
		<?
		}
	}
}
include "footer.php";
?>