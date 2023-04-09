<?php include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_JOB_FORM);
if($error==1) {
        echo bx_table_header(ERRORS_OCCURED);
        echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
        if ($minsalary_error=="1") echo MINSALARY_ERROR."<br>";
        if ($maxsalary_error=="1") echo MAXSALARY_ERROR."<br>";
            echo "</font>";
}?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
<tr>
<td bgcolor="<?php echo TABLE_BGCOLOR;?>" valign="top">
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR bgcolor="#FFFFFF">
      <TD colspan="5"  width="100%" align="center" class="headertdjob"><?php echo TEXT_FIND_JOB;?></TD>
    </TR>
    <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
</td></tr>
</table>
<TABLE border="0" cellpadding="0" cellspacing="0">
    <TR>
      <TD><br><ul>
           <li>
              <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SEARCH_NOTE1;?></b></FONT>
            </li>
            <li>
              <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SEARCH_NOTE2;?></b></FONT>
            </li>
           </ul>
      </TD>
    </TR>
</TABLE>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="4">
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_FIND, "auth_sess", $bx_session);?>" method="get" name="searchj" onSubmit="return check_search_job_form();">
  <INPUT type="hidden" name="action" value="search">
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SPECIFY_JOB_CATEGORY;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_JOB_CATEGORY;?>:<BR></STRONG></FONT>
        <font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" valign="top" width="70%">
        <SELECT name="jids[]" multiple size="5">
        <OPTION selected value="00"><?php echo TEXT_ALL_CATEGORIES;?></OPTION>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng."");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($job_result['jobcategoryid'],$title_result['jobcategoryid'])) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_LOCATION;?>:</STRONG></FONT><br>
                <font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" valign="top" width="70%">
            <SELECT name="lids[]" multiple size="5">
            <OPTION selected value="000"><?php echo TEXT_ALL_LOCATIONS;?></OPTION>
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if (strstr($job_result['locationid'],$location_result['locationid'])) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
   <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TEXT_OR_PROVINCE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="bx_prv" size="20"></FONT>
      </TD>
    </TR>
    <?php
    if (POSTING_LANGUAGE == "on") {
    ?>
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SPECIFY_POSTING_LANGUAGE;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
   <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_POSTING_LANGUAGE;?></STRONG></FONT><br> <font face="verdana" size=1><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" valign="top" width="70%">
        <SELECT multiple name="bx_plng[]" size="5">
          <OPTION selected value="0"><?php echo TEXT_ALL_LANGUAGES;?></OPTION>
         <?php
           $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                echo '<option value="'.$i.'">'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                $i++;
           }
          ?>
        </SELECT>
      </TD>
    </TR>
    <?php
    }          
    ?>
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SPECIFY_KEYWORDS;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD colspan="5" valign="top" width="100%">
        <ul><li><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SPECIFY_KEYWORDS_HELP1;?></FONT></li>
        <li><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SPECIFY_KEYWORDS_HELP2;?></FONT></li>
        <li><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SPECIFY_KEYWORDS_HELP3;?></FONT></li>
        </ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_KEYWORDS;?>:</STRONG></FONT>
      </TD>
      <TD colspan="3" valign="middle" width="35%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="bx_kwd" rows="3" cols="25"></textarea></FONT>
      </TD>
      <TD valign="middle" width="35%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
		<INPUT type="radio" class="radio" name="rdKeyw" checked value="2"><?php echo TEXT_OR;?><br>
        <INPUT type="radio" class="radio" name="rdKeyw" value="1"><?php echo TEXT_AND;?><br>
		<INPUT type="radio" class="radio" name="rdKeyw" value="3"><?php echo TEXT_EXACT;?></FONT>
      </TD>
    </TR>
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SPECIFY_SALARY;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_SALARY_RANGE;?>:<BR></STRONG></FONT>
        <font face="verdana" size="1"><?php echo TEXT_SALARY_EG;?></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SALARY_FROM;?>:</FONT><BR>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT name="bx_minsalary" size="7"  value="<?php echo $HTTP_POST_VARS['bx_minsalary'];?>"></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SALARY_TO;?>:</FONT><BR>
        <font face="verdana" size="2"><INPUT name="bx_maxsalary" size="7"  value="<?php echo $HTTP_POST_VARS['bx_maxsalary'];?>"></FONT>
      </TD>
      <TD colspan="2" valign="top" width="30%">
        <font face="verdana" size="1"><?php echo TEXT_INDICATE_YEARLY_SALARY;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD colspan="5" valign="top" width="100%">
        <font face="verdana" size="1"><STRONG><font face="verdana" color="#ff0000">*<?php echo TEXT_IMPORTANT;?></FONT>:</STRONG>
        <?php echo TEXT_IMPORTANT_MESSAGE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SPECIFY_LANGUAGE;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SPOKEN_LANGUAGE;?>:</B></FONT><br>
                <font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="2" valign="top" width="35%">
        <SELECT multiple name="bx_lngids[]" size="5">
          <OPTION selected value="-"><?php echo TEXT_ALL_LANGUAGES;?></OPTION>
          <?php
           $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                echo '<option value="'.substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).'">'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                $i++;
           }
          ?>
        </SELECT>
      </TD>
      <TD colspan="2" valign="middle" width="35%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="radio" class="radio" name="rdLang" checked value="2"> <?php echo TEXT_OR;?><BR>
        <INPUT type="radio" class="radio" name="rdLang" value="1"> <?php echo TEXT_AND;?></FONT>
      </TD>
    </TR>
    <?php
    }
    ?>
    <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EMPLOYMENT_TYPE;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_EMPLOYMENT_TYPE;?>:</STRONG></FONT>
        <br><font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" width="70%" nowrap>
       <SELECT name="tids[]" multiple size="5">
       <OPTION selected value="0"><?php echo TEXT_ALL_TYPE;?></OPTION>
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($job_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo "selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
      <tr>
         <TD colspan="5" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="right"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_JOB_PERIOD;?></b></font></TD></TR>
           <TR><td bgcolor="<?php echo TABLE_JOBSEEKER;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td></TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_JOB_POSTED_IN;?>:</STRONG></FONT>
      </TD>
      <TD width="70%" colspan="4">
      <SELECT name="posted" size="5">
       <OPTION selected value="0"><?php echo TEXT_ALL_POSTED;?></OPTION>
       <OPTION value="5">5 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="14">14 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="30">30 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="60">60 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="90">90 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="120">120 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="180">180 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="270">270 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       <OPTION value="365">365 <?php echo TEXT_SALARY_DAYS;?></OPTION>
       </SELECT>
      </TD>
    </TR>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <TR>
      <TD align="center" colspan="5" valign="top" width="100%">
        <P><INPUT type="reset" value="<?php echo TEXT_BUTTON_RESET;?>">
        <INPUT type="submit" name="cmdSearch" value="  <?php echo TEXT_BUTTON_SEARCH;?>  "></P>
      </TD>
    </TR>
  </TABLE>
  </FORM>
  </TD>
  </TR>
</TABLE>