<?php

include("global.php");

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

if(!$convert){

tableheader1();
print "<tr>";
print "<td class=\"tablecell1\">";
print "<b>File system conversion</b><br>";
print "It is VERY important to backup your data before proceeding<br>";
print "This is a RISKY operation, file system php1 is recommended at this time<br>";
print "Page format like this because navboard cant be run when converting file systems";
print "<br><br>";
print "Current file system: $filesystem<br><br>";

if($filesystem!=="php1"){
echo '<a href="admin_convert.php?convert=php1">php1</a><br>';
}

if($filesystem!=="php2"){
echo '<a href="admin_convert.php?convert=php2">php2</a><br>';
}

if($filesystem!=="php3"){
echo '<a href="admin_convert.php?convert=php3">php3</a><br>';
}

print "</td>";
print "</tr>";
print "</table>";
}//nothing to do check

if($convert){
@ini_set(MAX_EXECUTION_TIME,120);

////////////
function convert_getdata($name,$fs){

if($fs=="php1"){
$dataarray=@file($name);
for($n=1;$n<count($dataarray);$n++){$dataarray2[$n-1]=trim($dataarray[$n]);}
return $dataarray2;
}//php1

if($fs=="php2"){
@include($name);
return $tx;
}//php2

if($fs=="php3"){
@include($name);
return $tx;
}//php2

}

////////////
function convert_writedata($name,$data,$line,$fs){

if($fs=="php1"){//php1
$dataarray=convert_getdata($name,"php1");

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
}//php1

if($fs=="php2"){//php2
$dataarray=convert_getdata($name,"php2");

@chmod($name,octdec(777));
$open=@fopen($name,"w");

 if($open){
  @fwrite($open,"<?php\n");

  for($n=0;$n<$line;$n++){
  @fwrite($open,"\$tx[$n]='".addslashes($dataarray[$n])."';\n");
  }

  @fwrite($open,"\$tx[$n]='".addslashes($data)."';\n");

  for($n=$line+1;$n<count($dataarray);$n++){
  @fwrite($open,"\$tx[$n]='".addslashes($dataarray[$n])."';\n");
  }
  @fwrite($open,"?>\n");
 }

@fclose($open);
}//php2

if($fs=="php3"){//php3
$dataarray=convert_getdata($name,"php3");

@chmod($name,octdec(777));
$open=@fopen($name,"w");

 if($open){
  @fwrite($open,"<?php \$tx=array(\n");

  for($n=0;$n<$line;$n++){
  @fwrite($open,"'$n'=>'".addslashes($dataarray[$n])."',\n");
  }

  @fwrite($open,"'$n'=>'".addslashes($data)."',\n");

  for($n=$line+1;$n<count($dataarray);$n++){
  @fwrite($open,"'$n'=>'".addslashes($dataarray[$n])."',\n");
  }
  @fwrite($open,"); ?>\n");
 }

@fclose($open);
}//php3

}



 function convertdir($dir){
 global $filesystem,$convert;

   $dirsarray=listdirs($dir);
   for($n=0;$n<count($dirsarray);$n++){
    convertdir("$dir/$dirsarray[$n]");
   }

  $filesarray=listfilesext($dir);
  for($m=0;$m<count($filesarray);$m++){
   $file="$dir/$filesarray[$m]";;
   $dataarray=convert_getdata($file,$filesystem);
   unlink($file);
    for($l=0;$l<count($dataarray);$l++){
     convert_writedata($file,$dataarray[$l],$l,$convert);
    }
  }

 }//convert dir function
 
 convertdir("data");

 tableheader1();
 print "<tr>";
 print "<td class=\"tablecell1\">";
 print "<span class=\"textlarge\">";
 print "Data folder converted to filesystem $convert!<br>";
 print "</span>";
 print "</td>";
 print "</tr>";
 print "</table>";
}

}//admin check bracket

?>
