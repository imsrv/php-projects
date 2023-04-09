<table width="100%" align="center" border="0" bgcolor="<?php echo TABLE_BGCOLOR;?>" cellspacing="0" cellpadding="0">
  <tr>
       <td width="5%">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
       <?php
       $jobseeker_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_persons.persid) from ".$bx_table_prefix."_persons");
       $jobseeker_result=bx_db_fetch_array($jobseeker_query);
       ?>
       <td width="2%" align="center" nowrap><font face="Verdana" size="1" color="<?php echo STAT_FONT_COLOR;?>"><b>&nbsp;<?php echo strtolower(TEXT_JOBSEEKERS);?>:<?php echo $jobseeker_result[0];?>&nbsp;</b></font></td>
       <td width="10%">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
              <?php
       $employers_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_companies.compid) from ".$bx_table_prefix."_companies");
       $employers_result=bx_db_fetch_array($employers_query);
       ?>
       <td width="2%" align="center" nowrap><font face="Verdana" size="1" color="<?php echo STAT_FONT_COLOR;?>"><b>&nbsp;<?php echo strtolower(TEXT_EMPLOYERS);?>:<?php echo $employers_result[0];?>&nbsp;</b></font></td>
       <td width="10%">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
       <?php
       $resumes_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_resumes.resumeid) from ".$bx_table_prefix."_resumes where 1=1 ".((HIDE_RESUME=="yes")?" and ".$bx_table_prefix."_resumes.confidential!='1'":"").((RESUME_EXPIRE == "yes")?" and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)>= TO_DAYS(NOW())":""));
       $resumes_result=bx_db_fetch_array($resumes_query);
       ?>
       <td width="2%" align="center" nowrap><font face="Verdana" size="1" color="<?php echo STAT_FONT_COLOR;?>"><b>&nbsp;<?php echo strtolower(TEXT_RESUMES);?>:<?php echo $resumes_result[0];?>&nbsp;</b></font></td>
       <td width="10%">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
       <?php
       $jobs_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_jobs.jobid) from ".$bx_table_prefix."_jobs");
       $jobs_result=bx_db_fetch_array($jobs_query);
       ?>
       <td width="2%" align="center" nowrap><font face="Verdana" size="1" color="<?php echo STAT_FONT_COLOR;?>"><b>&nbsp;<?php echo strtolower(TEXT_JOBS);?>:<?php echo $jobs_result[0];?>&nbsp;</b></font></td>
       <td width="10%">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
       <?php
       if (MULTILANGUAGE_SUPPORT == "on") {
           $dirs = getFiles(DIR_FLAG);
           for ($i=0; $i<count($dirs); $i++) {
                if (eregi(".gif|jpg|png|jpeg",$dirs[$i],$rrr) && $dirs[$i]!="index.html" && $dirs[$i]!="index.htm") {
                    $lngname = split("\.",$dirs[$i]);
                    echo "<td width=\"2%\"><a href=\"http://".bx_make_url(bx_make_url($HTTP_SERVER_VARS['HTTP_HOST'].$HTTP_SERVER_VARS['REQUEST_URI'],"language",urlencode($lngname[0])), "auth_sess", $bx_session)."\" onmouseover=\"window.status='".TEXT_BROWSE_IN." ".$lngname[0]."'; return true;\" onmouseout=\"window.status=''; return true;\">".bx_image(HTTP_FLAG.$dirs[$i],0,$lngname[0])."</a>".bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"")."</td>";
                }     
           }
           ?>
           <td width="10%">
           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                    </tr>
           </table>
           </td>
           <td width="2%" align="center" nowrap><font face="Verdana" size="1" color="<?php echo STAT_FONT_COLOR;?>"><b>&nbsp;<?php echo strtolower(TEXT_LANGUAGE);?>:<?php echo $language;?>&nbsp;</b></font></td>
           <td width="5%">
           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td bgcolor="<?php echo STAT_FONT_COLOR;?>" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                    </tr>
           </table>
           </td>
       <?php
       }        
       ?>
  </tr>
</table>