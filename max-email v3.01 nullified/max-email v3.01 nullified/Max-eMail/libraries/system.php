<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////

//admin sections
$ADMIN_LIST_SECTIONS[members]="Manage Members";
$ADMIN_LIST_SECTIONS[banned]="Banned Emails"; 
$ADMIN_LIST_SECTIONS[import]="Import Data"; 
$ADMIN_LIST_SECTIONS[export]="Export Data"; 
$ADMIN_LIST_SECTIONS[audit]="Audit List";
$ADMIN_LIST_SECTIONS[templates]="Templates"; 
$ADMIN_LIST_SECTIONS[autofill]="Auto Fill"; 
$ADMIN_LIST_SECTIONS[compose]="Compose Emails"; 
$ADMIN_LIST_SECTIONS[send]="Send Emails"; 
$ADMIN_LIST_SECTIONS[content]="Saved Content"; 
$ADMIN_LIST_SECTIONS[images]="Images"; 
$ADMIN_LIST_SECTIONS[links]="Links"; 
$ADMIN_LIST_SECTIONS[stats]="Stats";
$ADMIN_LIST_SECTIONS[trim]="Trim Lists";

$ADMIN_ADV_SECTIONS[admins]="Administrators";
$ADMIN_ADV_SECTIONS[nullification]="Nullification Info";
$ADMIN_ADV_SECTIONS[inputforms]="Input Forms";
$ADMIN_ADV_SECTIONS[listsetup]="List Setup";
$ADMIN_ADV_SECTIONS[systemsetup]="System Setup";

//admin privelages!
$PRIV["members"]["section"]="edit,view";
$PRIV["members"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["banned"]["section"]="view,edit,use";
$PRIV["banned"]["lists"]="SELECT * FROM banned_groups;BannedGroupID;BannedGroupName";

$PRIV["import"]["section"]="use";
$PRIV["import"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["export"]["section"]="use";
$PRIV["export"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["audit"]["section"]="report,fix";
$PRIV["audit"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["templates"]["section"]="view,edit,use";
$PRIV["templates"]["lists"]="SELECT * FROM templates;TemplateID;TemplateName";

$PRIV["links"]["section"]="use,edit,report";
$PRIV["links"]["lists"]="SELECT * FROM link_groups;LinkGroupID;LinkGroupName";

$PRIV["images"]["section"]="use,manage";
$PRIV["images"]["lists"]="SELECT * FROM image_groups;ImageGroupID;ImageGroupName";

$PRIV["compose"]["section"]="use,edit;create";
$PRIV["compose"]["lists"]="SELECT * FROM composed_emails;ComposeId;ComposeName";

$PRIV["content"]["section"]="edit,use";
$PRIV["content"]["lists"]="SELECT * FROM content_cats;ContentCatID;ContentCatName";

$PRIV["autofill"]["section"]="use,manage";
$PRIV["autofill"]["lists"]="SELECT * FROM autofill_groups;AutoFillGroupID;AutoFillGroupName";

$PRIV["trim"]["section"]="use";
$PRIV["trim"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["send"]["section"]="use";
$PRIV["send"]["lists"]="SELECT * FROM lists;ListID;ListName";

$PRIV["stats"]["section"]="lists;system";
$PRIV["stats"]["lists"]="SELECT * FROM lists;ListID;ListName";


//admin libraries!
$ADMIN_LIBRARIES[]="basic.inc.php";
$ADMIN_LIBRARIES[]="auth.inc.php";
$ADMIN_LIBRARIES[]="lists.inc.php";
$ADMIN_LIBRARIES[]="manage_members.inc.php";
$ADMIN_LIBRARIES[]="banned.inc.php";
$ADMIN_LIBRARIES[]="admin_output.inc.php";
$ADMIN_LIBRARIES[]="email_composing.inc.php";
$ADMIN_LIBRARIES[]="email_parsing.inc.php";
$ADMIN_LIBRARIES[]="forms.inc.php";
$ADMIN_LIBRARIES[]="stats.inc.php";
$ADMIN_LIBRARIES[]="data_verification.inc.php";

//client side libraries
$CLIENT_LIBRARIES[]="basic.inc.php";
$CLIENT_LIBRARIES[]="lists.inc.php";
$CLIENT_LIBRARIES[]="manage_members.inc.php";
$CLIENT_LIBRARIES[]="banned.inc.php";
$CLIENT_LIBRARIES[]="forms.inc.php";
$CLIENT_LIBRARIES[]="data_verification.inc.php";
?>