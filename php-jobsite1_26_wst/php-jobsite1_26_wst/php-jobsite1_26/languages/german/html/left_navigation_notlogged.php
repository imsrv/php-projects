<table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="0" height="100%">
  <tr>
   <td align="center" height="18" bgcolor="<?php echo TABLE_JOBSEEKER?>" valign="top"><font face="Verdana" size="2" color="#FFFFFF"><b><i><?php echo TEXT_LEFT_JOBSEEKER;?></i></b></font></td>
  </tr>
  <tr><td height="2" valign="top">
         <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="#000000" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
        </table>
        </td>
  </tr>
  <tr>
      <td height="18" valign="top">
     <?php $tolog="jobseeker"; include(DIR_FORMS."nav_login_form.php");?>
      </td>
  </tr>
  <tr><td height="18" valign="top">&nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_HOME;?></a></td></tr>
  <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL."?action=new", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_REGISTRATION;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_FORGOT_PASSWORD;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_JOBMAIL;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL."?action=pers_form", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_MYACCOUNT;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_SEEKER, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo ($HTTP_SESSION_VARS['post_resumeid'])?TEXT_MODIFY_RESUME:TEXT_POST_RESUME;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
       &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH."?search=job", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_SEARCH_JOB;?></a>
   </td></tr>
   <tr><td height="18" valign="top">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_JSUPPORT;?></a>
   </td></tr>
   <tr>
         <td height="18" valign="top">&nbsp;</td>
   </tr>
  <TR>
   <TD height="18" valign="top">
    <?php include(DIR_FORMS."quick_job_search_form.php");?>
   </TD>
  </TR>
  <TR>
   <TD height="18" valign="top">
    <?php include(DIR_FORMS."featured_companies_jobs_form.php");?>
   </TD>
  </TR>  
  <TR><td>&nbsp;</td></tr>
</table>