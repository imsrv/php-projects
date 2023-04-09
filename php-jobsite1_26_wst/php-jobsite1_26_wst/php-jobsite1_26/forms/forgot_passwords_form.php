<?php
if($HTTP_GET_VARS['jobseeker']=="true")
{
   ?>
   <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS, "auth_sess", $bx_session);?>" method="post" name="bx_passwd_jobsk" onSubmit="return check_form(this.pers_email);">
   <input type="hidden" name="type" value="jobseeker">
   <input type="hidden" name="action" value="forgot_password">
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR>
        <TD colspan="2" align="center" valign="middle" width="100%" class="headertdjob"><?php echo TEXT_FORGOT_PASSWORD;?></FONT></TD>
    </TR>
    <tr><td colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
   </td></tr>
    <TR>
        <TD colspan="2" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_FORGOT_PASSWORD_HELP;?></SMALL></B></FONT></TD>
    </TR>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_EMAIL_ADDRESS;?>:</font></td>
     <td><input type="text" name="pers_email" size="30"></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/proceed.gif",0,TEXT_PROCEED);?></td>
   </tr>
   </table>
   </form>

<?php
}
if($HTTP_GET_VARS['employer']=="true")
{
 ?>
 <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?login=employer", "auth_sess", $bx_session);?>" method="post" name="bx_passwd_comp" onSubmit="return check_form(this.comp_email);"><center>
 <input type="hidden" name="type" value="employer">
 <input type="hidden" name="action" align="center" valign="center" value="forgot_password">
 <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">
     <TR>
        <TD colspan="2" align="center" valign="middle" width="100%" class="headertdjob"><?php echo TEXT_FORGOT_PASSWORD;?></FONT></TD>
    </TR>
     <tr><td colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_EMPLOYER;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
   </td></tr>
    <TR>
        <TD colspan="2" width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_FORGOT_PASSWORD_HELP;?></SMALL></B></FONT></TD>
    </TR>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EMAIL_ADDRESS;?>:</b></font></td>
     <td><input type="text" name="comp_email" size="30"></td>
   </tr>
  <tr>
      <td width="30%">&nbsp;</td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/proceed.gif",0,TEXT_PROCEED);?></td>
   </tr>
   </table>
 </center></form>
<?php
}
?>