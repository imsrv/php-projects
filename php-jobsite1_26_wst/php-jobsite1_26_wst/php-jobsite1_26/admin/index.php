<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
if ($HTTP_GET_VARS['showtips']=="no") {
   setcookie("bx_showtips", "no", mktime(0,0,0,date('m'),date('d'),date('Y')+5));
}
include("header.php");
if (DEBUG_MODE=="yes") {?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
     <tr>
             <td>
             <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#EFEFEF" style="border: 1px solid #000000;">
             <tr>
                 <td bgcolor="#BBBBBB"><font color="#FF0000">&nbsp;<b>Important Admin Note!</b></font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;<b><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#DEBUG_MODE" style="color: #FF0000; font-size: 14px;">DEBUG MODE</a></b> is <b>ON</b>!</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;Please set <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#DEBUG_MODE" style="color: #FF0000; font-size: 14px;">DEBUG MODE</a> to <b>no</b> when you finished debuging.</td>
             </tr>       
            </table>
            </td>
     </tr>
     </table>
<?php
}
if (TEST_MODE=="yes") {?>
    <table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
     <tr>
             <td>
             <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#EFEFEF" style="border: 1px solid #000000;">
             <tr>
                 <td bgcolor="#BBBBBB"><font color="#FF0000">&nbsp;<b>Important Admin Note!</b></font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;<b><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#TEST_MODE" style="color: #FF0000; font-size: 14px;">TEST MODE</a></b> is <b>ON</b>!</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;Please set <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#TEST_MODE" style="color: #FF0000; font-size: 14px;">TEST MODE</a> to <b>no</b> when you finished testing the Jobmail/Resumemail and Expired jobs plannings.</td>
             </tr>       
            </table>
            </td>
     </tr>
     </table>
<?php
}
if ($HTTP_COOKIE_VARS['bx_showtips']!="no" && $HTTP_GET_VARS['showtips']!="no") {
    srand((double)microtime()*1000000); // seed the random number generator
    $rand_num = @rand(1, 11);
    include(DIR_ADMIN."admin_tips_form.php");
}
?>
<table bgcolor="#DBEEEE" border="0" cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #000000">
     <tr>
      <td width="100%" align="center" valign="top">
	  <font face="Arial" size="5" color="#0073AA"><b><i>Welcome to <?php echo SITE_TITLE;?> Admin Area</i></b></font>
      </td>
	 </tr>
	 <tr>
	  <td>
	  &nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000" size="2"><b>The admin area contains some sections...</b></font>
 <br><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Employers section:</b></font><ul>
<li><span class="smallbold">Search companies</span> - <span class="text">Search for registered companies by email address name or location.</span></li>
<li><span class="smallbold">Search jobs</span> - <span class="text">Search for posted jobs by "job title" or job category.</span></li>
<li><span class="smallbold">Search invoices</span> - <span class="text">Search for invoices by invoice ID or planning type.</span></li>
<li><span class="smallbold">Show companies</span> - <span class="text">List companies by Planning type criteria. Good for jobsite statistics.</span></li>
<li><span class="smallbold">Show upgrades</span> - <span class="text">List the last planning (membership) upgrade effectuated by employers which are waiting for admin validation (not credit-card payment). Will be validated when the admin receive the payment.</span></li>
<li><span class="smallbold">Show buyers</span> - <span class="text">List the last jobs (featured jobs or resume consulting) purchase effectuated by employers which are waiting for admin validation (not credit-card payment).  Will be validated when the admin receive the payment.</span></li>
<li><span class="smallbold">All employers</span> - <span class="text">Show a briefly statistics with the currently registered companies, their jobs, featured jobs, resume consulting possibilities, and email address.</span></li>
<li><span class="smallbold">Bulk Email</span> - <span class="text">Here the admin can send a message for all registered companies(employers) </span></li>
</ul><br>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Jobseekers section:</b></font><ul>
<li><span class="smallbold">Search jobseekers</span> - <span class="text">Search for registered jobseekers by email address name or location.</span></li>
<li><span class="smallbold">Search resumes</span> - <span class="text">Search for jobseeker's resumes by "resume title" or resume category name.</span></li>
<li><span class="smallbold">All Jobseekers</span> - <span class="text">Show a briefly statistics with the currently registered jobseekers, their name location email address</span></li>
<li><span class="smallbold">Bulk Email</span> - <span class="text">Here the admin can send a message for all registered jobseekers</span></li></ul><br>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Script management:</b></font><ul>
<li><span class="smallbold">Layout manager</span> - <span class="text">Here the admin can make some changes to the script design (layout), with a preview, and save possibilities.</span></li>
<li><span class="smallbold">Script settings</span> - <span class="text">Here the admin can make changes to the script default settings, like number of items in listings, session expire, company info, payment info, etc.</span></li>
<li><span class="smallbold">Payment settings</span> - <span class="text">Here the admin can make changes to the script default payment settings, Credit Card processing, invoice and related stuff, like what Credit Card gateaway to use, and set his configuration options.</span></li>
<li><span class="smallbold">Planning manager</span> - <span class="text">Here the admin can make changes to the planning, prices, periods etc.. Add/edit/delete plans, also can set the default planning (membership)</span></li>
<li><span class="smallbold">Log file statistics</span> - <span class="text">Showing the number of hits, compilation time statistics, detailed statistics (host, browser agent, date, url), empty log file, download log file.</span></li>
<li><span class="smallbold">Change admin password</span> - <span class="text">Here the admin can change the password to the script admin area.</span></li></ul><br>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Database management:</b></font><ul>
<li><span class="smallbold">Backup database</span> - <span class="text">Backup your database (all information saved in the database) to your local hard-drive, or backup drive(a file is generated with the database information). Making this operation often, even your server had a crash (sometimes can happen, a hardware problem etc) you can easily restore the information to your database with insignificant loss.</span></li>
<li><span class="smallbold">Restore database</span> - <span class="text">Restore the database from the backup. (You have to upload the file generated by the backup database process). </span></li></ul><br>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Multilanguage support:</b></font><ul>
<li><span class="smallbold">Add Language</span> - <span class="text">Here the admin can add a new language. To add a new language he has to select a base language which words and phrases will be copied in the new language, unchanged, and then editing the new language ("Edit language"), those words and phrases have to be translated.</span></li>
<li><span class="smallbold">Edit language</span> - <span class="text">Here the admin can edit the language specific information, saved in files, images or in the database. Can edit the language words/phrases, job categories, employment-types, degrees, jobmail option, language options, language images.</span></li>
<li><span class="smallbold">Edit Email Messages</span> - <span class="text">Here the admin can edit the language specific email messages which the system is sending, like registration confirmation, job expiration, apply online, email job to a friend, etc...</span></li>
<li><span class="smallbold">Delete language</span> - <span class="text">Here the admin can delete the unused languages.</span></li></ul><br>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo bx_image(HTTP_IMAGES.$language."/adminbullet.gif",0,'');?>&nbsp;&nbsp;<font color="#0073AA"><b>Cron jobs:</b></font><ul>
 <span class="text">These are the script which have to be run once a day. In Unix system by crontab, in Windows by Task Scheduler, or any other schedulers.</span>
<li><span class="smallbold">Expired jobs</span> - <span class="text">Jobs that reached their expiration date, will be deleted. Employers Memebership/Planning that reached their expiration date, will be deleted.</span></li>
<li><span class="smallbold">Mailed jobs (job-mail)</span> - <span class="text">Will send emails to those jobseekers which resumes match with one or more newly posted jobs.</span></li>
<li><span class="smallbold">Mailed resumes (resume-mail)</span> - <span class="text">Will send emails to those employers which jobs match with one or more newly posted resumes.</span></li>
</ul><br>
</span>
      </td>
     </tr>
</table>
<?php include("footer.php");?>