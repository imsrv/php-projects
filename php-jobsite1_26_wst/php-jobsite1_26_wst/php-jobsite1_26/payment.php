<?php
include ('application_config_file.php');
if ($HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $HTTP_POST_VARS['compid'])) {
          $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $invoice_result['compid']==$HTTP_POST_VARS['compid'])) {
			   include(DIR_SERVER_ROOT.'cc_payment_settings.php');
			   if($HTTP_POST_VARS['payment_mode'] == 1) {
					   include(DIR_FUNCTIONS.'cclib/cc_'.CC_PROCESSOR_TYPE.'_process.php'); 					
			   }
			   else {
                      include(DIR_SERVER_ROOT."header.php"); 
                      include(DIR_FORMS.FILENAME_PAYMENT_FORM);
                      include(DIR_SERVER_ROOT."footer.php");
			   }
          } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
          else {
               include(DIR_SERVER_ROOT."header.php");
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               include(DIR_SERVER_ROOT."footer.php");
          }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
}//end if ($HTTP_SESSION_VARS['employerid'])
else {
       $login='employer';
       include(DIR_SERVER_ROOT."header.php");
       include(DIR_FORMS.FILENAME_LOGIN_FORM);
       include(DIR_SERVER_ROOT."footer.php");
}
?>