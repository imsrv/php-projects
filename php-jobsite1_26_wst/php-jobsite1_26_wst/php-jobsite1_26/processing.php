<?php
if($bx_sess_name = ini_get("session.name")) {}
else {
    $bx_sess_name = "PHPSESSID";
}
if(!$HTTP_COOKIE_VARS[$bx_sess_name] && $HTTP_POST_VARS['auth_sess']) {
    $HTTP_COOKIE_VARS[$bx_sess_name]=$HTTP_POST_VARS['auth_sess'];
    session_id($HTTP_COOKIE_VARS[$bx_sess_name]);
}
if(!$HTTP_COOKIE_VARS[$bx_sess_name] && $HTTP_GET_VARS['auth_sess']) {
    $HTTP_COOKIE_VARS[$bx_sess_name]=$HTTP_GET_VARS['auth_sess'];
    session_id($HTTP_COOKIE_VARS[$bx_sess_name]);
}
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_INVOICES);
$jsfile="company.js";
if ($HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $HTTP_POST_VARS['compid']))
      {   
          if(!$HTTP_POST_VARS['opid']) {
             if ($HTTP_SESSION_VARS['curr_opid']) {
                 $HTTP_POST_VARS['opid'] = $HTTP_SESSION_VARS['curr_opid'];
             }
             if ($HTTP_POST_VARS['invoice']) {
                 $HTTP_POST_VARS['opid'] = $HTTP_POST_VARS['invoice'];
             }
          }
          if(!$HTTP_POST_VARS['payment_mode']){
                 if ($HTTP_SESSION_VARS['curr_pmode']) {
                     $HTTP_POST_VARS['payment_mode'] = $HTTP_SESSION_VARS['curr_pmode'];
                 }
                 if ($HTTP_POST_VARS['custom']) {
                     $HTTP_POST_VARS['payment_mode'] = $HTTP_POST_VARS['custom'];
                 }
          }
          $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency, ".$bx_table_prefix."_invoices.discount as invoice_discount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng.",".$bx_table_prefix."_companies where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_invoices.compid");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $invoice_result['compid']==$HTTP_POST_VARS['compid'])) {
               if ($HTTP_POST_VARS['payment_mode']==1) {
                        include(DIR_SERVER_ROOT.'cc_payment_settings.php');
                        include(DIR_FUNCTIONS.'cclib/cc_'.CC_PROCESSOR_TYPE.'_process.php'); 					
               }//end if ($HTTP_POST_VARS['payment_mode']==1)
               if ($HTTP_POST_VARS['payment_mode']==2) {
                  $themessage.="          Invoice details (No: ".$invoice_result['opid'].")\n";
                  $themessage.="-----------------------Begin Company information(Sender)---------\n";
                  $themessage.="Company name: ".$invoice_result['company']."\n";
                  $themessage.="Company email: ".$invoice_result['email']."\n";
                  $themessage.="Address: ".$invoice_result['address']."\n";
                  if ($invoice_result['url']) {
                            $themessage.="Website: ".$invoice_result['url']."\n";
                  }
                  $themessage.="Company details: ".HTTP_SERVER."view.php?company_id=".$invoice_result['compid']."\n";
                  $themessage.="-----------------------End Company information---------\n\n";
                  $themessage.="-----------------------Begin Payment information---------\n";
                  $themessage.="List Price: ".bx_format_price($invoice_result['listprice'],$invoice_result['icurrency'])."\n";
                  if(USE_DISCOUNT == "yes" || ($invoice_result['invoice_discount']!=0)) {
                         $themessage.="Discount: ".bx_format_price((($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['invoice_discount']." %)"."\n";
                  }
                  if(USE_VAT == "yes") {
                         if(USE_DISCOUNT == "yes" || ($invoice_result['invoice_discount']!=0)) {
                                    $themessage.="Price with discount: ".bx_format_price($invoice_result['listprice']-(($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency'])."\n";
                         }
                         $themessage.="VAT: ".bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['invoice_discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)"."\n";
                  }
                  $themessage.="Total Price: ".bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency'])."\n";
                  $themessage.="Payment date: ".bx_format_date(date('Y-m-d'), DATE_FORMAT)."\n";
                  $themessage.="Description: ".$HTTP_POST_VARS['payment_description']."\n\n";
                  $themessage.="-----------------------Begin Payment modalities---------\n";
                  $themessage.="Customer selected payment modality: \n";
                  $themessage.="          ".${TEXT_PAYMENT_OPT.$HTTP_POST_VARS['payment_mode']}."\n";
                  $themessage.="-----------------------End Payment modalities---------\n\n";
                  $themessage.=(($invoice_result['pricing_type']==0)?"Payment description: ":"Upgrade to: ").$invoice_result['pricing_title']."\n";
                  $themessage.="Details: ".HTTP_SERVER_ADMIN."admin.php?action=".(($invoce_result['pricing_type']=='0')?"buyers":"upgrades")."\n";
                  $themessage.="-----------------------End Payment information---------\n";
                  $themessage.=SITE_SIGNATURE."\n";
                  bx_mail(SITE_NAME,SITE_MAIL,SITE_NAME."<".SITE_MAIL.">",TEXT_INVOICE_NUMBER.": ".$invoice_result['opid'],$themessage,"no");
                  $mailfile = $language."/mail/invoice_manualprocess.txt";
                  include(DIR_LANGUAGES.$mailfile.".cfg.php");
                  $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                  $invoice_result['listprice'] = bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);
                  $invoice_result['invoice_discount'] = bx_format_price((($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['invoice_discount']." %)";
                  $invoice_result['vat'] = bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['invoice_discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";
                  $invoice_result['totalprice'] = bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);
                  $invoice_result['invoice_paymentdate'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                  if ($html_mail == "no") {
                       $invoice_result['payment_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",PAYMENT_INFORMATION)));
                       $invoice_result['company_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",COMPANY_INFORMATION)));
                  }
                  else {
                       $invoice_result['payment_information'] = PAYMENT_INFORMATION;
                       $invoice_result['company_information'] = COMPANY_INFORMATION;
                  }
                  $invoice_result['description'] = $HTTP_POST_VARS['payment_description'];
                  reset($fields);
                  while (list($h, $v) = each($fields)) {
                          $mail_message = eregi_replace($v[0],$invoice_result[$h],$mail_message);
                          $file_mail_subject = eregi_replace($v[0],$invoice_result[$h],$file_mail_subject);
                  }
                  if ($add_mail_signature == "on") {
                          $mail_message .= "\n".SITE_SIGNATURE;
                  }
                  bx_mail(SITE_NAME,SITE_MAIL,$invoice_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                  bx_db_query("UPDATE ".$bx_table_prefix."_invoices set date_added='".date('Y-m-d')."', payment_date='".date('Y-m-d')."', paid='Y', updated='N', validated='N', payment_mode='".$HTTP_POST_VARS['payment_mode']."',info='".$HTTP_POST_VARS['payment_description']."' where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."'");
                  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                  include(DIR_SERVER_ROOT."header.php");
                  include(DIR_FORMS.FILENAME_PROCESSING_FORM);
                  include(DIR_SERVER_ROOT."footer.php");      
               }//end if ($HTTP_POST_VARS['payment_mode']==2)
           } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
           else {
               include(DIR_SERVER_ROOT."header.php");
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=HTTP_SERVER.FILENAME_MYINVOICES;
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               include(DIR_SERVER_ROOT."footer.php");      
           }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
      }//end if exist action==pay
      else  {
          $login='employer';
          include(DIR_SERVER_ROOT."header.php");
          include(DIR_FORMS.FILENAME_LOGIN_FORM);
          include(DIR_SERVER_ROOT."footer.php");      
      }
?>