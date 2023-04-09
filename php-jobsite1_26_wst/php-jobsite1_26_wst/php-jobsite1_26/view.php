<?php
include ('application_config_file.php');
if ($HTTP_GET_VARS['printit']=="yes") {
    echo "<html><head><title>".date('F d, Y ')."  ".SITE_TITLE."</title>";
    echo "<SCRIPT Language=\"Javascript\">\n";
    echo "function printit(){  \n";
    echo "var navver = parseInt(navigator.appVersion);\n";
    echo "if (navver > 3) {\n";
    echo "   if (window.print) {\n";
    echo "        parent.pmain.focus();\n";
    echo "        window.print() ;\n";  
    echo "    }\n";
    echo "}\n";
    echo "return false;\n";
    echo "}\n";
    echo "</script>\n";
    if($HTTP_GET_VARS['preview']=="resume") {
            ?>
            <script language="Javascript">
            <!--
             if (navigator.appName == "Netscape") {
                  if(navigator.userAgent.indexOf("Netscape6") > 0) {
                     document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
                  } else {
                     if(navigator.userAgent.indexOf("4.") > 0) {
                        document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php?type=ns\" type=\"text/css\">");
                     } else {
                        document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
                     }
                  }
               }
            else if (navigator.userAgent.indexOf("MSIE") > 0) {
                  document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
            }
            else {
                  document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
            }
            //-->
            </script>
            <noscript>
                <link rel="stylesheet" href="<?php echo $css_file_dir;?>css.php" type="text/css">
            </noscript>
       <?php  
       }
       echo "</head><body>\n";
}
else {
    include(DIR_SERVER_ROOT."header.php");    
}
     $view_error = false;
     if ($HTTP_GET_VARS['resume_id']) {
         $view_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_GET_VARS['resume_id']."'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         if (bx_db_num_rows($view_query)>0) {
             $view_query_result=bx_db_fetch_array($view_query);
         }
         else {  
               $view_error = true;
         }
     }
     if ($HTTP_POST_VARS['resume_id']) {
         $view_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_POST_VARS['resume_id']."'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         if (bx_db_num_rows($view_query)>0) {
             $view_query_result=bx_db_fetch_array($view_query);
         }
         else {  
               $view_error = true;
         }
     }
     if ($HTTP_GET_VARS['person_id']) {
         $view_query=bx_db_query("select * from ".$bx_table_prefix."_persons,".$bx_table_prefix."_locations_".$bx_table_lng." where persid='".$HTTP_GET_VARS['person_id']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_persons.locationid");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         if (bx_db_num_rows($view_query)>0) {
             $view_query_result=bx_db_fetch_array($view_query);
         }
         else {  
               $view_error = true;
         }
     }
     if ($HTTP_GET_VARS['job_id']) {
         $view_query=bx_db_query("select *, ".$bx_table_prefix."_companies.locationid as clocationid, ".$bx_table_prefix."_jobs.compid as jcompid,".$bx_table_prefix."_jobs.jobtitle as jtitle, ".$bx_table_prefix."_jobs.city as jcity, ".$bx_table_prefix."_jobs.province as jprovince, ".$bx_table_prefix."_jobs.description as jdescription, ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory as title from ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs,".$bx_table_prefix."_locations_".$bx_table_lng." , ".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.jobid='".$HTTP_GET_VARS['job_id']."' and (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0) and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid= ".$bx_table_prefix."_jobs.jobcategoryid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         if (bx_db_num_rows($view_query)>0) {
             $view_query_result=bx_db_fetch_array($view_query);
             $jobview_query=bx_db_query("select jobid from ".$bx_table_prefix."_jobview where jobid='".$HTTP_GET_VARS['job_id']."'");
             if (bx_db_num_rows($jobview_query)!=0)  {
                 if (!$HTTP_GET_VARS['employer']) {
                      bx_db_query("update ".$bx_table_prefix."_jobview set viewed=viewed+1, lastdate=NOW() where jobid='".$HTTP_GET_VARS['job_id']."'");
                 }//end if (!$HTTP_GET_VARS['employer'])
             }//end if (bx_db_num_rows($jobview_query)!=0)
             else {
                 if (!$HTTP_GET_VARS['employer']) {
                     bx_db_insert($bx_table_prefix."_jobview","jobid,viewed,lastdate",$HTTP_GET_VARS['job_id'].",1,NOW()");
                 }    
             }//end else if (bx_db_num_rows($jobview_query)!=0)    
          }
          else {  
               $view_error = true;
          }
      }
      if ($HTTP_GET_VARS['company_id']) {
          $view_query=bx_db_query("select * from ".$bx_table_prefix."_companies,".$bx_table_prefix."_locations_".$bx_table_lng." where compid='".$HTTP_GET_VARS['company_id']."' and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_companies.locationid");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          if (bx_db_num_rows($view_query)>0) {
               $view_query_result=bx_db_fetch_array($view_query);
          }
          else {  
               $view_error = true;
          }
      }
      if ($view_error) {
          $error_message=TEXT_UNAUTHORIZED_ACCESS;
          $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
          include(DIR_FORMS.FILENAME_ERROR_FORM);
      }
      else {
          include(DIR_FORMS.FILENAME_VIEW_FORM);           
      }
if(!$HTTP_GET_VARS['printit']) {
    include(DIR_SERVER_ROOT."footer.php");    
}
?>