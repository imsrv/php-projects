<?
postvars($HTTP_POST_VARS, "<b>\$HTTP_POST_VARS[ ]</b>");exit;

include(DIR_SERVER_ADMIN. 'admin_mail_lng.php');
if ($HTTP_POST_VARS['todo']=="upload") {
    if(ADMIN_SAFE_MODE == "yes") {
        $error_title = "restoring database";
        bx_admin_error(TEXT_SAFE_MODE_ALERT);
    }//end if ADMIN_SAFE_MODE == yes
    else {
        @set_time_limit(0);
        
                function split_sql($sql)
                {
                    $sql = trim($sql);
                    $sql = ereg_replace("#[^\n]*\n", "", $sql);
                    $buffer = array();
                    $ret = array();
                    $in_string = false;
                
                    for($i=0; $i<strlen($sql)-1; $i++)
                    {
                         if($sql[$i] == ";" && !$in_string)
                        {
                            $ret[] = substr($sql, 0, $i);
                            $sql = substr($sql, $i + 1);
                            $i = 0;
                        }
                
                        if($in_string && ($sql[$i] == $in_string) && $buffer[0] != "\\")
                        {
                             $in_string = false;
                        }
                        elseif(!$in_string && ($sql[$i] == "\"" || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\"))
                        {
                             $in_string = $sql[$i];
                        }
                        if(isset($buffer[1]))
                        {
                            $buffer[0] = $buffer[1];
                        }
                        $buffer[1] = $sql[$i];
                     }
                
                    if(!empty($sql))
                    {
                        $ret[] = $sql;
                    }
                
                    return($ret);
                }
                
        if(!empty($HTTP_POST_FILES['restore_file']['tmp_name']) && $HTTP_POST_FILES['restore_file']['tmp_name']!= "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($HTTP_POST_FILES['restore_file']['tmp_name'])))
        {
            $sql_query = fread(fopen($HTTP_POST_FILES['restore_file']['tmp_name'], "r"), filesize($HTTP_POST_FILES['restore_file']['tmp_name']));
        }
        else {
              echo "<center><b>Can read the uploaded file, or invalid name...Please try again...</b></center>";
        }
        $pieces=explode("#%%\n",$sql_query);
        if (count($pieces) == 1 && !empty($pieces[0])) {
            $sql_query = eregi_replace(";$","",trim($pieces[0]));
            $result = mysql_db_query (DB_DATABASE, trim($pieces[0])) or die("Unable to execute query: ".$pieces[0]);
            exit;
        }
        for ($i=0; $i<count($pieces); $i++)
        {
            $pieces[$i] = eregi_replace(";$","",trim($pieces[$i]));
            if(!empty($pieces[$i]) && $pieces[$i] != "#")
            {
                $result = mysql_db_query (DB_DATABASE, $pieces[$i]) or die("Unable to execute query: ".$pieces[$i]);
            }
        }
        $sql_query = stripslashes($sql_query);
        echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">\n";
        echo " <tr>\n";
        echo "     <td bgcolor=\"".TABLE_HEAD_BGCOLOR."\" align=\"center\"><font face=\"Verdana, Arial\" size=\"2\" color=\"white\"><b>Backup database</b></font></td>\n";
        echo " </tr>\n";
        echo " <tr>\n";
        echo "   <td bgcolor=\"".TABLE_HEAD_BGCOLOR."\">\n";
        echo "<TABLE border=\"0\" cellpadding=\"4\" cellspacing=\"0\" bgcolor=\"".INSIDE_TABLE_BG_COLOR."\" width=\"100%\">\n";
        echo "<tr>\n";
        echo "        <td align=\"center\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><b>Successful database restore...</b></font></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "        <td align=\"center\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><a href=\"".HTTP_SERVER_ADMIN."\">Home</a></font></td>\n";
        echo "</tr>\n";
        echo "</table>";
        echo "</td></tr>\n";
        echo "</table>";
     }   
} //end if ($todo == "upload")
else {
?>
<form method="post" enctype="multipart/form-data" action="<?=HTTP_SERVER_ADMIN."admin_restore_db.php"?>" name="upload">
<input type="hidden" name="todo" value="upload">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
 <tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Restore database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
        <td align="right"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_UPLOAD_BACKUP_FILE?>:</b></font>  <input type="file" name="restore_file"></td>
</tr>
<tr>
        <td align="right"><input type="submit" name="save" value="Upload"></td>
</tr>
</table>

</td></tr></table>
</form>
<?
} //end else if ($todo=="upload")
?>
