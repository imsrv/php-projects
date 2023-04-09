<table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="0" height="100%">
  <tr>
   <td height="18" align="center" bgcolor="<?php echo TABLE_EMPLOYER;?>"><font face="Verdana" size="2" color="#FFFFFF"><b><i><?php echo TEXT_RIGHT_EMPLOYER;?></i></b></font></td>
  </tr>
  <tr><td height="2">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="#000000" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
                </table>
       </td>
  </tr>
  <tr><td align="left" height="18" valign="top">
         <?php $tolog="employer"; include(DIR_FORMS."nav_login_form.php");?>
   </td></tr>
   <tr><td valign="top" height="18">&nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_HOME;?></a></td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY."?action=new", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_REGISTRATION;?></a>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_FORGOT_PASSWORD;?></a>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_MYCOMPANY;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY."?action=comp_form", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_MODIFY_PROFILE;?></a><br>
  </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_PLANNING;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_INVOICING;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_POST_JOB;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER."?action=job_form", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_ADD_JOB;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH."?search=resumes", "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_SEARCH_RESUMES;?></a><br>
   </td></tr>
   <tr><td valign="top" height="18">
      &nbsp;&nbsp;&nbsp;<a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, "auth_sess", $bx_session);?>" class="nav">&#171; <?php echo TEXT_ESUPPORT;?></a><br>
   </td></tr>
   <tr bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>">
         <td valign="top" height="18"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
   </tr>
   <TR><td>&nbsp;</td></tr>
</table>