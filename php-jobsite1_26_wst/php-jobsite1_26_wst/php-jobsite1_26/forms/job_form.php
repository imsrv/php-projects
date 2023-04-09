<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOB_FORM);?>
<?php
$edit=0;
if ($error==1)
  {
    $job_query=bx_db_query("select * from ".$bx_table_prefix."_jobs where jobid='".$HTTP_POST_VARS['jobid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $job_result=bx_db_fetch_array($job_query);
   //caculating titleids
    for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
           $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
    }
    //calculating lang
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
            if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]) {
                 $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
            }
            else {
                 $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
            }
            $i++;
    }
    $job_result['description']=bx_stripslashes($HTTP_POST_VARS['description']);
    $job_result['languageid']=$HTTP_POST_VARS['languageid'];
    $job_result['jobcategoryid']=$HTTP_POST_VARS['jobcategoryid'];
    $job_result['jobtitle']=bx_js_stripslashes($HTTP_POST_VARS['jobtitle']);
    $job_result['skills']=bx_stripslashes($HTTP_POST_VARS['skills']);
    $job_result['require']=$HTTP_POST_VARS['require'];
    $job_result['degreeid']=$HTTP_POST_VARS['degreeid'];
    $job_result['salary']=$HTTP_POST_VARS['salary'];
    $job_result['city']=bx_js_stripslashes($HTTP_POST_VARS['city']);
    $job_result['province']=bx_js_stripslashes($HTTP_POST_VARS['province']);
    $job_result['locationid']=$HTTP_POST_VARS['location'];
    $job_result['experience']=$HTTP_POST_VARS['experience'];
    $job_result['lang']=$calc_lang;
    $job_result['jobtypeids']=$calc_jobtypeids;
    $job_result['featuredjob']=$HTTP_POST_VARS['featuredjob'];
    $job_result['hide_compname'] = $HTTP_POST_VARS['hide_compname'];
    $job_result['contact_name'] = bx_js_stripslashes($HTTP_POST_VARS['contact_name']);
    $job_result['hide_contactname'] = $HTTP_POST_VARS['hide_contactname'];
    $job_result['contact_email'] = $HTTP_POST_VARS['contact_email'];
    $job_result['hide_contactemail'] = $HTTP_POST_VARS['hide_contactemail'];
    $job_result['contact_phone'] = $HTTP_POST_VARS['contact_phone'];
    $job_result['hide_contactphone'] = $HTTP_POST_VARS['hide_contactphone'];
    $job_result['contact_fax'] = $HTTP_POST_VARS['contact_fax'];
    $job_result['hide_contactfax'] = $HTTP_POST_VARS['hide_contactfax'];
  }
  else
 {
  $job_query=bx_db_query("select * from ".$bx_table_prefix."_jobs where jobid='".$HTTP_POST_VARS['jobid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $job_result=bx_db_fetch_array($job_query);
  $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $company_result=bx_db_fetch_array($company_query);
  $edit=1;
 }
?>
  <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);?>" method="post" name="frmJob"
  onsubmit="return check_form();">
   <?php if($error!=0)
    {
    echo bx_table_header(ERRORS_OCCURED);
    echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
    if ($jobtitle_error=="1") echo JOBTITLE_ERROR."<br>";
    if ($description_error=="1") echo DESCRIPTION_ERROR."<br>";
    if ($emplyment_type_error=="1") echo EMPLOYMENT_ERROR."<br>";
    if($salary_error==1) echo SALARY_ERROR."<br>";
    if($expyears_error==1) echo EXPYEARS_ERROR."e=".$HTTP_POST_VARS['expyears']."<br>";
    echo "</font>";
    }

  ?>
  <INPUT type="hidden" name="action" value="job">
  <INPUT type="hidden" name="jobid" value="<?php echo $HTTP_POST_VARS['jobid'];?>">
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
  <TR bgcolor="#FFFFFF">
      <TD colspan="5"  width="100%" align="center" class="headertdjob"><?php echo TEXT_JOB_ENTRY;?></TD>
  </TR>
  <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
            </tr>
   </table>
  </td>
  </tr>
  <?php if(USE_FEATURED_JOBS == "yes") {?>
  <TR>
      <TD>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_FEATURED;?></B></FONT>
      </TD>
      <TD colspan="5"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <?php echo TEXT_NO;?><input type="radio" class="radio" name="featuredjob"  value="N"<?php if((!$job_result['featuredjob']) or ($job_result['featuredjob']=='N')) {echo " checked";}?>>
        <?php echo TEXT_YES;?><input type="radio" class="radio" name="featuredjob"  value="Y"<?php if($job_result['featuredjob']=='Y') {echo "checked";}?>></font>
      </TD>
    </TR>
   <?php
   }
   else {
       ?>
       <input type="hidden" name="featuredjob" value="N">
   <?php
    }
    if (POSTING_LANGUAGE == "on") {
    ?>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTING_LANGUAGE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <SELECT name="languageid" size="1">
       <?php
          $i=1;
           while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
            {
             echo '<option value="'.$i.'"';
                    if ($i==$job_result['postlanguage'])
                       {
                        echo " selected";
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
    ?>
    <TR>
      <TD width="30%">
        <?php if($jobtitle_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_JOB_TITLE;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="jobtitle"  value="<?php echo $job_result['jobtitle'];?>" size="30">
        </FONT> <?php echo REQUIRED_STAR;?>
      </TD>
   </TR>
   <TR>
      <TD width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <SELECT name="jobcategoryid" size=1>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if ($job_result['jobcategoryid']==$title_result['jobcategoryid']) {echo " selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT></TD>
    </TR>
    <TR>
      <TD width="30%" valign="top">
        <?php if($description_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_JOB_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <TEXTAREA name="description" rows="5" cols="60"><?php echo $job_result['description'];?></TEXTAREA>
        </FONT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILLS;?>:</B></FONT>
      </TD>
      <TD colspan="2" width="40%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><textarea name="skills" rows="3" cols="30"><?php echo $job_result['skills'];?></textarea>
        </FONT>
      </TD>
      <TD colspan="2" width="30%" valign="top">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SKILL_EXAMPLE;?></FONT>
      </TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LANGUAGE_REQUIREMENTS;?>:</B></FONT>
      </TD>
    </TR>
    <?php
    $i=1;
    while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
       echo "<TR><TD width=\"30%\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><B>".${TEXT_LANGUAGE_KNOWN_OPT.$i}.":</B></FONT></TD><TD width=\"70%\" nowrap colspan=\"4\">&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."1")))
       {
       echo " checked ";
       }
         echo " value=1>".TEXT_VERY_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio  class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."2"))
       {
        echo " checked ";
       }
       echo   " value=2>".TEXT_GOOD."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."3"))
       {
       echo " checked ";
       }
       echo "  value=3>".TEXT_POOR."</FONT>&nbsp;&nbsp;&nbsp;&nbsp;<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><INPUT type=radio class=\"radio\" name=\"".substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."\"";
       if (strstr($job_result['languageids'],substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."4"))
       {
       echo " checked ";
       }
       echo " value=4>".TEXT_NONE."</FONT></TD></TR>";
       $i++;
       }
    }
    ?>
    <TR>
      <TD width="30%" valign="top">
        <?php if($emplyment_type_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
     <TD colspan="4" width="70%">
        <SELECT name="jobtypeids[]" multiple size="3">
        <?php
          $jobtype_query=bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
          while ($jobtype_result=bx_db_fetch_array($jobtype_query))
          {
          echo '<option value="'.$jobtype_result['jobtypeid'].'"';
          if (strstr($job_result['jobtypeids'],$jobtype_result['jobtypeid'])) {echo " selected";}
          echo '>'.$jobtype_result['jobtype'].'</option>';
          }
          ?>
        </SELECT> <?php echo REQUIRED_STAR;?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <?php if($salary_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_SALARY_RANGE;?>:</B></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="salary" size="7" value="<?php echo $job_result['salary'];?>"> <B><?php echo PRICE_CURENCY;?></B></FONT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_INDICATE_SALARY;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <?php if($expyears_error=="1") {echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";} else {echo "<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">";}?><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD valign="top" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="experience" size="7"  value="<?php echo $job_result['experience'];?>"></FONT>
      </TD>
      <TD colspan="3" valign="top" width="50%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_REQUIRED_EXPERIENCE;?></FONT>
      </TD>
    </TR>
    <TR>
      <TD width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <SELECT name="degreeid" size="1">
        <?php
          $i=1;
          while (${TEXT_DEGREE_OPT.$i}) {
                 echo '<option value="'.$i.'"';
                 if ($i == $job_result['degreeid']) {
                     echo " selected";
                 }
                 echo '>'.${TEXT_DEGREE_OPT.$i}.'</option>';
                 $i++;
          } 
          ?>
        </SELECT>
       </TD>
       <TD colspan="3" valign="top" width="45%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_PREFERED_DEGREE;?></FONT>
       </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <SELECT name="location" size="1">
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if ($job_result['locationid']==$location_result['locationid']) {echo " selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="70%" colspan="4">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="text" name="province" size="20" value="<?php echo $job_result['province'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD colspan="4" width="70%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="city" size="30"
        value="<?php echo $job_result['city'];?>"></FONT>
      </TD>
    </TR>
    <TR>
      <TD colspan="5">&nbsp;</TD>
    </TR>
    <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
            </tr>
   </table>
  </td>
  </tr>
  <TR>
        <TD colspan="5"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_HIDE_NOTE;?></B></FONT></TD>
   </TR>
  <TR>
      <TD colspan="5">&nbsp;</TD>
  </TR>
  <TR>
      <TD valign="top" width="55%" colspan="2">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_HIDE_COMPANY;?>:</B><br><?php echo TEXT_HIDE_COMPANY_NOTE;?></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_compname" value="yes"<?php if($job_result['hide_compname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
   </TR>
   <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_NAME;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contact_name" size="30"
        value="<?php echo ($job_result['contact_name'] || $HTTP_POST_VARS['jobid'])?$job_result['contact_name']:$company_result['company'];?>"></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactname" value="yes"<?php if($job_result['hide_contactname'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
   </TR>
   <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contact_email" size="30"
        value="<?php echo ($job_result['contact_email'] || $HTTP_POST_VARS['jobid'])?$job_result['contact_email']:$company_result['email'];?>"></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactemail" value="yes"<?php if($job_result['hide_contactemail'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contact_phone" size="20"
        value="<?php echo ($job_result['contact_phone'] || $HTTP_POST_VARS['jobid'])?$job_result['contact_phone']:$company_result['phone'];?>"></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactphone" value="yes"<?php if($job_result['hide_contactphone'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_FAX;?>:</B></FONT>
      </TD>
      <TD width="25%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><INPUT type="text" name="contact_fax" size="20"
        value="<?php echo ($job_result['contact_fax'] || $HTTP_POST_VARS['jobid'])?$job_result['contact_fax']:$company_result['fax'];?>"></FONT>
      </TD>
      <TD colspan="3" width="45%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><input type="checkbox" class="radio" name="hide_contactfax" value="yes"<?php if($job_result['hide_contactfax'] == "yes") { echo " checked";}?>> <?php echo TEXT_HIDE_INFORMATION;?></font></TD>
    </TR>
    <TR>
      <TD colspan="5">&nbsp;</TD>
    </TR>
    <TR>
      <TD align="center" colspan="5" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
        <INPUT type="button" name="btnCancel" onclick="self.history.back();" value="<?php echo TEXT_BUTTON_CANCEL;?>">
        <INPUT type="submit" name="btnSave" value="<?php echo TEXT_BUTTON_SAVE;?> "></FONT>
      </TD>
    </TR>
  </TABLE>
</FORM>