<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_MEMBERSHIP);
$jsfile="membership.js";
if ($HTTP_SESSION_VARS['employerid']) {
       if ($HTTP_POST_VARS['action']=="upgrade")
       {
        $can_upgrade=bx_db_query("select opid from ".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.compid='".$HTTP_SESSION_VARS['employerid']."' and (".$bx_table_prefix."_invoices.paid='N' or ".$bx_table_prefix."_invoices.updated='N' or ".$bx_table_prefix."_invoices.validated='N')");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        if (bx_db_num_rows($can_upgrade)==0) {
          if ($HTTP_POST_VARS['radio']==$HTTP_POST_VARS['current_pricing'])
          {
                  $success_message=TEXT_NO_UPGRADE;
                  $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session);
                  include(DIR_SERVER_ROOT."header.php");
                  include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                  include(DIR_SERVER_ROOT."footer.php");
          }//end radio=current_pricing
         else
         {
          $pricing_query=bx_db_query("SELECT pricing_title, pricing_avjobs, pricing_avsearch, pricing_fjobs, pricing_fcompany, pricing_period, pricing_price, pricing_currency FROM ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_id='".$HTTP_POST_VARS['radio']."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $pricing_result=bx_db_fetch_array($pricing_query);
          $discount_query=bx_db_query("SELECT discount FROM ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $discount_result=bx_db_fetch_array($discount_query);
          if ($discount_result['discount']!=0) {
                      $companydiscount = $discount_result['discount'];
          }
          else {
                      if (USE_DISCOUNT == "yes") {
                                $companydiscount = DISCOUNT_PROCENT;
                      }
                      else {
                                $companydiscount = 0;
                      }
          }
          if (USE_VAT == "yes") {
                    $vat = VAT_PROCENT;
          }
          else {
                    $vat = 0;
          }
          bx_db_insert($bx_table_prefix."_invoices","op_type,compid,pricing_type,info,listprice,currency,payment_mode,discount,vat,totalprice,description,paid","'1','".$HTTP_SESSION_VARS['employerid']."','".$HTTP_POST_VARS['radio']."','','".$pricing_result['pricing_price']."','".$pricing_result['pricing_currency']."','','".$companydiscount."','".$vat."','".(($pricing_result['pricing_price']-(($pricing_result['pricing_price']*$companydiscount)/100))+ ((($pricing_result['pricing_price']-(($pricing_result['pricing_price']*$companydiscount)/100))*$vat)/100))."','','N'");
          $opid=bx_db_insert_id();
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session));
          bx_exit();
         }//end else radio!=current_pricing
        }//end if (bx_db_num_rows($can_upgrade==0))
        else {
            $error_message=CAN_UPGRADE_ERROR;
            $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
            include(DIR_SERVER_ROOT."header.php");
            include(DIR_FORMS.FILENAME_ERROR_FORM);
            include(DIR_SERVER_ROOT."footer.php");
        }//end else if (bx_db_num_rows($can_upgrade==0))
       }//end if exist action==upgrade
       elseif($HTTP_POST_VARS['action']=="buy")
       {
       $error=0;
       if ($HTTP_POST_VARS['jobs']) {
              if (verify($HTTP_POST_VARS['jobs'],"int")!=1) {
                  $jobs_to_add=$HTTP_POST_VARS['jobs'];
                  $jobs_error=0;
              }
              else {
                  $error=1;
                  $jobs_error=1;
                  $jobs_to_add=0;
              }
        }
        else {
            $jobs_to_add=0;
            $jobs_error=0;
        }
        if ($HTTP_POST_VARS['fjobs']) {
              if (verify($HTTP_POST_VARS['fjobs'],"int")!=1) {
                  $fjobs_to_add=$HTTP_POST_VARS['fjobs'];
                  $fjobs_error=0;
              }
              else {
                  $error=1;
                  $fjobs_error=1;
                  $fjobs_to_add=0;
              }
        }
        else {
            $fjobs_to_add=0;
            $fjobs_error=0;
        }
        if ($HTTP_POST_VARS['resumes']) {
              if (verify($HTTP_POST_VARS['resumes'],"int")!=1) {
                  $resumes_to_add=$HTTP_POST_VARS['resumes'];
                  $resumes_error=0;
              }
              else {
                  $error=1;
                  $resumes_error=1;
                  $resumes_to_add=0;
              }
        }
        else {
            $resumes_to_add=0;
            $resumes_error=0;
        }
         if ((!$HTTP_POST_VARS['jobs']) && (!$HTTP_POST_VARS['fjobs']) && (!$HTTP_POST_VARS['resumes'])) {
          $error=1;
          $jobs_error=1;
          $fjobs_error=1;
          $resumes_error=1;
        }
        if ($error==0) {
           $can_buy=bx_db_query("select opid from ".$bx_table_prefix."_invoices where compid='".$HTTP_SESSION_VARS['employerid']."' and (paid='N' or updated='N' or validated='N')");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           if (bx_db_num_rows($can_buy)==0) {
            $temp_price=($jobs_to_add*JOBS_PRICE)+($fjobs_to_add*FEATURED_JOBS_PRICE)+($resumes_to_add*RESUMES_PRICE);
            $discount_query=bx_db_query("SELECT discount FROM ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $discount_result=bx_db_fetch_array($discount_query);
            if ($discount_result['discount']!=0) {
                    $companydiscount = $discount_result['discount'];
            }
            else {
                    if (USE_DISCOUNT == "yes") {
                            $companydiscount = DISCOUNT_PROCENT_JOBS;
                    }
                    else {
                            $companydiscount = 0;
                    }
            }
            if (USE_VAT == "yes") {
                    $vat = VAT_PROCENT;
            }
            else {
                    $vat = 0;
            }
            bx_db_insert($bx_table_prefix."_invoices","op_type,compid,pricing_type,jobs,featuredjobs,contacts,1job,1featuredjob,1contact,info,listprice,currency,payment_mode,discount,vat,totalprice,description,paid","'0','".$HTTP_SESSION_VARS['employerid']."','0','".$jobs_to_add."','".$fjobs_to_add."','".$resumes_to_add."','".JOBS_PRICE."','".FEATURED_JOBS_PRICE."','".RESUMES_PRICE."','','".$temp_price."','".PRICE_CURENCY."','','".$companydiscount."','".$vat."','".(($temp_price-($temp_price*$companydiscount)/100) + ((($temp_price-(($temp_price*$companydiscount)/100))*$vat)/100))."','','N'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session));
            bx_exit();
        }//end if (bx_db_num_rows($can_buy==0))
        else {
            $error_message=CAN_BUY_ERROR;
            $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
            include(DIR_SERVER_ROOT."header.php");
            include(DIR_FORMS.FILENAME_ERROR_FORM);
            include(DIR_SERVER_ROOT."footer.php");
        }//end else if (bx_db_num_rows($can_buy==0))
        }
        else {
            include(DIR_SERVER_ROOT."header.php");
            include(DIR_FORMS.FILENAME_MEMBERSHIP_FORM);
            include(DIR_SERVER_ROOT."footer.php");
        }
       }//end if action==buy
       else
       {   
           include(DIR_SERVER_ROOT."header.php");
           include(DIR_FORMS.FILENAME_MEMBERSHIP_FORM);
           include(DIR_SERVER_ROOT."footer.php");
       } //end else not exist action
}
else
{
        $login='employer';
        include(DIR_SERVER_ROOT."header.php");
        include(DIR_FORMS.FILENAME_LOGIN_FORM);
        include(DIR_SERVER_ROOT."footer.php");
}
?>