<?
/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/
require('header_inc.php');
require('error_inc.php');
require('config_inc.php');
if($REQUEST_METHOD=="POST"){
	if(isset($add)){      
		@mail($admin_mail,"Abuse","Site id: ".$id." 
Site URL: ".$url."
Reason: ".$Abuse.$other."
Reporting id: ".$idu,"From: $support_email");
?>
Thank you abuse was send to admin.
<?
	}
}else{
?> 
        <table border="0" cellpadding="5" cellspacing="5" width="100%">
          <tr>
                
            <td> 
		<font size="2" face="Verdana">
	<TABLE valign="center">
  	<TR>
    	<TD vAlign=bottom><BR><BR>Are you sure that you want to report<BR>this 
	      site for not complying with AutoHits's rules?<BR><BR>
	      <FORM action="" method=post>
		<INPUT type=radio value="has pop up or exit pop up from the previous site" name=Abuse>Yes, it has pop up or exit pop up from the previous site<BR>
		<INPUT type=radio value="has dialog boxes" name=Abuse>
		Yes,it has dialog boxes<BR>
		<INPUT type=radio value="has inappropriate content or is an adult site" name=Abuse>
		Yes, it has inappropriate content or is an adult site<BR>
		<INPUT type=radio value="has an adult banner" 
	      name=Abuse>Yes, it has an adult banner<BR>
		<INPUT type=radio value="breaks out of frames" 
	      name=Abuse>Yes, it breaks out of frames<BR>
		<INPUT type=radio value="ses site rotation" 
	      name=Abuse>Yes, it uses site rotation<BR>
		<INPUT type=radio value="uses URL forwarding" 
	      name=Abuse>Yes, it uses URL forwarding<BR>
		<INPUT type=radio value="" 
	      name=Abuse>Yes, (please indicate)
		<INPUT name=other><BR><INPUT type=submit name=add value="Report the site"> </FORM>
	</TD></TR></TABLE>
		</font>
              </td>
              </tr>
            </table>
              </td>
<?
}
require('footer_inc.php');
?>
