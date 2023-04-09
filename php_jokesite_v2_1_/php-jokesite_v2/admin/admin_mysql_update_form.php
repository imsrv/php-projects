<?
include(DIR_SERVER_ADMIN. 'admin_mail_lng.php');
function split_sql(&$ret, $sql)
{
    $sql          = trim($sql);
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $time0        = time();
    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];
        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $ret[] = $sql;
                    return TRUE;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)
        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $ret[]      = substr($sql, 0, $i);
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return TRUE;
            }
        } // end else if (is delimiter)

        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $string_start = $char;
        } // end else if (is start of string)

        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#'
                 || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                              ? strpos(' ' . $sql, "\012", $i+2)
                              : strpos(' ' . $sql, "\015", $i+2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    $ret[]    = trim(substr($sql, 0, $start_of_comment));
                }
                return TRUE;
            } else {
                $sql          = substr($sql, 0, $start_of_comment)
                              . ltrim(substr($sql, $end_of_comment));
                $sql_len      = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment)
      
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
        $ret[] = $sql;
    }
    return $ret;
}

if ($HTTP_POST_VARS['todo'] == "update") {
if(ADMIN_SAFE_MODE == "yes") {
        $error_title = "Updating database!";
        bx_admin_error(TEXT_SAFE_MODE_ALERT);
    }//end if ADMIN_SAFE_MODE == yes
    else {
        @set_time_limit(0);
        ?>
        <table width="100%" cellspacing="0" cellpadding="1" border="0">
         <tr>
             <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Update database</b></font></td>
         </tr>
         <tr>
           <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
            <table border="0" width="100%" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" cellpadding="2" align="center">
            <?
        $have_sql = false;
        if(!empty($HTTP_POST_FILES['update_file']['tmp_name']) && $HTTP_POST_FILES['update_file']['tmp_name'] != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($HTTP_POST_FILES['update_file']['tmp_name'])))
        {
            $sql_query = fread(fopen($HTTP_POST_FILES['update_file']['tmp_name'], "r"), filesize($HTTP_POST_FILES['update_file']['tmp_name']));
            $have_sql = true;
        }
        else if (!empty($HTTP_POST_VARS['update_sql'])) {
            $sql_query = $HTTP_POST_VARS['update_sql'];
            $have_sql = true;
        }
        else {
            $have_sql = false;
        }
        if ($have_sql) {
                $my_pieces  = split_sql($pieces, $sql_query);
                if (count($pieces) == 1 && !empty($pieces[0])) {
                    $pieces[0] = trim($pieces[0]);
                    $result = mysql_query ($pieces[0]) or die("<tr><td><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"#FF0000\">Unable to execute query: ".$pieces[0]."<br>Please check if you have the original file or the original query...</font></td></tr>");
                }
                else {
                    for ($i=0; $i<count($pieces); $i++) {
                        $pieces[$i] = trim($pieces[$i]);
                        if(!empty($pieces[$i]) && $pieces[$i] != "#") {
                            $result = mysql_query ($pieces[$i]) or die("<tr><td><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"#FF0000\">Unable to execute query: ".$pieces[$i]."<br>Please check if you have the original file or the original query...</font></td></tr>");
                        }
                    }
                }  
              
                echo "<tr><td align=\"center\">&nbsp;</td></tr>";
                echo "<tr><td align=\"center\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><b>Success...</b></font></td></tr>";
                echo "<tr><td align=\"center\">&nbsp;</td></tr>";
                echo "<tr><td align=\"center\"><a href=\"../index.php\">Go and check out!!!</a></td></tr>";
            }
            else {
              echo "<tr><td align=\"center\">&nbsp;</td></tr>";
              echo "<tr><td align=\"center\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><b>Can read the uploaded file, or invalid name, or nothing to update...<br>Please try again...</b></font></td></tr>";
              echo "<tr><td align=\"center\">&nbsp;</td></tr>";
              echo "<tr><td><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><a href=\"javascript: history.go(-1);\" onmouseover=\"window.status='Back'; return true;\" onmouseout=\"window.status=''; return true;\">Back</a></font></td></tr>";
            }
        ?>
        </table>
        </td>
        </tr>
        </table>
        <?
    }    
}
else {
?>
<form method="post" enctype="multipart/form-data" action="<?=HTTP_SERVER_ADMIN."admin_mysql_update.php"?>" name="upload">
<input type="hidden" name="todo" value="update">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
 <tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Update database</b></font></td>
 </tr>
 <tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
        <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_UPLOAD_UPDATE_FILE?>:</b></font>  <input type="file" name="update_file"></td>
</tr>
<tr>
        <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_UPDATE_SQL_QUERY?>:</b></font></td>
</tr>
<tr>
        <td align="center"><textarea rows="5" cols="50" name="update_sql"></textarea></td>
</tr>
<tr>
        <td align="center"><input type="submit" name="save" value="Update"></td>
</tr>
</table>

</td></tr></table>
</form>
<?  
}
?>