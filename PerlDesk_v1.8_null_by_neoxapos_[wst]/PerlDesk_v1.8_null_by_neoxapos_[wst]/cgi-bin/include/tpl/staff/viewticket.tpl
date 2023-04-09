 


<form action="staff.cgi?" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
          <tr> 
      <td colspan="4"> 
        
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b> 
          </b></font> </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
            <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{username} 
              ( view all requests by <a href="staff.cgi?do=listbyuser&user={username}">{username}</a> 
              )</font> </td>
          </tr>
          <tr>
            <td height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email</font></td>
            <td height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{email}</font></td>
          </tr>
          {fields}
        </table>
        <br>
      </font>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr>
            <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Request
                ID </font></td>
            <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{trackno}</font></td>
          </tr>
          <tr>
            <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Priority</font></td>
            <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{priority} </font></td>
          </tr>
        </table>
        </font>
        <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td height="27">
              <div align="right">
                <table width="400" border="1" cellspacing="0" cellpadding="1" align="right" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr>
                    <td width="150" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666">UPDATE
                          PRIORITY</font></div>
                    </td>
                    <td width="50" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_pri&id={trackno}&trackno={trackno}&pri=1">1</a></font></div>
                    </td>
                    <td width="50" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_pri&id={trackno}&trackno={trackno}&pri=2">2</a></font></div></td>
                    <td width="50" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_pri&id={trackno}&trackno={trackno}&pri=3">3</a></font></div></td>
                    <td width="50"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_pri&id={trackno}&trackno={trackno}&pri=4">4</a></font></div></td>
                    <td width="50"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_pri&id={trackno}&trackno={trackno}&pri=5">5</a></font></div></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>        
        <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
          </tr>
          <tr bgcolor="#D1D1E0">
            <td width="25%"><table width="100%" border="0" cellspacing="1" cellpadding="2">
              <tr bgcolor="#E1E0ED">
                <td bgcolor="#FAF7E4">
                  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?action=assign&callid={trackno}">ASSIGN
                        INTERNAL</a></font></div>
                </td>
              </tr>
            </table>
</td>
            <td width="25%">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#E1E0ED">
                  <td bgcolor="#FAF7E4">
                    <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=delete&cid={trackno}">DELETE
                          REQUEST</a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="25%">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#E1E0ED">
                  <td bgcolor="#FAF7E4">
                    <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?action=print&amp;callid={trackno}">PRINT
                          REQUEST </a></font></div>
                  </td>
                </tr>
              </table>
            </td>
            <td width="25%">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#E1E0ED">
                  <td bgcolor="#FAF7E4">
                    <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=own&cid={trackno}">CLAIM
                          OWNERSHIP</a></font></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
          </tr>
        </table>        
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
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
        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font> 
        <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td height="27">
              <div align="right">
                <table width="400" border="1" cellspacing="0" cellpadding="1" align="right" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr>
                    <td width="150" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666">UPDATE
                          STATUS</font></div>
                    </td>
                    <td width="83" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_status&id={trackno}&trackno={trackno}&status=OPEN">OPEN</a></font></div>
                    </td>
                    <td width="83" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_status&id={trackno}&trackno={trackno}&status=HOLD">HOLD</a></font></div>
                    </td>
                    <td width="83" height="2">
                      <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=change_status&id={trackno}&trackno={trackno}&status=CLOSED">CLOSE</a></font></div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
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
              </font></td>
          </tr>
        </table>
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr>
            <td height="27">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;            </td>
          </tr>
        </table>        
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#F2F2F2" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="2" height="29"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>{subject}</b></font></td>
          </tr>
          <tr> 
            <td colspan="2" height="41"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              </font> 
              <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{description}</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
                    </font></td>
                </tr>
                <tr> 
                  <td colspan="2">
                    <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">[ 
                      <a href="staff.cgi?action=editticket&amp;ticket={trackno}">EDIT 
                      TICKET</a> ] </font></div>
                  </td>
                </tr>
              </table>
              
            </td>
          </tr>
          <tr>
            <td height="23" colspan="2" bgcolor="#E1E1E1"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong> File
                  Attachment: {filename}</strong></font></td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font><br>
        <table width="100%" border="0" align="center">
          <tr> 
            <td colspan="2"> 
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr bgcolor="#E1E1E1"> 
                  <td colspan="2" height="22"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>User/Staff 
                    Responses</b></font></td>
                </tr>
              {notes}</table>
              
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
          <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td height="27"><a href="staff.cgi?action=addresponse&amp;ticket={trackno}&inc=1"><img src="{imgbase}/staff/quote_respond.gif" width="120" height="19" border="0"></a>
                <a href="staff.cgi?action=addresponse&amp;ticket={trackno}"><img src="{imgbase}/staff/respond.gif" width="120" height="19" border="0"> 
                </a> </td>
            </tr>
            <tr> 
              <td>&nbsp; </td>
            </tr>
          </table>
          <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr bgcolor="#CCCCCC"> 
                    <td height="2"> 
                      <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">
                        <tr bgcolor="#68977C"> 
                          <td colspan="5" height="8"> 
                            <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">Activity 
                              Log </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"></font></div>
                          </td>
                        </tr>
                        {log} 
                      </table>
                    </td>
                  </tr>
                  <tr> 
                    <td>&nbsp; </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <input type="hidden" name="ticket" value="{trackno}">
          <input type="hidden" name="action" value="addresponse">
          <br>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
