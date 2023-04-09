

  
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
      Incoming Email Settings</b></font></td>
  </tr>
  <tr> 
    <td><form name="form2" method="post" action="admin.cgi">
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="3" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Submission 
              Access</b></font></td>
          </tr>
          <tr> 
            <td width="51%" height="34"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">REQUIRE 
              REGISTRATION </font></td>
            <td width="15%" height="34"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="reqreg" class="gbox">
                
						{selected}                       
                
                </select>
                </font></div></td>
            <td width="34%" height="34"> <div align="center"> 
                <input name=do type=hidden id="do" value=emailsettings>
                <input type="submit" class="forminput" name="Submit2" value="Submit">
              </div></td>
          </tr>
          <tr> 
            <td colspan="3"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Setting 
              this to Yes will require all users to have an account before they 
              are able to log calls via email submission. Setting it no No allows 
              anyone to log a call via email. </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
          </tr>
        </table>
        <br>
      </form></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="42" valign="middle"> <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
      </table>
      <p><img src="{imgbase}/dot.gif"> <b><font face="Trebuchet MS, Verdana" size="2">Blocked 
        Addresses</font></b></p></td>
  </tr>
  <tr> 
    <td valign="top"><form name="form2" method="post" action="admin.cgi">
        <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
          <tr> 
            <td colspan="3" height="49"> <div align="center"> 
                <table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
                  <tr valign="middle"> 
                    <td width="34%" height="12">&nbsp;</td>
                    <td width="12%" height="12">&nbsp;</td>
                    <td width="54%">&nbsp;</td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="12"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Blocked 
                      Addresses </font></td>
                    <td height="12"> <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{cad} 
                        </font></div></td>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">(<a href="admin.cgi?do=view_blocked&type=address">view</a>) 
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Blocked 
                      Domains </font></td>
                    <td height="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">{cdom}</font></td>
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                      (<a href="admin.cgi?do=view_blocked&type=domain">view</a>) 
                      </font></td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4">&nbsp;</td>
                    <td height="4">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr valign="middle"> 
                    <td height="4" colspan="3"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input name="email" type="text" class="tbox" id="email" size="20">
                        </font> 
                        <select name="type" class="tbox" id="type">
                          <option value="domain">Domain</option>
                          <option value="address">Address</option>
                        </select>
                        <input name="add" type="submit" class="forminput" id="add" value="Add">
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input name=do type=hidden id="do" value=emailsettings>
                        </font></div></td>
                  </tr>
                  <tr valign="middle"> 
                    <td colspan="3" height="2">&nbsp;</td>
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
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="{imgbase}/dot.gif" width="13" height="11"> 
      Incoming Email Addresses</strong></font></td>
  </tr>
  <tr> 
    <td> <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><div align="right"><a href="admin.cgi?do=popserver"><img src="{imgbase}/admin/manage_pop_servers.gif" width="169" height="25" border="0"></a></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
        <tr> 
          <td colspan="3" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Manage 
            Incoming Addresses</b></font></td>
        </tr>
        <tr> 
          <td colspan="3" height="49"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">{directs}</font></div></td>
        </tr>
        <tr> 
          <td colspan="3" height="21"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Add 
            New Incoming Address</b></font></td>
        </tr>
        <tr> 
          <td colspan="3"> <form name="form1" method="post" action="admin.cgi">
              <input type=hidden name=do value=emailsettings>
              <table width="80%" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr valign="middle"> 
                  <td width="34%" height="4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" class="tbox" name="address" size="20" value="ticket@domain.com">
                    </font></td>
                  <td width="30%" height="4"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>-&gt; 
                      </b> </font></div></td>
                  <td width="36%" height="4"> <select name="select">{categories}
                    </select> </td>
                  <td width="36%" height="4"> <input type="submit" class="forminput" name="add" value="Add"> 
                  </td>
                </tr>
              </table>
            </form>
            &nbsp;</td>
        </tr>
      </table></td>
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
