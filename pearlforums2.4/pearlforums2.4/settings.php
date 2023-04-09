<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File: 	settings.php - Hold global settings and variables.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Note: Although generated by adminSettings.php, you can update existing 	
//  variables' values here directly.  However, if you add new variables or make 
//  changes to existing variables' names please do so in the adminSettings.php file.

global $GlobalSettings,$Document,$Member,$VARS,$Language,$AdminLanguage; 



//  Database:begin					
$GlobalSettings['DBServer']                  = "localhost";
$GlobalSettings['DBName']                    = "";
$GlobalSettings['DBUser']                    = ""; 
$GlobalSettings['DBPassword']                = ""; 
$GlobalSettings['DBPrefix']                  = "PF";	
//  Database:end

//General
$GlobalSettings['Organization']              = "Pearlinger.com";
$GlobalSettings['WebmasterEmail']            = "info@yoursite.com";		
$GlobalSettings['RegistrationSpamGuard']     = "1";	
$GlobalSettings['LoginSpamGuard']            = "0";	
$GlobalSettings['SpamGuardFolder']           = "spamguard";	
$GlobalSettings['MaxAddressBook']			 = "100";

$Document['membersOnly']                     = "0";  
$Document['checkBannedIPs']                  = "0";  
$Document['checkSensoredWords']              = "0";  
$Document['languagePreference']              = "english";
$Document['allowGuestPosting']               = "0";
$Document['allowAttachments']                = "1";
$Document['allowMessageAttachments']         = "1";
$Document['allowNotify']                     = "1";
$Document['displayMemberProfile']            = "1"; 
$Document['showEditTime']                    = "1";
$Document['showModerators']                  = "1";
$Document['showForumInfo']                   = "1";
$Document['showBoardDescription']            = "1";
$Document['showIPs']                         = "1";
$Document['graphicButtons']                  = "1";
$Document['linkColor']                       = "#FF6600"; 
$Document['textColor']                       = "#000000";
$Document['title']                           = "Pearl Forums"; 
$Document['width']                           = "95%";
$Document['allowableTags']                   = "<a><b><blockquote><br><div><dt><em><font><hr><i><img><li><marquee><ol><p><strike><strong><sub><sup><table><tbody><td><tr><u><ul>";
$Document['badAttributes']                   = "javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup";
$Document['avatarSize']                      = "51200"; 
$Document['avatarWidth']                     = "100";
$Document['avatarHeight']                    = "130";
$Document['avatarTypes']                     = array("jpg","gif","bmp","png");
$Document['disallowAttachmentTypes']         = array("php");
$Document['attachmentSize']                  = "1024000";
$Document['sessionDuration']                 = "86400"; #Default 1 day - 86400
$Document['postingsPerPage']                 = "10";
$Document['listingsPerPage']                 = "20";
$Document['maxMemberMessages']               = "100";
$Document['maxMessageAttachment']            = "1024000"; #Default 1MB - 1024000
$Document['MaxPagingLinks']				     = "10";

// Variables below this line can not be changed through the Admin's Settings section.
// You might want to leave them the way they are.
$GlobalSettings['pearlVersion']              = "2.4";
$GlobalSettings['serverName']                = $SERVER_NAME;
$GlobalSettings['boardPath']                 =  str_replace("/" . basename($PHP_SELF),"",$PHP_SELF);// "/forums";			
$GlobalSettings['includesDirectory']         = "includes"; #Functions & source files
$GlobalSettings['templatesDirectory']        = "templates"; #HTML layout files
$GlobalSettings['attachmentPath']            = "attachments";
$GlobalSettings['avatarsPath']               = "avatars";
$GlobalSettings['smileysPath']               = "smileys";
$GlobalSettings['messageAttachmentPath']     = $GlobalSettings['attachmentPath'] . "/messages";

$Document['mainScript']                      = $PHP_SELF;
$Document['spacer']                          = "&nbsp;&nbsp;";
$Document['contents']                        = "";
$Document['navigation']                      = "";
$Document['onLoad']                          = "";
$Document['onUnload']                        = "";
$Document['quickLogin']                      = "";
$Document['forumNavigation']                 = "";
$Document['moderators']                      = array();
$Member                                      = array();
$Language                                    = array();
$AdminLanguage                               = array();
$VARS                                        = array();
?>