<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,2,0,"alt1");?></td>
   </tr>
    <TR>
      <TD align="center" valign="middle" width="100%" colspan="2">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><I><?php echo TEXT_VIEWED_JOBS;?></I></B></FONT>
      </TD>
    </TR>
    <tr bgcolor="#000000">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"alt1");?></td>
   </tr>
   <TR bgcolor="#A9A9CC">
        <TD width="50%" align="center" class="verysmall"><b>&nbsp;<?php echo TEXT_JOB_TITLE;?>&nbsp;</B></TD>
        <TD width="50%" align="center" class="verysmall"><b>&nbsp;<?php echo TEXT_JOBS_VIEWED;?>&nbsp;</b></TD>
    </TR>
	<tr bgcolor="#000000">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"alt1");?></td>
   </tr>
  <?php
  $jobview_query=bx_db_query("select ".$bx_table_prefix."_jobs.jobid,".$bx_table_prefix."_jobs.jobtitle,".$bx_table_prefix."_jobview.viewed,".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobview where ".$bx_table_prefix."_jobs.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_jobs.jobcategoryid=".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid and ".$bx_table_prefix."_jobview.jobid=".$bx_table_prefix."_jobs.jobid");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  if (bx_db_num_rows($jobview_query)!=0) {
   while ($jobview_result=bx_db_fetch_array($jobview_query)) {
     ?>
     <TR>
      <TD width="50%" align="center">
       <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$jobview_result['jobid']."&employer=yes", "auth_sess", $bx_session);?>" style="font-size: 9px;"><?php echo $jobview_result['jobtitle'];?></a></font>
       </TD>
      <TD width="50%" align="center">
       <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo $jobview_result['viewed'];?></b></font>
      </TD>
      </TR>
     <?php
    }//end while ($jobview_result=bx_db_fetch_array($jobview_query))
  }//end if (bx_db_num_rows($jobview_query)!=0)
  else {
     ?>
      <TR><TD colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_NO_JOBVIEW;?></b></font></TD></TR>
     <?php
  }//end else if (bx_db_num_rows($jobview_query)!=0)

?>
<tr><td colspan="2">&nbsp;</td></tr>
<tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,2,0,"alt1");?></td>
</tr>
</table>