

  
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr>
    <td height="35" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%" height="16"> 
            <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=staff"><img src="{imgbase}/admin/list_staff.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=addstaff"><img src="{imgbase}/admin/add_staff.gif" width="104" height="19" border="0"> 
              </a><a href="#" onClick="Popup('admin.cgi?do=pm&to=inbox', 'Window', 425, 400)"><img src="{imgbase}/admin/staff_messaging.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=emailstaff"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a></strong></font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=staff">Staff</a></b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="3"><div align="right">
            <select name="select" class="gbox"  onChange="MM_jumpMenu('parent',this,0)">
            <option selected>Please Select</option>
			
            <option value="admin.cgi?do=staff&online=1">View Online (Active) Staff Members</option>
            </select>
          </div></td>
        </tr>
        <tr> 
          <td colspan="3"><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="3" align="center"><tr><td width="66%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="50%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>{total}
                                          Staff Account(s)</strong></font></td>
                                    <td width="50%">&nbsp;</td>
                                  </tr>
                                </table></td></tr></table>
          
          <hr>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
              <td width="50%"><table width="360" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="20"><img src="{imgbase}/profileb.gif" width="16" height="16"></td>
                    <td width="100"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;View
                        Profile</font></td>
                    <td width="20"><img src="{imgbase}/answered.gif" width="14" height="10"></td>
                    <td width="100"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Answered
                        Calls</font></td>
                    <td width="20"><img src="{imgbase}/perf.gif" width="15" height="15"></td>
                    <td width="100"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Performance</font></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          &nbsp;&nbsp;<br>
          &nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3"> <font face="Verdana, Arial, Helvetica, sans-serif">{stafflist} 
            {navbar} </font> 
            <p>&nbsp;</p>
          </td>
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
