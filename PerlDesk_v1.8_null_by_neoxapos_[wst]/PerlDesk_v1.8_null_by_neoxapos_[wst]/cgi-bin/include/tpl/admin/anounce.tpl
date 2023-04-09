
<table width="100%" border="0" align="center">
  <tr> 
    <td> </td>
  </tr>
  <tr> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      Announcements</b></font></td>
  </tr>
  <tr> 
    <td> 
      <div align="right"><font size="2"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></div>
    </td>
  </tr>
  <tr> 
    <td height="20"> 
      <form name="form1" method="post" action="admin.cgi">
        <div align="center"> 
          <table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr> 
              <td colspan="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
            </tr>
            <tr> 
              <td colspan="3">
                <div align="center"> 
                  <table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">{announcement}</font></td>
                    </tr>
                  </table>
                  
                </div>
              </td>
            </tr>
            <tr> 
              <td width="8%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
              <td width="19%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
              <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
            </tr>
            <tr> 
              <td colspan="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>&#8226; Post
                     New Announcement</b></font></td>
            </tr>
            <tr> 
              <td width="8%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
              <td width="19%">&nbsp;</td>
              <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
                </font> </td>
            </tr>
            <tr> 
              <td width="8%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
              <td width="19%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">To</font></td>
              <td width="73%"> 
                <table width="70%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="15%"> 
                      <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                        <input type="checkbox" name="users" value="yes">
                        </font></div>
                    </td>
                    <td width="85%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                      Users</font></td>
                  </tr>
                  <tr> 
                    <td width="15%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                      <input type="checkbox" name="staff" value="yes">
                      </font></td>
                    <td width="85%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                      Staff</font></td>
                  </tr>
                  <tr> 
                    <td width="15%">&nbsp;</td>
                    <td width="85%">&nbsp;</td>
                  </tr>
                </table>
                
              </td>
            </tr>
            <tr> 
              <td width="8%">&nbsp;</td>
              <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td>
              <td width="73%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input type="text" class="gbox" name="subject" size="55">
                </font></td>
            </tr>
            <tr> 
              <td width="8%">&nbsp;</td>
              <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
              <td width="73%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr> 
              <td width="8%" height="30">&nbsp;</td>
              <td width="19%" height="30" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Message</font></td>
              <td width="73%" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <textarea name="message" class="gbox" cols="65" rows="17"></textarea>
                </font> </td>
            </tr>
            <tr> 
              <td width="8%" height="30">&nbsp;</td>
              <td width="19%" height="30" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email 
                </font></td>
              <td width="73%" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                <input type="checkbox" name="email" value="yes">
                <font size="1">(also email to recipients)</font></font></td>
            </tr>
            <tr> 
              <td colspan="3"> 
                <div align="center"> </div>
              </td>
            </tr>
          </table>
          <br>
          <br>
          <input type="hidden" name="do" value="anc_save">
          <input type="submit" class="forminput" name="Submit" value="Save">
        </div>
      </form>
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>

