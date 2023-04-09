  
<table width="100%" border="0">
  <tr> 
    <td> </td>
  </tr>
  <tr valign="top">
    <td height="42">
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
    <td height="42"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
      Settings</b></font></td>
  </tr>
  <tr> 
    <td height="36" valign="top"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td colspan="3"> 
            <div align="center"> 
              <form method="post" action="admin.cgi">
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                    <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Urgent 
                      Ticket Notification</b></font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Notification</font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        <input name="pager" type="checkbox" id="pager" value="1"{pcheck}>
                        </font></font></div>
                    </td>
                    <td width="40%" height="23">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td height="26"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Notification 
                      Address</font></td>
                    <td height="26" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                      <input name="pageraddr" type="text" class="gbox" id="pageraddr" value="{pager}" size="30">
                    </td>
                  </tr>
                </table>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                </font> 
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                    <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Login 
                      / Session Options</b></font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Use 
                      IP in Cookie</font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        <input name="ip" type="checkbox" id="ip" value="1"{ipc}>
                        </font></font></div>
                    </td>
                    <td width="40%" height="23">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="39" colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Enabling 
                      this will record the users IP address in the session cookie, 
                      which will then be checked on every user call. If your users 
                      experience session problems or automatic logouts you may 
                      want to try disabling this.</font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="1" cellspacing="0" cellpadding="2" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td height="23"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Action</font></strong></td>
                    <td height="23"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Require 
                      Logged In User</font></strong></td>
                  </tr>
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Submit 
                      Request</font></td>
                    <td height="23"> 
                      <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <input name="access_submit" type="checkbox" value="1"{a}>
                        </font></font></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">View 
                      Ticket</font></td>
                    <td height="23">
                      <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </font></font><font size="1"> 
                        <input name="access_view" type="checkbox" id="ip22" value="1"{b}>
                        </font></font></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Respond 
                      </font></td>
                    <td height="23">
                      <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </font></font><font size="1"> 
                        <input name="access_respond" type="checkbox" id="ip24" value="1"{c}>
                        </font></font></div>
                    </td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="39" colspan="2"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">Enabling 
                      any of the above will allow users to take the actions without 
                      having an account or logging in, for example, enabling 'Submit 
                      Request' will activate a global submission form for your 
                      installation.s</font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                    <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Staff 
                      Rating</b></font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Enable 
                      Response Rating</font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        <input name="rating" type="checkbox" id="rating" value="1"{rat}>
                        </font></font></div>
                    </td>
                    <td width="40%" height="23">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="39" colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Enabling 
                      this feature will give the additional feature or tracking 
                      the satisfaction of your clients and users, when a ticket 
                      is closed a user will be able to rate the staff members 
                      response and add a comment. </font></td>
                  </tr>
                </table>
                <br>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font> 
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <br>
                </font> 
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="4%" height="32"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                    <td width="96%" height="32"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>User 
                      Options</b></font></td>
                  </tr>
                </table>
                <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="47%" height="23"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Minimum 
                      Password Chars</font></td>
                    <td colspan="2" height="23"> 
                      <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </font></font><font size="1"> 
                        <input name="chars" type="text" class="tbox" id="pageraddr" value="{chars}" size="5">
                        </font></font></div>
                    </td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="39" colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">All 
                      user passwords must be longer than x charachters defined 
                      above. It is recommended you set this to 6 or above.</font></td>
                  </tr>
                </table>
                <br>
                <table width="90%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC">
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">USER 
                      VALIDATION </font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"> 
                        <input type="checkbox" name="usvalid" value="1"{achecked}>
                        </font></font></div>
                    </td>
                    <td width="40%" height="23">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td colspan="3" height="34"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">Admin 
                      must approve all new accounts</font></font></td>
                  </tr>
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">EMAIL 
                      VALIDATION </font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input type="checkbox" name="sendvalid" value="1"{bchecked}>
                        </font></div>
                    </td>
                    <td width="40%" height="23"> 
                      <div align="center">&nbsp;</div>
                    </td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="34" colspan="3"> 
                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">User 
                        must verify email before account i</font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">s 
                        active</font> </font></p>
                    </td>
                  </tr>
                  <tr> 
                    <td width="47%" height="23"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">SIGNUP 
                      NOTIFICATION </font></td>
                    <td width="13%" height="23"> 
                      <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input type="checkbox" name="signup_note" value="1"{scheck}>
                        </font></div>
                    </td>
                    <td width="40%" height="23"> 
                      <div align="center">&nbsp;</div>
                    </td>
                  </tr>
                  <tr bgcolor="#F0F0F0"> 
                    <td height="34" colspan="3"> 
                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1">Send 
                        the Administrator an email when a new perlDesk account 
                        is created</font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></p>
                    </td>
                  </tr>
                </table>
                <p> 
                  <input name="do" type="hidden" id="do" value="upus">
                  <input type="submit" class="forminput" name="Submit2" value="  Update Help Desk Settings  ">
                </p>
              </form>
            </div>
          </td>
        </tr>
        <tr> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr> 
                <td colspan="3"><hr></td>
              </tr>
              <tr> 
                <td width="5%">&nbsp;</td>
                <td width="23%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
                <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
              </tr>
              <tr> 
                <td width="5%">&nbsp;</td>
                <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket 
                  Questions</b></font></td>
              </tr>
              <tr> 
                <td width="5%" height="38">&nbsp;</td>
                <td colspan="2" height="38"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">You 
                  can change the order these fields will appear on the submit 
                  ticket pages by modifying the order field, to delete a field 
                  leave it blank and click 'go'<br>
                  &nbsp; </font></td>
              </tr>
              <tr> 
                <td width="5%">&nbsp;</td>
                <td colspan="2"> <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr bgcolor="#D1DAE7"> 
                      <td width="2%" valign="top" bgcolor="#D1DAE7"><img src="{imgbase}/blue_topleft.gif" width="13" height="11"></td>
                      <td width="96%" rowspan="3" bgcolor="#D1DAE7"> <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                        <form method="post" action="admin.cgi">
                          {fields} 
                          <div align="center"> 
                            <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr> 
                                <td>&nbsp;</td>
                              </tr>
                              <tr> 
                                <td width="18%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                    <input type="submit" name="Submit3" value="Update" class="forminput">
                                    </font> 
                                    <input name="do" type="hidden" id="do" value="save_hdfields">
                                    </font> </div></td>
                              </tr>
                            </table>
                          </div>
                          <div align="right"> </div>
                        </form>
                        </font></p> <form method="post" action="admin.cgi">
                          <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr> 
                              <td width="19%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add 
                                  Field</strong></font></div></td>
                              <td width="40%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox" name="field">
                                  </font></div></td>
                              <td width="10%"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORDER</font></div></td>
                              <td width="11%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox" name="order" size="2">
                                  </font></div></td>
                              <td width="18%"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input name="do" type="hidden" id="do" value="adform">
                                  </font> </div></td>
                            </tr>
                          </table>
                          <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr> 
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td width="18%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input name="Submit" class="forminput" type="submit" id="  Save Fields  " value="  Save ">
                                  </font> </div></td>
                            </tr>
                          </table>
                        </form>
                        &nbsp;<br> </td>
                      <td width="2%" valign="top" bgcolor="#D1DAE7"><img src="{imgbase}/blue_topright.gif" width="13" height="11"></td>
                    </tr>
                    <tr bgcolor="#D1DAE7"> 
                      <td><p>&nbsp;</p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr bgcolor="#D1DAE7"> 
                      <td valign="bottom" bgcolor="#D1DAE7"><img src="{imgbase}/blue_bottomleft.gif" width="13" height="11"></td>
                      <td valign="bottom" bgcolor="#D1DAE7"><img src="{imgbase}/blue_bottomrigt.gif" width="13" height="11"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td width="5%">&nbsp;</td>
                <td width="23%">&nbsp;</td>
                <td width="72%">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="3"><hr></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Signup/Profile 
                  Questions</b></font></td>
              </tr>
              <tr> 
                <td height="38">&nbsp;</td>
                <td colspan="2" height="38"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">These 
                  fields will appear on the signup page and the users profile, 
                  you can remove them and/or add new fields.<br>
                  &nbsp; </font></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td colspan="2"> <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr bgcolor="#D1DAE7"> 
                      <td width="2%" valign="top" bgcolor="#D1DAE7"><img src="{imgbase}/blue_topleft.gif" width="13" height="11"></td>
                      <td width="96%" rowspan="3" bgcolor="#D1DAE7"> <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                        <form method="post" action="admin.cgi">
                          {sfields} 
                          <div align="center"> 
                            <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr> 
                                <td>&nbsp;</td>
                              </tr>
                              <tr> 
                                <td width="18%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                    <input type="submit" name="Submit3" value="Update" class="forminput">
                                    </font> 
                                    <input name="do" type="hidden" id="do" value="save_sfields">
                                    </font> </div></td>
                              </tr>
                            </table>
                          </div>
                          <div align="right"> </div>
                        </form>
                        </font> <p></p>
                        <form method="post" action="admin.cgi">
                          <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr> 
                              <td width="19%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add 
                                  Field</strong></font></div></td>
                              <td width="40%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox" name="field">
                                  </font></div></td>
                              <td width="10%"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORDER</font></div></td>
                              <td width="11%"> <div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox" name="order" size="2">
                                  </font></div></td>
                              <td width="18%"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input name="do" type="hidden" id="do" value="sadform">
                                  </font> </div></td>
                            </tr>
                          </table>
                          <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr> 
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td width="18%"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input name="Submit" class="forminput" type="submit" id="  Save Fields  " value="  Save ">
                                  </font> </div></td>
                            </tr>
                          </table>
                        </form>
                        &nbsp;<br> </td>
                      <td width="2%" valign="top" bgcolor="#D1DAE7"><img src="{imgbase}/blue_topright.gif" width="13" height="11"></td>
                    </tr>
                    <tr bgcolor="#D1DAE7"> 
                      <td><p>&nbsp;</p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr bgcolor="#D1DAE7"> 
                      <td valign="bottom" bgcolor="#D1DAE7"><img src="{imgbase}/blue_bottomleft.gif" width="13" height="11"></td>
                      <td valign="bottom" bgcolor="#D1DAE7"><img src="{imgbase}/blue_bottomrigt.gif" width="13" height="11"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td width="5%"> <input type="hidden" name="do2" value="websettings"> 
                </td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="3"> <div align="center"> </div></td>
              </tr>
              <tr> 
                <td colspan="3">&nbsp; </td>
              </tr>
            </table>
            
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td> </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
