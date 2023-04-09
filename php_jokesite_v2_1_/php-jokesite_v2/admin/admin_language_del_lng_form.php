<?
define('TEXT_FONT_COLOR', '#FF0000');
define('TEXT_FONT_SIZE', '2');
define('TEXT_FONT_FACE', 'verdana');
define('TEXT_CONFIRM_JOBTYPE_DELETE', 'Do you want to delete this entries?');

$dirs = getFiles(DIR_LANGUAGES);

$error_title = "deleting language";
$del = true;
if ($HTTP_POST_VARS['todo'] == "dellng" && sizeof($dirs) > 1 && $HTTP_POST_VARS['folders']){
      if (!file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['folders'])) {
           bx_error("Language directory doesn't exists ".DIR_LANGUAGES.$HTTP_POST_VARS['folders'].".");
           $del = false;
      }
      if (!file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images")) {
           bx_error("Language images directory doesn't exists ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images.");
           $del = false;
      }
      if ($del) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images");
           for ($i=0; $i<count($files); $i++) {
                 if (($del) && (!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images/".$files[$i])) ) {
                           bx_error("Unable to delete language images file ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images/".$files[$i].".");
                           $del = false;
                 }
           }
      }
	  if (!file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail")) {
           bx_error("Language images directory doesn't exists ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail.");
           $del = false;
      }
      if ($del) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail");
           for ($i=0; $i<count($files); $i++) {
                 if (($del) && (!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail/".$files[$i])) ) {
                           bx_error("Unable to delete language mail file ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail/".$files[$i].".");
                           $del = false;
                 }
           }
      }
	  if (!file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html")) {
           bx_error("Language images directory doesn't exists ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html.");
           $del = false;
      }
      if ($del) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html");
           for ($i=0; $i<count($files); $i++) {
                 if (($del) && (!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html/".$files[$i])) ) {
                           bx_error("Unable to delete language html file ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html/".$files[$i].".");
                           $del = false;
                 }
           }
      }
      if ($del) {
           $files = getFiles(DIR_LANGUAGES.$HTTP_POST_VARS['folders']);
           for ($i=0; $i<count($files); $i++) {
                 if (($del) && (!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/".$files[$i])) ) {
                           bx_error("Unable to delete language file ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/".$files[$i].".");
                           $del = false;
                 }
           }
      }
      if (($del) && (!rmdir(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images")) ) {
           bx_error("Unable to delete directory ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/images");
           $del = false;
      }
	  if (($del) && (!rmdir(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail")) ) {
           bx_error("Unable to delete directory ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/mail");
           $del = false;
      }
	  if (($del) && (!rmdir(DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html")) ) {
           bx_error("Unable to delete directory ".DIR_LANGUAGES.$HTTP_POST_VARS['folders']."/html");
           $del = false;
      }
      if (($del) && (!rmdir(DIR_LANGUAGES.$HTTP_POST_VARS['folders'])) ) {
           bx_error("Unable to delete directory ".DIR_LANGUAGES.$HTTP_POST_VARS['folders'].".");
           $del = false;
      }
       if (($del) && (!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['folders'].".php")) ) {
           bx_error("Unable to delete base language file ".DIR_LANGUAGES.$HTTP_POST_VARS['folders'].".php.");
           $del = false;
       }
	   if (file_exists(DIR_FLAG.$HTTP_POST_VARS['folders'].".gif")) {
                 $imgsize = getimagesize(DIR_FLAG.$HTTP_POST_VARS['folders'].".gif");
                 if (($del) && (!unlink(DIR_FLAG.$HTTP_POST_VARS['folders'].".gif")) ) {
                       bx_admin_error("Unable to delete flag image file ".DIR_FLAG.$HTTP_POST_VARS['folders'].".gif");
                       $del = false;
                 }
               }
               if (file_exists(DIR_FLAG.$HTTP_POST_VARS['folders'].".jpg")) {
                 $imgsize = getimagesize(DIR_FLAG.$HTTP_POST_VARS['folders'].".jpg");
                 if (($del) && (!unlink(DIR_FLAG.$HTTP_POST_VARS['folders'].".jpg")) ) {
                       bx_admin_error("Unable to delete flag image file ".DIR_FLAG.$HTTP_POST_VARS['folders'].".jpg");
                       $del = false;
                 }
               }
               if (file_exists(DIR_FLAG.$HTTP_POST_VARS['folders'].".png")) {
                 $imgsize = getimagesize(DIR_FLAG.$HTTP_POST_VARS['folders'].".png");
                 if (($del) && (!unlink(DIR_FLAG.$HTTP_POST_VARS['folders'].".png")) ) {
                       bx_admin_error("Unable to delete flag image file ".DIR_FLAG.$HTTP_POST_VARS['folders'].".png");
                       $del = false;
                 }
               }
       if ($del) {
	    bx_db_query("ALTER TABLE $bx_db_table_newsletter_categories DROP newsletter_category_name_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	    bx_db_query("ALTER TABLE $bx_db_table_image_categories DROP category_name_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	    bx_db_query("ALTER TABLE $bx_db_table_censor_categories DROP censor_category_name_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	    bx_db_query("ALTER TABLE $bx_db_table_joke_categories DROP category_name_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		bx_db_query("ALTER TABLE $bx_db_table_daily_newsletters DROP joke_text_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		bx_db_query("ALTER TABLE $bx_db_table_daily_newsletters DROP joke_title_".substr($HTTP_POST_VARS['folders'],0,3));
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

		if (file_exists(INCOMING."daily_active_joke_picture_".substr($HTTP_POST_VARS['folders'],0,3).".php"))
			unlink(INCOMING."daily_active_joke_picture_".substr($HTTP_POST_VARS['folders'],0,3).".php");
		
       }
      if ($del) {
           ?>
             <table width="100%" cellspacing="0" cellpadding="1" border="0">
              <tr>
                  <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b><?=TEXT_DELETE_LANGUAGE_SUCCESS?></b></font></td>
              </tr>
              <tr>
               <td bgcolor="<?=TABLE_BORDERCOLOR?>">
                   <TABLE border="0" cellpadding="1" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
                   <tr>
                       <td colspan="2"><br></td>
                   </tr>
                   <tr>
                       <td><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_LANGUAGE_DELETE_SUCCESS?></b></font><br></td>
                   </tr>
                   </table>
               </td></tr></table>
           <?
      }//end if $create
}
elseif ($HTTP_POST_VARS['todo'] == "dellng" && sizeof($dirs) == 1 && $HTTP_POST_VARS['folders'])
{
	bx_error("You cannot delete this language. You must have at least one language for this scirpt!");
}
else {
?>
<form method="post" action="<?=$this_file_name?>" name="dellng" onSubmit="return confirm('Do you want to delete this language?')">
<input type="hidden" name="todo" value="dellng">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Delete language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_BORDERCOLOR?>">
<TABLE border="0" cellpadding="1" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_DELETE_LANGUAGE?>:</b></font><br><font face="Verdana" size="1" color="#000000"><?=TEXT_SELECT_DELETE_LANGUAGE_NOTE?></font></td><td valign="top">
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
        <td colspan="2" align="center"><br><input type="submit" name="delete" value="Delete Language"></td>
</tr>
</table>

</td></tr></table>
</form>
<?
}
?>