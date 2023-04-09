
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td colspan="3"> 
            <form name="form1" method="post" action="admin.cgi">
              
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr valign="top">
            <td colspan="3" height="41">
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr> 
                  <td width="91%">
                    <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=settings"><img src="{imgbase}/admin/general.gif" width="104" height="19" border="0"></a> 
                      <a href="admin.cgi?do=emailsettings"><img src="{imgbase}/admin/incoming_email.gif" width="104" height="19" border="0"></a> 
                      <a href="admin.cgi?do=hdsettings"><img src="{imgbase}/admin/web_desk.gif" width="104" height="19" border="0"></a> 
                      <a href="admin.cgi?do=tpl"><img src="{imgbase}/admin/templates.gif" width="104" height="19" border="0"></a> 
                      <a href="admin.cgi?do=departments"><img src="{imgbase}/admin/departments.gif" width="104" height="19" border="0"></a></strong></font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="91%">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr valign="top"> 
            <td colspan="3" height="16"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
              Settings</b></font></td>
          </tr>
          <tr>
            <td height="2" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" height="42"><img src="{imgbase}/dot.gif"> <b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>General
            Configuration</b></font></b></td>
          </tr>
          <tr>
            <td colspan="3" height="42">
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr> 
                  <td width="36%" height="34"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">HELP 
                    DESK TITLE</font></td>
                  <td width="64%" height="34"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px"  name="title" value="{title}" size="40">
                    </font></td>
                </tr>
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">HELP 
                    DESK URL</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px"  name="baseurl" value="{baseurl}" size="40">
                    </font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">UPLOAD 
                    DIRECTORY</font></td>
                  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input  name="file_path" type="text" id="file_path2" style="font-size: 12px" value="{file}" size="40">
                    <font color="#990000" size="1">{perm}</font></font></td>
                </tr>
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">IMAGE 
                    URL</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px"  name="imgbase" value="{imgbase}" size="40">
                    </font></td>
                </tr>
                <tr>
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">LOGO 
                    URL </font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="text" style="font-size: 12px"  name="logo" value="{logo}" size="40">
                    </font></td>
                </tr>
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">DEFAULT 
                    LANGUAGE</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px"  name="language" size="2" value="{lang}">
                    <font size="1"> <font color="#666666">(en | es | sw | no )</font></font></font></td>
                </tr>
                <tr> 
                  <td width="36%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">TIME 
                    OFFSET</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px"  name="time" size="2" value="{offset}">
                    <font size="1" color="#333333">Current time: {hdtime}</font></font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="3" height="42"><img src="{imgbase}/dot.gif"> <b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Outgoing
                  Email</font></b></td>
          </tr>
          <tr>
            <td colspan="3" height="42"><table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr>
                  <td height="34"><input type="radio" name="sendmail" value="0"{sendmail}>
                  </td>
                  <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Sendmail</strong></font></td>
                </tr>
                <tr>
                  <td width="4%" height="30">&nbsp;</td>
                  <td width="32%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">SENDMAIL
                      PATH </font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <input  name="sendmail_path" type="text" id="sendmail_path" style="font-size: 12px" value="{sendmail_path}" size="40">
                  </font></td>
                </tr>
                <tr>
                  <td width="4%" height="34"><input type="radio" name="sendmail" value="1"{smtp}>
                  </td>
                  <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>SMTP</strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font></td>
                </tr>
                <tr>
                  <td width="4%">&nbsp;</td>
                  <td width="32%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">SMTP
                      Address</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <input  name="smtp_address" type="text" id="smtp_address" style="font-size: 12px" value="{smtp_add}" size="40">
                  </font></td>
                </tr>
              </table>
              <br>
              <table width="90%" border="1" cellspacing="0" cellpadding="3" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr> 
                  <td height="34" colspan="3"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Email 
                    Footer </strong></font></td>
                </tr>
                <tr> 
                  <td rowspan="2" height="30" width="4%">&nbsp;</td>
                  <td colspan="2" width="96%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">You 
                    can add a footer to all outgoing emails below. This can be 
                    used for your companies email legal disclaimer or privacy 
                    poilicy. </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    </font></td>
                </tr>
                <tr> 
                  <td colspan="2" width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <textarea name="footer" id="smtp_address" class="tbox" cols="80" rows="5">{footer}
</textarea>
                    </font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="43" colspan="3"><img src="{imgbase}/dot.gif"> <b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">General
                  Help Desk Settings</font></b></td>
          </tr>
          <tr> 
            <td colspan="3"> 
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ADMIN 
                    PASSWORD</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="password" style="font-size: 12px" name="password" size="30">
                    </font></td>
                </tr>
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ADMIN 
                    EMAIL </font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="text" style="font-size: 12px" name="email" value="{adminemail}" size="30">
                    </font></td>
                </tr>
                <tr> 
                  <td width="36%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ALERT 
                    OF NEW CALLS?</font></td>
                  <td width="64%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input type="checkbox" name="alert" value="yes"{alert}>
                    <font size="1">(as admin this will alert of ALL new calls)</font> 
                    </font></td>
                </tr>
              </table>
              <br>
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr bgcolor="#E1E1E1"> 
                  <td colspan="3" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket 
                    Shading</b></font></td>
                </tr>
                <tr> 
                  <td width="49%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRIORITY 
                    1</font></td>
                  <td width="16%" height="35"> 
                    <table width="80%" border="1" cellspacing="0" cellpadding="1" align="center" height="15" bordercolor="#CCCCCC">
                      <tr bgcolor="{pri1}"> 
                        <td></td>
                      </tr>
                    </table>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="35%" height="35"> 
                    <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                      <input type="text" class="tbox" style="font-size: 12px"  name="pri1" size="8" value="{pri1}">
                      </font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                      </font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="49%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRIORITY 
                    2</font></td>
                  <td width="16%" height="35"> 
                    <table width="80%" border="1" cellspacing="0" cellpadding="1" align="center" height="15" bordercolor="#CCCCCC">
                      <tr bgcolor="{pri2}"> 
                        <td></td>
                      </tr>
                    </table>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="35%" height="35"> 
                    <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                      <input type="text" class="tbox" style="font-size: 12px"  name="pri2" size="8" value="{pri2}">
                      </font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="49%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRIORITY 
                    3</font></td>
                  <td width="16%" height="35"> 
                    <table width="80%" border="1" cellspacing="0" cellpadding="1" align="center" height="15" bordercolor="#CCCCCC">
                      <tr bgcolor="{pri3}"> 
                        <td></td>
                      </tr>
                    </table>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="35%" height="35"> 
                    <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                      <input type="text" class="tbox" style="font-size: 12px"  name="pri3" size="8" value="{pri3}">
                      </font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="49%" height="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRIORITY 
                    4</font></td>
                  <td width="16%" height="2"> 
                    <table width="80%" border="1" cellspacing="0" cellpadding="1" align="center" height="15" bordercolor="#CCCCCC">
                      <tr bgcolor="{pri4}"> 
                        <td></td>
                      </tr>
                    </table>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="35%" height="2"> 
                    <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                      <input type="text" class="tbox" style="font-size: 12px"  name="pri4" size="8" value="{pri4}">
                      </font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="49%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PRIORITY 
                    5</font></td>
                  <td width="16%" height="35"> 
                    <table width="80%" border="1" cellspacing="0" cellpadding="1" align="center" height="15" bordercolor="#CCCCCC">
                      <tr bgcolor="{pri5}"> 
                        <td></td>
                      </tr>
                    </table>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                  <td width="35%" height="35"> 
                    <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                      <input type="text" class="tbox" style="font-size: 12px"  name="pri5" size="8" value="{pri5}">
                      </font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></div>
                  </td>
                </tr>
              </table>
              <br>
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr bgcolor="#E1E1E1"> 
                  <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Staff 
                    Access </b></font></td>
                </tr>
                <tr> 
                  <td width="36%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">STAFF 
                    DELETION </font></td>
                  <td width="64%" height="35"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                    <input type="checkbox" name="staffdelete" value="yes" {sdel}>
                    </font> </font></td>
                </tr>
                <tr bgcolor="#F0F0F0"> 
                  <td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">This 
                    will give staff members the ability to delete user tickets 
                    </font></td>
                </tr>
              </table>
              <br>
              <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                <tr bgcolor="#E1E1E1"> 
                  <td colspan="2" height="25"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>User 
                    Access </b></font></td>
                </tr>
                <tr>
                  <td width="36%" height="35"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Knowledge
                      Base </font></td>
                  <td width="64%" height="35"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">
                    <input name="kb" type="checkbox" id="kb" value="1" {kb}>
                  </font> </font></td>
                </tr>
                <tr> 
                  <td colspan="2" bgcolor="#F0F0F0"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Checking 
                    this feature will set the Knowledge Base to only allow logged 
                    in users to view the Knowledge Base</font></td>
                </tr>
              </table>              <br>
            </td>
          </tr>
          <tr> 
            <td width="3%" height="2">&nbsp;</td>
            <td colspan="2" valign="top" height="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3"> 
              <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name=name type=hidden id="name" value={name}>
                <input type=hidden name=do value=savesettings>
                <input type="submit" class="forminput" name="Submit" value="Submit">
                </font></div>
            </td>
          </tr>
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
            </form>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>

