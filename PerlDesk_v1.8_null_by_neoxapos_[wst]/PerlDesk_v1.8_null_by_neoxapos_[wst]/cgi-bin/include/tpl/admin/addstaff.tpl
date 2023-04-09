

  
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top">
    <td height="21">
      <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=staff"><img src="{imgbase}/admin/list_staff.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=addstaff"><img src="{imgbase}/admin/add_staff.gif" width="104" height="19" border="0"> 
        </a><a href="#" onClick="Popup('admin.cgi?do=pm&to=inbox', 'Window', 425, 400)"><img src="{imgbase}/admin/staff_messaging.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=emailstaff"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a></strong></font></div>
    </td>
  </tr>
  <tr valign="top"> 
    <td height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=staff">Staff</a>: Add Login</b></font></td>
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
                  <td colspan="3" height="26"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Personal 
                    Details</b></font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input name="name" type="text" class="tbox" size="40">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input name="email" type="text" class="tbox" size="40">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                </tr>
                <tr> 
                  <td colspan="3" height="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Log-in 
                    Details</b></font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="username">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="password" class="tbox" name="pass1">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="password" class="tbox" name="pass2">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                </tr>
                <tr> 
                  <td colspan="3" height="28">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="3" height="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Departmental 
                    Access. </b></font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">By 
                    selecting this, you can restrict members of staff to certain 
                    areas of the help desk, and they can only deal wit that area. 
                    You can select GLOBAL access for a user which will give them 
                    full access to all departments.</font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Access:</font></td>
                  <td width="64%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    {category} </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%">&nbsp;</td>
                  <td width="64%">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Notify 
                    of new calls?</font></td>
                  <td width="64%"> <input type="checkbox" name="notify" value="yes"> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"> 
                      <input type="submit" class="forminput" name="Submit" value="Submit">
                    </div></td>
                </tr>
                <tr> 
                  <td colspan="3"> <input type="hidden" name="do" value="savestaff"> 
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
