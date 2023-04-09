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
$a = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($_REQUEST['id'])."'"));

if ($_POST['message'] && $a)
{
  mail($a->email, $_POST['subject'], $_POST['message'], $defaultmail2);
  die("Your email was sent.");
}
?>
<CENTER>
<TABLE class=design cellspacing=0>
<FORM method=post>

<TR><TH colspan=2>Send Email to Registered Member
<TR><TD>To:
	<TD>
	<b><?=$a->email?></b> (<?=$a->username?>)<BR>
	<?=htmlspecialchars($a->name)?>
<TR><TD>Subject:
	<TD><INPUT type=text size=30 name=subject>
<TR><TD>Message:
	<TD><TEXTAREA cols=60 rows=8 name=message><? echo $emailtop,($emailbottom ? "\n" : ""),$emailbottom; ?></TEXTAREA>
<TR><TH colspan=2>
    <INPUT type=submit value='Send Mail'>
</TH>
<?=$id_post?>
</FORM>
</TABLE>
</CENTER>
