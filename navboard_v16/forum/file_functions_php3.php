<?php

/////////////
function listdirs($name){
global $dirsread,$listdirscache;$dirsread++;
//print "listdirs:$name<br>";

  $handle=@opendir($name);
   while ($file = @readdir($handle)) {
    if(!strstr($file,".")){
     $array[]=$file;
    }
   }
  @closedir($handle);
  
  return $array;
}

/////////////
function listfiles($name){
global $dirsread; $dirsread+=1;
//print "listfiles:$name<br>";

  $handle=@opendir($name);
   while ($file = @readdir($handle)) {
    if(strpos($file,".")){
	   $array[]=substr($file,0,strrpos($file,"."));
    }
   }
  @closedir($handle);

return $array;
}

/////////////
function listfilesext($name){
global $dirsread;$dirsread++;

  $handle=@opendir($name);
   while ($file = @readdir($handle)) {
    if(strpos($file,".")){
	 $array[]=$file;
    }
   }
  @closedir($handle);

  return $array;
}


////////////
function getdata($name){
global $filesopened;$filesopened+=1;
//print "getdata:$name<br>";

@include($name);

return $tx;
}

////////////
function writedata($name,$data,$line){
global $filewrites;$filewrites+=1;

$dataarray=getdata($name);

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
}


/////////////
function deletedata($name,$line){
$dataarray=getdata($name);
@chmod($name,octdec(777));
$open=@fopen($name,"w");

 if($open){
  @fwrite($open,"<?php $tx=array(\n");

  for($n=0;$n<$line;$n++){
  @fwrite($open,"'$n'='".addslashes($dataarray[$n])."',\n");
  }
  for($n=$line+1;$n<count($dataarray);$n++){
  @fwrite($open,"'$n'='".addslashes($dataarray[$n])."',\n");
  }
  
  @fwrite($open,"); ?>\n");
 }

fclose($open);
}

function createdir($name){
@mkdir($name,octdec(777));
@chmod($name,octdec(777));
}

function copydir($olddir,$newdir){
 createdir($newdir);
 
  $dirsarray=listdirs($olddir);
   for($n=0;$n<count($dirsarray);$n++){
    copydir("$olddir/$dirsarray[$n]","$newdir/$dirsarray[$n]");
   }
 
 $filesarray=listfilesext($olddir);
 for($m=0;$m<count($filesarray);$m++){
  copy("$olddir/$filesarray[$m]","$newdir/$filesarray[$m]");
 }
 
}

function deletedir($dir,$subdirs=1){

  $dirsarray=listdirs($dir);
  for($n=0;$n<count($dirsarray);$n++){
   deletedir("$dir/$dirsarray[$n]");
  }

 $filesarray=listfilesext($dir);
 for($m=0;$m<count($filesarray);$m++){
  unlink("$dir/$filesarray[$m]");
 }
 
rmdir("$dir");
}


?>
