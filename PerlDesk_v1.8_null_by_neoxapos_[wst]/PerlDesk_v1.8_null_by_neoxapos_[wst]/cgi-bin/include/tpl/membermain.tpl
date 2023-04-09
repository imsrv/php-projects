<!-- {{ This is the Home section of the members area, where an overview of calls and announcements can be viewed. }} --> 
<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr> 
      <td colspan="2"> 
        <div align="center"> 
          <table width="482" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td> 
                {usernav}
              </td>
            </tr>
            <tr> 
              <td> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, {name}</font></a></font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <table width="100%" border="0" cellspacing="1" align="center" cellpadding="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>%welcome%, 
              {name} !</b></font></td>
          </tr>
          <tr> 
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%welc1main% 
              {name}. %welc2main%.<br>
              </font></td>
          </tr>
          <tr> 
            <td height="2">{numcalls} </td>
          </tr>
          <tr>
            <td height="22"> 
              <div align="right"><font face="Verdana" size="1">PAGE: {nav}</font> 
              </div>
            </td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" align="center" height="19">
                <tr class="usertab"> 
                  <td width="12%"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%callid%</font></td>
                      </tr>
                      <tr> 
                        <td height="5"> 
                          <div align="right"><font size="1"><a href="{mainfile}?do=main&sort=id&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                            <a href="{mainfile}?do=main&sort=id&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="10%"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%status%</font></td>
                      </tr>
                      <tr> 
                        <td height="5"> 
                          <div align="right"><font size="1"><a href="{mainfile}?do=main&sort=status&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                            <a href="{mainfile}?do=main&sort=status&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="9%"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%priority%</font></td>
                      </tr>
                      <tr> 
                        <td height="5"> 
                          <div align="right"><font size="1"><a href="{mainfile}?do=main&sort=priority&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                            <a href="{mainfile}?do=main&sort=priority&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="45%" class="usertab"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%subject%</font></td>
                      </tr>
                      <tr> 
                        <td height="5"> 
                          <div align="right"><font size="1"><a href="{mainfile}?do=main&sort=subject&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                            <a href="{mainfile}?do=main&sort=subject&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="24%"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%whenlogged%</font></td>
                      </tr>
                      <tr> 
                        <td height="5"> 
                          <div align="right"><font size="1"><a href="{mainfile}?do=main&sort=time&method=asc"><img src="{imgbase}/up.gif" width="8" height="5" border="0"></a> 
                            <a href="{mainfile}?do=main&sort=time&method=desc"><img src="{imgbase}/down.gif" width="8" height="5" border="0"></a></font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <div align="center">{listofcalls}</div>
            </td>
          </tr>
          <tr> 
            <td height="36"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Displaying 
              {from}-{to} of {total} results</font></td>
          </tr>
          <tr> 
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
              </font></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td> 
                    <table width="100%" border="0">
                      <tr> 
                        <td colspan="2" valign="top"> 
                          <table width="99%" border="0" cellspacing="1" cellpadding="1">
                            <tr class=usertab> 
                              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>%announcement%</b></font></td>
                            </tr>
                            <tr> 
                              <td bgcolor="#FFFFFF">{announcement}</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr> 
                        <td width="65%">&nbsp;</td>
                        <td width="35%">&nbsp;</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <input type="hidden" name="action" value="submitreq">
          </font></div>
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
