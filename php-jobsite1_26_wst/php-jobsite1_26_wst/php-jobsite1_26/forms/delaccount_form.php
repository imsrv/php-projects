<?php include(DIR_LANGUAGES.$language."/".FILENAME_DELACCOUNT_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
   <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_DELETE_ACCOUNT_CONFIRMATION;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
</table>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_DELACCOUNT, "auth_sess", $bx_session);?>" method="post" name="delaccount">
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">
  <INPUT type="hidden" name="action" value="delaccount">
  <?php
  if ($HTTP_GET_VARS['jobseeker'] == "true" && $HTTP_SESSION_VARS['userid']) {
  ?>
  <INPUT type="hidden" name="type" value="jobseeker">  
  <tr>
        <TD width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_DELETE_JOBSEEKER_ACCOUNT_NOTE;?></font></TD>
  </tr>
  <?php
  }
  if ($HTTP_GET_VARS['employer'] == "true" && $HTTP_SESSION_VARS['employerid']) {
  ?>
  <INPUT type="hidden" name="type" value="employer">  
  <tr>
       <TD width="100%"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_DELETE_EMPLOYER_ACCOUNT_NOTE;?></font></TD>
  </tr>
  <?php
  }
  ?>
  <tr>
         <TD width="100%" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_DELETE_SURE;?></b></font></TD>
  </tr>
  <tr>
         <TD width="100%" align="center"><input type="submit" name="yes" value="<?php echo TEXT_YES?>" onClick="return confirm('<?php echo eregi_replace('"','&#034;',eregi_replace("'","\\'",TEXT_DELETE_SURE));?>');">&nbsp;&nbsp;<input type="submit" name="no" value="<?php echo TEXT_NO;?>"></TD>
  </tr>
</table>
</FORM>