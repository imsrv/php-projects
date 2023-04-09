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
if ($_POST['message']){
	if ($_POST['type'] == 'wm' || $_POST['type'] == 'pr'){
		$where = "WHERE type='{$_POST['type']}'";
	}else{
		$where = "WHERE type!='sys'";
	}
	$qr1 = mysql_query("SELECT email FROM epay_users $where");
	while ($a = mysql_fetch_object($qr1)){
		mail($a->email, $_POST['subject'], $_POST['message'], $defaultmail2);
	}
	die(mysql_num_rows($qr1)." messages were sent.");
}
?>
<CENTER>
<TABLE class=design cellspacing=0>
<FORM method=post>
<TR>
	<TH colspan=2>Mass Mailing
<TR>
	<TD>Subject:
	<TD><INPUT type=text size=30 name=subject>
<TR>
	<TD>Message:
	<TD><TEXTAREA cols=60 rows=8 name=message><? echo $emailtop,($emailbottom ? "\n" : ""),$emailbottom; ?></TEXTAREA>
<TR>
	<TH colspan=2><INPUT type=submit value='Post message'></TH>
</TR>
	<?=$id_post?>
</FORM>
</TABLE>
</CENTER>
