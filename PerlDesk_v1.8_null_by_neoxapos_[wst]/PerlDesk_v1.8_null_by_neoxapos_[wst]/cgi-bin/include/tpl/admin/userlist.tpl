
<table width="100%" border="0">
  <tr>
    <td width="100%" height="35">
      <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%" height="23" valign="top">
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
    <td height="35"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      Users</b></font><br>
    </td> 
  </tr>
  <tr>
    <td height="21" valign="top"><p align="right"><img src="{imgbase}/search_white.gif" width="16" height="17">  <a href="#s"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Search
    Users</font></a></p>
    </td>
  </tr>
  <tr>
    <td height="40" valign="middle"> 
      <div align="right"> 
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td> 
              <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
            Displaying {from} - {to} of {total} Users</strong></font></div></td>
          </tr>
          <tr> 
            <td height="24"><hr></td>
          </tr>
          <tr>
            <td height="16"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{nav}&nbsp;</font></div></td>
          </tr>
          <tr>
            <td height="24"><br>
            {userlist}{navbar} </td>
          </tr>
        </table>
      </div>
    </td> 
  </tr>
  <tr>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><form action="admin.cgi" method="post">
    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr bgcolor="#93A6BF">
        <td height="20" colspan="3"> <font color="#333333" size="2" face="Trebuchet MS, Verdana, Arial"><strong>&nbsp; <a name="s"></a><font color="#000000">Search
              Clients
                <input name="do" type="hidden" id="do" value="search_clients">
        </font></strong></font></td>
      </tr>
      <tr bgcolor="#C8D2DF">
        <td width="51%" height="39"><div align="center">
            <input name="query" type="text" class="tbox" size="40">
          </div>
        </td>
        <td width="22%"><div align="center">
            <select name="area" class="tbox">
                  <option value="username">Username</option>
                  <option value="name">Name</option>
                  <option value="email">E-Mail</option>
                </select>
          </div>
        </td>
        <td width="27%"><div align="center">
            <input type="submit" name="Submit" value="Search" class="forminput">
          </div>
        </td>
      </tr>
    </table></form></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
