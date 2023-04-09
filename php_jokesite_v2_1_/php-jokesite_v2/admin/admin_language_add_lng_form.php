<?
define('FILENAME_ADMIN_EDIT_LANGUAGE', 'admin_language_edit_lng.php');
define('TEXT_FONT_COLOR', '#FF0000');
define('TEXT_FONT_SIZE', '2');
define('TEXT_FONT_FACE', 'verdana');

$error_title = "creating the new language";
$create = true;
//postvars($HTTP_POST_VARS);exit;
if ($HTTP_POST_VARS['todo'] == "addlng"){
      if (empty($HTTP_POST_VARS['lng'])) {
           bx_error("Please enter a language name.");
           $create = false;
      }
      if (($create) && (empty($HTTP_POST_VARS['folders']))) {
           bx_error("Please select a base language.");
           $create = false;
      }
     if (($create) && (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']))) {
           bx_error("Language directory already exists ".DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".");
           $create = false;
     }
     if (($create) && (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images"))) 
     {
           bx_error("Language images directory already exists ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images".".");
           $create = false;
     }
	 if (($create) && (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail"))) 
     {
           bx_error("Language images directory already exists ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail".".");
           $create = false;
     }
	 if (($create) && (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html"))) 
     {
           bx_error("Language images directory already exists ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html".".");
           $create = false;
     }
     if (($create) && (!mkdir(DIR_LANGUAGES.$HTTP_POST_VARS['lng'], 0777)) ) {
           bx_error("Unable to create directory ".DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".");
           $create = false;
     }
     if (($create) && (!mkdir(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images", 0777)) ) {
           bx_error("Unable to create directory ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images.");
           $create = false;
     }
	 if (($create) && (!mkdir(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail", 0777)) ) {
           bx_error("Unable to create directory ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail.");
           $create = false;
     }
	 if (($create) && (!mkdir(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html", 0777)) ) {
           bx_error("Unable to create directory ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html.");
           $create = false;
     }
     if (($create) && (!copy(DIR_LANGUAGES.$HTTP_POST_VARS['folders'].".php",DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php")) ) {
           bx_error("Unable to copy/create base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php.");
           $create = false;
     }
     if (($create) && (!chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php", 0777))) {
           bx_error("Unable to change permissions for file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng'].".php.");
           $create = false;
     }
     if ($create) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images");
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images/".$files[$i],DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images/".$files[$i]))) {
                           bx_error("Unable to copy/create base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images/".$files[$i].".");
                           $create = false;
                 }
		 else {
			  @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/images/".$files[$i], 0777);
		 }
           }
     }
	 if ($create) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html");
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html/".$files[$i],DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/".$files[$i]))) {
                           bx_error("Unable to copy/create base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/".$files[$i].".");
                           $create = false;
                 }
		 else {
			  @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/".$files[$i], 0777);
		 }
           }
     }
	 if ($create) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail");
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail/".$files[$i],DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail/".$files[$i]))) {
                           bx_error("Unable to copy/create base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail/".$files[$i].".");
                           $create = false;
                 }
		 else {
			  @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/mail/".$files[$i], 0777);
		 }
           }
     }
     if ($create) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']);
           for ($i=0; $i<count($files); $i++) {
                 if (($create) && (!copy(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/".$files[$i],DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$files[$i]))) {
                           bx_error("Unable to copy/create base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$files[$i].".");
                           $create = false;
                 }
		 else {
			   @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$files[$i], 0777);
		 }
           }
      }
      if ($create) {
	   bx_db_query("ALTER TABLE $bx_db_table_newsletter_categories ADD newsletter_category_name_".substr($HTTP_POST_VARS['lng'],0,3)." VARCHAR(70) NOT NULL AFTER `newsletter_category_id`"); 
	   bx_db_query("update $bx_db_table_newsletter_categories set newsletter_category_name_".substr($HTTP_POST_VARS['lng'],0,3)."=newsletter_category_name_".substr($HTTP_POST_VARS['folders'],0,3));
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	   bx_db_query("ALTER TABLE $bx_db_table_image_categories ADD category_name_".substr($HTTP_POST_VARS['lng'],0,3)." VARCHAR(70) NOT NULL AFTER `category_id`"); 
	   bx_db_query("update $bx_db_table_image_categories set category_name_".substr($HTTP_POST_VARS['lng'],0,3)."=category_name_".substr($HTTP_POST_VARS['folders'],0,3));

	   bx_db_query("ALTER TABLE $bx_db_table_censor_categories ADD censor_category_name_".substr($HTTP_POST_VARS['lng'],0,3)." VARCHAR(150) NOT NULL AFTER censor_category_id"); 
	   bx_db_query("update $bx_db_table_censor_categories set censor_category_name_".substr($HTTP_POST_VARS['lng'],0,3)."=censor_category_name_".substr($HTTP_POST_VARS['folders'],0,3));

	   bx_db_query("ALTER TABLE $bx_db_table_joke_categories ADD category_name_".substr($HTTP_POST_VARS['lng'],0,3)." VARCHAR(150) NOT NULL AFTER category_id"); 
	   bx_db_query("update $bx_db_table_joke_categories set category_name_".substr($HTTP_POST_VARS['lng'],0,3)."=category_name_".substr($HTTP_POST_VARS['folders'],0,3));

	   bx_db_query("ALTER TABLE $bx_db_table_daily_newsletters ADD joke_text_".substr($HTTP_POST_VARS['lng'],0,3)." TEXT NOT NULL AFTER date"); 
	   bx_db_query("update $bx_db_table_daily_newsletters set joke_text_".substr($HTTP_POST_VARS['lng'],0,3)."=joke_text_".substr($HTTP_POST_VARS['folders'],0,3));
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	   bx_db_query("ALTER TABLE $bx_db_table_daily_newsletters ADD joke_title_".substr($HTTP_POST_VARS['lng'],0,3)." TEXT NOT NULL AFTER joke_text_".substr($HTTP_POST_VARS['lng'],0,3)); 
	   bx_db_query("update $bx_db_table_daily_newsletters set joke_title_".substr($HTTP_POST_VARS['lng'],0,3)."=joke_title_".substr($HTTP_POST_VARS['folders'],0,3));
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

     }
      if ($create) {
           ?>
             <form method="post" action="<?=HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_LANGUAGE?>" name="addlng">
             <input type="hidden" name="todo" value="editlng">
             <input type="hidden" name="folders" value="<?=$HTTP_POST_VARS['lng']?>">
             <table width="100%" cellspacing="0" cellpadding="1" border="0">
              <tr>
                  <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b><?=TEXT_LANGUAGE_SUCCESS?></b></font></td>
              </tr>
              <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
                   <TABLE border="0" cellpadding="1" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
                   <tr>
                       <td colspan="2"><br></td>
                   </tr>
                   <tr>
                       <td><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_LANGUAGE_CREATION_SUCCESS?></b></font><br></td>
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
           <?
      }//end if $create
}
else {
?>
<form method="post" action="<?=$this_file_name?>" name="addlng" onSubmit="return check_form();">
<input type="hidden" name="todo" value="addlng">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Add language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_BORDERCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td align="right"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>"><b>Please enter your new language name:
:</b></font><br><font face="Verdana" size="1" color="#000000">Note: The language name must be lowercase, and intuitive (e.g. english, german, french, chinese etc...).</font></td><td valign="top"><input type="text" name="lng" onChange="tolowercase();"></td>
</tr>
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>"><b>Please select one of the following base languages:</b></font><br><font face="Verdana" size="1" color="#000000">Note: You will have to translate all words/phrases from the selected base language into your new language</font></td><td valign="top">
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
        <td colspan="2" align="center"><br><input type="submit" name="save" value="Create Language"></td>
</tr>
</table>

</td></tr></table>
</form>
<?
}
?>