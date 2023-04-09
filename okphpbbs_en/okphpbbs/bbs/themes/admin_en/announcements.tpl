
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> 
            <p><font class="directory">Announceents:</font><b>Management</b> </p>
          </td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[<a href="index.php?action=announcements#add">New 
            Announcement </a>] </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form action="index.php" method="post">
                <tr> 
                  <th width="3%">id</th>
                  <th width="33%">Subject</th>
                  <th width="22%" align="center">Data<b><font color="#FFFFFF"></font></b></th>
                  <th width="21%">All forums</th>
                  <th width="21%">Oprations</th>
                </tr>
                <!-- BEGIN list -->
                <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                  <td width="3%"> 
                    <input type="checkbox" name="file_id[]" value="{id}">
                  </td>
                  <td width="33%">{title} </td>
                  <td width="22%"> {date}</td>
                  <td width="21%">&nbsp;{all_forums} &nbsp;</td>
                  <td width="21%" align="center"><a href="index.php?action=announcements&step=del&id={id}"  onClick="return confirm('Are you sure to delete???')"><img src="../images/admin/delete.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=announcements&step=mod_form&id={id}#add"><img src="../images/admin/edit.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;</td>
                </tr>
                <!-- END list -->
                <tr> 
                  <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <hr>
      <p> <a name="add"> </a><br>
      </p>
      <table border="0" cellspacing="1" cellpadding="0" bgcolor="#999999">
        <form name="post" method="post" action="index.php">
          <tr align="center"> 
            <th colspan="2">Set Announcement 
              <script language="JavaScript" type="text/javascript" src="../js/post.js"></script>
            </th>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="19%">*Subject:</td>
            <td width="81%"> 
              <input type="text" name="title" value="{settitle}" size="40">
            </td>
          </tr>
          <tr bgcolor="#F3F3F3"> 
            <td width="19%" bgcolor="#F3F3F3">*All Forums?<br>
            </td>
            <td width="81%" bgcolor="#F3F3F3"> 
              <input type="text" name="all_forums" size="5" value="{setall_forums}">
              (1:yes, 0:only homepage)</td>
          </tr>
          <tr> 
            <td width="19%" bgcolor="#F3F3F3">*Content<a href="#note"></a></td>
            <td width="81%" bgcolor="#F3F3F3" valign="top"> 
              <table width="500" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td colspan="9"><span class="genmed"><img src="../themes/default/images/blue/edit/image.gif" width="38" height="21" onClick="bbstyle(14)" onMouseOver="helpline('p')"> 
                    <img src="../themes/default/images/blue/edit/link.gif" width="38" height="21" onClick="bbstyle(16)" onMouseOver="helpline('w')"> 
                    <img src="../themes/default/images/blue/edit/flash.gif" width="38" height="21" onClick="bbstyle(10)" onMouseOver="helpline('l')"> 
                    <img src="../themes/default/images/blue/edit/code.gif" width="38" height="21" onClick="bbstyle(8)" onMouseOver="helpline('c')"> 
                    <img src="../themes/default/images/blue/edit/quote.gif" width="38" height="21" onClick="bbstyle(6)" onMouseOver="helpline('q')"></span> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="9"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td> <span class="genmed">&nbsp; 
                          <select name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
                            <option style="color:black; background-color: #FAFAFA" value="#444444" class="genmed" selected>COLOR..</option>
                            <option style="color:darkred; background-color: #FAFAFA" value="darkred" class="genmed">#TEXT#</option>
                            <option style="color:red; background-color: #FAFAFA" value="red" class="genmed">#TEXT#</option>
                            <option style="color:orange; background-color: #FAFAFA" value="orange" class="genmed">#TEXT#</option>
                            <option style="color:brown; background-color: #FAFAFA" value="brown" class="genmed">#TEXT#</option>
                            <option style="color:yellow; background-color: #FAFAFA" value="yellow" class="genmed">#TEXT#</option>
                            <option style="color:green; background-color: #FAFAFA" value="green" class="genmed">#TEXT#</option>
                            <option style="color:olive; background-color: #FAFAFA" value="olive" class="genmed">#TEXT#</option>
                            <option style="color:cyan; background-color: #FAFAFA" value="cyan" class="genmed">#TEXT#</option>
                            <option style="color:blue; background-color: #FAFAFA" value="blue" class="genmed">#TEXT#</option>
                            <option style="color:darkblue; background-color: #FAFAFA" value="darkblue" class="genmed">#TEXT#</option>
                            <option style="color:indigo; background-color: #FAFAFA" value="indigo" class="genmed">#TEXT#</option>
                            <option style="color:violet; background-color: #FAFAFA" value="violet" class="genmed">#TEXT#</option>
                            <option style="color:white; background-color: #FAFAFA" value="white" class="genmed">#TEXT#</option>
                            <option style="color:black; background-color: #FAFAFA" value="black" class="genmed">#TEXT#</option>
                          </select>
                          &nbsp; 
                          <select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
                            <option value="2">SIZE..</option>
                            <option value="0">0px(very small)</option>
                            <option value="1">1px(small)</option>
                            <option value="2">2px(normal)</option>
                            <option value="3">3px(big}</option>
                            <option value="4">4px(very big)</option>
                          </select>
                          </span> <img src="../themes/default/images/blue/edit/bold.gif" width="28" height="21" onClick="bbstyle(0)" onMouseOver="helpline('b')"> 
                          <img src="../themes/default/images/blue/edit/italic.gif" width="28" height="21" onClick="bbstyle(2)" onMouseOver="helpline('i')"> 
                          <img src="../themes/default/images/blue/edit/underline.gif" width="28" height="21" onClick="bbstyle(4)" onMouseOver="helpline('u')"> 
                          <img src="../themes/default/images/blue/edit/center.gif" width="28" height="21" onClick="bbstyle(12)" onMouseOver="helpline('o')"></td>
                        <td nowrap align="right" width="2%"><span class="genmed"></span></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr> 
                  <td colspan="9"> <span class="genmed"> 
                    <input type="text" name="helpbox" size="35" maxlength="100" style="width:450px; font-size:12px" class="helpline" >
                    </span></td>
                </tr>
                <tr> 
                  <td colspan="9"><span class="genmed"> 
                    <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:550px" tabindex="3" class="post" onSelect="storeCaret(this);" onClick="storeCaret(this);" onKeyUp="storeCaret(this);">{setcontent}</textarea>
                    </span></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr bgcolor="#F3F3F3"> 
            <td colspan="2" align="center"> 
              <input type="hidden" name="id" value="{setid}">
              <input type="hidden" name="action" value="announcements">
              <input type="hidden" name="step" value="{step}">
              <input type="submit" name="Submit2" value="Submit">
            </td>
          </tr>
        </form>
      </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td bgcolor="#F3F3F3" align="center" valign="top">&nbsp; </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
