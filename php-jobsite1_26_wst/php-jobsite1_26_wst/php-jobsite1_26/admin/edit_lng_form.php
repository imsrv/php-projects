<?php
if($HTTP_POST_VARS['todo']) {
    $todo=$HTTP_POST_VARS['todo'];
}
elseif ($HTTP_GET_VARS['todo']){
     $todo = $HTTP_GET_VARS['todo'];
}
else {
    $todo = '';
}
if($HTTP_POST_VARS['lng']) {
    $lng=$HTTP_POST_VARS['lng'];
}
elseif ($HTTP_GET_VARS['lng']){
     $lng = $HTTP_GET_VARS['lng'];
}
else {
    $lng = '';
}
$lng_table_lang = substr($lng,0,2);
if($HTTP_POST_VARS['folders']) {
    $folders=$HTTP_POST_VARS['folders'];
}
elseif ($HTTP_GET_VARS['folders']){
     $folders = $HTTP_GET_VARS['folders'];
}
else {
    $folders = '';
}
$folder_table_lang = substr($folders,0,2);
$error_title = "editing language";

function header_nav($l_todo, $l_lng) {
 echo "<table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\"><tr>";
 if ($l_todo == "editlng") {
      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
 }
 else {
      echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editlng&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
 }
 if ($l_todo == "editimg") {
     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
 }
 else {
     echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editimg&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
 }
 if ($l_todo == "editcateg") {
     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit Job categories</b></font></td>";
 }
 else {
     echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editcateg&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit jobcategories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit jobcategories</a></b></font></td>";
 }
 if ($l_todo == "editlocation") {
     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit Job Locations</b></font></td>";
 }
 else {
     echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editlocation&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit Locations'; return true;\" onmouseout=\"window.status=''; return true;\">Edit Locations</a></b></font></td>";
 }
 if ($l_todo == "edittypes") {
     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit employment types</b></font></td>";
 }
 else {
     echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=edittypes&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit employment type'; return true;\" onmouseout=\"window.status=''; return true;\">Edit employment types</a></b></font></td>";
 }
 if ($l_todo == "editoptions") {
     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit language options</b></font></td>";
 }
 else {
     echo "<td align=\"center\" bgcolor=\"#909090\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editoptions&folders=".urlencode($l_lng)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit language options'; return true;\" onmouseout=\"window.status=''; return true;\">Edit language options</a></b></font></td>";
 }
 echo "</tr></table>";
}

if ($todo == "upload") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             if(!empty($HTTP_POST_FILES['flag_file']['tmp_name']) && $HTTP_POST_FILES['flag_file']['tmp_name'] != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($HTTP_POST_FILES['flag_file']['tmp_name'])) && (in_array($HTTP_POST_FILES['flag_file']['type'],array ("image/gif","image/pjpeg","image/jpeg","image/x-png"))))
             {
                $flag_size=getimagesize($HTTP_POST_FILES['flag_file']['tmp_name']);
                switch ($flag_size[2]) {
                          case 1:
                               $flag_extension=".gif";
                               break;
                          case 2:
                               $flag_extension=".jpg";
                               break;
                          case 3:
                               $flag_extension=".png";
                               break;
                        default:
                               $flag_extension="";
        
                }//end switch ($logo_size[2])
                 $flag_location = DIR_FLAG.$lng.$flag_extension;
                 if (file_exists($flag_location)) {
                        @unlink($flag_location);
                 }//end if (file_exists($flag_location))
                 if (file_exists(DIR_FLAG.$lng.".gif")) {
                        @unlink(DIR_FLAG.$lng.".gif");
                 }//end if (file_exists(DIR_FLAG.$lng.".gif"))
                 if (file_exists(DIR_FLAG.$lng.".jpg")) {
                        @unlink(DIR_FLAG.$lng.".jpg");
                 }//end if (file_exists(DIR_FLAG.$lng.".jpg"))
                 if (file_exists(DIR_FLAG.$lng.".png")) {
                        @unlink(DIR_FLAG.$lng.".png");
                 }//end if (file_exists(DIR_FLAG.$lng.".png"))
                 if (move_uploaded_file($HTTP_POST_FILES['flag_file']['tmp_name'], $flag_location)) {
                     @chmod($flag_location, 0777);
                 ?>
                 <script language="Javascript">
                    <!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editlng">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                    //-->
                 </script>
                 <?php
                 }
                 else {
                     bx_admin_error("Language flag picture file upload fail.");
                 }
             }
             else {
                    bx_admin_error("Language flag picture file upload fail.");
             }
       }
}
if ($todo == "uploadimg") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             if(!empty($HTTP_POST_FILES['replace_file']['tmp_name']) && $HTTP_POST_FILES['replace_file']['tmp_name'] != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($HTTP_POST_FILES['replace_file']['tmp_name'])) && (in_array($HTTP_POST_FILES['replace_file']['type'],array ("image/gif","image/pjpeg","image/jpeg","image/x-png"))))
             {
                $replace_size=getimagesize($HTTP_POST_FILES['replace_file']['tmp_name']);
                $replace_location = DIR_IMAGES.$HTTP_POST_VARS['replacefile'];
                if (file_exists($replace_location)) {
                        @unlink($replace_location);
                }//end if (file_exists($flag_location))
                if (move_uploaded_file($HTTP_POST_FILES['replace_file']['tmp_name'], $replace_location)) {
                    @chmod($replace_location, 0777);
                ?>
                 <script language="Javascript"><!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editimg">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                    //-->
                  </script>
                 <?php
                 }
                 else {
                     bx_admin_error("Language image file upload fail.");
                 }
             }
             else {
                    bx_admin_error("Language image file upload fail.");
             }
     }
}
if ($todo == "savetypes") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             $ready = false;
             if (empty($lng)) {
                    bx_admin_error("Please select a language to edit.");
             }
             else {
                   if ($HTTP_POST_VARS['jobtypeid'] == "0") { //when we are adding a jobtype
                        if (empty($HTTP_POST_VARS['jobtype'])) {
                             bx_admin_error("Invalid jobtype! Please enter a jobtype to add.");
                        }
                        else {
                             $dirs = getFolders(DIR_LANGUAGES);  
                             for ($i=0; $i<count($dirs); $i++) {
                                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                           bx_db_query("INSERT INTO ".$bx_table_prefix."_jobtypes_".substr($dirs[$i],0,2)." values ('','".bx_addslashes($HTTP_POST_VARS['jobtype'])."')");
                                           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                   }
                             }    
                             $ready = true;
                        }
                   } //end if ($jobtypeid == "0")
                   else {  //else we are updating a jobtype
                        if (empty($HTTP_POST_VARS['jobtype'])) {
                             bx_admin_error("Invalid jobtype! Please enter a jobtype to update.");
                        }
                        else {
                             bx_db_query("UPDATE ".$bx_table_prefix."_jobtypes_".$lng_table_lang." set jobtype='".bx_addslashes($HTTP_POST_VARS['jobtype'])."' where jobtypeid = '".$HTTP_POST_VARS['jobtypeid']."'");
                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                             $ready = true;
                        }
                   } //end else if ($jobtypeid == "0")
                   if ($ready) {
                ?>
                 <script language="Javascript">
                 <!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="edittypes">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                  //-->
                  </script>
                 <?php
                 }
             }
       }      
}
if ($todo == "deltypes") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);
                for ($i=0; $i<count($dirs); $i++) {
                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                               bx_db_query("DELETE FROM ".$bx_table_prefix."_jobtypes_".substr($dirs[$i],0,2)." where jobtypeid = '".$HTTP_POST_VARS['jobtypeid']."'");
                               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1)); 
                       }
                }  
                $ready = true;
         } //end else if ($jobtypeid == "0")
          if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="edittypes">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }
}
//function to write the language file
function write_language_file($type) {
global $lng, $todo, $HTTP_POST_VARS;  
include(DIR_LANGUAGES.$lng.".php");
$newlangfile = array();
$langfile=file(DIR_LANGUAGES.$lng.".php");
    if ($type == "postlang") {
        if ($todo =="savepostlang") {
            if ($HTTP_POST_VARS['postlangid'] == "0") {
                $i=1;
                while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
                {
                     $i++;
                }
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".($i-1),$langfile[$j],$regs)) {
                        $newlangfile[] = $langfile[$j];
                        $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$i."='".$HTTP_POST_VARS['postlang']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }
            }//end if postlang == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$HTTP_POST_VARS['postlangid'],$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$HTTP_POST_VARS['postlangid']."='".$HTTP_POST_VARS['postlang']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if postlang == "0"
        }
        else if ($todo =="delpostlang") {
            for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$HTTP_POST_VARS['postlangid'],$langfile[$j],$regs)) {
                    }
                    else {
                        if (eregi("TEXT_LANGUAGE_KNOWN_OPT(.*)=(.*)",$langfile[$j],$regsw)) {
                            if ($regsw[1]>$HTTP_POST_VARS['postlangid']) {
                                $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".($regsw[1]-1)."=".$regsw[2];
                            }
                            else {
                                $newlangfile[] = $langfile[$j];       
                            }
                        }
                        else {
                            $newlangfile[] = $langfile[$j];   
                        }
                    }
            }//end for;
        } 
    }
    if ($type == "degree") {
        if ($todo =="savedegree") {
            if ($HTTP_POST_VARS['degreeid'] == "0") {
                $i=1;
                while (${TEXT_DEGREE_OPT.$i})
                {
                     $i++;
                }
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_DEGREE_OPT".($i-1),$langfile[$j],$regs)) {
                        $newlangfile[] = $langfile[$j];
                        $newlangfile[] = "\$TEXT_DEGREE_OPT".$i."='".$HTTP_POST_VARS['degree']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }
            }//end if degreeid == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_DEGREE_OPT".$HTTP_POST_VARS['degreeid'],$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_DEGREE_OPT".$HTTP_POST_VARS['degreeid']."='".$HTTP_POST_VARS['degree']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if degreeid == "0"
        }
        else if ($todo =="deldegree") {
            for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_DEGREE_OPT".$HTTP_POST_VARS['degreeid'],$langfile[$j],$regs)) {
                    }
                    else {
                        if (eregi("TEXT_DEGREE_OPT(.*)=(.*)",$langfile[$j],$regsw)) {
                            if ($regsw[1]>$HTTP_POST_VARS['degreeid']) {
                                $newlangfile[] = "\$TEXT_DEGREE_OPT".($regsw[1]-1)."=".$regsw[2];
                            }
                            else {
                                $newlangfile[] = $langfile[$j];       
                            }
                        }
                        else {
                            $newlangfile[] = $langfile[$j];   
                        }
                    }
            }//end for;
        } 
    }
    if ($type == "cctype") {
        if ($todo =="savecctype") {
            if ($HTTP_POST_VARS['cctypeid'] == "0") {
                $i=1;
                while (${TEXT_CCTYPE_OPT.$i})
                {
                     $i++;
                }
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_CCTYPE_OPT".($i-1),$langfile[$j],$regs)) {
                        $newlangfile[] = $langfile[$j];
                        $newlangfile[] = "\$TEXT_CCTYPE_OPT".$i."='".$HTTP_POST_VARS['cctype']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }
            }//end if degreeid == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_CCTYPE_OPT".$HTTP_POST_VARS['cctypeid'],$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_CCTYPE_OPT".$HTTP_POST_VARS['cctypeid']."='".$HTTP_POST_VARS['cctype']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if degreeid == "0"
        }
        else if ($todo =="delcctype") {
            for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_CCTYPE_OPT".$HTTP_POST_VARS['cctypeid'],$langfile[$j],$regs)) {
                    }
                    else {
                        if (eregi("TEXT_CCTYPE_OPT(.*)=(.*)",$langfile[$j],$regsw)) {
                            if ($regsw[1]>$HTTP_POST_VARS['cctypeid']) {
                                $newlangfile[] = "\$TEXT_CCTYPE_OPT".($regsw[1]-1)."=".$regsw[2];
                            }
                            else {
                                $newlangfile[] = $langfile[$j];       
                            }
                        }
                        else {
                            $newlangfile[] = $langfile[$j];   
                        }
                    }
            }//end for;
        } 
    }
    if ($type == "jobmail") {
        if ($todo =="savejobmail") {
            if ($HTTP_POST_VARS['jobmailid'] == "0") {
            }//end if jobmailid == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_JOBMAIL_OPT".$HTTP_POST_VARS['jobmailid'],$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_JOBMAIL_OPT".$HTTP_POST_VARS['jobmailid']."='".$HTTP_POST_VARS['jobmail']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if jobmailid == "0"
        }
    }
    if ($type == "payment") {
        if ($todo =="savepayment") {
            if ($HTTP_POST_VARS['paymentid'] == "0") {
            }//end if paymentid == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_PAYMENT_OPT".$HTTP_POST_VARS['paymentid'],$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_PAYMENT_OPT".$HTTP_POST_VARS['paymentid']."='".$HTTP_POST_VARS['payment']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if paymentid == "0"
        }
    }
    if ($type == "charset") {
        if ($todo =="savecharset") {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("CHARSET_OPTION",$langfile[$j],$regs)) {
                        $newlangfile[] = "\$CHARSET_OPTION='".$HTTP_POST_VARS['charset']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
         }       
    }
    if ($type == "dformat") {
        if ($todo =="savedformat") {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("DATE_FORMAT",$langfile[$j],$regs)) {
                        $newlangfile[] = "\$DATE_FORMAT='".$HTTP_POST_VARS['dformat']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
         }       
    }
    if ($type == "pformat") {
        if ($todo =="savepformat") {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("PRICE_FORMAT",$langfile[$j],$regs)) {
                        $newlangfile[] = "\$PRICE_FORMAT='".$HTTP_POST_VARS['pformat']."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
         }       
    }
    $fp = fopen(DIR_LANGUAGES.$lng.".php", "w");
    for ($j=0;$j<sizeof($newlangfile);$j++) {
          fwrite($fp, $newlangfile[$j]);
    }
    fclose($fp);
}
//end function write_language_file
if ($todo == "savepostlang") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
               if ($HTTP_POST_VARS['postlangid'] == "0") { //when we are adding a jobtype
                    if (empty($HTTP_POST_VARS['postlang'])) {
                         bx_admin_error("Invalid Posting language! Please enter a Posting language to add.");
                    }
                    else {
                         $dirs = getFolders(DIR_LANGUAGES);  
                         for ($i=0; $i<count($dirs); $i++) {
                                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                           $lng = $dirs[$i];
                                            write_language_file("postlang");
                                   }
                         }     
                         $ready = true;
                    }
               } //end if ($jobtypeid == "0")
               else {  //else we are updating a jobtype
                    if (empty($HTTP_POST_VARS['postlang'])) {
                         bx_admin_error("Invalid Posting language! Please enter a Posting language to add.");
                    }
                    else {
                         write_language_file("postlang");
                         $ready = true;
                    }
               } //end else if ($jobtypeid == "0")
               if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "delpostlang") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);  
                for ($i=0; $i<count($dirs); $i++) {
                           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                   $lng = $dirs[$i];
                                    write_language_file("postlang");
                           }
                }    
                $ready = true;
         } //end else if ($jobtypeid == "0")
          if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }     
}
if ($todo == "savedegree") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             $ready = false;
             if (empty($lng)) {
                    bx_admin_error("Please select a language to edit.");
             }
             else {
                   if ($HTTP_POST_VARS['degreeid'] == "0") { //when we are adding a jobtype
                        if (empty($HTTP_POST_VARS['degree'])) {
                             bx_admin_error("Invalid Degree Option! Please enter a Degree Option to add.");
                        }
                        else {
                             $dirs = getFolders(DIR_LANGUAGES);  
                             for ($i=0; $i<count($dirs); $i++) {
                                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                               $lng = $dirs[$i];
                                                write_language_file("degree");
                                       }
                             }    
                             $ready = true;
                        }
                   } //end if ($postlangid == "0")
                   else {  //else we are updating a jobtype
                        if (empty($HTTP_POST_VARS['degree'])) {
                             bx_admin_error("Invalid Degree Option! Please enter a Degree Option to add.");
                        }
                        else {
                             write_language_file("degree");
                             $ready = true;
                        }
                   } //end else if ($postlangid == "0")
                   if ($ready) {
                ?>
                 <script language="Javascript">
                 <!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editoptions">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                  //-->
                  </script>
                 <?php
                 }
            }
     }        
}
if ($todo == "deldegree") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);  
                for ($i=0; $i<count($dirs); $i++) {
                           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                   $lng = $dirs[$i];
                                    write_language_file("degree");
                           }
                }    
                $ready = true;
         } //end else if ($jobtypeid == "0")
         if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }     
}
if ($todo == "savecctype") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             $ready = false;
             if (empty($lng)) {
                    bx_admin_error("Please select a language to edit.");
             }
             else {
                   if ($HTTP_POST_VARS['cctypeid'] == "0") { //when we are adding a jobtype
                        if (empty($HTTP_POST_VARS['cctype'])) {
                             bx_admin_error("Invalid CC Type Option! Please enter a CC Type Option to add.");
                        }
                        else {
                             $dirs = getFolders(DIR_LANGUAGES);  
                             for ($i=0; $i<count($dirs); $i++) {
                                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                               $lng = $dirs[$i];
                                                write_language_file("cctype");
                                       }
                             }    
                             $ready = true;
                        }
                   } //end if ($postlangid == "0")
                   else {  //else we are updating a jobtype
                        if (empty($HTTP_POST_VARS['cctype'])) {
                             bx_admin_error("Invalid CC Type Option! Please enter a CC Type Option to add.");
                        }
                        else {
                             write_language_file("cctype");
                             $ready = true;
                        }
                   } //end else if ($postlangid == "0")
                   if ($ready) {
                ?>
                 <script language="Javascript">
                 <!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editoptions">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                  //-->
                  </script>
                 <?php
                 }
            }
     }        
}
if ($todo == "delcctype") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);  
                for ($i=0; $i<count($dirs); $i++) {
                           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                   $lng = $dirs[$i];
                                    write_language_file("cctype");
                           }
                }
                $ready = true;
         } //end else if ($cctypeid == "0")
         if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }     
}
if ($todo == "savejobmail") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
               if ($HTTP_POST_VARS['jobmailid'] == "0") { //when we are adding a jobtype
               } //end if ($postlangid == "0")
               else {  //else we are updating a jobtype
                    if (empty($HTTP_POST_VARS['jobmail'])) {
                         bx_admin_error("Invalid Jobmail Option! Please enter a Jobmail Option to add.");
                    }
                    else {
                         write_language_file("jobmail");
                         $ready = true;
                    }
               } //end else if ($postlangid == "0")
               if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
    }     
}
if ($todo == "savepayment") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
               if ($HTTP_POST_VARS['paymentid'] == "0") { //when we are adding a jobtype
               } //end if ($postlangid == "0")
               else {  //else we are updating a jobtype
                    if (empty($HTTP_POST_VARS['payment'])) {
                         bx_admin_error("Invalid Payment Option! Please enter a Payment Option to add.");
                    }
                    else {
                         write_language_file("payment");
                         $ready = true;
                    }
               } //end else if ($postlangid == "0")
               if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "savecharset") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($HTTP_POST_VARS['lng'])) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                   if (empty($HTTP_POST_VARS['charset'])) {
                         bx_admin_error("Invalid Language Encoding Option! Please enter a Language Encoding to update.");
                   }
                   else {
                         write_language_file("charset");
                        $ready = true;
                   }
             if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "savedformat") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($HTTP_POST_VARS['lng'])) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                   if (empty($HTTP_POST_VARS['dformat'])) {
                         bx_admin_error("Invalid Language Date Format! Please enter a Language Date Format (e.g. mm/dd/YYYY).");
                   }
                   else {
                         write_language_file("dformat");
                        $ready = true;
                   }
             if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "savepformat") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($HTTP_POST_VARS['lng'])) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                   if (empty($HTTP_POST_VARS['pformat'])) {
                         bx_admin_error("Invalid Language Price Format! Please enter a Language Price Format (e.g. 1,234.56).");
                   }
                   else {
                         write_language_file("pformat");
                        $ready = true;
                   }
             if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editoptions">');
                document.write('<input type="hidden" name="folders" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "savecateg") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
               if ($HTTP_POST_VARS['jobcategoryid'] == "0") { //when we are adding a jobcategory
                    if (empty($HTTP_POST_VARS['jobcategory'])) {
                         bx_admin_error("Invalid jobcategory! Please enter a jobcategory to add.");
                    }
                    else {
                          $dirs = getFolders(DIR_LANGUAGES);  
                          for ($i=0; $i<count($dirs); $i++) {
                               if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                       bx_db_query("INSERT INTO ".$bx_table_prefix."_jobcategories_".substr($dirs[$i],0,2)." values ('','".bx_addslashes($HTTP_POST_VARS['jobcategory'])."')");
                                       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                               }
                         }    
                         $ready = true;
                    }
               } //end if ($jobcategoryid == "0")
               else {  //else we are updating a jobcategory
                    if (empty($HTTP_POST_VARS['jobcategory'])) {
                         bx_admin_error("Invalid jobcategory! Please enter a jobcategory to update.");
                    }
                    else {
                         bx_db_query("UPDATE ".$bx_table_prefix."_jobcategories_".$lng_table_lang." set jobcategory='".bx_addslashes($HTTP_POST_VARS['jobcategory'])."' where jobcategoryid = '".$HTTP_POST_VARS['jobcategoryid']."'");
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         $ready = true;
                    }
               } //end else if ($jobtypeid == "0")
               if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editcateg">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
    }    
}
if ($todo == "ordercateg") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                   $categ_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobcategories_".$lng_table_lang." order by jobcategory");
                   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                   $mysql_query= array();
                   $mysql_query[]="DELETE FROM ".$bx_table_prefix."_jobcategories_".$lng_table_lang;
                   while($categ_result=bx_db_fetch_array($categ_query)){
                           $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_jobcategories_".$lng_table_lang." VALUES (".$categ_result[0].",'".addslashes($categ_result[1])."')";  
                   }//end while
                   for ($i=0;$i<sizeof($mysql_query);$i++){
                       bx_db_query($mysql_query[$i]);
                       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                   }    
                   $mysql_query = array();
                   $ready = true;
           }
           if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editcateg">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
     }
}
if ($todo == "savebulkcateg") {
     if(ADMIN_SAFE_MODE == "yes" && ($lng==DEFAULT_LANGUAGE || $HTTP_POST_VARS['translate']!="yes" )) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                    if (empty($HTTP_POST_VARS['jobcategoryids'])) {
                         bx_admin_error("Invalid jobcategorys! Please enter the jobcategorys to add.");
                    }
                    else {
                         $categ_ids = split("\n", bx_addslashes(trim($HTTP_POST_VARS['jobcategoryids'])));
                         $old_categ_ids = array();
                         $categ_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobcategories_".$lng_table_lang);
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         while ($categ_result=bx_db_fetch_array($categ_query)) {
                             $old_categ_ids['jobcategory'][] = trim($categ_result['jobcategory']);
                             $old_categ[] = strtolower(trim($categ_result['jobcategory']));
                             $old_categ_ids['jobcategoryid'][] = $categ_result['jobcategoryid'];
                         }
                         if ($HTTP_POST_VARS['translate']!="yes") {
                                 $auto_query=bx_db_query("SHOW TABLE STATUS LIKE '".$bx_table_prefix."_jobcategories_".$lng_table_lang."'");
                                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                 $auto_result=bx_db_fetch_array($auto_query);
                                 $maxid= $auto_result['Auto_increment'];
                                 if(!$maxid) {
                                     $auto_query=bx_db_query("select MAX(jobcategoryid) as maxid FROM '".$bx_table_prefix."_jobcategories_".$lng_table_lang."'");
                                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                     $auto_result=bx_db_fetch_array($auto_query);
                                     $maxid= $auto_result['maxid']+1;
                                 }
                                 $new_categ = array();
                                 $not_found = array();
                                 $not_found_ids = array();
                                 $not_found_pos = array();
                                 $n=0;
                                 for($i=0; $i<sizeof($categ_ids); $i++){
                                     $categ_id = strtolower(bx_stripslashes(trim($categ_ids[$i])));
                                     if ($categ_id!="") {
                                             $key=array_search($categ_id, $old_categ);
                                             if(($key==null || $key==false)){
                                                 if($categ_id==$old_categ[0]) {
                                                     $new_categ[$old_categ_ids['jobcategoryid'][0]]= eregi_replace("\n|\r|\013|\015$","",$categ_ids[$i]);
                                                     $new_categ_ids[] = $old_categ_ids['jobcategoryid'][0];
                                                     $n++;
                                                 }
                                                 else {
                                                     $not_found[$maxid] = eregi_replace("\n|\r|\013|\015$","",$categ_ids[$i]);
                                                     if ($not_found_pos[$maxid-1] == $n) {
                                                         $not_found_ids[] = $maxid;
                                                         $not_found_pos[$maxid]=$n;
                                                     }
                                                     else {
                                                         $not_found_ids[] = $maxid;
                                                         $not_found_pos[$maxid]=$n;
                                                     }
                                                     $new_categ[$maxid]= eregi_replace("\n|\r|\013|\015$","",$categ_ids[$i]);
                                                     $new_categ_ids[] = $maxid;
                                                     $maxid++;
                                                 }
                                             }
                                             else {
                                                 $new_categ[$old_categ_ids['jobcategoryid'][$key]]= eregi_replace("\n|\r|\013|\015$","",$categ_ids[$i]);
                                                 $new_categ_ids[] = $old_categ_ids['jobcategoryid'][$key];
                                                 $n++;
                                             }
                                     }
                                 }
                                 $del=array_diff($old_categ_ids['jobcategoryid'], $new_categ_ids);
                                 $mysql_query= array();
                                 $mysql_query[]="DELETE FROM ".$bx_table_prefix."_jobcategories_".$lng_table_lang;
                                 $r=0;
                                 while(list($k, $v) = each($new_categ)){
                                     $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_jobcategories_".$lng_table_lang." VALUES (".$new_categ_ids[$r].",'".$v."')";  
                                     $r++;
                                 }    
                                 $new_categ= $new_categ_ids[0];
                                 $lang_ar = array(); 
                                 $dirs = getFolders(DIR_LANGUAGES);
                                 for ($i=0; $i<count($dirs); $i++) {
                                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php") && $dirs[$i]!=$lng) {
                                               $lang_ar[] = substr($dirs[$i],0,2);
                                       }
                                 }
                                 for ($i=0; $i<sizeof($lang_ar); $i++) {
                                         $addcateg_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobcategories_".$lang_ar[$i]."");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         $mysql_query[]="DELETE FROM ".$bx_table_prefix."_jobcategories_".$lang_ar[$i];
                                         $pos=0;
                                         while($addcateg_result=bx_db_fetch_array($addcateg_query)){
                                                   $y=0;
                                                   reset($not_found);
                                                   while(list($k, $v) = each($not_found)){
                                                       if($pos == $not_found_pos[$k]){
                                                           $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_jobcategories_".$lang_ar[$i]." VALUES (".$not_found_ids[$y].",'".$v."')";  
                                                       }
                                                       $y++;
                                                   }
                                                   $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_jobcategories_".$lang_ar[$i]." VALUES (".$addcateg_result[0].",'".addslashes($addcateg_result[1])."')";  
                                                   $pos++;
                                         }//end while   
                                         $y=0;
                                         reset($not_found);
                                         while(list($k, $v) = each($not_found)){
                                               if($pos == $not_found_pos[$k]){
                                                   $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_jobcategories_".$lang_ar[$i]." VALUES (".$not_found_ids[$y].",'".$v."')";  
                                               }
                                               $y++;
                                         }            
                                 }    
                                 while(list($k, $v) = each($del)){
                                         bx_db_query("UPDATE ".$bx_table_prefix."_jobs set jobcategoryid='".$new_categ."' where jobcategoryid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE del".$bx_table_prefix."_jobs set jobcategoryid='".$new_categ."' where jobcategoryid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE ".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$v."-', '-".$new_categ."-') where POSITION('-".$v."-' IN jobcategoryids)!=0");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE del".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$v."-', '-".$new_categ."-') where POSITION('-".$v."-' IN jobcategoryids)!=0");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                          for ($i=0; $i<sizeof($lang_ar); $i++) {
                                               $mysql_query[] = "DELETE FROM ".$bx_table_prefix."_jobcategories_".$lang_ar[$i]." where jobcategoryid = '".$v."'";    
                                         }
                                 }
                         }
                         else {
                             $m = min(sizeof($categ_ids),sizeof($old_categ_ids['jobcategoryid']));
                             for($i=0; $i<$m; $i++){
                                     $mysql_query[] = "UPDATE ".$bx_table_prefix."_jobcategories_".$lng_table_lang." set jobcategory = '".eregi_replace("\n|\r|\013|\015$","",$categ_ids[$i])."' where jobcategoryid = ".$old_categ_ids['jobcategoryid'][$i]."";  
                             }      
                         }
                         for ($i=0;$i<sizeof($mysql_query);$i++){
                               bx_db_query($mysql_query[$i]);
                               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         }
                         $mysql_query = array();
                         $ready = true;
                    }
                    if ($ready) {
                    ?>
                     <script language="Javascript">
                     <!--
                        document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                        document.write('<input type="hidden" name="todo" value="editcateg">');
                        document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                        document.write('</form>');
                        document.redirect.submit();
                      //-->
                      </script>
                     <?php
                     }
         }    
    }  
}
if ($todo == "delcateg") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);
                for ($i=0; $i<count($dirs); $i++) {
                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                               bx_db_query("DELETE FROM ".$bx_table_prefix."_jobcategories_".substr($dirs[$i],0,2)." where jobcategoryid = '".$HTTP_POST_VARS['jobcategoryid']."'");
                               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                       }
                } 
                $newcateg_query=bx_db_query("select * FROM ".$bx_table_prefix."_jobcategories_".$lng_table_lang." LIMIt 0,1");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                $newcateg_result = bx_db_fetch_array($newcateg_query);
                $new_categ = $newcateg_result['jobcategoryid'];
                bx_db_query("UPDATE ".$bx_table_prefix."_jobs set jobcategoryid='".$new_categ."' where jobcategoryid = '".$HTTP_POST_VARS['jobcategoryid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE del".$bx_table_prefix."_jobs set jobcategoryid='".$new_categ."' where jobcategoryid = '".$HTTP_POST_VARS['jobcategoryid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                if($new_categ) {
                    bx_db_query("UPDATE ".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$HTTP_POST_VARS['jobcategoryid']."-', '-".$new_categ."-') where POSITION('-".$HTTP_POST_VARS['jobcategoryid']."-' IN jobcategoryids)!=0");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    bx_db_query("UPDATE del".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$HTTP_POST_VARS['jobcategoryid']."-', '-".$new_categ."-') where POSITION('-".$HTTP_POST_VARS['jobcategoryid']."-' IN jobcategoryids)!=0");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
                else {
                    bx_db_query("UPDATE ".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$HTTP_POST_VARS['jobcategoryid']."-', '-') where POSITION('-".$HTTP_POST_VARS['jobcategoryid']."-' IN jobcategoryids)!=0");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    bx_db_query("UPDATE del".$bx_table_prefix."_resumes set jobcategoryids=REPLACE(jobcategoryids,'-".$HTTP_POST_VARS['jobcategoryid']."-', '-') where POSITION('-".$HTTP_POST_VARS['jobcategoryid']."-' IN jobcategoryids)!=0");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
                $ready = true;
         } //end else if ($jobtypeid == "0")
          if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editcateg">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }     
}
if ($todo == "savelocation") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
               if ($HTTP_POST_VARS['locationid'] == "0") { //when we are adding a jobcategory
                    if (empty($HTTP_POST_VARS['location'])) {
                         bx_admin_error("Invalid location! Please enter a location to add.");
                    }
                    else {
                         $dirs = getFolders(DIR_LANGUAGES);  
                          for ($i=0; $i<count($dirs); $i++) {
                               if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                       bx_db_query("INSERT INTO ".$bx_table_prefix."_locations_".substr($dirs[$i],0,2)." values ('','".bx_addslashes($HTTP_POST_VARS['location'])."')");
                                       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                               }
                         }    
                         $ready = true;
                    }
               } //end if ($locationid == "0")
               else {  //else we are updating a location
                    if (empty($HTTP_POST_VARS['location'])) {
                         bx_admin_error("Invalid location! Please enter a location to update.");
                    }
                    else {
                         bx_db_query("UPDATE ".$bx_table_prefix."_locations_".$lng_table_lang." set location='".bx_addslashes($HTTP_POST_VARS['location'])."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         $ready = true;
                    }
               } //end else if ($locationid == "0")
               if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editlocation">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
         }
     }    
}
if ($todo == "orderloc") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                 $location_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_locations_".$lng_table_lang." order by location");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 $mysql_query= array();
                 $mysql_query[]="DELETE FROM ".$bx_table_prefix."_locations_".$lng_table_lang;
                 while($location_result=bx_db_fetch_array($location_query)){
                            $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_locations_".$lng_table_lang." VALUES (".$location_result[0].",'".addslashes($location_result[1])."')";  
                 }//end while
                 for ($i=0;$i<sizeof($mysql_query);$i++){
                       bx_db_query($mysql_query[$i]);
                       SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 }    
                 $mysql_query = array();
                 $ready = true;
           }
           if ($ready) {
            ?>
             <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editlocation">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
              </script>
             <?php
             }
     }
}
if ($todo == "savebulklocation") {
     if(ADMIN_SAFE_MODE == "yes" && ($lng==DEFAULT_LANGUAGE || $HTTP_POST_VARS['translate']!="yes" )) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                    if (empty($HTTP_POST_VARS['locationids'])) {
                         bx_admin_error("Invalid locations! Please enter the locations to add.");
                    }
                    else {
                         $location_ids = split("\n", bx_addslashes(trim($HTTP_POST_VARS['locationids'])));
                         $old_location_ids = array();
                         $location_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_locations_".$lng_table_lang);
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         while ($location_result=bx_db_fetch_array($location_query)) {
                             $old_location_ids['location'][] = trim($location_result['location']);
                             $old_location[] = strtolower(trim($location_result['location']));
                             $old_location_ids['locationid'][] = $location_result['locationid'];
                         }
                         if ($HTTP_POST_VARS['translate']!="yes") {
                                 $auto_query=bx_db_query("SHOW TABLE STATUS LIKE '".$bx_table_prefix."_locations_".$lng_table_lang."'");
                                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                 $auto_result=bx_db_fetch_array($auto_query);
                                 $maxid= $auto_result['Auto_increment'];
                                 if(!$maxid) {
                                     $auto_query=bx_db_query("select MAX(locationid) as maxid FROM '".$bx_table_prefix."_locations_".$lng_table_lang."'");
                                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                     $auto_result=bx_db_fetch_array($auto_query);
                                     $maxid= $auto_result['maxid']+1;
                                 }
                                 $new_locations = array();
                                 $not_found = array();
                                 $not_found_ids = array();
                                 $not_found_pos = array();
                                 $n=0;
                                 for($i=0; $i<sizeof($location_ids); $i++){
                                     $location_id = strtolower(bx_stripslashes(trim($location_ids[$i])));
                                     if($location_id!="") {
                                             $key=array_search($location_id, $old_location);
                                             if(($key==null || $key==false)){
                                                 if($location_id==$old_location[0]) {
                                                         $new_locations[$old_location_ids['locationid'][0]]= eregi_replace("\n|\r|\013|\015$","",$location_ids[$i]);
                                                         $new_locations_ids[] = $old_location_ids['locationid'][0];
                                                         $n++;
                                                 }
                                                 else {
                                                         $not_found[$maxid] = eregi_replace("\n|\r|\013|\015$","",$location_ids[$i]);
                                                         if ($not_found_pos[$maxid-1] == $n) {
                                                             $not_found_ids[] = $maxid;
                                                             $not_found_pos[$maxid]=$n;
                                                         }
                                                         else {
                                                             $not_found_ids[] = $maxid;
                                                             $not_found_pos[$maxid]=$n;
                                                         }
                                                         $new_locations[$maxid]= eregi_replace("\n|\r|\013|\015$","",$location_ids[$i]);
                                                         $new_locations_ids[] = $maxid;
                                                         $maxid++;
                                                 }
                                             }
                                             else {
                                                 $new_locations[$old_location_ids['locationid'][$key]]= eregi_replace("\n|\r|\013|\015$","",$location_ids[$i]);
                                                 $new_locations_ids[] = $old_location_ids['locationid'][$key];
                                                 $n++;
                                             }
                                     }
                                 }
                                 $del=array_diff($old_location_ids['locationid'], $new_locations_ids);
                                 $mysql_query= array();
                                 $mysql_query[]="DELETE FROM ".$bx_table_prefix."_locations_".$lng_table_lang;
                                 $r=0;
                                 while(list($k, $v) = each($new_locations)){
                                     $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_locations_".$lng_table_lang." VALUES (".$new_locations_ids[$r].",'".$v."')";  
                                     $r++;
                                 }    
                                 $new_loc= $new_locations_ids[0];
                                 $lang_ar = array(); 
                                 $dirs = getFolders(DIR_LANGUAGES);
                                 for ($i=0; $i<count($dirs); $i++) {
                                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php") && $dirs[$i]!=$lng) {
                                               $lang_ar[] = substr($dirs[$i],0,2);
                                       }
                                 }
                                 $y=0;
                                 for ($i=0; $i<sizeof($lang_ar); $i++) {
                                     $addloc_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_locations_".$lang_ar[$i]."");
                                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                     $mysql_query[]="DELETE FROM ".$bx_table_prefix."_locations_".$lang_ar[$i];
                                     $pos=0;
                                     while($addloc_result=bx_db_fetch_array($addloc_query)){
                                               $y=0;
                                               reset($not_found);
                                               while(list($k, $v) = each($not_found)){
                                                   if($pos == $not_found_pos[$k]){
                                                        $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_locations_".$lang_ar[$i]." VALUES (".$not_found_ids[$y].",'".$v."')";  
                                                   }
                                                   $y++;
                                               }   
                                               $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_locations_".$lang_ar[$i]." VALUES (".$addloc_result[0].",'".addslashes($addloc_result[1])."')";  
                                               $pos++;
                                     }//end while    
                                     $y=0;
                                     reset($not_found);
                                     while(list($k, $v) = each($not_found)){
                                           if($pos == $not_found_pos[$k]){
                                                $mysql_query[] = "INSERT INTO ".$bx_table_prefix."_locations_".$lang_ar[$i]." VALUES (".$not_found_ids[$y].",'".$v."')";  
                                           }
                                           $y++;
                                     }
                                 }    
                                 while(list($k, $v) = each($del)){
                                         bx_db_query("UPDATE ".$bx_table_prefix."_jobs set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE del".$bx_table_prefix."_jobs set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE ".$bx_table_prefix."_persons set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE del".$bx_table_prefix."_persons set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE ".$bx_table_prefix."_companies set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         bx_db_query("UPDATE del".$bx_table_prefix."_companies set locationid='".$new_loc."' where locationid = '".$v."'");
                                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         if($new_loc) {
                                             bx_db_query("UPDATE ".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$v."-', '-".$new_loc."-') where POSITION('-".$v."-' IN locationids)!=0");
                                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                             bx_db_query("UPDATE del".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$v."-', '-".$new_loc."-') where POSITION('-".$v."-' IN locationids)!=0");
                                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));    
                                         }
                                         else {
                                             bx_db_query("UPDATE ".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$v."-', '-') where POSITION('-".$v."-' IN locationids)!=0");
                                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                             bx_db_query("UPDATE del".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$v."-', '-') where POSITION('-".$v."-' IN locationids)!=0");
                                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                         }
                                         for ($i=0; $i<sizeof($lang_ar); $i++) {
                                               $mysql_query[] = "DELETE FROM ".$bx_table_prefix."_locations_".$lang_ar[$i]." where locationid = '".$v."'";    
                                         }
                                 }
                         }
                         else {
                             $m = min(sizeof($location_ids),sizeof($old_location_ids['locationid']));
                             for($i=0; $i<$m; $i++){
                                     $mysql_query[] = "UPDATE ".$bx_table_prefix."_locations_".$lng_table_lang." set location = '".eregi_replace("\n|\r|\013|\015$","",$location_ids[$i])."' where locationid = ".$old_location_ids['locationid'][$i]."";  
                             }      
                         }
                         for ($i=0;$i<sizeof($mysql_query);$i++){
                               bx_db_query($mysql_query[$i]);
                               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         }
                         $mysql_query = array();
                         $ready = true;
                    }
                    if ($ready) {
                    ?>
                     <script language="Javascript">
                     <!--
                        document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                        document.write('<input type="hidden" name="todo" value="editlocation">');
                        document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                        document.write('</form>');
                        document.redirect.submit();
                      //-->
                      </script>
                     <?php
                     }
             }    
      }  
}
if ($todo == "dellocation") {
     if(ADMIN_SAFE_MODE == "yes") {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
         $ready = false;
         if (empty($lng)) {
                bx_admin_error("Please select a language to edit.");
         }
         else {
                $dirs = getFolders(DIR_LANGUAGES);
                for ($i=0; $i<count($dirs); $i++) {
                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                               bx_db_query("DELETE FROM ".$bx_table_prefix."_locations_".substr($dirs[$i],0,2)." where locationid = '".$HTTP_POST_VARS['locationid']."'");
                               SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                       }
                } 
                $newloc_query=bx_db_query("select * FROM ".$bx_table_prefix."_locations_".$lng_table_lang." LIMIt 0,1");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                $newloc_result = bx_db_fetch_array($newloc_query);
                $new_loc = $newloc_result['locationid'];
                bx_db_query("UPDATE ".$bx_table_prefix."_jobs set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE del".$bx_table_prefix."_jobs set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE ".$bx_table_prefix."_persons set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE del".$bx_table_prefix."_persons set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE ".$bx_table_prefix."_companies set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("UPDATE del".$bx_table_prefix."_companies set locationid='".$new_loc."' where locationid = '".$HTTP_POST_VARS['locationid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                if($new_loc) {
                        bx_db_query("UPDATE ".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$HTTP_POST_VARS['locationid']."-', '-".$new_loc."-') where POSITION('-".$HTTP_POST_VARS['locationid']."-' IN locationids)!=0");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("UPDATE del".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$HTTP_POST_VARS['locationid']."-', '-".$new_loc."-') where POSITION('-".$HTTP_POST_VARS['locationid']."-' IN locationids)!=0");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
                else {
                        bx_db_query("UPDATE ".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$HTTP_POST_VARS['locationid']."-', '-') where POSITION('-".$HTTP_POST_VARS['locationid']."-' IN locationids)!=0");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("UPDATE del".$bx_table_prefix."_resumes set locationids=REPLACE(locationids,'-".$HTTP_POST_VARS['locationid']."-', '-') where POSITION('-".$HTTP_POST_VARS['locationid']."-' IN locationids)!=0");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                }
                
                $ready = true;
         } //end else if ($jobtypeid == "0")
          if ($ready) {
            ?>
             <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editlocation">');
                document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
     }     
}
else if ($todo == "savefile") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
         $error_title = "editing language";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
            $towrite = '';
            for ($i=0;$i<count($HTTP_POST_VARS['inputs']) ;$i++ ) {
                if ($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]) {
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = bx_stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                    if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) {
                        if(ADMIN_SAFE_MODE == "yes") {
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("exec|system|\(|\)|\$|print|echo","",$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        }    
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'\.$", "\\\\'.", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'\.", "'.", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("^\.\\\\'", "%[wqt]%", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\.\\\\'", ".'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("%\[wqt\]%", ".\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);  
                    }
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\", "\\\\", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'", "'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        if($HTTP_POST_VARS['type']=="main") {
                            $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".preg_replace("/(\015\012)|(\015)|(\012)/","'.\"\\n\".'",$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]])."');\n";
	                    }
                        else {
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\015\012|\015|\012", ' ', trim($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]));
                            $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]."');\n";
                        }
                }
                else {
                    if ( is_string($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]])) {
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = bx_stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) 	{
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        }
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\", "\\\\", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'", "'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\015\012|\015|\012", ' ', trim($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]));
                        $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]."');\n";
                    }
                    else {
                        $towrite .= "".bx_stripslashes(trim($HTTP_POST_VARS['inputs'][$i]))."\n";
                    }
                }
            }
            $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'],"w");
            fwrite($fp,"<?php\n");
            fwrite($fp, eregi_replace("\n$","",$towrite));
            fwrite($fp,"\n?>");
            fclose($fp);
            @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['filename'], 0777);
            ?>
            <script language="Javascript">
                    <!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editlng">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $lng;?>">');
                    document.write('</form>');
                    document.redirect.submit();
                    //-->
            </script>
     <?php
     }
}
else if ($todo == "editfile") {
$fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'],"r");
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?ref=".time();?>" name="editfile">
<input type="hidden" name="todo" value="savefile">
<input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>">
<input type="hidden" name="lng" value="<?php echo $lng;?>">
<?php if($HTTP_POST_VARS['type']=="main") {
	echo "<input type=\"hidden\" name=\"type\" value=\"main\">";
}?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language file: <?php echo $HTTP_POST_VARS['editfile'];?></b></font></td></tr>
<tr>
   <td bgcolor="#000000"><TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
   <tr>
       <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Base language text:</b></font></td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>New language text:</b></font></td>
   </tr>
<?php
$i=1;
while (!feof($fp)) {
   $str=trim(fgets($fp, 20000));
   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
        if (eregi("define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
            echo "<tr>";
            $regexp[2] = eregi_replace("'$", "", $regexp[2]);
            $regexp[2] = eregi_replace("\\\\\\\\", "\\", $regexp[2]);
			if (strlen(eregi_replace("'","",$regexp[2])) < 30) {
                echo "<td width=\"50%\"><span class=\"editlng\">".eregi_replace("\\\\'","'",$regexp[2])."</span></td><td><input type=\"text\" name=\"".$regexp[1]."\" size=\"40\" value=\"".eregi_replace("\\\\'","'",$regexp[2])."\"></td>";
            }
            else {
                $regexp[2] = eregi_replace("'\.&quot;\\\\n&quot;\.'","\n",$regexp[2]);
                $regexp[2] = eregi_replace('\.&quot;\\\\n&quot;\.',"\n",eregi_replace("\\\\'","&#039",eregi_replace("'\.","&#039;.",eregi_replace("\.'",".&#039;",$regexp[2]))));
                echo "<td width=\"50%\" valign=\"top\">";
                echo "<span class=\"editlng\">".$regexp[2]."</span></td><td><textarea name=\"".$regexp[1]."\"  rows=\"8\" cols=\"50\" wrap=virtual>".eregi_replace("'","",$regexp[2])."</textarea></td>";
            }
            echo "</tr>";
			echo "<input type=\"hidden\" name=\"inputs[]\" value=\"".$regexp[1]."\">";
        }
		else if ($str == "<?php" || $str == "?>") {
		}
        else {
             echo "<input type=\"hidden\" name=\"inputs[]\" value=\"".htmlspecialchars($str)."\">";
        }
   }
   $i++;
}
fclose($fp);
?>
<tr>
        <td colspan="3" align="right"><input type="submit" name="save" value="Save"></td>
</tr>
</table>
</td></tr></table>
</form>
<?php
}
else if ($todo == "editlng") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
       ?>
            <script language="Javascript">
       <!--
       function err_pop(title,content) {
            mywindow = open('','error_popup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=300,left=0,top=0,screenX=0,screenY=0');
            mywindow.document.write('<html><style type="text/css" title=""><!--');
            mywindow.document.write('A:LINK, A:VISITED {	color : #0000FF; font-family : arial; text-decoration : none; font-weight : normal; font-size : 12px;}');
            mywindow.document.write('A:HOVER {	color : #FF0000; font-family : arial; text-decoration : underline; font-weight : normal;	font-size : 12px;}');
            mywindow.document.write('//-->');
            mywindow.document.write('</style><body bgcolor="#EFEFEF">');
            mywindow.document.write('<table width="100%" cellpadding="0" cellspacing="0" border="0">');
            mywindow.document.write('<tr><td><hr></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;&nbsp;<b>'+title+'</b></td></tr>');
            mywindow.document.write('<tr><td><hr></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('<tr><td><font style="font-size:12px;" nowrap>'+content+'</font></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('<tr><td align="right" valign="middle"><a href="javascript: ;" onClick="window.close();" style="color: #FF0000; text-decoration:none; font-weight: bold; font-size:12px; background: #FFFFFF; border: 1px solid #000000;">&nbsp;x&nbsp;</a>&nbsp;<a href="javascript: window.close();">Close Window</a></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('</table>');
            mywindow.document.write('</body></html>');
       }
       //-->
       </script>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?php echo urldecode($folders);?> language files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_FILE_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_FILE;?>:</b></font></td>
               </tr>
               <tr><td colspan="2">
                <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <th>#</th>
                    <th align="left">File</th>
                    <th align="center">Permission</th>
                    <th align="center">Action</th>
                </tr>
                <tr>
                    <td colspan="4"><hr size="1" color="#000000"></td>
                </tr>
               <?php
                     $n=1;
                     if (file_exists(DIR_LANGUAGES.$folders.".php")) {
                     $perms_error=false;
                     ?>
                           <tr>
                                   <td><b><u><?php echo $n;?></u>.</b></td>
                                   <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>">
                                   <input type="hidden" name="todo" value="editfile">
                                   <input type="hidden" name="editfile" value="<?php echo $folders.".php";?>">
                                   <input type="hidden" name="lng" value="<?php echo $folders;?>">
                                   <input type="hidden" name="type" value="main">
                                   <td><b><?php echo $folders.".php";?></b></td>
                                   <td align="center"><b><?php 
                                   $perms=substr(base_convert(@fileperms(DIR_LANGUAGES.$folders.".php"), 10, 8),3);
                                   echo $perms;
                                   if ($perms==666 || $perms==777) {
                                       echo " - OK";
                                       $perms_error=false;
                                   }
                                   else {
                                       $title="File Permission Error - ".$folders.".php";
                                       $content="<font color=red><b>The permission for this file is invalid.<br>Valid permission for the file is: <b>777</b>.</font><br> The changes to the file will not be saved properly(will be lost)!<br>Please change the file permission for ".DIR_LANGUAGES.$folders.".php"." to 777.";
                                       $perms_error=true;
                                       ?>
                                                                     <font color="#FF0000" size="2"><b>ERROR</b>...<a href="javascript: ;" onClick="err_pop('<?php echo $title;?>','<?php echo eregi_replace("'","\'",$content);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></font>
                                                              <?php                  
                                   }
                                   ?></b></td>
                                   <td align="center"><input type="submit" name="edit" value="Edit File"<?php if($perms_error){ echo " onClick=\"return confirm('Invalid File Permission (".$perms.") for ".eregi_replace("'","\'",$folders.".php")."\\nChanges will not be saved!\\nClick on Ok if you still want to continue, Cancel otherwise!');\"";}?>></td>
                                   </form>
                            </tr>
                     <?php
                     $n++;
                     }
                     $dirs = getFiles(DIR_LANGUAGES.$folders);
                     sort($dirs);
                     for ($i=0; $i<count($dirs); $i++) {
                             if ($dirs[$i]!="index.html" && $dirs[$i]!="index.htm") {
                                 $perms_error=false;
                                 ?>
                                <tr>
                                       <td><b><u><?php echo $n;?></u>.</b></td>
                                       <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>">
                                       <input type="hidden" name="todo" value="editfile">
                                       <input type="hidden" name="editfile" value="<?php echo $folders."/".$dirs[$i];?>">
                                       <input type="hidden" name="lng" value="<?php echo $folders;?>">
                                       <td><b><?php echo $dirs[$i];?></b></td>
                                       <td align="center"><b><?php 
                                   $perms=substr(base_convert(@fileperms(DIR_LANGUAGES.$folders."/".$dirs[$i]), 10, 8),3);
                                   echo $perms;
                                   if ($perms==666 || $perms==777) {
                                       echo " - OK";
                                       $perms_error=false;
                                   }
                                   else {
                                       $title="File Permission Error - ".$dirs[$i];
                                       $content="<font color=red><b>The permission for this file is invalid.<br>Valid permission for the file is: <b>777</b>.</font><br> The changes to the file will not be saved properly(will be lost)!<br>Please change the file permission for ".DIR_LANGUAGES.$folders."/".$dirs[$i]." to 777.";
                                       $perms_error=true;
                                       ?>
                                                                     <font color="#FF0000" size="2"><b>ERROR</b>...<a href="javascript: ;" onClick="err_pop('<?php echo $title;?>','<?php echo eregi_replace("'","\'",$content);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></font>
                                                              <?php                  
                                   }
                                   ?></b></td>
                                       <td align="center"><input type="submit" name="edit" value="Edit File"<?php if($perms_error){ echo " onClick=\"return confirm('Invalid File Permission (".$perms.") for ".eregi_replace("'","\'",$dirs[$i])."\\nChanges will not be saved!\\nClick on Ok if you still want to continue, Cancel otherwise!');\"";}?>></td>
                                       </form>
                                </tr> 
                             <?php
                             $n++;
                             }
                     }
                 ?>
                 <tr>
                    <td colspan="4"><hr size="1" color="#000000"></td>
                </tr>
               </table>
               </td>
               </tr>
               <tr>
                   <td valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_UPLOAD_LANGUAGE_FLAG;?></b></font><br><font face="Verdana" size="1" color="#000000"><?php echo TEXT_UPLOAD_LANGUAGE_FLAG_NOTE;?></font></td>
               </tr>
               <?php
               if ( (file_exists(DIR_FLAG.$folders.".gif")) || (file_exists(DIR_FLAG.$folders.".jpg")) || (file_exists(DIR_FLAG.$folders.".png"))) {
               ?>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?php echo TEXT_FLAG_INFORMATION;?>:</font></td>
               </tr>
               <?php
               if (file_exists(DIR_FLAG.$folders.".gif")) {
                   $imgsize = getimagesize(DIR_FLAG.$folders.".gif");
                   $imgname = $folders.".gif";
                   $imgmodtime = filemtime (DIR_FLAG.$folders.".gif");
               }
               if (file_exists(DIR_FLAG.$folders.".jpg")) {
                   $imgsize = getimagesize(DIR_FLAG.$folders.".jpg");
                   $imgname = $folders.".jpg";
                   $imgmodtime = filemtime (DIR_FLAG.$folders.".jpg");
               }
               if (file_exists(DIR_FLAG.$folders.".png")) {
                   $imgsize = getimagesize(DIR_FLAG.$folders.".png");
                   $imgname = $folders.".png";
                   $imgmodtime = filemtime (DIR_FLAG.$folders.".jpg");
               }
               $lastmodtime = date("d.m.Y - H:i:s", $imgmodtime);
               ?>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?php echo TEXT_FLAG_FILE_NAME;?>: <?php echo $imgname;?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?php echo TEXT_FLAG_FILE_SIZE;?>: <?php echo $imgsize[0]."x".$imgsize[1];?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?php echo TEXT_FLAG_FILE_PREVIEW;?>: <?php echo bx_image(HTTP_FLAG.$imgname,0,'');?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?php echo TEXT_FLAG_FILE_LAST_MODIFIED;?>: <?php echo $lastmodtime;?></font></td>
               </tr>
               <?php
               }
               ?>
               <form method="post" enctype="multipart/form-data" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>" name="upload">
               <input type="hidden" name="todo" value="upload">
               <input type="hidden" name="lng" value="<?php echo $folders;?>">
               <?php
               if (fileperms(DIR_FLAG) != 16895) {
               ?>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#FF0000">You must set the directory <i><?php echo DIR_FLAG;?></i> to all writeable (chmod 777).</font></td>
               </tr>
               <?php
               }
               ?>
               <tr>
                       <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_UPLOAD_FLAG_FILE;?>:</b></font>  <input type="file" name="flag_file"></td>
               </tr>
               <tr>
                       <td align="center"><input type="submit" name="save" value="Upload"></td>
               </tr>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editlng")
else if ($todo == "editimg") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?php echo $folders;?> language files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_IMAGE_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_IMAGE;?>:</b></font></td>
               </tr>
               <?php
                     $dirs = getFiles(DIR_IMAGES.$folders);
                     sort($dirs);
                     for ($i=0; $i<count($dirs); $i++) {
                               if ($dirs[$i]!="index.html" && $dirs[$i]!="index.htm") {
                                   echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"uploadimg\"><input type=\"hidden\" name=\"replacefile\" value=\"".$folders."/".$dirs[$i]."\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\">";
                                   //echo "<tr><td align=\"right\"><b>".$dirs[$i]."</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
                                   $imgsize = getimagesize(DIR_IMAGES.$folders."/".$dirs[$i]);
                                   $imgmodtime = filemtime(DIR_IMAGES.$folders."/".$dirs[$i]);
                                   $lastmodtime = date("d.m.Y - H:i:s", $imgmodtime);
                                   echo "<tr>";
                                        echo "<td width=\"50%\">".bx_image(HTTP_IMAGES.$folders."/".$dirs[$i],0,'')."</td>";
                                        echo "<td><font face=\"Verdana\" size=\"1\" color=\"#000000\">Name: <b>".$dirs[$i]."</b></font>";
                                        echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Size: ".$imgsize[0]."x".$imgsize[1]."</font>";
                                        echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Modified: ".$lastmodtime."</font>";
                                        echo "</td>";
    
                                   echo "</tr>";
                                   echo "<tr><td colspan=\"2\"><input type=\"file\" name=\"replace_file\">  <input type=\"submit\" name=\"replace\" value=\"Upload/Replace\"></td></tr></form>";
                               }    
                     }
                ?>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editimg")
else if ($todo == "editoptions") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?php echo $folders;?> language options</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_OPTIONS_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_POSTING_OPTIONS;?>:</b></font></td>
               </tr>
               <?php
               $i=1;
               while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savepostlang\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"postlangid\" value=\"".$i."\"><input type=\"text\" name=\"postlang\" value=\"".${TEXT_LANGUAGE_KNOWN_OPT.$i}."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"delpostlang\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"postlangid\" value=\"".$i."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_POSTLANG_DELETE."');\"></td></tr></form>";
                    $i++;
               }
               echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savepostlang\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"postlangid\" value=\"0\"><input type=\"text\" name=\"postlang\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_DEGREE_OPTIONS;?>:</b></font></td>
               </tr>
               <?php
               $i=1;
               while (${TEXT_DEGREE_OPT.$i}) {
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savedegree\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"degreeid\" value=\"".$i."\"><input type=\"text\" name=\"degree\" value=\"".${TEXT_DEGREE_OPT.$i}."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"deldegree\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"degreeid\" value=\"".$i."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_DEGREE_DELETE."');\"></td></tr></form>";
                    $i++;
               }
               echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savedegree\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"degreeid\" value=\"0\"><input type=\"text\" name=\"degree\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
               ?>
                <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_CCTYPE_OPTIONS;?>:</b></font></td>
               </tr>
               <?php
               $i=1;
               while (${TEXT_CCTYPE_OPT.$i}) {
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savecctype\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"cctypeid\" value=\"".$i."\"><input type=\"text\" name=\"cctype\" value=\"".${TEXT_CCTYPE_OPT.$i}."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"delcctype\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"cctypeid\" value=\"".$i."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_CCTYPE_DELETE."');\"></td></tr></form>";
                    $i++;
               }
               echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savecctype\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"cctypeid\" value=\"0\"><input type=\"text\" name=\"cctype\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_JOBMAIL_OPTIONS;?>:</b></font></td>
               </tr>
               <?php
               $i=1;  
               while (${TEXT_JOBMAIL_OPT.$i}) {
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savejobmail\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jobmailid\" value=\"".$i."\"><input type=\"text\" name=\"jobmail\" value=\"".${TEXT_JOBMAIL_OPT.$i}."\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                    $i++;
               }
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_PAYMENT_OPTIONS;?>:</b></font></td>
               </tr>
               <?php
               $i=1;  
               while (${TEXT_PAYMENT_OPT.$i}) {
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savepayment\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"paymentid\" value=\"".$i."\"><input type=\"text\" name=\"payment\" value=\"".${TEXT_PAYMENT_OPT.$i}."\" size=\"".(strlen(${TEXT_PAYMENT_OPT.$i})+5)."\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                    $i++;
               }
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_CHARSET_OPTIONS;?>:</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3" nowrap><font class="text"><?php echo TEXT_SELECT_EDIT_CHARSET_NOTE;?></font></td>
               </tr>
               <?php
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savecharset\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"text\" name=\"charset\" value=\"".$CHARSET_OPTION."\" size=\"".(strlen($CHARSET_OPTION)+5)."\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_DATE_FORMAT;?>:</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3" nowrap><font class="text"><?php echo TEXT_SELECT_EDIT_DATE_NOTE;?></font></td>
               </tr>
               <?php
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savedformat\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"text\" name=\"dformat\" value=\"".$DATE_FORMAT."\" size=\"".(strlen($DATE_FORMAT)+5)."\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
               ?>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_PRICE_FORMAT;?>:</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3" nowrap><font class="text"><?php echo TEXT_SELECT_EDIT_PRICE_NOTE;?></font></td>
               </tr>
               <?php
                    echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savepformat\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"text\" name=\"pformat\" value=\"".$PRICE_FORMAT."\" size=\"".(strlen($PRICE_FORMAT)+5)."\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
               ?>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editoptions")
else if ($todo == "editcateg") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit Job Category for <?php echo $folders;?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_JOBCATEG_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_JOBCATEG;?>:</b></font></td>
               </tr>
               <?php
                     $categ_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobcategories_".$folder_table_lang);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\" style=\"margin-top: 0px; margin-bottom: 0px;\"><input type=\"hidden\" name=\"todo\" value=\"savecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jobcategoryid\" value=\"".$categ_result['jobcategoryid']."\"><input type=\"text\" name=\"jobcategory\" value=\"".bx_js_stripslashes($categ_result['jobcategory'])."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\" style=\"margin-top: 0px; margin-bottom: 0px;\"><input type=\"hidden\" name=\"todo\" value=\"delcateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"jobcategoryid\" value=\"".$categ_result['jobcategoryid']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBTYPE_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jobcategoryid\" value=\"0\"><input type=\"text\" name=\"jobcategory\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               <tr>
                   <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>"><input type="hidden" name="todo" value="ordercateg"><input type="hidden" name="lng" value="<?php echo $folders;?>"><td valign="top" colspan="3">Click here to order Jobcategories Alphabetically:&nbsp;&nbsp;&nbsp;<input type="submit" name="edit" value="  Order  "></td></form>
                </tr>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
                </tr>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Quick Job Categories Edit:</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Every Job Category should be positioned on a single line!</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Like in the example below:</b></font><b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JobCategory1<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jobcategory2<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JobCategory3<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etc..</b></td>
               </tr>
               <tr>
                   <td colspan="3"><font color="#FF0000"><b>Very Important:</b> Every order change or delete or addition will be reflected also in the other languages available. If you want to translate the jobcategories without changing the order please check the "Translate Mode" below.</td>
               </tr>
               <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>" name="savebulk">
               <input type="hidden" name="todo" value="savebulkcateg">
               <input type="hidden" name="lng" value="<?php echo $folders;?>">
                <tr>
                   <td width="100%" align="center" colspan="3"><table width="100%" cellpadding="0" cellspacing="2" border="0" align="center"><tr>
                   <td valign="top" width="30%">&nbsp;&nbsp;<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>JobCategory List:</b></font></td>
                   <td valign="top" width="70%" align="left" colspan="2"><textarea name="jobcategoryids" rows="20" cols="50"><?php
                     $categ_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobcategories_".$folder_table_lang);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $row=0;
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                             if($row!=0) {
                                 echo "\n";
                             }
                             echo $categ_result['jobcategory'];
                             $row++;
                     }
                ?></textarea></td></tr>
               <tr>
                   <td>&nbsp;</td>
                   <td><input type="checkbox" name="translate" value="yes" class="radio"<?php echo ($folders==DEFAULT_LANGUAGE)?"":" checked";?>>&nbsp;<b>Translating Mode</b></td>
               </tr>
                </table></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3" align="center">&nbsp;<input type="submit" name="go" value="Update" onClick="if(!document.savebulk.translate.checked){ return confirm('IMPORTANT!!!\nYou are NOT in Translate Mode\n All the changes you have made will be reflected in all the languages available!\nAre you sure you want this?');}"></td>
               </tr>
               </form>
               <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editcateg")
else if ($todo == "editlocation") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit Job Locations for <?php echo $folders;?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_LOCATION_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_LOCATION;?>:</b></font></td>
               </tr>
               <?php
                     $location_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_locations_".$folder_table_lang);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($location_result=bx_db_fetch_array($location_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<tr><td align=\"right\" width=\"70%\"><form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\" style=\"margin-top: 0px; margin-bottom: 0px;\"><input type=\"hidden\" name=\"todo\" value=\"savelocation\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><input type=\"hidden\" name=\"locationid\" value=\"".$location_result['locationid']."\"><input type=\"text\" name=\"location\" value=\"".bx_js_stripslashes($location_result['location'])."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></form></td>";
                            echo "<td align=\"left\"><form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\" style=\"margin-top: 0px; margin-bottom: 0px;\"><input type=\"hidden\" name=\"todo\" value=\"dellocation\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><input type=\"hidden\" name=\"locationid\" value=\"".$location_result['locationid']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBLOCATION_DELETE."');\"></form></td></tr>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savelocation\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"locationid\" value=\"0\"><input type=\"text\" name=\"location\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               <tr>
                   <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>"><input type="hidden" name="todo" value="orderloc"><input type="hidden" name="lng" value="<?php echo $folders;?>"><td valign="top" colspan="3">Click here to order Job Locations Alphabetically:&nbsp;&nbsp;&nbsp;<input type="submit" name="edit" value="  Order  "></td></form>
               </tr>
               <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Quick Job Locations Edit:</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Every Job Location should be positioned on a single line!</b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Like in the example below:</b></font><b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location1<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location2<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location3<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etc..</b></td>
               </tr>
               <tr>
                   <td colspan="3"><font color="#FF0000"><b>Very Important:</b> Every order change or delete or addition will be reflected also in the other languages available. If you want to translate the locations without changing the order please check the "Translate Mode" below.</td>
               </tr>
               <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>" name="savebulk">
               <input type="hidden" name="todo" value="savebulklocation">
               <input type="hidden" name="lng" value="<?php echo $folders;?>">
                <tr>
                   <td width="100%" align="center" colspan="3"><table width="100%" cellpadding="0" cellspacing="2" border="0" align="center"><tr>
                   <td valign="top" width="30%">&nbsp;&nbsp;<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Location List:</b></font></td>
                   <td valign="top" width="70%" align="left" colspan="2"><textarea name="locationids" rows="20" cols="50"><?php
                     $location_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_locations_".$folder_table_lang);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $row=0;
                     while ($location_result=bx_db_fetch_array($location_query)) {
                             if($row!=0) {
                                 echo "\n";
                             }
                             echo $location_result['location'];
                             $row++;
                     }
                ?></textarea></td></tr>
                <tr>
                   <td>&nbsp;</td>
                   <td><input type="checkbox" name="translate" value="yes" class="radio"<?php echo ($folders==DEFAULT_LANGUAGE)?"":" checked";?>>&nbsp;<b>Translating Mode</b></td>
               </tr>
                </table></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3" align="center">&nbsp;<input type="submit" name="go" value="Update" onClick="if(!document.savebulk.translate.checked){ return confirm('IMPORTANT!!!\nYou are NOT in Translate Mode\n All the changes you have made will be reflected in all the languages available!\nAre you sure you want this?');}"></td>
               </tr>
               </form>
               <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editlocation")
else if ($todo == "edittypes") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?php echo $folders;?> language files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="3"><?php header_nav($todo, $folders);?></td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_TYPE_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_TYPE;?>:</b></font></td>
               </tr>
               <?php
                     $type_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_jobtypes_".$folder_table_lang);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($type_result=bx_db_fetch_array($type_query)) {
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savetypes\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jobtypeid\" value=\"".$type_result['jobtypeid']."\"><input type=\"text\" name=\"jobtype\" size=\"30\" value=\"".bx_js_stripslashes($type_result['jobtype'])."\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"deltypes\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"jobtypeid\" value=\"".$type_result['jobtypeid']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBTYPE_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."\"><input type=\"hidden\" name=\"todo\" value=\"savetypes\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jobtypeid\" value=\"0\"><input type=\"text\" size=\"30\" name=\"jobtype\" value=\"\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "edittypes")
else {
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>" name="editlng" onSubmit="return check_form_editlng();">
<input type="hidden" name="todo" value="editlng">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top" width="70%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE;?>:</b></font></td><td valign="top">
<?php
  $dirs = getFolders(DIR_LANGUAGES);
  if(count($dirs) == 1) {
          refresh(HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE."?todo=editlng&folders=".$dirs[0]);
  }
  for ($i=0; $i<count($dirs); $i++) {
       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
              echo "<input type=\"radio\" name=\"folders\" value=\"".$dirs[$i]."\" class=\"radio\">".$dirs[$i]."<br>";
       }
  }
?>
</td></tr>
<tr>
        <td colspan="2" align="center"><br><input type="submit" name="edit" value="Edit Language"></td>
</tr>
</table>

</td></tr></table>
</form>
<?php
}
?>