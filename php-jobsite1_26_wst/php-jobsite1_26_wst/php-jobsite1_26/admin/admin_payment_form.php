<?php include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);?>
<?php
if ($HTTP_POST_VARS['todo']=="save") {
      if(ADMIN_SAFE_MODE == "yes") {
            $error_title = "updateing payment settings!";
            bx_admin_error(TEXT_SAFE_MODE_ALERT);
      }//end if ADMIN_SAFE_MODE == yes
      else {
            $towrite = '';
            for ($i=0;$i<count($HTTP_POST_VARS['inputs']) ;$i++ ) {
                if ($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]) {
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = bx_stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                    if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) {
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'\.$", "\\\\'.", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'[\.]", "'.", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("^\.\\\\'", "%[wqt]%", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\.\\\\'", ".'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("%\[wqt\]%", ".\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);  
                    }
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\", "\\\\", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                    $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'", "'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                    $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".preg_replace("/(\015\012)|(\015)|(\012)/","'.\"\\n\".'",$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]])."');\n";
                }
                else {
                    if ( is_string($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]])) {
                        $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = bx_stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        if (eregi(".*'.*", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]], $regs)) 	{
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("'", "\\'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\", "\\\\", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                            $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]] = eregi_replace("\\\\'", "'", $HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]);
                        }
                    $towrite .= "define('".$HTTP_POST_VARS['inputs'][$i]."','".$HTTP_POST_VARS[$HTTP_POST_VARS['inputs'][$i]]."');\n";
                    }
                    else {
                        $towrite .= "".bx_stripslashes($HTTP_POST_VARS['inputs'][$i])."\n";
                    }
                }
            }
            $fp=@fopen(DIR_SERVER_ROOT."cc_payment_settings.php","w");
            @fwrite($fp,"<?php\n");
            @fwrite($fp, eregi_replace("\n$","",$towrite));
            @fwrite($fp,"\n?>");
            @fclose($fp);
            ?>
        <table width="100%" cellspacing="0" cellpadding="2" border="0">
         <tr>
             <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Fee/Payment settings</b></font></td>
         </tr>
         <tr>
           <td bgcolor="#000000">
             <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
                    <tr>
                        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Successfull update.</b></font></td>
                    </tr>
                    <tr>
                        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>">Home</a></font></td>
                    </tr>
             </table>
          </td>
         </tr>
        </table>
    <?php
    }
}
else {
$fp=fopen(DIR_SERVER_ROOT."cc_payment_settings.php","r");
$perms=substr(base_convert(@fileperms(DIR_SERVER_ROOT."cc_payment_settings.php"), 10, 8),3);
if ($perms==666 || $perms==777) {
   $perms_error=false;
}
else {
   $title="File Permission Error - cc_payment_settings.php";
   $content="<font color=red><b>The permission for this file is invalid (".$perms.").<br>Valid permission for the file is: <b>777</b>.</font><br> The changes to the file will not be saved properly(will be lost)!<br>Please change the file permission for ".DIR_SERVER_ROOT."cc_payment_settings.php"." to 777.";
   $perms_error=true;
}
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_PAYMENT;?>" name="settings">
<input type="hidden" name="todo" value="save">
<?php if($perms_error){?>
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
<?php }?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Fee/Payment Settings</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%" align="center" class="reg">
<?php 
if ($perms_error) {
   ?>
   <tr><td colspan="2"><font color="#FF0000" size="2"><b>ERROR: File Permission Error</b>...<a href="javascript: ;" onClick="err_pop('<?php echo $title;?>','<?php echo eregi_replace("'","\'",$content);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></font></td></tr>
   <?
}
include("phpjob_payment.cfg.php");
$i=0;
while (!feof($fp)) {
   $str=trim(fgets($fp, 20000));
   if (!empty($str) && ($str != "\r\n") && ($str != "\n") && ($str != "\r")) {
	    for ( $j=0 ; $j<sizeof($fields[$i]["comment"]); $j++) {
            echo "<tr><td colspan=\"2\" align=\"center\"><font size=\"2\" face=\"arial\" color=\"#FF0000\"><b>".ucfirst($fields[$i]["comment"][$j])."</b></font></td></tr>";
        }
        $field_name = $fields[$i]["name"];
        if (eregi("^define\(['](.*)['|.?],['|.?| ](.*)\)",htmlspecialchars($str),$regexp)) {
            echo "<tr>";
                $regexp[2] = eregi_replace("'$", "", $regexp[2]);
				if ($field_name) {
					if (eregi("\(radio (.*)\)(.*)",$field_name,$regcomm)) {
                        echo "<td align=\"right\">".$regcomm[2]." </td>";
                        $radio = true;
                    }
                    else if (eregi("\(select (.*)\)(.*)",$field_name,$regcomm)) {
                        echo "<td align=\"right\" valign=\"top\">".$regcomm[2]." </td>\n";
                        $select = true;
                    }
                    else {
                        echo "<td align=\"right\" valign=\"top\">".$field_name." = </td>";    
                    }
				}
				else {
                       echo "<td align=\"right\" nowrap valign=\"top\">".$regexp[1]." = </td>";	
				}
                if ($radio) {
                            echo "<td>";
                            $radio_values = split(",",trim($regcomm[1]));
                            for ($j=0;$j<sizeof($radio_values);$j++) {
                                if (eregi_replace("'","",$regexp[2]) == $radio_values[$j]) {
                                    $checked = " checked";
                                }
                                else {
                                    $checked = "";
                                }
                                echo "<input type=\"radio\" class=\"radio\" name=\"".$regexp[1]."\" value=\"".$radio_values[$j]."\"".$checked.">".$radio_values[$j]."";
                            }
                            $radio = false;
                }
                else if ($select) {
                            echo "<td>";
                            $select_values = split(",",trim($regcomm[1]));
                            echo "<select name=\"".$regexp[1]."\">";
                            for ($j=0;$j<sizeof($select_values);$j++) {
                                if (eregi_replace("'","",$regexp[2]) == $select_values[$j]) {
                                    $checked = " selected";
                                }
                                else {
                                    $checked = "";
                                }
                                echo "<option value=\"".$select_values[$j]."\"".$checked.">".$select_values[$j]."</option>";
                            }
                            echo "</select>";
                            $select = false;
                }
                else {
                    if (strlen($regexp[2])<30) {
                            echo "<td>";
                            $regexp[2] = eregi_replace("\\\\'","'",$regexp[2]);
                            $regexp[2] = eregi_replace("\\\\\\\\","\\",$regexp[2]);
                            echo "<input type=\"text\" name=\"".$regexp[1]."\" value=\"".$regexp[2]."\">";
                    }
                    else {
                            echo "<td>";
                            $regexp[2] = eregi_replace("\\\\'","'",$regexp[2]);
                            $regexp[2] = eregi_replace("\\\\\\\\","\\",$regexp[2]);
                            echo "<input type=\"text\" name=\"".$regexp[1]."\" value=\"".$regexp[2]."\" size=\"".(strlen($regexp[2])+5)."\">";
                    }
                }
				echo "<input type=\"hidden\" name=\"inputs[]\" value=\"".$regexp[1]."\"></td>\n";
                echo "</tr>";
        }
		else {
		   if ($str == "<?php" || $str == "?>") {
		   }
		   else {
				if (strlen($str) < 30) {
					echo "<tr><td colspan=\"2\" align=\"center\"><input type=\"text\" name=\"inputs[]\" value=\"".htmlspecialchars($str)."\" size=\"80\"></td></tr>";
				}
				else {
					echo "<tr><td colspan=\"2\" align=\"center\"><textarea name=\"inputs[]\" rows=\"4\" cols=\"60\">".htmlspecialchars($str)."</textarea></td></tr>";
				}
			}
		}
   }
   $i++;
}
fclose($fp);
?>
<tr>
        <td colspan="3" align="right"><input type="submit" name="save" value="<?php echo TEXT_BUTTON_SAVE;?>"<?php if($perms_error){ echo " onClick=\"return confirm('Invalid File Permission (".$perms.") for ".eregi_replace("'","\'","cc_payment_settings.php")."\\nChanges will not be saved!\\nClick on Ok if you still want to continue, Cancel otherwise!');\"";}?>></td>
</tr>
</table>
</td></tr></table>
</form>
<?php
}
?>