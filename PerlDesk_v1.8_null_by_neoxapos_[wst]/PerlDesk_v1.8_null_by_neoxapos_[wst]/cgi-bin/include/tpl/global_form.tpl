<!-- {{ This file is for the global submission form, if enabled in the admin clients will be able to 
log a support request from this global form without logging in }} -->

<form action="{mainfile}" method=post>
  <table width="90%" border="0" cellspacing="0" align="center" cellpadding="2">
    <tr valign="middle"> 
      <td colspan="2" height="73"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><br>
        </font> 
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr bgcolor="#D1D1D1"> 
            <td height="19"> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#F5F5F5"> 
                  <td><font size="1" face="Geneva, Arial, Helvetica, san-serif">TICKET 
                    DETAILS </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="24%">&nbsp;</td>
      <td width="76%">&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td colspan="2" height="2">{form}</td>
    </tr>
    <tr valign="top"> 
      <td width="24%" height="2">&nbsp;</td>
      <td width="76%" height="2">&nbsp;</td>
    </tr>
    <tr> 
      <td rowspan="2" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%priority%</font></td>
      <td width="76%" height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <select name="priority"  class="tbox">
          <option value="1">1 - %urgent%</option>
          <option value="2">2</option>
          <option value="3" selected>3</option>
          <option value="4">4</option>
          <option value="5">5 - %inquiry%</option>
        </select>
        </font></td>
    </tr>
    <tr> 
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font> 
        <table width="90%" border="0" cellspacing="1" cellpadding="0">
          <tr bgcolor="#D1D1D1"> 
            <td height="19"> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#F5F5F5"> 
                  <td><font size="1" face="Geneva, Arial, Helvetica, san-serif">%logtext4%</font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></td>
    </tr>
    <tr> 
      <td width="24%" height="47"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%category%</font></td>
      <td width="76%" height="47"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <select name="category" class="tbox">
                {category}
              
        </select>
        </font></td>
    </tr>
    <tr valign="middle"> 
      <td colspan="2" height="56"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr bgcolor="#D1D1D1"> 
            <td height="19"> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2">
                <tr bgcolor="#F5F5F5"> 
                  <td><font size="1" face="Geneva, Arial, Helvetica, san-serif">REQUEST 
                    DETAILS </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%subject%</font></td>
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text"  class="tbox" name="subject" size="35">
        </font></td>
    </tr>
    <tr> 
      <td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%comments%</font></td>
      <td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="description" class="tbox" cols="55" rows="13"></textarea>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
          <input type="hidden" name="lang" value="{lang}">
          <input type="hidden" name="user" value="{uname}">
          <input type="hidden" name="username" value="{uname}">
          <input type="hidden" name="do" value="submit_req">
          <input type="submit" name="Submit" class="forminput" value="%submit%">
          </font></div>
      </td>
    </tr>
  </table>
  <br>
</form>
