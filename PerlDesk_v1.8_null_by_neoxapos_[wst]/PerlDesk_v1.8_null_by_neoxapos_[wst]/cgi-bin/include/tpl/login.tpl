<!-- {{ The login template for PerlDesk }} -->

<form action="{mainfile}" method=post>
  <table width="90%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="3" height="2"> 
        <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="{mainfile}?do=register&lang={lang}"><img src="{imgbase}/user_register.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=submit_ticket&lang={lang}"><img src="{imgbase}/user_submitreq.gif" width="104" height="19" border="0"></a> 
          <a href="{mainfile}?do=track&lang={lang}"><img src="{imgbase}/user_track.gif" width="104" height="19" border="0"></a> 
          <a href="kb.cgi"> <img src="{imgbase}/user_kb.gif" width="104" height="19" border="0"></a></strong></font></div>
      </td>
    </tr>
    <tr> 
      <td colspan="3" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" valign="middle"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%maintxt%</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <br>
          </font></div>
      </td>
    </tr>
    <tr> 
      <td valign="middle"> 
        <div align="center"> 
          <table width="95%" border="0" cellspacing="0" align="center" cellpadding="0">
            <tr> 
              <td width="57%" valign="middle"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{error}</font></div></td>
            </tr>
          </table>
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td valign="middle" height="44" width="49%"> 
                <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
                  <tr>
                    <td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td width="28%" valign="middle"> <div align="center"><span class="tbox"><span class="tbox"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%username%</font> 
                        </span></span></div></td>
                    <td width="29%" valign="middle"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><span class="tbox"><span class="tbox"><span class="tbox"><span class="tbox"> 
                        <input type="text" name="username" class="gbox" size="25" value="{user}">
                        </span></span></span></span> </font></div></td>
                  </tr>
                  <tr> 
                    <td width="28%" valign="middle"> <div align="center"><span class="tbox"><span class="tbox"><span class="tbox"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%password%</font> 
                        </span> </span></span></div></td>
                    <td width="29%" valign="middle"> <div align="right"><span class="tbox"><span class="tbox"> 
                        <span class="tbox"><span class="tbox"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input type="password" name="password" class="gbox" size="25">
                        </font></span></span> </span></span></div></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="middle" height="35"> <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%remember% 
                        <input type="checkbox" name="remember" value="yes" class="tbox">
                        </font> </div></td>
                  </tr>
                  <tr> 
                    <td colspan="2" valign="middle" height="35"> <div align="right"> 
                        <table width="100%" border="0">
                          <tr> 
                            <td width="46%">&nbsp;</td>
                            <td width="54%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                <input type=hidden name=lang2 value={lang}>
                                <input type="submit" name="Submit" value="  Login  " onClick="DisableForm(this.form);" class="forminput">
                                </font></div></td>
                          </tr>
                        </table>
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        </font></div></td>
                  </tr>
                </table>
              </td>
              <td colspan="2" valign="middle" height="44" width="51%"> 
                <div align="center">
                  <table width="85%" border="0" cellspacing="0" align="right" cellpadding="0">
                    <tr> 
                      <td valign="middle">&nbsp;</td>
                      <td valign="middle">&nbsp;</td>
                      <td valign="middle">&nbsp;</td>
                      <td valign="middle">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td width="4%" valign="top" bgcolor="#CFD9EB"><img src="{imgbase}/blue_topleft.gif" width="13" height="11"></td>
                      <td width="51%" valign="middle" bgcolor="#CFD9EB"> <div align="center"><font size="2" face="Trebuchet MS, Verdana, Arial"><strong>Login 
                          Help?</strong></font></div></td>
                      <td width="0%" valign="top" bgcolor="#CFD9EB"><img src="{imgbase}/blue_topright.gif" width="13" height="11"></td>
                      <td width="45%" valign="middle"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><span class="tbox"><span class="tbox"><span class="tbox"><span class="tbox"> 
                          </span></span></span></span> </font></div></td>
                    </tr>
                    <tr bgcolor="#CFD9EB"> 
                      <td colspan="4" valign="middle"> </td>
                    </tr>
                    <tr> 
                      <td colspan="4" valign="middle" height="10"></td>
                    </tr>
                    <tr> 
                      <td colspan="4" valign="middle" height="35"> <div align="right"> 
                          <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif">If 
                            you have forgotten your support password, please click 
                            below. </font></p>
                          <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                            [ <a href="{mainfile}?do=lpass&lang={lang}">%lpassword%</a> 
                            ]</font></p>
                        </div></td>
                    </tr>
                    <tr> 
                      <td colspan="4" valign="middle" height="35"> <div align="right"> 
                          <table width="100%" border="0">
                            <tr> 
                              <td width="46%">&nbsp;</td>
                              <td width="54%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  </font></div></td>
                            </tr>
                          </table>
                          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                          </font></div></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
          </table>
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td colspan="2" valign="middle" height="35"> 
                <div align="center"></div>
              </td>
            </tr>
            <tr> 
              <td colspan="2" valign="middle" height="35"> 
                <div align="center">{htmlbar}</div>
              </td>
            </tr>
            <tr> 
              <td colspan="2"> 
                <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  <input type="hidden" name="lang" value="{lang}">
                  <input type="hidden" name="do" value="pro_login">
                  </font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <span class="tbox"></span> 
</form>