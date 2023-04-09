<!-- {{ Closereq.tpl  This template is used by a user when they want to close a 
support request directly from the client area }} -->
<form action="{mainfile}" method="post">
  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
    <tr> 
      <td colspan="4"> 
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
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, 
                  {name}</font></a></font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td colspan="4" height="102"> 
        <div align="right"> 
          <table width="100%" border="0" cellpadding="3">
            <tr class="usertab"> 
              <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>CLOSE 
                TICKET</b></font></td>
            </tr>
            <tr> 
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr> 
              <td width="29%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">REASON 
                </font></td>
              <td width="71%"> 
                <textarea name="reason" cols="60" rows="10" class="tbox"></textarea>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4"> 
        <div align="center">
          <input type="hidden" name="lang" value="{lang}">
          <input type="hidden" name="id" value="{trackno}">
          <input type="hidden" name="do" value="closesave">
          <input type="submit" name="Submit" class="forminput" value="Submit">
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
