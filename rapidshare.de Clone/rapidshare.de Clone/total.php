<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
   
    $files
    = Array();
   
    //specify the directory
    @$handle = opendir("./files/"); while (
   false !== (@$file = readdir($handle))) {     if (
    $file != "." && $file != "..") {         
   $files[] = $file;     }
   }
   @
   closedir($handle);
   $top = count($files);
 
$total=  $top - 1;
      ?> 