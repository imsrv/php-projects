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
$email = array(
  "email_remindpsw" => "Email sent when a member requests his username and password.\n\n[info] = username\n[addinfo] = password",
  "email_signup" => "Email with URL leading to Step 2 of signup process.\n\n",
  "email_edit" => "Email with URL designated for members email change confirmation.\n\n",
  "email_suspend_warn" => "Email sent if a user has negative balance and does not login into his account for a long time.\n\n[info] = balance\n[addinfo] = days left",
  "email_suspend" => "Email sent to a user when his account gets suspended due to negative balance.\n\n[info] = admin email\n[addinfo] = inactive days"
);
$funds = array(
  "reqpay_unknown" => "Email sent to an unknown user when a request for money is made\n\n",
  "reqpay_email" => "Email sent to an $sitename member when a request for money is made\n\n",
  "transfer_unknown" => "Email sent to an unknown user when money is sent to them\n\n",
  "transfer_email" => "Email sent to an $sitename member when money is sent to them\n\n" 
);
$html = array(
  "html_remindpsw" => "Page displayed when a member requests his username and password.\n\n",
  "html_signup" => "Page displayed when a user completes Step 1 of signup process.\n\n",
  "html_edit" => "Page displayed when a member changes his email address.\n\n"
);
$email_adm = array(
  "email_new_user" => "Email sent to admin when a new user signs up.\n\n[info] = user email",
);
if($charge_signup){
	$billing = array(
		"signup_fee" => "Email sent when a user signs up if sign up fee is selected",
		"invoice" => "Email sent when a user does a transaction",
		"receipt" => "Email sent when a user does a transaction"
	);
}else{
	$billing = array(
		"invoice" => "Email sent when a user does a transaction",
		"receipt" => "Email sent when a user does a transaction"
	);
}

function generate_group($group, $title)
{
  global $GLOBALS;
  echo "<TR><TH colspan=2>$title\n";
  reset($GLOBALS[$group]);
  while ($a = each($GLOBALS[$group]))
  {
    list($value) = mysql_fetch_row(mysql_query("SELECT title FROM epay_templates WHERE id='$a[0]'"));
    echo "<TR>\n",
         "<TD valign=top><B>$a[0]</B><BR>",
         "<small>",nl2br($a[1]),"</small>\n",
         "<TD><TEXTAREA cols=70 rows=5 name=$a[0]>",htmlspecialchars($value),"</TEXTAREA>";
  }
}

function update_group($group)
{
  global $GLOBALS, $_POST;
  while ($a = each($GLOBALS[$group]))
    mysql_query("UPDATE epay_templates SET title='".addslashes($_POST[$a[0]])."' WHERE id='$a[0]'");
}

if ($_POST['change1'])
{
  update_group("email");
  update_group("html");
  update_group("email_adm");
  update_group("funds");
  update_group("billing");
}

?>

<small>
Strings in square will be replaced with appropriate values. The following patterns are supported:
<li>[sitename] - Site Mame</li>
<li>[siteurl] - Site's URL</li>
<li>[username] - Current member's name</li>
<li>[usersite] - Current member's site name</li>
<li>[account] - Link to member's account, makes sense only in page templates</li>
<li>[project] - Link to project page, makes sense only in some page templates</li>
<li>[board] - Link to message board, makes sense only in some page templates</li>
<li>[url] - Link to related content, makes sense only in some page templates</li>
<li>[info] - Some information, content differs for each template</li>
<li>[addinfo] - Additional information, content differs for each template</li>
<br>
</small>

<TABLE class=design width=100% cellspacing=0>

<?
generate_group("email", "Common email templates");
generate_group("html", "Common page templates");
generate_group("email_adm", "Admin email templates");
generate_group("funds", "Email templates when money is requested / sent");
generate_group("billing", "invoice / receipt templates");
?>

<TR><TH colspan=2><INPUT type=submit name=change1 value="Update templates">

</TABLE>
