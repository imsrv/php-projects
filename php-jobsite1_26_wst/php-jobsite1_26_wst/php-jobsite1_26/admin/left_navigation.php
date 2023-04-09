<table width="100%" cellspacing="0" cellpadding="2">
 <tr>
   <td bgcolor="#000000" nowrap>
<table width="100%" border="0" bgcolor="#009191" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top" nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?> <a href="<?php echo HTTP_SERVER.FILENAME_INDEX;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Home</font></a></td>
  </tr>
  <tr>
    <td valign="top" nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?> <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Admin Home</font></a></td>
  </tr>
  <tr>
    <td valign="top" nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?> <a href="<?php echo HTTP_SERVER_ADMIN."admin_tips.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Admin Tips</font></a></td>
  </tr>
  <tr>
    <td valign="top" nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?> <a href="<?php echo HTTP_SERVER_ADMIN."admin_stat.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Admin Statistics</font></a></td>
  </tr>
  <?php if($HTTP_SESSION_VARS['adm_user']){?>
  <tr>
    <td valign="top" nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?> <a href="<?php echo HTTP_SERVER_ADMIN."logout.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Admin Logout</font></a></td>
  </tr>
  <?php }?>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
        <table bgcolor="#C0C0FF" width="100%"><tr><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Employers Section</b></font></td></tr></table>
        </td></tr></table>
     </td>
  </tr>
  <tr>
     <td nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?company=yes" onmouseover="window.status='Search companies'; return true;" onmouseout="window.status=''; return true;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Search companies</font></a><br>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?company=add" onmouseover="window.status='Add new Company'; return true;" onmouseout="window.status=''; return true;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Add new company</font></a><br>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?jobs=yes"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Search jobs</font></a><br>
    </td>
  </tr>
   <tr>
     <td nowrap>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?job=add" onmouseover="window.status='Add New Job'; return true;" onmouseout="window.status=''; return true;"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Add new job</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?invoices=yes"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Search invoices</font></a><br>
    </td>
  </tr>
    <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=companies"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Show companies</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=upgrades"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Show upgrades</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?action=buyers"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Show buyers</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=employers"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">All Employers</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_BULK_EMAIL;?>?mail=companies"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Bulk Email</font></a>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
        <table bgcolor="#C0C0FF" width="100%"><tr><td nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Jobseekers Section</b></font></td></tr></table>
        </td></tr></table>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?jobseekers=yes"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Search jobseekers</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?resumes=yes"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Search resumes</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN;?>?all=jobseekers"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">All Jobseekers</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_BULK_EMAIL;?>?mail=jobseekers"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Bulk Email</font></a><br>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
        <table bgcolor="#C0C0FF" width="100%"><tr><td nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Script Management</b></font></td></tr></table>
        </td></tr></table>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_LAYOUT;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Layout manager</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Script Settings</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_PAYMENT;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Payment Settings</font></a><br>
    </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Planning manager</font></a><br>
    </td>
  </tr>
  <?php if(ADMIN_SAFE_MODE != "yes") {?>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."timestat.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Log file statistics</font></a><br>
    </td>
  </tr>
  <?php }?>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_PASSWORD;?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Change admin password</font></a><br>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
        <table bgcolor="#C0C0FF" width="100%"><tr><td nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Database Management</b></font></td></tr></table>
        </td></tr></table>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."backup_db.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Backup database</font></a><br>
     </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."restore_db.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Restore database</font></a>
    </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."export_db.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Export database</font></a>
    </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."mysql_update.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Update database</font></a>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
         <table bgcolor="#C0C0FF" width="100%"><tr><td nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Multilanguage Support</b></font></td></tr></table>
         </td></tr></table>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."add_lng.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Add Language</font></a><br>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."edit_lng.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Edit Language</font></a><br>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."edit_mail.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Edit Email Messages</font></a><br>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Edit HTML Files</font></a><br>
     </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."del_lng.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Delete Language</font></a>
    </td>
  </tr>
  <tr>
     <td nowrap>
      <hr>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td bgcolor="#FFFFFF" nowrap>
        <table bgcolor="#C0C0FF" width="100%"><tr><td nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white"><b>Cron Jobs</b></font></td></tr></table>
        </td></tr></table>
     </td>
  </tr>
  <tr>
     <td>
      <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."job_cron.php?type=admin";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Expired jobs/plans</font></a>
     </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."jobmail_cron.php?type=admin";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Mailed jobs</font></a>
    </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."resumemail_cron.php?type=admin";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Mailed resumes</font></a>
   <hr>
   </td>
  </tr>
  <tr>
     <td>
     <?php echo bx_image(HTTP_IMAGES.$language."/bullet.gif",0,'');?>  <a href="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="white">Cross Network Options</font></a>
   </td>
  </tr>
  <tr>
     <td>

   <hr>
   </td>
  </tr>
</table>
</td></tr></table>