<?


function foto($foto_dir) {
 require_once("./phemplate.class.php");
 require_once("./config.php");
 $phemplate = new phemplate();  
 $phemplate->set_file('foto',"./foto_browse.htx");

 if (!isset($foto_dir)) {
   $foto_dir = $config["foto_dir"];
 }

 if (!eregi($config["foto_dir"],$foto_dir) || eregi("\.\.",$foto_dir)) {
   Header("Location: ".html_entity_decode($config["foto_browse_script"]));
   exit();
 }


 $aindex = 0;
 $bindex = 0;

 if ($foto_dir != $config["foto_dir"]) {
   $dir[$bindex]["index"] = $bindex;
   $dir[$bindex]["title"] = $config["foto_back"];
   $dir[$bindex]["date"]  = Date("j. M. Y  H:i:s", filemtime($foto_dir));
   $dir[$bindex]["dir"]   = substr($foto_dir, 0, strrpos($foto_dir, '/'));
   $bindex++;
 }

 if (!is_dir($foto_dir."/".$config["foto_thumb"])) {
   mkdir($foto_dir."/".$config["foto_thumb"]);
   chmod($foto_dir."/".$config["foto_thumb"], 0777);
 }

 $handle = opendir($foto_dir);
 while($entry = readdir($handle)) {
   if(is_file($foto_dir."/".$entry)) {
     $foto[$aindex]["index"]       = $aindex;
     $foto[$aindex]["fname_description"] =  $foto_dir."/".$config["foto_desc"]."/".$entry.".txt";
     if (file_exists($foto[$aindex]["fname_description"])) {
       unset($temp);
       $temp = implode(file($foto[$aindex]["fname_description"]),"\n");
       $pos = strpos($temp, "\n");

       if ($pos === false) {
         $foto[$aindex]["title"]       = $temp;
         $foto[$aindex]["description"] = "";
       } else {
         $foto[$aindex]["title"]       = substr($temp, 0, $pos); 
         $foto[$aindex]["description"] = substr($temp, $pos);
       }
     } else {
       $foto[$aindex]["title"]       = $entry;
       $foto[$aindex]["description"] = "";
     }

     $foto[$aindex]["file_thumb"]    = $foto_dir."/".$config["foto_thumb"]."/".$entry;
     $foto[$aindex]["file_name"]     = $entry;
     $foto[$aindex]["dir"]           = $foto_dir;


     if (!file_exists($foto[$aindex]["file_thumb"])) {
       require_once("resize.class.php");

       $thumb=new thumbnail($foto[$aindex]["dir"]."/".$foto[$aindex]["file_name"]);	// generate image_file, set filename to resize
       $thumb->set_max($config["foto_max_size"]);				// set the biggest width or height for thumbnail
       $thumb->process($foto[$aindex]["file_thumb"]);		// save your thumbnail to file
     }
     $foto[$aindex]["size"]        = round((filesize ($foto_dir."/".$entry)/1024),1);
     $foto[$aindex]["filectime"]   = filectime($foto_dir."/".$entry);
     $foto[$aindex]["filemtime"]   = filemtime($foto_dir."/".$entry);
     $foto[$aindex]["date"]        = Date($config["foto_date_format"] , $foto[$aindex]["filemtime"]);
     $aindex++;
   } elseif (($entry != ".") && ($entry != "..") && ($entry != $config["foto_thumb"]) && ($entry != $config["foto_desc"])) {
     $dir[$bindex]["index"] = $bindex;
     $dir[$bindex]["title"] = $entry;
     $dir[$bindex]["dir"]   = $foto_dir."/".$entry;
     $dir[$bindex]["filectime"]  = filectime($foto_dir."/".$entry);
     $dir[$bindex]["filemtime"]  = filemtime($foto_dir."/".$entry);
     $dir[$bindex]["date"]  = Date($config["foto_date_format"] , $dir[$bindex]["filemtime"]);

     $bindex++;
   }
 }
 closedir($handle);

 $dir = foto_arr_sort($dir, $config["foto_sort_by"], $config["foto_sort_ASC"]);
// $foto = foto_arr_sort($foto, $config["foto_sort_by"], $config["foto_sort_ASC"]);

 if (isset($dir)) {
   $phemplate->set_loop('dir', $dir);
 } else {
   $phemplate->set_loop('dir', NULL);
 }
 if (isset($foto)) {
   $phemplate->set_loop('photo', $foto);
 } else {
   $phemplate->set_loop('photo', NULL);
 }
 $phemplate->set_var("browse_script", $config["foto_browse_script"]);
 $phemplate->set_var("detail_script", $config["foto_detail_script"]);	
 return $phemplate->process('proc_foto','foto',2);
}

/* display detail of image */

function foto_detail($foto_dir, $foto_file) {
 require_once("./phemplate.class.php");
 require_once("./config.php");
 $phemplate = new phemplate();  
 $phemplate->set_file('foto',"./foto_detail.htx");


 if (!isset($foto_dir)) {
   $foto_dir = $config["foto_dir"];
 }

 if (!eregi($config["foto_dir"],$foto_dir) || eregi("\.\.",$foto_dir)) {
   Header("Location: ./index.php?st=foto");
   exit();
 }

 $foto["title"] = "error: File not exists!";

 $handle = opendir($foto_dir);
 while($entry = readdir($handle)) {
   if(is_file($foto_dir."/".$entry)) {
     if (isset($foto["file_name"]) && !isset($next_foto)) {
       $next_foto = $entry;
     }
     if ($entry == $foto_file) {
     $foto["fname_description"] =  $foto_dir."/".$config["foto_desc"]."/".$entry.".txt";
     if (file_exists($foto["fname_description"])) {
       unset($temp);
       $temp = file_get_contents($foto["fname_description"]);
       $pos = strpos($temp, "\n");

       if ($pos === false) {
         $foto["title"]       = $temp;
         $foto["description"] = "";
       } else {
         $foto["title"]       = substr($temp, 0, $pos); 
         $foto["description"] = substr($temp, $pos);
       }
     } else {
       $foto["title"]       = $entry;
       $foto["description"] = "";
     }

     $foto["file_name"]     = $entry;
     $foto["dir"]           = $foto_dir;
     if ($config["foto_exif_enabled"] && function_exists(exif_read_data)) {
       $exif = exif_read_data($foto["dir"]."/".$foto["file_name"], 0, true);
       foreach ($exif as $key => $section) {
         foreach ($section as $name => $val) {
           if ($key == "MAKERNOTE")
             $exif_makernote = true;
           if (!eregi("dump|makernote",$name))
             $foto["exif"][$key] .= "$name : $val<br />";
         }
       }
     }

     $foto["size"]        = round((filesize ($foto_dir."/".$entry)/1024),1);
     $foto["filectime"]   = filectime($foto_dir."/".$entry);
     $foto["filemtime"]   = filemtime($foto_dir."/".$entry);
     $foto["date"]        = Date($config["foto_date_format"], $foto["filemtime"]);
     } 

     if (!isset($foto["file_name"])) {
       $prev_foto = $entry;
     }
   } elseif (($entry != ".") && ($entry != "..") && ($entry != $config["foto_thumb"]) && ($entry != $config["foto_desc"])) {
     /* adresare ted neresim */
   }
 }
 closedir($handle);

 if (isset($foto)) {
   $phemplate->set_var('photo', $foto);
 } else {
   $phemplate->set_var('photo', NULL);
 }

 $phemplate->set_var("prev_foto", $prev_foto);
 $phemplate->set_var("next_foto", $next_foto);
 $phemplate->set_var("exif_makernote", $exif_makernote);
 $phemplate->set_var("exif",(isset($exif["EXIF"])));
 $phemplate->set_var("browse_script", $config["foto_browse_script"]);
 $phemplate->set_var("detail_script", $config["foto_detail_script"]);	
 return $phemplate->process('proc_foto','foto',2 | 32);
}

function foto_arr_sort (&$array, $key_sort, $ASC_DESC = "SORT_ASC") { // start function
   if (empty($array)) {
     return array();
   }
   $key_sorta = explode(",", $key_sort); 

   $keys = array_keys($array[0]);

     // sets the $key_sort vars to the first
     for($m=0; $m < count($key_sorta); $m++){ $nkeys[$m] = trim($key_sorta[$m]); }

   $n += count($key_sorta);    // counter used inside loop

     // this loop is used for gathering the rest of the 
     // key's up and putting them into the $nkeys array
     for($i=0; $i < count($keys); $i++){ // start loop

         // quick check to see if key is already used.
         if(!in_array($keys[$i], $key_sorta)){

             // set the key into $nkeys array
             $nkeys[$n] = $keys[$i];

             // add 1 to the internal counter
             $n += "1"; 

           } // end if check

     } // end loop

     // this loop is used to group the first array [$array]
     // into it's usual clumps
     for($u=0;$u<count($array); $u++){ // start loop #1

         // set array into var, for easier access.
         $arr = $array[$u];

           // this loop is used for setting all the new keys 
           // and values into the new order
           for($s=0; $s<count($nkeys); $s++){

               // set key from $nkeys into $k to be passed into multidimensional array
               $k = $nkeys[$s];

                 // sets up new multidimensional array with new key ordering
                 $output[$u][$k] = $array[$u][$k]; 

           } // end loop #2

     } // end loop #1

   // sort
   if ($ASC_DESC == 'SORT_ASC') {
     sort($output);
   } else {
     rsort($output);
   }

 // return sorted array
 return $output;

} // end function


?>