<!-- {{ Email a copy of a support request to a given email address }} -->

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
          <table width="80%" border="0" cellpadding="3" align="center">
            <tr class="usertab"> 
              <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>EMAIL 
                REQUEST </b></font></td>
            </tr>
            <tr> 
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr> 
              <td width="29%" valign="top">
                <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">ADDRESS 
                  </font></div>
              </td>
              <td width="71%" valign="top"> 
                <input type="text" name="email" size="40" class="tbox" value="">
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
          <input type="hidden" name="do" value="emailreqsend">
          <input type="submit" name="Submit" value="Submit">
        </div>
      </td>
    </tr>
  </table>
  <br>
  <br>
</form>
<p>&nbsp;</p>
