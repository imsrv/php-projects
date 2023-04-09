<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOBSEEKER_FORM);
if ($error==1)
  {
    $user_query=bx_db_query("select * from ".$bx_table_prefix."_persons where persid='".$HTTP_SESSION_VARS['userid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $user_result=bx_db_fetch_array($user_query);
  //calculating jobcategoryids
        for ($i=0;$i<sizeof($HTTP_POST_VARS['jobcategoryids']);$i++)
        {
            $calc_jobcategoryids.=$HTTP_POST_VARS['jobcategoryids'][$i]."-";
        }
        //calculating locationids
        for ($i=0;$i<sizeof($HTTP_POST_VARS['locationids']);$i++)
        {
            $calc_locationids.=$HTTP_POST_VARS['locationids'][$i]."-";
        }
        //caculating jobtypeids
        for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++)
        {
            $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
        }
        //calculating lang
       $i=1;
       while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
            if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)])  {
                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
            }
            else {
                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
            }
            $i++;
       }
 $resume_result['postlanguage']=$HTTP_POST_VARS['languageid'];
 $resume_result['confidential']=$HTTP_POST_VARS['confidential'];
 $resume_result['summary']=bx_js_stripslashes($HTTP_POST_VARS['summary']);
 $resume_result['jobcategoryids']="-".$calc_jobcategoryids;
 $resume_result['jobtypeids']=$calc_jobtypeids;
 $resume_result['resume']=bx_stripslashes($HTTP_POST_VARS['resume']);
 $resume_result['skills']=bx_stripslashes($HTTP_POST_VARS['skills']);
 $resume_result['salary']=bx_js_stripslashes($HTTP_POST_VARS['salary']);
 $resume_result['degreeid']=$HTTP_POST_VARS['degreeid'];
 $resume_result['education']=bx_stripslashes($HTTP_POST_VARS['education']);
 $resume_result['experience']=bx_stripslashes($HTTP_POST_VARS['experience']);
 $resume_result['resume_city']=bx_js_stripslashes($HTTP_POST_VARS['resume_city']);
 $resume_result['resume_province']=bx_js_stripslashes($HTTP_POST_VARS['resume_province']);
 $resume_result['jobmail']=$HTTP_POST_VARS['jobmail'];
 $resume_result['workexperience']=bx_stripslashes($HTTP_POST_VARS['workexperience']);
 $resume_result['languageids']=$calc_lang;
 $resume_result['locationids']="-".$calc_locationids;
 if($HTTP_POST_VARS['resexp']) {
     $resume_result['resexp']=$HTTP_POST_VARS['resexp'];
 }
 else {
     $resume_result['resexp']=NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY+10;    
 }
   }
  else
 {
  $resume_query=bx_db_query("select *,TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire) - TO_DAYS(NOW()) as resexp from ".$bx_table_prefix."_resumes where persid='".$HTTP_SESSION_VARS['userid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  if(bx_db_num_rows($resume_query)>0) {
      $resume_result=bx_db_fetch_array($resume_query);    
  }
  else {
      $resume_result['resexp'] = NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY+10;
  }
 }
?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);?>" enctype="multipart/form-data" method="post" name="frm" onSubmit="return check_form();">
  <?php if($error!=0)
    {
    echo bx_table_header(ERRORS_OCCURED);
    echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
    if ($summary_error=="1") echo SUMMARY_ERROR."<br>";
    if ($emplyment_type_error=="1") echo EMPLOYMENT_ERRROR."<br>";
    if ($jobcategory_error=="1") echo JOBCATEGORY_ERRROR."<br>";
    if($salary_error==1) echo SALARY_ERROR."<br>";
    if($expyears_error==1) echo EXPYEARS_ERROR."<br>";
    if($upload_error==1) echo UPLOAD_ERROR."<br>";
    echo "</font>";
    }
  ?>
  <INPUT type="hidden" name="action" value="resume">
  <input type="hidden" name="countryp" value="<?php echo $user_result['country'];?>">
  <input type="hidden" name="res_date" value="<?php echo bx_format_date(date('Y-m-d'), DATE_FORMAT);?>">
  <input type="hidden" name="salary_format" value="<?php echo bx_format_price('',PRICE_CURENCY,0);?>">
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
   <TR bgcolor="#FFFFFF">
            <TD colspan="5" width="100%" align="center" class="headertdjob"><?php echo TEXT_RESUME_ENTRY;?></TD>
   </TR>
   <TR><TD colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
    </TR>
    <?php
    if(RESUME_EXPIRE == "yes") {
        if($resume_result['resexp'] <= NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY) {
        ?>
        <INPUT type="hidden" name="reactivate" value="yes">
        <INPUT type="hidden" name="resexp" value="<?php echo $resume_result['resexp'];?>">
        <TR>
          <TD valign="top" width="100%" colspan="5">
            <font face="<?php echo ERROR_TEXT_FONT_FACE;?>" size="<?php echo ERROR_TEXT_FONT_SIZE;?>" color="<?php echo ERROR_TEXT_FONT_COLOR;?>"><B><?php echo ($resume_result['resexp']>=0)?TEXT_EXPIRE_IN.$resume_result['resexp'].TEXT_REACTIVATE_RESUME_BEFORE:TEXT_REACTIVATE_RESUME;?></B></FONT>
          </TD>
        </TR>    
        <?php
        }
    }    
    if (POSTING_LANGUAGE == "on") {
    ?>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_RESUME_LANGUAGE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <SELECT name="languageid" size="1">
       <?php
          $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
             echo '<option value="'.$i.'"';
                    if ($i==$resume_result['postlanguage'])
                       {
                        echo "selected";
                        }
                        echo '>'.${TEXT_LANGUAGE_KNOWN_OPT.$i}.'</option>';
                        $i++;
                        }
                     ?>
              </SELECT>
      </TD>
    </TR>
    <?php
    }       
    if(HIDE_RESUME == "yes") {?>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="checkbox" name="confidential" class="radio" value="1"<?php if($resume_result['confidential']=="1"){echo " checked";}?>><B><?php echo TEXT_RESUME_NOT_SEARCH;?></B>
        </FONT>
      </TD>
    </TR>
    <?php }?>
    <TR>
      <TD valign="top" width="24%">
        <?php if($summary_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_SUMMARY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="summary" size="30"  value="<?php echo $resume_result['summary'];?>">
        </FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <?php if($jobcategory_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_RESUME_CATEGORY;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <SELECT multiple name="jobcategoryids[]" size="5">
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($resume_result['jobcategoryids'],"-".$title_result['jobcategoryid']."-")) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_YOUR_RESUME;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="resume" rows="6" cols="50"><?php echo $resume_result['resume'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_UPLOAD_RESUME;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
       <TD valign="top" width="24%">
           <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_UPLOAD_RESUME_NOTE;?></FONT>
       </TD>
       <TD valign="top" width="76%" colspan="4">
           <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="file" name="resume_cv" size="20">
           <?php if($resume_result['resume_cv']){ ?>
               &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: ;" onClick=" window.open('<?php echo bx_make_url(HTTP_SERVER."preview_resume_file.php?resume_id=".$resume_result['resumeid'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=50;left=50;top=50;');"><?php echo TEXT_VIEW_FILE;?></a> 
           <?php }?>
       </font>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_USED;?></FONT>
      </TD>
      <TD colspan="2" width="40%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="skills" rows="3" cols="30"><?php echo $resume_result['skills'];?></textarea>
        </FONT>
      </TD>
      <TD colspan="2" width="36%" valign="top">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_EXAMPLE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_KNOWN_LANGUAGES;?>:</B></FONT>
        </TD>
    </TR>
    <?php
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
         echo "<TR><TD width=\"24%\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><B>".${TEXT_LANGUAGE_KNOWN_OPT.$i}.":</B></FONT></TD><TD width=\"76%\" colspan=\"4\" nowrap>&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."1")))
         {
         echo " checked ";
         }
         echo "value=1>".TEXT_VERY_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."2"))
         {
          echo " checked ";
         }
         echo   " value=2>".TEXT_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."3"))
         {
          echo " checked ";
         }
         echo "  value=3>".TEXT_POOR."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
         if (strstr($resume_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."4"))
         {
         echo " checked ";
         }
         echo " value=4>".TEXT_NONE."</FONT></TD></TR>";
         $i++;
         }
    }
    ?>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_WORK_EXPERIENCE;?>:</B></FONT>
        </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="workexperience" rows="5" cols="40"><?php echo $resume_result['workexperience'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
    <TR>
          <TD colspan="5" width="100%">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EDUCATION;?>:</B></FONT>
          </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"></FONT>
      </TD>
      <TD colspan="4" width="76%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="education" rows="5" cols="40"><?php echo $resume_result['education'];?></TEXTAREA>
        </FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <?php if($emplyment_type_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="100%">
          <SELECT name="jobtypeids[]" multiple size="3">
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($resume_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo "selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="24%">
        <?php if($salary_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_SALARY;?>:</B></FONT>
      </TD>
      <TD valign="top" width="19%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="salary" size="7" value="<?php echo $resume_result['salary'];?>"> <B><?php echo PRICE_CURENCY;?></B></FONT>
      </TD>
      <TD colspan="3" valign="top" width="38%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_JINDICATE_YEARLY_SALARY;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="20%">
        <?php if($expyears_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="experience" size="7"  value="<?php echo $resume_result['experience'];?>"></FONT>
      </TD>
      <TD colspan="3" valign="top" width="60%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_REQUIRED_EXPERIENCE;?></FONT>
      </TD>
    </TR>
     <TR>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
     <TD width="25%">
        <SELECT name="degreeid" size="1">
        <?php
          $i=1;
          while (${TEXT_DEGREE_OPT.$i}) {
                 echo '<option value="'.$i.'"';
                 if ($i == $resume_result['degreeid']) {
                     echo " selected";
                 }
                 echo '>'.${TEXT_DEGREE_OPT.$i}.'</option>';
                 $i++;
          }
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LOCATION;?>:</B></FONT><br><font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
     <TD width="25%">
     <SELECT name="locationids[]" multiple size="5">
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if (strstr($resume_result['locationids'],"-".$location_result['locationid']."-")) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PREFERED_LOCATION;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resume_province" size="30"
        value="<?php echo $resume_result['resume_province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="75%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="resume_city" size="30"
        value="<?php echo $resume_result['resume_city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD colspan="3" align="right" width="62%" nowrap><br>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="button" name="btnCancel" onclick="self.history.back()" value="<?php echo TEXT_BUTTON_CANCEL;?>">
        <?php
            if(RESUME_EXPIRE == "yes") {
                if($resume_result['resexp'] <= NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY) {?>
            <INPUT type="submit" name="btnSave" value=" <?php echo TEXT_BUTTON_REACTIVATE;?> "></FONT>
               <?php
               }
               else {?>
               <INPUT type="submit" name="btnSave" value=" <?php echo TEXT_BUTTON_SAVE;?> "></FONT>
            <?php }
           }
           else {?>
               <INPUT type="submit" name="btnSave" value=" <?php echo TEXT_BUTTON_SAVE;?> "></FONT>
        <?php }?>
        <input type="button" name="print_resume" value="<?php echo TEXT_PREVIEW_RESUME;?>" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."print_version.php", "auth_sess", $bx_session);?>&url='+escape('<?php echo HTTP_SERVER.FILENAME_VIEW."?preview=resume&printit=yes";?>'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=600,height=520,left=0,top=0,screenX=0,screenY=0');">
      </TD>
      </FORM>
      <?php if($resume_result['resumeid']) {?>
      <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);?>" method="post" name="frmResume">
        <INPUT type="hidden" name="action" value="del_resume">
      <TD colspan="2" align="right" width="38%"><br>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="submit" name="btnDelete" value="<?php echo TEXT_BUTTON_DELETE;?>"></FONT>
      </TD>
      </FORM>
      <?php }?>
    </TR>
</TABLE>