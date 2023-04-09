<?

/*----------------------------------
  MAIAN MAIL v2.1
  Written by David Ian Bennett
  E-Mail: david@m-dream.co.uk
  Website: www.m-dream.co.uk
  This File: User Configuration File
-----------------------------------*/

/****************************************************************************************************************
*  IMPORTANT - READ FIRST                                                                                       *
*  Listed below are the configuration options for your website. Edit them carefully, ensuring that you do NOT   *
*  remove any semi colons OR anything that is displayed in CAPITAL letters. These are important to the program. *
*  Also make sure that your options remain between single quotes ('). This isn`t always necessary, but is       *
*  good practice for beginners.                                                                                 *
*****************************************************************************************************************/

/*--------------------------------------------------------------------------------------
  1. DEFINE WEBSITE SETTINGS
     Specify your website preferences
     Some language files may need the Charset changing, otherwise no need to change this
---------------------------------------------------------------------------------------*/


define('WEBSITE_NAME', 'Web Site Ad§n§z');        //Name of Website = Website Name
define('EMAIL_ADDRESS', 'adiniz@siteadiniz.com');  // yahut  habipoguz@mynet.com tarz§ birўey= E-Mail Address
define('FORM_TITLE', 'нLETнонM FORMU');          //My Contact Form = Appears top left in your browser & at top of form
define('AUTO_RESPONDER', '1');                      //Send E-Mail to Visitor? 1 = yes, 0 = no


/*---------------------------------------------------------------------------------------------------------
  2. DEFINE DISPLAY OPTIONS
     Specify language file.

----------------------------------------------------------------------------------------------------------*/


define('LANGFILE', 'turkish.php');                //english.php = Language File


/*----------------------------------------------------------------------------
  3. DEFINE ERROR CHECKING
     For which fields do you want error checking to be enabled?
-----------------------------------------------------------------------------*/


define('NAME_CHECK', '1');                       //0 = Off, 1 = On
define('SUBJECT_CHECK', '1');                    //0 = Off, 1 = On
define('EMAIL_CHECK', '1');                      //0 = Off, 1 = On
define('COMMENTS_CHECK', '1');                   //0 = Off, 1 = On


/*--------------------------------------------------------------------------------------------------------
  4. DEFINE E-MAIL BAN FEATURE
     This simple little feature enables you to prevent anyone from sending you messages from a specified
     e-mail address. If enabled, a 'thank you' message is displayed, but no mail gets sent.
     IMPORTANT NOTE: Please be careful if you edit the array. Each entry is preceded by a , except the
     last. Failure to take care could result in the script malfunctioning.
---------------------------------------------------------------------------------------------------------*/


define('BAN_OPTION', '0');                       //0 = No, 1 = Yes
$bannedemails = array('spam@spam.com','you@youremail.com','blah@blah.com');

?>