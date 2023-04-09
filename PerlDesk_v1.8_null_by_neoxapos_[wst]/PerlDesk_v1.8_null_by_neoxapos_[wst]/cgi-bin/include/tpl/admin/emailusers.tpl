
<table width="100%" border="0" align="center">
  <tr> 
    <td> </td>
  </tr>
  <tr>
    <td height="32" valign="top"> 
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
  <tr> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=users">Users</a>: Email Users</b></font></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"> 
      <form name="form1" method="post" action="admin.cgi">
        <table width="100%" border="0" cellspacing="2" cellpadding="6">
          <tr> 
            <td colspan="2"> 
              <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Below, 
                you can send an email to all users with a registered account on 
                the help desk. </font></div>
            </td>
          </tr>
          <tr> 
            <td width="23%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">From 
              Email:</font></b></td>
            <td width="77%"> 
              <input type="text" class="gbox" name="email" size="55">
            </td>
          </tr>
          <tr> 
            <td width="23%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></b></td>
            <td width="77%"> 
              <input type="text" class="gbox" name="subject" size="55">
            </td>
          </tr>
          <tr> 
            <td width="23%" valign="top"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Message:</font></b></td>
            <td width="77%"> 
              <textarea name="message" class="gbox" cols="65" rows="20"></textarea>
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="hidden" name="do" value="usersend">
          <input type="submit" class="forminput" name="Submit" value="Submit">
        </p>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
