<!-- {{ The registration/signup form }} -->

<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="2"> 
        <table width="100%" border="0" cellspacing="1" align="center">
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td> 
                    <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
                      <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
                      <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
                      <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font></div>
                  </td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td> <font size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif"><a href="{baseurl}/{mainfile}?do=login&lang={lang}"><font face="Trebuchet MS, Verdana, Arial" size="3">{title}</font></a><font face="Trebuchet MS, Verdana, Arial" size="3">: 
                    %registration%</font></font></b></font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>
              <table width="87%" border="0" cellspacing="1" align="center">
                <tr> 
                  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>%step% 
                    1 </b> - %step1text%</font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table width="87%" border="0" cellspacing="1" align="center">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Registering
                for a help desk account takes only a minute and allows you to
            view and track any of your submissions from the web interface.</font></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>        
        <table width="62%" border="0" cellspacing="1" align="center">
          <tr> 
            <td colspan="2"><font size="1" face="Trebuchet MS, Verdana, Arial" color="#990000">{error}</font></td>
          </tr>
          <tr> 
            <td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%username%</font></td>
            <td width="68%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" name="username" class="tbox" value="{username}">
              </font></td>
          </tr>
          <tr> 
            <td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%password%</font></td>
            <td width="68%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="password" name="password" class="tbox" value="{password}">
              </font></td>
          </tr>
          <tr> 
            <td width="32%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">%password%</font></td>
            <td width="68%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="password" name="password2" class="tbox" value="{password2}">
              </font></td>
          </tr>
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%name%</font></td>
            <td width="68%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" name="name" class="tbox" value="{name}">
              </font></td>
          </tr>
          <tr> 
            <td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%email% 
              </font></td>
            <td width="68%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" name="email" class="tbox" value="{email}">
              </font></td>
          </tr>{fields}
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
          </tr>
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%">&nbsp;</td>
          </tr>
        </table>
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <input type="hidden" name="do" value="register2">
 <input type="hidden" name="lang" value="{lang}">
          <input type="submit" name="Submit" class="forminput"  onclick="DisableForm(this.form);" value="%submit%">
          </font></div>
      </td>
    </tr>
  </table>
</form>