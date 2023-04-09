

  
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top"> 
    <td height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=announcements">Announcements</a>: Edit</b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td colspan="3"> 
            <div align="center"></div>
          </td>
        </tr>
        <tr> 
          <td colspan="3"> 
            <form name="form1" method="post" action="admin.cgi">
              <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Annoucement 
                    Details ({nid})</b></font></td>
                </tr>
                <tr> 
                  <td width="5%" height="28">&nbsp;</td>
                  <td width="31%" height="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td>
                  <td width="64%" height="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="subject" size="40" value="{subject}">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Body:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <textarea class="tbox" name="notes" cols="50" rows="10">{note}
</textarea>
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
                </tr>
                <tr> 
                  <td colspan="3"> 
                    <div align="center"> 
                      <input type="submit" class="forminput" name="Submit" value="Submit">
                    </div>
                  </td>
                </tr>
                <tr> 
                  <td colspan="3"> 
                    <input type="hidden" name="do" value="anc_esave">
                    <input type="hidden" name="nid" value="{nid}">
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td> </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
