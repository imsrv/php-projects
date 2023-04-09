<!-- {{ The final registration screen where the user is forwarded to the login page after creating an account }} -->


<form action="{mainfile}" method=post>
  <table width="94%" border="0" cellspacing="1" align="center">
    <tr> 
      <td colspan="2"> 
        <table width="92%" border="0" cellspacing="1" align="center">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>%registration% 
              %complete%!</b></font></td>
          </tr>
        </table>
        <table width="92%" border="0" cellspacing="1" align="center">
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%mainreg% 
              {email}</font></td>
          </tr>
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="32%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%username%</font></b></td>
            <td width="68%"> <b><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#666666">{user} 
              </font></b></td>
          </tr>
          <tr> 
            <td width="32%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%password%</font></b></td>
            <td width="68%"> <b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              {password} </font></b></td>
          </tr>
          <tr> 
            <td width="32%">&nbsp;</td>
            <td width="68%">&nbsp;</td>
          </tr>
        </table>
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <input type="hidden" name="username" value="{user}">
          <input type="hidden" name="password" value="{password}">
          <input type="hidden" name="lang" value="{lang}">
          <input type="hidden" name="action" value="login">
          <input type="submit" name="Login" class = "forminput" value="%login%">
          </font></div>
      </td>
    </tr>
  </table>
</form>