 
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top"> 
    <td height="29"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      Help Desk Stats</b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr valign="top"> 
          <td colspan="3" height="53"> 
            <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">These 
              are the overall statistics for your perldesk installation. The average 
              response time records all staff members response times to give an 
              accurate figure.</font></div>
          </td>
        </tr>
        <tr> 
          <td colspan="3" height="18">
            <table width="85%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
              <tr bgcolor="#DBDBDB"> 
                <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>AVERAGE 
                  RESPONSE TIME</b></font></td>
              </tr>
              <tr> 
                <td colspan="2" height="30">
                  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{avgresponse}</font></div>
                </td>
              </tr>
            </table>
            <br>            <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="50%"><table width="90%" border="0" cellspacing="0" cellpadding="2" align="center">
                  <tr>
                    <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Open
                        Requests</font></td>
                    <td width="53%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{OPEN} </font></td>
                  </tr>
                  <tr>
                    <td width="29%"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>{open_perc}%</em></font></div>
                    </td>
                    <td width="2%"><div align="right"><font color="#999999" size="2">|</font></div>
                    </td>
                    <td colspan="2"><div align="left"></div>
                        <table width="{open_perc}%" height="9" border="00" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="1" height="9" background="{imgbase}/admin_stats_bg_yellow.gif">
                              <div align="right"><img src="{imgbase}/admin_stats_left_yellow.gif" width="2" height="9"></div>
                            </td>
                            <td width="50" height="9" background="{imgbase}/admin_stats_bg_yellow.gif"><img src="{imgbase}/admin_stats_bg_yellow.gif" width="1" height="9"></td>
                            <td width="3" height="9">
                              <div align="left"><img src="{imgbase}/admin_stats_right_yellow.gif" width="3" height="9"></div>
                            </td>
                          </tr>
                        </table>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Hold 
                      Requests</font></td>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{HOLD}</font></td>
                  </tr>
                  <tr>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>{hold_perc}%</em></font></td>
                    <td><div align="right"><font color="#999999" size="2">|</font></div>
                    </td>
                    <td colspan="2"><table width="{hold_perc}%" height="9" border="00" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="1" height="9" background="{imgbase}/admin_stats_bg_blue.gif">
                            <div align="right"><img src="{imgbase}/admin_stats_left_blue.gif" width="2" height="9"></div>
                          </td>
                          <td width="50" height="9" background="{imgbase}/admin_stats_bg_blue.gif"><img src="{imgbase}/admin_stats_bg_blue.gif" width="1" height="9"></td>
                          <td width="3" height="9">
                            <div align="left"><img src="{imgbase}/admin_stats_right_blue.gif" width="3" height="9"></div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Closed
                      Requests</font></td>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{CLOSED}</font></td>
                  </tr>
                  <tr>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>{closed_perc}%</em></font></td>
                    <td><div align="right"><font color="#999999" size="2">|</font></div>
                    </td>
                    <td colspan="2">
                      <table width="{closed_perc}%" height="9" border="00" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="1" height="9" background="{imgbase}/admin_stats_bg_green.gif">
                            <div align="right"><img src="{imgbase}/admin_stats_left_green.gif" width="2" height="9"></div>
                          </td>
                          <td width="50" height="9" background="{imgbase}/admin_stats_bg_green.gif"><img src="{imgbase}/admin_stats_bg_green.gif" width="1" height="9"></td>
                          <td width="3" height="9">
                            <div align="left"><img src="{imgbase}/admin_stats_right_green.gif" width="3" height="9"></div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table></td>
                <td width="50%"><table width="85%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr bgcolor="#DBDBDB">
                    <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>SUPPORT
                          REQUESTS </b></font></td>
                  </tr>
                  <tr>
                    <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">OPEN
                        TICKETS </font></td>
                    <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{OPEN}</font></td>
                  </tr>
                  <tr>
                    <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">HOLD
                        TICKETS</font></td>
                    <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{HOLD}</font></td>
                  </tr>
                  <tr>
                    <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CLOSED
                        TICKETS</font></td>
                    <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{CLOSED}</font></td>
                  </tr>
                  <tr>
                    <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></td>
                    <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{calls}</font></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br>
            
            <table width="85%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
              <tr bgcolor="#DBDBDB"> 
                <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ACCOUNTS</b></font></td>
              </tr>
              <tr> 
                <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TOTAL 
                  USERS </font></td>
                <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{users}</font></td>
              </tr>
              <tr> 
                <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TOTAL 
                  STAFF </font></td>
                <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{staff}</font></td>
              </tr>
            </table>
            <br>
            <table width="85%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
              <tr bgcolor="#DBDBDB"> 
                <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>SUBMISSION 
                  METHODS </b></font></td>
              </tr>
              <tr> 
                <td width="72%" height="15"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">WEB 
                  DESK </font></td>
                <td width="28%" height="15"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{hd}</font></td>
              </tr>
              <tr> 
                <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">EMAIL</font></td>
                <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{em}</font></td>
              </tr>
              <tr> 
                <td width="72%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">STAFF 
                  LOGGING</font></td>
                <td width="28%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{cc}</font></td>
              </tr>
            </table>
            <p>&nbsp;</p>
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
