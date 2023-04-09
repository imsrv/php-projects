<?php include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);
function bx_js_prepare($l_str){
    $l_str = eregi_replace("\015\012|\015|\012", ' ', $l_str);
    $l_str = eregi_replace("'","&#039;",$l_str);
    $l_str = eregi_replace("\\\\","\\\\",$l_str);
    return $l_str;
}
header("Content-type: text/html");?>
if (!pjs_titleBGColor) {
    var pjs_titleBGColor='<?php echo TABLE_BGCOLOR;?>';
}
if (!pjs_title) {
    var pjs_title='<b><?php echo bx_js_prepare(ucfirst(TEXT_FEATURED_JOBS));?> - <a href="<?php echo bx_js_prepare(HTTP_SERVER);?>"><?php echo bx_js_prepare(SITE_NAME);?></a></b>';
}
if (!pjs_bigFont) {
    var pjs_bigFont='<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">';
}
if (!pjs_headerFont) {
    var pjs_headerFont='<font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">';
}
if(!pjs_borderColor){
    var pjs_borderColor='<?php echo LIST_BORDER_COLOR;?>';
}
if(!pjs_headerBGColor){
    var pjs_headerBGColor='<?php echo LIST_HEADER_COLOR;?>';
}
if (!pjs_rowBGColor1) {
    var pjs_rowBGColor1='<?php echo DISPLAY_LINE_BGCOLOR_FIRST;?>';
}
if (!pjs_rowBGColor2) {
    var pjs_rowBGColor2='<?php echo DISPLAY_LINE_BGCOLOR_SECOND;?>';
}
if (!pjs_linkStyle) {
    var pjs_linkStyle='style="color: #0000FF; font-size: 12px; font-weight: normal;"';
}
document.write('<table width="100%" border="0" cellspacing="0" cellpadding="0">');
document.write('<TR>');
document.write('      <TD colspan="2"  width="100%" align="center" bgcolor="'+pjs_titleBGColor+'">'+pjs_bigFont+pjs_title+'</font></TD>');
document.write('   </TR>');
document.write('<tr>');
document.write('    <td width="100%">');
document.write('      <table bgcolor="'+pjs_borderColor+'" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>');
document.write('  <table bgcolor="'+pjs_borderColor+'" width="100%" border="0" cellspacing="1" cellpadding="2">');
document.write('          <tr bgcolor="'+pjs_headerBGColor+'">');
document.write('            <td width="15%">'+pjs_headerFont);
document.write('            <B>&nbsp;<?php echo bx_js_prepare(TEXT_POST_DATE);?>&nbsp;</B></font></td>');
document.write('            <td width="28%" align="center">'+pjs_headerFont);
document.write('            <b>&nbsp;<?php echo bx_js_prepare(TEXT_TITLE);?>&nbsp;</b></font></td>');
document.write('            <td width="28%" align="center">'+pjs_headerFont);
document.write('            <b>&nbsp;<?php echo bx_js_prepare(TEXT_JOBCATEGORY);?>&nbsp;</b></font></td>');
document.write('            <td width="28%" align="center">'+pjs_headerFont);
document.write('            <b>&nbsp;<?php echo bx_js_prepare(TEXT_LOCATION);?>&nbsp;</b></font></td>');
document.write('        </tr>');
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
       if($empty!=1)
         {
         while($j<sizeof($array_jobs))            //$jobs=bx_db_fetch_array($result_featured_jobs)
            {
              $rows++;
              $job=bx_db_data_seek($result_featured_jobs, $array_jobs[$j]);
              $result_jobs=bx_db_fetch_array($result_featured_jobs);
              ?>document.write('             <tr <?php if(floor($rows/2) == ($rows/2)) { echo 'bgcolor="\'+pjs_rowBGColor1+\'"';} else {echo 'bgcolor="\'+pjs_rowBGColor2+\'"';}?>>');
 document.write('                      <td align="left" width="15%"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>" target="_blank" '+pjs_linkStyle+'><?php echo bx_js_prepare(bx_format_date($result_jobs['jobdate'], DATE_FORMAT));?></a></td>');
 document.write('                      <td width="28%" align="center"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>" target="_blank" '+pjs_linkStyle+'><?php echo bx_js_prepare($result_jobs['jobtitle']);?></a></td>');
 document.write('                      <td width="28%" align="center"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>" target="_blank" '+pjs_linkStyle+'><?php echo bx_js_prepare($result_jobs['jobcategory']);?></a></td>');
 document.write('                      <td width="28%" align="center"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session);?>" target="_blank" '+pjs_linkStyle+'><?php echo bx_js_prepare($result_jobs['location']);?></a></td>');
 document.write('             </tr>');
         <?php
                 if($j==FEATURED_JOBS_NUMBER) {
                          break;
                 }
                 $j++;
             }
          }//end if empty
          else {
          ?>
document.write('              <TR>');
document.write('               <TD colspan="4" align="center" valign="middle" bgcolor="'+pjs_rowBGColor1+'">'+pjs_bigFont+'<?php echo bx_js_prepare(TEXT_NO_FEATURED_JOB);?></font></TD>');
document.write('              </TR>');
          <?php
          }
          ?>
document.write('     </table>');
document.write('    </td>');
document.write('    </tr>');
document.write('    </table></td>');
document.write('</tr>');
document.write('</table>');