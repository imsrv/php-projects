<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_COMPANY);
$jsfile="company.js";
if($HTTP_POST_VARS['action']) {
    $action = $HTTP_POST_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
include(DIR_SERVER_ROOT."header.php");
if ($HTTP_POST_VARS['validation'])
       {
         $error=0;
         if (($HTTP_POST_VARS['company']=="") || (strlen($HTTP_POST_VARS['company'])<ENTRY_COMAPANY_MIN_LENGTH))
           {
           $error=1;
           $company_error=1;
           }
         else
           {
          $company_error=0;
           }
           if (($HTTP_POST_VARS['address']=="") || (strlen($HTTP_POST_VARS['address'])<ENTRY_ADDRESS_MIN_LENGTH))
           {
           $error=1;
           $address_error=1;
           }
         else
           {
          $address_error=0;
           }
           if (($HTTP_POST_VARS['city']=="") || (strlen($HTTP_POST_VARS['city'])<ENTRY_CITY_MIN_LENGTH))
           {
           $error=1;
           $city_error=1;
           }
           else
           {
          $city_error=0;
           }
            if (($HTTP_POST_VARS['postalcode']=="") || (strlen($HTTP_POST_VARS['postalcode'])<ENTRY_POSTALCODE_MIN_LENGTH))
           {
           $error=1;
           $postalcode_error=1;
           }
           else
           {
          $postalcode_error=0;
           }
           if (($HTTP_POST_VARS['phone']=="") || (strlen($HTTP_POST_VARS['phone'])<ENTRY_PHONE_MIN_LENGTH)  || (verify($HTTP_POST_VARS['phone'],"phone")==1))
           {
           $error=1;
           $phone_error=1;
           }
           else
           {
          $phone_error=0;
           }
           if (($HTTP_POST_VARS['email']=="") || (strlen($HTTP_POST_VARS['email'])<ENTRY_EMAIL_MIN_LENGTH) || (!eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs)))
           {
           $error=1;
           $email_error=1;
           }
           else
           {
          $email_error=0;
           }
           $email_query=bx_db_query("select * from ".$bx_table_prefix."_companies where email like '".$HTTP_POST_VARS['email']."' and compid!='".$HTTP_SESSION_VARS['employerid']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           $email_number=bx_db_num_rows($email_query);
           if (($email_number!=0) && ($check_email))
           {
           $error=1;
             $email_result=bx_db_fetch_array($email_query);
             if ($email_result['email']==$HTTP_POST_VARS['email']) {
                   $allready_email_error=1;
             }
               else {$allready_email_error=0;}
           }
           else
           {
           $allready_email_error=0;
           }
           if (($HTTP_POST_VARS['password']=="") || (strlen($HTTP_POST_VARS['password'])<ENTRY_PASSWORD_MIN_LENGTH))
           {
           $error=1;
           $password_error=1;
           }
         else
           {
          $password_error=0;
           }
           if (($HTTP_POST_VARS['password']!=$HTTP_POST_VARS['confpassword']) || (strlen($HTTP_POST_VARS['confpassword'])<ENTRY_PASSWORD_MIN_LENGTH))
           {
           $error=1;
           $confpassword_error=1;
           }
         else
           {
          $confpassword_error=0;
           }
           if ($HTTP_POST_VARS['agree']=="") {
                $error=1;
                $terms_error=1;
           }
           else {
                $terms_error=0;
           }
      }//end if validation etc
      if ($HTTP_SESSION_VARS['employerid'])
       {
        if ($action=="comp_form")
         {
        $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $company_result=bx_db_fetch_array($company_query);
        include(DIR_FORMS.FILENAME_COMPANY_FORM);
         }  //end if action=comp_form
         // validating information
       if ($action=="comp_update")
         {
          if ($error==1) //we have errors
           {
          include(DIR_FORMS.FILENAME_COMPANY_FORM);
           } //end if error=1
          else //no errors
           {
         bx_db_query("update ".$bx_table_prefix."_companies set company='".bx_dirty_words($HTTP_POST_VARS['company'])."', address='".bx_dirty_words($HTTP_POST_VARS['address'])."' , city='".bx_dirty_words($HTTP_POST_VARS['city'])."' , province='".bx_dirty_words($HTTP_POST_VARS['province'])."' , postalcode='".bx_dirty_words($HTTP_POST_VARS['postalcode'])."' , locationid='".$HTTP_POST_VARS['location']."' , phone='".bx_dirty_words($HTTP_POST_VARS['phone'])."' , fax='".bx_dirty_words($HTTP_POST_VARS['fax'])."' , description='".bx_dirty_words($HTTP_POST_VARS['description'])."', email='".$HTTP_POST_VARS['email']."' , url='".bx_dirty_words($HTTP_POST_VARS['url'])."', password='".bx_addslashes($HTTP_POST_VARS['password'])."', hide_address='".$HTTP_POST_VARS['hide_address']."', hide_location='".$HTTP_POST_VARS['hide_location']."', hide_phone='".$HTTP_POST_VARS['hide_phone']."', hide_fax='".$HTTP_POST_VARS['hide_fax']."', hide_email='".$HTTP_POST_VARS['hide_email']."' where compid='".$HTTP_SESSION_VARS['employerid']."'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         //bx_db_query("update keywords set login='".$HTTP_POST_VARS['login']."' , password='".$HTTP_POST_VARS['password']."' where userid='".$HTTP_SESSION_VARS['employerid']."'");
         $success_message=TEXT_MODIFICATION_SUCCESS;
         $back_url=bx_make_url(HTTP_SERVER.FILENAME_COMPANY."?action=comp_form", "auth_sess", $bx_session);
         include(DIR_FORMS.FILENAME_MESSAGE_FORM);
           } //end else error=1
         } //end if action=comp_update
       } //end if we have employerid
      else //no employerid
       {
       if ($HTTP_POST_VARS['new_company']) //creating a new account
       {
        if ($error==1) //we have errors
           {
          include(DIR_FORMS.FILENAME_COMPANY_FORM);
           } //end if error=1
          else //no errors
           {
            if($HTTP_POST_VARS['radio']==0)
              {
                $featured="no";
              } else
                  {
                    $featured="yes";
                  }
                  if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){
                          $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
                  }
                  else {
                          $IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
                  }
          bx_db_insert($bx_table_prefix."_companies","company,address,city,province,postalcode,locationid,phone,fax,description,email,url,password,hide_address,hide_location,hide_phone,hide_fax,hide_email,featured,signupdate, lastlogin,lastip","'".bx_dirty_words($HTTP_POST_VARS['company'])."','".bx_dirty_words($HTTP_POST_VARS['address'])."','".bx_dirty_words($HTTP_POST_VARS['city'])."','".bx_dirty_words($HTTP_POST_VARS['province'])."' ,'".bx_dirty_words($HTTP_POST_VARS['postalcode'])."' ,'".$HTTP_POST_VARS['location']."' ,'".bx_dirty_words($HTTP_POST_VARS['phone'])."' ,'".bx_dirty_words($HTTP_POST_VARS['fax'])."' , '".bx_dirty_words($HTTP_POST_VARS['description'])."','".$HTTP_POST_VARS['email']."' ,'".bx_dirty_words($HTTP_POST_VARS['url'])."','".bx_addslashes($HTTP_POST_VARS['password'])."','".$HTTP_POST_VARS['hide_address']."','".$HTTP_POST_VARS['hide_location']."','".$HTTP_POST_VARS['hide_phone']."','".$HTTP_POST_VARS['hide_fax']."','".$HTTP_POST_VARS['hide_email']."','0','".date('Y-m-d')."', NOW(),'".$IP."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $compid=bx_db_insert_id();
          bx_db_insert($bx_table_prefix."_companycredits","compid,jobs,featuredjobs,contacts","'".$compid."','0','0','0'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		  $pricing_query=bx_db_query("SELECT * from ".$bx_table_prefix."_pricing_".$bx_table_lng." where pricing_default='1'");
		  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		  if (bx_db_num_rows($pricing_query)!=0) {
		       $pricing_result = bx_db_fetch_array($pricing_query);
			   bx_db_query("UPDATE ".$bx_table_prefix."_companycredits set jobs='".$pricing_result['pricing_avjobs']."', featuredjobs='".$pricing_result['pricing_fjobs']."',contacts='".$pricing_result['pricing_avsearch']."' where compid='".$compid."'");
               bx_db_insert($bx_table_prefix."_membership","compid,pricing_id","'".$compid."','".$pricing_result['pricing_id']."'");
               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               bx_db_query("UPDATE ".$bx_table_prefix."_companies set expire='".date('Y-m-d',mktime (0,0,0,date('m')+$pricing_result['pricing_period'],date('d'),date('Y')))."' where compid='".$compid."'");
               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               if ($pricing_result['pricing_fcompany']=="yes") {
                    bx_db_query("update ".$bx_table_prefix."_companies set featured=1 where compid='".$compid."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               }
          }
          
		  //send mail to registered company
          $mailfile = $language."/mail/employer_registration.txt";
          include(DIR_LANGUAGES.$mailfile.".cfg.php");
          $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
          reset($fields);
          while (list($h, $v) = each($fields)) {
               $mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
               $file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
          }
          if ($add_mail_signature == "on") {
               $mail_message .= "\n".SITE_SIGNATURE;
          }
          bx_mail(SITE_NAME,SITE_MAIL,$HTTP_POST_VARS['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
          $success_message=TEXT_NEW_COMPANY_CREATION_SUCCESS;
          $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);
          include(DIR_FORMS.FILENAME_MESSAGE_FORM);
          }  //end else error=1
       } //end if newaccount
     else {
           if ($action=="comp_form") {
                $login='employer';
                include(DIR_FORMS.FILENAME_LOGIN_FORM);
           }
           else {
             include(DIR_FORMS.FILENAME_COMPANY_FORM);
           }
     }
}
include(DIR_SERVER_ROOT."footer.php");
?>