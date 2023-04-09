<?php include(DIR_LANGUAGES.$language."/".FILENAME_CONFIRM_JOB_DELETE_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR bgcolor="#FFFFFF">
      <TD colspan="5"  width="100%" align="center" class="headertdjob"><?php echo TEXT_DELETE_JOB;?></TD>
    </TR>
    <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
</td></tr>
<TR>
      <TD colspan="3" align="left" valign="top" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;&nbsp;&nbsp;&nbsp;<B><I><?php echo TEXT_CONFIRM_DELETE;?></B></I></FONT>
      </TD>
     </TR>
     <TR>
     <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post" name="deljob">
      <TD align="right" width="50%">
          <INPUT type="hidden" name="action" value="del_job">
          <INPUT type="hidden" name="confirmed" value="yes">
          <INPUT type="hidden" name="jobid" value="<?php echo $HTTP_POST_VARS['jobid'];?>">
          <INPUT type="submit" name="confirm" value=" <?php echo TEXT_YES;?> ">
      </FORM>
      </TD>
      <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post" name="deljob">
       <TD align="left" width="50%">
          <INPUT type="hidden" name="vconfirmed" value="no">
          <INPUT type="hidden" name="jobid" value="<?php echo $HTTP_POST_VARS['jobid'];?>">
          <INPUT type="submit" name="confirm" value="<?php echo TEXT_NO;?> ">
      </FORM>
      </TD>
    </TR>
</table>
</FORM>