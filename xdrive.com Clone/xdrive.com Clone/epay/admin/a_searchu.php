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
$keywords = preg_split("/\\W/", $_POST['search']);
while ($a = each($keywords))
  if ($a[1])
  {
    $key_search[] = "/".preg_quote(htmlspecialchars($a[1]))."(?![>])/i";
    $token = "LIKE '%".addslashes($a[1])."%'";
    $key[] = "username $token OR email $token OR name $token OR profile $token";
  }
$key = implode(" OR ", $key);
if($_POST['xdelete']){
	$qr1 = mysql_query("SELECT * FROM epay_users WHERE type!='sys' ORDER BY username");
	$uC = 0;
	while ($d = mysql_fetch_object($qr1)){
		$key = $_POST["delete{$d->id}"];
		if($key){
			if($d->username == $key){
				delete_user($d->id);
				echo "{$d->username} was deleted<bR>";
				$uC++;
			}
		}
	}
	die("$uC users deleted<bR>");
}
?>
<TABLE class=design width=100% cellspacing=0>
<form method=post name=form1>
<input type=hidden name=xdelete value=0>
<INPUT type=hidden name=suid value="<?=$suid?>">
<INPUT type=hidden name=a value="searchu">
<INPUT type=hidden name=sus value="<?=$_GET['sus']?>">
<input type=hidden name=search value="<?=$_POST['search']?>">
<TR>
	<TH colspan=7>
<?	if($_GET['sus']){	?>
		Displaying Suspended Users
<?	}else{	?>
		User Search Results
<?	}	?>
<TR><TH>Username
	<TH>Name
	<TH>Email
	<TH>Password
<?	if($charge_signup)echo"<TH>Signup Paid";?>
	<TH>Status
	<TH>Delete
<?
$ulist_page = 20;
($startp = $_POST['startp'] or $startp = $_GET['startp']);
if(!$startp){$startp = 0;}
if($_GET['sus'] == 1){
	$susp = "suspended = 1";
}
$qr2 = mysql_query("SELECT * FROM epay_users WHERE type!='sys'".($key ? " AND ($key)" : "")." ".($susp ? " AND ($susp)" : "")." ORDER BY username ");
$numrows = mysql_num_rows($qr2);
$qr1 = mysql_query("SELECT * FROM epay_users WHERE type!='sys'".($key ? " AND ($key)" : "")." ".($susp ? " AND ($susp)" : "")." ORDER BY username LIMIT $startp,$ulist_page");
while ($a = mysql_fetch_object($qr1)){
	$ahref = "right.php?a=user&id=$a->username&$id";
	$href = "window.open('right.php?a=user&id=$a->username&$id','epay','width=500,height=500,toolbar=no,scrollbars=yes,menubar=no,resizable=1'); return false;";
	$href2 = "window.open('right.php?a=write&id=$a->username&$id','write','width=500,height=500,toolbar=no,scrollbars=yes,menubar=no,resizable=1'); return false;";
	$kname = $a->username;
	if ($key_search){
		$a->username = preg_replace($key_search, "<b>\\0</b>", $a->username);
		$a->email = preg_replace($key_search, "<b>\\0</b>", $a->email);
		$a->name = preg_replace($key_search, "<b>\\0</b>", htmlspecialchars($a->name));
	}
	if($charge_signup){
		$feep = "<TD>".($a->fee ? "yes" : "no")."\n";
	}
	echo 	"\n<TR>\n",
			"<TD><a href=\"$ahref\">$a->username</a>\n",
			"<TD>",($a->name != '' ? $a->name : "&nbsp;"),"\n",
			"<TD>$a->email (<a href=# onClick=\"$href2\">write</a>)\n",
			"<TD>",($a->password != '' ? $a->password : "&nbsp;"),"\n",
			$feep,
			"<TD>";
	if ($a->suspended){
		echo "suspended "; 
	}else{ 
		echo "active"; 
	}
	echo "<TD><input type=checkbox name=\"delete{$a->id}\" value=\"{$kname}\">";
}
?>
<TR>
	<TH>&nbsp;
	<TH>&nbsp;
	<TH>&nbsp;
	<TH>&nbsp;
<?	if($charge_signup)echo"<TH>&nbsp;";?>
	<TH colspan=3 align=right>
		<input type=button class=button value="Delete Selected Members" onClick="if (confirm('Delete this item?')) { form1.xdelete.value = '1'; form1.submit(); }">
	</TH>
</TR>
</TABLE>
</form>
<BR>
<TABLE class=design width=100% cellspacing=0>
<form method=post name=pform>
<input type=hidden name=startp value=0>
<input type=hidden name=search value="<?=$_POST['search']?>">
<TR>
<?	if($startp > 0){	?>
		<th align=left><div align=left><a href="javascript:pform.startp.value = '<?=($startp - $ulist_page)?>'; pform.submit();"><b>Previous</b></a></th>
<?	}	?>
<?	if($numrows > ($startp + $ulist_page)){		?>
		<th align=right><div align=right><a href="javascript:pform.startp.value = '<?=($startp + $ulist_page)?>'; pform.submit();"><b>Next</b></a></th>
<?	}	?>
</TR>
</TABLE>
</form>
<br><br>
<br>
<? echo mysql_num_rows($qr1)," users found"; ?>
<br><br>
<br>
<FORM method=post action=right.php target=right name="sform1">
<INPUT type=hidden name=a>
<INPUT type=hidden name=suid value="<?=$suid?>">
<TABLE class=design width=100% cellspacing=0>
<TR>
	<TH colspan=5>Search Users</TH>
</TR>
<TR>
	<TD>Search</TD>
	<TD><INPUT type=text name=search size=27></TD>
	<TD><INPUT type=button onClick="sform1.a.value='searchu'; sform1.submit();" value="Search &gt;&gt;"></TD>
</TR>
</TABLE>
</form>
<?
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
?>