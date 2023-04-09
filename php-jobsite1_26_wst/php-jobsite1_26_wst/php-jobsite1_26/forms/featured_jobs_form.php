<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR>
      <TD colspan="2"  width="100%" align="center" class="headertdjob"><?php echo ucfirst(TEXT_FEATURED_JOBS);?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
</TR>
<tr>
    <td width="100%">
      <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="15%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
            <B>&nbsp;<?php echo TEXT_POST_DATE;?>&nbsp;</B></font></td>
            <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
            <b>&nbsp;<?php echo TEXT_TITLE;?>&nbsp;</b></font></td>
            <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
            <b>&nbsp;<?php echo TEXT_JOBCATEGORY;?>&nbsp;</b></font></td>
            <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
            <b>&nbsp;<?php echo TEXT_LOCATION;?>&nbsp;</b></font></td>
        </tr>
<?php
$array_jobs=array();
if (FEATURED_ORDER==1 || FEATURED_ORDER==2) {
    $query = "SELECT ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory as jobcategory,".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.jobdate, ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_jobs.jobid, concat(if (".$bx_table_prefix."_jobs.city='','',concat(".$bx_table_prefix."_jobs.city, ' - ')),if (".$bx_table_prefix."_jobs.province='','', concat(".$bx_table_prefix."_jobs.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location FROM ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs, ".$bx_table_prefix."_locations_".$bx_table_lng.",".$bx_table_prefix."_companies WHERE ".$bx_table_prefix."_jobs.featuredjob='y' and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid=".$bx_table_prefix."_jobs.jobcategoryid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid";
    srand((double)microtime()*1000000); // seed the random number generator
    if (FEATURED_ORDER==2) {
            $array_date=array();
            $array_ordjobs=array();
    }
}
else {
    $query = "SELECT ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory as jobcategory,".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.jobdate, ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_jobs.jobid, concat(if (".$bx_table_prefix."_jobs.city='','',concat(".$bx_table_prefix."_jobs.city, ' - ')),if (".$bx_table_prefix."_jobs.province='','', concat(".$bx_table_prefix."_jobs.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location FROM ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs, ".$bx_table_prefix."_locations_".$bx_table_lng.",".$bx_table_prefix."_companies WHERE ".$bx_table_prefix."_jobs.featuredjob='y' and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid=".$bx_table_prefix."_jobs.jobcategoryid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc";
    
}
   $empty=0;
   $result_featured_jobs=bx_db_query($query);
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $count_jobs=bx_db_num_rows($result_featured_jobs);
   if ($count_jobs!=0)
    {
              if ($count_jobs>=FEATURED_JOBS_NUMBER) {
                   $number_random=FEATURED_JOBS_NUMBER;
              }
              else {
                   $number_random=$count_jobs;
              }
              for($j=0;$j<$number_random;$j++) {
                       $rand_row = @rand(0, ($count_jobs - 1));
                       $exist=random_once($array_jobs,$rand_row);
                       if($exist!=1) {
                          $array_jobs[$j]=$rand_row;
                       }
                       else {
                           $j--;
                       }
               }
               if (FEATURED_ORDER==1) {
                  
               }
               elseif (FEATURED_ORDER==2) {
                   $j=0;
                   while($j<sizeof($array_jobs))            
                        {
                          $job=bx_db_data_seek($result_featured_jobs, $array_jobs[$j]);
                          $result_jobs=bx_db_fetch_array($result_featured_jobs);
                          $array_date[$array_jobs[$j]] =$result_jobs['jobdate']; 
                          $j++;
                        } 
                        arsort($array_date);
                        while(list($key)=each($array_date)) {
                                $array_ordjobs[]=$key;    
                        }
                        $array_jobs=$array_ordjobs;
               }
               else {
                      for($j=0;$j<$number_random;$j++) {
                          $array_jobs[$j]=$j;
                      }
               }
               
       }
       else {
           $empty=1;
       }
       $j=0;
       if($empty!=1) {
            while($j<sizeof($array_jobs))            //$jobs=bx_db_fetch_array($result_featured_jobs)
            {
              $rows++;
              $job=bx_db_data_seek($result_featured_jobs, $array_jobs[$j]);
              $result_jobs=bx_db_fetch_array($result_featured_jobs);
              ?>
              <tr <?php if(floor($rows/2) == ($rows/2)) {
                    echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
                     } else {
                    echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
                     }?>>
                       <td align="left" width="15%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_date($result_jobs['jobdate'], DATE_FORMAT);?></font></td>
                       <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>"><?php echo $result_jobs['jobtitle'];?></a></font></td>
                       <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>"><?php echo $result_jobs['jobcategory'];?></a></font></td>
                       <td width="28%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $result_jobs['location'];?></font></td>
              </tr>
              <?php
              if($j==FEATURED_JOBS_NUMBER) {
                  break;
              }
              $j++;
            }
          }//end if empty
          else {
          ?>
              <TR bgcolor="<?php echo TABLE_FEATURED_BGCOLOR;?>">
               <TD colspan="4" align="center" valign="middle"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FF0000"><b><?php echo TEXT_NO_FEATURED_JOB;?></b></font></TD>
              </TR>
          <?php
          }
          ?>
     </table>
    </td>
    </tr>
    </table>
</td>
</tr>
</table><br>