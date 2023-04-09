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
<CENTER>
<TABLE class=design cellspacing=0>
<TR><TH colspan=4>Safe Transfer List
<TR><TH>From
	<TH>To
	<TH>Amount
	<TH>&nbsp;
  
<?
if ($_GET['c'])
{
  $r = mysql_fetch_object(mysql_query("SELECT * FROM epay_safetransfers WHERE id=".(int)$_GET['c']));
  list($uname) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$r->paidby"));
  transact(2,$r->paidto,$r->amount,"Safe transfer from $uname");
  mysql_query("DELETE FROM epay_safetransfers WHERE id=".(int)$_GET['c']);
}
elseif ($_GET['d'])
{
  $r = mysql_fetch_object(mysql_query("SELECT * FROM epay_safetransfers WHERE id=".(int)$_GET['d']));
  list($uname) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$r->paidto"));
  transact(2,$r->paidby,$r->amount,"Safe transfer return from $uname");
  mysql_query("DELETE FROM epay_safetransfers WHERE id=".(int)$_GET['d']);
}

$qr1 = mysql_query("SELECT * FROM epay_safetransfers");
while ($a = mysql_fetch_object($qr1))
{
  list($uname1) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidby"));
  list($uname2) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=$a->paidto"));
  echo "\n<TR>",
       "<TD><a href=right.php?a=user&id=$uname1&$id>$uname1</a>",
       "<TD><a href=right.php?a=user&id=$uname2&$id>$uname2</a>",
       "<TD>",prsumm($a->amount),
       "<TD>",
       "<a href=right.php?a=safetr&c=$a->id&$id>Confirm</a> ",
       "<a href=right.php?a=safetr&d=$a->id&$id>Return</a>";
}
if (!mysql_num_rows($qr1))
  echo "<TR><TD colspan=4>No current transfers.";
?>

</TABLE>
</CENTER>
