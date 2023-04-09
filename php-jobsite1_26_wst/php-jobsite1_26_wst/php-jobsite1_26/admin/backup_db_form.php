<?php if($HTTP_POST_VARS['todo'] == "backup") {?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Backup database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Thank you...<br> Please make sure you store this file in a safe place!!!<br>Make copies if you are not sure...</b></font></td>
</tr>
<tr>
        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>">Home</a></font></td>
</tr>
</table>

</td></tr></table>
<?php
refresh(HTTP_SERVER_ADMIN.FILENAME_ADMIN_BACKUP_DB."?todo=senddb");} else {?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_BACKUP_DB;?>" name="backup">
<input type="hidden" name="todo" value="backup">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Backup database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
        <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Here you can backup your database.<br>We encourage you to make database backup's periodically, the loss will not be so big when something happen to the database.<br>A good option is to name your backup file in a format like this: mm-dd-yy-dbname.sql. This is automatically suggested by Internet Explorer, for other browsers you must introduce the filename.<br>Today suggested filename is : <?php echo date('m-d-Y')."-".((ADMIN_SAFE_MODE == "yes")?"DATABASENAME":DB_DATABASE).".sql";?>.<br>Also if you can store your backup files in the same directory, to be easy to find the files when you want to restore your database.</b></font></td>
</tr>
<tr>
        <td align="right"><input type="submit" name="save" value="Backup"></td>
</tr>
</table>

</td></tr></table>
</form>
<?php }?>