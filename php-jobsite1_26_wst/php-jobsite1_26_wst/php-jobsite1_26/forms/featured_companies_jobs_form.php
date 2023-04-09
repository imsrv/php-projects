<table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="2">
<?php if(USE_FEATURED_COMPANIES == "yes") {?>
<tr>
         <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="#000000" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" nowrap><font style="color: <?php echo TEXT_COMPANY_FONT_COLOR;?>; font-family: arial;	font-weight: bold; font-size: 11px;"><?php echo TEXT_FEATURED_COMPANIES;?></font></td>
  </tr>
 <tr>
    <td align="left" valign="top" nowrap>
<?php
$array_comps=array();
if (FEATURED_COMPANY_ORDER==1 || FEATURED_COMPANY_ORDER==2) {
    $query = "SELECT company, compid, signupdate, logo FROM ".$bx_table_prefix."_companies WHERE TO_DAYS(".$bx_table_prefix."_companies.expire)>=TO_DAYS(NOW()) and featured='1'";
    srand((double)microtime()*1000000); // seed the random number generator
    if (FEATURED_COMPANY_ORDER==2) {
            $array_date=array();
            $array_ordcomps=array();
    }
}
else {
    $query = "SELECT company, compid, signupdate, logo FROM ".$bx_table_prefix."_companies WHERE TO_DAYS(".$bx_table_prefix."_companies.expire)>=TO_DAYS(NOW()) and featured='1' order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc";
}
$empty=0;
$result_featured_companies=bx_db_query($query);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$count_companies=bx_db_num_rows($result_featured_companies);
   if ($count_companies!=0) {
      if ($count_companies>=FEATURED_COMPANIES_NUMBER) {
          $number_random=FEATURED_COMPANIES_NUMBER;
      }
      else {
        $number_random=$count_companies;
      }
      for($i=0;$i<$number_random;$i++) {
               $rand_row = @rand(0, ($count_companies - 1));
               $exist=random_once($array_comps,$rand_row);
               if($exist!=1) {
                  $array_comps[$i]=$rand_row;
               }
               else {
                   $i--;
               }
      } 
      if (FEATURED_COMPANY_ORDER==1) {
                  
      }
      elseif (FEATURED_COMPANY_ORDER==2) {
           $i=0;
           while($i<sizeof($array_comps))            
                {
                  $company=bx_db_data_seek($result_featured_companies, $array_comps[$i]);
                  $result_companies=bx_db_fetch_array($result_featured_companies);
                  $array_date[$array_comps[$i]] =$result_companies['signupdate']; 
                  $i++;
                } 
                arsort($array_date);
                while(list($key)=each($array_date)) {
                        $array_ordcomps[]=$key;    
                }
                $array_comps=$array_ordcomps;
      }
      else {
              for($i=0;$i<$number_random;$i++) {
                  $array_comps[$i]=$i;
              }
      }
    }  
    else {
           $empty=1;
    }
    $i=0;
    if($empty!=1) {  
       while($i<sizeof($array_comps)) {
         $record=bx_db_data_seek($result_featured_companies, $array_comps[$i]);
         $result_companies=bx_db_fetch_array($result_featured_companies);
         echo"&nbsp;&nbsp;<a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$result_companies['compid'], "auth_sess", $bx_session)."\">"."<font class=\"featcomp\">".short_string(trim($result_companies['company']), 25)."</font></a><br>";
         if($i==FEATURED_COMPANIES_NUMBER) {
             break;
         }
         $i++;
       }
    }  
    else {
      echo"&nbsp;&nbsp;<font style=\"font-weight: bold; font-size: 10px;\"><b>".TEXT_NONE.".</b></font><br>";
    }       
?>
</td>
</tr>
<?php
}
else {
    echo "<tr><td>&nbsp;</td></tr>";
}
if(USE_FEATURED_JOBS == "yes") {?>
<tr>
     <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="#000000" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></td>
  </tr>
  <tr>
         <td align="left" valign="top"><font style="color: <?php echo TEXT_COMPANY_FONT_COLOR;?>; font-family: arial;	font-weight: bold; font-size: 11px;"><?php echo ucfirst(TEXT_FEATURED_JOBS);?></font></td>
</tr>
<tr>
         <td align="left" valign="top" nowrap>
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
   if ($count_jobs!=0) {
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
   else  {
          $empty=1;
           echo"&nbsp;&nbsp;<font style=\"font-weight: bold; font-size: 10px;\">".TEXT_NONE.".</font><br>";
   }
   $j=0;
   if($empty!=1)
         {
         while($j<sizeof($array_jobs))            //$jobs=bx_db_fetch_array($result_featured_jobs)
            {
              $job=bx_db_data_seek($result_featured_jobs, $array_jobs[$j]);
              $result_jobs=bx_db_fetch_array($result_featured_jobs);
              echo"&nbsp;&nbsp;<a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$result_jobs['jobid'], "auth_sess", $bx_session)."\">"."<font class=\"featjobs\">".short_string(trim($result_jobs['jobtitle']), 25)."</font></a><br>";
              if($j==FEATURED_JOBS_NUMBER)
                {
                  break;
                }
              $j++;
            }
        }//end if empty
?>
</td>
</tr>
<?php }?>
</table>