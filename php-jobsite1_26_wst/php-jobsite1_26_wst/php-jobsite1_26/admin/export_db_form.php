<?php
if ($HTTP_POST_VARS['todo'] == "sel_db") {
    ?>
    <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EXPORT_DB;?>" name="sel_fields">
    <input type="hidden" name="todo" value="sel_fields">
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
     <tr>
         <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Select Database to export</b></font></td>
     </tr>
     <tr>
       <td bgcolor="#000000">
    <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <tr>
            <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Select Fields from Database:</b></font></td>
    </tr>

    <?php
    for($i=0; $i<sizeof($HTTP_POST_VARS['phpjob_db']); $i++) {
            include(DIR_ADMIN.$HTTP_POST_VARS['phpjob_db'][$i].".cfg.php");
            ?>
            <input type="hidden" name="phpjob_db[]" value="<?php echo $HTTP_POST_VARS['phpjob_db'][$i];?>">
            <tr><td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo $db_name;?></b></td></tr>
            <?php
            reset($fields);
            while (list($h, $v) = each($fields)) {
                echo "<tr><td width=\"30%\">&nbsp;</td><td width=\"70%\" nowrap><input type=\"checkbox\" name=\"".$HTTP_POST_VARS['phpjob_db'][$i]."[]\" value=\"".$h."\" checked>&nbsp;<b>".$v[1]."</b> (e.g. ".$v[2].")</td></tr>\n";
            }
    }
    ?>
    <tr>
        <td align="center" colspan="2">&nbsp;</td>
    </tr>
     <tr>
        <td colspan="2"><b><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">Show Fields name on the first line of the exported file?</b></font>&nbsp;&nbsp;<input type="radio" class="radio" name="show_fields" value="Y" checked><b>Yes</b>&nbsp;<input type="radio" class="radio" name="show_fields" value="N"><b>No</b></td>
    </tr>
    <tr>
        <td colspan="2"><b><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">Export file type:</b></font></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;&nbsp;<input type="radio" class="radio" name="file_type" value="csv" checked><b>CSV</b> (Ms Excell compatible)</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;&nbsp;<input type="radio" class="radio" name="file_type" value="text"><b>Text file</b></td>
    </tr>
    <tr>
        <td width="15%">&nbsp;</td>
        <td align="left" width="85%">Fields delimitated by:&nbsp;&nbsp;<select name="delim"><option value=""></option><option value="comma">Comma (,)</option><option value="tab">Tab</option></select>&nbsp;<font size="1">e.g. John Doe, johndoe@whatever.com</font></td>
    </tr>
    <tr>
        <td width="15%">&nbsp;</td>
        <td align="left" width="85%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or enter yours:&nbsp;&nbsp;<input type="text" name="delimy" value="" size="3"></td>
    </tr>
    <tr>
        <td width="15%">&nbsp;</td>
        <td align="left" width="85%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields enclosed by:&nbsp;&nbsp;<input type="text" name="enclosed" value="&#034;" size="2">&nbsp;<font size="1">e.g. "John Doe","johndoe@whatever.com"</font></td>
    </tr>
   
    <tr>
        <td align="center" colspan="2"><input type="submit" name="save" value="Next"></td>
    </tr>
    </table>
    </td></tr></table>
    </form>
    <?php
}
else {?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EXPORT_DB;?>" name="sel_db" onSubmit="var dbnames = document.sel_db['phpjob_db[]']; var go=0; if(dbnames.length>0) {for (var i=0; i<dbnames.length; i++) { if(dbnames[i].checked ==true) { go = 1;} } } else { if(dbnames.checked == true) {go = 1;} else{ go =0;} } if( go == 0) { alert('Please select a database to export. '); return false;} else{ return true;}">
<input type="hidden" name="todo" value="sel_db">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Select Database to export</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
        <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Select Database to export:</b></font></td>
</tr>
<tr>
        <td width="30%">&nbsp;</td>
        <td width="70%"><input type="checkbox" name="phpjob_db[]" value="<?php echo $bx_table_prefix."_companies";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Employers</b></font></td>
</tr>
<tr>
        <td width="30%">&nbsp;</td>
        <td width="70%"><input type="checkbox" name="phpjob_db[]" value="<?php echo $bx_table_prefix."_persons";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Jobseekers</b></font></td>
</tr>
<tr>
        <td width="30%">&nbsp;</td>
        <td width="70%"><input type="checkbox" name="phpjob_db[]" value="<?php echo $bx_table_prefix."_jobs";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Jobs</b></font></td>
</tr>
<tr>
        <td width="30%">&nbsp;</td>
        <td width="70%"><input type="checkbox" name="phpjob_db[]" value="<?php echo $bx_table_prefix."_resumes";?>"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Resumes</b></font></td>
</tr>
<tr>
        <td align="center" colspan="2">&nbsp;</td>
</tr>
<tr>
        <td align="center" colspan="2"><input type="submit" name="save" value="Next"></td>
</tr>
</table>

</td></tr></table>
</form>
<?php }?>