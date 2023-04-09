<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
include("header.php");
function search_prep($str){
    return bx_addslashes(htmlspecialchars(strtolower(trim($str))));
}
if($HTTP_POST_VARS['type']) {
    $type=$HTTP_POST_VARS['type'];
}
elseif ($HTTP_GET_VARS['type']){
     $type = $HTTP_GET_VARS['type'];
}
else {
    $type = '';
}
if ($type!="")
      {
       if ($type=="comp_email") {
             $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid and email like \"".($HTTP_GET_VARS['comp_email']?$HTTP_GET_VARS['comp_email']:$HTTP_POST_VARS['comp_email'])."\" order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       }//end if ($HTTP_POST_VARS['type']=="comp_email")
       elseif ($type=="comp_name")
         {
              $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid and LCASE(company) like \"%".search_prep(($HTTP_GET_VARS['comp_name']?$HTTP_GET_VARS['comp_name']:$HTTP_POST_VARS['comp_name']))."%\" order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         }//end elseif ($HTTP_POST_VARS['type']=="comp_name")
         elseif ($type=="comp_location")
         {
             if ($HTTP_POST_VARS['location']=="000" || $HTTP_GET_VARS['location']=="000")
             {
                 $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else {
                 $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid and  ".$bx_table_prefix."_companies.locationid='".($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location'])."' order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['jobcategoryid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="job_category")
        elseif ($type=="pers_email") {
             $person_query=bx_db_query("select *,".$bx_table_prefix."_persons.persid as apersid from ".$bx_table_prefix."_persons left join ".$bx_table_prefix."_resumes on ".$bx_table_prefix."_resumes.persid = ".$bx_table_prefix."_persons.persid where email like \"".($HTTP_GET_VARS['pers_email']?$HTTP_GET_VARS['pers_email']:$HTTP_POST_VARS['pers_email'])."\" order by ".$bx_table_prefix."_persons.signupdate desc, ".$bx_table_prefix."_persons.persid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        }
        elseif ($type=="pers_name")
         {
          $person_query=bx_db_query("select *,".$bx_table_prefix."_persons.persid as apersid from ".$bx_table_prefix."_persons left join ".$bx_table_prefix."_resumes on ".$bx_table_prefix."_resumes.persid = ".$bx_table_prefix."_persons.persid where LCASE(name) like \"%".search_prep(($HTTP_GET_VARS['pers_name']?$HTTP_GET_VARS['pers_name']:$HTTP_POST_VARS['pers_name']))."%\" order by ".$bx_table_prefix."_persons.signupdate desc, ".$bx_table_prefix."_persons.persid desc");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         }//end elseif ($HTTP_POST_VARS['type']=="pers_name")
         elseif ($type=="pers_location")
         {
             if ($HTTP_GET_VARS['location']=="000" || $HTTP_POST_VARS['location']=="000")
             {
             $person_query=bx_db_query("select *,".$bx_table_prefix."_persons.persid as apersid from ".$bx_table_prefix."_persons left join ".$bx_table_prefix."_resumes on ".$bx_table_prefix."_resumes.persid = ".$bx_table_prefix."_persons.persid order by ".$bx_table_prefix."_persons.signupdate desc, ".$bx_table_prefix."_persons.persid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else
             {
             $person_query=bx_db_query("select *,".$bx_table_prefix."_persons.persid as apersid from ".$bx_table_prefix."_persons left join ".$bx_table_prefix."_resumes on ".$bx_table_prefix."_resumes.persid = ".$bx_table_prefix."_persons.persid where ".$bx_table_prefix."_persons.locationid='".($HTTP_GET_VARS['location']?$HTTP_GET_VARS['location']:$HTTP_POST_VARS['location'])."' order by ".$bx_table_prefix."_persons.signupdate desc, ".$bx_table_prefix."_persons.persid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['jobcategoryid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="pers_location")
        elseif ($type=="job_title")
         {
          $company_query=bx_db_query("select *,".$bx_table_prefix."_jobs.compid as jcompid from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where LCASE(jobtitle) like \"%".search_prep(($HTTP_GET_VARS['job_title']?$HTTP_GET_VARS['job_title']:$HTTP_POST_VARS['job_title']))."%\" and (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0) GROUP by ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

         }//end elseif ($HTTP_POST_VARS['type']=="job_title")
         elseif ($type=="job_category")
         {
             if ($HTTP_GET_VARS['jobcategoryid']=="000" || $HTTP_POST_VARS['jobcategoryid']=="000")
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_jobs.compid as jcompid from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0) GROUP by ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_jobs.compid as jcompid from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.jobcategoryid=\"".($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid'])."\" and (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0) GROUP by ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['jobcategoryid']=="000")
		 }
		elseif ($type=="job_employer") {
	        if ($HTTP_GET_VARS['compid']=="000" || $HTTP_POST_VARS['compid']=="000")
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_jobs.compid as jcompid from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0) GROUP by ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_jobs.compid as jcompid from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.compid=\"".($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid'])."\" and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid order by ".$bx_table_prefix."_jobs.jobdate desc, ".$bx_table_prefix."_jobs.jobid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['compid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="job_employer")
	   elseif ($type=="resume_title")
         {
          $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where LCASE(".$bx_table_prefix."_resumes.summary) like \"%".search_prep(($HTTP_GET_VARS['resume_title']?$HTTP_GET_VARS['resume_title']:$HTTP_POST_VARS['resume_title']))."%\" and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid order by ".$bx_table_prefix."_resumes.resumedate desc, ".$bx_table_prefix."_resumes.resumeid desc");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

         }//end elseif ($HTTP_POST_VARS['type']=="resume_title")
         elseif ($type=="resume_persid")
         {
             if ($HTTP_GET_VARS['persid']=="000" || $HTTP_POST_VARS['persid']=="000")
             {
                 $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_persons.persid order by ".$bx_table_prefix."_resumes.resumedate desc, ".$bx_table_prefix."_resumes.resumeid desc");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else
             {
                 $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid = '".($HTTP_GET_VARS['persid']?$HTTP_GET_VARS['persid']:$HTTP_POST_VARS['persid'])."' and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid order by ".$bx_table_prefix."_resumes.resumedate desc, ".$bx_table_prefix."_resumes.resumeid desc");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['jobcategoryid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="resume_category")
        elseif ($type=="resume_category")
         {
             if ($HTTP_GET_VARS['jobcategoryid']=="000" || $HTTP_POST_VARS['jobcategoryid']=="000")
             {
             $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_persons.persid order by ".$bx_table_prefix."_resumes.resumedate desc, ".$bx_table_prefix."_resumes.resumeid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['jobcategoryid']=="000")
             else
             {
             $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where (POSITION('-".($HTTP_GET_VARS['jobcategoryid']?$HTTP_GET_VARS['jobcategoryid']:$HTTP_POST_VARS['jobcategoryid'])."-' IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0) and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid order by ".$bx_table_prefix."_resumes.resumedate desc, ".$bx_table_prefix."_resumes.resumeid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['jobcategoryid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="resume_category")
        elseif ($type=="invoice_id")
         {
          $company_query=bx_db_query("select *,".$bx_table_prefix."_invoices.discount as idiscount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where opid=\"".$HTTP_POST_VARS['invoice_id']."\" and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid order by ".$bx_table_prefix."_invoices.opid desc");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         }//end elseif ($HTTP_POST_VARS['type']=="invoices_id")
        elseif ($type=="invoice_employer")
          {
            if ($HTTP_GET_VARS['compid']=="000" || $HTTP_POST_VARS['compid']=="000")
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_invoices.discount as idiscount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid order by ".$bx_table_prefix."_invoices.opid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['pricingid']=="000")
             else
             {
			 $company_query=bx_db_query("select *,".$bx_table_prefix."_invoices.discount as idiscount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_invoices.compid='".($HTTP_GET_VARS['compid']?$HTTP_GET_VARS['compid']:$HTTP_POST_VARS['compid'])."' and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid order by ".$bx_table_prefix."_invoices.opid desc");
			 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['pricingid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="invoice_employer")
        elseif ($type=="invoice_pricing")
          {
            if ($HTTP_GET_VARS['pricingid']=="000" || $HTTP_POST_VARS['pricingid']=="000")
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_invoices.discount as idiscount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid order by ".$bx_table_prefix."_invoices.opid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end if ($HTTP_POST_VARS['pricingid']=="000")
             else
             {
             $company_query=bx_db_query("select *,".$bx_table_prefix."_invoices.discount as idiscount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id='".($HTTP_GET_VARS['pricingid']?$HTTP_GET_VARS['pricingid']:$HTTP_POST_VARS['pricingid'])."' and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid order by ".$bx_table_prefix."_invoices.opid desc");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end else if ($HTTP_POST_VARS['pricingid']=="000")
        }//end elseif ($HTTP_POST_VARS['type']=="invoice_pricing")

      include(DIR_ADMIN.FILENAME_ADMIN_SEARCH_RESULT_FORM);
      }//end if ($HTTP_POST_VARS['type']!="")
      else
      {
      include(DIR_ADMIN.FILENAME_ADMIN_SEARCH_FORM);
      }//end else if ($HTTP_POST_VARS['type']!="")
include("footer.php");
?>