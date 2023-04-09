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
//
// Field `epay_users`.`cobrand` takes one of the following values:
// NULL - user is not a programmer or haven't applied
// 1 - admin confirmed application
// 0 - admin deleted application

if ($_GET['username']){
	$_add = 0;
	include("src/g_cobrand.php");
	if ($formerr) exit;
}elseif ($_GET['ud']){
	$username = addslashes($_GET['ud']);
	mysql_query("UPDATE epay_users SET cobrand=0 WHERE username='$username'");
	mysql_query("DELETE FROM epay_cobrand WHERE username='$username'");
	echo $reload_left;
}elseif ($_GET['cs']){
	$username = addslashes($_GET['cs']);
	$r = mysql_fetch_row(mysql_query("SELECT cobrand FROM epay_users WHERE username='$username'"));
	if ($r[0]){
		$sp = 0;
	}else{
		$sp = 1;
	}
	mysql_query("UPDATE epay_users SET cobrand=$sp WHERE username='$username'");
	echo $reload_left;
}elseif ($_GET['cp']){
}
?>
<? 
	list($r1) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE cobrand=1 AND type='pr'")); 
	list($r2) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE cobrand=1 AND type='wm'")); 
	list($r) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_cobrand"));
?>
	Co-branded Member Stats: (<?=$r1?> <?=$pr?>s, <?=$r2?> <?=$wm?>s)<BR>
	Total CB's in Database: <?=$r?><BR>
<TABLE class=design width=100% cellspacing=0>
<TR>
	<TH colspan=7>Cobranded Users List
<TR>
	<TH>Username
	<TH>Type
	<TH>Full Name
	<TH>Email
	<TH>&nbsp;
<?
$qr1 = mysql_query("SELECT epay_cobrand.username,type,fullname,cobrand,email1 FROM epay_cobrand,epay_users WHERE epay_cobrand.username=epay_users.username ORDER BY epay_cobrand.username") or die( mysql_error() );
while ($a = mysql_fetch_object($qr1)){
	echo "<TR>\n",
			"<TD><a href=right.php?a=user&id=$a->username&$id>$a->username</a>\n",
			"<TD>",$GLOBALS[$a->type],
			"<TD>",htmlspecialchars($a->fullname),"\n",
			"<TD>$a->email1 (<a href=right.php?a=write&id=$a->username&$id>write</a>)\n",
			"<TD align=center>",($a->cobrand ? "Approved | " : "Pending | "),
			"<a href=right.php?a=gbuser&cs=$a->username&$id>",($a->cobrand ? "Reject" : "Approve"),"</a><BR>";
	echo "<a href=right.php?a=gbuser&username=$a->username&$id>Edit</a> | ",
		"<a href=right.php?a=gbuser&ud=$a->username&$id $del_confirm>Delete</a> ";
}
?>
</TABLE>
