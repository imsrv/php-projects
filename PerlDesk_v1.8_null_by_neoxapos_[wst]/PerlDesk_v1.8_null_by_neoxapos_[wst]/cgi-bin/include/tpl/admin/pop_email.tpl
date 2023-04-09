

  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top"> 
    <td height="42"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
        <tr> 
          <td width="91%"> <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=settings"><img src="{imgbase}/admin/general.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=emailsettings"><img src="{imgbase}/admin/incoming_email.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=hdsettings"><img src="{imgbase}/admin/web_desk.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=tpl"><img src="{imgbase}/admin/templates.gif" width="104" height="19" border="0"></a> 
              <a href="admin.cgi?do=departments"><img src="{imgbase}/admin/departments.gif" width="104" height="19" border="0"></a></strong></font></div></td>
        </tr>
        <tr> 
          <td width="91%">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr valign="top"> 
    <td height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      POP Retrival Email Settings</b></font></td>
  </tr>
  <tr>
    <td height="42" valign="middle"><div align="center">
        <table width="70%" border="0" cellspacing="0" cellpadding="2">
          {servers}
        </table>

        <br>
        <table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td bgcolor="#000000"> 
              <div align="right">
                <table width="100%" border="0" cellspacing="1" cellpadding="4">
                  <tr> 
                    <td bgcolor="#CBCCEB"> <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Automating 
                        POP Retrieval<br>
                        You can use the button below to retrieve emails from your 
                        pop email accounts, but it is recommended you automate 
                        this by executing the <font face="Courier New, Courier, mono">include/pop-email.cgi</font> 
                        file periodically using cron.</font></div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
        <table width="80%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td height="23">&nbsp;</td>
          </tr>
          <tr> 
            <td height="23"> 
              <div align="right"><a href="#" onClick="Popup('admin.cgi?do=download_pop', 'Window', 305, 200)"><img src="{imgbase}/admin/retrieve_mail.gif" width="110" height="19" border="0"></a></div></td>
          </tr>
        </table>
        </div></td>
  </tr>
  <tr> 
    <td height="42" valign="middle"> <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
      </table>
      <p><img src="{imgbase}/dot.gif"> <b><font face="Trebuchet MS, Verdana" size="2">Add 
        New POP Server</font></b></p></td>
  </tr>
  <tr> 
    <td valign="top"><form name="form2" method="post" action="admin.cgi">
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="3" height="49"> <div align="center"> 
                <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
                  <tr valign="middle"> 
                    <td width="34%" height="12">&nbsp;</td>
                    <td width="54%">&nbsp;</td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="24"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">POP 
                      HOST </font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <input name="host" type="text" class="tbox" id="host" size="20">
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">POP 
                      Username </font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <input name="user" type="text" class="tbox" id="user" size="20">
                      </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">POP 
                      Password</font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <input name="password" type="text" class="tbox" id="password" size="20">
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">POP 
                      Port</font></td>
                    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                      <input name="port" type="text" class="tbox" id="port" value="110" size="5">
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4" colspan="2"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        </font> 
                        <input name="add" type="submit" class="forminput" id="add" value="Add New Server">
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input name=do type=hidden id="do" value=save_pop>
                        </font></div></td>
                  </tr>
                  <tr valign="middle"> 
                    <td colspan="2" height="2">&nbsp;</td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="340" valign="top"> <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td> </td>
        </tr>
      </table></td>
  </tr>
</table>
