<?php

include("global.php");

@ini_set("max_execution_time",120);

 if($step==""){

 print "<table>";
 print "<form action=\"upgrade_to15.php\" method=\"post\">";
 print "<input type=hidden name=\"step\" value=\"2\">";

 print "<tr>";
 print "<td width=\"100%\">";
 print "Upgrade to v15<br><br>";
 print "READ upgrade.txt documentation before proceeding!<br>";
 print "DO NOT run this file if you dont want to upgrade!<br>";
 print "BACKUP data files before running this upgrade!<br>";
 print "<br>";
 print "</tr>";
 print "</table>";

 print "<br><br>";

 print "<table>";

 print "<tr>";
 print "<td width=\"100%\"><input type=submit name=\"submit\" value=\"Upgrade!\"</td>";
 print "</form>";
 print "</tr>";
 print "</table>";
 }

 if($step==2){

 print "This needs to be manually done by user<br>";
 print "ONLY if you secured your data directories before<br>";
 print "If you never heard of that or dont know how then you most likely didn't do it!<br><br>";
 print "Rename data directories back to normal:<br>";
 print "Main data dir: &nbsp&nbsp&nbsp&nbsp data<br>";
 print "Forums dir: &nbsp&nbsp&nbsp&nbsp data/forum<br>";
 print "Users dir: &nbsp&nbsp&nbsp&nbsp data/users<br>";
 print "Modules data dir: &nbsp&nbsp&nbsp&nbsp data/modules<br>";
 print "Custom dir: &nbsp&nbsp&nbsp&nbsp data<br><br>";
 print "<br>";
 print "Also make sure your file system is on txt<br>";
 print "<br>";
 print "Do this before next step";

 print "<br>";

 print "<a href=\"upgrade_to15.php?step=3\">Next step</a>";

 }//step 2 bracket

 if($step==3){

////////////
function fs_read_txt($name,$id=""){
$dataarray=@file($name);
 if(count($dataarray)==1&&$dataarray[0]==""){unset($dataarray);}
 for($n=0;$n<count($dataarray);$n++){
  $dataarray[$n]=trim($dataarray[$n]);
 }
 return $dataarray;
}

////////////
function fs_read_txt_new($name,$id=""){
$dataarray=@file($name);
if(strpos($dataarray[0],"?php")){$die=array_shift($dataarray);}
 if(count($dataarray)==1&&$dataarray[0]==""){unset($dataarray);}
 for($n=0;$n<count($dataarray);$n++){
  $dataarray[$n]=trim($dataarray[$n]);
 }
 return $dataarray;
}

////////////
function fs_write_txt_new($name,$data,$line="",$id=""){
$dataarray=fs_read_txt_new($name,$id);
@chmod($name,octdec(777));
$open=@fopen($name,"w");

 if($open){
  @fwrite($open,"<?php die(); ?>\n");

  for($n=0;$n<$line;$n++){
  @fwrite($open,"$dataarray[$n]\n");
  }

  @fwrite($open,"$data\n");

  for($n=$line+1;$n<count($dataarray);$n++){
  @fwrite($open,"$dataarray[$n]\n");
  }
 }

@fclose($open);
}

function convertfiles($dir){

 $files=listfilesext($dir);
 for($n=0;$n<count($files);$n++){
  $dataarray=fs_read_txt($dir."/".$files[$n]);
   for($m=0;$m<count($dataarray);$m++){
    $path=substr($files[$n],0,-4);
    fs_write_txt_new($dir."/".$path.".php",$dataarray[$m],$m);
   }
 @unlink($dir."/".$files[$n]);
 }

 $dirs=listdirs($dir);
 for($n=0;$n<count($dirs);$n++){
  convertfiles($dir."/".$dirs[$n]);
 }

}

convertfiles($maindatadir);

 print "UPGRADE IS FINISHED!";
 }//step 3


?>