<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
////////////////////////////////////////////////////////

include("./config.php");
include("./header.php");


$sizehosted = 0; //get the storage size hosted
$handle = opendir("./storage/");
while($file = readdir($handle)) {
$sizehosted = $sizehosted + filesize ("./storage/".$file);
  if((is_dir("./storage/".$file.'/')) && ($file != '..')&&($file != '.'))
  {
  $sizehosted = $sizehosted + total_size("./storage/".$file.'/');
  }
}
$sizehosted = round($sizehosted/1024/1024,2);

if(isset($allowedtypes)){ //get allowed filetypes.
  $types = implode(", ", $allowedtypes);
  $filetypes = "<b>allowed file types:</b> ".$types."<br /><br />";
} else { $filetypes = ""; }

if(isset($categories)){ //get categories
  $categorylist = "Category: <select name=\"category\">";
  foreach($categories as $category){
    $categorylist .= "<option value=\"".$category."\">".$category."</option>";
  }
  $categorylist .= "</select><br />";
} else { $filetypes = ""; }

if(isset($_GET['page']))
  $p = $_GET['page'];
else
  $p = "0";
include 'total.php';

switch($p) {
default: include("./pages/upload.php"); break;
}

include("./footer.php");
?>