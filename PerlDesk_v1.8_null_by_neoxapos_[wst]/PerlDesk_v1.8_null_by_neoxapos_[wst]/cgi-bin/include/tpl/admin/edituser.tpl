
<form action="admin.cgi" method="post">
  <table width="100%" border="0">
    <tr> 
      <td> </td>
    </tr>
    <tr>
      <td height="37" valign="top">
        <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=adduser"><img src="{imgbase}/admin/add_user.gif" width="104" height="19" border="0"></a> 
          <a href="admin.cgi?do=users"><img src="{imgbase}/admin/list_users.gif" width="104" height="19" border="0"></a> 
          <a href="admin.cgi?do=exportusers"><img src="{imgbase}/admin/export_users.gif" width="104" height="19" border="0"></a> 
          <a href="admin.cgi?do=emailusers"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a> 
          <a href="admin.cgi?do=validate"><img src="{imgbase}/admin/validate_users.gif" width="104" height="19" border="0"></a></font></div>
      </td>
    </tr>
    <tr> 
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
        <a href="admin.cgi?do=users">Users</a>: Edit User</b></font></td>
    </tr>
    <tr> 
      <td height="36" valign="top"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="64%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></td>
            <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" class="gbox" name="name" value="{name}">
              </font></td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
            <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" class="gbox" name="email" value="{email}" size="40">
              </font></td>
          </tr>
          {fields}
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="64%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
            <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="password" class="gbox" name="pass1">
              </font></td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
            <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="password" class="gbox" name="pass2">
              </font></td>
          </tr>
          <tr> 
            <td width="12%">&nbsp;</td>
            <td width="24%">&nbsp;</td>
            <td width="64%">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3"> 
              <div align="center">
                <input name="id" type="hidden" id="id" value="{id}">
                <input type="hidden" name="uname" value="{username}">
                <input type="hidden" name="do" value="saveeuser">
                <input type="submit" class="forminput" name="Submit" value="Submit">
              </div>
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
</form>
