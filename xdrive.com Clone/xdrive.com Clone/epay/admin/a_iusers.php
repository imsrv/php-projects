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
<TABLE class=design width=100% cellspacing=0>
<TR><TH colspan=6>Inactive Users List
<TR><TH>Username
  <TH>Balance
  <TH>Name
  <TH>Email
  <TH>Last login
  <TH>&nbsp;

<?

$qr1 = mysql_query("SELECT * FROM epay_users WHERE NOW()>DATE_ADD(lastlogin, INTERVAL 1 MONTH) AND type!='sys'");
while ($a = mysql_fetch_object($qr1))
{
  echo "\n<TR>\n",
       "<TD><a href=right.php?a=user&id=$a->username&$id>$a->username</a>\n",
       "<TD>",prsumm(balance($a->id), 1),"\n",
       "<TD>",($a->name != '' ? htmlspecialchars($a->name) : "&nbsp;"),"\n",
       "<TD>$a->email (<a href=right.php?a=write&id=$a->username&$id>write</a>)\n",
       "<TD>",prdate($a->lastlogin),"\n",
       "<TD>&nbsp;";
  if ($a->special) echo "special ";
  if ($a->suspended) echo "suspended ";
}
if (!mysql_num_rows($qr1))
  echo "<tr><td colspan=6>No inactive users.";
?>

</TABLE>
