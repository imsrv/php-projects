<!-- {{ The login template for PerlDesk }} -->

<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="3" height="2"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
          <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font></div></td>
    </tr>
    <tr> 
      <td colspan="3" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="middle"> <div align="center"> 
          <table width="95%" border="0" cellspacing="1" align="center" cellpadding="3">
            <tr> 
              <td width="94%" valign="middle"><font size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif"><a href="{baseurl}/{mainfile}?do=login&lang={lang}"><font face="Trebuchet MS, Verdana, Arial" size="3">{title}</font></a><font face="Trebuchet MS, Verdana, Arial" size="3">: 
                Track Request</font></font></b></font></td>
            </tr>
            <tr> 
              <td valign="middle">&nbsp;</td>
            </tr>
            <tr> 
              <td height="49" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">If 
                you are already a registered user, it is recommended you login 
                to the members area to track a support issue.</font></td>
            </tr>
            <tr> 
              <td valign="middle"> <table width="65%" border="0" cellspacing="2" align="center" cellpadding="4">
                  <tr> 
                    <td width="12%" height="24" valign="middle">&nbsp;</td>
                    <td width="30%" valign="middle"> <div align="left"><span class="tbox"><span class="tbox"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Request 
                        ID</font></span></span></div></td>
                    <td width="58%" valign="middle"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><span class="tbox"><span class="tbox"><span class="tbox"><span class="tbox"> 
                        <input name="id" type="text" class="gbox" id="id" size="10">
                        </span></span></span></span> </font></div></td>
                  </tr>
                  <tr> 
                    <td width="12%" valign="middle">&nbsp;</td>
                    <td width="30%" valign="middle"> <div align="left"><span class="tbox"><span class="tbox"><span class="tbox"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Key</font> 
                        </span> </span></span></div></td>
                    <td width="58%" valign="middle"> <div align="left"><span class="tbox"><span class="tbox"> 
                        <span class="tbox"><span class="tbox"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input name="key" type="password" class="gbox" id="key" size="25">
                        </font></span></span> </span></span></div></td>
                  </tr>
                  <tr> 
                    <td colspan="3" valign="middle" height="50"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input name=lang type=hidden id="lang" value={lang}>
                        <input type="submit" name="Submit" value="    Track   " onclick="DisableForm(this.form);" class="forminput">
                        <input name=do type=hidden id="do" value=track_call>
                        </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                        </font> </div></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <td valign="middle">&nbsp;</td>
            </tr>
          </table>
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
  <span class="tbox"></span> 
</form>