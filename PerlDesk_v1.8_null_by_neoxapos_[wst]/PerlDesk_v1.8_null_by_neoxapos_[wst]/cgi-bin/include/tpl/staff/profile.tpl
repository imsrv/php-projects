
<form action="staff.cgi" method="post">
    <table width="85%" border="0" align="center">
      <tr> 
        <td colspan="2"> 
      <tr> 
        <td colspan="4"> </td>
      </tr>
      <tr> 
        <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>{name}'s
              Configuration</b></font></td>
      </tr>
      <tr> 
        <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">You can update your personal configuration and preferences
          below, including your login password and pre-defined responses.</font></td>
      </tr>
      <tr valign="middle"> 
        <td colspan="2" height="42"> 
          <table width="100%" border="0" align="center">
            <tr> 
              <td colspan="2"> 
            <tr valign="middle"> 
              <td colspan="2" height="21">&nbsp;</td>
            </tr>
            <tr valign="middle"> 
              <td height="27" colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font color="#000066">&#8226; </font></b></font> <font color="#000066">Pre-Defined
              Responses</font></b></font></td>
            </tr>
            <tr valign="middle"> 
              <td height="37" colspan="2" bgcolor="#F0F0F0"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">If
                  you find yourself answering the same question over again, you
                  can
                set-up a simple pre-defined answer which you can then use when
                you respond to a call.</font></td>
            </tr>
            <tr> 
              <td width="30%" valign="middle" height="2" bgcolor="#F0F0F0"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Responses</font></td>
              <td width="70%" height="2" bgcolor="#F0F0F0"> 
                <select name="menu" class="gbox" onChange="MM_jumpMenu('parent',this,0)">
                  <option value="staff_profile.pl">--- Your Templates ---</option>
{preans}
                </select>
                <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> (<a href="staff.cgi?do=profile&goto=add_pre">ADD</a>) 
                </font></td>
            </tr>
            <tr> 
              <td colspan="2" valign="top" height="2">&nbsp;</td>
            </tr>
            <tr> 
              <td height="27" colspan="2" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font color="#000066">&#8226; </font></b></font> <font color="#000066">Personal
                      Profile</font></b></font></td>
            </tr>
            <tr> 
              <td width="30%" valign="top" height="2" bgcolor="#F0F0F0"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Name</font></td>
              <td width="70%" height="2" bgcolor="#F0F0F0"> 
                <input type="text" style="font-size: 12px" name="name" value="{name}" size="30">
              </td>
            </tr>
            <tr> 
              <td width="30%" valign="top" height="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">E-Mail 
                <br>
                </font></td>
              <td width="70%" valign="top" height="2"> 
                <input type="text" style="font-size: 12px" name="email" value="{email}" size="30">
              </td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F0F0F0"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sound Alert</font></td>
              <td valign="top" bgcolor="#F0F0F0"><input name="sound" type="checkbox" id="sound" value="yes" {snd}>
</td>
            </tr>
            <tr>
              <td height="32" valign="top">&nbsp;</td>
              <td valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">This will play a sound on the main page,  when
                refreshed if a new call is logged.</font></td>
            </tr>
            <tr> 
              <td width="30%" valign="top" bgcolor="#F0F0F0"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Notification</font></td>
              <td width="70%" valign="top" bgcolor="#F0F0F0"> 
                <input type="checkbox" name="notify" value="yes" {ncheck}>
                <br>
                <font size="1" face="Verdana, Arial, Helvetica, sans-serif">(Notify
              me of new submissions via email)</font>              </td>
            </tr>
            <tr> 
              <td colspan="2" valign="top">&nbsp;</td>
            </tr>
            <tr> 
              <td colspan="2" valign="top">&nbsp; </td>
            </tr>
            <tr>
              <td colspan="2" valign="top" bgcolor="#F0F0F0"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Please
                  leave the passwords blank if you would like to leave your current
              password unchanged.</font></td>
            </tr>
            <tr> 
              <td width="30%" valign="top" bgcolor="#F0F0F0"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
              <td width="70%" bgcolor="#F0F0F0"> 
                <input type="password" style="font-size: 12px" name="pass1">
              </td>
            </tr>
            <tr> 
              <td width="30%" valign="top" bgcolor="#F0F0F0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></td>
              <td width="70%" bgcolor="#F0F0F0"> 
                <input type="password" style="font-size: 12px" name="pass2">
              </td>
            </tr>
            <tr> 
              <td colspan="2" valign="top"> 
                <table width="100%" border="0" cellpadding="2" cellspacing="1">
                  <tr> 
                    <td width="29%">&nbsp;</td>
                    <td width="71%">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td height="27" colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font color="#000066">&#8226; Signature</font></b></font></td>
                  </tr>
                  <tr> 
                    <td rowspan="2" valign="top" bgcolor="#F0F0F0" height="22"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Your 
                      Signature:<br>
                      </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif">(Added 
                      to responses)</font></td>
                    <td rowspan="2" bgcolor="#F0F0F0" width="71%"> 
                      <div align="center"> 
                        
                      <textarea style="font-size: 12px" name="sig" cols="45" rows="5">{sig}</textarea>
                      </div>
                    </td>
                  </tr>
                  <tr> </tr>
                </table>
              </td>
            </tr>
            <tr> 
              <td colspan="2" valign="top">&nbsp; </td>
            </tr>
            <tr valign="middle"> 
              <td colspan="2" height="42"> 
                <div align="center"> 
                  <input type="hidden" name="hidden">
                  <input type="hidden" name="do" value="profile">
                  <input type="hidden" name="goto" value="updateprofile">
                  <input type="submit" name="Submit2" value="Submit">
                </div>
              </td>
            </tr>
            <tr> 
              <td colspan="2">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr valign="middle"> 
        <td colspan="2" height="42"> 
          <div align="center"></div>
        </td>
      </tr>
      <tr> 
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
