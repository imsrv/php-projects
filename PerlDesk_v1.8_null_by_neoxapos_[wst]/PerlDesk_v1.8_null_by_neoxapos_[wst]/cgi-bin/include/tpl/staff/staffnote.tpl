 
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


<form action="staff.cgi" method="post" enctype="multipart/form-data">
  <table width="85%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="4"> 
        
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <br>
        <table width="100%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="46%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">STATUS 
              </font></td>
            <td width="54%" height="2"> 
              <select name="newstatus" class="gbox">
                <option value="Resolved">Closed (Resolved)</option>
                <option value="Unresolved" selected>Open (Unresolved)</option>
                <option value="Hold">Hold (In Progress)</option>
              </select>
            </td>
          </tr>
          <tr> 
            <td width="46%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">PRIVATE 
              REPONSE </font></td>
            <td width="54%"> 
              <select name="private" class="gbox">
                <option value="Yes">Yes</option>
                <option value="No" selected>No</option>
              </select>
            </td>
          </tr>
          <tr> 
            <td width="46%"><font size="2">CC</font> </td>
            <td width="54%"> 
              <input type="text" name="cc" class="gbox" size="30">
            </td>
          </tr>
          <tr>
            <td width="46%"><font size="2">TIME SPENT</font></td>
            <td width="54%"> 
              <input type="text" name="time" class="gbox" size="8">
              <font size="1"> (mins) </font></td>
          </tr>
        </table>
        </font> 
        <table width="90%" border="0" align="center">
          <tr> 
            <td colspan="2" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><font size="1">Private 
              responses are viewable by staff members only. </font></font></td>
          </tr>
          <tr> 
            <td width="40%" valign="top">&nbsp;</td>
            <td width="60%">&nbsp;</td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="173"> 
              <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <table width="100%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="63%" height="2"> 
                      <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRE-DEFINED 
                        RESPONSE </font></div>
                    </td>
                    <td width="37%" height="2"> 
                      <select name="menu" onChange="MM_jumpMenu('parent',this,0)" class="tbox">
                        <option selected>--- Your Templates ---</option>
                     {preans} </select>
                    </td>
                  </tr>
                </table>
                </font> <br>
                <textarea name="comments" cols="90" rows="12" class="gbox">{msg}{ifpre}{sig}</textarea>
                <br>
              </div>
              <div align="right"><font face=Verdana size=1><a href="#" onclick="Popup('staff.cgi?action=history&callid={trackno}', 'Window', 425, 400)">View 
                Request History</a><br>
                <br>
                </font></div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="39"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <table width="100%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr>
                  <td height="2"><font size="2">F<font face="Verdana, Arial, Helvetica, sans-serif">ILE</font></font></td>
                  <td height="2"><input type="file" class="gbox" name="file"></td>
                </tr>
                <tr> 
                  <td width="25%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">NOTIFY 
                    </font></td>
                  <td width="75%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <select name="notify" class="tbox">
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                    </font> </td>
                </tr>
                <tr> 
                  <td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Send 
                    user notification of this response ?</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
                  </td>
                </tr>
              </table>
              </font> </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="60"> 
              <div align="center"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr> 
                    <td colspan="2" height="8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <table width="100%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                        <tr> 
                          <td width="25%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">ADD 
                            TO KB</font></td>
                          <td width="75%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="checkbox" name="addtokb" value="1">
                            </font> </td>
                        </tr>
                        <tr>
                          <td width="25%" height="2"><font size="2">TAKE OWNERSHIP</font></td>
                          <td width="75%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                            <input type="checkbox" name="own" value="1" checked>
                            </font></td>
                        </tr>
                      </table>
                      </font></td>
                  </tr>
                </table>
                <input type="hidden" name="ticket" value="{trackno}">
                <input type="hidden" name="action" value="submitnote">
                <input type="submit" name="Submit" value="Submit">
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr>
                  <td height="2">
                    <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Request
                  Body</strong></font></div></td>
                </tr>
                <tr>
                  <td height="2"><font size="2">{description}</font></td>
                </tr>
              </table>
            </font></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
