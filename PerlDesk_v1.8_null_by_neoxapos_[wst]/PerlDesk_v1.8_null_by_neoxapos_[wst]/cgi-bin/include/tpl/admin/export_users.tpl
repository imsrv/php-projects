 
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top">
    <td height="29">
      <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=adduser"><img src="{imgbase}/admin/add_user.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=users"><img src="{imgbase}/admin/list_users.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=exportusers"><img src="{imgbase}/admin/export_users.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=emailusers"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=validate"><img src="{imgbase}/admin/validate_users.gif" width="104" height="19" border="0"></a></font></div>
    </td>
  </tr>
  <tr valign="top"> 
    <td height="29"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>:
      Export Users</b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td colspan="3" height="18"> 
            <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td width="100%" height="40"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Using
                      the user export tool you can save user 
                      data to a text file, this file can take some time to generate
                      depending on the database size. Please specify the delimiter
                      to use when creating this file.</font></td>
              </tr>
              <tr>
                <td height="40">
                  <form name="form1" method="post" action="admin.cgi">
                    <table width="80%" border="0" cellspacing="0" cellpadding="4" align="center">
                      <tr>
                        <td colspan="2" height="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="32%" height="50"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Field
                            Delimiter</font></td>
                        <td width="68%" height="50">
                          <input type="text" name="delimeter" size="5" value="," class="tbox">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" height="41">
                          <div align="center">
                            <input type="submit" name="Submit" value="Generate" class="forminput">
                            <input type="hidden" name="do" value="start_export">
                          </div>
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
              <tr>
                <td height="40"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Please
                    choose 'Save as' when prompted by your browser and save the
                    file to the location of your choice.</font></td>
              </tr>
              <tr>
                <td height="40">&nbsp;</td>
              </tr>
            </table>
            <p align="center">&nbsp;</p>
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
