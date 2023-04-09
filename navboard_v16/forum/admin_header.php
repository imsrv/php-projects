<?php

   print "<table border=0 cellspacing=0 cellpadding=0 width=\"100%\">";
   print "<tr>";
   print "<td width=\"15%\" valign=\"top\">";

   //menu items
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Main options</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_config.php\">Config/Options</a><br>";
   print "<a href=\"admin_storage.php\">Storage</a>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Info</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_status.php\">Status</a><br>";
   print "<a href=\"admin_troubleshoot.php\">Troubleshooting</a><br>";
   print "<a href=\"admin_news.php\">NavBoard News</a>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Forums</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_forums.php\">Edit/Delete</a><br>";
   print "<a href=\"admin_forums.php?addforum=1\">Add</a><br>";
   print "<a href=\"admin_forums.php?editorder=1\">Order</a>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Users</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_users.php\">Edit/Ban</a><br>";
   print "<a href=\"admin_profilefields.php\">Profile Fields</a><br>";
   print "<a href=\"admin_userlevels.php\">User Levels</a><br>";
   print "<a href=\"admin_usergroups.php\">User groups</a><br>";
   print "<a href=\"admin_banlist.php\">Ban list</a><br>";
   print "<a href=\"admin_approve.php\">Approvals</a>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Themes</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_themes.php\">Main</a><br>";
   print "<a href=\"admin_themes.php#templates\">Templates</a><br>";
   print "<a href=\"admin_themes.php#replacements\">Replacements</a><br>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Posts</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_bbcode.php\">BBCode</a><br>";
   print "<a href=\"admin_smilies.php\">Smilies</a><br>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Files</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "<a href=\"admin_backup.php\">Backup</a><br>";
   print "<a href=\"admin_clean.php\">Clean</a><br>";
   print "<a href=\"admin_convert.php\">Convert File System</a><br>";
   print "</span>";
   print "</td></tr>";
   print "</table><br>";
   
   print "<table cellspacing=\"0\" cellpadding=\"4\" width=\"90%\" class=\"table\">";
   print "<tr><td class=\"tableheadercell\">";
   print "<span class=\"textheader\"><b>Modules</b></span>";
   print "</td></tr>";
   print "<tr><td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";

   $modulesarray=listdirs("modules");
   for($n=0;$n<count($modulesarray);$n++){
    unset($moduleconfig);
    include("modules/$modulesarray[$n]/config.php"); 
     if($moduleconfig['adminpage']){
      $modulesadminarray[]=$modulesarray[$n];
     }
   }

   if(count($modulesadminarray)>0){
    for($n=0;$n<count($modulesadminarray);$n++){
     print "<a href=\"admin_modules.php?module=$modulesadminarray[$n]\">$modulesadminarray[$n]</a><br>";
    }
   }else{
   print "None";
   }
   
   print "</span>";
   print "</td></tr>";
   print "</table>";
   //end menu items
     
   print "</td>";
   print "<td width=\"85%\" valign=\"top\">";

?>
