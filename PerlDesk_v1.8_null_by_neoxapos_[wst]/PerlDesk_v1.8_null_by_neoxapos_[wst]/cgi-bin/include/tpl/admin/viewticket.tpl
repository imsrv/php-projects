  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
          <tr> 
      <td colspan="4"> 
        <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
          View Ticket {trackno}</b></font></div>
      </td>
    </tr>
    <tr> 
      <td colspan="4"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">( <a href="admin.cgi?do=del_ticket&id={trackno}&status={status}">remove
          ticket</a> ) </font></div></td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>&nbsp;&nbsp; 
          </b></font> </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        
        
      <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
        <tr> 
          <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
          <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{username} 
            </font></td>
        </tr>
        <tr> 
          <td height="2"><font size="2">Email</font></td>
          <td height="2"><font size="2">{email} ( <a href="admin.cgi?do=emailsettings&amp;email={email}&amp;type=address">block 
            address</a> ) </font></td>
        </tr>
        <tr> 
          <td height="2"><font size="2">Viewing Key</font></td>
          <td height="2"><font size="2"><b><i>{ckey}</i></b></font></td>
        </tr>
        {fields} 
      </table>
        </font><br>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Request 
              ID </font></td>
            <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{trackno}</font></td>
          </tr>
          <tr> 
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Priority</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{priority} 
              </font></td>
          </tr>
          <tr> 
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Logged</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{date}</font> 
            </td>
          </tr>
          <tr> 
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Status</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{status}</font></td>
          </tr>
        </table>
        <br>
        </font> 
        
      <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
        <tr> 
          <td width="19%" height="19"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ownership</font></td>
          <td width="72%" height="19"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>{owned}</b></font></td>
        </tr>
        <tr> 
          <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Working 
            Time</font></td>
          <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{time_spent} 
            minutes </font></td>
        </tr>
        <tr> 
          <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Department</font></td>
          <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{category} 
            &nbsp; </font></td>
        </tr>
      </table>
        <br>
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#F2F2F2" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="2" height="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>{subject}</b></font></td>
          </tr>
          <tr> 
            <td colspan="2" height="41"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              </font> 
              <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{description}</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
                    </font></td>
                </tr>
              </table>
              
            </td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font><br>
        <table width="100%" border="0" align="center">
          <tr> 
            <td colspan="2"> 
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr> 
                  <td colspan="2" height="19"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Responses</b></font></td>
                </tr>{notes}
              </table>
              <table width="90%" border="0" align="center">
                <tr> 
                  <td colspan="3" height="8"> 
                    <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
                  </td>
                </tr>
              </table>
            <br>
            <table width="90%" border="0" align="center" cellpadding="4" cellspacing="1">
              <tr bgcolor="#006633"> 
                <td colspan="5" height="8"> 
                  <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">Activity 
                    Log </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"></font></div>
                </td>
              </tr>{log}
              
              <tr> 
                <td width="25%" height="8">&nbsp;</td>
                <td width="20%" height="8">&nbsp;</td>
                <td colspan="3" height="8" width="55%">&nbsp;</td>
              </tr>
            </table>
          </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td> 
              <div align="center"></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="149" valign="top">&nbsp;</td>
      <td width="97">&nbsp;</td>
      <td width="123">&nbsp;</td>
      <td width="131">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" valign="top"> 
        <div align="center"> 
          <input type="hidden" name="ticket" value="{trackno}">
          <input type="hidden" name="action" value="addresponse">
          <br>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
