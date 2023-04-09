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

if ($_POST['change2'] && $action == 'config')
{
  $a_int = array(
    'att_max_size', 'max_feedback_len', 'max_comment_len', 'suspend_days', 'suspend_notice',
    'ulist_page','cobrand',
	'special_levels','sortprojects','securelogin'
  );
  $a_string = array(
    'sitename', 'siteurl', 'superpass', 'att_path', 'bkp_path', 'adminemail', 'replymail'
  );
  $a_check = array(
    'cat_multi', 'att_enable', 'allow_same_email', 'dep_notify', 'wdr_notify',
    'display_categories', 'featured_show_all','useturingnumber','allow_same_ip'
  );
  $a_textarea = array(
    'emailtop', 'emailbottom'
  );
  
  $str = "<?\n";
  while ($a = each($_POST))
  {
    if (substr($a[0], 0, 9) == 'separator')
      $str .= "\n// $a[1]\n";
    elseif (in_array($a[0], $a_int))
      $str .= '$'."{$a[0]} = ".(int)$a[1].";\n";
    elseif (in_array($a[0], $a_string))
      $str .= '$'."{$a[0]} = \"".preg_replace("/[\"\\\\]/", "\\\\\\0", $a[1])."\";\n";
    elseif (in_array($a[0], $a_check))
      $str .= '$'."{$a[0]} = ".($a[1] ? '1' : '0').";\n";
    elseif (in_array($a[0], $a_textarea))
      $str .= '$'."{$a[0]} = \"".str_replace(array("\r","\n"), array("","\\n"), preg_replace("/[\"\\\\]/", "\\\\\\0", $a[1]))."\";\n";
  }
  $str .= "\n?>";

  $f = fopen("config.php", "w");
  if ($f)
  {
    fwrite($f, $str);
    fclose($f);
    echo "<div style='color: red;'>Update variables successful.</div><br>";
  }
  else
    echo "<div style='color: red;'>Update variables failed. Check write permissions for file \"config.php\".</div><br>";
  
  include("config.php");
}

?>
<TABLE class=design width=100% cellspacing=0>

<!-- SITE -->
<TR><TH colspan=2>Site Options, General<input type=hidden name=separator1 value="SITE">
<TR><TD width=60%><b>Site Name</b> - Your website Title (e.g. "epay")
	<TD><input type=text size=40 name=sitename value="<?=htmlspecialchars($sitename)?>">
<TR><TD><b>Site URL</b> - Your site URL. Must include "http://" in the beginning and must not include trailing slash. (e.g. "http://www.epay.com")</TD>
	<TD><input type=text size=40 name=siteurl value="<?=htmlspecialchars($siteurl)?>"></TD></TR>
<TR><TD><b>Admin Email Address</b> - Main admin's email address. Notifications about money transfers will be sent to this address.</TD>
	<TD><input type=text size=40 name=adminemail value="<?=htmlspecialchars($adminemail)?>"></TD></TR>
<TR><TD><b>Email Auto Replies</b> - Reply-To email for some outgoing letters. This should be some ficticious "drop" mailbox (e.g. donotreply@donotreply.com).</TD>
	<TD><input type=text size=40 name=replymail value="<?=htmlspecialchars($replymail)?>"></TD></TR>
<TR><TD><b>Admin Panel Password</b> - Administration password. This password will be used to access the administration part of the site. To change it just enter one that you will easily remember and click "Update Variables" below. <b>NOTE:</b> Same username (e.g. admin/admin) will allow you to login and administer user interface.
	<TD><input type=text size=40 name=superpass value="<?=htmlspecialchars($superpass)?>">
<!------///////////////--->
<TR><TH colspan=2>Site Options, Other</TH> </TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Upload Directory</b> - Path where uploaded files are stored. It should exist and should have write permissions (CHMOD 777) for PHP. Default: "files/"</TD>
	<TD><input type=text size=40 name=att_path value="<?=htmlspecialchars($att_path)?>"></TD></TR>
<TR><TD><b>Backup Site</b> - Path to backup files are stored. It should exist and should have write permissions (CHMOD 777) for PHP. Default: "backup/"</TD>
	<TD><input type=text size=40 name=bkp_path value="<?=htmlspecialchars($bkp_path)?>"></TD></TR>
<TR><TD><b>Use Turing Number</b> - Use a Turing Number on Signup. <br><FONT COLOR="#008000"><b>We Recommend: Enable</b></TD>
	<TD><input type=checkbox class=checkbox name=useturingnumber value=1 <? if ($useturingnumber) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Suspensions</b> - Number of days before suspending an account. The account will become suspended if a user has negative summ of money in his account and he doesn't deposit the money in the specified amount of days. Default: "30"</TD>
	<TD><input type=text size=10 name=suspend_days value="<?=htmlspecialchars($suspend_days)?>"></TD></TR>
<TR><TD><b>Suspension Notice</b> - When to send account suspension notification. If you specify, for expample "3", then a user will receive 3 letters, one each day, before account suspension. Default: "5"</TD>
	<TD><input type=text size=10 name=suspend_notice value="<?=htmlspecialchars($suspend_notice)?>"></TD></TR>
<TR><TD><b>IP Address - Multiple Accounts</b> - Allow to register multiple accounts with one IP address. <br><FONT COLOR="#008000"><b>We Recommend: Disable</b></TD>
	<TD><input type=checkbox class=checkbox name=allow_same_ip value=1 <? if ($allow_same_ip) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Email - Multiple Accounts</b> - Allow to register multiple accounts with one email address. <br><FONT COLOR="#008000"><b>We Recommend: Disable</b></TD>
	<TD><input type=checkbox class=checkbox name=allow_same_email value=1 <? if ($allow_same_email) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Allow Secure Login</b> - Allows you to set the admin part of your side to allow only one administrator to be logged in to a time. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=securelogin value=1 <? if ($securelogin) echo 'checked'; ?>></TD></TR>
<!------///////////////--->
<TR><TH colspan=2>Admin E-Mail options <input type=hidden name=separator3 value="EMAIL"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Header</b> - Header for all outgoing letters. If you want to separate header from message text, hit enter at the bottom line.</TD>
	<TD><textarea name=emailtop cols=45 rows=6><?=htmlspecialchars($emailtop)?></textarea></TD></TR>
<TR><TD><b>Footer</b> - Footer for all outgoing letters. If you want to separate message text from footer, hit enter at the top line.</TD>
	<TD><textarea name=emailbottom cols=45 rows=6><?=htmlspecialchars($emailbottom)?></textarea></TD></TR>

<!------///////////////--->
<TR><th colspan=2 class=submit><input type=submit name=change2 value="Update variables">
<!------\\\\\\\\\\\\\\\--->
</TD></TR>
</TABLE>

</TD>
