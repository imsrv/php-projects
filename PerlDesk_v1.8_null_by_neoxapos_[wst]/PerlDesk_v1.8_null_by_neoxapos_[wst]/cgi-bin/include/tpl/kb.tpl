<!-- {{ The main Knowledge Base page }} -->

<form action="kb.cgi?search" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr>
      <td height="15" valign="top">
        <div align="center"> 
          <p align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
            <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
            <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
            <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a><br>
            &nbsp; </strong></font></p>
      </div></td>
    </tr>
    <tr><td height="15"><div align="center"> 
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td> 
                <div align="left"><font size="2"><b><font face="Verdana, Arial, Helvetica, sans-serif"><a href="{baseurl}/{mainfile}?do=login&lang={lang}"><font face="Trebuchet MS, Verdana, Arial" size="3">{title}</font></a><font face="Trebuchet MS, Verdana, Arial" size="3">: 
                  %kb%</font></font></b></font></div>
              </td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div align="center">
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td valign="top"><font color="#000066" size="2" face="Trebuchet MS, Verdana, Arial"><strong>%category%</strong></font></td>
              <td width="3%" rowspan="3" valign="top">&nbsp;</td>
              <td width="70%" rowspan="3" valign="top"> <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
                  <tr> 
                    <td bgcolor="#336633"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td height="24"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;<b>%search% 
                            %kb%</b></font></td>
                          <td width="1%"><div align="right"><img src="{imgbase}/admin/green_corner.gif" width="18" height="24"></div></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#F5F5F5"> 
                      <table width="90%" border="0" cellspacing="1" cellpadding="2" align="center">
                        <tr> 
                          <td width="31%" height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%query% 
                            </font></td>
                          <td width="69%"> <input type="text"  class="tbox" name="query" size="20"> 
                          </td>
                        </tr>
                        <tr> 
                          <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%category% 
                            </font></td>
                          <td width="69%"> <select  class="tbox" name="select">
                             {category}                              
                            </select> </td>
                        </tr>
                        <tr> 
                          <td colspan="2" height="32"> <div align="right"> 
                              <input type="hidden" name="lang" value="{lang}">
                              <input type="submit" name="Submit" class="forminput" value="  %submit%  ">
                            </div></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <table width="95%" border="0" cellspacing="1" cellpadding="0" align="center">
                  <tr> 
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr bgcolor="#6C7CA2"> 
                          <td height="22"> <table width="100%" border="0" cellpadding="1">
                              <tr> 
                                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#FFFFFF">%recarticles%</font></b></font></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr bgcolor="#CCCCCC"> 
                          <td> <table width="100%" border="0" cellspacing="1" callpadding="0">
                              {list} </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
            <tr> 
              <td height="21" valign="top"><font color="#999999" face="Arial, Helvetica, sans-serif"><img src="{imgbase}/kb_dots.gif" width="216" height="4"></font></td>
            </tr>
            <tr> 
              <td width="27%" valign="top"><p>{categories}</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> 
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </td>
    </tr>
  </table>
</form>

