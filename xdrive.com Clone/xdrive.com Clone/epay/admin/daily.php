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
$qr = mysql_query("SELECT * FROM epay_users WHERE NOW()>DATE_ADD(lastlogin, INTERVAL ".($suspend_days - $suspend_notice)." DAY)");
while ($r = mysql_fetch_object($qr))
{
  $balance = balance($r->id);
  if ($balance >= 0) continue;
  $tr = (int)(strtotime(time() - $r->lastlogin) / 86400);
  if ($tr > $suspend_days)
  {
    mail($r->email, "$sitename Account Suspended", 
      $emailtop.gettemplate("email_suspend_warn", "$siteurl/{$r->type}.php?a=account", $balance, $suspend_notice).$emailbottom, 
    $defaultmail);
  }
  else
  {
    mail($r->email, "$sitename Account", 
      $emailtop.gettemplate("email_suspend", "$siteurl/{$r->type}.php?a=account", $adminemail, $suspend_days).$emailbottom, 
    $defaultmail);
  }
}
?>
