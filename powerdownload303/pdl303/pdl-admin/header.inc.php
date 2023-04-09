<?
$incdir = "../";
$inadmin = 1;
include_once($incdir."pdl-inc/pdl_header.inc.php");
include("functions.inc.php");

$template[bg] = "#000000";
$template[table_border] = "#9B0000";
$template[header_bg] = "#700000";
$template[footer_bg] = "#5F0000";
$template[alt_1] = "#2E0000";
$template[alt_2] = "#3B0000";

?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <title>PowerDownload <? echo $settings[pdlversion]; ?> - Admin</title>
 <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body text="#FFFFFF" bgcolor="<? echo $template[bg]; ?>" bottommargin="0" leftmargin="0" topmargin="0" rightmargin="0">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td bgcolor="<? echo $template[table_border]; ?>">
      <table border="0" cellpadding="3" cellspacing="1" width="100%" height="100%">
        <tr>
          <td bgcolor="<? echo $template[header_bg]; ?>" width="200" valign="top">
            <table border="0" cellspacing="2" cellpadding="0" width="100%">
              <tr>
                <td align="center">
                  <?
                  if($user_details)
                   {?>
                  Hi <? echo $user_details[nick]; ?><br>
                  [ <a href="index.php?logout=1">Logout</a> | <a href="<? echo $settings[script_file]; ?>usercenter=profil">Profil</a> ]
                  <? }
                  else
                   {
                    echo "Bitte einloggen.";
                   } ?>
                </td>
              </tr>
              <tr>
                <td>
                  <hr />
                </td>
              </tr>
                  <?
                  $master_if = false;
                  menu_topic($user_rights[adminaccess] == "Y","N�tzliches");
                  menu_link($user_rights[adminaccess] == "Y","Replacements anzeigen","showreplacements.php");
                  menu_link($user_rights[templates] == "Y","Template Variablen anzeigen","showtempvars.php");
                  menu_close();
                  menu_topic($user_rights[adminaccess] == "Y","Releases");
                  menu_link($settings[ftp_on] == "Y" && function_exists("ftp_connect"),"FTP Browser/Upload","ftp_browser.php");
                  menu_link($user_rights[adminaccess] == "Y","hinzuf�gen","addrelease.php");
                  menu_link($user_rights[editfiles] == "Y" || $user_rights[delfiles] == "Y","�ndern/l�schen","or_list.php");
                  menu_close();
                  menu_topic($user_rights[adddirs] == "Y" || $user_rights[editdirs] == "Y" || $user_rights[deldirs] == "Y", "Ordner");
                  menu_link($user_rights[adddirs] == "Y","hinzuf�gen","adddir.php");
                  menu_link($user_rights[editdirs] == "Y" || $user_rights[deldirs] == "Y","�ndern/l�schen","or_list.php");
                  menu_close();
                  menu_topic($user_rights[edituser] == "Y" || $user_rights[deluser] == "Y","User");
                  menu_link($user_rights[edituser] == "Y","editieren","edituser.php");
                  menu_link($user_rights[deluser] == "Y","l�schen","deluser.php");
                  menu_link($user_rights[edituser] == "Y" && $user_rights[deluser] == "Y","Usergruppe hinzuf�gen","addugroup.php");
                  menu_link($user_rights[edituser] == "Y" && $user_rights[deluser] == "Y","Usergruppe �ndern/l�schen","editdelugroup.php");
                  menu_close();
                  menu_topic($user_rights[writeletter] == "Y","Download Letter");
                  menu_link($user_rights[writeletter] == "Y","Letter generieren/schreiben","makeletter.php");
                  menu_close();
                  menu_topic($user_rights[templates] == "Y" || $user_rights[replacement] == "Y","Templates/Replacements");
                  menu_link($user_rights[replacement] == "Y","Replacement hinzuf�gen","addreplacement.php");
                  menu_link($user_rights[replacement] == "Y","Replacement l�schen","delreplacement.php");
                  menu_link($user_rights[templates] == "Y","Templates �ndern","templates.php");
                  menu_close();
                  menu_topic($user_rights[god] == "Y","System");
                  menu_link($user_rights[god] == "Y","Settings","settings.php");
                  menu_link($user_rights[god] == "Y","Datenbank Backup","backup.php");
                  menu_link($user_rights[god] == "Y","Backup ausf�hren","dobackup.php");
                  menu_link($user_rights[god] == "Y","Datenbank optimieren","optimize.php");
                  menu_link($user_rights[god] == "Y","DL Datenbank zur�cksetzen","reset.php");
                  menu_close();
                  menu_topic($user_rights[god] == "Y","System erweiterungen");
                  menu_link($user_rights[god] == "Y","Setting hinzuf�gen","addsettings.php");
                  menu_link($user_rights[god] == "Y","Setting Gruppe hinzuf�gen","addsgroup.php");
                  menu_link($user_rights[god] == "Y","Settings/Gruppen �ndern/l�schen","editdelsettingssgroup.php");
                  menu_link($user_rights[god] == "Y","Template hinzuf�gen","addtemplate.php");
                  menu_link($user_rights[god] == "Y","Template Gruppe hinzuf�gen","addtgroup.php");
                  menu_link($user_rights[god] == "Y","Template/Gruppen �ndern/l�schen","editdeltemplatestgroup.php");
                  menu_link($user_rights[god] == "Y","Userrechte hinzuf�gen","adduright.php");
                  menu_link($user_rights[god] == "Y","Userrechte �ndern/l�schen","editdeluright.php");
                  menu_close();
                  ?>
            </table>
          </td>
          <td height="15" bgcolor="<? echo $template[header_bg]; ?>">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" height="100%">
              <tr>
                <td height="15">
                  <small>PowerDownload <? echo $settings[pdlversion]; ?> - Admin | <a href="<? echo $settings[script_file]; ?>"><small>Zur �bersicht</small></a></small>
                </td>
                <td align="right">
                  <small>PowerDownload &copy; 2002 by Arpad Borsos</small>
                </td>
              </tr>
              <tr>
                <td bgcolor="<? echo $template[bg]; ?>" valign="top" height="100%" colspan="2" align="center">

