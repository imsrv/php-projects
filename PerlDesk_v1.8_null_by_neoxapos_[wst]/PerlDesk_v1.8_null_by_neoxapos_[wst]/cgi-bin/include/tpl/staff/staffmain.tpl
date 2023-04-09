<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" valign="top"><div align="right">
        <select name="menu" class="gbox" onChange="MM_jumpMenu('parent',this,0)">
          <option selected>Auto Refresh Page</option>
          <option value="staff.cgi?do=main&timer=60000"{t1}>Every Minute </option>
          <option value="staff.cgi?do=main&timer=180000"{t2}>Every 3 Minutes </option>
          <option value="staff.cgi?do=main&timer=300000"{t3}>Every 5 Minutes </option>
          <option value="staff.cgi?do=main&timer=900000"{t4}>Every 15 Minutes </option>
          <option value="staff.cgi?do=main&timer=1800000"{t5}>Every 30 Minutes </option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td height="30" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Welcome
          {name}</b></font></td>
  </tr>
  <tr>
    <td height="35" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Thank
        you for logging into the staff area {name}, below you can view an overview
        of support requests in your departments. </font></td>
  </tr>
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center">
        <tr bgcolor="#F2F2F2">
          <td width="34%" bgcolor="#D8D8D8" height="14">
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Department</font></div>
          </td>
          <td width="22%" height="14" bgcolor="#E8E8E8">
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total
                Unresolved </font></div>
          </td>
          <td width="22%" height="14" bgcolor="#E8E8E8">
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Awaiting
                Staff Response</font></div>
          </td>
          <td width="22%" height="14" bgcolor="#E8E8E8">
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Awaiting
                User Response</font></div>
          </td>
        </tr>
      {dep_stats}
      </table>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="staff.cgi">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td> </td>
    </tr>
    <tr>
      <td height="19" valign="top"><div align="right">
      </div></td>
    </tr>
    <tr> 
      <td height="31"> 
        <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
          ( <a href="staff.cgi?do=listcalls&status=open">view 
          all unresolved</a> )</font></div>
      </td>
    </tr>
    <tr> 
      <td height="18" bgcolor="#990000"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">EMERGENCY</font></td>
        </tr>
      </table>        
      </td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="1" align="center" height="19" cellpadding="0">
          <tr> 
            <td width="13%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    ID</font></td>
                </tr>
              </table>
            </td>
            <td width="17%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Logged 
                    By </font></td>
                </tr>
              </table>
            </td>
            <td width="21%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Subject</font></td>
                </tr>
              </table>
            </td>
            <td width="22%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Department</font></td>
                </tr>
              </table>
            </td>
            <td width="8%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Status</font></td>
                </tr>
              </table>
            </td>
            <td width="19%" bgcolor="#D1D1D1"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">When 
                    Logged </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center">{em_call}</div>
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#330099" height="18"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">NEW</font></td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="1" align="center" height="19" cellpadding="0">
          <tr>
            <td width="13%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> ID</font></td>
                </tr>
              </table>
            </td>
            <td width="17%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Logged
                      By </font></td>
                </tr>
              </table>
            </td>
            <td width="21%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Subject</font></td>
                </tr>
              </table>
            </td>
            <td width="22%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Department</font></td>
                </tr>
              </table>
            </td>
            <td width="8%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Status</font></td>
                </tr>
              </table>
            </td>
            <td width="19%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">When
                      Logged </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center"></div>
      <div align="center">{new_call}</div>
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#336633" height="18"><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF">OPEN</font></td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="1" align="center" height="19" cellpadding="0">
          <tr>
            <td width="13%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> ID</font></td>
                </tr>
              </table>
            </td>
            <td width="17%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Logged
                      By </font></td>
                </tr>
              </table>
            </td>
            <td width="21%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Subject</font></td>
                </tr>
              </table>
            </td>
            <td width="22%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Department</font></td>
                </tr>
              </table>
            </td>
            <td width="8%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Status</font></td>
                </tr>
              </table>
            </td>
            <td width="19%" bgcolor="#D1D1D1">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="19" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">When
                      Logged </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center"></div>
      <div align="center">{open_call}</div>
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td height="2"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"> 
              <table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                  <td width="3%">&nbsp;</td>
                  <td width="6%"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input name=all_c type=checkbox id="all_c" onClick="this.value=check(this.form.ticket_check)" value=1>
                  </font></div></td>
                  <td width="22%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=#000000>
                    <div align="center">
                      <select name="action_call" class="query" id="action_call">
                        <option value="delete">Delete Selected
                        <option value="respond">Respond to Selected
                        <option value="own">Take Ownership</option>
                      </select>
                    </div>
                  </font></td>
                  <td width="69%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=#000000> 
                    <input type="image" border="0" name="imageField" src="{imgbase}/staff/save_changes.gif">
                    <input name="status" type="hidden" id="status" value="main">
                    <input name="do" type="hidden" id="do" value="update_list_calls">
                    </font></td>
                </tr>
              </table>
</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td> </td>
    </tr>
    <tr> 
      <td height="49"> 
        <div align="right"> 
          <table width="350" border="0" cellspacing="1" cellpadding="0" align="right">
            <tr> 
              <td width="25">&nbsp;</td>
              <td width="150">&nbsp;</td>
              <td width="25">&nbsp;</td>
              <td width="150">&nbsp;</td>
            </tr>
            <tr> 
              <td width="25"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="{imgbase}/online.gif"></font></td>
              <td width="150"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Awaiting 
                Staff Response</font></td>
              <td width="25"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="{imgbase}/offline.gif"></font></td>
              <td width="150"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Awaiting 
                User Response</font></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr> 
            <td colspan="2" valign="top"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="7">
                <tr> 
                  <td width="35%" valign="top"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr>
                        <td width="12%"><img src="{imgbase}/Profile-Icon.gif" width="23" height="23"></td> 
                        <td width="88%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>INBOX 
                          </b> <font size="1">(<a href="#" onClick="Popup('staff.cgi?do=messanger&to=inbox', 'Window', 425, 400)">open</a>) 
                          </font></font></td>
                      </tr>
                      <tr valign="middle">
                        <td height="38" colspan="2" bgcolor="#FFFFFF"> 
                          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">{pm}</font></div>
                        </td> 
                      </tr>
                    </table>
                  </td>
                  <td width="65%" valign="top"> 
                    <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr>
                        <td width="6%"><div align="left"><img src="{imgbase}/announcement.gif" width="23" height="23"></div></td> 
                        <td width="94%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ANNOUNCEMENTS</b></font></td>
                      </tr>
                      <tr>
                        <td height="38" colspan="2" valign="top" bgcolor="#FFFFFF"> 
                          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">{announcement}</font></div>
                        </td> 
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top">&nbsp; </td>
          </tr>
          <tr> 
            <td width="28%" valign="top">&nbsp;</td>
            <td width="72%" valign="top">&nbsp; </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
    </tr>
  </table>
</form>
