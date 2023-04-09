<!-- {{ View an article in the Knowledge Base }} -->
 
<form action="kb.cgi" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr> 
      <td> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
          <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font><br>
          &nbsp; </div></td>
    </tr>
    <tr> 
      <td> <div align="center"> </div></td>
    </tr>
    <tr> 
      <td> <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center">
          <tr> 
            <td> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr> 
                  <td width="62%" valign="top" bgcolor="#FFFFFF"> <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td> <div align="left"><font size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif"><a href="{baseurl}/{mainfile}?do=login&lang={lang}"><font face="Trebuchet MS, Verdana, Arial" size="3">{title}</font></a><font face="Trebuchet MS, Verdana, Arial" size="3">: 
                            %kb%</font></font></b></font></div></td>
                      </tr>
                      <tr> 
                        <td> <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                            </font></div></td>
                      </tr>
                    </table> </td>
                  <td width="38%" bgcolor="#FFFFFF"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
                      <tr> 
                        <td bgcolor="#336633"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td height="24"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;<b>Email 
                                Article </b></font></td>
                              <td width="1%"><div align="right"><img src="{imgbase}/admin/green_corner.gif" width="18" height="24"></div></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td bgcolor="#F5F5F5"> <table width="90%" border="0" cellspacing="1" cellpadding="2" align="center">
                            <tr> 
                              <td width="31%" height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">E-Mail</font></td>
                              <td width="58%"> <input name="email" type="text"  class="tbox" id="email" size="15"> 
                              </td>
                              <td width="11%" valign="middle"><input type="image" src="{imgbase}/go1.gif" width="10" height="10"> 
                              </td>
                            </tr>
                          </table>
                          <input name="do" type="hidden" id="do" value="email_article">
                          <input name="id" type="hidden" id="id" value="{id}"></td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td colspan="2" bgcolor="#FFFFFF"><table width="90%" border="0" cellspacing="1" cellpadding="0" align="center">
                      <tr> 
                        <td width="100%"><font color="#000066" size="3" face="Trebuchet MS, Verdana, Arial"><b><img src="{imgbase}/article.gif" width="14" height="13"> 
                          {subject}</b></font></td>
                      </tr>
                      <tr> 
                        <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>{author}</em></font></div></td>
                      </tr>
                      <tr> 
                        <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{article}</font></td>
                      </tr>
                    </table> </td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>

