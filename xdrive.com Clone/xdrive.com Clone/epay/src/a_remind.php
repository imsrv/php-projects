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
	if ($_POST['remind']){
		$posterr = 0;
		// Check email
		$data = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE email='".addslashes($_POST['email'])."'"));
		if (!$data)
			errform('There are no accounts registered with the email address you specified.');
	}
	if ($_POST['remind'] && !$posterr){
		mail($_POST['email'], "$sitename Username and Password", 
		$emailtop.gettemplate('email_remindpsw', '', $data->username, $data->password).$emailbottom, 
		$defaultmail); 
		prpage('html_remindpsw');
	}else{
?>
	<BR>
	<CENTER>
	<TABLE class=design cellspacing=0>
	<FORM method=post>
	<TR>
		<TH colspan=2> Send Username and Password</TH>
	</TR>
	<TR>
		<TD>Enter your email:</TD>
		<TD><INPUT type=text name=email size=30 maxLength=30 value="<?=htmlspecialchars($_POST['email'])?>"></TD>
	</TR>
	<TR>
		<TH colspan=2 class=submit><INPUT type=submit class=button name=remind value='Submit >>'></TH>
		<?=$id_post?>
	</TR>
	</FORM>
	</TABLE>
	</CENTER>
<?
	}
?>