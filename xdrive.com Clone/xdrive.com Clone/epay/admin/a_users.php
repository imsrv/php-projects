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
if($_POST['xdelete']){
	$letter = $_POST['letter'];
	$wh = $_POST['wh'];
	$qr1 = mysql_query("SELECT * FROM epay_users WHERE $wh AND UPPER(LEFT(username,1))='".addslashes($letter)."' ORDER BY username");
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

if ($_GET['t'] == 'wm' || $_GET['t'] == 'pr')
{
  $type = $_GET['t'];
  $wh = "type='$type'";
}
else
{
  $type = '';
  $wh = "type!='sys'";
}
$letter = $_GET['let'];

$qr1 = mysql_query("SELECT UPPER(LEFT(username,1)) AS letter,COUNT(id) FROM epay_users WHERE $wh GROUP BY letter ORDER BY letter");
?>
<TABLE class=design width=100% cellspacing=0>
<TR><TH>
  <?=($type ? $GLOBALS[$type] : "User")?>s List
<TR><TD align=center>
  <? 
    while ($a = mysql_fetch_row($qr1))
    {
      if (!$letter) $letter = $a[0];
      if ($a[0] != $letter)
        echo "<a href=right.php?a=users&t=$type&let=$a[0]&$id title='$a[1] users'>$a[0]</a> ";
      else
        echo "<b>$a[0]</b> ";
    }
  ?>
</TABLE>
<BR>
<TABLE class=design width=100% cellspacing=0>
<form method=post name=form1>
<input type=hidden name=xdelete value=0>
<input type=hidden name=letter value="<?=$letter?>">
<input type=hidden name=wh value="<?=$wh?>">
<TR><TH>Username
	<TH>Balance
	<TH>Name
	<TH>Email
	<TH>Password
	<?	if($charge_signup)echo"<TH>Signup Paid";?>
	<TH>Class
	<TH>Delete
<?
$qr1 = mysql_query("SELECT * FROM epay_users WHERE $wh AND UPPER(LEFT(username,1))='".addslashes($letter)."' ORDER BY username");
while ($a = mysql_fetch_object($qr1))
{
  if($charge_signup){
  	$feep = "<TD>".($a->fee ? "yes" : "no")."\n";
  }
  echo "\n<TR>\n",
       "<TD><a href=# onClick=\"window.open('right.php?a=user&id=$a->username&$id','epay','width=500,height=500,toolbar=no,scrollbars=yes,menubar=no,resizable=1'); return false;\">$a->username</a>\n",($type ? "" : " ({$GLOBALS[$a->type]})"),
       "<TD>",prsumm(balance($a->id), 1),"\n",
       "<TD>",($a->name != '' ? htmlspecialchars($a->name) : "&nbsp;"),"\n",
       "<TD>$a->email (<a href=right.php?a=write&id=$a->username&$id>write</a>)\n",
       "<TD>",($a->password != '' ? $a->password : "&nbsp;"),"\n",
       $feep,
       "<TD>&nbsp;";
  if ($a->special) echo "special ";
  if ($a->suspended) echo "suspended ";
  echo "<TD><input type=checkbox name=delete{$a->id} value={$a->username}>";
}
?>
<TR>
	<TH>&nbsp;
	<TH>&nbsp;
	<TH>&nbsp;
	<TH>&nbsp;
<?	if($charge_signup)echo"<TH>&nbsp;";?>
	<TH colspan=3 align=right><input type=button class=button value="Delete this user(s)" onClick="if (confirm('Delete this item?')) { form1.xdelete.value = '1'; form1.submit(); }"></TH></TR>
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