<?
define('FILENAME_ADMIN_EDIT_LANGUAGE', 'admin_language_edit_lng.php');
define('TEXT_FONT_COLOR', '#FF0000');
define('TEXT_FONT_SIZE', '2');
define('TEXT_FONT_FACE', 'verdana'); 

if ($HTTP_POST_VARS['todo'] == "backup") {?>
<table width="100%" cellspacing="0" cellpadding="1" border="0">
 <tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Backup database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
        <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Thank you...<br> Please make sure you store this file in a safe place!!!<br>Make copies if you are not sure...</b></font></td>
</tr>
<tr>
        <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><a href="<?=HTTP_SERVER_ADMIN.FILENAME_INDEX?>">Home</a></font></td>
</tr>
</table>

</td></tr></table>
<?
refresh(HTTP_SERVER_ADMIN."admin_backup_db.php"."?todo=senddb");} else {?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_backup_db.php"?>" name="backup">
<input type="hidden" name="todo" value="backup">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
 <tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Backup database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
        <td align="right"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Here you can backup your database.<br>We encourage you to make database backup's periodically, the loss will not be so big when something happen to the database.<br>A good option is to name your backup file in a format like this: mm-dd-yy-dbname.sql. This is automatically suggested by Internet Explorer, for other browsers you must introduce the filename.<br>Today suggested filename is : <?=date('m-d-Y')."-".((ADMIN_SAFE_MODE == "yes")?"DATABASENAME":DB_DATABASE).".sql"?>.<br>Also if you can store your backup files in the same directory, to be easy to find the files when you want to restore your database.</b></font></td>
</tr>
<tr>
        <td align="right"><input type="submit" name="save" value="Backup"></td>
</tr>
</table>

</td></tr></table>
</form>
<?}?>