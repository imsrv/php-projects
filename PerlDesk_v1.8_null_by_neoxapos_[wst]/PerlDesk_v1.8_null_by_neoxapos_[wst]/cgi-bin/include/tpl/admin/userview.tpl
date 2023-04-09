
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr>
    <td height="36" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      <a href="admin.cgi?do=users">Users</a>: View User</b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr> 
          <td height="48" colspan="2" valign="top"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=deluser&amp;user={username}"> 
              Delete User</a> | <a href="admin.cgi?do=usercalls&amp;user={username}">View 
              Requests</a> | <a href="admin.cgi?do=edituser&amp;user={username}">Edit 
              User</a></b></font></div></td>
        </tr>
        <tr> 
          <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></td>
          <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{name}</font></td>
        </tr>
        <tr> 
          <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
          <td width="72%"><a href="mailto:{email}"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{email}</font></a></td>
        </tr>
        {fields} 
        <tr> 
          <td width="19%">&nbsp;</td>
          <td width="72%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="19%">&nbsp;</td>
          <td width="72%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{activate}</font><br> 
            <hr> <br> </td>
        </tr>
        <tr> 
          <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Departmental 
                  Submissions</strong></font></td>
                <td><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Request 
                  Tally</font></strong></td>
              </tr>
              <tr> 
                <td width="60%" rowspan="2">{graph1} 
                  <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                    *Others reflects departments which have since been removed 
                    from the system<br>
                    </font></p></td>
                <td width="40%" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr bgcolor="#EBEBEB"> 
                      <td width="33%"><strong><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Open 
                        </font></strong></td>
                      <td width="33%"><strong><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">{open}</font><font color="#006633" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        </font></strong></td>
                    </tr>
                    <tr bgcolor="#EBEBEB"> 
                      <td><strong><font color="#006633" size="2" face="Verdana, Arial, Helvetica, sans-serif">Hold</font></strong></td>
                      <td><strong><font color="#006633" size="2" face="Verdana, Arial, Helvetica, sans-serif">{hold}</font></strong></td>
                    </tr>
                    <tr bgcolor="#EBEBEB"> 
                      <td><strong><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">Closed</font></strong></td>
                      <td bgcolor="#EBEBEB"><strong><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">{closed}</font></strong></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr bgcolor="#EBEBEB"> 
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Total</strong></font></td>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>{requests}</strong></font></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td width="40%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

