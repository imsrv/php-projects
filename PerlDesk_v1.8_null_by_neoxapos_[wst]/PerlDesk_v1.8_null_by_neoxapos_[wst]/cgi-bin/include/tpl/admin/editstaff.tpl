 
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


<form action="admin.cgi" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="4"> </td>
    </tr>
    <tr>
      <td colspan="4" height="33" valign="top"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr> 
            <td width="91%">              
              <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="admin.cgi?do=staff"><img src="{imgbase}/admin/list_staff.gif" width="104" height="19" border="0"></a> 
                <a href="admin.cgi?do=addstaff"><img src="{imgbase}/admin/add_staff.gif" width="104" height="19" border="0"> 
                </a><a href="#" onClick="Popup('admin.cgi?do=pm&to=inbox', 'Window', 425, 400)"><img src="{imgbase}/admin/staff_messaging.gif" width="104" height="19" border="0"></a> 
                <a href="admin.cgi?do=emailstaff"><img src="{imgbase}/admin/email_all.gif" width="104" height="19" border="0"></a></strong></font></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=main">Admin</a>: 
        <a href="admin.cgi?do=staff">Staff</a>: Edit Staff</b></font></td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"> 
              <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><a href="admin.cgi?do=delstaff&amp;user={user}"> [
                      Delete {sname} ]</a></b></font></div>
            </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top"> 
              <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                  <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Contact
                  Details</b></font></td>
                </tr>
              </table>
              <table width="85%" border="0" cellspacing="1" cellpadding="2" align="center">
                <tr> 
                  <td width="28%" valign="top">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="28%" valign="top"><font size="2" face="Geneva, Arial, Helvetica, san-serif">Name</font></td>
                  <td width="72%"> 
                    <input name="name" type="text" class="tbox" value="{sname}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="28%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Email<b><br>
                  </b></font></td>
                  <td width="72%" valign="top"> 
                    <input name="email" type="text" class="tbox" value="{semail}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="28%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Notification</font></td>
                  <td width="72%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    {notify} </font></td>
                </tr>
                <tr>
                  <td colspan="2" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                      <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Access
                            Password</b></font></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="27" valign="middle"><font size="2" face="Geneva, Arial, Helvetica, san-serif">Password</font></td>
                  <td>
                    <input name="pass1" type="password" class="tbox" id="pass1" size="15">
                  </td>
                </tr>
                <tr>
                  <td valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password<b><br>
                  </b></font></td>
                  <td valign="top">
                    <input name="pass2" type="password" class="tbox" id="pass2" size="15">
                  </td>
                </tr>
                <tr>
                  <td colspan="2" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td height="28" colspan="2" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                        <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Pre-Defined
                              Responses</b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Templates</font></td>
                  <td><select name="menu" class="gbox" onChange="MM_jumpMenu('parent',this,0)">
                    <option value="staff_profile.pl" selected>--- {sname}'s Templates
                    --- {preans}</option>
                  </select>
                    <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font></td>
                </tr>
                <tr>
                  <td valign="middle">&nbsp;</td>
                  <td> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <font size="1"> </font></font></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top">&nbsp;</td>
                </tr>
                <tr> 
                  <td height="28" colspan="2" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="4%"><img src="{imgbase}/dot.gif" width="13" height="11"></td>
                      <td width="96%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Departmental
                        Access</b></font></td>
                    </tr>
                  </table>
                  </td>
                </tr>
                <tr> 
                  <td width="28%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Department 
                    </font></td>
                  <td width="72%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">{category} 
                    </font></td>
                </tr>
                <tr> 
                  <td width="28%" valign="middle">&nbsp;</td>
                  <td width="72%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <font size="1"> </font></font></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#999999">(Select 
                    GLOBAL if you wish to grant this user full roaming access 
                    to the help desk)</font></td>
                </tr>
                <tr> 
                  <td width="28%">&nbsp;</td>
                  <td width="72%">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="42"> 
              <div align="center"> 
                <input type="submit" class="forminput" name="Submit" value="Submit">
                <input type="hidden" name="user" value="{user}">
                <input type="hidden" name="do" value="saveeditstaff">
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
