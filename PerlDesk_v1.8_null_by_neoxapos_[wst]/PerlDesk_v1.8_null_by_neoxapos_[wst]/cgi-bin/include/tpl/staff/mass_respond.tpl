 


<form action="staff.cgi" method="post">
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
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="46%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">STATUS 
              </font></td>
            <td width="54%" height="2"> 
              <select name="status" class="tbox">
                <option value="CLOSED">Closed (Resolved)</option>
                <option value="OPEN" selected>Open (Unresolved)</option>
                <option value="HOLD">Hold (In Progress)</option>
              </select>
            </td>
          </tr>
        </table>
        </font> 
        <table width="90%" border="0" align="center">
          <tr valign="middle"> 
            <td colspan="2" height="173"> 
              <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> <br>
                <textarea name="comments" cols="80" rows="12" class="tbox">
</textarea>
                <font face=Verdana size=1><br>
                </font></div>
              </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="39"> 
              <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Please 
                note, this procedure will not send notifications to clients and 
                will not adjust response timings.</font> </div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="60"> 
              <div align="center"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr> 
                    <td colspan="2" height="8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      </font></td>
                  </tr>
                </table>{hidden}
                <input type="hidden" name="do" value="refresh_calls">
                <input type="submit" name="Submit" value="Submit">
              </div>
            </td>
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
