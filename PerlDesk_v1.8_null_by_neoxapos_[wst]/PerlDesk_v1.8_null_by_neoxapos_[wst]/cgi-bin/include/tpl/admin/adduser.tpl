

  
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top">
    <td height="42">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%"> 
            <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=adduser"><img src="{imgbase}/admin/add_user.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=users"><img src="{imgbase}/admin/list_users.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=exportusers"><img src="{imgbase}/admin/export_users.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=emailusers"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=validate"><img src="{imgbase}/admin/validate_users.gif" width="104" height="19" border="0"></a></font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr valign="top"> 
    <td height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=users">Users</a>: Add Login</b></font></td>
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
              <table width="85%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Personal 
                    Details</b></font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="name" size="30">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="email" size="30">
                    </font></td>
                </tr>{fields}
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%">&nbsp;</td>
                  <td width="67%">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="3" height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Log-in 
                    Details</b></font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username:</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="username">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="password" class="tbox" name="pass1">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="password" class="tbox" name="pass2">
                    </font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="67%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                </tr>
                <tr> 
                  <td width="5%">&nbsp;</td>
                  <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Send 
                    Registration Email?</font> <input type="checkbox" name="notify" value="yes"> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="3"> <div align="center"><br>
                      <br>
                      <input type="submit" class="forminput" name="Submit" value="Submit">
                    </div></td>
                </tr>
                <tr> 
                  <td colspan="3"> <input type="hidden" name="do" value="saveuser"> 
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
