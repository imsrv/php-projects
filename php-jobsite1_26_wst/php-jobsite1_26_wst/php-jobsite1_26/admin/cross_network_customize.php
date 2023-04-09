<?php 
function bx_js_prepare($l_str){
    $l_str = eregi_replace("\015\012|\015|\012", ' ', $l_str);
    $l_str = eregi_replace("'","&#039;",$l_str);
    return $l_str;
}
function bx_js_quote($l_str){
    $l_str = eregi_replace('"',"&#034;",$l_str);
    return $l_str;
}
include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);
?>
<form method="post" target="preview"  name="customize" action="<?php echo HTTP_SERVER_ADMIN."cross_network.php";?>" onSubmit="make_html_code();df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=550,height=420,screenX=50,screenY=100');df.window.focus(); return true;">
      <input type="hidden" name="html_code" value="">
      <input type="hidden" name="todo" value="preview">
      <?php if($HTTP_GET_VARS['type']=="ljobs"){?>
      <input type="hidden" name="type" value="Latest Jobs">
      <?php }elseif($HTTP_GET_VARS['type']=="fjobs"){?>
      <input type="hidden" name="type" value="Featured Jobs">            
      <?php }elseif($HTTP_GET_VARS['type']=="fcomp"){?>
      <input type="hidden" name="type" value="Featured Companies">            
      <?php }elseif($HTTP_GET_VARS['type']=="compjobs"){?>
      <input type="hidden" name="type" value="Company Jobs">
      <?php }?>
      <table align="center" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
          <td align="right"><b>Title:</b></td>
          <td><input type="text" name="pjs_title" size="50" value="<?php
      if ($HTTP_GET_VARS['type']=="ljobs") {
          echo bx_js_quote("<b>".bx_js_prepare(TEXT_LATEST_JOBS)." - <a href=\"".bx_js_prepare(HTTP_SERVER)."\">".bx_js_prepare(SITE_NAME)."</a></b>");
      }  
      elseif ($HTTP_GET_VARS['type']=="fjobs") {
          echo bx_js_quote("<b>".bx_js_prepare(ucfirst(TEXT_FEATURED_JOBS))." - <a href=\"".bx_js_prepare(HTTP_SERVER)."\">".bx_js_prepare(SITE_NAME)."</a></b>");
      }
      elseif ($HTTP_GET_VARS['type']=="fcomp") {
          echo bx_js_quote("<b>".bx_js_prepare(TEXT_FEATURED_COMPANIES)." - <a href=\"".bx_js_prepare(HTTP_SERVER)."\">".bx_js_prepare(SITE_NAME)."</a></b>");
      }
      elseif ($HTTP_GET_VARS['type']=="compjobs") {
          if ($HTTP_GET_VARS['compid']) {
              $company_query=bx_db_query("SELECT company FROM ".$bx_table_prefix."_companies where compid='".$HTTP_GET_VARS['compid']."'");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
              $company_result=bx_db_fetch_array($company_query);
          }
          echo bx_js_quote("<b>".bx_js_prepare($company_result['company']." ".TEXT_COMPANY." ".TEXT_JOBS)." - <a href=\"".bx_js_prepare(HTTP_SERVER)."\">".bx_js_prepare(SITE_NAME)."</a></b>");
      }
      ?>"></td>
          <td>&nbsp;</td>
      </tr>
      <tr>
          <td align="right"><b>Title BGColor:</b></td>
          <td><input type="text" name="pjs_titleBGColor" size="10" value="<?php echo TABLE_BGCOLOR;?>"></td>
          <td><table id="id1" bgcolor="<?php echo TABLE_BGCOLOR;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_titleBGColor,'value','id1', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
      <tr>
          <td align="right"><b>Title Font definition:</b></td>
          <td><input type="text" name="pjs_bigFont" size="40" value="<?php echo bx_js_quote("<font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\">");?>"></td>
          <td>&nbsp;</td>
      </tr>
      <?php if($HTTP_GET_VARS['type']=="fcomp"){?>
     <tr>
          <td align="right"><b>Table BGColor:</b></td>
          <td><input type="text" name="pjs_tableBGColor" size="10" value="<?php echo TABLE_FEATURED_BGCOLOR;?>"></td>
          <td><table id="id6" bgcolor="<?php echo TABLE_FEATURED_BGCOLOR;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_tableBGColor,'value','id6', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
      <?php }?>
      <?php if($HTTP_GET_VARS['type']!="fcomp"){?>
      <tr>
          <td align="right"><b>Header Font definition:</b></td>
          <td><input type="text" name="pjs_headerFont" size="40" value="<?php echo bx_js_quote("<font face=\"".DISPLAY_TEXT_FONT_FACE."\" size=\"".DISPLAY_TEXT_FONT_SIZE."\" color=\"".DISPLAY_TEXT_FONT_COLOR."\">");?>"></td>
          <td>&nbsp;</td>
      </tr>
      <tr>
          <td align="right"><b>Header BGColor:</b></td>
          <td><input type="text" name="pjs_headerBGColor" size="10" value="<?php echo LIST_HEADER_COLOR;?>"></td>
          <td><table id="id2" bgcolor="<?php echo LIST_HEADER_COLOR;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_headerBGColor,'value','id2', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
      <tr>
          <td align="right"><b>Table Border Color:</b></td>
          <td><input type="text" name="pjs_borderColor" size="10" value="<?php echo LIST_BORDER_COLOR;?>"></td>
          <td><table id="id3" bgcolor="<?php echo LIST_BORDER_COLOR;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_borderColor,'value','id3', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
      <tr>
          <td align="right"><b>Table First Line/Row BGColor:</b></td>
          <td><input type="text" name="pjs_rowBGColor1" size="10" value="<?php echo DISPLAY_LINE_BGCOLOR_FIRST;?>"></td>
          <td><table id="id4" bgcolor="<?php echo DISPLAY_LINE_BGCOLOR_FIRST;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_rowBGColor1,'value','id4', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
       <tr>
          <td align="right"><b>Table Second Line/Row BGColor:</b></td>
          <td><input type="text" name="pjs_rowBGColor2" size="10" value="<?php echo DISPLAY_LINE_BGCOLOR_SECOND;?>"></td>
          <td><table id="id5" bgcolor="<?php echo DISPLAY_LINE_BGCOLOR_SECOND;?>" border="1">
                <tr><td><span onmouseover="PcjsColorChooser(document.forms.customize.pjs_rowBGColor2,'value','id5', event)" style="cursor: hand">&nbsp;&nbsp;&nbsp;&nbsp;</span></td></tr>
                </table>
           </td>     
      </tr>
      <?php }?>
      <tr>
          <td align="right"><b>Link Style:</b></td>
          <td><input type="text" name="pjs_linkStyle" size="50" value="<?php echo bx_js_quote("style=\"color: #0000FF; font-size: 12px; font-weight: normal;\"");?>"></td>
          <td>&nbsp;</td>
      </tr>
      <?php if (MULTILANGUAGE_SUPPORT == "on") {?>
      <tr>
          <td align="right"><b>Language:</b></td>
          <td><select name="language" size="1">
          <?php
        $dirs = getFolders(DIR_LANGUAGES);  
        for ($i=0; $i<count($dirs); $i++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                   echo "<option value=\"".$dirs[$i]."\"";
                   if ($dirs[$i]==DEFAULT_LANGUAGE) {
                       echo " selected";
                   }
                   echo ">".$dirs[$i]."</option>";
           }
        }    
      ?></select></td>
          <td>&nbsp;</td>
      </tr>
      <?php }?>
      <tr>
          <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
          <td colspan="3" align="center"><input type="submit" name="save" value="Save" class="button" onClick="make_html_code(); return_and_close(); return false;">&nbsp;&nbsp;<input type="submit" name="preview" value="Preview" class="button"></td>
      </tr>
      </table>
      </form>
      <div id="PcjsPopup" style="position:absolute; left:118px; top:214px; width:312px; height:112px; z-index:20; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#0000CC" style="border: 1px solid #D6D6CE">
<tr><td style="border: 1px solid #848484"><form name="pcjsform" action="layout.php" method="post">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#D6D6CE" style="border: 1px solid #FFFFFF">
       <tr>
                <td height="3" width="2"><img src="images/pix-t.gif" width="2" height="3"></td>
                <td height="25" valign="middle">
                        <div align="right" style="background:#0000CC; height: 20px;"><span style="position: relative; font-size: 14px; background: #DDDDDD; width: 15px; height: 15px; top: 1px; vertical-align: middle; text-align: center; border: 1px solid #000000"><a href="javascript: ;" onClick='PcjsInternalClosePopup()' class="closebutton">&nbsp;x&nbsp;</a></span></div>
                </td>
                <td height="3" width="2"><img src="images/pix-t.gif" width="2" height="3"></td>
        </tr>
        <tr>
                <td height="13" width="2"><img src="images/pix-t.gif" width="2" height="13"></td>
                <td align="center" bgcolor="#FFFFFF"><font face='Verdana, Arial, Helvetica, sans-serif' size="2"><b><font color="#0000CC" size="3">
Color Chooser</font><font color="#0000CC"></font></b></font><br></td>
                <td height="13" width="2"><img src="images/pix-t.gif" width="2" height="13"></td>
        </tr>
        <tr>
                <td height="81" width="2"><img src="images/pix-t.gif" width="2" height="3"></td>
                <td height="81" bgcolor="#FFFFFF">
                        <table border="0" cellpadding="1" cellspacing="0">
                                <tr>
                                        <td>
                                                <table border="0" cellspacing="1" align="center" cellpadding="1">
                                                <tr><td bgcolor="#000000" onClick="PcjsInternalSelectColor('#000000')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor="#000033"
                      onClick="PcjsInternalSelectColor('#000033')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#000066 onClick="PcjsInternalSelectColor('#000066')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor="#000099"
                      onClick="PcjsInternalSelectColor('#000099')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#0000CC onClick="PcjsInternalSelectColor('#0000CC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor="#0000FF"
                      onClick="PcjsInternalSelectColor('#0000FF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#003300 onClick="PcjsInternalSelectColor('#003300')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor="#003333"
                      onClick="PcjsInternalSelectColor('#003333')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#003366 onClick="PcjsInternalSelectColor('#003366')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#003399
                      onClick="PcjsInternalSelectColor('#003399')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#0033CC onClick="PcjsInternalSelectColor('#0033CC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#0033FF
                      onClick="PcjsInternalSelectColor('#0033FF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#006600 onClick="PcjsInternalSelectColor('#006600')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#006633
                      onClick="PcjsInternalSelectColor('#006633')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#006666 onClick="PcjsInternalSelectColor('#006666')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#006699
                      onClick="PcjsInternalSelectColor('#006699')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#0066CC onClick="PcjsInternalSelectColor('#0066CC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#0066FF
                      onClick="PcjsInternalSelectColor('#0066FF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> </tr>
                      <tr> <td bgcolor=#009900 onClick="PcjsInternalSelectColor('#009900')"
                      width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#009933
                      onClick="PcjsInternalSelectColor('#009933')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#009966 onClick="PcjsInternalSelectColor('#009966')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#009999
                      onClick="PcjsInternalSelectColor('#009999')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#0099CC onClick="PcjsInternalSelectColor('#0099CC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#0099FF
                      onClick="PcjsInternalSelectColor('#0099FF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00CC00 onClick="PcjsInternalSelectColor('#00CC00')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00CC33
                      onClick="PcjsInternalSelectColor('#00CC33')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00CC66 onClick="PcjsInternalSelectColor('#00CC66')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00CC99
                      onClick="PcjsInternalSelectColor('#00CC99')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00CCCC onClick="PcjsInternalSelectColor('#00CCCC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00CCFF
                      onClick="PcjsInternalSelectColor('#00CCFF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00FF00 onClick="PcjsInternalSelectColor('#00FF00')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00FF33
                      onClick="PcjsInternalSelectColor('#00FF33')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00FF66 onClick="PcjsInternalSelectColor('#00FF66')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00FF99
                      onClick="PcjsInternalSelectColor('#00FF99')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#00FFCC onClick="PcjsInternalSelectColor('#00FFCC')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#00FFFF
                      onClick="PcjsInternalSelectColor('#00FFFF')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td></tr>
                      <tr> <td bgcolor=#330000
                      onClick="PcjsInternalSelectColor('#330000')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#330033 onClick="PcjsInternalSelectColor('#330033')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#330066
                      onClick="PcjsInternalSelectColor('#330066')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#330099 onClick="PcjsInternalSelectColor('#330099')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#3300CC
                      onClick="PcjsInternalSelectColor('#3300CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#3300FF onClick="PcjsInternalSelectColor('#3300FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#333300
                      onClick="PcjsInternalSelectColor('#333300')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#333333 onClick="PcjsInternalSelectColor('#333333')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#333366
                      onClick="PcjsInternalSelectColor('#333366')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#333399 onClick="PcjsInternalSelectColor('#333399')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#3333CC
                      onClick="PcjsInternalSelectColor('#3333CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#3333FF onClick="PcjsInternalSelectColor('#3333FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#336600
                      onClick="PcjsInternalSelectColor('#336600')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#336633 onClick="PcjsInternalSelectColor('#336633')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#336666
                      onClick="PcjsInternalSelectColor('#336666')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#336699 onClick="PcjsInternalSelectColor('#336699')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#3366CC
                      onClick="PcjsInternalSelectColor('#3366CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#3366FF onClick="PcjsInternalSelectColor('#3366FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr>
                       <td bgcolor=#339900
                      onClick="PcjsInternalSelectColor('#339900')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#339933 onClick="PcjsInternalSelectColor('#339933')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#339966
                      onClick="PcjsInternalSelectColor('#339966')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#339999 onClick="PcjsInternalSelectColor('#339999')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#3399CC
                      onClick="PcjsInternalSelectColor('#3399CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#3399FF onClick="PcjsInternalSelectColor('#3399FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33CC00
                      onClick="PcjsInternalSelectColor('#33CC00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33CC33 onClick="PcjsInternalSelectColor('#33CC33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33CC66
                      onClick="PcjsInternalSelectColor('#33CC66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33CC99 onClick="PcjsInternalSelectColor('#33CC99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33CCCC
                      onClick="PcjsInternalSelectColor('#33CCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33CCFF onClick="PcjsInternalSelectColor('#33CCFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33FF00
                      onClick="PcjsInternalSelectColor('#33FF00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33FF33 onClick="PcjsInternalSelectColor('#33FF33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33FF66
                      onClick="PcjsInternalSelectColor('#33FF66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33FF99 onClick="PcjsInternalSelectColor('#33FF99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#33FFCC
                      onClick="PcjsInternalSelectColor('#33FFCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#33FFFF onClick="PcjsInternalSelectColor('#33FFFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr> <td bgcolor=#660000
                      onClick="PcjsInternalSelectColor('#660000')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#660033 onClick="PcjsInternalSelectColor('#660033')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#660066
                      onClick="PcjsInternalSelectColor('#660066')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#660099 onClick="PcjsInternalSelectColor('#660099')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#6600CC
                      onClick="PcjsInternalSelectColor('#6600CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#6600FF onClick="PcjsInternalSelectColor('#6600FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#663300
                      onClick="PcjsInternalSelectColor('#663300')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#663333 onClick="PcjsInternalSelectColor('#663333')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#663366
                      onClick="PcjsInternalSelectColor('#663366')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#663399 onClick="PcjsInternalSelectColor('#663399')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#6633CC
                      onClick="PcjsInternalSelectColor('#6633CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#6633FF onClick="PcjsInternalSelectColor('#6633FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#666600
                      onClick="PcjsInternalSelectColor('#666600')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#666633 onClick="PcjsInternalSelectColor('#666633')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#666666
                      onClick="PcjsInternalSelectColor('#666666')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#666699 onClick="PcjsInternalSelectColor('#666699')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#6666CC
                      onClick="PcjsInternalSelectColor('#6666CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#6666FF onClick="PcjsInternalSelectColor('#6666FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr>
                      <td bgcolor=#669900
                      onClick="PcjsInternalSelectColor('#669900')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#669933 onClick="PcjsInternalSelectColor('#669933')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#669966
                      onClick="PcjsInternalSelectColor('#669966')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#669999 onClick="PcjsInternalSelectColor('#669999')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#6699CC
                      onClick="PcjsInternalSelectColor('#6699CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#6699FF onClick="PcjsInternalSelectColor('#6699FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66CC00
                      onClick="PcjsInternalSelectColor('#66CC00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66CC33 onClick="PcjsInternalSelectColor('#66CC33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66CC66
                      onClick="PcjsInternalSelectColor('#66CC66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66CC99 onClick="PcjsInternalSelectColor('#66CC99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66CCCC
                      onClick="PcjsInternalSelectColor('#66CCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66CCFF onClick="PcjsInternalSelectColor('#66CCFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66FF00
                      onClick="PcjsInternalSelectColor('#66FF00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66FF33 onClick="PcjsInternalSelectColor('#66FF33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66FF66
                      onClick="PcjsInternalSelectColor('#66FF66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66FF99 onClick="PcjsInternalSelectColor('#66FF99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#66FFCC
                      onClick="PcjsInternalSelectColor('#66FFCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#66FFFF onClick="PcjsInternalSelectColor('#66FFFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#990000
                      onClick="PcjsInternalSelectColor('#990000')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#990033 onClick="PcjsInternalSelectColor('#990033')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#990066
                      onClick="PcjsInternalSelectColor('#990066')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#990099 onClick="PcjsInternalSelectColor('#990099')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#9900CC
                      onClick="PcjsInternalSelectColor('#9900CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#9900FF onClick="PcjsInternalSelectColor('#9900FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#993300
                      onClick="PcjsInternalSelectColor('#993300')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#993333 onClick="PcjsInternalSelectColor('#993333')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#993366
                      onClick="PcjsInternalSelectColor('#993366')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#993399 onClick="PcjsInternalSelectColor('#993399')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#9933CC
                      onClick="PcjsInternalSelectColor('#9933CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#9933FF onClick="PcjsInternalSelectColor('#9933FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#996600
                      onClick="PcjsInternalSelectColor('#996600')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#996633 onClick="PcjsInternalSelectColor('#996633')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#996666
                      onClick="PcjsInternalSelectColor('#996666')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#996699 onClick="PcjsInternalSelectColor('#996699')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#9966CC
                      onClick="PcjsInternalSelectColor('#9966CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#9966FF onClick="PcjsInternalSelectColor('#9966FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#999900
                      onClick="PcjsInternalSelectColor('#999900')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#999933 onClick="PcjsInternalSelectColor('#999933')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#999966
                      onClick="PcjsInternalSelectColor('#999966')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#999999 onClick="PcjsInternalSelectColor('#999999')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#9999CC
                      onClick="PcjsInternalSelectColor('#9999CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#9999FF onClick="PcjsInternalSelectColor('#9999FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99CC00
                      onClick="PcjsInternalSelectColor('#99CC00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99CC33 onClick="PcjsInternalSelectColor('#99CC33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99CC66
                      onClick="PcjsInternalSelectColor('#99CC66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99CC99 onClick="PcjsInternalSelectColor('#99CC99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99CCCC
                      onClick="PcjsInternalSelectColor('#99CCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99CCFF onClick="PcjsInternalSelectColor('#99CCFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99FF00
                      onClick="PcjsInternalSelectColor('#99FF00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99FF33 onClick="PcjsInternalSelectColor('#99FF33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99FF66
                      onClick="PcjsInternalSelectColor('#99FF66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99FF99 onClick="PcjsInternalSelectColor('#99FF99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#99FFCC
                      onClick="PcjsInternalSelectColor('#99FFCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#99FFFF onClick="PcjsInternalSelectColor('#99FFFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#CC0000
                      onClick="PcjsInternalSelectColor('#CC0000')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC0033 onClick="PcjsInternalSelectColor('#CC0033')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC0066
                      onClick="PcjsInternalSelectColor('#CC0066')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC0099 onClick="PcjsInternalSelectColor('#CC0099')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC00CC
                      onClick="PcjsInternalSelectColor('#CC00CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC00FF onClick="PcjsInternalSelectColor('#CC00FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC3300
                      onClick="PcjsInternalSelectColor('#CC3300')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC3333 onClick="PcjsInternalSelectColor('#CC3333')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC3366
                      onClick="PcjsInternalSelectColor('#CC3366')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC3399 onClick="PcjsInternalSelectColor('#CC3399')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC33CC
                      onClick="PcjsInternalSelectColor('#CC33CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC33FF onClick="PcjsInternalSelectColor('#CC33FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC6600
                      onClick="PcjsInternalSelectColor('#CC6600')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC6633 onClick="PcjsInternalSelectColor('#CC6633')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC6666
                      onClick="PcjsInternalSelectColor('#CC6666')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC6699 onClick="PcjsInternalSelectColor('#CC6699')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC66CC
                      onClick="PcjsInternalSelectColor('#CC66CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC66FF onClick="PcjsInternalSelectColor('#CC66FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#CC9900
                      onClick="PcjsInternalSelectColor('#CC9900')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC9933 onClick="PcjsInternalSelectColor('#CC9933')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC9966
                      onClick="PcjsInternalSelectColor('#CC9966')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC9999 onClick="PcjsInternalSelectColor('#CC9999')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CC99CC
                      onClick="PcjsInternalSelectColor('#CC99CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CC99FF onClick="PcjsInternalSelectColor('#CC99FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCCC00
                      onClick="PcjsInternalSelectColor('#CCCC00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCCC33 onClick="PcjsInternalSelectColor('#CCCC33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCCC66
                      onClick="PcjsInternalSelectColor('#CCCC66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCCC99 onClick="PcjsInternalSelectColor('#CCCC99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCCCCC
                      onClick="PcjsInternalSelectColor('#CCCCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCCCFF onClick="PcjsInternalSelectColor('#CCCCFF')"
                      width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCFF00
                      onClick="PcjsInternalSelectColor('#CCFF00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCFF33 onClick="PcjsInternalSelectColor('#CCFF33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCFF66
                      onClick="PcjsInternalSelectColor('#CCFF66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCFF99 onClick="PcjsInternalSelectColor('#CCFF99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#CCFFCC
                      onClick="PcjsInternalSelectColor('#CCFFCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#CCFFFF onClick="PcjsInternalSelectColor('#CCFFFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#FF0000
                      onClick="PcjsInternalSelectColor('#FF0000')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF0033 onClick="PcjsInternalSelectColor('#FF0033')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF0066
                      onClick="PcjsInternalSelectColor('#FF0066')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF0099 onClick="PcjsInternalSelectColor('#FF0099')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF00CC
                      onClick="PcjsInternalSelectColor('#FF00CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF00FF onClick="PcjsInternalSelectColor('#FF00FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF3300
                      onClick="PcjsInternalSelectColor('#FF3300')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF3333 onClick="PcjsInternalSelectColor('#FF3333')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF3366
                      onClick="PcjsInternalSelectColor('#FF3366')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF3399 onClick="PcjsInternalSelectColor('#FF3399')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF33CC
                      onClick="PcjsInternalSelectColor('#FF33CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF33FF onClick="PcjsInternalSelectColor('#FF33FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF6600
                      onClick="PcjsInternalSelectColor('#FF6600')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF6633 onClick="PcjsInternalSelectColor('#FF6633')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF6666
                      onClick="PcjsInternalSelectColor('#FF6666')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF6699 onClick="PcjsInternalSelectColor('#FF6699')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF66CC
                      onClick="PcjsInternalSelectColor('#FF66CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF66FF onClick="PcjsInternalSelectColor('#FF66FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                      <tr><td bgcolor=#FF9900
                      onClick="PcjsInternalSelectColor('#FF9900')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF9933 onClick="PcjsInternalSelectColor('#FF9933')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF9966
                      onClick="PcjsInternalSelectColor('#FF9966')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF9999 onClick="PcjsInternalSelectColor('#FF9999')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FF99CC
                      onClick="PcjsInternalSelectColor('#FF99CC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FF99FF onClick="PcjsInternalSelectColor('#FF99FF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFCC00
                      onClick="PcjsInternalSelectColor('#FFCC00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFCC33 onClick="PcjsInternalSelectColor('#FFCC33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFCC66
                      onClick="PcjsInternalSelectColor('#FFCC66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFCC99 onClick="PcjsInternalSelectColor('#FFCC99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFCCCC
                      onClick="PcjsInternalSelectColor('#FFCCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFCCFF onClick="PcjsInternalSelectColor('#FFCCFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFFF00
                      onClick="PcjsInternalSelectColor('#FFFF00')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFFF33 onClick="PcjsInternalSelectColor('#FFFF33')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFFF66
                      onClick="PcjsInternalSelectColor('#FFFF66')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFFF99 onClick="PcjsInternalSelectColor('#FFFF99')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td> <td bgcolor=#FFFFCC
                      onClick="PcjsInternalSelectColor('#FFFFCC')" width=4 height="8"><img src="images/pix-t.gif" width="4"
                      height="8"></td> <td bgcolor=#FFFFFF onClick="PcjsInternalSelectColor('#FFFFFF')" width=4
                      height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                      </tr>
                                                <tr><td colspan=3>&nbsp;</td>
                                                <td bgcolor="#000000" onClick="PcjsInternalSelectColor('#000000')" width="4" height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#333333" onClick="PcjsInternalSelectColor('#333333')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#666666" onClick="PcjsInternalSelectColor('#666666')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#999999" onClick="PcjsInternalSelectColor('#999999')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#CCCCCC" onClick="PcjsInternalSelectColor('#CCCCCC')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#FFFFFF" onClick="PcjsInternalSelectColor('#FFFFFF')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#FF0000" onClick="PcjsInternalSelectColor('#FF0000')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#00FF00" onClick="PcjsInternalSelectColor('#00FF00')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#0000FF" onClick="PcjsInternalSelectColor('#0000FF')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#FFFF00" onClick="PcjsInternalSelectColor('#FFFF00')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#00FFFF" onClick="PcjsInternalSelectColor('#00FFFF')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td bgcolor="#FF00FF" onClick="PcjsInternalSelectColor('#FF00FF')" width=4 height="8"><img src="images/pix-t.gif" width="4" height="8"></td>
                                                <td colspan=3>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td colspan="18" align="center">
                                                                <table border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                                <td width="50%">
                                                                                                <font face='Verdana, Arial, Helvetica, sans-serif' size=2 color=#0000CC>Color : </font>
                                                                                                <input type="text" name="color" size="10" maxlength="8" onChange='makeChanges(0);' style="font-size: 10px;"></td>
                                                                                <td align="center" valign="middle">
                                                                                        <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                                                                                        <tr width="30" height="35">
                                                                                                <td id="pcjscell" width="30" height="35" align="center" valign="top"><img src="images/pix-t.gif" width="20" height="25"></td>
                                                                                        </tr>
                                                                                        </table>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                        </tr>
                                        <tr><td colspan=18 align="center">
                                                <input type="button" name="select" value="Accept" onClick="PcjsInternalSelectClose()" class="button">
                                                </td>
                                        </tr>
                                </table>
                        </td>
                        <td valign="top" bgcolor="#DDDDDD">
                                <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#DDDDDD">
                                <tr>
                                        <td id="id2000" width="200" height="100" align="center" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                        <td><TABLE BORDER="0" width="100%" CELLPADDING="0" cellspacing="0" bgcolor="#DDDDDD">
                                                <tr><td valign="top"><b>Red:</b></td>
                                                <td><input type="text" name="rcolor" size="3" value="" onChange="makeChanges(1);"><br><img src="images/up.gif" ONCLICK="changeColor(1)">&nbsp;<img src="images/down.gif" ONCLICK="changeColor(4)"></td>
                                                </tr>
                                                <tr><td valign="top"><b>Green:</b></td>
                                                <td><input type="text" name="gcolor" size="3" value="" onChange="makeChanges(2);"><br><img src="images/up.gif" ONCLICK="changeColor(2)">&nbsp;<img src="images/down.gif" ONCLICK="changeColor(5)"></td>
                                                </tr>
                                                <tr><td valign="top"><b>Blue:</b></td>
                                                <td><input type="text" name="bcolor" size="3" value="" onChange="makeChanges(3);"><br><img src="images/up.gif" ONCLICK="changeColor(3)">&nbsp;<img src="images/down.gif" ONCLICK="changeColor(6)"></td>
                                                </tr>
                                             </TABLE>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
</form>
</td>
<td height="71" width="2"><img src="images/pix-t.gif" width="2" height="71"></td>
</tr>
<tr height="2"><td height="2" width="2"><img src="images/pix-t.gif" width="2" height="2"></td>
<td height="2"><img src="images/pix-t.gif" height="2"></td>
<td height="2" width="2"><img src="images/pix-t.gif" width="2" height="2"></td>
</tr>
</table>
</td>
</tr>
</table></div>
<script language="Javascript">
<!--
PcjsGeneratePopup();
prefix="#"
rnum1=0
bnum1=0
gnum1=0
rnum2=0
bnum2=0
gnum2=0
if (document.layers) {
        hexNumber2=document.layers['id2000'].bgColor;
}
else if (document.all) {
        hexNumber2=document.all.id2000.bgColor;
}
else {
        hexNumber2=document.getElementById('id2000').style.background;
}
rcount=0;
bcount=0;
gcount=0;
//-->
</script>