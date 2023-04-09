<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_PERSONAL);
$jsfile="personal.js";
if($HTTP_POST_VARS['action']) {
    $action = $HTTP_POST_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
     if ($HTTP_POST_VARS['validation']) //we make validation
      {
        // validating information
         $error=0;
         if (($HTTP_POST_VARS['jname']=="") || (strlen($HTTP_POST_VARS['jname'])<ENTRY_NAME_MIN_LENGTH))
           {
           $error=1;
           $name_error=1;
           }
         else
           {
          $name_error=0;
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
           if (($HTTP_POST_VARS['phone']=="") || (strlen($HTTP_POST_VARS['phone'])<ENTRY_PHONE_MIN_LENGTH) || (verify($HTTP_POST_VARS['phone'],"phone")==1))
           {
           $error=1;
           $phone_error=1;
           }
           else
           {
          $phone_error=0;
           }
           if (ENTRY_BIRTHYEAR_LENGTH!=0 && (($HTTP_POST_VARS['birthyear']=="") || (strlen($HTTP_POST_VARS['birthyear'])!=ENTRY_BIRTHYEAR_LENGTH) || (verify($HTTP_POST_VARS['birthyear'],"int")==1)))
           {
           $error=1;
           $birthyear_error=1;
           }
           else
           {
          $birthyear_error=0;
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
           $email_query=bx_db_query("select persid, email from ".$bx_table_prefix."_persons where email like '".$HTTP_POST_VARS['email']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           $email_number=bx_db_num_rows($email_query);
           if (($email_number!=0) && ($check_email))
           {
               $email_result=bx_db_fetch_array($email_query);
               if ($email_result['email']==$HTTP_POST_VARS['email']) {
                   if ($HTTP_SESSION_VARS['userid']) {
                             if ($email_result['persid']!=$HTTP_SESSION_VARS['userid']) {
                                  $error = 1;
                                  $allready_email_error = 1;
                             }
                             else {
                                  $allready_email_error = 0 ;
                             }
                   }
                   else {
                        $error = 1;
	           $allready_email_error=1;
                   }
               }
               else {
                    $allready_email_error=0;
               }
           }
           else {
                $allready_email_error=0;
           }
           if (($HTTP_POST_VARS['password']=="") || (strlen($HTTP_POST_VARS['password'])<ENTRY_PASSWORD_MIN_LENGTH)) {
                $error=1;
                $password_error=1;
           }
           else {
                $password_error=0;
           }
           if (($HTTP_POST_VARS['password']!=$HTTP_POST_VARS['confpassword']) || (strlen($HTTP_POST_VARS['confpassword'])<ENTRY_PASSWORD_MIN_LENGTH)) {
                $error=1;
                $confpassword_error=1;
           }
           else {
                $confpassword_error=0;
           }
           if ($HTTP_POST_VARS['agree']=="") {
                $error=1;
                $terms_error=1;
           }
           else {
                $terms_error=0;
           }
           if(!$HTTP_POST_VARS['hide_address']) {
                $HTTP_POST_VARS['hide_address']='no'; 
           }
           if(!$HTTP_POST_VARS['hide_location']) {
                $HTTP_POST_VARS['hide_location']='no'; 
           }
           if(!$HTTP_POST_VARS['hide_phone']) {
                $HTTP_POST_VARS['hide_phone']='no'; 
           }
           if(!$HTTP_POST_VARS['hide_fax']) {
                $HTTP_POST_VARS['hide_fax']='no'; 
           }
           if(!$HTTP_POST_VARS['hide_email']) {
                $HTTP_POST_VARS['hide_email']='no'; 
           }
      }//end if validation
      if ($HTTP_SESSION_VARS['userid'])
       {
        if ($action=="pers_form") //|| $HTTP_GET_VARS['action']=="pers_form"
         {
            $personal_query=bx_db_query("select * from ".$bx_table_prefix."_persons where persid='".$HTTP_SESSION_VARS['userid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $personal_result=bx_db_fetch_array($personal_query);
            include(DIR_SERVER_ROOT."header.php");     
            include(DIR_FORMS.FILENAME_PERSONAL_FORM);
            include(DIR_SERVER_ROOT."footer.php");
         }  //end if action=pers_form

        if ($action=="pers_update")
         {
          if ($error==1) //we have errors
           {
              include(DIR_SERVER_ROOT."header.php");    
              include(DIR_FORMS.FILENAME_PERSONAL_FORM);
              include(DIR_SERVER_ROOT."footer.php");
           } //end if error=1
           else //no errors
           {
             bx_db_query("update ".$bx_table_prefix."_persons set name='".bx_dirty_words($HTTP_POST_VARS['jname'])."' , address='".bx_dirty_words($HTTP_POST_VARS['address'])."' , city='".bx_dirty_words($HTTP_POST_VARS['city'])."' , province='".bx_dirty_words($HTTP_POST_VARS['province'])."' , postalcode='".bx_dirty_words($HTTP_POST_VARS['postalcode'])."' , locationid='".$HTTP_POST_VARS['location']."' , gender='".$HTTP_POST_VARS['gender']."'  , birthyear='".$HTTP_POST_VARS['birthyear']."'  , phone='".bx_dirty_words($HTTP_POST_VARS['phone'])."' , fax='".bx_dirty_words($HTTP_POST_VARS['fax'])."' , email='".$HTTP_POST_VARS['email']."' , url='".bx_dirty_words($HTTP_POST_VARS['url'])."', password='".bx_addslashes($HTTP_POST_VARS['password'])."', hide_name='".$HTTP_POST_VARS['hide_name']."', hide_address='".$HTTP_POST_VARS['hide_address']."', hide_location='".$HTTP_POST_VARS['hide_location']."', hide_phone='".$HTTP_POST_VARS['hide_phone']."', hide_email='".$HTTP_POST_VARS['hide_email']."' where persid='".$HTTP_SESSION_VARS['userid']."'");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             $success_message=TEXT_MODIFICATION_SUCCESS;
             $back_url=bx_make_url(HTTP_SERVER.FILENAME_PERSONAL."?action=pers_form", "auth_sess", $bx_session);
             include(DIR_SERVER_ROOT."header.php");
             include(DIR_FORMS.FILENAME_MESSAGE_FORM);
             include(DIR_SERVER_ROOT."footer.php");
           } //end else error=1
        } //end if action=pers_update

       } //end if we have userid
      else //no userid
       {
       if ($HTTP_POST_VARS['new_account']) //creating a new account
       {
        if ($error==1) //we have errors
           {
             include(DIR_SERVER_ROOT."header.php");
             include(DIR_FORMS.FILENAME_PERSONAL_FORM);
             include(DIR_SERVER_ROOT."footer.php");
           } //end if error=1
          else //no errors
           {
            if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){
                  $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
            }
            else {
                  $IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
            }
            bx_db_insert($bx_table_prefix."_persons","name,address,city,province,postalcode,locationid,phone,fax,email,gender,birthyear,url,password,hide_name,hide_address,hide_location,hide_phone,hide_email,signupdate,lastlogin,lastip","'".bx_dirty_words($HTTP_POST_VARS['jname'])."','".bx_dirty_words($HTTP_POST_VARS['address'])."','".bx_dirty_words($HTTP_POST_VARS['city'])."' ,'".bx_dirty_words($HTTP_POST_VARS['province'])."' ,'".bx_dirty_words($HTTP_POST_VARS['postalcode'])."' ,'".$HTTP_POST_VARS['location']."' ,'".bx_dirty_words($HTTP_POST_VARS['phone'])."' ,'".bx_dirty_words($HTTP_POST_VARS['fax'])."' ,'".$HTTP_POST_VARS['email']."','".$HTTP_POST_VARS['gender']."','".$HTTP_POST_VARS['birthyear']."' ,'".bx_dirty_words($HTTP_POST_VARS['url'])."','".bx_addslashes($HTTP_POST_VARS['password'])."','".$HTTP_POST_VARS['hide_name']."','".$HTTP_POST_VARS['hide_address']."','".$HTTP_POST_VARS['hide_location']."','".$HTTP_POST_VARS['hide_phone']."','".$HTTP_POST_VARS['hide_email']."','".date('Y-m-d')."', NOW(), '".$IP."'");
            $userid = bx_db_insert_id();
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $mailfile = $language."/mail/jobseeker_registration.txt";
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
            $success_message=TEXT_NEW_ACCOUNT_CREATION_SUCCESS;
            $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);
            bx_session_register("userid");
            $sessiontime = time();
            bx_session_register("sessiontime");     
            include(DIR_SERVER_ROOT."header.php");
            include(DIR_FORMS.FILENAME_MESSAGE_FORM);
            include(DIR_SERVER_ROOT."footer.php");
          }  //end else error=1
       } //end if newaccount
       else
       {
          if ($action=="pers_form") {
                 $login='jobseeker';
                 include(DIR_SERVER_ROOT."header.php");
                 include(DIR_FORMS.FILENAME_LOGIN_FORM);
                 include(DIR_SERVER_ROOT."footer.php");
          }
          else {
                 include(DIR_SERVER_ROOT."header.php");    
                 include(DIR_FORMS.FILENAME_PERSONAL_FORM);
                 include(DIR_SERVER_ROOT."footer.php");
          }
       } //end else newaccount
}
bx_exit();
?>