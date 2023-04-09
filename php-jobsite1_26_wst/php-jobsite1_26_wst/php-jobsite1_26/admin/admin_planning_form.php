<?php
if($HTTP_POST_VARS['lng']) {
    $lng=$HTTP_POST_VARS['lng'];
}
elseif ($HTTP_GET_VARS['lng']){
     $lng = $HTTP_GET_VARS['lng'];
}
else {
    $lng = $language;
}
if (!get_magic_quotes_gpc()) {
    while (list($header, $value) = each($HTTP_POST_VARS)) {
         $HTTP_POST_VARS[$header] = addslashes($HTTP_POST_VARS[$header]);
    }
}
$lng_table_lang = substr($lng,0,2);
$error_title = "updating plans";
if ($HTTP_POST_VARS['todo'] == "saveplanning") {
    if(ADMIN_SAFE_MODE == "yes") {
        bx_admin_error(TEXT_SAFE_MODE_ALERT);
    }//end if ADMIN_SAFE_MODE == yes
    else {
            if (empty($lng)) {
                 bx_admin_error("You must select a language to edit.");
             }//end if (empty($folders))
             else {
                    $ready = false;
                     if ($HTTP_POST_VARS['pricing_id'] == "0" && $HTTP_POST_VARS['save_type']!="additional") { //when we are adding a new planning type
                          if (empty($HTTP_POST_VARS['pricing_title'])) {
                                   bx_admin_error("Invalid planning type! Please enter a planning type to add.");
                          }
                          if ((empty($HTTP_POST_VARS['pricing_fcompany'])) || (($HTTP_POST_VARS['pricing_fcompany']!="no") && ($HTTP_POST_VARS['pricing_fcompany']!="yes"))) {
                                   bx_admin_error("Invalid featured company type! Please enter yes or no in the featured company field.");
                          }
                          if (empty($HTTP_POST_VARS['pricing_currency'])) {
                                   bx_admin_error("Invalid planning currency! Please enter a planning currency to add.");
                          }
                          else {
                                   $count_query = bx_db_query("select max(pricing_id) from ".$bx_table_prefix."_pricing_".$lng_table_lang."");
                                   $count_result = bx_db_fetch_array($count_query);
                                   $dir_list = split("::",$HTTP_POST_VARS['lng_dirs']);
                                   for ( $i=0 ; $i<sizeof($dir_list) ; $i++ ) {
                                           bx_db_query("INSERT INTO ".$bx_table_prefix."_pricing_".substr($dir_list[$i],0,2)." values ('".($count_result[0]+1)."','".$HTTP_POST_VARS['pricing_title']."', '".$HTTP_POST_VARS['pricing_avjobs']."', '".$HTTP_POST_VARS['pricing_avsearch']."', '".$HTTP_POST_VARS['pricing_fjobs']."', '".$HTTP_POST_VARS['pricing_fcompany']."', '".$HTTP_POST_VARS['pricing_period']."', '".$HTTP_POST_VARS['pricing_price']."', '".$HTTP_POST_VARS['pricing_currency']."', '".$HTTP_POST_VARS['pricing_default']."')");
                                           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                           $ready = true;
                                   }       
                          }
                      }  //end if ($pricing_id == "0")
                      else {  //else we are updating a planning type
                                if (empty($HTTP_POST_VARS['pricing_id']) && $HTTP_POST_VARS['save_type']!="additional") {
                                    bx_admin_error("Invalid planning type! Please enter a planning type to add.");
                                }
                                if (empty($HTTP_POST_VARS['pricing_title'])) {
                                   bx_admin_error("Invalid planning type! Please enter a planning type to add.");
                                }
                                if ((empty($HTTP_POST_VARS['pricing_fcompany'])) || (($HTTP_POST_VARS['pricing_fcompany']!="no") && ($HTTP_POST_VARS['pricing_fcompany']!="yes"))) {
                                   bx_admin_error("Invalid featured company type! Please enter yes or no in the featured company field.");
                                }
                                if (empty($HTTP_POST_VARS['pricing_currency'])) {
                                   bx_admin_error("Invalid planning currency! Please enter a planning currency to add.");
                                }
                                if ($HTTP_POST_VARS['pricing_price']!="0.00" && $HTTP_POST_VARS['pricing_price']!="0" && $HTTP_POST_VARS['pricing_default']) {
                                   bx_admin_error("Invalid planning price! The default planning has to have the price set to 0.");
                                }
                                else {
                                    if ($HTTP_POST_VARS['pricing_default']) {
                                        $dir_list = split("::",$HTTP_POST_VARS['lng_dirs']);
                                        for ( $i=0 ; $i<sizeof($dir_list) ; $i++ ) {
                                            bx_db_query("UPDATE ".$bx_table_prefix."_pricing_".substr($dir_list[$i],0,2)." set pricing_default='0'");	
                                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                        }    
                                    }
                                    bx_db_query("UPDATE ".$bx_table_prefix."_pricing_".$lng_table_lang." set pricing_title = '".$HTTP_POST_VARS['pricing_title']."', pricing_avjobs = '".$HTTP_POST_VARS['pricing_avjobs']."', pricing_avsearch = '".$HTTP_POST_VARS['pricing_avsearch']."', pricing_fjobs = '".$HTTP_POST_VARS['pricing_fjobs']."', pricing_fcompany = '".$HTTP_POST_VARS['pricing_fcompany']."', pricing_period = '".$HTTP_POST_VARS['pricing_period']."', pricing_price = '".$HTTP_POST_VARS['pricing_price']."', pricing_currency = '".$HTTP_POST_VARS['pricing_currency']."', pricing_default = '".$HTTP_POST_VARS['pricing_default']."' where pricing_id = '".$HTTP_POST_VARS['pricing_id']."'");
                                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                    $dir_list = split("::",$HTTP_POST_VARS['lng_dirs']);
                                    for ( $i=0 ; $i<sizeof($dir_list) ; $i++ ) {
                                        bx_db_query("UPDATE ".$bx_table_prefix."_pricing_".substr($dir_list[$i],0,2)." set pricing_default='".$HTTP_POST_VARS['pricing_default']."' where pricing_id='".$HTTP_POST_VARS['pricing_id']."'");	
                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                    }    
                                    $ready = true;
                                }
                      }
              }        
       }       
}
if ($HTTP_POST_VARS['todo'] == "delplanning") {
    if(ADMIN_SAFE_MODE == "yes") {
        bx_admin_error(TEXT_SAFE_MODE_ALERT);
    }//end if ADMIN_SAFE_MODE == yes
    else {
         $ready = false;
         $dir_list = split("::",$HTTP_POST_VARS['lng_dirs']);
         for ( $i=0 ; $i<sizeof($dir_list) ; $i++ ) {
             bx_db_query("DELETE FROM ".$bx_table_prefix."_pricing_".substr($dir_list[$i],0,2)." where pricing_id = '".$HTTP_POST_VARS['pricing_id']."'");
             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
         }   
         $ready = true;         
         if ($ready) {
         ?>
         <script language="Javascript">
                <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."?lng=".$lng;?>" name="redirect">');
                document.write('</form>');
                document.redirect.submit();
                //-->
             </script>
             <?php
          }
    }     
}
else {
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit Planning information (language: <?php echo $lng;?>)</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="2" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
    <td colspan="11">Select Language: 
    <?php
      $lng_dirs="";
      $dirs = getFolders(DIR_LANGUAGES);
      for ($i=0; $i<count($dirs); $i++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                  $lng_dirs .= $dirs[$i]."::";
                  if ($lng == $dirs[$i]) {
                      $font = "<font size=3 color=\"#FF0000\">";
                  }
                  else {
                      $font = "<font size=2>";
                  }
                  echo "<a href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."?lng=".$dirs[$i]."&ref=".time()."\">".$font.$dirs[$i]."</font></a>&nbsp;&nbsp;";
           }
      }
      $lng_dirs = eregi_replace("::$","", $lng_dirs);
    ?>
    </td>
</tr>
<tr>
    <td colspan="11"><br></td>
</tr>
<TR>
     <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_AUTO_PLANNING;?></B></small></font>
     </TD>
	 <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_MEMBERSHIP_TYPE;?></B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_RESUMES;?><br>(999=unlimited)</B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_JOBS;?><br>(999=unlimited)</B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_FEATURED_JOBS_MEMBERSHIP;?></B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_FEATURED_COMPAN;?><br>(yes/no)</B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_PERIOD;?><br>(month)</B></small></font>
      </TD>
      <TD align="center" width="5%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_PRICE;?></B></small></font>
      </TD>
      <TD align="center" width="10%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_CURRENCY;?></B></small></font>
      </TD>
      <TD align="center" colspan="2" width="20%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><small><B><?php echo TEXT_ACTION;?></B></small></font>
      </TD>
    </TR>
<?php
                     $planning_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_pricing_".$lng_table_lang." where pricing_id>0");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     while ($planning_result=bx_db_fetch_array($planning_query)) {
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."\"><input type=\"hidden\" name=\"todo\" value=\"saveplanning\"><input type=\"hidden\" name=\"lng\" value=\"".$lng."\"><input type=\"hidden\" name=\"lng_dirs\" value=\"".$lng_dirs."\"><input type=\"hidden\" name=\"pricing_id\" value=\"".$planning_result['pricing_id']."\"><tr><td align=\"right\" width=\"10%\"><input type=\"checkbox\" name=\"pricing_default\" value=\"1\"";
							if ($planning_result['pricing_default']) {
							    echo "checked";
							}
							echo "></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_title\" value=\"".$planning_result['pricing_title']."\" size=\"20\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_avsearch\" value=\"".$planning_result['pricing_avsearch']."\" size=\"3\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_avjobs\" value=\"".$planning_result['pricing_avjobs']."\" size=\"3\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_fjobs\" value=\"".$planning_result['pricing_fjobs']."\" size=\"3\"></td><td align=\"right\" width=\"10%\"><select name=\"pricing_fcompany\"><option value=\"no\"".(($planning_result['pricing_fcompany']=="no")?" selected":"").">".TEXT_NO."</option><option value=\"yes\"".(($planning_result['pricing_fcompany']=="yes")?" selected":"").">".TEXT_YES."</option></select></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_period\" value=\"".$planning_result['pricing_period']."\" size=\"2\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_price\" value=\"".$planning_result['pricing_price']."\" size=\"5\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_currency\" value=\"".$planning_result['pricing_currency']."\" size=\"5\"></td><td align=\"right\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
                            echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."\"><input type=\"hidden\" name=\"todo\" value=\"delplanning\"><input type=\"hidden\" name=\"lng\" value=\"".$lng."\"><input type=\"hidden\" name=\"lng_dirs\" value=\"".$lng_dirs."\"><td align=\"left\"><input type=\"hidden\" name=\"pricing_id\" value=\"".$planning_result['pricing_id']."\"><input type=\"submit\" name=\"edit\" value=\"Delete\" onClick=\"return confirm('".TEXT_CONFIRM_PLANNING_DELETE."');\"></td></tr></form>";

                     }
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."\"><input type=\"hidden\" name=\"todo\" value=\"saveplanning\"><input type=\"hidden\" name=\"lng\" value=\"".$lng."\"><input type=\"hidden\" name=\"lng_dirs\" value=\"".$lng_dirs."\"><input type=\"hidden\" name=\"pricing_id\" value=\"0\"><tr><td align=\"right\" width=\"10%\"><input type=\"checkbox\" name=\"pricing_default\" value=\"1\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_title\" value=\"\" size=\"20\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_avsearch\" value=\"0\" size=\"3\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_avjobs\" value=\"0\" size=\"3\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_fjobs\" value=\"0\" size=\"3\"></td><td align=\"right\" width=\"10%\"><select name=\"pricing_fcompany\"><option value=\"no\">".TEXT_NO."</option><option value=\"yes\">".TEXT_YES."</option></select></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_period\" value=\"3\" size=\"2\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_price\" value=\"0\" size=\"5\"></td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_currency\" value=\"".PRICE_CURENCY."\" size=\"5\"></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"  Add  \"></td></tr></form>";
                     echo "<tr><td colspan=\"11\">&nbsp;</td></tr>";
                     echo "<tr><td colspan=\"11\"><font color=\"#FFFFFF\"><b>Additional Job Shopping (employers can buy jobs/featured jobs/resumes contact extra planning)</b></font></td></tr>";
                     $planning_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_pricing_".$lng_table_lang." where pricing_id=0");
                     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                     $planning_result=bx_db_fetch_array($planning_query);
                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_PLANNING."\"><input type=\"hidden\" name=\"todo\" value=\"saveplanning\"><input type=\"hidden\" name=\"lng\" value=\"".$lng."\"><input type=\"hidden\" name=\"lng_dirs\" value=\"".$lng_dirs."\"><input type=\"hidden\" name=\"pricing_id\" value=\"".$planning_result['pricing_id']."\"><input type=\"hidden\" name=\"save_type\" value=\"additional\"><input type=\"hidden\" name=\"pricing_fcompany\" value=\"no\"><input type=\"hidden\" name=\"pricing_currency\" value=\"".PRICE_CURENCY."\"><tr><td align=\"right\" width=\"10%\">&nbsp;";
                     echo "</td><td align=\"right\" width=\"10%\"><input type=\"text\" name=\"pricing_title\" value=\"".$planning_result['pricing_title']."\" size=\"20\"></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"right\" width=\"10%\"><b>N/A</b></td><td align=\"center\" colspan=\"2\"><input type=\"submit\" name=\"edit\" value=\"Update\"></td></form>";
             ?>
<tr>
    <td colspan="11">&nbsp;</td>
</tr>
<tr><td colspan="11"><font color="#FFFFFF"><?php echo TEXT_AUTO_PLANNING_NOTE;?></font></td></tr>
<tr>
    <td colspan="11">&nbsp;</td>
</tr>
</table>

</td></tr></table>
<?php
}
?>