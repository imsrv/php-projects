<?php include(DIR_LANGUAGES.$language."/".FILENAME_VIEW_FORM);
if (($HTTP_GET_VARS['resume_id']) || ($HTTP_POST_VARS['resume_id'])) {
  if (!$HTTP_SESSION_VARS['employerid'])
  {
   $error_message=TEXT_TRYING_UNPAYED_INFORMATION;
   $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
   include(DIR_FORMS.FILENAME_ERROR_FORM);
  }
  else
  {
  include(DIR_LANGUAGES.$language."/".FILENAME_JOBSEEKER_FORM);
  include(DIR_LANGUAGES.$language."/".FILENAME_PERSONAL);
  include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY_FORM);
  if ($HTTP_POST_VARS['action']=="view_contact_info") {
      $companycredits_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where compid='".$HTTP_SESSION_VARS['employerid']."'");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      $companycredits_result=bx_db_fetch_array($companycredits_query);
      if ($companycredits_result['contacts']>0) {
          if ($companycredits_result['contacts']!=999) {
          bx_db_query("update ".$bx_table_prefix."_companycredits set contacts=contacts-1 where compid='".$HTTP_SESSION_VARS['employerid']."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          }
          ?>
          <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
         <TR bgcolor="#FFFFFF">
                        <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_CONTACT_INFORMATIONS;?></TD>
         </TR>
         <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                                <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                                </tr>
                        </table></TD>
         </TR>
         <TR>
               <?php
               $contact_query=bx_db_query("select * from ".$bx_table_prefix."_persons,".$bx_table_prefix."_locations_".$bx_table_lng.",".$bx_table_prefix."_resumes where ".$bx_table_prefix."_resumes.resumeid='".$HTTP_POST_VARS['resume_id']."' and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_persons.locationid");
               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               $contact_result=bx_db_fetch_array($contact_query);
               ?>
                 <TD valign="top" width="30%">
                  <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NAME;?>:</B></FONT>
                 </TD>
                 <TD width="70%" class="view"><?php if($contact_result['hide_name']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['name'];}?></TD>
         </TR>
         <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['address'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['city'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['province'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['postalcode'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['location'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view"><?php if($contact_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['phone'];}?></TD>
        </TR>
       <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view" nowrap><?php if($contact_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><A href="mailto:<?php echo $contact_result['email'];?>" class="featured"><?php echo $contact_result['email'];?></A><?php };?>&nbsp;&nbsp;<a href="javascript:;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE."?person_id=".$contact_result['persid'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=460,height=400,top=0,left=0,screenX=10,screenY=10');"><?php echo TEXT_EMAIL_JOBSEEKER;?></a>&nbsp;</TD>
        </TR>
        <TR>
                <TD valign="top" width="30%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
                </TD>
                <TD width="70%" class="view">
                        <?php if($contact_result['url']=="-")
                        {
                        echo $contact_result['url'];
                        }
                        else
                        {
                                if (!strstr($contact_result['url'], "http://")) {
                                        $url = "http://".eregi_replace("/$", "" ,$contact_result['url']);
                                }
                                else {
                                        $url = $contact_result['url'];
                                }
                        echo "<a href=\"$url\" target=\"_blank\" class=\"featured\">".$contact_result['url']."</a>";
                        }?>
                </TD>
      </TR>
      <TR>
      <?php
           $sess_resume_id = $HTTP_POST_VARS['resume_id'];
           bx_session_unregister("sess_resume_id");
           bx_session_register("sess_resume_id");
      ?>
         <TD colspan="2"><form method="post" action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?resume_id=".$HTTP_POST_VARS['resume_id'], "auth_sess", $bx_session);?>" onSubmit="return false;"><input type="button" name="print_resume" value="<?php echo TEXT_PRINT_RESUME;?>" onClick="newwind = window.open('<?php echo HTTP_SERVER;?>print_version.php?url='+escape('<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?resume_id=".$HTTP_POST_VARS['resume_id']."&printit=yes", "auth_sess", $bx_session);?>'),'_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=520,screenX=50,screenY=100');">&nbsp;&nbsp;<input type="button" name="email_resume" value="<?php echo TEXT_EMAIL_RESUME;?>" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."email_resume.php?resume_id=".$HTTP_POST_VARS['resume_id'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=400,screenX=50,screenY=100');"><?php if($view_query_result['resume_cv']!=""){?>
         &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="download_resume" value="<?php echo TEXT_DOWNLOAD_RESUME;?>" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER."download_resume.php?resume_id=".$HTTP_POST_VARS['resume_id'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=400,screenX=50,screenY=100');">
         <?php }?></form></TD>
    </TR>
    <?php if($HTTP_POST_VARS['back_search']){?>
    <TR><TD colspan="2" align="left">
    <br><a href="<?php echo $HTTP_POST_VARS['back_search'];?>" class="search"><?php echo TEXT_BACK_SEARCH;?></a>
    </TD></TR>
    <?php }?>        
  </TABLE>
 <?php
        }//end if ($companycredits_result['contacts']>0)
        else {
              $error_message=TEXT_NOMORE_CONTACTS;
              $back_url=bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);
              include(DIR_FORMS.FILENAME_ERROR_FORM);
        }
  }//end if $action=="view_contact_info"
  else if($HTTP_GET_VARS['printit'] == "yes") {
  ?>
  <table bgcolor="#FFFFFF" width="100%" border="0" cellspacing="0" cellpadding="2">
  <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><b><?php echo TEXT_CONTACT_INFORMATIONS;?></b></TD>
  </TR>
  <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><hr></TD>
  </TR>
    <?php
   $contact_query=bx_db_query("select * from ".$bx_table_prefix."_persons,".$bx_table_prefix."_locations_".$bx_table_lng.",".$bx_table_prefix."_resumes where ".$bx_table_prefix."_resumes.resumeid='".$HTTP_SESSION_VARS['sess_resume_id']."' and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_persons.locationid");
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $contact_result=bx_db_fetch_array($contact_query);
   ?>
   <TR>
        <TD valign="top" width="30%"><B><?php echo TEXT_NAME;?>:</B></TD>
         <TD width="70%" class="view"><?php if($contact_result['hide_name']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['name'];}?></TD>
   </TR>
   <TR>
        <TD valign="top" width="30%"><B><?php echo TEXT_ADDRESS;?>:</B></TD>
        <TD width="70%" class="view"><?php if($contact_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['address'];}?></TD>
   </TR>
   <TR>
        <TD valign="top" width="30%"><B><?php echo TEXT_CITY;?>:</B></TD>
        <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['city'];}?></TD>
   </TR>
   <TR>
        <TD valign="top" width="30%"><B><?php echo TEXT_PROVINCE;?>:</B></TD>
        <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['province'];}?></TD>
   </TR>
   <TR>
         <TD valign="top" width="30%"><B><?php echo TEXT_POSTAL_CODE;?>:</B></TD>
         <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['postalcode'];}?></TD>
   </TR>
   <TR>
          <TD valign="top" width="30%"><B><?php echo TEXT_COUNTRY;?>:</B></TD>
          <TD width="70%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['location'];}?></TD>
   </TR>
   <TR>
           <TD valign="top" width="30%"><B><?php echo TEXT_PHONE;?>:</B></TD>
           <TD width="70%" class="view"><?php if($contact_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['phone'];}?></TD>
   </TR>
   <TR>
            <TD valign="top" width="30%"><B><?php echo TEXT_EMAIL;?>:</B></TD>
            <TD width="70%" class="view"><?php if($contact_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;?>&nbsp;<?php } else {?><A href="mailto:<?php echo $contact_result['email'];?>" class="featured"><?php echo $contact_result['email'];?></A><?php };?>&nbsp;</TD>
   </TR>
   <TR>
            <TD valign="top" width="30%"><B><?php echo TEXT_URL;?>:</B></TD>
            <TD width="70%" class="view">
                        <?php if($contact_result['url']=="-")
                        {
                        echo $contact_result['url'];
                        }
                        else
                        {
                                if (!strstr($contact_result['url'], "http://")) {
                                        $url = "http://".eregi_replace("/$", "" ,$contact_result['url']);
                                }
                                else {
                                        $url = $contact_result['url'];
                                }
                        echo "<a href=\"$url\" target=\"_blank\" class=\"featured\">".$contact_result['url']."</a>";
                        }?>
                </TD>
   </TR>
   <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left">&nbsp;</TD>
   </TR>
   <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><b><?php echo TEXT_RESUME_DETAILS;?></b></TD>
   </TR>
  <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><hr></TD>
  </TR>
  <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_SUMMARY;?>:</B>
      </TD>
      <TD width="70%"><?php echo $view_query_result['summary'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_JOB_CATEGORY;?>:</B>
      </TD>
      <TD width="70%">
        <?php
        $w=$view_query_result['jobcategoryids'];
                    while (eregi("-([0-9]*)-(.*)",$w,$regs))
                    {
                          $where.=$regs[1].',';
                          $w="-".$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if($where != "") {
                $category_query=bx_db_query("select jobcategory from ".$bx_table_prefix."_jobcategories_".$bx_table_lng." where jobcategoryid in ($where) group by jobcategory");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                while ($category_result=bx_db_fetch_array($category_query))
                {echo "- ".$category_result['jobcategory']."<br>";}    
        }
        ?>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo ucfirst(TEXT_RESUME);?>:</B>
      </TD>
      <TD width="70%"><?php echo bx_textarea($view_query_result['resume']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_SKILL;?>:</B>
      </TD>
      <TD width="70%"><?php echo bx_textarea($view_query_result['skills']);?></TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?> 
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_KNOWN_LANGUAGES;?>:</B>
      </TD>
      <TD width="70%">
       <?php
       $i=1;
       while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
        for($j=1;$j<4;$j++)
        {
        if (strstr($view_query_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$j)))
         {
          switch ($j)
          {
          case 1: echo " - ".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_VERY_GOOD."";break;
          case 2: echo " - ".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_GOOD."";break;
          case 3: echo " - ".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_POOR."";break;
          }
         }
        }
         $i++;
        } //end while
       ?>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B>
      </TD>
      <TD width="70%"><ul><?php
        $where="";
        $w=$view_query_result['jobtypeids'];
                    while (eregi("([0-9]*)-(.*)",$w,$regs))
                    {
                          $where.="'".$regs[1]."',";
                          $w=$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if($where != "") {
            $jobtype_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            while ($jobtype_result=bx_db_fetch_array($jobtype_query))
            {echo "<li>".$jobtype_result['jobtype'].'</li>';}
        }    
        ?></ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_SALARY;?>:</B>
      </TD>
      <TD width="70%"><?php if($view_query_result['salary']!=0) {
          echo bx_format_price($view_query_result['salary'],PRICE_CURENCY,0);
        }
        else {
            echo TEXT_UNSPECIFIED;
        }
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_LOCATION;?>:</B>
      </TD>
      <TD width="70%">
        <?php
        $where="";
        $w=$view_query_result['locationids'];
        while (eregi("-([0-9]*)-(.*)",$w,$regs))
        {
            $where.="'".$regs[1]."',";
            $w="-".$regs[2];
        }
        $where=substr($where,0,strlen($where)-1);
        if ($where=="") {
            $where = "''";
        }
        $location_query=bx_db_query("select location from ".$bx_table_prefix."_locations_".$bx_table_lng." where locationid in ($where) group by location");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        if (bx_db_num_rows($location_query)) {
                while ($location_result=bx_db_fetch_array($location_query))
                {
                    echo "- ".$location_result['location']."<br>";
                }
        }
        else {
            echo TEXT_UNSPECIFIED;
        }
        ?>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_PREFERRED_CITYPROVINCE;?>:</B>
      </TD>
      <TD width="70%"><?php 
      $line=false;
      if($view_query_result['resume_city']){
          echo $view_query_result['resume_city'];
          $line=true;
      }
      if($view_query_result['resume_province']){
          if ($line) {
              echo " - ";
          }
          echo $view_query_result['resume_province'];
      }
      ?></TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><b><?php echo TEXT_OTHER_INFORMATIONS;?></b></TD>
    </TR>
    <TR bgcolor="#FFFFFF">
          <TD colspan="2" width="100%" align="left"><hr></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%"><B><?php echo TEXT_EDUCATION;?>:</B></TD>
      <TD width="40%"><?php echo bx_textarea($view_query_result['education']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_DEGREE_PREFERED;?>:</B>
      </TD>
      <TD width="70%"><?php
        echo ${TEXT_DEGREE_OPT.$view_query_result['degreeid']};
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_WORK_EXPERIENCE;?>:</B>
      </TD>
      <TD width="70%"><?php echo bx_textarea($view_query_result['workexperience']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_EXPERIENCE;?>:</B>
      </TD>
      <TD width="70%"><?php echo $view_query_result['experience'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <B><?php echo TEXT_POST_DATE;?>:</B>
      </TD>
      <TD width="70%" class="view"><?php echo bx_format_date($view_query_result['resumedate'], DATE_FORMAT);?></TD>
    </TR>
     <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
	</TABLE>
  <?php
  }
  else {
?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR>
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_RESUME_DETAILS;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SUMMARY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['summary'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><ul>
        <?php
        $w=$view_query_result['jobcategoryids'];
                    while (eregi("-([0-9]*)-(.*)",$w,$regs))
                    {
                          $where.=$regs[1].',';
                          $w="-".$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if($where != "") {
                $category_query=bx_db_query("select jobcategory from ".$bx_table_prefix."_jobcategories_".$bx_table_lng." where jobcategoryid in ($where) group by jobcategory");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                while ($category_result=bx_db_fetch_array($category_query))
                {echo "<li>".$category_result['jobcategory'].'</li>';}    
        }
        ?></ul>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo ucfirst(TEXT_RESUME);?>:</B></FONT>
      </TD>
      <TD width="70%" class="td4textarea"><?php echo bx_textarea($view_query_result['resume']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo bx_textarea($view_query_result['skills']);?></TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?> 
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_KNOWN_LANGUAGES;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><ul>
       <?php
       $i=1;
       while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
        for($j=1;$j<4;$j++)
        {
        if (strstr($view_query_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$j)))
         {
          switch ($j)
          {
          case 1: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_VERY_GOOD."</li>";break;
          case 2: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_GOOD."</li>";break;
          case 3: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_POOR."</li>";break;
          }
         }
        }
         $i++;
        } //end while
       ?></ul>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><ul><?php
        $where="";
        $w=$view_query_result['jobtypeids'];
                    while (eregi("([0-9]*)-(.*)",$w,$regs))
                    {
                          $where.="'".$regs[1]."',";
                          $w=$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if($where != "") {
                $jobtype_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                while ($jobtype_result=bx_db_fetch_array($jobtype_query))
                {echo "<li>".$jobtype_result['jobtype'].'</li>';}
        }        
        ?></ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['salary']!=0) {
          echo bx_format_price($view_query_result['salary'],PRICE_CURENCY,0);
        }
        else {
            echo TEXT_UNSPECIFIED;
        }
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LOCATION;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view">
        <?php
        $where="";
        $w=$view_query_result['locationids'];
                    while (eregi("-([0-9]*)-(.*)",$w,$regs))
                    {
                        $where.="'".$regs[1]."',";
                        $w="-".$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if ($where=="") {
            $where = "''";
        }
        $location_query=bx_db_query("select location from ".$bx_table_prefix."_locations_".$bx_table_lng." where locationid in ($where) group by location");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        if (bx_db_num_rows($location_query)) {
                echo "<ul>";
                while ($location_result=bx_db_fetch_array($location_query))
                {
                    echo "<li>".$location_result['location'].'</li>';
                }
                echo "</ul>";
        }
        else {
            echo TEXT_UNSPECIFIED;
        }
        ?>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PREFERRED_CITYPROVINCE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php 
      $line=false;
      if($view_query_result['resume_city']){
          echo $view_query_result['resume_city'];
          $line=true;
      }
      if($view_query_result['resume_province']){
          if ($line) {
              echo " - ";
          }
          echo $view_query_result['resume_province'];
      }
      ?></TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_OTHER_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EDUCATION;?>:</B></FONT>
      </TD>
       <TD width="40%" class="td4textarea"><?php
        echo bx_textarea($view_query_result['education']);
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php
        echo ${TEXT_DEGREE_OPT.$view_query_result['degreeid']};
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_WORK_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="td4textarea"><?php echo bx_textarea($view_query_result['workexperience']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['experience'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo bx_format_date($view_query_result['resumedate'], DATE_FORMAT);?></TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
	<tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_CONTACT_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <form name="bx_viewcontactinfo" action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW, "auth_sess", $bx_session);?>" method="post">
    <input type="hidden" name="action" value="view_contact_info">
    <input type="hidden" name="resume_id" value="<?php echo $HTTP_GET_VARS['resume_id'];?>">
    <?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <input type="hidden" name="back_search" value="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>">
    <?php }?>        
     <TR>
       <TD colspan="2" align="center"><input type="submit" name="view" value="<?php echo TEXT_VIEW_CONTACT_INFORMATION;?>"></TD>
     </TR>
     <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    </form>
    <TR><TD colspan="2" align="left">
    <?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <a href="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>" class="search"><?php echo TEXT_BACK_SEARCH;?></a>
    <?php }else{?>&nbsp;
    <?php }?>        
    </TD></TR>
    </TABLE>
 <?php }
  }//end else if($action=="view_contact_info")
 }//end if resume_id
 if (($HTTP_GET_VARS['preview']=="resume") && ($HTTP_GET_VARS['printit']=="yes")) {
    if($HTTP_SESSION_VARS['userid']) {
    include(DIR_LANGUAGES.$language."/".FILENAME_JOBSEEKER_FORM);
    include(DIR_LANGUAGES.$language."/".FILENAME_PERSONAL);
    ?>
    <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_RESUME_DETAILS;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SUMMARY;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><script language="Javascript"><!--
                                                          document.write(parent.opener.document.frm.summary.value);
                                                          //--></script></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><ul>
                  <script language="Javascript"><!--
                                         var jobcateg = parent.opener.document.frm['jobcategoryids[]'];
                                         for (i=0;i<jobcateg.length;i++) {
                                                 if(jobcateg[i].selected == true) {
                                                     document.write("<li>"+jobcateg[i].text+"</li>");
                                                 }
                                         }                                         
                         //--></script>
        </ul>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBSEEKER_RESUME;?>:</B></FONT>
      </TD>
      <TD width="60%" class="td4textarea"><script language="Javascript"><!--
                                                          document.write(parent.opener.document.frm.resume.value.replace(/\n/gi,"<br>"));
                                                          //--></script></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILL;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><script language="Javascript">
                                                                    <!--
                                                                              document.write(parent.opener.document.frm.skills.value);
                                                                     //-->
                                                                     </script></TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?> 
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_KNOWN_LANGUAGES;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><ul>
       <?php
       $i=1;
       while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
        ?>
        <script language="Javascript">
        <!--
           var lang<?php echo substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3);?> = parent.opener.frm.<?php echo substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3);?>;
           for ( i=0 ; i<lang<?php echo substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3);?>.length; i++ ) {
               if(lang<?php echo substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3);?>[i].checked == true) {
                   if(i == 0) {
                       document.write('<li><?php echo ${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_VERY_GOOD;?></li>');
                   }
                   if(i == 1) {
                       document.write('<li><?php echo ${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_GOOD;?></li>');
                   }
                   if(i == 2) {
                       document.write('<li><?php echo ${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_POOR;?></li>');
                   }
               }
           }
        //-->
        </script>
         <?php
         $i++;
        } //end while
       ?></ul>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><ul>
                  <script language="Javascript">
                       <!--
                                         var jobtype = parent.opener.document.frm['jobtypeids[]'];
                                         for (i=0;i<jobtype.length;i++) {
                                                 if(jobtype[i].selected == true) {
                                                     document.write("<li>"+jobtype[i].text+"</li>");
                                                 }
                                         }                                         
                         //-->
                         </script>
                         </ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view">
         <?php if(CURRENCY_POSITION == "right") {?>
                 <script language="Javascript">
                      <!--
                                 if(parent.opener.document.frm.salary.value!=0) {
                                         document.write(parent.opener.document.frm.salary.value+" "+parent.opener.document.frm.salary_format.value);
                                 }
                                 else {
                                         document.write('<?php echo TEXT_UNSPECIFIED;?>');
                                 }
                        //-->
                        </script>
         <?php
         }
         else {
                ?>
                 <script language="Javascript">
                      <!--
                                 if(parent.opener.document.frm.salary.value!=0) {
                                         document.write(parent.opener.document.frm.salary_format.value+parent.opener.document.frm.salary.value);
                                 }
                                 else {
                                         document.write('<?php echo TEXT_UNSPECIFIED;?>');
                                 }
                        //-->
                        </script>
         <?php }
         ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LOCATION;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><ul>
                 <script language="Javascript">
                       <!--
                                         var joblocation = parent.opener.document.frm['locationids[]'];
                                         for (i=0;i<joblocation.length;i++) {
                                                 if(joblocation[i].selected == true) {
                                                     document.write("<li>"+joblocation[i].text+"</li>");
                                                 }
                                         }                                         
                         //-->
                         </script>
                         </ul>
     </TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PREFERRED_CITYPROVINCE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><script language="Javascript">
                                                                    <!--
                                                                              var line=0;
                                                                              if(parent.opener.document.frm.resume_city.value!=""){
                                                                                  document.write(parent.opener.document.frm.resume_city.value);
                                                                                  line=1;
                                                                              }
                                                                              if(parent.opener.document.frm.resume_province.value!=""){
                                                                                  if (line==1) {
                                                                                        document.write(' - ');
                                                                                  }
                                                                                  document.write(parent.opener.document.frm.resume_province.value);
                                                                                  line=1;
                                                                              }
                                                                     //-->
                                                                     </script>
                                                    </TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_OTHER_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EDUCATION;?>:</B></FONT>
      </TD>
       <TD width="60%" class="td4textarea"><script language="Javascript1.2">
                                                                    <!--
                                                                              document.write(parent.opener.document.frm.education.value.replace(/\n/gi,"<br>"));
                                                                     //-->
                                                                     </script></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><ul>
                  <script language="Javascript">
                       <!--
                                         var jobdegree = parent.opener.document.frm['degreeid'];
                                         for (i=0;i<jobdegree.length;i++) {
                                                 if(jobdegree[i].selected == true) {
                                                     document.write("<li>"+jobdegree[i].text+"</li>");
                                                 }
                                         }                                         
                         //-->
                         </script>
                         </ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_WORK_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="td4textarea">
                                                   <script language="Javascript">
                                                                    <!--
                                                                              document.write(parent.opener.document.frm.workexperience.value.replace(/\n/gi,"<br>"));
                                                                     //-->
                                                                     </script></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><script language="Javascript">
                                                                    <!--
                                                                              document.write(parent.opener.document.frm.experience.value);
                                                                     //-->
                                                                     </script></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><script language="Javascript">
                                                                    <!--
                                                                              document.write(parent.opener.document.frm.res_date.value);
                                                                     //-->
                                                                     </script></TD>
    </TR>
     <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
	<tr>
         <TD colspan="2" width="100%" align="left">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_CONTACT_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
               <?php
               $contact_query=bx_db_query("select * from ".$bx_table_prefix."_persons,".$bx_table_prefix."_locations_".$bx_table_lng." where ".$bx_table_prefix."_persons.persid='".$HTTP_SESSION_VARS['userid']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_persons.locationid");
               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               $contact_result=bx_db_fetch_array($contact_query);
               ?>
                 <TD valign="top" width="40%">
                  <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NAME;?>:</B></FONT>
                 </TD>
                 <TD width="60%" class="view"><?php if($contact_result['hide_name']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['name'];}?></TD>
         </TR>
         <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['address'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['city'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['province'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['postalcode'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['location'];}?></TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view"><?php if($contact_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $contact_result['phone'];}?></TD>
        </TR>
       <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view" nowrap><?php if($contact_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><A href="mailto:<?php echo $contact_result['email'];?>" class="featured"><?php echo $contact_result['email'];?></A><?php };?>&nbsp;&nbsp;<a href="javascript:;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE."?person_id=".$contact_result['persid'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=460,height=400,top=0,left=0,screenX=10,screenY=10');"><?php echo TEXT_EMAIL_JOBSEEKER;?></a>&nbsp;</TD>
        </TR>
        <TR>
                <TD valign="top" width="40%">
                        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
                </TD>
                <TD width="60%" class="view">
                        <?php if($contact_result['url']=="-")
                        {
                        echo $contact_result['url'];
                        }
                        else
                        {
                                if (!strstr($contact_result['url'], "http://")) {
                                        $url = "http://".eregi_replace("/$", "" ,$contact_result['url']);
                                }
                                else {
                                        $url = $contact_result['url'];
                                }
                        echo "<a href=\"$url\" target=\"_blank\" class=\"featured\">".$contact_result['url']."</a>";
                        }?>
                </TD>
      </TR>
    </TABLE>
    <?php
    }
    else {
          $error_message=TEXT_UNAUTHORIZED_ACCESS;
          $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
          include(DIR_FORMS.FILENAME_ERROR_FORM);
    }
 }
  if ($HTTP_GET_VARS['person_id'])
   {
   include(DIR_LANGUAGES.$language."/".FILENAME_PERSONAL);
   $companycredits_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where compid='".$HTTP_SESSION_VARS['employerid']."'");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      $companycredits_result=bx_db_fetch_array($companycredits_query);
      if ($companycredits_result['contacts']>0) {
          if ($companycredits_result['contacts']!=999) {
			bx_db_query("update ".$bx_table_prefix."_companycredits set contacts=contacts-1 where compid='".$HTTP_SESSION_VARS['employerid']."'");
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          }
   ?>
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_PERSONAL_INFORMATION;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NAME;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_name']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['name'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['address'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['city'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['province'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['postalcode'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['location'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php if($view_query_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['phone'];}?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view" nowrap><?php if($view_query_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><A href="mailto:<?php echo $view_query_result['email'];?>" class="featured"><?php echo $view_query_result['email'];?></A><?php };?>&nbsp;&nbsp;<a href="javascript:;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE."?person_id=".$view_query_result['persid'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=460,height=400,top=0,left=0,screenX=10,screenY=10');"><?php echo TEXT_EMAIL_JOBSEEKER;?></a>&nbsp;</TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view">
        <?php if($view_query_result['url']=="-")
        {
        echo $view_query_result['url'];
        }
        else
        {
                if (!strstr($view_query_result['url'], "http://")) {
                        $url = "http://".eregi_replace("/$", "" ,$view_query_result['url']);
                }
                else {
                        $url = $view_query_result['url'];
                }
                echo "<a href=\"$url\" target=\"_blank\" class=\"featured\">".$view_query_result['url']."</a>";
        }?>
      </TD>
    </TR>
    <TR><TD colspan="2" align="left">
    <?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <br><a href="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>" class="search"><?php echo TEXT_BACK_SEARCH;?></a>
    <?php }else{?>&nbsp;
    <?php }?>        
    </TD></TR>
  </TABLE>
   <?php
     }//end if ($companycredits_result['contacts']>0)
     else {
              $error_message=TEXT_NOMORE_CONTACTS;
              $back_url=bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);
              include(DIR_FORMS.FILENAME_ERROR_FORM);
          }
   } //end if personal information
   if ($HTTP_GET_VARS['job_id'])
       {
       include(DIR_LANGUAGES.$language."/".FILENAME_JOB_FORM);
       include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY_FORM);
   ?>
     <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="2" width="100%" align="center" class="headertdjob"><?php echo TEXT_JOB_DETAILS;?></TD>
   </TR>
   <TR><TD colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <?php if($view_query_result['hide_compname']!="yes" && $view_query_result['jcompid']!=0){
       if ($view_query_result['logo']) {
       ?>
       <tr>
           <td colspan="2">
               <?php
               $td_num = 1;
               if ($view_query_result['hide_contactname'] != "yes" && $view_query_result['contact_name']) {
                   $td_num++;
               }
               if ($view_query_result['hide_contactemail'] != "yes" && $view_query_result['contact_email']) {
                   $td_num++;
               }
               if ($view_query_result['hide_contactphone'] != "yes" && $view_query_result['contact_phone']) {
                   $td_num++;
               }
               if ($view_query_result['hide_contactfax'] != "yes" && $view_query_result['contact_fax']) {
                   $td_num++;
               }
               if ($view_query_result['url']) {
                   if (!strstr($view_query_result['url'], "http://")) {
                            $url = "http://".eregi_replace("/$", "" ,$view_query_result['url']);
                    }
                    else {
                            $url = $view_query_result['url'];
                    }
                    $td_num++;
               }
               ?>
               <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
               <tr>
                   <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT></td>
                   <TD class="view" width="20%" align="left" valign="top"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$view_query_result['compid'], "auth_sess", $bx_session);?>"><?php echo $view_query_result['company'];?></a></TD>
                   <td align="center" rowspan="<?php echo $td_num;?>">
                   <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
                   $image_location = DIR_LOGO. $view_query_result['logo'];
                   if ((!empty($view_query_result['logo'])) && (file_exists($image_location))) {
                            if (!empty($view_query_result['url'])) {
                                    echo "<a href=\"".$url."\" target=\"_blank\"><img src=\"".HTTP_LOGO.$view_query_result['logo']."\" border=0 align=absmiddle></a>";
                            }
                            else {
                                    echo "<a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$view_query_result['compid'], "auth_sess", $bx_session)."\" target=\"_blank\"><img src=\"".HTTP_LOGO.$view_query_result['logo']."\" border=0 align=absmiddle></a>";
                            }
                   }//end if (file_exists($image_location))
                   ?></font>
                   </td>
               </tr>
               <?php if($view_query_result['hide_contactname'] != "yes" && $view_query_result['contact_name']) {?>
               <tr>
                   <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_NAME;?>:</B></FONT></td>
                   <TD class="view" width="20%" align="left" valign="top"><?php echo $view_query_result['contact_name'];?></TD>
               </tr>
               <?php }
               if ($view_query_result['hide_contactemail'] != "yes" && $view_query_result['contact_email']) {?>
               <tr>
                   <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_EMAIL;?>:</B></FONT></td>
                   <TD class="view" width="20%" align="left" valign="top"><a href="mailto:<?php echo $view_query_result['contact_email']?>" class="featured"><?php echo $view_query_result['contact_email'];?></a></TD>
               </tr>
               <?php }
               if ($view_query_result['hide_contactphone'] != "yes" && $view_query_result['contact_phone']) {?>
               <tr>
                   <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_PHONE;?>:</B></FONT></td>
                   <TD class="view" width="20%" align="left" valign="top"><?php echo $view_query_result['contact_phone'];?></TD>
               </tr>
               <?php }
               if ($view_query_result['hide_contactfax'] != "yes" && $view_query_result['contact_fax']) {?>
               <tr>
                   <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_FAX;?>:</B></FONT></td>
                   <TD class="view" width="20%" align="left" valign="top"><?php echo $view_query_result['contact_fax'];?></TD>
               </tr>
               <?php }
               if ($view_query_result['url']) {?>
               <tr>
                       <td width="30%" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT></td>
                       <TD class="view" width="20%" align="left" valign="top"><a href="<?php echo $url;?>" target="_blank" class="featured"><?php echo $view_query_result['url'];?></a></TD>
               </tr>
               <?php }?>
               </table>
           </td>
       </tr>
        <TR>
                  <td colspan="2">&nbsp;</td>
        </TR>
       <?php }else{?>
           <TR>
              <TD valign="top" width="30%">
                 <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT>
              </TD>
              <TD width="70%" class="view"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$view_query_result['compid'], "auth_sess", $bx_session);?>"><?php echo $view_query_result['company'];?></a></TD>
            </TR>
       <?php }
    }?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_TITLE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['jobtitle'];?></TD>
    </TR>
	<TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_CATEGORY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['title'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_DESCRIPTION;?>:</B></FONT>
      </TD>
      <TD width="70%" class="td4textarea"><?php echo bx_textarea($view_query_result['jdescription']);?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SKILLS;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo bx_textarea($view_query_result['skills']);?></TD>
    </TR>
    <?php
    if (REQUIRED_LANGUAGE == "on") {
    ?>
    <TR>
      <TD valign="top" width="40%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_LANGUAGE_REQUIREMENTS;?>:</B></FONT>
      </TD>
      <TD width="70%" class="ulli"><ul><?php
       $i=1;
       while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
        for($j=1;$j<4;$j++)
        {
        if (strstr($view_query_result['languageids'],(substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$j)))
         {
          switch ($j)
          {
          case 1: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_VERY_GOOD."</li>";break;
          case 2: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_GOOD."</li>";break;
          case 3: echo "<li>".${TEXT_LANGUAGE_KNOWN_OPT.$i}."-".TEXT_POOR."</li>";break;
          }
         }
        }
         $i++;
        } //end while
       ?>
       </ul>
      </TD>
    </TR>
    <?php
    }
    ?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_VIEW_EMPLOYMENT_TYPE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="ulli"><ul><?php
        $where="";
        $w=$view_query_result['jobtypeids'];
                    while (eregi("([0-9]*)-(.*)",$w,$regs))
                    {
                          $where.="'".$regs[1]."',";
                          $w=$regs[2];
                    }
        $where=substr($where,0,strlen($where)-1);
        if($where != "") {
            $jobtype_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            while ($jobtype_result=bx_db_fetch_array($jobtype_query))
            {echo "<li>".$jobtype_result['jobtype'].'</li>';}
        }    
        ?></ul>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SALARY_RANGE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view">
	    <?php if($view_query_result['salary']!=0) {
          echo bx_format_price($view_query_result['salary'],PRICE_CURENCY,0);
        }
        else {
            echo TEXT_UNSPECIFIED;
        }
        ?>
	  </TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_OTHER_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_DEGREE_PREFERED;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view">
        <?php
        echo ${TEXT_DEGREE_OPT.$view_query_result['degreeid']};
        ?>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EXPERIENCE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['experience'];?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOB_LOCATION;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php 
      $line=false;
      if($view_query_result['jcity']){
          echo $view_query_result['jcity'];
          $line=true;
      }
      if($view_query_result['jprovince']){
          if ($line) {
              echo " - ";
          }
          echo $view_query_result['jprovince'];
          $line=true;
      }
      if($view_query_result['location']){
       if ($line) {
              echo " - ";
       }
       echo $view_query_result['location'];
      }
      ?></TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POST_DATE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo bx_format_date($view_query_result['jobdate'], DATE_FORMAT);?></TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <?php if( ($view_query_result['hide_compname']!="yes" && $view_query_result['jcompid']!=0) || ($view_query_result['hide_contactname'] != "yes" && $view_query_result['contact_name']) || ($view_query_result['hide_contactemail'] != "yes" && $view_query_result['contact_email']) || ($view_query_result['hide_contactphone'] != "yes" && $view_query_result['contact_phone']) || ($view_query_result['hide_contactfax'] != "yes" && $view_query_result['contact_fax'])) {?>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_CONTACT_INFORMATIONS;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <?php if(($view_query_result['hide_compname']!="yes") && ($view_query_result['jcompid']!=0)){?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$view_query_result['compid'], "auth_sess", $bx_session);?>"><?php echo $view_query_result['company'];?></a></TD>
    </TR>
    <?php }
      if($view_query_result['hide_contactname'] != "yes" && $view_query_result['contact_name']) {?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_NAME;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['contact_name'];?></TD>
    </TR>
    <?php }
    if ($view_query_result['hide_contactemail'] != "yes" && $view_query_result['contact_email']) {?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><a href="mailto:<?php echo $view_query_result['contact_email'];?>" class="featured"><?php echo $view_query_result['contact_email'];?></a></TD>
    </TR>
    <?php }
    if ($view_query_result['hide_contactphone'] != "yes" && $view_query_result['contact_phone']) {?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['contact_phone'];?></TD>
    </TR>
    <?php }
    if ($view_query_result['hide_contactfax'] != "yes" && $view_query_result['contact_fax']) {?>
    <TR>
      <TD valign="top" width="30%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CONTACT_FAX;?>:</B></FONT>
      </TD>
      <TD width="70%" class="view"><?php echo $view_query_result['contact_fax'];?></TD>
    </TR>
    <?php }
    }?>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
   <?php if(!$HTTP_SESSION_VARS['employerid']) {?>
    <tr>
         <TD colspan="2" width="100%">
          <TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
           <TR><TD align="left"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php echo TEXT_APPLY_ONLINE;?></b></font></TD></TR>
           <TR>
           <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR?>" colspan="2" width="100%" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
           </TR>
          </TABLE>
         </TD>
    </tr>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <?php if ($view_query_result['jcompid']==0 && !$view_query_result['contact_email']) {?>
    <TR>
        <TD colspan="2" align="center"><a href="<?php echo $view_query_result['job_link'];?>" target="_blank" class="featured"><?php echo TEXT_APPLY_ONLINE_LINK;?></a></TD>
    </TR>
    <TR>
        <TD colspan="2">&nbsp;</TD>
    </TR>
    <?php }else{?>
    <form name="bx_jobApply" action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);?>" method="post">
    <input type="hidden" name="action" value="contact">
    <?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <input type="hidden" name="back_search" value="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>">
    <?php }?>
    <input type="hidden" name="jobid" value="<?php echo $HTTP_GET_VARS['job_id'];?>">
    <TR>
      <TD valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SEND_INFORMATION;?>:</b></font><br><font face="<?php echo REQUIRED_TEXT_FONT_FACE;?>" size="1" color="<?php echo REQUIRED_TEXT_FONT_COLOR;?>"><?php echo TEXT_YOU_CAN_APPLY_ONLINE;?></font></TD>
      <TD width="70%" valign="top">
      <?php
      if (!$HTTP_SESSION_VARS['userid']) {
      ?>
       <INPUT type="text" name="login" size="10"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b> ... <?php echo TEXT_USER_NAME;?></b></font><BR>
       <INPUT type="password" name="password" size="10"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b> ... <?php echo TEXT_PASSWORD;?></b></font><br>
      <?php
      }//end if (!userid)
      ?>
         <textarea name="apply_message" cols="25" rows="6" value=""></textarea>
     </TD>
     </TR>
     <TR><TD colspan="2">&nbsp;</TD></TR>
     <TR>
      <TD colspan="2" align="center"><input type="submit" name="send" value="<?php echo TEXT_SEND_MESSAGE;?>"></TD>
     </TR>
     <?php }?>
     <TR><TD colspan="2">
         <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
             <td width="50%"><a href="javascript: ;" class="featured" onClick="window.open('<?php echo FILENAME_EMAIL_JOB;?>?job_id=<?php echo $HTTP_GET_VARS['job_id']?>', '_blank', 'scrollbars=no,menubar=no,resizable=0,location=no,width=500,height=320,screenX=50,screenY=100') ;" onmouseover="window.status='<?php echo TEXT_EMAIL_JOB_TOFRIEND;?>'; return true;" onmouseout="window.status=''; return true;"><?php echo TEXT_EMAIL_JOB_TOFRIEND;?></td>
     <td width="50%" align="right">
    <?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <a href="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>" class="search"><?php echo TEXT_BACK_SEARCH;?></a>
    <?php }else{?>&nbsp;
    <?php }?></td>
        </tr>
        </table>
    </TD></TR>
    </form>
   <?php }//end if !$HTTP_SESSION_VARS['employerid']?>
  </TABLE>
    <?php
    }//end if job_id
    if ($HTTP_GET_VARS['company_id'])
    {
    include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY_FORM);
    if (!strstr($view_query_result['url'], "http://")) {
                $url = "http://".eregi_replace("/$", "" ,$view_query_result['url']);
        }
        else {
                $url = $view_query_result['url'];
        }
    ?>
    <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="3" width="100%" align="center" class="headertdjob"><?php echo TEXT_COMPANY_INFORMATION;?></TD>
   </TR>
   <TR><TD colspan="3"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
     <TD colspan="3"><hr></TD>
   </TR>
   <TR>
      <TD valign="top" width="60%" colspan="2" class="compdesc"><?php echo $view_query_result['description'];?></TD>
      <TD width="40%" align="center" valign="middle">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
       $image_location = DIR_LOGO. $view_query_result['logo'];
       if ((!empty($view_query_result['logo'])) && (file_exists($image_location))) {
                if (!empty($view_query_result['url'])) {
                        echo "<A href=\"".$url."\" target=\"_blank\"><img src=\"".HTTP_LOGO.$view_query_result['logo']."\" border=0 align=absmiddle></a>";
                }
                else {
                        echo "<img src=\"".HTTP_LOGO.$view_query_result['logo']."\" border=0 align=absmiddle>";
                }
       }//end if (file_exists($image_location))
       else {
                 echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>".TEXT_LOGO_NOT_AVAILABLE."</b></font>";
       }//end else if (file_exists($image_location))
       ?></font>
      </TD>
    </TR>
    <TR>
     <TD colspan="3"><hr></TD>
    </TR>
    </table>
    <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR>
        <TD width="20%">&nbsp;</TD>
        <TD valign="top" width="20%">
            <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COMPANY;?>:</B></FONT>
        </TD>
        <TD width="60%" class="view"><?php echo $view_query_result['company'];?></TD>
    </TR>
    <TR>
      <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_ADDRESS;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_address']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['address'];}?></TD>
    </TR>
    <TR>
	  <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_CITY;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['city'];}?></TD>
    </TR>
     <TR>
         <TD width="20%">&nbsp;</TD>
         <TD valign="top" width="20%">
               <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_POSTAL_CODE;?>:</B></FONT>
          </TD>
          <TD width="60%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {if(!empty($view_query_result['postalcode'])) {echo $view_query_result['postalcode'];} else {echo "-";}}?></TD>
     </TR>
     <TR>
        <TD width="20%">&nbsp;</TD>
        <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PROVINCE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {if(!empty($view_query_result['province'])) {echo $view_query_result['province'];} else {echo "-";}}?></TD>
    </TR>
    <TR>
      <TD width="20%">&nbsp;</TD>
	  <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_COUNTRY;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_location']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['location'];}?></TD>
    </TR>
    <TR>
	  <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_PHONE;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_phone']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {echo $view_query_result['phone'];}?></TD>
    </TR>
    <TR>
      <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_FAX;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view"><?php if($view_query_result['hide_fax']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {if(!empty($view_query_result['fax'])) {echo $view_query_result['fax'];} else {echo "-";}}?></TD>
    </TR>
    <TR>
      <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_EMAIL;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view" nowrap><?php if($view_query_result['hide_email']=="yes") {echo TEXT_HIDDEN_INFORMATION;} else {?><A href="mailto:<?php echo $view_query_result['email'];?>" class="featured"><?php echo $view_query_result['email'];?></A><?php };?>&nbsp;&nbsp;<a href="javascript:;" onClick="newwind = window.open('<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE."?company_id=".$view_query_result['compid'], "auth_sess", $bx_session);?>','_blank','scrollbars=yes,menubar=no,resizable=yes,location=no,width=500,height=420,top=0,left=0,screenX=10,screenY=10');"><?php echo TEXT_EMAIL_COMPANY;?></a></TD>
    </TR>
    <TR>
      <TD width="20%">&nbsp;</TD>
      <TD valign="top" width="20%">
         <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_URL;?>:</B></FONT>
      </TD>
      <TD width="60%" class="view">
        <?php if(!$view_query_result['url'])
        {
            echo "-";
        }
        else
        {
            echo "<a href=\"$url\" target=\"_blank\" class=\"featured\">".$view_query_result['url']."</a>";
        }
        ?>
      </TD>
    </TR>
    <TR>
      <TD colspan="3">
       <br> <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_AVAILABLE_JOBS;?></B></font>
      </TD>
    </TR>
<?php
 $jobs_query=bx_db_query("SELECT ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory as title, ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.jobid FROM ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs WHERE ".$bx_table_prefix."_jobs.compid='".$HTTP_GET_VARS['company_id']."'  and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid=".$bx_table_prefix."_jobs.jobcategoryid and ".$bx_table_prefix."_jobs.hide_compname!='yes' order by ".$bx_table_prefix."_jobs.jobdate DESC");
 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
 if (bx_db_num_rows($jobs_query)!=0) {
 while($jobs_result=bx_db_fetch_array($jobs_query))
   {
?>
    <TR>
      <TD colspan="3"><ul>
<?php
      echo "<li><a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$jobs_result['jobid'], "auth_sess", $bx_session)."\" class=\"featured\">".$jobs_result['jobtitle']." [".$jobs_result['title']."]"."</li>";
?>
      </ul></TD>
    </TR>
<?php
   }
}
else {
   ?>
      <TR>
      <TD colspan="3" align="center">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_NONE_JOBS;?></B></font>
      </TD>
    </TR>
    <?php
   }
?>
  <tr>
    <td colspan="3" align="right"><?php if($HTTP_SERVER_VARS['HTTP_REFERER'] && $HTTP_GET_VARS['type']=="search"){?>
    <br><a href="<?php echo $HTTP_SERVER_VARS['HTTP_REFERER'];?>" class="search"><?php echo TEXT_BACK_SEARCH;?></a>
    <?php }else{?>&nbsp;
    <?php }?></td>
  </tr>
  </TABLE>
<?php
} //end if company_id
?>