<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body text="#000000" bgcolor="#e0e0e0" alink="#ffffff" vlink="#000000" link="#000000">
<center>
<?php

$dir = '../';
require($dir.'adminfunctions.php');

if (isset($HTTP_GET_VARS['display'])) {
	$display=$HTTP_GET_VARS['display'];
} else {
	$display='admin.php?action=stats';
}

$top =<<<EOF
<span style="font-weight: bold; font-family: verdana; font-size: 11px;">Admin Menu [WDYL] Rls<br>
<a target="_parent" href="../">Web Home</a> | <a href="admin.php" target="main">CP Main</a></b></span>
EOF;
// <a style="font-weight: bold; font-family: verdana; font-size: 11px;" target="_parent" href="../">Web Home</a> | <a style="font-weight: bold; font-family: verdana; font-size: 11px;" href="admin.php" target="main">CP Main</a></b>

echo $top;

cptabletop();
cplinkheader('Site Content');
cplink('cplist.php?action=pagelist', 'List Pagebits');
cplink('cplist.php?action=shrinelist', 'List Shrines');
cplink('cplist.php?action=downloadlist', 'List All Files');
cplink('cplist.php?action=dlcatlist', 'List File Categories');
cplink('cplist.php?action=notelist', 'List Notes');
cplink('admin.php?action=newpagebit', 'Add Pagebit');
cplink('admin.php?action=newshrine', 'Add Shrine');
cplink('admin.php?action=newfile', 'Add File');
cplink('admin.php?action=newdlcat', 'Add File Category');
cptablebottom();

cptabletop();
cplinkheader('Forum Content');
cplink('cplist.php?action=forumlist', 'List Forums');
cplink('cplist.php?action=topiclist', 'List Topics');
cplink('cplist.php?action=postlist', 'List Posts');
cplink('cplist.php?action=polllist', 'List All Polls');
cplink('cplist.php?action=pollanswerlist', 'List All Poll Answers');
cplink('admin.php?action=newforum', 'Add Forum');
cptablebottom();

cptabletop();
cplinkheader('Users');
cplink('cplist.php?action=userlist', 'List All Users');
cplink('cplist.php?action=ranklist', 'List All Ranks');
cplink('cplist.php?action=avatarlist', 'List All Avatars');
cplink('admin.php?action=newrank', 'Add Rank');
cplink('admin.php?action=newavatar', 'Add Avatar');
cplink('cplist.php?action=seeavatars', 'Add Uploaded Avatars');
cptablebottom();

cptabletop();
cplinkheader('Presentation');
cplink('cplist.php?action=Templatelist', 'List Templates');
cplink('cplist.php?action=templatesetlist', 'List Template Sets');
cplink('cplist.php?action=stylesetlist', 'List Stylesets');
cplink('admin.php?action=newtemplate', 'Add Template');
cplink('admin.php?action=newtemplateset', 'Add Template Set');
cplink('admin.php?action=newstyleset', 'Add Styleset');
cplink('admin.php?action=import_templateset', 'Import Template Set');
cplink('admin.php?action=export_templateset', 'Export Template Set');
cplink('admin.php?action=import_styleset', 'Import Styleset');
cplink('admin.php?action=export_styleset', 'Export Styleset');
cptablebottom();

cptabletop();
cplinkheader('Settings & Config');
cplink('cplist.php?action=viewsettings&settingtype=config', 'Configuration');
cplink('cplist.php?action=viewsettings&settingtype=performance', 'Performance');
cplink('cplist.php?action=viewsettings&settingtype=display', 'Display');
cplink('cplist.php?action=viewsettings&settingtype=user', 'Users');
cplink('cplist.php?action=viewsettings&settingtype=rpg', 'RPG');
cplink('cplist.php?action=viewsettings&settingtype=permissions', 'Permissions');
cplink('cplist.php?action=viewsettings&settingtype=limit', 'List Limits');
cplink('cplist.php?action=viewsettings&settingtype=mod', 'Mods');
cplink('admin.php?action=newsetting', 'Add Setting');
cptablebottom();

cptabletop();
cplinkheader('Wordbits');
cplink('cplist.php?action=wordbitlist&wordbitgroup=misc', 'Miscellaneous');
cplink('cplist.php?action=wordbitlist&wordbitgroup=user', 'User Feedback');
cplink('cplist.php?action=wordbitlist&wordbitgroup=rpg', 'RPG Messages');
cplink('cplist.php?action=wordbitlist&wordbitgroup=error', 'Error Messages');
cplink('cplist.php?action=wordbitlist&wordbitgroup=forums', 'Forums');
cplink('cplist.php?action=wordbitlist&wordbitgroup=shrine', 'Shrines');
cplink('cplist.php?action=wordbitlist&wordbitgroup=mail', 'Mailer');
cplink('cplist.php?action=wordbitlist&wordbitgroup=cp', 'Control Panel');
cplink('cplist.php?action=wordbitlist&wordbitgroup=mod', 'Mods');
cplink('admin.php?action=newwordbit', 'Add Wordbit');
cptablebottom();

cptabletop();
cplinkheader('Site Extras');
cplink('cplist.php?action=quotelist', 'List Random Quotes');
cplink('cplist.php?action=faqlist', 'List All FAQs');
cplink('cplist.php?action=faqgrouplist', 'List FAQ Groups');
cplink('admin.php?action=newquote', 'Add Random Quote');
cplink('admin.php?action=newfaq', 'Add FAQ');
cplink('admin.php?action=newfaqgroup', 'Add FAQ Group');
cptablebottom();

cptabletop();
cplinkheader('Maintenance');
cplink('admin.php?action=editmisc', 'Misc Fields');
cplink('admin.php?action=prunedate', 'Delete Posts By Date');
cptablebottom();

?>
</center>
</body>
</html>