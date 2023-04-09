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
	if($_POST['user'] && !$_GET['id'])$_GET['id'] = $_POST['user'];
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($_GET['id'])."' OR id='".addslashes($_GET['id'])."'")); 
	if ($r->type == 'sys') exit;

	function delete_user($id){
		mysql_query("UPDATE epay_users SET referredby=NULL WHERE referredby=$id");
		mysql_query("UPDATE epay_transactions SET paidby=100 WHERE paidby=$id");
		mysql_query("UPDATE epay_transactions SET paidto=100 WHERE paidto=$id");
		mysql_query("UPDATE epay_safetransfers SET paidby=100 WHERE paidby=$id");
		mysql_query("UPDATE epay_safetransfers SET paidto=100 WHERE paidto=$id");
		mysql_query("UPDATE epay_bids SET bidby=100 WHERE bidby=$id");
		mysql_query("UPDATE epay_messages SET postedby=100 WHERE postedby=$id");
		mysql_query("UPDATE epay_messages SET postedto=100 WHERE postedto=$id");
		mysql_query("UPDATE epay_reviews SET user=100 WHERE user=$id");
		mysql_query("UPDATE epay_projects SET programmer=100 WHERE programmer=$id");
		mysql_query("UPDATE epay_projects SET openedby=100 WHERE openedby=$id");
		list($uname) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$id"));
		mysql_query("DELETE FROM epay_special WHERE username='$uname'");
		mysql_query("DELETE FROM epay_users WHERE id=$id");
	}

	if($_POST['addnotes']){
		if($_POST['nid']){
			$sql = "UPDATE epay_notes SET notes='{$_POST['note']}' WHERE id='{$_POST['nid']}'";
		}else{
			$sql = "INSERT INTO epay_notes SET notes='{$_POST['note']}',user='{$_POST['user']}'";
		}
		mysql_query($sql) or die( mysql_error()."<br>$sql" );
	}

	if ($_GET['ssp']){
		mysql_query("UPDATE epay_users SET suspended=1-suspended WHERE id=".(int)$_GET['ssp']);
		$r->suspended = 1 - $r->suspended;
	}elseif ($_GET['sif']){
		if($r->fee){$nfee="0";}else{$nfee="1";}
		mysql_query("UPDATE epay_users SET fee=$nfee WHERE id=".(int)$_GET['sif']);
		$r->fee = $nfee;
	}elseif ($_GET['del']){
		delete_user((int)$_GET['del']);
		die("The user was deleted.".$reload_left);
	}elseif ($_GET['ed']){
		$tt = $_GET['id'];
		$_GET['id'] = $_GET['ed'];
		$_fpr_add = 0;
		require("admin/g_uedit.php");
		if ($_fpr_err) exit;
		$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($tt)."'")); 
	}
	if ($use_images && !$_FILES['logo']['error']){
		if (strtolower(substr($_FILES['logo']['name'], -4)) != ".jpg")
			errform("File must have the .JPG extension", "img");
		elseif ($_FILES['logo']['size'] > 120 * 1024)
			errform("Your logo file is too large", "img");
		else
			$img = 1;
	}else{
		$img = 0;
	}
	if ($img)
		copy($_FILES['logo']['tmp_name'], $att_path.$data->username.".jpg");
	if ($_POST['delimg'])
		unlink($att_path.$data->username.".jpg");
	$sname1 = statename("",$r->country);
	$sname2 = statename($r->state,$r->country);
	$country = strtolower($r->country);
	if (file_exists("img/flags/{$r->state}.gif") ){
		$sflag = "<img src=../img/flags/{$r->state}.gif height=15 width=22 border=0 alt='$sname2'> ";
	}
	if (file_exists("img/flags/{$country}.gif") ){
		$cflag = "<img src=../img/flags/{$country}.gif height=15 width=22 border=0 alt='$sname1'> ";
	}
?>
<CENTER>
<TABLE class=design cellspacing=0 width=100%>
	<FORM method=post enctype='multipart/form-data'>
<TR><TH colspan=2>Member Information
<TR><TD>Username:
	<TD><?=$r->username?> (<a href="<?=$siteurl?>/index.php?a=uview&user=<?=$r->id?>" target=mainsite>View on Site</a>)
	                      (<a href="right.php?a=user&id=<?=$r->username?>&ed=<?=$r->id?>&<?=$id?>">Edit</a>)
<TR><TD>E-mail:
	<TD><?=$r->email?> (<a href=right.php?a=write&id=<?=$r->username?>&<?=$id?>>Write mail</a>)
<TR><TD>Password:
	<TD><?=htmlspecialchars($r->password)?>
<TR><TD>Name:
	<TD><?=( $r->name ? htmlspecialchars($r->name) : "&nbsp;" )?>
<TR><TD>Company Registration Number:
	<TD><?=( $r->regnum ? htmlspecialchars($r->regnum) : "&nbsp;" )?>
<TR><TD>Address:
	<TD><?=( $r->address ? htmlspecialchars($r->address) : "&nbsp;" )?>
<TR><TD>City:
	<TD><?=( $r->city ? htmlspecialchars($r->city) : "&nbsp;" )?>
<TR><TD>State / Region:
	<TD><?=$sflag?> <?=$state_values[$r->country][$r->state]?>
<TR><TD>Zip Code:
	<TD><?=( $r->zipcode ? htmlspecialchars($r->zipcode) : "&nbsp;" )?>
<TR><TD>Country:
	<TD><?=$cflag?><?=$country_values[$r->country]?>
<TR><TD>Phone:
	<TD><?=( $r->phone1 ? htmlspecialchars($r->phone1) : "&nbsp;" )?>
<TR><TD>Fax:
	<TD><?=( $r->fax ? htmlspecialchars($r->fax) : "&nbsp;" )?>
<TR><TD>Balance:
	<TD><?=( prsumm(balance($r->id), 1) ? prsumm(balance($r->id), 1) : "&nbsp;" )?>
<?if($charge_signup){?>
<TR><TD>Signup Paid:
	<TD><?=($r->fee ? "yes" : "no")?> ( <a href=right.php?a=user&id=<?=$r->username?>&sif=<?=$r->id?>&<?=$id?>><?=($r->fee ? "no" : "yes")?></a> )
<?}?>
<TR><TD>Referred by:
	<TD><? if ($r->referredby) { list($uname) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$r->referredby")); echo "<a href=right.php?a=user&id=$uname&$id>$uname</a>"; } else echo "&nbsp;"; ?>
<TR><TD>ID:
	<TD><?=$r->id?>
<TR><TD>Last login:
	<TD><? echo prdate($r->lastlogin)," from ",$r->lastip; ?>
<TR><TD>Account
	<TD><?=($r->suspended ? "Suspended. (<a href=right.php?a=user&id=$r->username&ssp=$r->id&$id>Activate</a>)" : "Active. (<a href=right.php?a=user&id=$r->username&ssp=$r->id&$id>Suspend</a>)")?>
<TR><TD colspan=2 align=center><a href=right.php?a=user&id=<?=$r->username?>&del=<?=$r->id?>&<?=$id?> <?=$del_confirm?>>Delete account</a> (<span style='color:red;'>Will cause extensive database updates</span>)
  </TD><?=$id_post?></FORM>
</TABLE>
<BR>
<a href="right.php?a=viewtr2&u=<?=$r->id?>&<?=$id?>" style="color:white;">View transactions</a>
<br><br>
<?/*
<TABLE class=design cellspacing=0 width=100%>
<TR><TH>Transaction History
<TR>
	<TD>
		<iframe src="right.php?a=viewtr2&u=<?=$r->id?>&<?=$id?>" height="350" width="600"></iframe>
	</TD>
</TR>
</TABLE>
<BR><BR>
*/?>
<?
	$qr1 = mysql_query("SELECT * FROM epay_notes WHERE user=$r->id");
	$ba = mysql_fetch_object($qr1);
?>
<TABLE cellspacing=0 width=100% cellpadding=5 cellspacing=5>
<TR>
	<TD width=50%  valign=top>
		<TABLE class=design cellspacing=0 width=100%>
		<TR><TH>Notes
		<TR>
			<form method="POST">
			<input type="hidden" name="addnotes" value=1>
			<input type="hidden" name="user" value=<?=$r->id?>>
			<TD>
		<?	if($ba->id){	?>
				<input type="hidden" name="nid" value=<?=$ba->id?>>
		<?	}	?>
				<textarea name="note" class="fields" rows="7" style="width:100%"><?=$ba->notes?></textarea>
			</TD>
		</TR>
		<TR>
			<TH>
				<input type="submit" value="submit">
			</TH>
		</TR>
			</form>
		</TABLE>
	</TD>
	<TD width=50%  valign=top>
		<?
			$qr1 = mysql_query("SELECT username FROM epay_users WHERE referredby=$r->id ORDER BY username");
		?>
		<TABLE class=design cellspacing=0 width=100%>
		<TR><TH>Referred Users
		<?
			while ($a = mysql_fetch_object($qr1))
				echo "<tr><td><a href=right.php?a=user&id=$a->username&$id>$a->username</a>";
			if (mysql_num_rows($qr1) == 0) echo "<TR><TD>None.";
		?>
		</TABLE>
	</TD>
</TR>
</TABLE>
</CENTER>
