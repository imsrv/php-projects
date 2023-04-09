<?php 
function bx_js_prepare($l_str){
    $l_str = eregi_replace("\015\012|\015|\012", ' ', $l_str);
    $l_str = eregi_replace("'","&#039;",$l_str);
    return $l_str;
}
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Cross Network Options</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
    <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>With Cross Network Options you can allow other webmasters, sites, companies to display the latest jobs, featured jobs, featured companies or a specific company jobs from your jobsite!</b></font></td>
    </tr>
    <tr>
        <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Below is the "HTML CODE" which need to be inserted in a html page on the other party website!</b></font></td>
    </tr>
    <tr>
        <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>There is a Preview Button for online display, and a Customize button for design/layout customization!</b></font></td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td colspan="2"><form method="post" target="preview" action="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>" name="ljobs" onSubmit="df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=550,height=420,screenX=50,screenY=100');df.window.focus(); return true;">
    <input type="hidden" name="todo" value="preview">
    <input type="hidden" name="type" value="Latest Jobs"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Latest Jobs on <?php echo SITE_TITLE;?>:</b></font></td>
    </tr>
    <tr>
        <TD align="right" valign="top"><B>HTML CODE:</B></TD>
        <td align="left"><textarea name="html_code" rows="5" cols="60"><script language="Javascript" src="<?php echo HTTP_SERVER;?>latest_jobs.php"></script></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="go" value="Preview">&nbsp;&nbsp;<input type="button" name="customize" value="Customize" onClick="df=open('<?php echo HTTP_SERVER_ADMIN."cross_network.php?todo=customize&type=ljobs";?>','customize','scrollbars=no,menubar=no,resizable=0,location=no,width=640,height=500,left=0,top=0,screenX=0,screenY=0');df.window.focus(); return true;"></td>
    </form>
    </tr>
    <tr>
        <td colspan="2"><form method="post" target="preview" action="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>" name="fjobs" onSubmit="df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=550,height=420,screenX=50,screenY=100');df.window.focus(); return true;">
    <input type="hidden" name="todo" value="preview">
    <input type="hidden" name="type" value="Featured Jobs"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Featured Jobs on <?php echo SITE_TITLE;?>:</b></font></td>
    </tr>
    <tr>
        <TD align="right" valign="top"><B>HTML CODE:</B></TD>
        <td align="left"><textarea name="html_code" rows="5" cols="60"><script language="Javascript" src="<?php echo HTTP_SERVER;?>featured_jobs.php"></script></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="go" value="Preview">&nbsp;&nbsp;<input type="button" name="customize" value="Customize" onClick="df=open('<?php echo HTTP_SERVER_ADMIN."cross_network.php?todo=customize&type=fjobs";?>','customize','scrollbars=no,menubar=no,resizable=0,location=no,width=640,height=500,left=0,top=0,screenX=0,screenY=0');df.window.focus(); return true;"></td>
    </form>
    </tr>
    <tr>
        <td colspan="2"><form method="post" target="preview" action="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>" name="fcomp" onSubmit="df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=550,height=420,screenX=50,screenY=100');df.window.focus(); return true;">
    <input type="hidden" name="todo" value="preview">
    <input type="hidden" name="type" value="Featured Companies"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Featured Companies on <?php echo SITE_TITLE;?>:</b></font></td>
    </tr>
    <tr>
        <TD align="right" valign="top"><B>HTML CODE:</B></TD>
        <td align="left"><textarea name="html_code" rows="5" cols="60"><script language="Javascript" src="<?php echo HTTP_SERVER;?>featured_companies.php"></script></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="go" value="Preview">&nbsp;&nbsp;<input type="button" name="customize" value="Customize" onClick="df=open('<?php echo HTTP_SERVER_ADMIN."cross_network.php?todo=customize&type=fcomp";?>','customize','scrollbars=no,menubar=no,resizable=0,location=no,width=640,height=500,left=0,top=0,screenX=0,screenY=0');df.window.focus(); return true;"></td>
    </form>
    </tr>
    <tr>
        <td colspan="2"><form method="post" target="preview" action="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>" name="compjobs" onSubmit="df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=550,height=420,screenX=50,screenY=100');df.window.focus(); return true;">
    <input type="hidden" name="todo" value="preview">
    <input type="hidden" name="type" value="Company Jobs"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Company Jobs on <?php echo SITE_TITLE;?>:</b></font></td>
    </tr>
    <tr>
     <TD align="right">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B>Select Company:</B></FONT>
      </TD>
     <TD align="left">
           <SELECT name="compid" size="1" onChange="document.compjobs.html_code.value='<script language=&#034;Javascript&#034; src=&#034;<?php echo bx_js_prepare(HTTP_SERVER);?>company_jobs.php?company_id='+this.options[this.selectedIndex].value+'&#034;></script>';">
           <option value="">---Select Company---</option>
        <?php
        $employer_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_companies");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($employer_result=bx_db_fetch_array($employer_query))
        {
        echo '<option value="'.$employer_result['compid'].'">'.$employer_result['company'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </TR>
    <tr>
        <TD align="right" valign="top"><B>HTML CODE:</B></TD>
        <td align="left"><textarea name="html_code" rows="5" cols="60"></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="go" value="Preview">&nbsp;&nbsp;<input type="button" name="customize" value="Customize" onClick="df=open('<?php echo HTTP_SERVER_ADMIN."cross_network.php?todo=customize&type=compjobs&compid=";?>'+document.compjobs.compid.value,'customize','scrollbars=no,menubar=no,resizable=0,location=no,width=640,height=500,left=0,top=0,screenX=0,screenY=0');df.window.focus(); return true;"></td>
    </form>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td colspan="2"><br></td>
    </tr>
    </table>
</td></tr></table>