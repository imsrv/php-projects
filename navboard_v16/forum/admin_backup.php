<?php

include("global.php");

$pagetitle=" - Administration - Backup";
$links=" > Administration > Backup";

include ("header.php");

include ("admin_header.php");

if($userloggedinarray[15]!=="administrator"){
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Must be logged in as administrator to use control panel!";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
}else{

 if(!$backup&&!$restore&&!$delete){
 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Flat-file backup<br><br>";
 print "<a href=\"admin_backup.php?backup=1\">Make new backup</a><br><br>";
 print "Existing backups:<br>";
 $backuparray=listdirs("backups");
 for($n=0;$n<count($backuparray);$n++){
  print date($dateformat,$backuparray[$n]);
  print " | <a href=\"admin_backup.php?restore=$backuparray[$n]\">Restore</a>";
  print " | <a href=\"admin_backup.php?delete=$backuparray[$n]\">Delete</a>";
  print "<br>";
 }
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
 }
 
 if($backup==1){
 $time=time();
 @mkdir("backups",octdec(777));
 @mkdir("backups/$time",octdec(777));
 
  function databackup($dir){
  global $time,$maindatadir;
   @mkdir("backups/$time/$dir",octdec(777));
   
   $filesarray=listfilesext($dir);
   for($n=0;$n<count($filesarray);$n++){
    @copy("$dir/$filesarray[$n]","backups/$time/$dir/$filesarray[$n]");
    @chmod("backups/$time/$dir/$filesarray[$n]",octdec(777));
   }
   $dirsarray=listdirs($dir);
   for($n=0;$n<count($dirsarray);$n++){
    databackup("$dir/$dirsarray[$n]");
    @chmod("$dir/$dirsarray[$n]",octdec(777));
   }
  }
  
  databackup($maindatadir);
  
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Backup finished";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
 }
 
 if($restore){
  function datadelete($dir){
  global $maindatadir;
   
   $filesarray=listfilesext($dir);
   for($n=0;$n<count($filesarray);$n++){
    @unlink("$dir/$filesarray[$n]");
   }
   $dirsarray=listdirs($dir);
   for($n=0;$n<count($dirsarray);$n++){
    datadelete("$dir/$dirsarray[$n]");
   }
    @rmdir("$dir/$dirsarray[$n]");
  }
  
  datadelete($maindatadir);

  function datarestore($dir){
  global $maindatadir,$restore;
   @mkdir($dir,octdec(777));
   
   $filesarray=listfilesext("backups/$restore/$dir");
   for($n=0;$n<count($filesarray);$n++){
    @copy("backups/$restore/$dir/$filesarray[$n]","$dir/$filesarray[$n]");
   }
   $dirsarray=listdirs("backups/$restore/$dir");
   for($n=0;$n<count($dirsarray);$n++){
    datarestore("$dir/$dirsarray[$n]");
   }
  }
  
  @mkdir($maindatadir,octdec(777));
  datarestore($maindatadir);
  
   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Backup restored";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
 }
 
 if($delete){
   function datadelete($dir){
   
   $filesarray=listfilesext($dir);
   for($n=0;$n<count($filesarray);$n++){
    unlink("$dir/$filesarray[$n]");
   }
   $dirsarray=listdirs($dir);
   for($n=0;$n<count($dirsarray);$n++){
    datadelete("$dir/$dirsarray[$n]");
    rmdir("$dir/$dirsarray[$n]");
   }
  }
  
   datadelete("backups/$delete");

   rmdir("backups/$delete");

   tableheader1();
   print "<tr>";
   print "<td class=\"tablecell1\">";
   print "<span class=\"textlarge\">";
   print "Backup deleted";
   print "</span>";
   print "</td>";
   print "</tr>";
   print "</table>";
 }
 
}
include("admin_footer.php");
 print "<br><br>";
 tableheader1();

 include("footer.php");

?>
