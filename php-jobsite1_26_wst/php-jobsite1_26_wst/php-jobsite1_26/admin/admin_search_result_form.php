<?php include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);?>
<?php
$action="details";
if($HTTP_POST_VARS['type']) {
    $type=$HTTP_POST_VARS['type'];
}
elseif ($HTTP_GET_VARS['type']){
     $type = $HTTP_GET_VARS['type'];
}
else {
    $type = '';
}
if (($type=="comp_email") or ($type=="comp_name") or ($type=="comp_location"))
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $no_of_res = bx_db_num_rows($company_query);
  if($HTTP_POST_VARS['show']=="all") {
      $item_from = 0;
      $item_to = $no_of_res;
  }
?>
  <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="7" align="right" class="searchhead">Search companies Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
           <td width="35%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_SIGNUP_DATE;?>&nbsp;</td>
            <td width="5%" align="center">&nbsp;<?php echo TEXT_AVAILABLE_JOBS;?>&nbsp;</td>
            <td width="5%" align="center">&nbsp;<?php echo TEXT_AVAILABLE_FJOBS;?>&nbsp;</td>
            <td width="5%" align="center">&nbsp;<?php echo TEXT_AVAILABLE_RESUMES;?>&nbsp;</td>
            <td width="10%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;

   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['compid'];?></td>
      <td align="center"><?php echo $company_result['company'];?></td>
      <td align="center"><?php echo $company_result['signupdate'];?></td>
      <td align="center"><?php if($company_result['jobs'] == '999') {
         echo TEXT_UNLIMITED;
      }
     else {
           echo $company_result['jobs'];
       }?></td>
      <td align="center"><?php echo $company_result['featuredjobs'];?></td>
      <td align="center"><?php if($company_result['contacts'] == '999') {
         echo TEXT_UNLIMITED;
      }
      else {
            echo $company_result['contacts'];
      }?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&comp_name=".($HTTP_GET_VARS['comp_name']?$HTTP_GET_VARS['comp_name']:$HTTP_POST_VARS['comp_name'])."&comp_email=".($HTTP_GET_VARS['comp_email']?$HTTP_GET_VARS['comp_email']:$HTTP_POST_VARS['comp_email'])."&location=".($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location'])."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"7\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%">
  <tr>
  <?php
  if ($item_from>NR_DISPLAY && $HTTP_POST_VARS['show']!="all")
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&comp_name=<?php echo ($HTTP_GET_VARS['comp_name']?$HTTP_GET_VARS['comp_name']:$HTTP_POST_VARS['comp_name']);?>&comp_email=<?php echo ($HTTP_GET_VARS['comp_email']?$HTTP_GET_VARS['comp_email']:$HTTP_POST_VARS['comp_email']);?>&location=<?php echo ($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location']);?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
  }
  if ($item_from<bx_db_num_rows($company_query) && $HTTP_POST_VARS['show']!="all")
  {
  $remains=$no_of_res-$item_from;
  if ($remains > NR_DISPLAY) {
      $remains = NR_DISPLAY;
  }
   ?>
  <td colspan=5 align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&comp_name=<?php echo ($HTTP_GET_VARS['comp_name']?$HTTP_GET_VARS['comp_name']:$HTTP_POST_VARS['comp_name']);?>&comp_email=<?php echo ($HTTP_GET_VARS['comp_email']?$HTTP_GET_VARS['comp_email']:$HTTP_POST_VARS['comp_email']);?>&location=<?php echo ($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location']);?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.$remains;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if ($HTTP_GET_VARS['table']=="company")

if (($type=="pers_email") or ($type=="pers_name") or ($type=="pers_location"))
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $no_of_res = bx_db_num_rows($person_query);
  if($HTTP_POST_VARS['show']=="all") {
      $item_from = 0;
      $item_to = $no_of_res;
  }
?>
  <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="6" bgcolor="#FFFFFF" width="100%"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="6" align="right" class="searchhead">Search jobseekers Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="6" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
          <td width="10%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
          <td width="30%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
          <td width="15%" align="center">&nbsp;<?php echo TEXT_SIGNUP_DATE;?>&nbsp;</td>
          <td width="35%" align="center">&nbsp;<?php echo TEXT_ADDRESS;?>&nbsp;</td>
          <td width="35%" align="center">&nbsp;<?php echo TEXT_RESUME;?>&nbsp;</td>
          <td width="10%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($person_result=bx_db_fetch_array($person_query))
  {
  $rows++;
  $item++;

   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $person_result['apersid'];?></td>
      <td align="center"><?php echo $person_result['name'];?></td>
      <td align="center"><?php echo $person_result['signupdate'];?></td>
      <td align="center"><?php echo $person_result['address'];?></td>
      <td align="center"><?php if($person_result['resumeid']) {
       echo "<a href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS."?action=details&resumeid=".$person_result['resumeid']."&back_url=".urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&pers_name=".($HTTP_GET_VARS['pers_name']?$HTTP_GET_VARS['pers_name']:$HTTP_POST_VARS['pers_name'])."&pers_email=".($HTTP_GET_VARS['pers_email']?$HTTP_GET_VARS['pers_email']:$HTTP_POST_VARS['pers_email'])."&location=".($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location'])."&from=".$item_from)."\">".TEXT_YES."</a>";
      }
      else {
             echo TEXT_NO;
       }?></td>
     <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&persid=<?php echo $person_result['apersid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&pers_name=".($HTTP_GET_VARS['pers_name']?$HTTP_GET_VARS['pers_name']:$HTTP_POST_VARS['pers_name'])."&pers_email=".($HTTP_GET_VARS['pers_email']?$HTTP_GET_VARS['pers_email']:$HTTP_POST_VARS['pers_email'])."&location=".($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location'])."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"7\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%">
  <tr>
  <?php
  if ($item_from>NR_DISPLAY && $HTTP_POST_VARS['show']!="all")
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&pers_name=<?php echo ($HTTP_GET_VARS['pers_name']?$HTTP_GET_VARS['pers_name']:$HTTP_POST_VARS['pers_name']);?>&pers_email=<?php echo ($HTTP_GET_VARS['pers_email']?$HTTP_GET_VARS['pers_email']:$HTTP_POST_VARS['pers_email']);?>&location=<?php echo ($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location']);?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($person_query) && $HTTP_POST_VARS['show']!="all")
  {
  $remains=$no_of_res-$item_from;
  if ($remains > NR_DISPLAY) {
      $remains = NR_DISPLAY;
  }
  ?>
  <td colspan=5 align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&pers_name=<?php echo ($HTTP_GET_VARS['pers_name']?$HTTP_GET_VARS['pers_name']:$HTTP_POST_VARS['pers_name']);?>&pers_email=<?php echo ($HTTP_GET_VARS['pers_email']?$HTTP_GET_VARS['pers_email']:$HTTP_POST_VARS['pers_email']);?>&location=<?php echo ($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location']);?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.$remains;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if ($HTTP_GET_VARS['table']=="persons")

if (($type=="job_title") or ($type=="job_category") or ($type=="job_employer"))
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $no_of_res = bx_db_num_rows($company_query);
  if($HTTP_POST_VARS['show']=="all") {
      $item_from = 0;
      $item_to = $no_of_res;
  }
?>
    <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="7" align="right" class="searchhead">Search jobs Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
            <td width="5%" align="center">&nbsp;<?php echo TEXT_TYPE;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_SEARCH_JOB_TITLE;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_EXPIRE;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;

   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['jobid'];?></td>
      <td align="center"><?php if($company_result['featuredjob']=="Y") {echo bx_image("images/fjob.gif",0,"Featured Job");} else {echo bx_image("images/njob.gif",0,"Normal Job");}?></td>
      <td align="center"><?php echo $company_result['jobtitle'];?></td>
      <td align="center"><?php if($company_result['jcompid']!=0){?><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>"><?php echo $company_result['company'];?></a><?php }else{ echo " Default Company ";}?></td>
      <td align="center"><?php echo $company_result['jobdate'];?></td>
      <td align="center"><?php echo $company_result['jobexpire'];?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&jobid=<?php echo $company_result['jobid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&job_title=".($HTTP_GET_VARS['job_title']?$HTTP_GET_VARS['job_title']:$HTTP_POST_VARS['job_title'])."&jobcategoryid=".($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid'])."&compid=".($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid'])."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"7\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
   </table>
  <br>
  <table width="100%">
  <tr>
  <?php
  if ($item_from>NR_DISPLAY && $HTTP_POST_VARS['show']!="all")
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&job_title=<?php echo ($HTTP_GET_VARS['job_title']?$HTTP_GET_VARS['job_title']:$HTTP_POST_VARS['job_title']);?>&jobcategoryid=<?php echo ($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid']);?>&compid=<?php echo ($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid']);?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($company_query) && $HTTP_POST_VARS['show']!="all")
  {
  $remains=$no_of_res-$item_from;
  if ($remains > NR_DISPLAY) {
      $remains = NR_DISPLAY;
  }
  ?>
  <td colspan=5 align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&job_title=<?php echo ($HTTP_GET_VARS['job_title']?$HTTP_GET_VARS['job_title']:$HTTP_POST_VARS['job_title']);?>&jobcategoryid=<?php echo ($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid']);?>&compid=<?php echo ($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid']);?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.$remains;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if ($HTTP_GET_VARS['table']=="jobs")

if (($type=="resume_title") or ($type=="resume_category") or ($type=="resume_persid"))
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
 $no_of_res = bx_db_num_rows($resume_query);
 if($HTTP_POST_VARS['show']=="all") {
      $item_from = 0;
      $item_to = $no_of_res;
  }
?>
   <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="7" align="right" class="searchhead">Search resumes Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="7" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_NAME;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_SEARCH_RESUME_TITLE;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_SKILLS;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</td>
            <td width="20%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($resume_result=bx_db_fetch_array($resume_query))
  {
  $rows++;
  $item++;
    if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $resume_result['resumeid'];?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&persid=<?php echo $resume_result['persid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&resume_title=".($HTTP_GET_VARS['resume_title']?$HTTP_GET_VARS['resume_title']:$HTTP_POST_VARS['resume_title'])."&jobcategoryid=".($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid'])."&persid=".($HTTP_GET_VARS['persid']?$HTTP_GET_VARS['persid']:$HTTP_POST_VARS['persid'])."&from=".$item_from);?>"><?php echo $resume_result['name'];?></a></td>
      <td align="center"><?php echo $resume_result['summary'];?></td>
      <td align="center"><?php echo $resume_result['skills'];?></td>
      <td align="center"><?php echo $resume_result['resumedate'];?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&resumeid=<?php echo $resume_result['resumeid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&resume_title=".($HTTP_GET_VARS['resume_title']?$HTTP_GET_VARS['resume_title']:$HTTP_POST_VARS['resume_title'])."&jobcategoryid=".($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid'])."&persid=".($HTTP_GET_VARS['persid']?$HTTP_GET_VARS['persid']:$HTTP_POST_VARS['persid'])."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"7\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%"> 
  <tr>
  <?php
  if ($item_from>NR_DISPLAY && $HTTP_POST_VARS['show']!="all")
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&resume_title=<?php echo ($HTTP_GET_VARS['resume_title']?$HTTP_GET_VARS['resume_title']:$HTTP_POST_VARS['resume_title']);?>&jobcategoryid=<?php echo ($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid']);?>&persid=<?php echo ($HTTP_GET_VARS['persid']?$HTTP_GET_VARS['persid']:$HTTP_POST_VARS['persid']);?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($resume_query) && $HTTP_POST_VARS['show']!="all")
  {
  $remains=$no_of_res-$item_from;
  if ($remains > NR_DISPLAY) {
      $remains = NR_DISPLAY;
  }
  ?>
  <td colspan=5 align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&resume_title=<?php echo ($HTTP_GET_VARS['resume_title']?$HTTP_GET_VARS['resume_title']:$HTTP_POST_VARS['resume_title']);?>&jobcategoryid=<?php echo ($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid']);?>&persid=<?php echo ($HTTP_GET_VARS['persid']?$HTTP_GET_VARS['persid']:$HTTP_POST_VARS['persid']);?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.$remains;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end if ($HTTP_GET_VARS['table']=="resumes")

if (($type=="invoice_id") or ($type=="invoice_pricing") or ($type=="invoice_employer"))
{
if ($HTTP_GET_VARS['from'])
  {
  $item_from=$HTTP_GET_VARS['from'];
  //$item_to=$HTTP_GET_VARS['to'];
  $item_to=$item_from+NR_DISPLAY;
  }
  else
  {
  $item_from=0;
  $item_to=NR_DISPLAY;
  }
  $no_of_res = bx_db_num_rows($company_query);
  if($HTTP_POST_VARS['show']=="all") {
      $item_from = 0;
      $item_to = $no_of_res;
  }
?>
  <table width="100%" cellpadding="1" cellspacing="1" border="0" class="listtable">
  <tr><td colspan="8" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <TR bgcolor="#FFFFFF"><td colspan="8" align="right" class="searchhead">Search invoices Showing <?php echo " (".$item_from." to ".$item_to." from ".$no_of_res.")";?></td></tr>
  <tr><td colspan="8" bgcolor="#FFFFFF"><?php echo bx_image_width("images/pix-t.gif",1,5,0,"");?></td></tr>
  <tr class="listhead">
            <td width="5%" align="center">&nbsp;<?php echo TEXT_ID;?>&nbsp;</td>
            <td width="35%" align="center">&nbsp;<?php echo TEXT_COMPANY_NAME;?>&nbsp;</td>
            <td width="10%" align="center">&nbsp;<?php echo TEXT_PRICING_TYPE;?>&nbsp;</td>
            <td width="15%" align="center">&nbsp;<?php echo TEXT_DATE_ADDED;?>&nbsp;</td>
            <td width="5%" align="center">&nbsp;<?php echo TEXT_UPGRADE_VALUE;?>&nbsp;</td>
          <?php if(USE_DISCOUNT == "yes") {?>
            <td width="10%" align="center">&nbsp;<?php echo TEXT_DISCOUNT_VALUE;?>&nbsp;</td>
         <?php }?>
            <td width="10%" align="center">&nbsp;<?php echo TEXT_PAYMENT_VALUE;?>&nbsp;</td>
            <td width="10%" align="center">&nbsp;<?php echo TEXT_ACTION;?>&nbsp;</td>
  </tr>
  <?php
  $rows=0;
  $item=0;
  while ($company_result=bx_db_fetch_array($company_query))
  {
  $rows++;
  $item++;
   if (($item<=$item_to) and ($item>=$item_from+1))
   {
   ?>
    <tr <?php if(floor($rows/2) == ($rows/2)) {echo 'bgcolor="#ffffff"';} else {echo 'bgcolor="#f4f7fd"';}?>>
      <td align="center"><?php echo $company_result['opid'];?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&compid=<?php echo $company_result['compid'];?>"><?php echo $company_result['company'];?></a></td>
      <td align="center"><?php echo $company_result['pricing_title'];?></td>
      <td align="center"><?php echo $company_result['date_added'];?></td>
      <td align="center"><?php echo bx_format_price($company_result['listprice'],$company_result['currency']);?></td>
      <?php if(USE_DISCOUNT == "yes") {?>
      <td align="center"><?php echo bx_format_price((($company_result['listprice']*$company_result['idiscount'])/100),$company_result['currency']);?></td>
      <?php }?>
      <td align="center"><?php echo bx_format_price($company_result['totalprice'],$company_result['currency']);?></td>
      <td align="center"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_DETAILS;?>?action=details&opid=<?php echo $company_result['opid'];?>&back_url=<?php echo urlencode(HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=".$action."&type=".$type."&invoice_id=".($HTTP_GET_VARS['invoice_id']?$HTTP_GET_VARS['invoice_id']:$HTTP_POST_VARS['invoice_id'])."&compid=".($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid'])."&pricingid=".($HTTP_GET_VARS['pricingid']?$HTTP_GET_VARS['pricingid']:$HTTP_POST_VARS['pricingid'])."&from=".$item_from);?>">Details</a></td>
    </tr>
   <?php
   } //end if
  } //end while $referer_result
  $item_back_from=$item_from;
  $item_from=$item_to;
  $item_to=$item_from+NR_DISPLAY;
  if (!$rows) {
      echo "<tr><td colspan=\"8\" align=\"center\" class=\"errortd\">Nothing found</td></tr>";
  }
  ?>
  </table>
  <br>
  <table width="100%">
  <tr>
  <?php
  if ($item_from>NR_DISPLAY && $HTTP_POST_VARS['show']!="all")
   {
  ?>
  <td colspan="2" align="left"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&invoice_id=<?php echo ($HTTP_GET_VARS['invoice_id']?$HTTP_GET_VARS['invoice_id']:$HTTP_POST_VARS['invoice_id']);?>&compid=<?php echo ($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid']);?>&pricingid=<?php echo ($HTTP_GET_VARS['pricingid']?$HTTP_GET_VARS['pricingid']:$HTTP_POST_VARS['pricingid']);?>&from=<?php echo $item_back_from-NR_DISPLAY;?>" class="nxt"><b><?php echo PREVIOUS.' '.NR_DISPLAY;?></b></a></td>
  <?php
   }
  if ($item_from<bx_db_num_rows($company_query) && $HTTP_POST_VARS['show']!="all")
  {
  $remains=$no_of_res-$item_from;
  if ($remains > NR_DISPLAY) {
      $remains = NR_DISPLAY;
  }
  ?>
  <td colspan="7" align="right"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>?action=<?php echo $action;?>&type=<?php echo $type;?>&invoice_id=<?php echo ($HTTP_GET_VARS['invoice_id']?$HTTP_GET_VARS['invoice_id']:$HTTP_POST_VARS['invoice_id']);?>&compid=<?php echo ($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid']);?>&pricingid=<?php echo ($HTTP_GET_VARS['pricingid']?$HTTP_GET_VARS['pricingid']:$HTTP_POST_VARS['pricingid']);?>&from=<?php echo $item_from;?>" class="nxt"><b><?php echo NEXT.' '.$remains;?></b></a></td>
  <?php
  }
  ?>
  </tr>
  </table>
<?php
}//end
?>