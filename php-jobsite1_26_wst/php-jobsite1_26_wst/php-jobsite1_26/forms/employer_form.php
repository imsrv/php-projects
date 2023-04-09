<?php
include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER_FORM);
$company_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companies.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_companycredits.compid=".$bx_table_prefix."_companies.compid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$company_result=bx_db_fetch_array($company_query);
$job_query=bx_db_query("select *,UNIX_TIMESTAMP(jobexpire)-UNIX_TIMESTAMP(NOW()) as mytime, concat(if (".$bx_table_prefix."_jobs.city='','',concat(".$bx_table_prefix."_jobs.city, ' - ')),if (".$bx_table_prefix."_jobs.province='','', concat(".$bx_table_prefix."_jobs.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_locations_".$bx_table_lng." where compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
?>
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="1">
  <TR bgcolor="#FFFFFF">
      <TD colspan="3"  width="100%" align="center" class="headertdjob"><?php echo TEXT_MY_JOBS;?></TD>
    </TR>
    <tr><td colspan="3"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
</td></tr>
<TR>
      <TD colspan="3" align="center" valign="top" width="100%">
<?php
$jobcount_query=bx_db_query("select *,COUNT(jobid) as job_count from ".$bx_table_prefix."_jobs where compid='".$HTTP_SESSION_VARS['employerid']."' group by compid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$jobcount_result=bx_db_fetch_array($jobcount_query);
?>
        <br><b><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_ALREADY_POSTED;?> <?php if($jobcount_result['job_count']) {echo $jobcount_result['job_count'];} else {echo '0';}?> <?php echo TEXT_JOBS;?> <?php echo TEXT_FOR;?> &lt;&lt; <font color="#0000FF"><?php echo $company_result['company'];?></font> &gt;&gt;<BR><?php echo TEXT_YOU_CAN_POST;?> <?php if($company_result['jobs']=="999") {echo "<font color=\"red\">".TEXT_UNLIMITED."</font>";} else { echo $company_result['jobs'];}?> <?php echo TEXT_MORE_JOBS;?><?php echo (USE_FEATURED_JOBS=="yes")?"&nbsp;".TEXT_AND."&nbsp;".$company_result['featuredjobs']."&nbsp;".TEXT_MORE_FEATUREDJOBS:"";?>&nbsp;<?php echo TEXT_MORE_SEARCH;?> <?php if($company_result['contacts']=="999") {echo "<font color=\"red\">".TEXT_UNLIMITED."</font>";} else { echo $company_result['contacts'];}?> <?php echo TEXT_TIMES;?></FONT></b>
      </TD>
    </TR>
    <TR>
      <TD colspan="3" align="center" width="100%">
        <CENTER>
        <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <TH><font face="verdana" size="2" color="#000000"><?php echo TEXT_POST_DATE;?></FONT></TH>
			<TH><font face="verdana" size="1" color="#000000"><?php echo TEXT_TYPE;?></TH>
            <TH><font face="verdana" size="2" color="#000000"><?php echo TEXT_JOB_TITLE;?></FONT></TH>
            <TH><font face="verdana" size="2" color="#000000"><?php echo TEXT_LOCATION;?></FONT></TH>
            <TH><font face="verdana" size="2" color="#000000"><?php echo TEXT_EXPIRE_DATE;?></FONT></TH>
            <TH><font face="verdana" size="1" color="#000000"><?php echo TEXT_EDIT;?></FONT></TH>
            <TH><font face="verdana" size="1" color="#000000"><?php echo TEXT_DELETE;?></FONT></TH>
          </TR>
   <?php
  while ($job_result=bx_db_fetch_array($job_query))
   {
   $rows++;
   ?>
<tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
<TD width="12%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_date($job_result['jobdate'], DATE_FORMAT);?></FONT></TD>
<TD align="center"><?php if($job_result['featuredjob']=='Y') {echo  bx_image(HTTP_IMAGES.$language."/fjob.gif",0,TEXT_FEATURED_JOB);} else {echo bx_image(HTTP_IMAGES.$language."/njob.gif",0,TEXT_NORMAL_JOB);}?></TD>
<TD width="30%"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$job_result['jobid']."&employer=yes", "auth_sess", $bx_session);?>"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="blue"><b><?php echo $job_result['jobtitle'];?>
      </b></FONT></a></TD>
<TD width="30%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $job_result['location'];?></FONT>
</TD>
<TD width="12%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_date($job_result['jobexpire'], DATE_FORMAT);?>
     <?php
       $mytime = $job_result['mytime'];  
       if ($mytime<0) {
           $mytime = - $mytime;
           $sign = "-";
       } 
       else {
           $sign = "+";
       }
       if ($mytime>=86400) {
           echo $sign.(floor($mytime/(3600*24)))."d ";    
       }
       else {
           echo "+0d ";
       }
       ?> 
    </FONT></TD>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post">
<TD align="center" width="15%"><font face="verdana" size="1"><INPUT type="hidden" name="action" value="job_form"><INPUT type="hidden" name="jobid" value="<?php echo $job_result['jobid'];?>"><input type="submit" value="<?php echo TEXT_EDIT;?>" style="width: 60px" title="<?php echo TEXT_EDIT;?>"></TD></FORM><FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post">
<TD align="center" width="15%"><font face="verdana" size="1"><INPUT type="hidden" name="action" value="del_job"><INPUT type="hidden" name="jobid" value="<?php echo $job_result['jobid'];?>"><input type="submit" value="<?php echo TEXT_DELETE;?>" style="width: 75px" title="<?php echo TEXT_DELETE;?>"></TD></FORM>
</TR>
 <?php
  }//end while
 ?>
</TABLE></td>
</tr>
</TABLE>
</CENTER>
</TD>
</TR>
<tr>
<td colspan="5" align="right"><br>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post">
<INPUT type="hidden" name="action" value="job_form">
<INPUT type="hidden" name="jobid" value="0">
<input type="submit" name="add" value="<?php echo TEXT_ADD_JOB;?>">
</FORM></td>
</tr>
</table>