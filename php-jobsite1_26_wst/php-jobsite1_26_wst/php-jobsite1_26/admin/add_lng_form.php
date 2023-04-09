<?php
$error_title = "creating the new language";
$create = true;
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
if ($HTTP_POST_VARS['todo'] == "addlng"){
      if (empty($lng)) {
           bx_admin_error("Please enter a language name.");
           $create = false;
      }
      $dirs = getFolders(DIR_LANGUAGES);
      for ($i=0; $i<count($dirs); $i++) {
               if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                      if($lng_table_lang == substr($dirs[$i],0,2)) {
                          bx_admin_error("Invalid language name (the first 2 letters from the language must be unique).");
                          $create = false;
                      }
               }
      }
      if (($create) && (empty($folders))) {
           bx_admin_error("Please select a base language.");
           $create = false;
      }
      if (($create) && (file_exists(DIR_LANGUAGES.$lng))) {
           bx_admin_error("Language directory already exists ".DIR_LANGUAGES.$lng.".");
           $create = false;
      }
      if (($create) && (file_exists(DIR_LANGUAGES.$lng."/mail"))) {
           bx_admin_error("Language mail directory already exists ".DIR_LANGUAGES.$lng."/mail".".");
           $create = false;
      }
      if (($create) && (file_exists(DIR_LANGUAGES.$lng."/html"))) {
           bx_admin_error("Language mail directory already exists ".DIR_LANGUAGES.$lng."/html".".");
           $create = false;
      }
      if (($create) && (file_exists(DIR_IMAGES.$lng))) {
           bx_admin_error("Language image directory already exists ".DIR_LANGUAGES.$lng.".");
           $create = false;
      }
      if (($create) && (!mkdir(DIR_LANGUAGES.$lng, 0777)) ) {
           bx_admin_error("Unable to create directory ".DIR_LANGUAGES.$lng.".");
           $create = false;
      }
      else {
          @chmod(DIR_LANGUAGES.$lng, 0777);
      }
      if (($create) && (!mkdir(DIR_LANGUAGES.$lng."/mail", 0777)) ) {
           bx_admin_error("Unable to create directory ".DIR_LANGUAGES.$lng."/mail.");
           $create = false;
      }
      else {
         @chmod(DIR_LANGUAGES.$lng."/mail", 0777);
      }
      if (($create) && (!mkdir(DIR_LANGUAGES.$lng."/html", 0777)) ) {
           bx_admin_error("Unable to create directory ".DIR_LANGUAGES.$lng."/html.");
           $create = false;
      }
      else {
         @chmod(DIR_LANGUAGES.$lng."/html", 0777);
      }
      if (($create) && (!mkdir(DIR_IMAGES.$lng, 0777)) ) {
           bx_admin_error("Unable to create directory ".DIR_IMAGES.$lng.".");
           $create = false;
      }
      else {
         @chmod(DIR_IMAGES.$lng, 0777);
      }
      if (($create) && (!copy(DIR_LANGUAGES.$folders.".php",DIR_LANGUAGES.$lng.".php")) ) {
           bx_admin_error("Unable to copy/create base language file ".DIR_LANGUAGES.$lng.".php.");
           $create = false;
      }
      if (($create) && (!chmod(DIR_LANGUAGES.$lng.".php", 0777))) {
           bx_admin_error("Unable to change permissions for file ".DIR_LANGUAGES.$lng.".php.");
           $create = false;
      }
      if ($create) {
           $files = getFiles(DIR_LANGUAGES.$folders);
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$folders."/".$files[$i],DIR_LANGUAGES.$lng."/".$files[$i]))) {
                           bx_admin_error("Unable to copy/create base language file ".DIR_LANGUAGES.$lng."/".$files[$i].".");
                           $create = false;
                 }
                 else {
                       @chmod(DIR_LANGUAGES.$lng."/".$files[$i], 0777);
                 }
           }
      }
      if ($create) {
           $files = getFiles(DIR_LANGUAGES.$folders."/mail");
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$folders."/mail/".$files[$i],DIR_LANGUAGES.$lng."/mail/".$files[$i]))) {
                           bx_admin_error("Unable to copy/create base language file ".DIR_LANGUAGES.$lng."/mail/".$files[$i].".");
                           $create = false;
                 }
                 else {
                      @chmod(DIR_LANGUAGES.$lng."/mail/".$files[$i], 0777);
                 }
           }
      }
      if ($create) {
           $files = getFiles(DIR_LANGUAGES.$folders."/html");
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$folders."/html/".$files[$i],DIR_LANGUAGES.$lng."/html/".$files[$i]))) {
                           bx_admin_error("Unable to copy/create base language file ".DIR_LANGUAGES.$lng."/html/".$files[$i].".");
                           $create = false;
                 }
                 else {
                          @chmod(DIR_LANGUAGES.$lng."/html/".$files[$i], 0777);
                 }
           }//end for
      }
      if ($create) {
           $files = getFiles(DIR_IMAGES.$folders);
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_IMAGES.$folders."/".$files[$i],DIR_IMAGES.$lng."/".$files[$i]))) {
                           bx_admin_error("Unable to copy/create language images ".DIR_IMAGES.$lng."/".$files[$i].".");
                           $create = false;
                 }
                 else {
                          @chmod(DIR_IMAGES.$lng."/".$files[$i], 0777);
                 }
           }
      }
      if ($create) {
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_jobcategories_".$lng_table_lang." (jobcategoryid int(2) NOT NULL auto_increment,jobcategory varchar(100) NOT NULL default '',PRIMARY KEY  (jobcategoryid))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_jobcategories_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_jobcategories_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_locations_".$lng_table_lang." (locationid int(4) NOT NULL auto_increment,location varchar(120) NOT NULL default '',PRIMARY KEY  (locationid), KEY location (location))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_locations_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_locations_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_jobtypes_".$lng_table_lang." (jobtypeid int(1) NOT NULL auto_increment, jobtype varchar(60) NOT NULL default '', PRIMARY KEY  (jobtypeid))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_jobtypes_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_jobtypes_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_help_".$lng_table_lang." (help_id int(11) NOT NULL auto_increment, help_catid int(3) NOT NULL default '0',  help_subcatid int(5) NOT NULL default '0', help_title varchar(255) NOT NULL default '', help_text text NOT NULL, PRIMARY KEY  (help_id))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_help_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_help_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_helpsubcat_".$lng_table_lang." (help_subcatid int(5) NOT NULL auto_increment, help_catid int(3) NOT NULL default '0', help_subcategory varchar(255) NOT NULL default '', PRIMARY KEY  (help_subcatid))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_helpsubcat_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_helpsubcat_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_helpcat_".$lng_table_lang." (help_catid int(3) NOT NULL auto_increment, help_category varchar(255) NOT NULL default '', help_type tinyint(2) NOT NULL default '0', PRIMARY KEY  (help_catid))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_helpcat_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_helpcat_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_helptoc_".$lng_table_lang." (help_tocid bigint(20) NOT NULL auto_increment, help_toclabel varchar(255) NOT NULL default '', help_type tinyint(2) NOT NULL default '0', help_id int(5) NOT NULL default '0', help_catid int(3) NOT NULL default '0', help_subcatid int(3) NOT NULL default '0', help_word varchar(80) NOT NULL default '', PRIMARY KEY  (help_tocid), KEY help_word (help_word))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_helptoc_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_helptoc_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("CREATE TABLE ".$bx_table_prefix."_pricing_".$lng_table_lang." (pricing_id mediumint(3) NOT NULL default '0', pricing_title varchar(50) NOT NULL default '', pricing_avjobs mediumint(3) NOT NULL default '0', pricing_avsearch mediumint(3) NOT NULL default '0', pricing_fjobs mediumint(3) NOT NULL default '0',  pricing_fcompany char(3) NOT NULL default '0', pricing_period mediumint(2) NOT NULL default '0', pricing_price float(10,2) NOT NULL default '0.00', pricing_currency char(3) NOT NULL default '', pricing_default tinyint(4) NOT NULL default '0', PRIMARY KEY  (pricing_id))");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           bx_db_query("INSERT INTO ".$bx_table_prefix."_pricing_".$lng_table_lang." SELECT * FROM ".$bx_table_prefix."_pricing_".$folder_table_lang);
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      }
      if ($create) {
           ?>
             <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE;?>" name="addlng">
             <input type="hidden" name="todo" value="editlng">
             <input type="hidden" name="folders" value="<?php echo $lng;?>">
             <table width="100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                  <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b><?php echo TEXT_LANGUAGE_SUCCESS;?></b></font></td>
              </tr>
              <tr>
               <td bgcolor="#000000">
                   <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
                   <tr>
                       <td colspan="2"><br></td>
                   </tr>
                   <tr>
                       <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_LANGUAGE_CREATION_SUCCESS;?></b></font><br></td>
                   </tr>
                   <tr>
                       <td colspan="2"><br></td>
                   </tr>
                   <tr>
                         <td colspan="2" align="center"><br><input type="submit" name="edit" value="Edit Language"></td>
                   </tr>
                   </table>
               </td></tr></table>
               </form>
           <?php
      }//end if $create
}
else {
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_ADD_LANGUAGE;?>" name="addlng" onSubmit="return check_form();">
<input type="hidden" name="todo" value="addlng">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Add language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_DEFINE_LANGUAGE_NAME;?>:</b></font><br><font face="Verdana" size="1" color="#000000"><?php echo TEXT_DEFINE_LANGUAGE_NAME_NOTE;?></font></td><td valign="top"><input type="text" name="lng" onChange="tolowercase();"></td>
</tr>
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_LANGUAGE;?>:</b></font><br><font face="Verdana" size="1" color="#000000"><?php echo TEXT_SELECT_LANGUAGE_NOTE;?></font></td><td valign="top">
<?php
  $dirs = getFolders(DIR_LANGUAGES);
  for ($i=0; $i<count($dirs); $i++) {
       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
              echo "<input type=\"radio\" name=\"folders\" value=\"".$dirs[$i]."\" class=\"radio\">".$dirs[$i]."<br>";
       }
  }
?>
</td></tr>
<tr>
        <td colspan="2" align="center"><br><input type="submit" name="save" value="Create Language"></td>
</tr>
</table>

</td></tr></table>
</form>
<?php
}
?>