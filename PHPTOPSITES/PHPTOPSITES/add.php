<?
include "config.php";
include "header.php";

if (!isset($submit)) {
	include "rules.php";
	?>
	<Table Align="center" Border="1" Width="400" CellPadding="3" CellSpacing="0">
	<tr>
		<td>
			<form action="add.php" method="post">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Seu Nome:</font><BR>
			<input type="text" name="name"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Senha:</font><BR>
			<input type="password" name="passw"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Email :</font><BR>
			<input type="text" name="email"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Título do site:</font><BR>
			<input size=50 type="text" name="title"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">URL do Site:</font><BR>
			<input size=50 type="text" name="url" value="http://"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Confirma URL:</font><BR>
			<input size=50 type="text" name="linkback" value="http://"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">URL do Banner:</font><BR>
			<input size=50 type="text" name="banner_url" value="http://"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner Largura (<? echo $max_banner_width;?> max) :</font><BR>
			<input ReadOnly size="4" type="text" name="banner_w" value="<? echo $max_banner_width;?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner Altura (<? echo $max_banner_height;?> max) :</font><BR>
			<input ReadOnly size="4" type="text" name="banner_h" value="<? echo $max_banner_height;?>"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Descrição do Site:</font><BR>
			<input size="50" type="text" name="description"><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Categoria do site:</font><BR>
			<select name=category>
			<?
			$query = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());
			while ($rows = mysql_fetch_array($query))
			{
				echo "<option value=$rows[cid] ";
				if ($cid == $rows[cid]) {echo "selected";}
				echo ">$rows[catname]</option><BR>";
			}
			?>
			</select>
			</font>
			<BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">País:</font><BR>
			<select name=country>
			<?
			$handle=opendir("images/flags");
			while (false!==($file = readdir($handle))) { 
			    if ($file != "." && $file != "..") { 
				$country = substr($file,0,strpos($file,'.'));
				echo "<option value=\"".$file."\">".$country."</option>\n";
			    } 
			}
			closedir($handle); 
			?>
			</select>
			</font>
			<BR>
			<center>
			<BR>
			<input type="submit" value="submit" name="submit">
			</center>
			</form>
		</td>
	</tr>
	</Table>
	<?	
}
if (isset($submit)) {
	$get_rows = mysql_db_query ($dbname,"Select * from top_user Where url='$url' OR description='$description' OR title='$title'",$db) or die (mysql_error());
	$count = mysql_num_rows($get_rows);
	if ($count > 0) {
		?>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site already registered.</font>
		<?
	}
	if ($count < 1) {
	
		$name = trim($name);
		$passw = trim($passw);
		$email = trim($email);
		$title = trim($title);
		$url = trim($url);
		$banner_w = trim($banner_w);
		$banner_h = trim($banner_h);
		$description = trim($description);
		$category = trim($category);

		if (!$name) { $err.= "Please enter your name.<BR>"; }
		if (!$passw) { $err.= "Please enter password.<BR>"; }
		if (!$email) { $err.= "Please enter your email address.<BR>"; }
		if (!$title) { $err.= "Please enter site title.<BR>"; }
		if (!$url) { $err.= "Please enter site url.<BR>"; }
		if (!$linkback) { $err.= "Please enter link back url.<BR>"; }
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
		else {
		$sid = time();

		if (strlen($banner_url) <= 7) $banner_url="";
		if ($auto_validation == "yes") mysql_db_query ($dbname,"Insert into top_user (sid,name,password,email,title,url,banner,bannerw,bannerh,description,category,status,country,linkback) values ('$sid','$name','$passw','$email','$title','$url','$banner_url',$banner_w,$banner_h,'$description',$category,'Y','$country','$linkback')",$db) or die (mysql_error());
		else {
			mysql_db_query ($dbname,"Insert into top_user (sid,name,password,email,title,url,banner,bannerw,bannerh,description,category,status,country,linkback) values ('$sid','$name','$passw','$email','$title','$url','$banner_url',$banner_w,$banner_h,'$description',$category,'N','$country','$linkback')",$db) or die (mysql_error());
			$msg = "Thank you for submission of your site to $top_name. Your site will be reviewed shortly.";
			mail($email,"Welcome $name to the $top_name",$msg,"From: $admin_email\nReply-To: $admin_email");
		}


		if ($new_member == "yes" AND $auto_validation == "no") {
			$msg = "GO TO $url_to_folder/admin\n";
			$msg.= "Site ID : $sid\n";
			$msg.= "User Name : $name\n";
			$msg.= "User Email : $email\n";
			$msg.= "Site Title : $title\n";
			$msg.= "Site URL : $url\n";
			$msg.= "Site Description : $description\n";
			$msg.= "\n";
			mail($admin_email,"Site Required Validation",$msg,"From: $email\nReply-To: $email");	
		}

		if ($auto_validation == "no") { $msg = "Your account has been added and waiting for validation.<BR>Your ID is:"; }
		else { $msg = "Your account has been added automatically.<BR>Your ID is:"; }
		?>		
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $msg;?> <? echo $sid;?><BR><A HREF="help.php?site=<? echo $sid?>">"Click and Get HTML Code for Your Web Site."</A></font>
		<?
		}
	}
}
include "footer.php";
?>
