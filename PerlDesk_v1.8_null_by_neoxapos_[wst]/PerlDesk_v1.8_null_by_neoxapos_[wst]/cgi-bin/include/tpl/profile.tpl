<!-- {{ Profile.tpl is where the user can manage and update their contact information and login password }} -->

<form action="{mainfile}" method="post">
  <table width="482" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr><td> 
        {usernav}
    </td></tr>
    <tr><td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
    <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, {name}</font></a></font></div>
      </td></tr>
  </table>
  <div align="center">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#F5F5F5"> 
              <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_topleft.gif" width="13" height="11"></td>
              <td width="98%" rowspan="3" bgcolor="#D1DAE7">
<p><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%profile%: <strong>{name}</strong></font><strong><font size="1" face="Geneva, Arial, Helvetica, san-serif">&nbsp; 
                  </font></strong></p></td>
              <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_topright.gif" width="13" height="11"></td>
            </tr>
            <tr bgcolor="#F5F5F5"> 
              <td width="1%" bgcolor="#D1DAE7">&nbsp;</td>
              <td width="1%" bgcolor="#D1DAE7">&nbsp;</td>
            </tr>
            <tr bgcolor="#F5F5F5"> 
              <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_bottomleft.gif" width="13" height="11"></td>
              <td width="1%" bgcolor="#FFFFFF"><img src="{imgbase}/blue_bottomrigt.gif" width="13" height="11"></td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td width="30%">&nbsp;</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%name%</font></td>
        <td width="70%"> <input type="text"  style="font-size: 12px" name="name" value="{name}" size="30"></td>
      </tr>
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%email%</font></td>
        <td width="70%"> <input type="text"  style="font-size: 12px" name="email" value="{email}" size="30"></td>
      </tr>
      {fields} 
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%password%</font></td>
        <td width="70%"> <input type="password"  style="font-size: 12px" name="pass1"></td>
      </tr>
      <tr> 
        <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%password%</font></td>
        <td width="70%"> <input type="password"  style="font-size: 12px" name="pass2"></td>
      </tr>
      <tr> 
        <td width="30%" height="39">&nbsp;</td>
        <td width="70%"> <table width="90%" border="0" cellspacing="1" cellpadding="0">
            <tr bgcolor="#D1D1D1"> 
              <td height="19"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                  <tr bgcolor="#F5F5F5"> 
                    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">%profilepass%</font></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td width="30%">&nbsp;</td>
        <td width="70%">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="2"> <div align="center"> 
            <input name="lang" type="hidden" id="lang" value="{lang}">
            <input name="do" type="hidden" id="do" value="update_profile">
            <input type="submit" name="Submit2" class="forminput" value="%submit%">
          </div></td>
      </tr>
    </table>
  </div>
  <br>
  <br>
</form>
<p>&nbsp;</p>
