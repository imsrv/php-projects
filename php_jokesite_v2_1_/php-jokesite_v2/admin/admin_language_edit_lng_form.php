<?

define('TEXT_FONT_COLOR', '#FF0000');
define('TEXT_FONT_SIZE', '2');
define('TEXT_FONT_FACE', 'verdana');
define('TEXT_CONFIRM_JOBTYPE_DELETE', 'Do you want to delete this entries?');
if($todo == "editcateg_censor" || $todo == "dellocation" || $todo == "savelocation") {
    $bx_db_table_locations = eregi_replace("_".substr($language,0,3)."$","",$bx_db_table_locations);
}

$work_lng = "_".substr($HTTP_POST_VARS['lng'],0,3);

$todo = $HTTP_POST_VARS['todo'] ? $HTTP_POST_VARS['todo'] : $HTTP_GET_VARS['todo'];
$folders = $HTTP_POST_VARS['folders'] ? $HTTP_POST_VARS['folders'] : $HTTP_GET_VARS['folders'];


$error_title = "editing language";
if ($todo == "upload") {
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
         $flag_location = DIR_FLAG.$HTTP_POST_VARS['lng'].$flag_extension;
         if (file_exists($flag_location)) {
                @unlink($flag_location);
         }//end if (file_exists($flag_location))
         if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".gif")) {
                @unlink(DIR_FLAG.$HTTP_POST_VARS['lng'].".gif");
         }//end if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".gif"))
         if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".jpg")) {
                @unlink(DIR_FLAG.$HTTP_POST_VARS['lng'].".jpg");
         }//end if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".jpg"))
         if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".png")) {
                @unlink(DIR_FLAG.$HTTP_POST_VARS['lng'].".png");
         }//end if (file_exists(DIR_FLAG.$HTTP_POST_VARS['lng'].".png"))
          if (move_uploaded_file($HTTP_POST_FILES['flag_file']['tmp_name'], $flag_location)) {
                     @chmod($flag_location, 0777);
         ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editlng">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
         }
         else {
             bx_error("Language flag picture file upload fail.");
         }
     }
     else {
            bx_error("Language flag picture file upload fail.");
     }
}
if ($todo == "uploadimg") {
		   if(!empty($HTTP_POST_FILES['replace_file']['tmp_name']) && $HTTP_POST_FILES['replace_file']['tmp_name'] != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($HTTP_POST_FILES['replace_file']['tmp_name'])) && (in_array($HTTP_POST_FILES['replace_file']['type'],array ("image/gif","image/pjpeg","image/jpeg","image/x-png"))))
             {
                $replace_size=getimagesize($HTTP_POST_FILES['replace_file']['tmp_name']);
                        $replace_location = DIR_LANGUAGES.$HTTP_POST_VARS['replacefile'];
                if (file_exists($replace_location)) {
                        @unlink($replace_location);
                }//end if (file_exists($flag_location))
                if (move_uploaded_file($HTTP_POST_FILES['replace_file']['tmp_name'], $replace_location)) {
                    @chmod($replace_location, 0777);
                ?>
                 <script language="Javascript"><!--
                    document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?ref=".time()?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editimg">');
                    document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
                    document.write('</form>');
                    document.redirect.submit();
                    //-->
                  </script>
                 <?
                 }
         else {
             bx_error("Language image file upload fail.");
         }
     }
     else {
            bx_error("Language image file upload fail.");
     }
}
//function to write the language file
function write_language_file($type) {
global $lng, $todo, $postlangid, $postlang, $degreeid, $degree, $jobmailid, $jobmail, $paymentid, $payment, $HTTP_POST_VARS;  
include(DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php");
$newlangfile = array();
$langfile=file(DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php");
    if ($type == "postlang") {
        if ($todo =="savepostlang") {
            if ($postlangid == "0") {
                $i=1;
                while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
                {
                     $i++;
                }
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".($i-1),$langfile[$j],$regs)) {
                        $newlangfile[] = $langfile[$j];
                        $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$i."='".$postlang."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }
            }//end if postlang == "0"
            else {
                for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$postlangid,$langfile[$j],$regs)) {
                        $newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$postlangid."='".$postlang."';\n";
                    }
                    else {
                        $newlangfile[] = $langfile[$j];
                    }
                }//end for
            }//end else if postlang == "0"
        }
        else if ($todo =="delpostlang") {
            for ($j=0;$j<sizeof($langfile);$j++) {
                    if (eregi("TEXT_LANGUAGE_KNOWN_OPT".$postlangid,$langfile[$j],$regs)) {
                        //$newlangfile[] = "\$TEXT_LANGUAGE_KNOWN_OPT".$postlangid."='".$postlang."';\n";
                    }
                    else {
                        if (eregi("TEXT_LANGUAGE_KNOWN_OPT(.*)=(.*)",$langfile[$j],$regsw)) {
                            if ($regsw[1]>$postlangid) {
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
    $fp = fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php", "w");
    for ($j=0;$j<sizeof($newlangfile);$j++) {
          fwrite($fp, $newlangfile[$j]);
    }
    fclose($fp);
}
//end function write_language_file
if ($todo == "savepostlang") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
           if ($postlangid == "0") { //when we are adding a jobtype
                if (empty($postlang)) {
                     bx_error("Invalid Posting language! Please enter a Posting language to add.");
                }
                else {
                     write_language_file("postlang");
                     $ready = true;
                }
           } //end if ($jobtypeid == "0")
           else {  //else we are updating a jobtype
                if (empty($postlang)) {
                     bx_error("Invalid Posting language! Please enter a Posting language to add.");
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
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_newsletter">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
          </script>
         <?
         }
     }
}
if ($todo == "delpostlang") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
            write_language_file("postlang");
            $ready = true;
     } //end else if ($jobtypeid == "0")
      if ($ready) {
        ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_newsletter">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
      }
}


if ($todo == "savejokecateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
           if ($HTTP_POST_VARS['jokecategoryid'] == "0") { //when we are adding a jokecategory
                if (empty($HTTP_POST_VARS['jokecategory'])) {
                     bx_error("Invalid jokecategory! Please enter a jokecategory to add.");
                }
                else {

			$SQL = "select * from $bx_db_table_joke_categories";
			$query = bx_db_query($SQL);
			$nr_table_fields = mysql_num_fields($query);
			
			for ($i = 0; $i < $nr_table_fields ; $i++ )
			{
				if(ereg(".*category_name.*", mysql_field_name($query, $i),$reg))
				{
					$key .= mysql_field_name($query, $i).",";
					$val .= "'".$HTTP_POST_VARS['jokecategory']."'".",";
				}
			}
			$key = substr($key,0,-1);
			$val = substr($val, 0, -1);
			bx_db_insert($bx_db_table_joke_categories ,$key, $val);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	                $ready = true;
                }
           } //end if ($HTTP_POST_VARS['jokecategoryid'] == "0")
           else {  //else we are updating a jokecategory
                if (empty($HTTP_POST_VARS['jokecategory'])) {
                     bx_error("Invalid jokecategory! Please enter a jokecategory to update.");
                }
                else {
                     $SQL = "UPDATE $bx_db_table_joke_categories set category_name_".substr($HTTP_POST_VARS['lng'],0,3)."='".$HTTP_POST_VARS['jokecategory']."' where category_id = '".$HTTP_POST_VARS['jokecategoryid']."'";
		     bx_db_query($SQL);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $ready = true;
                }
           } //end else if ($jobtypeid == "0")
           if ($ready) {
        ?>
         <script language="Javascript">
         <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_joke">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
          </script>
         <?
         }
     }
}

if ($todo == "deljokecateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
            bx_db_query("DELETE FROM $bx_db_table_joke_categories where category_id = '".$HTTP_POST_VARS['jokecategoryid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $ready = true;
     } //end else if ($jobtypeid == "0")
      if ($ready) {
        ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_joke">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
      }
}





if ($todo == "savecensorcateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {

           if ($HTTP_POST_VARS['censorcategoryid'] == "0") { //when we are adding a censorcategory
                if (empty($HTTP_POST_VARS['censorcategory'])) {
                     bx_error("Invalid censorcategory! Please enter a censorcategory to add.");
                }
                else {

			$SQL = "select * from $bx_db_table_censor_categories";
			$query = bx_db_query($SQL);
			$nr_table_fields = mysql_num_fields($query);
			
			for ($i = 0; $i < $nr_table_fields ; $i++ )
			{
				if(ereg(".*category_name.*", mysql_field_name($query, $i),$reg))
				{
					$key .= mysql_field_name($query, $i).",";
					$val .= "'".$HTTP_POST_VARS['censorcategory']."'".",";
				}
			}
			$key = substr($key,0,-1);
			$val = substr($val, 0, -1);
			bx_db_insert($bx_db_table_censor_categories ,$key, $val);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	                $ready = true;
                }
           } //end if ($HTTP_POST_VARS['censorcategoryid'] == "0")
           else {  //else we are updating a censorcategory
                if (empty($HTTP_POST_VARS['censorcategory'])) {
                     bx_error("Invalid censorcategory! Please enter a censorcategory to update.");
                }
                else {
                     $SQL = "UPDATE $bx_db_table_censor_categories set censor_category_name_".substr($HTTP_POST_VARS['lng'],0,3)."='".$HTTP_POST_VARS['censorcategory']."' where censor_category_id = '".$HTTP_POST_VARS['censorcategoryid']."'";
		     bx_db_query($SQL);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $ready = true;
                }
           } //end else if ($jobtypeid == "0")
           if ($ready) {
        ?>
         <script language="Javascript">
         <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_censor">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
          </script>
         <?
         }
     }
}

if ($todo == "delcensorcateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
            bx_db_query("DELETE FROM $bx_db_table_censor_categories where censor_category_id = '".$HTTP_POST_VARS['censorcategoryid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $ready = true;
     } //end else if ($jobtypeid == "0")
      if ($ready) {
        ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_censor">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
      }
}



if ($todo == "savenewslettercateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {

           if ($HTTP_POST_VARS['newslettercategoryid'] == "0") { //when we are adding a newslettercategory
                if (empty($HTTP_POST_VARS['newslettercategory'])) {
                     bx_error("Invalid newslettercategory! Please enter a newslettercategory to add.");
                }
                else {

			$SQL = "select * from $bx_db_table_newsletter_categories";
			$query = bx_db_query($SQL);
			$nr_table_fields = mysql_num_fields($query);
			
			for ($i = 0; $i < $nr_table_fields ; $i++ )
			{
				if(ereg(".*category_name.*", mysql_field_name($query, $i),$reg))
				{
					$key .= mysql_field_name($query, $i).",";
					$val .= "'".$HTTP_POST_VARS['newslettercategory']."'".",";
				}
			}
			$key = substr($key,0,-1);
			$val = substr($val, 0, -1);
			bx_db_insert($bx_db_table_newsletter_categories ,$key, $val);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	                $ready = true;
                }
           } //end if ($HTTP_POST_VARS['newslettercategoryid'] == "0")
           else {  //else we are updating a newslettercategory
                if (empty($HTTP_POST_VARS['newslettercategory'])) {
                     bx_error("Invalid newslettercategory! Please enter a newslettercategory to update.");
                }
                else {
                     $SQL = "UPDATE $bx_db_table_newsletter_categories set newsletter_category_name_".substr($HTTP_POST_VARS['lng'],0,3)."='".$HTTP_POST_VARS['newslettercategory']."' where newsletter_category_id = '".$HTTP_POST_VARS['newslettercategoryid']."'";
		     bx_db_query($SQL);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $ready = true;
                }
           } //end else if ($jobtypeid == "0")
           if ($ready) {
        ?>
         <script language="Javascript">
         <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_newsletter">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
          </script>
         <?
         }
     }
}

if ($todo == "delnewslettercateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
            bx_db_query("DELETE FROM $bx_db_table_newsletter_categories where newsletter_category_id = '".$HTTP_POST_VARS['newslettercategoryid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $ready = true;
     } //end else if ($jobtypeid == "0")
      if ($ready) {
        ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_newsletter">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
      }
}



if ($todo == "saveimagecateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
           if ($HTTP_POST_VARS['imagecategoryid'] == "0") { //when we are adding a jokecategory
                if (empty($HTTP_POST_VARS['imagecategory'])) {
                     bx_error("Invalid imagecategory! Please enter an imagecategory to add.");
                }
                else {

			$SQL = "select * from $bx_db_table_image_categories";
			$query = bx_db_query($SQL);
			$nr_table_fields = mysql_num_fields($query);
			
			for ($i = 0; $i < $nr_table_fields ; $i++ )
			{
				if(ereg(".*category_name.*", mysql_field_name($query, $i),$reg))
				{
					$key .= mysql_field_name($query, $i).",";
					$val .= "'".$HTTP_POST_VARS['imagecategory']."'".",";
				}
			}
			$key = substr($key,0,-1);
			$val = substr($val, 0, -1);
			bx_db_insert($bx_db_table_image_categories ,$key, $val);
			SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	                $ready = true;
                }
           } //end if ($HTTP_POST_VARS['jokecategoryid'] == "0")
           else {  //else we are updating a jokecategory
                if (empty($HTTP_POST_VARS['imagecategory'])) {
                     bx_error("Invalid imagecategory! Please enter an imagecategory to update.");
                }
                else {
                     $SQL = "UPDATE $bx_db_table_image_categories set category_name_".substr($HTTP_POST_VARS['lng'],0,3)."='".$HTTP_POST_VARS['imagecategory']."' where category_id = '".$HTTP_POST_VARS['imagecategoryid']."'";
		     bx_db_query($SQL);
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $ready = true;
                }
           } //end else if ($jobtypeid == "0")
           if ($ready) {
        ?>
         <script language="Javascript">
         <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_image">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
          </script>
         <?
         }
     }
}

if ($todo == "delimagecateg") {
     $ready = false;
     if (empty($HTTP_POST_VARS['lng'])) {
            bx_error("Please select a language to edit.");
     }
     else {
            bx_db_query("DELETE FROM $bx_db_table_image_categories where category_id = '".$HTTP_POST_VARS['imagecategoryid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            $ready = true;
     } //end else if ($jobtypeid == "0")
      if ($ready) {
        ?>
         <script language="Javascript">
            <!--
            document.write('<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editcateg_image">');
            document.write('<input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">');
            document.write('</form>');
            document.redirect.submit();
            //-->
         </script>
         <?
      }
}
else if ($todo == "savefile") {
    $towrite = '';
 	for ($i=0;$i<count($HTTP_POST_VARS['inputs']) ;$i++ ) {
		if ($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]) {
			$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
			if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) {
				$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
				$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'[\.]", "'.", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
				$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("[\.]\\\\'", ".'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
			}
                                       $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\015\012|\015|\012", ' ', trim($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]));
                                       $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]."');\n";
		}
		else {
			if ( is_string($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]])) {
				$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
				if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) 	{
					$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
					}
                                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\015\012|\015|\012", ' ', trim($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]));
                                        $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]."');\n";
			}
			else {
				$towrite .= "".stripslashes(trim($HTTP_POST_VARS['inputs'][$i]))."\n";
			}
		}
	}
	$fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'],"w");
             fwrite($fp,"<?\n");
	fwrite($fp, eregi_replace("\n$","",$towrite));
	fwrite($fp,"\n?>");
             fclose($fp);
             @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['filename'], 0777);
    ?>
     <table width="100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
          <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language file</b></font></td>
      </tr>
      <tr>
         <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Successfull update.</b></font></td>
            </tr>
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><a href="<?=HTTP_SERVER_ADMIN.FILENAME_INDEX?>">Home</a></font></td>
            </tr>
         </table>
         </td>
      </tr>
      </table>
<?
}
else if ($todo == "editfile") {
$fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'],"r");
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="editfile">
<input type="hidden" name="todo" value="savefile">
<input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language file: <?=$HTTP_POST_VARS['editfile']?></b></font></td></tr>
<tr>
   <td bgcolor="<?=TABLE_BORDERCOLOR?>"><TABLE border="0" cellpadding="1" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
   <tr>
       <td><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Base language text:</b></font></td><td><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>New language text:</b></font></td>
   </tr>
<?
$i=1;
while (!feof($fp)) {
   $str=trim(fgets($fp, 20000));
   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
        if (eregi("define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
            echo "<tr>";
            $regexp[2] = eregi_replace("'$", "", $regexp[2]);
			if (strlen(eregi_replace("'","",$regexp[2])) < 30) {
                echo "<td width=\"50%\"><span class=\"editlng\">".eregi_replace("\\\\'","'",$regexp[2])."</span></td><td><input type=\"text\" name=\"".$regexp[1]."\" size=\"40\" value=\"".eregi_replace("\\\\'","'",$regexp[2])."\"></td>";
            }
            else {
                echo "<td width=\"50%\"><span class=\"editlng\">".eregi_replace("\\\\'","'",$regexp[2])."</span></td><td><textarea name=\"".$regexp[1]."\"  rows=\"4\" cols=\"40\">".eregi_replace("\\\\'","'",$regexp[2])."</textarea></td>";
            }
            echo "</tr>";
			echo "<input type=\"hidden\" name=\"inputs[]\" value=\"".$regexp[1]."\">";
        }
		else if ($str == "<?" || $str == "?>") {
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
<?
}
else if ($todo == "editlng") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?=urldecode($folders)?> language files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="2" valign="top"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit joke categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="2" color="#000099"><b>The multilanguage support is build using some language files which are included dynamically in the output forms.
Here you can edit this files and you can see what happens after some changes.
Also please take care about some Javascript error messages which has a "\n" at the end. This means that the next word will begin in a new line. 
Select a language file to edit: 
</b></font></td>
               </tr>
               <?// && DIR_LANGUAGES.$folders.".php" !="admin_form.php" 
                 if (file_exists(DIR_LANGUAGES.$folders.".php")) {
                       echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"editfile\"><input type=\"hidden\" name=\"editfile\" value=\"".$folders.".php\"><tr><td align=\"right\"><b>".$folders.".php</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
                 }
               ?>
               <?
                     $dirs = getFiles(DIR_LANGUAGES.$folders);
					 sort($dirs);
                     for ($i=0; $i<count($dirs); $i++) {
                               echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"editfile\"><input type=\"hidden\" name=\"editfile\" value=\"".$folders."/".$dirs[$i]."\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\"><b>".$dirs[$i]."</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
                    }
                 ?>
               <tr>
                   <td valign="top"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?="Here you can upload a flag picture for this language"?></b></font><br><font face="Verdana" size="1" color="#000000">The flag picture can be a gif, jpeg or png, the size is up to you.</font></td>
               </tr>
               <?
               if ( (file_exists(DIR_FLAG.$folders.".gif")) || (file_exists(DIR_FLAG.$folders.".jpg")) || (file_exists(DIR_FLAG.$folders.".png"))) {
               ?>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?=TEXT_FLAG_INFORMATION?>:</font></td>
               </tr>
               <?
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
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?=TEXT_FLAG_FILE_NAME?>: <?=$imgname?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?=TEXT_FLAG_FILE_SIZE?>: <?=$imgsize[0]."x".$imgsize[1]?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?=TEXT_FLAG_FILE_PREVIEW?>: <?=bx_image(HTTP_FLAG.$imgname,0,'');?></font></td>
               </tr>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#000000"><?=TEXT_FLAG_FILE_LAST_MODIFIED?>: <?=$lastmodtime?></font></td>
               </tr>
               <?
               }
               ?>
               <form method="post" enctype="multipart/form-data" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="upload">
               <input type="hidden" name="todo" value="upload">
               <input type="hidden" name="lng" value="<?=$folders?>">
               <?
               if (fileperms(DIR_FLAG) != 16895) {
               ?>
               <tr>
                   <td valign="top"><font face="Verdana" size="1" color="#FF0000">You must set the directory <i><?=DIR_FLAG?></i> to all writeable (chmod 777).</font></td>
               </tr>
               <?
               }
               ?>
               <tr>
                       <td align="right"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Upload language flag picture file:</b></font>  <input type="file" name="flag_file"></td>
               </tr>
               <tr>
                       <td align="center"><input type="submit" name="save" value="Upload"></td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editlng")
else if ($todo == "editimg") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?=$folders?> language files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="2"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit joke categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_EDIT_LANGUAGE_IMAGE_NOTE?></b></font><br><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_EDIT_LANGUAGE_IMAGE?>:</b></font></td>
               </tr>
               <?
                     $dirs = getFiles(DIR_LANGUAGES.$folders."/images");
                     for ($i=0; $i<count($dirs); $i++) {
                               echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"uploadimg\"><input type=\"hidden\" name=\"replacefile\" value=\"".$folders."/images/".$dirs[$i]."\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\">";
                               //echo "<tr><td align=\"right\"><b>".$dirs[$i]."</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
                               $imgsize = getimagesize(DIR_LANGUAGES.$folders."/images/".$dirs[$i]);
                               $imgmodtime = @filemtime (DIR_FLAG.$folders.".gif");
                               $lastmodtime = date("d.m.Y - H:i:s", $imgmodtime);
                               echo "<tr>";
                                    echo "<td width=\"50%\">".bx_image(HTTP_LANGUAGES.$folders."/images/".$dirs[$i],0,'')."</td>";
                                    echo "<td><font face=\"Verdana\" size=\"1\" color=\"#000000\">Name: <b>".$dirs[$i]."</b></font>";
                                    echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Size: ".$imgsize[0]."x".$imgsize[1]."</font>";
                                    echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Modified: ".$lastmodtime."</font>";
                                    echo "</td>";

                               echo "</tr>";
                               echo "<tr><td colspan=\"2\"><input type=\"file\" name=\"replace_file\">  <input type=\"submit\" name=\"replace\" value=\"Upload/Replace\"></td></tr></form>";
                     }
                ?>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editimg")
else if ($todo == "editcateg_joke") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit joke categories for <?=$folders?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="3"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit joke categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Edit/Add a joke category:</b></font></td>
               </tr>
               <?
                     $categ_query=bx_db_query("SELECT category_id, category_name_".substr($folders,0,3)." as category_name FROM $bx_db_table_joke_categories");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"savejokecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jokecategoryid\" value=\"".$categ_result['category_id']."\"><input type=\"text\" name=\"jokecategory\" value=\"".$categ_result['category_name']."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"deljokecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"jokecategoryid\" value=\"".$categ_result['category_id']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBTYPE_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?folders=".$HTTP_GET_VARS['folders']."\"><input type=\"hidden\" name=\"todo\" value=\"savejokecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"jokecategoryid\" value=\"0\"><input type=\"text\" name=\"jokecategory\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editcateg_joke")
else if ($todo == "editcateg_censor") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit censor categories for <?=$folders?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="3"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Edit/Add a censorcategory:</b></font></td>
               </tr>
               <?
                     $categ_query=bx_db_query("SELECT censor_category_id, censor_category_name_".substr($folders,0,3)." as censor_category_name FROM $bx_db_table_censor_categories");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"savecensorcateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"censorcategoryid\" value=\"".$categ_result['censor_category_id']."\"><input type=\"text\" name=\"censorcategory\" value=\"".$categ_result['censor_category_name']."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"delcensorcateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"censorcategoryid\" value=\"".$categ_result['censor_category_id']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBTYPE_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?folders=".$HTTP_GET_VARS['folders']."\"><input type=\"hidden\" name=\"todo\" value=\"savecensorcateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"censorcategoryid\" value=\"0\"><input type=\"text\" name=\"censorcategory\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editcateg_censor")
else if ($todo == "editcateg_newsletter") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit newsletter categories for <?=$folders?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="3"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Edit newsletter category:</b></font></td>
               </tr>
               <?
                     $categ_query=bx_db_query("SELECT newsletter_category_id, newsletter_category_name_".substr($folders,0,3)." as newsletter_category_name FROM $bx_db_table_newsletter_categories");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"savenewslettercateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"newslettercategoryid\" value=\"".$categ_result['newsletter_category_id']."\"><input type=\"text\" name=\"newslettercategory\" value=\"".$categ_result['newsletter_category_name']."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"delnewslettercateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"newslettercategoryid\" value=\"".$categ_result['newsletter_category_id']."\"></td></tr></form>";

                     }
                     
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editcateg_newsletter")
else if ($todo == "editcateg_image") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit image categories for <?=$folders?> language</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="3"><table width="100%" cellpadding="1" cellspacing="1"><tr>
                                <?
                                 if ($todo == "editlng") {
                                      echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit files</b></font></td>";
                                 }
                                 else {
                                      echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editlng&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit files'; return true;\" onmouseout=\"window.status=''; return true;\">Edit files</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editimg") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit images</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editimg&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit images'; return true;\" onmouseout=\"window.status=''; return true;\">Edit images</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_joke") {
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit joke categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_joke&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit joke categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit joke categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 
				 if ($todo == "editcateg_image") {//editsubcat
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit image categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_image&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit image categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit image categories</a></b></font></td>";
                                 }
				 if ($todo == "editcateg_censor") {//editlocation
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit censor categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_censor&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit censor Categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit censor categories</a></b></font></td>";
                                 }
                                ?>
                                <?
                                 if ($todo == "editcateg_newsletter") {//editoptions
                                     echo "<td align=\"center\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b>Edit newsletter categories</b></font></td>";
                                 }
                                 else {
                                     echo "<td align=\"center\" bgcolor=\"#6699CC\"><font face=".TEXT_FONT_FACE." size=".TEXT_FONT_SIZE." color=".TEXT_FONT_COLOR."><b><A href=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?todo=editcateg_newsletter&folders=".urlencode($folders)."\" style=\"color:#000000; text-decoration:none; font-family: Verdana; font-weight: bold; font-size: 11px;\" onmouseover=\"window.status='Edit newsletter categories'; return true;\" onmouseout=\"window.status=''; return true;\">Edit newsletter categories</a></b></font></td>";
                                 }
                                ?>
                       </tr></table>
                   </td>
               </tr>
               <tr>
                   <td colspan="3"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="3"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Edit/Add an image category:</b></font></td>
               </tr>
               <?
                     $categ_query=bx_db_query("SELECT category_id, category_name_".substr($folders,0,3)." as category_name FROM $bx_db_table_image_categories");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($categ_result=bx_db_fetch_array($categ_query)) {
                            //echo "<tr><td>".$type_result['jobtype']."</td></tr>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"saveimagecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"imagecategoryid\" value=\"".$categ_result['category_id']."\"><input type=\"text\" name=\"imagecategory\" value=\"".$categ_result['category_name']."\" size=\"30\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."\"><input type=\"hidden\" name=\"todo\" value=\"delimagecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><td align=\"left\"><input type=\"hidden\" name=\"imagecategoryid\" value=\"".$categ_result['category_id']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_JOBTYPE_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_language_edit_lng.php"."?folders=".$HTTP_GET_VARS['folders']."\"><input type=\"hidden\" name=\"todo\" value=\"saveimagecateg\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\" width=\"70%\"><input type=\"hidden\" name=\"imagecategoryid\" value=\"0\"><input type=\"text\" name=\"imagecategory\" value=\"\" size=\"30\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                ?>
                <tr>
                   <td valign="top" colspan="3">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editcateg_image")
else if ($todo == "editcateg_censor") {
  
}//end if ($todo == "editcateg_censor")
else if ($todo == "editcateg_image") {//$todo == "editcateg_censor"
   
}//end if ($todo == "editcateg_image")
elseif ($todo=="saveimagecateg" || $todo=="delimagecateg" || $todo=="savejokecateg" || $todo == "deljokecateg" || $todo == "savecharset" || $todo == "editcateg_censor" || $todo == "savepictcat" || $todo == "delpictcat")
{
	
}
else {
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_language_edit_lng.php"?>" name="editlng" onSubmit="return check_form_editlng();">
<input type="hidden" name="todo" value="editlng">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_BORDERCOLOR?>">
<TABLE border="0" cellpadding="1" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top" width="70%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_EDIT_LANGUAGE?>:</b></font></td><td valign="top">
<?
  $dirs = getFolders(DIR_LANGUAGES);
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
<?
}
?>