

  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top">
    <td height="42" valign="top">
      <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=settings"><img src="{imgbase}/admin/general.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=emailsettings"><img src="{imgbase}/admin/incoming_email.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=hdsettings"><img src="{imgbase}/admin/web_desk.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=tpl"><img src="{imgbase}/admin/templates.gif" width="104" height="19" border="0"></a> 
        <a href="admin.cgi?do=departments"><img src="{imgbase}/admin/departments.gif" width="104" height="19" border="0"></a></strong></font></div>
    </td>
  </tr>
  <tr valign="top"> 
    <td height="42" valign="top"><font size="2" face="Trebuchet MS, Verdana"><b><a href="../PRO/admin.cgi?do=main">Admin</a>: 
      Email Settings</b></font></td>
  </tr>
  <tr> 
    <td height="42" valign="middle"> <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
      </table>
      <p><img src="{imgbase}/dot.gif"> <b><font face="Trebuchet MS, Verdana" size="2">Blocked 
        Listings </font></b></p></td>
  </tr>
  <tr> 
    <td valign="top"><form name="form2" method="post" action="admin.cgi">
      <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
        <tr>
          <td colspan="3" height="49">
            <div align="center">
              <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr valign="middle">
                  <td width="34%" height="12">&nbsp;</td>
                  <td width="12%" height="12">&nbsp;</td>
                  <td width="54%">&nbsp;</td>
                </tr>
                <tr valign="middle">
                  <td height="4" colspan="3"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      <select name="email" size="10" multiple class="tbox" id="email">
                        
                         {list}

                        
                      </select>
                    </font></div>
                  </td>
                </tr>
                <tr valign="middle">
                  <td height="4">&nbsp;</td>
                  <td height="4">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="middle">
                  <td height="4" colspan="3"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font>
                          <input name="remove" type="submit" class="forminput" id="remove" value="Remove Address">
                          <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                          <input name=do type=hidden id="do" value=remove_blocked>
                          <input name=tpl type=hidden id="tpl" value=settings>
                        </font></div>
                  </td>
                </tr>
                <tr valign="middle">
                  <td colspan="3" height="2">&nbsp;</td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
