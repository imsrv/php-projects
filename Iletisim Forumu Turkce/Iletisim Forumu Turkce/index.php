
<?php

error_reporting (E_ALL ^ E_NOTICE);

@include('inc/config.inc.php');
@include('lang/' . LANGFILE);

//------------------------------
//Get Savant template class
//------------------------------

@include('lib/Savant2.php');

//--------------------
//Script Processing
//Off we go..
//--------------------

if ((isset($_GET['cmd'])) && ($_GET['cmd']=="send"))
{
     $name      = trim($_POST['name']);
     $subject   = trim($_POST['subject']);
     $email     = trim($_POST['email']);
     $comments  = trim($_POST['comments']);

     //---------------------------------
     //Create instance of mail class
     //---------------------------------

     @include('inc/class_mail.inc.php');

     $MAIANMAIL = new mailClass($name,$email,$subject,$comments);

     //---------------------------
     //Error Checking if enabled
     //---------------------------

     $error_string = array();

     if (NAME_CHECK)
     {
          if ($MAIANMAIL->is_name_valid())
          {
               $error_string[] = $form_error_name;
          }
     }
     if (EMAIL_CHECK)
     {
          if ($MAIANMAIL->is_email_valid())
          {
               $error_string[] = $form_error_email;
          }
     }
     if (SUBJECT_CHECK)
     {
          if ($MAIANMAIL->is_subject_valid())
          {
               $error_string[] = $form_error_subject;
          }
     }
     if (COMMENTS_CHECK)
     {
          if ($MAIANMAIL->is_comments_valid())
          {
               $error_string[] = $form_error_comments;
          }
     }

     //--------------------------------------
     //See if error string array is empty
     //If it is not, show errors
     //--------------------------------------

     if (!empty($error_string))
     {
          $tpl_error   =& new Savant2();

          $MAIANMAIL->show_error($tpl_error,$charset,$form_error,$error_string,$form_return);
          exit;
     }

     //-------------------------------------------------------------
     //Now see if e-mail has been banned
     //If it has, show thank you page and send NO mail. hee hee!
     //-------------------------------------------------------------

     if (BAN_OPTION)
     {
          if ($MAIANMAIL->is_email_banned($bannedemails))
          {
               $tpl_thanks   =& new Savant2();

               $MAIANMAIL->show_thank_you($tpl_thanks,$charset,$form_thanks,$form_message,$form_continue);
               exit;
          }
     }

     //--------------------------------------
     //Ok, so far, so now send messages
     //--------------------------------------

     $MAIANMAIL->send_webmaster_mail(EMAIL_ADDRESS);

     //---------------------------------------------
     //If auto responder enabled, send to visitor
     //----------------------------------------------

     if (AUTO_RESPONDER)
     {
          $MAIANMAIL->send_visitor_mail(WEBSITE_NAME,EMAIL_ADDRESS,$auto_vis_subject);
     }

     //-------------------------------------------
     //Display thanks page and we are all done
     //-------------------------------------------

     $tpl_thanks   =& new Savant2();

     $MAIANMAIL->show_thank_you($tpl_thanks,$charset,$form_thanks,$form_message,$form_continue);
     exit;

}
//-----------------------------------------------------
//Create instance of Savant template class (Main)
//-----------------------------------------------------

$tpl_index   =& new Savant2();
$tpl_index->assign('REQUIREDFIELDS', $form_field);
$tpl_index->assign('IS_NAME_REQUIRED', $name_req);
$tpl_index->assign('IS_EMAIL_REQUIRED', $email_req);
$tpl_index->assign('IS_SUBJECT_REQUIRED', $subject_req);
$tpl_index->assign('IS_COMMENTS_REQUIRED', $comments_req);
$tpl_index->assign('NAME', $form_name);
$tpl_index->assign('EMAIL', $form_email);
$tpl_index->assign('SUBJECT', $form_subject);
$tpl_index->assign('COMMENTS', $form_comments);
$tpl_index->assign('SEND', $form_send);
$tpl_index->assign('CLEAR', $form_clear);
$tpl_index->display('templates/index.tpl.php');

?>