<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER);
include(DIR_SERVER_ROOT."header.php");
      if ($HTTP_SESSION_VARS['employerid'])
      {
       if ($HTTP_POST_VARS['action']=="mycompany") {
        if ((!empty($HTTP_POST_FILES['company_logo']['tmp_name'])) && ($HTTP_POST_FILES['company_logo']['tmp_name']!="none") ) {
          $logo_size=getimagesize($HTTP_POST_FILES['company_logo']['tmp_name']);
          if (($logo_size[0]>LOGO_MAX_WIDTH) || ($logo_size[1]>LOGO_MAX_HEIGHT) || ($HTTP_POST_FILES['company_logo']['size']>LOGO_MAX_SIZE) || (!in_array($HTTP_POST_FILES['company_logo']['type'],array ("image/gif","image/pjpeg","image/jpeg","image/x-png")))) {
           $error_message=LOGO_ERROR;
           $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);
           include(DIR_FORMS.FILENAME_ERROR_FORM);
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
                 bx_db_query("update ".$bx_table_prefix."_companies set logo = '" . $HTTP_SESSION_VARS['employerid'].$logo_extension. "' where compid = '" . $HTTP_SESSION_VARS['employerid'] . "'");
                 $image_location = DIR_LOGO. $HTTP_SESSION_VARS['employerid'].$logo_extension;
                  if (file_exists($image_location)) {
                      @unlink($image_location);
                  }//end if (file_exists($image_location))
                  move_uploaded_file($HTTP_POST_FILES['company_logo']['tmp_name'], $image_location);
                  @chmod($image_location, 0777);
                  $success_message=UPLOAD_LOGO_DESCRIPTION_SUCCESS;
                  $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);
                  include(DIR_FORMS.FILENAME_MESSAGE_FORM);
            }//end else if (($logo_size[0]>120) || ($logo_size[1]>60) || (!in_array($company_logo_type,array ("image/gif","image/jpg","image/png"))))
          }//end if ((!empty($company_logo)) && ($company_logo!="none") )
        else {
           $error_message=LOGO_ERROR;
           $back_url=bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, "auth_sess", $bx_session);
           include(DIR_FORMS.FILENAME_ERROR_FORM);
          }
       }//end if ($action=="mycompany")
	   else if($HTTP_POST_VARS['action'] == "resumemail") {
		    $resumemail_query=bx_db_query("select * from ".$bx_table_prefix."_resumemail where compid='".$HTTP_SESSION_VARS['employerid']."'");
			if(bx_db_num_rows($resumemail_query)!=0) {
				bx_db_query("update ".$bx_table_prefix."_resumemail set resumemail_type=\"".$HTTP_POST_VARS['resumemail_type']."\",rmail_lang='".$HTTP_POST_VARS['rmail_lang']."',resumemail_lastdate='' where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
				SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
			}//end if(bx_db_num_rows($resumemail_query)!=0)
            else
            {
              bx_db_insert($bx_table_prefix."_resumemail","compid,resumemail_type,rmail_lang,resumemail_lastdate","\"".$HTTP_SESSION_VARS['employerid']."\",\"".$HTTP_POST_VARS['resumemail_type']."\",'".$HTTP_POST_VARS['rmail_lang']."','".date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')))."'");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            }//end else if(bx_db_num_rows($resumemail_query)!=0)
            include(DIR_FORMS.FILENAME_MYCOMPANY_FORM);	   
	   }
       else {
           include(DIR_FORMS.FILENAME_MYCOMPANY_FORM);
       }//end else if ($action=="mycompany")
      } //end if employerid
      else
      {
          $login='employer';
          include(DIR_FORMS.FILENAME_LOGIN_FORM);
      }//end else employerid
include(DIR_SERVER_ROOT."footer.php");
?>