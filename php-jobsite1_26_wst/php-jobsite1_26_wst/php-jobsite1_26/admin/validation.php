<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
if (!get_magic_quotes_gpc()) {
    while (list($header, $value) = each($HTTP_POST_VARS)) {
         if(is_array($HTTP_POST_VARS[$header])){
            for ( $i=0 ;$i<sizeof($HTTP_POST_VARS[$header]);$i++) {
                $HTTP_POST_VARS[$header][$i] = addslashes($HTTP_POST_VARS[$header][$i]);
            }
         }
         else {
            $HTTP_POST_VARS[$header] = addslashes($HTTP_POST_VARS[$header]);
         }    
    }
}
include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);
if (($HTTP_POST_VARS['action']=="upgrades") && ($HTTP_POST_VARS['compid']))
{
   bx_db_query("update ".$bx_table_prefix."_invoices set date_added='".$HTTP_POST_VARS['date_added']."', payment_mode='".$HTTP_POST_VARS['payment_mode']."',info='".$HTTP_POST_VARS['info']."',description='".$HTTP_POST_VARS['description']."',payment_date='".$HTTP_POST_VARS['pdate_added']."',paid='Y',validated='Y' where opid='".$HTTP_POST_VARS['opid']."'");
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency,".$bx_table_prefix."_invoices.description as description, ".$bx_table_prefix."_invoices.discount as invoice_discount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_companies,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid = ".$bx_table_prefix."_invoices.compid");
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $invoice_result=bx_db_fetch_array($invoice_query);
   $mailfile = $language."/mail/upgrade_adminapproved.txt";
   include(DIR_LANGUAGES.$mailfile.".cfg.php");
   $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
   $invoice_result['listprice'] = bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);
   $invoice_result['invoice_discount'] = bx_format_price((($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['invoice_discount']." %)";
   $invoice_result['vat'] = bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['invoice_discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";
   $invoice_result['totalprice'] = bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);
   $invoice_result['invoice_paymentdate'] = bx_format_date($invoice_result['payment_date'], DATE_FORMAT);
   if ($html_mail == "no") {
        $invoice_result['payment_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",PAYMENT_INFORMATION)));
        $invoice_result['company_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",COMPANY_INFORMATION)));
   }
   else {
        $invoice_result['payment_information'] = PAYMENT_INFORMATION;
        $invoice_result['company_information'] = COMPANY_INFORMATION;
   }
   if($invoice_result['payment_mode'] == 1) {
              $trans_query = bx_db_query("SELECT * from ".$bx_table_prefix."_cctransactions where opid = '".$invoice_result['opid']."'");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
              if(bx_db_num_rows($trans_query)>0) {
                     $cc_transaction_result = bx_db_fetch_array($trans_query);
                     include(DIR_FUNCTIONS."cclib/class.rc4crypt.php");
                     include(DIR_SERVER_ROOT."cc_payment_settings.php");   
                     $decoder=new rc4crypt();   
                     $invoice_result['auth_name'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_name'],"de");
                     $invoice_result['auth_type'] =$decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_type'],"de");	
                     $invoice_result['auth_ccnum'] = eregi_replace('([0-9])','x', $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_num'],"de"));
                     $invoice_result['auth_ccvcode'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_cvc'],"de");
                     $invoice_result['auth_exp'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_exp'],"de");
                     $invoice_result['auth_comm'] = $invoice_result['info'];
                     if(CC_AVS == "yes") {
                            $invoice_result['auth_street'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_street'],"de");	
                            $invoice_result['auth_city'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_city'],"de");			
                            $invoice_result['auth_state'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_state'],"de");					
                            $invoice_result['auth_zip'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_zip'],"de");							
                            $invoice_result['auth_country'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_country'],"de");							
                            $invoice_result['auth_phone'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_phone'],"de");											
                            $invoice_result['auth_email'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_email'],"de");													
                     }
              }
   }
   reset($fields);
   while (list($h, $v) = each($fields)) {
           $mail_message = eregi_replace($v[0],$invoice_result[$h],$mail_message);
           $file_mail_subject = eregi_replace($v[0],$invoice_result[$h],$file_mail_subject);
   }
   if ($add_mail_signature == "on") {
           $mail_message .= "\n".SITE_SIGNATURE;
   }
   bx_mail(SITE_NAME,SITE_MAIL,$invoice_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
   if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
   }
   else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
   }
   bx_exit();
}//end if action=upgrades and compid

if (($HTTP_POST_VARS['action']=="buyers") && ($HTTP_POST_VARS['compid']))
   {
   bx_db_query("update ".$bx_table_prefix."_invoices set date_added='".$HTTP_POST_VARS['date_added']."', payment_mode='".$HTTP_POST_VARS['payment_mode']."',info='".$HTTP_POST_VARS['info']."',description='".$HTTP_POST_VARS['description']."',payment_date='".$HTTP_POST_VARS['pdate_added']."',paid='Y',validated='Y' where opid='".$HTTP_POST_VARS['opid']."'");
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency,".$bx_table_prefix."_invoices.description as description, ".$bx_table_prefix."_invoices.discount as invoice_discount from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_companies,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_POST_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type and ".$bx_table_prefix."_companies.compid = ".$bx_table_prefix."_invoices.compid");
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $invoice_result=bx_db_fetch_array($invoice_query);
   $mailfile = $language."/mail/buyer_adminapproved.txt";
   include(DIR_LANGUAGES.$mailfile.".cfg.php");
   $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
   $invoice_result['listprice'] = bx_format_price($invoice_result['listprice'],$invoice_result['icurrency']);
   $invoice_result['invoice_discount'] = bx_format_price((($invoice_result['listprice']*$invoice_result['invoice_discount'])/100),$invoice_result['icurrency'])." (".$invoice_result['invoice_discount']." %)";
   $invoice_result['vat'] = bx_format_price(((($invoice_result['listprice']-($invoice_result['listprice']*$invoice_result['invoice_discount'])/100))*$invoice_result['vat']/100),$invoice_result['currency'])." (".$invoice_result['vat']." %)";
   $invoice_result['totalprice'] = bx_format_price($invoice_result['totalprice'],$invoice_result['icurrency']);
   $invoice_result['invoice_paymentdate'] = bx_format_date($invoice_result['payment_date'], DATE_FORMAT);
   if ($html_mail == "no") {
        $invoice_result['payment_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",PAYMENT_INFORMATION)));
        $invoice_result['company_information'] = eregi_replace("<br>","\n",eregi_replace("&nbsp;"," ",eregi_replace("<ul>|<li>|</ul>|</li>|<p>|</p>","",COMPANY_INFORMATION)));
   }
   else {
        $invoice_result['payment_information'] = PAYMENT_INFORMATION;
        $invoice_result['company_information'] = COMPANY_INFORMATION;
   }
   if($invoice_result['payment_mode'] == 1) {
          $trans_query = bx_db_query("SELECT * from ".$bx_table_prefix."_cctransactions where opid = '".$invoice_result['opid']."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          if(bx_db_num_rows($trans_query)>0) {
                 $cc_transaction_result = bx_db_fetch_array($trans_query);
                 include(DIR_FUNCTIONS."cclib/class.rc4crypt.php");
                 include(DIR_SERVER_ROOT."cc_payment_settings.php");   
                 $decoder=new rc4crypt();   
                 $invoice_result['auth_name'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_name'],"de");
                 $invoice_result['auth_type'] =$decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_type'],"de");	
                 $invoice_result['auth_ccnum'] = eregi_replace('([0-9])','x', $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_num'],"de"));
                 $invoice_result['auth_ccvcode'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_cvc'],"de");
                 $invoice_result['auth_exp'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_exp'],"de");
                 $invoice_result['auth_comm'] = $invoice_result['info'];
                 if(CC_AVS == "yes") {
                        $invoice_result['auth_street'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_street'],"de");	
                        $invoice_result['auth_city'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_city'],"de");			
                        $invoice_result['auth_state'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_state'],"de");					
                        $invoice_result['auth_zip'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_zip'],"de");							
                        $invoice_result['auth_country'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_country'],"de");							
                        $invoice_result['auth_phone'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_phone'],"de");											
                        $invoice_result['auth_email'] = $decoder->endecrypt(CRYPT_PHRASE,$cc_transaction_result['cc_email'],"de");													
                 }
          }
   }
   reset($fields);
   while (list($h, $v) = each($fields)) {
           $mail_message = eregi_replace($v[0],$invoice_result[$h],$mail_message);
           $file_mail_subject = eregi_replace($v[0],$invoice_result[$h],$file_mail_subject);
   }
   if ($add_mail_signature == "on") {
           $mail_message .= "\n".SITE_SIGNATURE;
   }
   bx_mail(SITE_NAME,SITE_MAIL,$invoice_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
   if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
   }
   else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
   }
   bx_exit();
}//end if action=buyers and compid
if (($HTTP_POST_VARS['action']=="details") && ($HTTP_POST_VARS['compid']))
   {
   if ($HTTP_POST_VARS['btnDelete']!="") {
       $employer_query = bx_db_query("select * from ".$bx_table_prefix."_companies where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       $employer_result = bx_db_fetch_array($employer_query);
       bx_db_query("insert into del".$bx_table_prefix."_companies select * from ".$bx_table_prefix."_companies where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("delete from ".$bx_table_prefix."_companies where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("delete from ".$bx_table_prefix."_companycredits where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("insert into del".$bx_table_prefix."_jobs select * from ".$bx_table_prefix."_jobs where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       $job_query = bx_db_query("select jobid from ".$bx_table_prefix."_jobs where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       while ($job_result = bx_db_fetch_array($job_query)) {
           bx_db_query("delete from ".$bx_table_prefix."_jobview where jobid=\"".$job_result['jobid']."\"");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       }
       bx_db_query("delete from ".$bx_table_prefix."_jobs where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("insert into del".$bx_table_prefix."_invoices select * from ".$bx_table_prefix."_invoices where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("delete from ".$bx_table_prefix."_invoices where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("insert into del".$bx_table_prefix."_membership select * from ".$bx_table_prefix."_membership where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("delete from ".$bx_table_prefix."_membership where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("delete from ".$bx_table_prefix."_resumemail where compid=\"".$HTTP_POST_VARS['compid']."\"");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       if ($employer_result['logo'] && file_exists(DIR_LOGO.$employer_result['logo'])) {
            @unlink(DIR_LOGO.$employer_result['logo']);
       }
       if ($HTTP_POST_VARS['back_url']) {
           header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
       }
       else {
           header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
       }
       bx_exit();
   }//end if ($HTTP_POST_VARS['btnDelete']!="")
   else {
               
          if ((!empty($HTTP_POST_FILES['company_logo']['tmp_name'])) && ($HTTP_POST_FILES['company_logo']['tmp_name']!="none") ) {
              $logo_size=getimagesize($HTTP_POST_FILES['company_logo']['tmp_name']);
              if (($logo_size[0]>LOGO_MAX_WIDTH) || ($logo_size[1]>LOGO_MAX_HEIGHT) || ($HTTP_POST_FILES['company_logo']['size']>LOGO_MAX_SIZE) || (!in_array($HTTP_POST_FILES['company_logo']['type'],array ("image/gif","image/pjpeg","image/jpeg","image/x-png")))) {
                    include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER);
                    $error_message=LOGO_ERROR;
                    $back_url=HTTP_SERVER_ADMIN."/".FILENAME_ADMIN_DETAILS."?action=details&compid=".$HTTP_POST_VARS['compid'];
                    include(DIR_FORMS."/".FILENAME_ERROR_FORM);
                    bx_exit();
              }//end if (($logo_size[0]>120) || ($logo_size[1]>60) || (!in_array($company_logo_type,array ("image/gif","image/jpg","image/png"))))
              else {
                  switch ($logo_size[2]) {
                      case 1:
                           $logo_extension=".gif";
                           break;
                      case 2:
                           $logo_extension=".jpg";
                           break;
                      case 3:
                           $logo_extension=".png";
                           break;
                      default:
                           $logo_extension="";
                      }//end switch ($logo_size[2])
                      bx_db_query("update ".$bx_table_prefix."_companies set logo = '".$HTTP_POST_VARS['compid'].$logo_extension."' where compid = '".$HTTP_POST_VARS['compid']."'");
                      $image_location = DIR_LOGO. $HTTP_POST_VARS['compid'].$logo_extension;
                      if (file_exists($image_location)) {
                          @unlink($image_location);
                      }//end if (file_exists($image_location))
                      move_uploaded_file($HTTP_POST_FILES['company_logo']['tmp_name'], $image_location);
                      @chmod($image_location, 0777);
                 }//end else if (($logo_size[0]>120) || ($logo_size[1]>60) || (!in_array($company_logo_type,array ("image/gif","image/jpg","image/png"))))
       }//end if ((!empty($company_logo)) && ($company_logo!="none") )
       bx_db_query("update ".$bx_table_prefix."_companies set company='".htmlspecialchars($HTTP_POST_VARS['company'])."',description='".htmlspecialchars($HTTP_POST_VARS['description'])."', address='".htmlspecialchars($HTTP_POST_VARS['address'])."' , city='".htmlspecialchars($HTTP_POST_VARS['city'])."' , province='".htmlspecialchars($HTTP_POST_VARS['province'])."' , postalcode='".htmlspecialchars($HTTP_POST_VARS['postalcode'])."' , locationid='".$HTTP_POST_VARS['location']."' , phone='".htmlspecialchars($HTTP_POST_VARS['phone'])."' , fax='".htmlspecialchars($HTTP_POST_VARS['fax'])."' , email='".$HTTP_POST_VARS['email']."' , url='".htmlspecialchars($HTTP_POST_VARS['url'])."', password='".$HTTP_POST_VARS['password']."', hide_address='".$HTTP_POST_VARS['hide_address']."', hide_location='".$HTTP_POST_VARS['hide_location']."', hide_phone='".$HTTP_POST_VARS['hide_phone']."', hide_fax='".$HTTP_POST_VARS['hide_fax']."', hide_email='".$HTTP_POST_VARS['hide_email']."', discount='".$HTTP_POST_VARS['discount']."', expire='".$HTTP_POST_VARS['expire']."', featured='".$HTTP_POST_VARS['featured']."' where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       bx_db_query("UPDATE ".$bx_table_prefix."_companycredits set jobs='".$HTTP_POST_VARS['jobs']."', featuredjobs='".$HTTP_POST_VARS['featuredjobs']."',contacts='".$HTTP_POST_VARS['contacts']."' where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       $membership_query = bx_db_query("SELECT pricing_id from ".$bx_table_prefix."_membership where compid='".$HTTP_POST_VARS['compid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       if (bx_db_num_rows($membership_query)>0) {
           bx_db_query("UPDATE ".$bx_table_prefix."_membership set pricing_id='".$HTTP_POST_VARS['pricing_id']."' where compid='".$HTTP_POST_VARS['compid']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       }
       else {
           bx_db_insert($bx_table_prefix."_membership","compid,pricing_id","'".$HTTP_POST_VARS['compid']."','".$HTTP_POST_VARS['pricing_id']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       }
       if ($HTTP_POST_VARS['back_url']) {
            header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
       }
       else {
            header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
       }
       bx_exit();
   }//end else if ($HTTP_POST_VARS['btnDelete']!="")
 }//end if action=details and compid
if (($HTTP_POST_VARS['action']=="details") && ($HTTP_POST_VARS['persid']))
   {
   if ($HTTP_POST_VARS['btnDelete']!="")
   {
    $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_POST_VARS['persid']."'");
    if(bx_db_num_rows($resume_query)!=0)
       {
         $resume_result=bx_db_fetch_array($resume_query);
         $cv_file_location = DIR_RESUME.$resume_result['resume_cv'];
         if (file_exists($cv_file_location)) {
              @unlink($cv_file_location);
         }//end if (file_exists($cv_file_location))
    }     
    bx_db_query("insert into del".$bx_table_prefix."_resumes select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_POST_VARS['persid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_resumes where persid=\"".$HTTP_POST_VARS['persid']."\"");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("insert into del".$bx_table_prefix."_persons select * from ".$bx_table_prefix."_persons where persid='".$HTTP_POST_VARS['persid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_persons where persid=\"".$HTTP_POST_VARS['persid']."\"");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_jobmail where persid=\"".$HTTP_POST_VARS['persid']."\"");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
    }
    else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
    }
    bx_exit();
   }//end if ($HTTP_POST_VARS['btnDelete']!="")
   else
   {
       bx_db_query("update ".$bx_table_prefix."_persons set name='".htmlspecialchars($HTTP_POST_VARS['name'])."' , address='".htmlspecialchars($HTTP_POST_VARS['address'])."' , city='".htmlspecialchars($HTTP_POST_VARS['city'])."' , province='".htmlspecialchars($HTTP_POST_VARS['province'])."' , postalcode='".htmlspecialchars($HTTP_POST_VARS['postalcode'])."' , locationid='".$HTTP_POST_VARS['location']."' , gender='".$HTTP_POST_VARS['gender']."'  , birthyear='".$HTTP_POST_VARS['birthyear']."'  , phone='".htmlspecialchars($HTTP_POST_VARS['phone'])."' , fax='".htmlspecialchars($HTTP_POST_VARS['fax'])."' , email='".$HTTP_POST_VARS['email']."' , url='".htmlspecialchars($HTTP_POST_VARS['url'])."', password='".$HTTP_POST_VARS['password']."', hide_name='".$HTTP_POST_VARS['hide_name']."', hide_address='".$HTTP_POST_VARS['hide_address']."', hide_location='".$HTTP_POST_VARS['hide_location']."', hide_phone='".$HTTP_POST_VARS['hide_phone']."', hide_email='".$HTTP_POST_VARS['hide_email']."' where persid='".$HTTP_POST_VARS['persid']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       if ($HTTP_POST_VARS['back_url']) {
            header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
       }
       else {
            header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
       }
       bx_exit();
   }//end else if ($HTTP_POST_VARS['btnDelete']!="")
 }//end if action=details and persid

if (($HTTP_POST_VARS['action']=="details") && ($HTTP_POST_VARS['jobid']))
   {
   if ($HTTP_POST_VARS['btnDelete']!="")
   {
    bx_db_query("insert into del".$bx_table_prefix."_jobs select * from ".$bx_table_prefix."_jobs where jobid='".$HTTP_POST_VARS['jobid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_jobs where jobid=\"".$HTTP_POST_VARS['jobid']."\"");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_jobview where jobid=\"".$HTTP_POST_VARS['jobid']."\"");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
    }
    else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
    }
    bx_exit();

   }//end if ($HTTP_POST_VARS['btnDelete']!="")
   else
   {
      for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++)
                    {
               $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                     }
                     //calculating lang
                    $i=1;
                    while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
                    {
                     if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)])
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                        }
                        else
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                        }
                     $i++;
                    }
     if ($HTTP_POST_VARS['job_link']) {
          if (!strstr($HTTP_POST_VARS['job_link'], "http://")) {
                $HTTP_POST_VARS['job_link'] = "http://".$HTTP_POST_VARS['job_link'];
         }
     }                    
     bx_db_query("update ".$bx_table_prefix."_jobs set description='".htmlspecialchars($HTTP_POST_VARS['description'])."',jobtitle='".htmlspecialchars($HTTP_POST_VARS['jobtitle'])."',jobcategoryid='".$HTTP_POST_VARS['jobcategoryid']."',locationid='".$HTTP_POST_VARS['location']."',province='".htmlspecialchars($HTTP_POST_VARS['province'])."',skills='".htmlspecialchars($HTTP_POST_VARS['skills'])."',jobtypeids='".$calc_jobtypeids."',salary='".htmlspecialchars($HTTP_POST_VARS['salary'])."',degreeid='".$HTTP_POST_VARS['degreeid']."',experience='".htmlspecialchars($HTTP_POST_VARS['experience'])."',city='".htmlspecialchars($HTTP_POST_VARS['city'])."',languageids='".$calc_lang."',postlanguage='".$HTTP_POST_VARS['languageid']."', hide_compname='".$HTTP_POST_VARS['hide_compname']."', contact_name='".htmlspecialchars($HTTP_POST_VARS['contact_name'])."', hide_contactname='".$HTTP_POST_VARS['hide_contactname']."', contact_email='".$HTTP_POST_VARS['contact_email']."', hide_contactemail='".$HTTP_POST_VARS['hide_contactemail']."', contact_phone='".$HTTP_POST_VARS['contact_phone']."', hide_contactphone='".$HTTP_POST_VARS['hide_contactphone']."', contact_fax='".$HTTP_POST_VARS['contact_fax']."', hide_contactfax='".$HTTP_POST_VARS['hide_contactfax']."', job_link='".htmlspecialchars($HTTP_POST_VARS['job_link'])."', jobexpire='".$HTTP_POST_VARS['jobexpire']."', jobdate='".$HTTP_POST_VARS['jobdate']."', featuredjob = '".$HTTP_POST_VARS['featuredjob']."' where jobid='".$HTTP_POST_VARS['jobid']."'");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
     }
     else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
     }
     bx_exit();
   }//end else if ($HTTP_POST_VARS['btnDelete']!="")
 }//end if action=details and jobid

 if (($HTTP_POST_VARS['action']=="details") && ($HTTP_POST_VARS['resumeid']))
   {
   $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_POST_VARS['resumeid']."'");
   $resume_result=bx_db_fetch_array($resume_query);
   if ($HTTP_POST_VARS['btnDelete']!="")
   {
    $cv_file_location = DIR_RESUME.$resume_result['resume_cv'];
    if (file_exists($cv_file_location)) {
      @unlink($cv_file_location);
    }//end if (file_exists($cv_file_location))  
    bx_db_query("insert into del".$bx_table_prefix."_resumes select * from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_POST_VARS['resumeid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    bx_db_query("delete from ".$bx_table_prefix."_resumes where resumeid='".$HTTP_POST_VARS['resumeid']."'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
    }
    else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
    }
    bx_exit();
   }//end if ($HTTP_POST_VARS['btnDelete']!="")
   else
   {
     //looking for errors
     $error=0;
     //summary validation
     if ($HTTP_POST_VARS['summary']=="")  {
          $error=1;
          $summary_error=1;
     }
     else {
          $summary_error=0;
     }
     if (sizeof($HTTP_POST_VARS['jobtypeids'])==0) {
          $error=1;
          $emplyment_type_error=1;
     }
     else {
          $emplyment_type_error=0;
     }
     if(verify($HTTP_POST_VARS['salary'],"int")==1) {
          $error=1;
          $salary_error=1;
     }
     else {
          $salary_error=0;
     }
     if(verify($HTTP_POST_VARS['experience'],"int")==1) {
          $error=1;
          $expyears_error=1;
     }
     else {
          $expyears_error=0;
     }
     if ($error=="0") {
          // echo "update";
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
                           print $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                     }
          //calculating lang
                    $i=1;
                    while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
                    {
                     if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)])
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                        }
                        else
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                        }
                     $i++;
                  }
     bx_db_query("update ".$bx_table_prefix."_resumes set summary='".htmlspecialchars($HTTP_POST_VARS['summary'])."',resume='".htmlspecialchars($HTTP_POST_VARS['resume'])."',education='".htmlspecialchars($HTTP_POST_VARS['education'])."',workexperience='".htmlspecialchars($HTTP_POST_VARS['workexperience'])."',degreeid='".$HTTP_POST_VARS['degreeid']."',confidential='".$HTTP_POST_VARS['confidential']."',jobtypeids='".$calc_jobtypeids."',locationids='-".$calc_locationids."',jobcategoryids='-".$calc_jobcategoryids."',salary='".htmlspecialchars($HTTP_POST_VARS['salary'])."',skills='".htmlspecialchars($HTTP_POST_VARS['skills'])."',jobmail='".$HTTP_POST_VARS['jobmail']."',languageids='".$calc_lang."',postlanguage='".$HTTP_POST_VARS['languageid']."',experience='".htmlspecialchars($HTTP_POST_VARS['experience'])."',resume_city='".htmlspecialchars($HTTP_POST_VARS['resume_city'])."',resume_province='".htmlspecialchars($HTTP_POST_VARS['resume_province'])."',resumedate='".$HTTP_POST_VARS['resumedate']."',resumeexpire='".$HTTP_POST_VARS['resumeexpire']."' where resumeid='".$HTTP_POST_VARS['resumeid']."'");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     if ((!empty($HTTP_POST_FILES['resume_cv']['tmp_name'])) && ($HTTP_POST_FILES['resume_cv']['tmp_name']!="none") ) {
                     $cv_file_location = DIR_RESUME.$resume_result['persid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name']);
                     if ($resume_result['resume_cv']!="") {
                         $old_cv_location=DIR_RESUME.$resume_result['resume_cv'];
                         if (file_exists($old_cv_location)) {
                              @unlink($old_cv_location);
                         }//end if (file_exists($old_cv_location))
                     }
                     if (file_exists($cv_file_location)) {
                          @unlink($cv_file_location);
                      }//end if (file_exists($cv_file_location))
                      move_uploaded_file($HTTP_POST_FILES['resume_cv']['tmp_name'], $cv_file_location);
                      @chmod($cv_file_location, 0777);
                      bx_db_query("update ".$bx_table_prefix."_resumes set resume_cv = '" .$resume_result['persid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name']). "' where resumeid = '".$HTTP_POST_VARS['resumeid']."'"); 
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     }//end if ((!empty($resume_cv)) && ($resume_cv!="none") )
     if ($HTTP_POST_VARS['back_url']) {
        header("Location: ".bx_stripslashes(urldecode($HTTP_POST_VARS['back_url'])));
     }
     else {
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
     }
     bx_exit();
     }
     else {
           echo "Errors in the input fields.";
           echo bx_table_header(ERRORS_OCCURED_RESUME);
           echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
           if ($summary_error=="1") echo SUMMARY_ERROR."<br>";
           if ($emplyment_type_error=="1") echo EMPLOYMENT_ERRROR."<br>";
           if($salary_error==1) echo SALARY_ERROR."<br>";
           if($expyears_error==1) echo EXPYEARS_ERROR."<br>";
           echo "</font>";
     }
   }//end else if ($HTTP_POST_VARS['btnDelete']!="")
 }//end if action=details and resumeid

if (($HTTP_POST_VARS['action']=="details") && ($HTTP_POST_VARS['opid'])) {
   if ($HTTP_POST_VARS['btnDelete']!="")
   {
            bx_db_query("insert into del".$bx_table_prefix."_invoices select * from ".$bx_table_prefix."_invoices where opid='".$HTTP_POST_VARS['opid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            bx_db_query("delete from ".$bx_table_prefix."_invoices where opid=\"".$HTTP_POST_VARS['opid']."\"");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            bx_db_query("delete from ".$bx_table_prefix."_cctransactions where opid=\"".$HTTP_POST_VARS['opid']."\"");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            if ($HTTP_POST_VARS['back_url']) {
                header("Location: ".urldecode($HTTP_POST_VARS['back_url']));
            }
            else {
                header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
            }
            bx_exit();
   }//end if ($HTTP_POST_VARS['btnDelete']!="")
   else
   {
           if ($HTTP_POST_VARS['back_url']) {
                header("Location: ".urldecode($HTTP_POST_VARS['back_url']));
           }
           else {
                header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=".$HTTP_POST_VARS['action']);
           }
           bx_exit();
   }//end else if ($HTTP_POST_VARS['btnDelete']!="")
}//end if action=details and opid
if ($HTTP_POST_VARS['action']=="add_comp") {
        bx_db_insert($bx_table_prefix."_companies","company,address,city,province,postalcode,locationid,phone,fax,description,email,url,password,hide_address,hide_location,hide_phone,hide_fax,hide_email,featured,signupdate,expire, lastlogin","'".htmlspecialchars($HTTP_POST_VARS['company'])."','".htmlspecialchars($HTTP_POST_VARS['address'])."','".htmlspecialchars($HTTP_POST_VARS['city'])."','".htmlspecialchars($HTTP_POST_VARS['province'])."' ,'".htmlspecialchars($HTTP_POST_VARS['postalcode'])."' ,'".$HTTP_POST_VARS['location']."' ,'".htmlspecialchars($HTTP_POST_VARS['phone'])."' ,'".htmlspecialchars($HTTP_POST_VARS['fax'])."' , '".htmlspecialchars($HTTP_POST_VARS['description'])."','".$HTTP_POST_VARS['email']."' ,'".htmlspecialchars($HTTP_POST_VARS['url'])."','".$HTTP_POST_VARS['password']."','".$HTTP_POST_VARS['hide_address']."','".$HTTP_POST_VARS['hide_location']."','".$HTTP_POST_VARS['hide_phone']."','".$HTTP_POST_VARS['hide_fax']."','".$HTTP_POST_VARS['hide_email']."','".$HTTP_POST_VARS['featured']."',NOW(),'".$HTTP_POST_VARS['expire']."', NOW()");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $compid=bx_db_insert_id();
        bx_db_insert($bx_table_prefix."_companycredits","compid,jobs,featuredjobs,contacts","'".$compid."','".$HTTP_POST_VARS['jobs']."','".$HTTP_POST_VARS['featuredjobs']."','".$HTTP_POST_VARS['contacts']."'");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		if ((!empty($company_logo)) && ($company_logo!="none") ) {
              $logo_size=getimagesize($company_logo);
              if (($logo_size[0]>LOGO_MAX_WIDTH) || ($logo_size[1]>LOGO_MAX_HEIGHT) || ($company_logo_size>LOGO_MAX_SIZE) || (!in_array($company_logo_type,array ("image/gif","image/pjpeg","image/jpeg","image/x-png")))) {
                    include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER);
                    $error_message=LOGO_ERROR;
                    $back_url=HTTP_SERVER_ADMIN."/".FILENAME_ADMIN_DETAILS."?action=details&compid=".$compid;
                    include(DIR_FORMS."/".FILENAME_ERROR_FORM);
                    bx_exit();
              }//end if (($logo_size[0]>120) || ($logo_size[1]>60) || (!in_array($company_logo_type,array ("image/gif","image/jpg","image/png"))))
              else {
                  switch ($logo_size[2]) {
                      case 1:
                           $logo_extension=".gif";
                           break;
                      case 2:
                           $logo_extension=".jpg";
                           break;
                      case 3:
                           $logo_extension=".png";
                           break;
                      default:
                           $logo_extension="";
                      }//end switch ($logo_size[2])
                      bx_db_query("update ".$bx_table_prefix."_companies set logo = '".$compid.$logo_extension."' where compid = '".$compid."'");
                      $image_location = DIR_LOGO. $compid.$logo_extension;
                      if (file_exists($image_location)) {
                          @unlink($image_location);
                      }//end if (file_exists($image_location))
                      move_uploaded_file($company_logo, $image_location);
                 }//end else if (($logo_size[0]>120) || ($logo_size[1]>60) || (!in_array($company_logo_type,array ("image/gif","image/jpg","image/png"))))
       }//end if ((!empty($company_logo)) && ($company_logo!="none") )
       bx_db_insert($bx_table_prefix."_membership","compid,pricing_id","'".$compid."','".$HTTP_POST_VARS['pricing_id']."'");
       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
       header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=details&type=comp_location&location=000");
       bx_exit();
}
if (($HTTP_POST_VARS['action']=="add_job"))
   {
      //caculating jobcatypeids
      for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
            $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
      }
      //calculating lang
      $i=1;
      while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
            if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)])
            {
                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
            }
            else
            {
                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
            }
         $i++;
      }
      if ($HTTP_POST_VARS['job_link']) {
          if (!strstr($view_query_result['url'], "http://")) {
                $HTTP_POST_VARS['job_link'] = "http://".$HTTP_POST_VARS['job_link'];
         }
      }     
      bx_db_insert($bx_table_prefix."_jobs","compid,jobtitle,jobcategoryid,description,locationid,province,skills,jobtypeids,salary,degreeid,experience,city,jobdate,languageids,postlanguage,featuredjob,hide_compname,contact_name,hide_contactname,contact_email,hide_contactemail,contact_phone,hide_contactphone,contact_fax,hide_contactfax,job_link,jobexpire","'".$HTTP_POST_VARS['compid']."','".htmlspecialchars($HTTP_POST_VARS['jobtitle'])."','".$HTTP_POST_VARS['jobcategoryid']."','".htmlspecialchars($HTTP_POST_VARS['description'])."','".$HTTP_POST_VARS['location']."','".htmlspecialchars($HTTP_POST_VARS['province'])."','".htmlspecialchars($HTTP_POST_VARS['skills'])."','".$calc_jobtypeids."','".htmlspecialchars($HTTP_POST_VARS['salary'])."','".$HTTP_POST_VARS['degreeid']."','".htmlspecialchars($HTTP_POST_VARS['experience'])."','".htmlspecialchars($HTTP_POST_VARS['city'])."','".$HTTP_POST_VARS['jobdate']."','".$calc_lang."','".$HTTP_POST_VARS['languageid']."','".$HTTP_POST_VARS['featured']."','".$HTTP_POST_VARS['hide_compname']."','".htmlspecialchars($HTTP_POST_VARS['contact_name'])."','".$HTTP_POST_VARS['hide_contactname']."','".$HTTP_POST_VARS['contact_email']."','".$HTTP_POST_VARS['hide_contactemail']."','".$HTTP_POST_VARS['contact_phone']."','".$HTTP_POST_VARS['hide_contactphone']."','".$HTTP_POST_VARS['contact_fax']."','".$HTTP_POST_VARS['hide_contactfax']."','".htmlspecialchars($HTTP_POST_VARS['job_link'])."','".$HTTP_POST_VARS['jobexpire']."'");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     $new_jobid = bx_db_insert_id();
     bx_db_insert($bx_table_prefix."_jobview","jobid,viewed,lastdate",$new_jobid.",0,NOW()");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH."?action=details&type=job_category&jobcategoryid=000&tm=".time());
}//end if action=details and jobid
?>